-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.5.9-MariaDB-1:10.5.9+maria~focal - mariadb.org binary distribution
-- Операционная система:         debian-linux-gnu
-- HeidiSQL Версия:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных mvc2
CREATE DATABASE IF NOT EXISTS `mvc2` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `mvc2`;

-- Дамп структуры для таблица mvc2.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы mvc2.blog: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` (`id`, `message`, `date`, `user_id`, `img`) VALUES
	(3, 'Выпуск Wine 6.8\r\nСостоялся экспериментальный выпуск открытой реализации WinAPI - Wine 6.8. С момента выпуска версии 6.7 было закрыто 35 отчётов об ошибках и внесено 359 изменений.', '2021-05-09 01:30:15', 5, ''),
	(4, 'Релиз дистрибутива Nitrux 1.4.0 с рабочим столом NX Desktop\r\nОпубликован выпуск дистрибутива Nitrux 1.4.0, построенного на пакетной базе Debian, технологиях KDE и системе инициализации ', '2021-05-09 01:31:22', 5, ''),
	(5, 'Релиз фреймворка Qt 6.1\r\nКомпания Qt Company опубликовала релиз фреймворка Qt 6.1, в которой продолжена работа по стабилизации и наращиванию функциональности ветки Qt 6. В Qt 6.1 обеспечена ', '2021-05-09 01:31:35', 5, ''),
	(6, 'Релиз Mesa 21.1, свободной реализации OpenGL и Vulkan\r\nПредставлен релиз свободной реализации API OpenGL и Vulkan - Mesa 21.1.0. Первый выпуск ветки Mesa 21.1.0 имеет экспериментальный статус - после проведения окончательной ', '2021-05-09 01:31:56', 5, ''),
	(7, 'Не хочу так:', '2021-05-09 16:08:27', 1, '1_6ab49c14531cc27f8d5d484ebf90f931.jpg'),
	(8, '+', '2021-05-09 16:11:14', 1, '1_23b9b1fbc9e5e87f8e0a26b6a01cfe29.jpg'),
	(9, ')', '2021-05-09 16:11:28', 1, '1_96ae9e0cb1ef6c7d5cc2812682fa9f4f.jpg'),
	(10, '_', '2021-05-09 16:11:44', 1, '1_e5b007739772f75bd6d4f0fc1791566c.jpg'),
	(11, 'про питончик', '2021-05-09 16:12:02', 1, '1_f96224f4d0f51975483b67655c368b05.jpg');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;

-- Дамп структуры для таблица mvc2.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(40) NOT NULL,
  `date_registration` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы mvc2.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `date_registration`) VALUES
	(1, 'Vladislav', 'vlad@email.ru', '886536b4e64542c249159657961f9873fd7df3f8', '2021-05-07 20:01:03'),
	(5, 'Вовчик', 'user12@gmail.com', '6e73349f6c3d9f7078b27596939bcaa9d2ab07ce', '2021-05-07 21:02:54'),
	(7, 'Игорь', 'vp@gmail.com', '886536b4e64542c249159657961f9873fd7df3f8', '2021-05-08 21:44:20');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
