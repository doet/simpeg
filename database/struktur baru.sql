/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.3.11-MariaDB : Database - db_prog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_prog` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_prog`;

/*Table structure for table `tb_dls` */

DROP TABLE IF EXISTS `tb_dls`;

CREATE TABLE `tb_dls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ppjks_id` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `ops` varchar(255) DEFAULT NULL,
  `bapp` varchar(255) DEFAULT NULL,
  `pc` varchar(10) DEFAULT NULL,
  `pcon` varchar(255) DEFAULT NULL,
  `pcoff` varchar(255) DEFAULT NULL,
  `tunda` varchar(255) DEFAULT NULL,
  `tundaon` varchar(255) DEFAULT NULL,
  `tundaoff` varchar(255) DEFAULT NULL,
  `dd` varchar(255) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `kurs` varchar(10) DEFAULT NULL,
  `lhp_date` varchar(255) DEFAULT NULL,
  `moring` varchar(100) DEFAULT NULL,
  `lstp` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `tb_dls` */

/*Table structure for table `tb_ppjks` */

DROP TABLE IF EXISTS `tb_ppjks`;

CREATE TABLE `tb_ppjks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_issue` int(11) DEFAULT NULL,
  `ppjk` varchar(255) DEFAULT NULL,
  `agens_id` int(11) DEFAULT NULL,
  `kapals_id` int(11) DEFAULT NULL,
  `jettys_id` int(11) DEFAULT NULL,
  `eta` int(11) DEFAULT NULL,
  `etd` int(11) DEFAULT NULL,
  `etmal` int(11) DEFAULT NULL,
  `asal` varchar(255) DEFAULT NULL,
  `tujuan` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `muat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `tb_ppjks` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
