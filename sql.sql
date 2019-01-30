/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 8.0.13 : Database - salon
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`salon` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;

USE `salon`;

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `cust_id` int(10) NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(250) DEFAULT NULL,
  `bdate` date DEFAULT NULL,
  `cust_address` varchar(250) DEFAULT NULL,
  `cust_city` varchar(250) DEFAULT NULL,
  `mobileno` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `customers` */

insert  into `customers`(`cust_id`,`cust_name`,`bdate`,`cust_address`,`cust_city`,`mobileno`) values 
(1,'Kaleb Mari',NULL,NULL,NULL,NULL),
(2,'Rommel Santiago',NULL,NULL,NULL,NULL),
(3,'Ivy Sebastian',NULL,NULL,NULL,NULL);

/*Table structure for table `employee_master` */

DROP TABLE IF EXISTS `employee_master`;

CREATE TABLE `employee_master` (
  `specialist_id` varchar(10) NOT NULL,
  `emp_fname` varchar(100) DEFAULT NULL,
  `emp_sname` varchar(100) DEFAULT NULL,
  `emp_mname` varchar(100) DEFAULT NULL,
  `bdate` date DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `addr1` varchar(100) DEFAULT NULL,
  `addr2` varchar(100) DEFAULT NULL,
  `contact_details` varchar(100) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `isactive` enum('Y','N') DEFAULT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`specialist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `employee_master` */

insert  into `employee_master`(`specialist_id`,`emp_fname`,`emp_sname`,`emp_mname`,`bdate`,`gender`,`addr1`,`addr2`,`contact_details`,`hire_date`,`isactive`,`user_id`) values 
('0000000001','Chard','Santos','M','1984-06-12','M','-','-','-','2018-11-04','Y','max'),
('0000000002','Eric','Torres','J','1987-09-16','M','-','-','-','2014-07-24','Y','max'),
('0000000003','Ronnie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Y',NULL),
('0000000004','Will','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Y',NULL);

/*Table structure for table `product_history` */

DROP TABLE IF EXISTS `product_history`;

CREATE TABLE `product_history` (
  `product_id` varchar(10) DEFAULT NULL,
  `prod_details` varchar(150) DEFAULT NULL,
  `amount` double(12,2) DEFAULT NULL,
  `commission` double(12,2) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `trandate` datetime DEFAULT NULL,
  `user_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `product_history` */

insert  into `product_history`(`product_id`,`prod_details`,`amount`,`commission`,`startdate`,`enddate`,`remarks`,`trandate`,`user_id`) values 
('0000000002','Shave1',100.00,20.00,'2019-01-01',NULL,NULL,'2019-01-21 00:41:08','max'),
('0000000004','8 ball\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000004','8 ball\r\n',250.00,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000005',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000002','Shave1',100.00,20.00,'2019-01-01',NULL,NULL,'2019-01-21 00:50:39','max'),
('0000000006',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000007',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000004','Shampoo',210.00,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000005','Hairline',230.00,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000006','Inventory 1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000007','Inventory 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000008',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000009',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000010',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('0000000008',NULL,NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000009',NULL,NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000010',NULL,NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000008','Inventory 2',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000009','Inventory 2',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000010','Inventory 2',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL);

/*Table structure for table `product_master` */

DROP TABLE IF EXISTS `product_master`;

CREATE TABLE `product_master` (
  `product_id` varchar(10) NOT NULL,
  `prod_details` varchar(250) DEFAULT NULL,
  `amount` double(12,2) DEFAULT NULL,
  `commission` double(12,2) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `trandate` datetime DEFAULT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `product_master` */

insert  into `product_master`(`product_id`,`prod_details`,`amount`,`commission`,`startdate`,`enddate`,`remarks`,`trandate`,`user_id`) values 
('0000000001','Hair cut',180.00,30.00,'2019-01-01',NULL,NULL,'2019-01-21 00:38:53','max'),
('0000000002','Shave',100.00,20.00,'2019-01-01',NULL,NULL,'2019-01-21 00:50:39','max'),
('0000000003','Booking',230.00,30.00,'2019-01-01',NULL,NULL,'2019-01-21 00:54:03','max'),
('0000000004','Shampoo',210.00,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000005','Hairline',230.00,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000006','Inventory 1',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000007','Inventory 2',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000008','Inventory 3',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000009','Inventory 4',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL),
('0000000010','Inventory 5',NULL,NULL,'2019-01-01',NULL,NULL,NULL,NULL);

/*Table structure for table `sales_dtl` */

DROP TABLE IF EXISTS `sales_dtl`;

CREATE TABLE `sales_dtl` (
  `invoice_no` int(10) DEFAULT NULL,
  `branch_cd` varchar(10) DEFAULT NULL,
  `product_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `specialist_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `item_amount` double(12,2) DEFAULT '0.00',
  `item_qty` int(5) DEFAULT NULL,
  `item_disc` double(12,2) DEFAULT '0.00',
  `comm_amount` double(12,2) DEFAULT '0.00',
  `iscancelled` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `sales_dtl` */

insert  into `sales_dtl`(`invoice_no`,`branch_cd`,`product_id`,`specialist_id`,`item_amount`,`item_qty`,`item_disc`,`comm_amount`,`iscancelled`) values 
(1,'01','0000000001','Chard',180.00,1,0.00,0.00,'N'),
(2,'01','0000000001','Chard',180.00,1,0.00,0.00,'N'),
(2,'01','0000000002','Chard',100.00,1,0.00,0.00,'N'),
(2,'01','0000000004','Ronnie',210.00,1,0.00,0.00,'N'),
(3,'01','0000000005','Will',230.00,1,0.00,0.00,'N'),
(4,'01','0000000005','Chard',230.00,1,0.00,0.00,'N'),
(5,'01','0000000004','Eric',210.00,1,0.00,0.00,'N'),
(6,'01','0000000001','Eric',180.00,1,0.00,0.00,'N');

/*Table structure for table `sales_hdr` */

DROP TABLE IF EXISTS `sales_hdr`;

CREATE TABLE `sales_hdr` (
  `invoice_no` int(10) NOT NULL,
  `branch_cd` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer` varchar(250) DEFAULT NULL,
  `other_amount` double(12,2) DEFAULT NULL,
  `serv_date` date DEFAULT NULL,
  `trandate` datetime DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(250) DEFAULT NULL,
  `iscancelled` enum('Y','N') DEFAULT 'N',
  `user_id` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`invoice_no`,`branch_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `sales_hdr` */

insert  into `sales_hdr`(`invoice_no`,`branch_cd`,`customer`,`other_amount`,`serv_date`,`trandate`,`remarks`,`iscancelled`,`user_id`) values 
(1,'01','aadsfasdf',0.00,'2019-01-26','2019-01-26 10:35:09',NULL,'N','max'),
(2,'01','Ron Marquez',0.00,'2019-01-26','2019-01-26 10:37:25',NULL,'N','max'),
(3,'01','Gab Santos',0.00,'2019-01-26','2019-01-26 10:42:36',NULL,'N','max'),
(4,'01','aadsfasdf',0.00,'2019-01-26','2019-01-26 11:10:04',NULL,'N','max'),
(5,'01','Rico Reyes',100.00,'2019-01-26','2019-01-26 11:17:37',NULL,'N','max'),
(6,'01','Dennis Cruz',0.00,'2019-01-26','2019-01-26 11:25:01',NULL,'N','max');

/*Table structure for table `sales_time` */

DROP TABLE IF EXISTS `sales_time`;

CREATE TABLE `sales_time` (
  `time` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `sales_time` */

insert  into `sales_time`(`time`) values 
('01:00pm'),
('01:30pm'),
('02:00pm'),
('02:30pm'),
('03:00pm'),
('03:30pm'),
('04:00pm'),
('04:30pm'),
('05:00pm'),
('05:30pm'),
('06:00pm'),
('06:30pm'),
('07:00am'),
('07:00pm'),
('07:30am'),
('07:30pm'),
('08:00am'),
('08:00pm'),
('08:30am'),
('08:30pm'),
('09:00am'),
('09:00pm'),
('09:30am'),
('09:30pm'),
('10:00am'),
('10:00pm'),
('10:30am'),
('11:00am'),
('12:00pm'),
('12:30pm');

/*Table structure for table `sysusers` */

DROP TABLE IF EXISTS `sysusers`;

CREATE TABLE `sysusers` (
  `user_id` varchar(25) NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `isadmin` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `sysusers` */

insert  into `sysusers`(`user_id`,`username`,`isadmin`) values 
('admin','Administrator','Y'),
('max','Max Lemuel','Y');

/*Table structure for table `t1` */

DROP TABLE IF EXISTS `t1`;

CREATE TABLE `t1` (
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t1` */

/* Trigger structure for table `product_master` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trg_producthist` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'admin'@'%' */ /*!50003 TRIGGER `trg_producthist` AFTER UPDATE ON `product_master` FOR EACH ROW BEGIN
	INSERT INTO product_history VALUES (OLD.product_id, old.prod_details, old.amount, old. commission, old.startdate, old.enddate, old.remarks, old.trandate, old.user_id);	
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
