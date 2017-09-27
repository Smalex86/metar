<?php
	
	include 'config.php';
	include 'parser.php';
	
	$parser = new parser;
	
	$sitename = 'Погода в аэропорту Емельяново';
	
	// блок с текущей температурой
	$curValues = $parser->getCurrentTempAndTime();
	$currentTempBlock = '<div class="jumbotron">';
	$currentTempBlock .= sprintf("<h1>%.1f  \xC2\xB0C</h1>", $curValues[0]);
	$currentTempBlock .= '<p>Температура воздуха в аэропорту Емельяново</p>';
	$currentTempBlock .= sprintf('<p><small>по состоянию на %s местного времени</small></p>', date('H:i', strtotime($curValues[1])));
	$currentTempBlock .= '</div>';
	
	// получение суточных данных
	$dateEnd = time();
	$dateStart = $dateEnd - 24*60*60;
	$tempValues = $parser->getTempValues(date('c', $dateStart), date('c', $dateEnd));
	foreach ($tempValues as $value) {
		$tempValuesArray[] = $value['temp'];
		$timeValuesArray[] = sprintf('"%s"', $value['date']);
	}
	$tempValuesArray = implode(',', $tempValuesArray);
	$timeValuesArray = implode(',', $timeValuesArray);

	// блок с суточным изменением температуры
	$chartDay = '<center><h1>Дневной график изменения температуры</h1></center>';
	$chartDay .= '<div id="chart"></div>';
	$chartDay .= '<link type="text/css" rel="StyleSheet" href="chart/chart.css" />';
	$chartDay .= '<script src="chart/chart.js"></script>';
	$chartDay .= '
		<script>
			$(function () {
				var dailyTime = [' . $timeValuesArray . '];
				var dailyTemp = [' . $tempValuesArray . '];
				$("#chart").shieldChart({
					theme: "light",
					exportOptions: {
						image: false,
						print: false
					},
					primaryHeader: {
						text: ""
					},
					seriesSettings: {
						line: {
							enablePointSelection: true,
							pointMark: {
								activeSettings: {
									pointSelectedState: {
										drawWidth: 4,
										drawRadius: 4
									}
								}
							}
						}
					},
					axisY: {
						title: {
							text: "Температура (градусы цельсия)"
						}
					},
					axisX: {
						categoricalValues: dailyTime
					},
					dataSeries: [{
						seriesType: "line",
						collectionAlias: "Дневная температура",
						data: dailyTemp
					}]
				});
			});
		</script>';
	
	
	// блок с возможностью изменения интервалов
	// анализируем переменные из массива пост
	if (isset($_POST['dateEnd'])) 
		$dateEnd = $_POST['dateEnd'];
	else
		$dateEnd = date('Y-m-d H:i:s', $dateEnd);
	if (isset($_POST['dateStart'])) 
		$dateStart = $_POST['dateStart'];
	else {
		$dateStart_ = $parser->getLastValueTempFromDB(true);
		$dateStart = $dateStart_[1];
	}
	$resizeBlockH1 = '<center><h1>График изменения температуры с выбором интервала</h1></center>';
	$resizeBlock = '<form method="post" role="form" action="">'; // форма
	// дата старта
	$resizeBlock .= '<div class="form-group">';
		$resizeBlock .= '<label>Начало интервала</label>';
		$resizeBlock .= sprintf('<input type="text" class="form-control" id="dateStart" name="dateStart" placeholder="Дата начала" value="%s">', $dateStart);
	$resizeBlock .= '</div>';
	// дата финиша
	$resizeBlock .= '<div class="form-group">';
		$resizeBlock .= '<label>Конец интервала</label>';
		$resizeBlock .= sprintf('<input type="text" class="form-control" id="dateEnd" name="dateEnd" placeholder="Дата конца" value="%s">', $dateEnd);
	$resizeBlock .= '</div>';
	// кнопка
	$resizeBlock .= '<div class="form-group">';
		$resizeBlock .= '<button class="btn btn-primary" id="buttonUpdate" type="submit">';
		$resizeBlock .= 'Перестроить график';
		$resizeBlock .= '</button> ';
	$resizeBlock .= '</div>';
	$resizeBlock .= '</form>';
	
	// значения макс, мин и средней температуры на указанном диапазоне
	$resizeBlock .= sprintf('<p>Максимум = %.1f</p>', $parser->getTempMaxMinAvg($dateStart, $dateEnd, 'MAX'));
	$resizeBlock .= sprintf('<p>Минимум = %.1f</p>', $parser->getTempMaxMinAvg($dateStart, $dateEnd, 'MIN'));
	$resizeBlock .= sprintf('<p>Среднее = %.1f</p>', $parser->getTempMaxMinAvg($dateStart, $dateEnd, 'AVG'));
	
	// скрипт для работы этого блока
	$resizeBlock .= '<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >';
	$resizeBlock .= '<script src="datetimepicker/jquery.datetimepicker.js"></script>';
	$resizeBlock .= "<script type='text/javascript'>
							jQuery('#dateStart').datetimepicker({
								format:'Y-m-d H:i:s',
								lang:'ru'
							});
							jQuery('#dateEnd').datetimepicker({
								format:'Y-m-d H:i:s',
								lang:'ru'
							});
						</script>";
	
	// формирование данных для графика с произвольным диапазоном
	$tempValues = $parser->getTempValues($dateStart, $dateEnd);
	$tempValuesArray = array();
	$timeValuesArray = array();
	foreach ($tempValues as $value) {
		$tempValuesArray[] = $value['temp'];
		$timeValuesArray[] = sprintf('"%s"', $value['date']);
	}
	$tempValuesArray = implode(',', $tempValuesArray);
	$timeValuesArray = implode(',', $timeValuesArray);
	
	// блок с регулируемым диапазоном изменения температуры
	$resizeBlock2 = '<div id="chart2"></div>';
	$resizeBlock2 .= '<link type="text/css" rel="StyleSheet" href="chart/chart.css" />';
	$resizeBlock2 .= '<script src="chart/chart.js"></script>';
	$resizeBlock2 .= '
		<script>
			$(function () {
				var dailyTime = [' . $timeValuesArray . '];
				var dailyTemp = [' . $tempValuesArray . '];
				$("#chart2").shieldChart({
					theme: "light",
					exportOptions: {
						image: false,
						print: false
					},
					primaryHeader: {
						text: ""
					},
					seriesSettings: {
						line: {
							enablePointSelection: true,
							pointMark: {
								activeSettings: {
									pointSelectedState: {
										drawWidth: 4,
										drawRadius: 4
									}
								}
							}
						}
					},
					axisY: {
						title: {
							text: "Температура (градусы цельсия)"
						}
					},
					axisX: {
						categoricalValues: dailyTime
					},
					dataSeries: [{
						seriesType: "line",
						collectionAlias: "Температура",
						data: dailyTemp
					}]
				});
			});
		</script>';
	
	// переменная, идет в футер шаблона
	$dataFromSite = 'сформировано на основе данных с сайта <a href="http://aviationweather.gov">aviationweather.gov</a>';
	
	// вызов шаблона
	include_once("templates/templatemain.php");

?>