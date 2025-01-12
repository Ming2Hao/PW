/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.22-MariaDB : Database - t7_221116962
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`t7_221116962` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `t7_221116962`;

/*Table structure for table `inventory` */

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `in_id` varchar(11) NOT NULL,
  `in_us_id` varchar(11) DEFAULT NULL,
  `in_sa_id` varchar(11) DEFAULT NULL,
  `in_qty` int(11) DEFAULT NULL,
  `in_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`in_id`),
  KEY `in_sa_id` (`in_sa_id`),
  KEY `in_us_id` (`in_us_id`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`in_sa_id`) REFERENCES `saham` (`sa_id`),
  CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`in_us_id`) REFERENCES `users` (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `inventory` */

insert  into `inventory`(`in_id`,`in_us_id`,`in_sa_id`,`in_qty`,`in_price`) values 
('IN001','US001','SA001',35,100),
('IN002','US002','SA001',5,100),
('IN003','US001','SA002',20,200),
('IN004','US002','SA002',20,200),
('IN005','US001','SA003',20,300),
('IN006','US002','SA003',20,300);

/*Table structure for table `market` */

DROP TABLE IF EXISTS `market`;

CREATE TABLE `market` (
  `ma_id` varchar(11) NOT NULL,
  `ma_sa_id` varchar(11) DEFAULT NULL,
  `ma_price` int(11) DEFAULT NULL,
  `ma_qty` int(11) DEFAULT NULL,
  `ma_us_id` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `ma_sa_id` (`ma_sa_id`),
  KEY `ma_us_id` (`ma_us_id`),
  CONSTRAINT `market_ibfk_1` FOREIGN KEY (`ma_sa_id`) REFERENCES `saham` (`sa_id`),
  CONSTRAINT `market_ibfk_2` FOREIGN KEY (`ma_us_id`) REFERENCES `users` (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `market` */

/*Table structure for table `saham` */

DROP TABLE IF EXISTS `saham`;

CREATE TABLE `saham` (
  `sa_id` varchar(11) NOT NULL,
  `sa_marketname` varchar(100) DEFAULT NULL,
  `sa_assetname` varchar(100) DEFAULT NULL,
  `sa_ipoprice` int(11) DEFAULT NULL,
  `sa_lastprice` int(11) DEFAULT NULL,
  PRIMARY KEY (`sa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `saham` */

insert  into `saham`(`sa_id`,`sa_marketname`,`sa_assetname`,`sa_ipoprice`,`sa_lastprice`) values 
('SA001','BBCA','BCA Corp',100,15),
('SA002','TTK','Tiktok',200,200),
('SA003','META','Metadata',300,300);

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `tr_id` varchar(11) DEFAULT NULL,
  `tr_price` int(11) DEFAULT NULL,
  `tr_qty` int(11) DEFAULT NULL,
  `tr_sa_id` varchar(11) DEFAULT NULL,
  KEY `tr_sa_id` (`tr_sa_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`tr_sa_id`) REFERENCES `saham` (`sa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `transaksi` */

insert  into `transaksi`(`tr_id`,`tr_price`,`tr_qty`,`tr_sa_id`) values 
('TR001',5000,15,'SA002'),
('TR002',7000,13,'SA001'),
('TR003',8000,10,'SA003'),
('TR004',10,10,'SA001'),
('TR005',15,15,'SA001');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `us_id` varchar(11) NOT NULL,
  `us_name` varchar(100) DEFAULT NULL,
  `us_email` varchar(100) DEFAULT NULL,
  `us_username` varchar(100) DEFAULT NULL,
  `us_password` varchar(100) DEFAULT NULL,
  `us_saldo` int(11) DEFAULT NULL,
  `us_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`us_id`,`us_name`,`us_email`,`us_username`,`us_password`,`us_saldo`,`us_status`) values 
('US001','a','x@m.cm','a','123',1000000,1),
('US002','user1','ivancs2010ggg@gmail.com','user1','passuser1',1000000,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
