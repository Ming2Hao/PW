/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.22-MariaDB : Database - db_221116962
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_221116962` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_221116962`;

/*Table structure for table `brand` */

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `br_id` varchar(100) NOT NULL,
  `br_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`br_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `brand` */

insert  into `brand`(`br_id`,`br_name`) values 
('BR001','masako'),
('BR002','sasa'),
('BR003','gulaku'),
('BR004','kapal api'),
('BR005','milkita');

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `ca_id` varchar(100) NOT NULL,
  `cs_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ca_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `category` */

insert  into `category`(`ca_id`,`cs_name`) values 
('CA001','penyedap'),
('CA002','permen'),
('CA003','kopi'),
('CA004','garam'),
('CA005','gula');

/*Table structure for table `d_trans` */

DROP TABLE IF EXISTS `d_trans`;

CREATE TABLE `d_trans` (
  `dt_id` varchar(100) NOT NULL,
  `dt_it_id` varchar(100) DEFAULT NULL,
  `dt_jumlah` int(11) DEFAULT NULL,
  `dt_harga` int(11) DEFAULT NULL,
  `dt_ht_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dt_id`),
  KEY `dt_it_id` (`dt_it_id`),
  KEY `dt_ht_id` (`dt_ht_id`),
  CONSTRAINT `d_trans_ibfk_1` FOREIGN KEY (`dt_it_id`) REFERENCES `items` (`it_id`),
  CONSTRAINT `d_trans_ibfk_2` FOREIGN KEY (`dt_ht_id`) REFERENCES `h_trans` (`ht_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `d_trans` */

insert  into `d_trans`(`dt_id`,`dt_it_id`,`dt_jumlah`,`dt_harga`,`dt_ht_id`) values 
('DT001','IT001',12,60000,'HT001');

/*Table structure for table `h_trans` */

DROP TABLE IF EXISTS `h_trans`;

CREATE TABLE `h_trans` (
  `ht_id` varchar(100) NOT NULL,
  `ht_total` int(11) DEFAULT NULL,
  `ht_us_id` varchar(100) DEFAULT NULL,
  `ht_waktu` time DEFAULT NULL,
  PRIMARY KEY (`ht_id`),
  KEY `ht_us_id` (`ht_us_id`),
  CONSTRAINT `h_trans_ibfk_1` FOREIGN KEY (`ht_us_id`) REFERENCES `users` (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `h_trans` */

insert  into `h_trans`(`ht_id`,`ht_total`,`ht_us_id`,`ht_waktu`) values 
('HT001',60000,'US001','18:24:23');

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `it_id` varchar(100) NOT NULL,
  `it_name` varchar(100) DEFAULT NULL,
  `it_br_id` varchar(100) DEFAULT NULL,
  `it_ca_id` varchar(100) DEFAULT NULL,
  `it_us_id` varchar(100) DEFAULT NULL,
  `it_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`it_id`),
  KEY `it_br_id` (`it_br_id`),
  KEY `it_ca_id` (`it_ca_id`),
  KEY `it_us_id` (`it_us_id`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`it_br_id`) REFERENCES `brand` (`br_id`),
  CONSTRAINT `items_ibfk_2` FOREIGN KEY (`it_ca_id`) REFERENCES `category` (`ca_id`),
  CONSTRAINT `items_ibfk_3` FOREIGN KEY (`it_us_id`) REFERENCES `users` (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `items` */

insert  into `items`(`it_id`,`it_name`,`it_br_id`,`it_ca_id`,`it_us_id`,`it_price`) values 
('IT001','masako rasa ayam','BR001','CA001','US003',2000000),
('IT004','masako rasa nyambik','BR001','CA001','US004',10000000),
('IT005','milkita stroberi','BR005','CA003','US004',5000000);

/*Table structure for table `keranjang` */

DROP TABLE IF EXISTS `keranjang`;

CREATE TABLE `keranjang` (
  `ke_id` varchar(100) NOT NULL,
  `ke_us_id` varchar(100) DEFAULT NULL,
  `ke_it_id` varchar(100) DEFAULT NULL,
  `ke_jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`ke_id`),
  KEY `ke_us_id` (`ke_us_id`),
  KEY `ke_it_id` (`ke_it_id`),
  CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`ke_us_id`) REFERENCES `users` (`us_id`),
  CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`ke_it_id`) REFERENCES `items` (`it_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `keranjang` */

insert  into `keranjang`(`ke_id`,`ke_us_id`,`ke_it_id`,`ke_jumlah`) values 
('KE001','US002','IT004',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `us_id` varchar(100) NOT NULL,
  `us_username` varchar(100) DEFAULT NULL,
  `us_email` varchar(100) DEFAULT NULL,
  `us_password` varchar(100) DEFAULT NULL,
  `us_name` varchar(100) DEFAULT NULL,
  `us_saldo` int(11) DEFAULT 0,
  `us_role` varchar(100) DEFAULT 'customer',
  PRIMARY KEY (`us_id`),
  CONSTRAINT `adminoruser` CHECK (`us_role` = 'admin' or `us_role` = 'customer' or `us_role` = 'toko')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`us_id`,`us_username`,`us_email`,`us_password`,`us_name`,`us_saldo`,`us_role`) values 
('US000','mimin','mimin@gmail.com','mimin','admin',0,'admin'),
('US001','adi','ivan@gmail.com','ivanganteng','ivan cahyadi',100000000,'customer'),
('US002','user3','upraksinlui2021@gmail.com','passuser3','nuser3',100000000,'customer'),
('US003','user1','ivancs2010ggg@gmail.com','passuser1','nuser1',0,'toko'),
('US004','toko1','toko1@gmail.com','passtoko1','nama toko1',0,'toko');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
