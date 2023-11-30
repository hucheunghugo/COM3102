-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 伺服器版本:                        8.2.0 - MySQL Community Server - GPL
-- 伺服器作業系統:                      Win64
-- HeidiSQL 版本:                  12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 傾印 com3102 的資料庫結構
CREATE DATABASE IF NOT EXISTS `com3102` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `com3102`;

-- 傾印  資料表 com3102.friend_list 結構
CREATE TABLE IF NOT EXISTS `friend_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `friend_id` int DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在傾印表格  com3102.friend_list 的資料：~0 rows (近似值)
REPLACE INTO `friend_list` (`id`, `user_id`, `friend_id`) VALUES
	(1, 13, 14),
	(2, 14, 17),
	(3, 17, 14),
	(4, 14, 16),
	(5, 16, 14);

-- 傾印  資料表 com3102.grades 結構
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `grade` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在傾印表格  com3102.grades 的資料：~30 rows (近似值)
REPLACE INTO `grades` (`id`, `student_name`, `subject`, `grade`) VALUES
	(1, 'asd', 'sada', 'A'),
	(27, '21321', '213', '2'),
	(28, '21321', '213', '2'),
	(29, 'asd', 'sad', 'A'),
	(30, 'asd', 'sad', 'A'),
	(31, 'asd', 'sad', 'A'),
	(32, 'sad', 'sadsa', 'A'),
	(33, '', '', ''),
	(34, '', '', ''),
	(35, '', '', ''),
	(36, '', '', ''),
	(37, '', '', ''),
	(38, '', '', ''),
	(39, '', '', ''),
	(40, '', '', ''),
	(41, '', '', ''),
	(42, '', '', ''),
	(43, '', '', ''),
	(44, '', '', ''),
	(45, '', '', ''),
	(46, '', '', ''),
	(47, '', '', ''),
	(48, '', '', ''),
	(49, '', '', ''),
	(50, '', '', ''),
	(51, '', '', ''),
	(52, '', '', ''),
	(53, '', '', ''),
	(54, 'asd', 'sad', 'sad'),
	(55, 'asd', 'sad', 'A');

-- 傾印  資料表 com3102.photo 結構
CREATE TABLE IF NOT EXISTS `photo` (
  `photo_id` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(50) NOT NULL DEFAULT '0',
  `user_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在傾印表格  com3102.photo 的資料：~0 rows (近似值)
REPLACE INTO `photo` (`photo_id`, `file_name`, `user_id`) VALUES
	(7, '11.jpg', NULL),
	(8, '13.jpg', NULL);

-- 傾印  資料表 com3102.users 結構
CREATE TABLE IF NOT EXISTS `users` (
  `Userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `programme` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `year_of_entrance` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sid` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`Userid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 正在傾印表格  com3102.users 的資料：~3 rows (近似值)
REPLACE INTO `users` (`Userid`, `username`, `password`, `token`, `email`, `programme`, `year_of_entrance`, `sid`) VALUES
	(13, 'user', 'user', '4cad608d095ba077afb7d1d83c05ea12', 'abc@abc', '', '', ''),
	(14, 'Hugo', 'Hugo', '21560dd5cccc80fdf50e3e0c1cccd828', '2503hugo@gmail.com', 'aaa', '2003', 'as23'),
	(16, 'user1', 'uesr1', NULL, 'asd@sads', 'aaa', '2003', 'as23'),
	(17, 'user2', 'uesr2', NULL, 'sada2@asdasd', 'aaa', '2003', 'as23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
