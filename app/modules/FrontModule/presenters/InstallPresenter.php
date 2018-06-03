<?php

namespace App\FrontModule\Presenters;



use Nette\Application\UI\Form;
use Nette;
use Nette\Database\Connection;
use PDOException;


class InstallPresenter  extends BasePresenter
{

	public  $db;

	public function __construct()
	{

	}

    public function renderDefault(){

    }

    public function createComponentDatabaseForm(){
		$form = new Form();
		$form->addPassword('password');
		$form->addText('username');
		$form->addText('dbname');
		$form->addText('host');

		$form->addSubmit('submit');

	    $form->onSuccess[] = [$this, 'databaseFormSucceeded'];

		return $form;
    }

    public function createComponentNewAccountForm(){
		$form = new Form();
		$form->addPassword('password');
		$form->addText('email');

		$form->addSubmit('submit');

	    $form->onSuccess[] = [$this, 'newAccountFormSucceeded'];

		return $form;
    }

    public function databaseFormSucceeded($form){
		$data = $form->getHttpData();
		$password = true;
		unset($data['_submit'], $data['_do']);

		if($data['password'] == "") {
			$password = false;
		}
		if ($data['username'] == ""){
			$form['username']->addError('fill the username');
		}
		elseif ($data['host'] == ""){
			$form['host']->addError('fill the host');
		}
		elseif ($data['dbname'] == ""){
			$form['dbname']->addError('fill the dbname');
		}

	    $host = $data['host'];
	    $username = $data['username'];
	    $password = $password == true ? $data['password'] : "";
	    $dbname = $data['dbname'];

	    try {
		    $this->db = new Connection("mysql:host=$host;dbname=$dbname", $username, $password);

	    }
	    catch(PDOException $e)
	    {
		    $form->addError('Database connection failed.');
	    }



		if(!$form->hasErrors()){
			$this->write_ini_file('./config.ini', $data);

			$this->createDatabase();

			$this->redirect('Install:account');
		}

    }

    public function newAccountFormSucceeded($form){
		$data = $form->getHttpData();
		unset($data['_submit'], $data['_do']);

		if($data['password'] == "") {
			$form['password']->addError('password is required');
		}
		if ($data['email'] == ""){
			$form['email']->addError('fill in the email');
		}


	    $email = $data['email'];
	    $password = $data['password'];



	    $ini_array = parse_ini_file("./config.ini");

	    if(isset($ini_array['username'])){
		    $dbUsername = $ini_array['username'];
		    $dbPassword = $ini_array['password'];
		    $dbDbname = $ini_array['dbname'];
		    $dbHost = $ini_array['host'];
	    }
	    else {
		    $form->addError('set up the database first');
		    $this->redirect('Install:');
	    }


		if(!$form->hasErrors()){
			$connection = new Connection("mysql:host=$dbHost;dbname=$dbDbname", $dbUsername, $dbPassword);

			$check = $connection->query('SELECT * FROM users WHERE email = ? LIMIT 1', $email)->fetchAll();

			if(count($check) > 0){
				$form->addError('This email already exists');
				die();
			}


			$connection->query('INSERT INTO users (email, password) values (?, ?)', $email, password_hash($password, PASSWORD_DEFAULT));
			$newUser = $connection->query('SELECT * FROM users WHERE email = ? LIMIT 1', $email)->fetchAll();


			$userId = $newUser[0]->id;
			$connection->query('INSERT INTO `userrights`(`userId`, `rightId`) VALUES (?,1) ', $userId);


			$this->redirect('Homepage:');
		}

    }


    public function createDatabase() {
	    define('ROOTPATH', dirname(__FILE__));
	    $file = './sql.sql';
	    if($fp = file_get_contents($file)) {
		    $var_array = explode(';',$fp);
		    bdump($var_array);
		    foreach($var_array as $value) {
		    	bdump($value);
		    	try {
				    $this->db->query($value.';');
			    }
			    catch(Nette\Database\DriverException $e){
			    }
		    }
	    }
    }


	public function write_ini_file($file, $array = []) {
		// check first argument is string
		if (!is_string($file)) {
			throw new \InvalidArgumentException('Function argument 1 must be a string.');
		}

		// check second argument is array
		if (!is_array($array)) {
			throw new \InvalidArgumentException('Function argument 2 must be an array.');
		}

		// process array
		$data = array();
		foreach ($array as $key => $val) {
			if (is_array($val)) {
				$data[] = "[$key]";
				foreach ($val as $skey => $sval) {
					if (is_array($sval)) {
						foreach ($sval as $_skey => $_sval) {
							if (is_numeric($_skey)) {
								$data[] = $skey.'[] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
							} else {
								$data[] = $skey.'['.$_skey.'] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
							}
						}
					} else {
						$data[] = $skey.' = '.(is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"'.$sval.'"'));
					}
				}
			} else {
				$data[] = $key.' = '.(is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"'.$val.'"'));
			}
			// empty line
			$data[] = null;
		}

		// open file pointer, init flock options
		$fp = fopen($file, 'w');
		$retries = 0;
		$max_retries = 100;

		if (!$fp) {
			return false;
		}

		// loop until get lock, or reach max retries
		do {
			if ($retries > 0) {
				usleep(rand(1, 5000));
			}
			$retries += 1;
		} while (!flock($fp, LOCK_EX) && $retries <= $max_retries);

		// couldn't get the lock
		if ($retries == $max_retries) {
			return false;
		}

		// got lock, write data
		fwrite($fp, implode(PHP_EOL, $data).PHP_EOL);

		// release lock
		flock($fp, LOCK_UN);
		fclose($fp);

		return true;
	}


}
