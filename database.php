<?php

class database {
	// параметры подключения 
	private $errno = 0; // код ошибки
	private $errstr = ''; // текст ошибки
	
	static private $count = 0;
	private $mysqli = null; // ссылка на объект класса mysqli	
		
	function __construct() {
		global $cfg;
		$this->mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWD, DB_NAME);
		if (!$this->mysqli->set_charset('utf8')) 
			printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);		
		if (mysqli_connect_error()) {
			$this->errno = mysqli_connect_errno();
			$this->errstr = mysqli_connect_error();
		}
		self::$count++;
	}
	
	function __destruct() {
		self::$count--;	
	}
	
	function getMysqli() {
		if ($this->mysqli) return $this->mysqli;
		return false;
	}
	
	function getCount() {
		return self::$count;
	}
	
	// заглушка для функции fetch_all
	function fetch_all($result) {
		$data = null;
		while($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
	
}

?>