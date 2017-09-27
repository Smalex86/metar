<?php	

include_once 'config.php';
include_once 'logging.php';	
include_once 'database.php';
	
class parser {
		
	// конструктор класса
	function __construct(){
		# подключение базы данных
		$database = new database(); 
		$this->db = $database->getMysqli();
		$this->databaseObj = $database;
		if (!$this->db) die('Не удалось обратиться к объекту базы данных');
	}
	
	// деструктор
	function __destruct() {
		//if ($this->db) $this->db->__destruct();
	}	
	
	// получить текущее значение температуры и времени формирования данных
	function getCurrentTempAndTime() {
		// получаем содержимое с сайта
		$metarData = file_get_contents(METAR_ADDR);
		// создаем объект на основе xml
		$metarObj = new SimpleXMLElement($metarData);
		//print_r($metarObj);
		// получаем значение температуры
		$temperature = (float) $metarObj->data->METAR->temp_c;
		$time = (string) $metarObj->data->METAR->observation_time;
		$metarObj->destroy;
		return array($temperature, $time);
	}
	
	// получить последнее значение температуры
	function getLastValueTempFromDB($reverse = false) {
		$query = sprintf("SELECT date, temp FROM data ORDER BY date %s LIMIT 1", ($reverse) ? 'ASC' : 'DESC');
		setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- query = ' . $query);
		if ($result = $this->db->query($query)) {
			$row = $result->fetch_assoc();
			$date = $row['date'];
			$temp = $row['temp'];
			$result->close(); 
			return array($temp, $date);
		}	else	
			setLogMsg(1, __FILE__ . ' : ' . __LINE__ . ' -- error = ' . $this->db->error);
		return false;
	}
	
	// добавить значение температуры в базу
	function insertValueToDB($temp, $date) {
		$date = strtotime($date);
		$date = date('c', $date);
		$query = sprintf('insert into data (date, temp) values ("%s", %f)', $date, $temp);
		setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- query = ' . $query);
		if ($this->db->query($query)) {
			$affectedRows = $this->db->affected_rows;
			setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- affectedRows = ' . $affectedRows);
			return $affectedRows;
		} else
			setLogMsg(1, __FILE__ . ' : ' . __LINE__ . ' -- error = ' . $this->db->error);
		return false;	
	}
	
	// выбрать значения температур из базы по диапазону дат
	function getTempValues($minDate, $maxDate) {
		$query = sprintf('SELECT date, temp FROM data 
			WHERE date >= "%s" and date <= "%s" ORDER BY date ASC', $minDate, $maxDate);
		setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- query = ' . $query);
		if ($result = $this->db->query($query)) {
			$values = $this->databaseObj->fetch_all($result);
			$result->close(); 
			return $values;
		} else	
			setLogMsg(1, __FILE__ . ' : ' . __LINE__ . ' -- error = ' . $this->db->error);
		return false;
	}
	
	// метод для получения значений макс, мин и средней температуры
	function getTempMaxMinAvg($minDate, $maxDate, $func) {
		$query = sprintf('SELECT %s(temp) as value FROM data 
			WHERE date >= "%s" and date <= "%s"', $func, $minDate, $maxDate);
		setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- query = ' . $query);
		if ($result = $this->db->query($query)) {
			$row = $result->fetch_assoc();
			$result->close(); 
			return $row['value'];
		} else	
			setLogMsg(1, __FILE__ . ' : ' . __LINE__ . ' -- error = ' . $this->db->error);
		return false;
	}
	
	
}
	
?>