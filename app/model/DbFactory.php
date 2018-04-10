<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 8.4.2018
 * Time: 23:49
 */

namespace App\Model;


class DbFactory {

	public $username;
	public $password;
	public $dbname;
	public $host;



	public function __construct() {
		$ini_array = parse_ini_file("../www/config.ini");

		if(isset($ini_array['username'])){
			$this->username = $ini_array['username'];
			$this->password = $ini_array['password'];
			$this->dbname = $ini_array['dbname'];
			$this->host = $ini_array['host'];
		}
		else {
			$this->username = '';
			$this->password = '';
			$this->dbname = '';
			$this->host = '';
		}
	}




}