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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.admin: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `email`, `password`, `name`) VALUES
	(1, 'admin@mail.com', '$2y$10$DBx1sWe3Zj7juZ7yoNIx3.oxJZnaodu5aQyoVoCVhySiMdRpkUlCm', 'ADMIN ACCOUNT'),
	(3, 'asda@mail.com', '$2y$10$pN5LPM7u56R4Ly8ha99.buyw5vbw4bFrIgjhwtALkudk57wqnBlV.', 'test');
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
  `rank` int(11) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.agents: ~3 rows (approximately)
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` (`id`, `is_active`, `email`, `password`, `name`, `phone_number`, `total_point`, `point`, `rank`, `deleted_at`) VALUES
	(1, 1, 'agent@mail.com', '$2y$10$DBx1sWe3Zj7juZ7yoNIx3.oxJZnaodu5aQyoVoCVhySiMdRpkUlCm', 'AGENT ACCOUNT', '0123456789', 600, 500, 2, NULL),
	(2, 1, 'syafiq@mailinator.com', '$2y$10$8fv2qdP543kXf/8Xdu9tbOlaFUZLf5Jz2Ei.ZKg/PjevaNRdaKivm', 'SYAFIQ', '34545', 0, 0, 0, NULL),
	(3, 1, 'bugagykytu@mailinator.com', '$2y$10$nseP4vXnqoAU9yE1LGfKkuuN4rRbjFiwYN9b1MaHreqwhSeoOSuJm', 'Charity Rocha', '+1 (605) 292-4092', 0, 0, 0, NULL),
	(4, 1, 'pexagu@mailinator.com', '$2y$10$88GBPvpdg.SviJ2W6uDBWuu8MK5jC8XUl.wf8JaKOAiXJpE178LVG', 'Kenneth Armstrong', '+1 (256) 482-1429', 0, 0, 0, NULL);
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
  `receipt` varchar(50) DEFAULT NULL,
  `admin_remark` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.bookings: ~2 rows (approximately)
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` (`id`, `house_id`, `agent_id`, `customer_id`, `status`, `code`, `point_gain`, `remark`, `receipt`, `admin_remark`, `created_at`) VALUES
	(1, 1, 1, 2, 3, '24022', 200, ' hannan test', '../../assets/uploads/receipt/1621760535.png', '', '2021-05-06 15:03:05'),
	(2, 1, 1, 2, 2, '36286', 0, ' ', '../../assets/uploads/receipt/1621760535.png', '', '2021-05-06 17:03:14');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.houses: ~2 rows (approximately)
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` (`id`, `project_id`, `current_booking_id`, `name`, `type`, `price`, `point`) VALUES
	(1, 1, NULL, 'Lot 1', '3', 180000.00, 200),
	(2, 1, NULL, 'Lot 2', '3', 180000.00, 200),
	(3, 1, NULL, 'Lot 3', '3', 230000.00, 250);
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
  `location_name` varchar(255) NOT NULL DEFAULT '',
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.projects: ~1 rows (approximately)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `name`, `location_name`, `start`, `end`, `status`) VALUES
	(1, 'RUmah mesra rakyat', 'Location Name example', '2021-05-08', '2021-05-20', 2),
	(2, 'testing', 'Location Name example', '2021-05-02', '2021-05-15', 1);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Dumping structure for table booking_house.project_brochures
CREATE TABLE IF NOT EXISTS `project_brochures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `file_location` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.project_brochures: ~2 rows (approximately)
/*!40000 ALTER TABLE `project_brochures` DISABLE KEYS */;
INSERT INTO `project_brochures` (`id`, `project_id`, `title`, `file_location`) VALUES
	(1, 1, 'entrance', '../../assets/uploads/1620291601.jpg'),
	(2, 1, 'semi D', '../../assets/uploads/1620291621.jpg'),
	(3, 1, 'Bunglow', '../../assets/uploads/1620291633.jpg');
/*!40000 ALTER TABLE `project_brochures` ENABLE KEYS */;

-- Dumping structure for table booking_house.vouchers
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `valid_till` date DEFAULT NULL,
  `cost` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.vouchers: ~1 rows (approximately)
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
INSERT INTO `vouchers` (`id`, `name`, `image`, `valid_till`, `cost`, `status`, `is_deleted`) VALUES
	(1, 'Test', '../../assets/uploads/voucher/1622280731.png', '2021-05-14', 100, 1, 0);
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;

-- Dumping structure for table booking_house.voucher_claims
CREATE TABLE IF NOT EXISTS `voucher_claims` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `claim_at` datetime DEFAULT NULL,
  `cost` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table booking_house.voucher_claims: ~2 rows (approximately)
/*!40000 ALTER TABLE `voucher_claims` DISABLE KEYS */;
INSERT INTO `voucher_claims` (`id`, `voucher_id`, `code`, `agent_id`, `claim_at`, `cost`) VALUES
	(1, 1, '0ZYU7VGN', 1, '2021-05-29 18:13:27', 0),
	(2, 1, 'WEH5RLVZ', NULL, NULL, 0);
/*!40000 ALTER TABLE `voucher_claims` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
