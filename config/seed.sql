-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for booking_house
CREATE DATABASE IF NOT EXISTS `booking_house` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `booking_house`;

-- Dumping structure for table booking_house.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.admin: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `email`, `password`, `name`) VALUES
	(1, 'admin@mail.com', '$2y$10$DBx1sWe3Zj7juZ7yoNIx3.oxJZnaodu5aQyoVoCVhySiMdRpkUlCm', 'ADMIN ACCOUNT'),
	(2, 'qikiqah@mailinator.com', '$2y$10$bZMPCGSfBuWScZ9X/6ZBn.UZ1Apc67CUmWHvW2ZOol20zypXgkjmO', 'Fuller Trujillo');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table booking_house.agents
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` smallint(6) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `total_point` int(11) DEFAULT '0',
  `point` int(11) DEFAULT '0',
  `rank` varchar(255) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.agents: ~3 rows (approximately)
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` (`id`, `is_active`, `email`, `password`, `name`, `phone_number`, `total_point`, `point`, `rank`, `deleted_at`) VALUES
	(1, 1, 'agent@mail.com', '$2y$10$DBx1sWe3Zj7juZ7yoNIx3.oxJZnaodu5aQyoVoCVhySiMdRpkUlCm', 'AGENT ACCOUNT', '0123456789', 0, 0, 'junior', NULL),
	(2, 1, 'syafiq@mailinator.com', '$2y$10$8fv2qdP543kXf/8Xdu9tbOlaFUZLf5Jz2Ei.ZKg/PjevaNRdaKivm', 'SYAFIQ', '34545', 0, 0, 'senior', NULL),
	(3, 1, 'bugagykytu@mailinator.com', '$2y$10$nseP4vXnqoAU9yE1LGfKkuuN4rRbjFiwYN9b1MaHreqwhSeoOSuJm', 'Charity Rocha', '+1 (605) 292-4092', 0, 0, 'senior', NULL);
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;

-- Dumping structure for table booking_house.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `code` varchar(50) DEFAULT NULL,
  `point_gain` int(11) NOT NULL DEFAULT '0',
  `remark` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.bookings: ~1 rows (approximately)
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` (`id`, `house_id`, `agent_id`, `customer_id`, `status`, `code`, `point_gain`, `remark`, `created_at`) VALUES
	(1, 1, 1, 2, 0, '24022', 0, ' hannan test', '2021-05-06 15:03:05');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;

-- Dumping structure for table booking_house.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.customers: ~1 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `email`, `password`, `name`, `phone_number`, `approved_at`) VALUES
	(2, 'customer@mail.com', '$2y$10$nyVTyAM6Q.E1IcQeqCReE.96jZEPPaQFtyNdksberNm6kJKKdRkVu', 'ABDUL HANNAN BIN YUSOP', '0123455461', '2021-04-25 16:24:15');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping structure for table booking_house.houses
CREATE TABLE IF NOT EXISTS `houses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `current_booking_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `point` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.houses: ~0 rows (approximately)
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;

-- Dumping structure for table booking_house.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `content` varchar(255) NOT NULL DEFAULT '',
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.notifications: ~0 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table booking_house.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `location_coordinate` varchar(50) NOT NULL,
  `location_name` varchar(255) NOT NULL DEFAULT '',
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.projects: ~1 rows (approximately)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `name`, `location_coordinate`, `location_name`, `start`, `end`, `status`) VALUES
	(1, 'RUmah mesra rakyat', '1.232,0.234', 'Location Name example', '2021-05-04', '2021-10-23', 1);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Dumping structure for table booking_house.project_brochures
CREATE TABLE IF NOT EXISTS `project_brochures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `file_location` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.project_brochures: ~0 rows (approximately)
/*!40000 ALTER TABLE `project_brochures` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_brochures` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
