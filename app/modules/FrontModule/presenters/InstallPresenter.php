<?php

namespace App\FrontModule\Presenters;



use Nette\Application\UI\Form;
use Nette;
use PDOException;

class InstallPresenter  extends BasePresenter
{


	public function __construct()
	{

	}

    public function renderDefault(){

    }

    public function createComponentDatabaseForm(){
		$form = new Form();
		$form->addText('password');
		$form->addText('username');
		$form->addText('dbname');
		$form->addText('host');

		$form->addSubmit('submit');

	    $form->onSuccess[] = [$this, 'databaseFormSucceeded'];

		return $form;
    }

    public function databaseFormSucceeded($form){
		$data = $form->getHttpData();
		unset($data['_submit'], $data['_do']);

		if($data['password'] == "") {
			$form['password']->addError('fill the password');
		}
		elseif ($data['username'] == ""){
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
	    $password = $data['password'];
	    $dbname = $data['dbname'];


	    try {
		    new Nette\Database\Connection("mysql:host=$host;dbname=$dbname", $username, $password);
	    }
	    catch(PDOException $e)
	    {
		    $form->addError('Database connection failed.');
	    }



		if(!$form->hasErrors()){
			$this->write_ini_file('./config.ini', $data);
			$this->redirect('Homepage:');
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


//	public function write_php_ini($array, $file)
//	{
//		unset($array['_do'],$array['_submit']);
//		bdump($array);
//		$res = array();
//		foreach($array as $key => $val)
//		{
//			if(is_array($val))
//			{
//				$res[] = "[$key]";
//				foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
//			}
//			else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
//		}
//		$this->safefilerewrite($file, implode("\r\n", $res));
//	}
//
//	public function safefilerewrite($fileName, $dataToSave)
//	{    if ($fp = fopen($fileName, 'w'))
//			{
//				$startTime = microtime(TRUE);
//				do
//				{
//					$canWrite = flock($fp, LOCK_EX);
//					// If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
//					if(!$canWrite) usleep(round(rand(0, 100)*1000));
//				} while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));
//
//				//file was locked so now we can store information
//				if ($canWrite) {
//
//					bdump($dataToSave);
//					fwrite($fp, $dataToSave);
//					flock($fp, LOCK_UN);
//				}
//				fclose($fp);
//			}
//
//	}

}
