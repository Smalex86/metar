-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 28 2017 г., 15:36
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `metar`
--

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT NULL,
  `temp` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `data`
--

INSERT INTO `data` (`id`, `date`, `temp`) VALUES
(20, '2017-07-27 10:30:00', '25.00'),
(21, '2017-07-27 11:00:00', '26.00'),
(22, '2017-07-27 11:30:00', '26.00'),
(23, '2017-07-27 12:00:00', '26.00'),
(24, '2017-07-27 12:30:00', '25.00'),
(25, '2017-07-27 13:00:00', '24.00'),
(26, '2017-07-27 13:30:00', '22.00'),
(27, '2017-07-27 14:00:00', '20.00'),
(28, '2017-07-27 14:30:00', '19.00'),
(29, '2017-07-27 15:00:00', '19.00'),
(30, '2017-07-27 15:30:00', '18.00'),
(31, '2017-07-27 16:00:00', '18.00'),
(32, '2017-07-28 12:30:00', '27.00'),
(33, '2017-07-28 13:00:00', '26.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
