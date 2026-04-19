/*
SQLyog Community
MySQL - 11.8.6-MariaDB : Database - dom_april
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `domains` */

CREATE TABLE `domains` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `zone` varchar(255) NOT NULL,
  `registered_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `domain_name_server` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ns_country` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doc_domain_1` varchar(255) DEFAULT NULL,
  `doc_domain_2` varchar(255) DEFAULT NULL,
  `doc_domain_3` varchar(255) DEFAULT NULL,
  `doc_domain_4` varchar(255) DEFAULT NULL,
  `doc_domain_5` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `name_organization` text DEFAULT NULL,
  `klasifikasi_instansi_id` int(11) DEFAULT NULL,
  `nama_instansi` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postal_code` char(100) DEFAULT NULL,
  `status` enum('error','draft','verifikasi dokumen','pending payment','verifikasi pembayaran','active','suspend','cancelled','reject') NOT NULL DEFAULT 'draft',
  `status_stage` enum('information-instansi','information-domain','document-domain','preview') NOT NULL DEFAULT 'information-instansi',
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `village_id` varchar(10) DEFAULT NULL,
  `registrant_id` int(11) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `canceled_by_id` int(11) DEFAULT NULL,
  `description_domain` varchar(255) DEFAULT NULL,
  `approved_payment_by_id` int(11) DEFAULT NULL,
  `type_domain` enum('registration','renewal','transfer') DEFAULT 'registration',
  `renewal_date` date DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `duration` tinyint(4) DEFAULT NULL,
  `d_registrant_type` varchar(100) DEFAULT NULL,
  `ammount` int(11) DEFAULT NULL,
  `d_status` char(5) DEFAULT NULL,
  `d_xname` varchar(255) DEFAULT NULL,
  `u_organization_type` varchar(100) DEFAULT NULL,
  `u_organization_name` varchar(255) DEFAULT NULL,
  `u_state` varchar(50) DEFAULT NULL,
  `u_city` varchar(50) DEFAULT NULL,
  `u_street2` text DEFAULT NULL,
  `u_street3` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by_id` int(11) DEFAULT NULL,
  `processed_update_ns_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`zone`) USING BTREE,
  KEY `domains_processed_update_ns_at_index` (`processed_update_ns_at`),
  KEY `registrant_id` (`registrant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=197533 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
