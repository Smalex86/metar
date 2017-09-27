<?php

	// константа с запросом на получение информации о погоде для аэропорта емельяново
	define("METAR_ADDR", "http://aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString=UNKL&hoursBeforeNow=5&mostRecent=true");
	
	// константы для подключения к бд
	define("DB_HOST", 'localhost');
	define("DB_USERNAME", 'metar');
	define("DB_PASSWD", '1234567');
	define("DB_NAME", 'metar');
	
	if (!defined("DIRECTORY_SEPARATOR ")) define("DIRECTORY_SEPARATOR ", "/");
	date_default_timezone_set('Asia/Novosibirsk');

?>