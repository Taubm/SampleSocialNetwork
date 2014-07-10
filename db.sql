-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 09 2014 г., 06:09
-- Версия сервера: 5.6.12-log
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `snetwork`
--
CREATE DATABASE IF NOT EXISTS `snetwork` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `snetwork`;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`author_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author_id`, `text`, `date`) VALUES
(51, 41, 9, 'Комментарий 1', '2014-07-09 05:56:51'),
(52, 41, 9, 'Комментарий 2\nТест', '2014-07-09 05:57:00'),
(53, 41, 9, 'Комментарий 3', '2014-07-09 05:57:07'),
(59, 42, 10, 'Тестовый комментарий', '2014-07-09 06:07:51'),
(60, 41, 10, 'Проверка', '2014-07-09 06:08:04');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `text` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `text`, `date`) VALUES
(21, 9, 'Запись 1', '2014-07-09 05:40:11'),
(22, 9, 'Запись 2', '2014-07-09 05:40:16'),
(23, 9, 'Запись 3', '2014-07-09 05:40:20'),
(24, 9, 'Запись 4', '2014-07-09 05:40:23'),
(25, 9, 'Запись 5', '2014-07-09 05:40:29'),
(26, 9, 'Запись 6', '2014-07-09 05:40:33'),
(27, 9, 'Запись 7', '2014-07-09 05:40:36'),
(28, 9, 'Запись 8', '2014-07-09 05:40:39'),
(29, 9, 'Запись 9', '2014-07-09 05:40:42'),
(30, 9, 'Запись 10', '2014-07-09 05:40:44'),
(31, 9, 'Запись 11', '2014-07-09 05:40:46'),
(32, 9, 'Запись 12', '2014-07-09 05:40:49'),
(33, 9, 'Запись 13', '2014-07-09 05:40:55'),
(34, 9, 'Запись 14', '2014-07-09 05:40:57'),
(35, 9, 'Запись 15', '2014-07-09 05:40:59'),
(36, 9, 'Запись 16', '2014-07-09 05:41:02'),
(37, 9, 'Запись 17', '2014-07-09 05:41:05'),
(38, 9, 'Запись 18', '2014-07-09 05:41:07'),
(39, 9, 'Запись 19', '2014-07-09 05:41:09'),
(40, 9, 'Запись 20', '2014-07-09 05:41:13'),
(41, 9, 'Запись 21', '2014-07-09 05:56:17'),
(42, 10, 'Тестовая запись', '2014-07-09 06:07:42');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `sex` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `secondname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `sex`, `firstname`, `secondname`, `lastname`) VALUES
(9, 'ivan@mail.ru', '474546cdcd3f71226877581787d977a0', 'm', 'Иван', 'Иванович', 'Иванов'),
(10, 'anna@mail.ru', '098f6bcd4621d373cade4e832627b4f6', 'f', 'Анна-Мария', 'Ивановна', 'Иванова');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
