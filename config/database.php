<?php
// namespace

class Database {

	private $hostname;
	private $dbname;
	private $username;
	private $password;

	private $connect;

	public function connects() {
		$this->hostname = 'localhost';
		$this->dbname 	= 'php_rest_api';
		$this->username = 'root';
		$this->password = '';

		$this->connect = new mysqli( $this->hostname, $this->username, $this->password, $this->dbname );
		if ( $this->connect->connect_errno ) {
			print_r( $this->connect->connect_error );
			exit;
		} else {
			return $this->connect;
			//print_r($this->connect;);
		}
	}
}
// $db = new Database();

// $db->connects();