/*
SQLyog Enterprise v12.5.1 (64 bit)
MySQL - 8.0.20 : Database - dblatihandatatable
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `levels` */

DROP TABLE IF EXISTS `levels`;

CREATE TABLE `levels` (
  `levelid` int NOT NULL AUTO_INCREMENT,
  `levelnama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`levelid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `levels` */

insert  into `levels`(`levelid`,`levelnama`) values 
(1,'Administrator'),
(2,'Mahasiswa');

/*Table structure for table `mahasiswa` */

DROP TABLE IF EXISTS `mahasiswa`;

CREATE TABLE `mahasiswa` (
  `nobp` char(7) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tmplahir` varchar(100) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `jenkel` char(1) DEFAULT NULL,
  `mhsprodiid` int DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `mhspass` varchar(100) DEFAULT NULL,
  `mhslevelid` int DEFAULT NULL,
  PRIMARY KEY (`nobp`),
  KEY `mhsprodiid` (`mhsprodiid`),
  CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`mhsprodiid`) REFERENCES `prodi` (`prodiid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `mahasiswa` */

insert  into `mahasiswa`(`nobp`,`nama`,`tmplahir`,`tgllahir`,`jenkel`,`mhsprodiid`,`foto`,`mhspass`,`mhslevelid`) values 
('0910169','Novinaldi','Padang',NULL,'L',1,NULL,'$2y$10$i.tO2z3L7xm0mbM.kwYvietd0zWK2G/0R5skusUhPKF5ZxY/be6QK',2),
('2010001','Aini',NULL,NULL,NULL,1,NULL,NULL,NULL),
('2010002','Husna',NULL,NULL,NULL,1,NULL,NULL,NULL);

/*Table structure for table `prodi` */

DROP TABLE IF EXISTS `prodi`;

CREATE TABLE `prodi` (
  `prodiid` int NOT NULL AUTO_INCREMENT,
  `prodinama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`prodiid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `prodi` */

insert  into `prodi`(`prodiid`,`prodinama`) values 
(0,'Manajemen Informatika'),
(1,'Sistem Informasi'),
(2,'Sistem Komputer');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userid` char(50) NOT NULL,
  `usernama` varchar(100) DEFAULT NULL,
  `userpass` varchar(100) DEFAULT NULL,
  `userlevelid` int DEFAULT NULL,
  `userfoto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  KEY `userlevelid` (`userlevelid`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userlevelid`) REFERENCES `levels` (`levelid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`userid`,`usernama`,`userpass`,`userlevelid`,`userfoto`) values 
('admin','Admin Sistem','$2y$10$v7.yI9.mKLd4hTI7uytWV.xOOhK2tpn/nkuyGN.DUU1iP9q0kNySi',1,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
