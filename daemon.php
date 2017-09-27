#!/usr/bin/php -q
<?php

	include "config.php";
	include "parser.php";
	include_once "logging.php";

	set_time_limit(0);
	
	setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- daemon start, time = ' . date('c'));
	
	$parser = new parser;
	
	$count = 1;
	while ($count > 0) {
		// получить последние данные из базы
		$lastInfo = $parser->getLastValueTempFromDB();
		echo("Database last record data:\n");
		var_dump($lastInfo);
		var_dump(strtotime($lastInfo[1]));
		echo("\n");
		// получить данные с сервера
		$serverInfo = $parser->getCurrentTempAndTime();
		echo("Server current data:\n");
		var_dump($serverInfo);
		var_dump(strtotime($serverInfo[1]));
		echo("\n");
		// сравнить время
		$lastDate = strtotime($lastInfo[1]);
		$serverDate = strtotime($serverInfo[1]);
		echo('Digital time view: timeDb = ' . $lastDate . ', timeSrv = ' . $serverDate . "\n");
		setLogMsg(3, __FILE__ . ' : ' . __LINE__ . ' -- timeDB = ' . $lastDate . ', timeSrv = ' . $serverDate);
		if (!$lastDate) $lastDate = 0;
		if ($lastDate < $serverDate) {
			// если время изменилось, то внести полученные данные в базу
			$parser->insertValueToDB($serverInfo[0], $serverInfo[1]);
			echo("New record has been inserted in database \n");
		}	
		// ждать
		echo "Waiting... 10min \n";
		echo "------------------------------------------------------------------------------------------------\n";
		sleep(600);
		$count++;
	}
	
	setLogMsg(0, __FILE__ . ' : ' . __LINE__ . ' -- daemon finish, time = ' . date('c'));

?>