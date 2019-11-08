/*
SQLyog Community v12.4.1 (64 bit)
MySQL - 10.1.30-MariaDB : Database - db_smartseal
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_smartseal` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_smartseal`;

/*Table structure for table `ms_area` */

DROP TABLE IF EXISTS `ms_area`;

CREATE TABLE `ms_area` (
  `AreaID` char(3) NOT NULL,
  `Area` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`AreaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ms_area` */

insert  into `ms_area`(`AreaID`,`Area`) values 
('BTS','BANTEN SELATAN'),
('BTU','BANTEN UTARA'),
('CKK','CIKOKOL'),
('CKP','CIKUPA'),
('SRP','SERPONG'),
('TLN','TELUK NAGA');

/*Table structure for table `ms_penerimaan` */

DROP TABLE IF EXISTS `ms_penerimaan`;

CREATE TABLE `ms_penerimaan` (
  `PenerimaanID` varchar(32) DEFAULT NULL,
  `Tanggal` date DEFAULT NULL,
  `NoSegel` varchar(32) NOT NULL,
  `AreaID` varchar(10) DEFAULT NULL,
  `Bidang` varchar(10) DEFAULT NULL,
  `Urut` tinyint(5) DEFAULT NULL,
  `Status` varchar(32) DEFAULT NULL,
  `PengambilanID` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`NoSegel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ms_penerimaan` */

insert  into `ms_penerimaan`(`PenerimaanID`,`Tanggal`,`NoSegel`,`AreaID`,`Bidang`,`Urut`,`Status`,`PengambilanID`) values 
('1020191111085042','2019-11-11','CKP-PBPD-000001-19','CKP','PBPD',1,'get','2020191112135714'),
('1020191111085042','2019-11-11','CKP-PBPD-000002-19','CKP','PBPD',2,'get','2020191112135714'),
('1020191111085042','2019-11-11','CKP-PBPD-000003-19','CKP','PBPD',3,'get','2020191112135714'),
('1020191111085042','2019-11-11','CKP-PBPD-000004-19','CKP','PBPD',4,'ready',''),
('1020191111085042','2019-11-11','CKP-PBPD-000005-19','CKP','PBPD',5,'ready',''),
('1020191111085042','2019-11-11','CKP-PBPD-000006-19','CKP','PBPD',6,'ready',''),
('1020191111085042','2019-11-11','CKP-PBPD-000007-19','CKP','PBPD',7,'ready',''),
('1020191111085042','2019-11-11','CKP-PBPD-000008-19','CKP','PBPD',8,'ready',''),
('1020191111085042','2019-11-11','CKP-PBPD-000009-19','CKP','PBPD',9,'ready',''),
('1020191111085042','2019-11-11','CKP-PBPD-000010-19','CKP','PBPD',10,'ready','');

/*Table structure for table `ms_pengambilan` */

DROP TABLE IF EXISTS `ms_pengambilan`;

CREATE TABLE `ms_pengambilan` (
  `PengambilanID` varchar(32) DEFAULT NULL,
  `Tanggal` date DEFAULT NULL,
  `NoSegel` varchar(32) NOT NULL,
  `AreaID` varchar(10) DEFAULT NULL,
  `Bidang` varchar(10) DEFAULT NULL,
  `Urut` tinyint(5) DEFAULT NULL,
  `Status` varchar(32) DEFAULT NULL,
  `PemakaianID` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`NoSegel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ms_pengambilan` */

insert  into `ms_pengambilan`(`PengambilanID`,`Tanggal`,`NoSegel`,`AreaID`,`Bidang`,`Urut`,`Status`,`PemakaianID`) values 
('2020191112135714','2019-11-12','CKP-PBPD-000001-19','CKP','PBPD',1,'ready',''),
('2020191112135714','2019-11-12','CKP-PBPD-000002-19','CKP','PBPD',2,'ready',''),
('2020191112135714','2019-11-12','CKP-PBPD-000003-19','CKP','PBPD',3,'ready','');

/*Table structure for table `ms_user` */

DROP TABLE IF EXISTS `ms_user`;

CREATE TABLE `ms_user` (
  `Password` varchar(32) DEFAULT NULL,
  `Admin` bigint(1) DEFAULT NULL,
  `UserID` varchar(32) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `AreaID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ms_user` */

insert  into `ms_user`(`Password`,`Admin`,`UserID`,`Nama`,`Email`,`AreaID`) values 
('123smi321',1,'adi','Adi Winata','adiwinata@smartmeterindo.com',NULL),
('123smi321',0,'andhie','Andhie Purbandoko','andi@smartmeterindo.com',NULL),
('123smi321',0,'komara','Adi Komara','adi@smartmeterindo.com','CKP'),
('abe',1,'rony','Rony Agung','ronyagungaribudiman@yahoo.com','CKP');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
