/*
SQLyog Job Agent Copyright(c) Webyog Inc. All Rights Reserved.
MySQL - 10.3.8-MariaDB : Database - db_papan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Database structure for database `db_papan` */

CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_papan` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_papan`;

/*Table structure for table `tb_agens` */

DROP TABLE IF EXISTS `tb_agens`;

CREATE TABLE `tb_agens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tb_agens` */

insert  into `tb_agens` values 
(1,'admiral','wiyoto'),
(2,'admiral','deri'),
(3,'oscean','rido'),
(4,'ADL','Adi');

/*Table structure for table `tb_jettys` */

DROP TABLE IF EXISTS `tb_jettys`;

CREATE TABLE `tb_jettys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_jettys` */

/*Table structure for table `tb_vessels` */

DROP TABLE IF EXISTS `tb_vessels`;

CREATE TABLE `tb_vessels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_vessels` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
