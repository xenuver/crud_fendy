/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: db    Database: db_kreator
-- ------------------------------------------------------
-- Server version	10.11.18-MariaDB-ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `kreator`
--

DROP TABLE IF EXISTS `kreator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kreator` (
  `kreator_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL COMMENT 'Alamat email kreator untuk notifikasi otomatis',
  `alamat` text DEFAULT NULL,
  `id_game` varchar(50) NOT NULL,
  `status` enum('active','suspended') DEFAULT 'active',
  `last_uid_update` datetime DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kreator_id`),
  UNIQUE KEY `uq_kreator_id_game` (`id_game`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kreator`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `kreator` WRITE;
/*!40000 ALTER TABLE `kreator` DISABLE KEYS */;
INSERT INTO `kreator` VALUES
(1,'MiminBS',NULL,'Indonesia','44423','active',NULL,NULL,'','','2026-06-02 21:52:23','2026-06-27 15:11:57',NULL),
(3,'errmentok',NULL,'Indonesia','100008','active',NULL,NULL,'','https://youtube.com/@errmentok','2026-06-15 12:44:15','2026-07-04 21:43:13',NULL),
(4,'Xval',NULL,'Indonesia','100029','active',NULL,NULL,'https://tiktok.com/@xval','','2026-06-15 12:44:15','2026-06-16 21:21:27',NULL),
(5,'Aurest',NULL,'Indonesia','100001','active',NULL,NULL,'','https://youtube.com/@aurest','2026-06-15 12:44:15','2026-06-16 21:21:47',NULL),
(6,'Benjamin 889',NULL,'Indonesia','8888888327','active',NULL,NULL,NULL,NULL,'2026-06-15 12:44:15','2026-06-16 21:21:39',NULL),
(7,'Hans7',NULL,'Indonesia','100012','active',NULL,NULL,'https://tiktok.com/@hans7','','2026-06-15 12:44:15','2026-06-16 21:21:37',NULL),
(8,'Batman',NULL,'Indonesia','8888888106','active',NULL,NULL,NULL,NULL,'2026-06-15 12:44:15','2026-06-16 21:21:43',NULL),
(9,'Fenzy',NULL,'Indonesia','100015','active',NULL,NULL,'https://tiktok.com/@fenzy','','2026-06-15 12:44:15','2026-06-16 21:21:41',NULL),
(11,'kaiser','fendy.fendy740@gmail.com','Indonesia','123456','active','2026-06-27 14:35:23','https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/profil/1781530628_43608d9fc451374e.jpg','https://www.tiktok.com/@kaisermawii','https://www.youtube.com/@Kaiserbloodstrike','2026-06-15 20:00:16','2026-08-01 15:44:34',NULL),
(13,'Jerry Tiktok',NULL,'Indonesia','100010','active',NULL,NULL,'https://tiktok.com/@jerry_tiktok','','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(15,'Feels Gaming',NULL,'Indonesia','100006','active',NULL,NULL,'','https://youtube.com/@feels_gaming','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(16,'Kaolla',NULL,'Indonesia','100018','active',NULL,NULL,'https://tiktok.com/@kaolla','','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(17,'Benjamin 889',NULL,'Indonesia','100003','active',NULL,NULL,'https://tiktok.com/@benjamin_889','','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(18,'Lynch',NULL,'Indonesia','100035','active',NULL,NULL,'','https://youtube.com/@lynch','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(19,'Paat',NULL,'Indonesia','100013','active',NULL,NULL,'','https://youtube.com/@paat','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(22,'Cukup Tampan',NULL,'Indonesia','100004','active',NULL,NULL,'','https://youtube.com/@cukup_tampan','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(23,'aisyah',NULL,'Indonesia','100016','active',NULL,NULL,'','https://youtube.com/@aisyah','2026-05-01 08:00:00','2026-07-21 14:57:02',NULL),
(24,'Tearyu',NULL,'Indonesia','100023','active',NULL,NULL,'https://tiktok.com/@tearyu','','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(25,'Vindragon',NULL,'Indonesia','100025','active',NULL,NULL,'https://tiktok.com/@vindragon','','2026-05-01 08:00:00','2026-05-01 08:00:00',NULL),
(28,'emjeluvepep ',NULL,'Indonesia','12345678910','active',NULL,NULL,'https://www.tiktok.com/@emjeluvepep?is_from_webapp=1&sender_device=pc','https://youtube.com/@emjexe?si=5gTQ6Ubj0MfYzbeN','2026-07-04 12:20:12','2026-07-04 12:27:03',NULL),
(29,'Mizy',NULL,'Indonesia','586014813642','active',NULL,NULL,'https://www.tiktok.com/@letknowmizy?is_from_webapp=1&sender_device=pc','','2026-07-04 13:33:35','2026-07-04 13:34:44',NULL),
(30,'hanscream11',NULL,'Indonesia','586024048389','active',NULL,NULL,'https://www.tiktok.com/@itshanscream','','2026-07-04 14:01:14','2026-07-04 14:03:38',NULL),
(31,'eLva',NULL,'Indonesia','31007018689299','active','2026-07-21 15:01:43',NULL,'https://www.tiktok.com/@elvahahaha2.0?_r=1&_t=ZS-97kL9ceSXn6','','2026-07-04 14:29:29','2026-07-21 15:01:43',NULL),
(32,'Valtz strike',NULL,'Indonesia','586014366028','active',NULL,NULL,'https://www.tiktok.com/@valtzstrike.v2?is_from_webapp=1&sender_device=pc','','2026-07-04 21:16:36','2026-07-04 21:19:56',NULL),
(33,'haizua',NULL,'Makassar','586016851413','active',NULL,NULL,'https://www.tiktok.com/@haizuaa?is_from_webapp=1&sender_device=pc','https://youtube.com/@haizuaa?si=EcF5jMhh3DyRnKyR','2026-07-04 22:25:30','2026-07-04 22:28:52',NULL),
(34,'radagelo',NULL,'Indonesia','586024730751','active',NULL,NULL,'https://www.tiktok.com/@radagelobs?is_from_webapp=1&sender_device=pc','','2026-07-04 22:56:07','2026-07-04 23:00:02',NULL),
(35,'Rusli',NULL,'Indonesia','313295314797','active',NULL,NULL,'https://www.tiktok.com/@ruslysetiawann?_r=1&_t=ZS-97kyWR1AFAC','','2026-07-04 23:17:11','2026-07-04 23:30:42',NULL),
(36,'Panjiwcs ',NULL,'Indonesia','310062264557','active',NULL,NULL,'https://www.tiktok.com/@panjiwcs?_r=1&_t=ZS-97kypN5onVX','https://youtube.com/@pandroid1420?si=c0EB2KfFGNh8EBkl','2026-07-04 23:28:39','2026-07-04 23:34:30',NULL),
(37,'MiminBS',NULL,'Indonesia','51123456789012','active',NULL,NULL,'https://www.tiktok.com/@bloodstrikeid','','2026-07-21 13:58:47','2026-07-21 15:01:02',NULL),
(40,'melyanto',NULL,'Indonesia','88992387782','active',NULL,NULL,'https://www.tiktok.com/@kaiserofciall','','2026-07-30 10:13:19','2026-07-30 10:24:13',NULL),
(41,'akuntesting',NULL,'Indonesia','88849562341','active',NULL,NULL,NULL,NULL,'2026-07-30 22:56:32','2026-07-30 22:56:32',NULL);
/*!40000 ALTER TABLE `kreator` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `laporan_mingguan`
--

DROP TABLE IF EXISTS `laporan_mingguan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_mingguan` (
  `laporan_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `kreator_id` int(11) unsigned NOT NULL,
  `platform` enum('youtube','tiktok') DEFAULT 'tiktok',
  `jumlah_video` int(11) NOT NULL DEFAULT 0,
  `total_views_video` bigint(20) NOT NULL DEFAULT 0,
  `jumlah_shorts` int(11) DEFAULT 0,
  `views_shorts` bigint(20) DEFAULT 0,
  `jumlah_live` int(11) NOT NULL DEFAULT 0,
  `total_views_live` bigint(20) NOT NULL DEFAULT 0,
  `foto_views_konten` varchar(255) DEFAULT NULL,
  `foto_views_shorts` varchar(255) DEFAULT NULL,
  `foto_views_livestream` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_validasi` enum('pending','valid','tidak_valid') NOT NULL DEFAULT 'pending',
  `pesan_admin` text DEFAULT NULL,
  `status_banding` enum('menunggu','diterima','ditolak_final') DEFAULT NULL,
  `alasan_banding` text DEFAULT NULL,
  `catatan_superadmin` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `penonton_puncak_live` bigint(20) DEFAULT 0,
  `foto_penonton_puncak_live` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`laporan_id`),
  KEY `fk_user_laporan` (`user_id`),
  KEY `idx_status_validasi` (`status_validasi`),
  KEY `idx_status_banding` (`status_banding`),
  KEY `idx_kreator_id` (`kreator_id`),
  CONSTRAINT `fk_user_laporan` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_mingguan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `laporan_mingguan` WRITE;
/*!40000 ALTER TABLE `laporan_mingguan` DISABLE KEYS */;
INSERT INTO `laporan_mingguan` VALUES
(200,15,'Jerry Tiktok',13,'tiktok',3,141120,0,0,2,35280,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1800,'dummy_ccv.webp'),
(201,15,'Jerry Tiktok',13,'tiktok',3,241760,0,0,2,60440,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1800,'dummy_ccv.webp'),
(202,15,'Jerry Tiktok',13,'tiktok',3,327600,0,0,2,81900,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1800,'dummy_ccv.webp'),
(203,15,'Jerry Tiktok',13,'tiktok',3,297600,0,0,2,74400,'dummy_konten.webp',NULL,'dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1800,'dummy_ccv.webp'),
(204,7,'Xval',4,'tiktok',3,516000,0,0,2,129000,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1087,'dummy_ccv.webp'),
(205,7,'Xval',4,'tiktok',3,536000,0,0,2,134000,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1087,'dummy_ccv.webp'),
(206,7,'Xval',4,'tiktok',3,505600,0,0,2,126400,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1087,'dummy_ccv.webp'),
(207,7,'Xval',4,'tiktok',3,485600,0,0,2,121400,'dummy_konten.webp',NULL,'dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1087,'dummy_ccv.webp'),
(211,6,'Errmentok',3,'youtube',3,222070,5,222070,2,111035,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1451,'dummy_ccv.webp'),
(212,6,'Errmentok',3,'youtube',3,543000,5,543000,2,271500,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1451,'dummy_ccv.webp'),
(213,6,'Errmentok',3,'youtube',3,373160,5,373160,2,186580,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1451,'dummy_ccv.webp'),
(214,6,'Errmentok',3,'youtube',3,211240,5,211240,2,105620,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,1451,'dummy_ccv.webp'),
(219,17,'Feels Gaming',15,'youtube',3,171200,5,171200,2,85600,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,898,'dummy_ccv.webp'),
(220,17,'Feels Gaming',15,'youtube',3,190400,5,190400,2,95200,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,898,'dummy_ccv.webp'),
(221,17,'Feels Gaming',15,'youtube',3,197280,5,197280,2,98640,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,898,'dummy_ccv.webp'),
(222,8,'Aurest',5,'youtube',3,20000,5,20000,2,10000,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,617,'dummy_ccv.webp'),
(223,10,'Hans7',7,'tiktok',3,112080,0,0,2,28020,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,427,'dummy_ccv.webp'),
(224,10,'Hans7',7,'tiktok',3,109360,0,0,2,27340,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,427,'dummy_ccv.webp'),
(225,10,'Hans7',7,'tiktok',3,85600,0,0,2,21400,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,427,'dummy_ccv.webp'),
(226,10,'Hans7',7,'tiktok',3,124960,0,0,2,31240,'dummy_konten.webp',NULL,'dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,427,'dummy_ccv.webp'),
(227,18,'Kaolla',16,'tiktok',3,115440,0,0,2,28860,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,364,'dummy_ccv.webp'),
(228,18,'Kaolla',16,'tiktok',3,225360,0,0,2,56340,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,364,'dummy_ccv.webp'),
(229,18,'Kaolla',16,'tiktok',3,142160,0,0,2,35540,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,364,'dummy_ccv.webp'),
(230,18,'Kaolla',16,'tiktok',3,172560,0,0,2,43140,'dummy_konten.webp',NULL,'dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,364,'dummy_ccv.webp'),
(231,19,'Benjamin 889',17,'tiktok',3,233520,0,0,2,58380,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,327,'dummy_ccv.webp'),
(232,19,'Benjamin 889',17,'tiktok',3,235360,0,0,2,58840,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,327,'dummy_ccv.webp'),
(233,20,'Lynch',18,'youtube',3,60440,5,60440,2,30220,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,266,'dummy_ccv.webp'),
(234,20,'Lynch',18,'youtube',3,72080,5,72080,2,36040,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,266,'dummy_ccv.webp'),
(235,20,'Lynch',18,'youtube',3,194880,5,194880,2,97440,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,266,'dummy_ccv.webp'),
(236,20,'Lynch',18,'youtube',3,162920,5,162920,2,81460,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,266,'dummy_ccv.webp'),
(237,21,'Paat',19,'youtube',3,15000,5,15000,2,7500,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,324,'dummy_ccv.webp'),
(238,21,'Paat',19,'youtube',3,26040,5,26040,2,13020,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,324,'dummy_ccv.webp'),
(239,21,'Paat',19,'youtube',3,28720,5,28720,2,14360,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,324,'dummy_ccv.webp'),
(240,21,'Paat',19,'youtube',3,14600,5,14600,2,7300,'dummy_konten.webp','dummy_shorts.webp','dummy_live.webp','2026-06-01 10:00:00','2026-06-01 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,324,'dummy_ccv.webp'),
(249,12,'Fenzy',9,'tiktok',3,527920,0,0,2,131980,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-11 10:00:00','2026-05-11 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,262,'dummy_ccv.webp'),
(250,12,'Fenzy',9,'tiktok',3,423205,0,0,2,105801,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-18 10:00:00','2026-05-18 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,262,'dummy_ccv.webp'),
(251,12,'Fenzy',9,'tiktok',3,498000,0,0,2,124500,'dummy_konten.webp',NULL,'dummy_live.webp','2026-05-25 10:00:00','2026-05-25 10:00:00','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,1,262,'dummy_ccv.webp'),
(252,12,'Fenzy',9,'tiktok',3,494080,0,0,2,123520,'dummy_konten.webp',NULL,'dummy_live.webp','2026-06-01 10:00:00','2026-07-19 15:01:32','valid','Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',NULL,NULL,NULL,0,262,'dummy_ccv.webp'),
(261,30,'emjeluvepep ',28,'tiktok',0,14300,0,0,5,2500,'konten_emjeluvepep__20260704_123916_5912.webp',NULL,'live_emjeluvepep__20260704_123916_5912.webp','2026-07-04 12:39:16','2026-07-04 12:39:55','valid','Bagus nih bang emje, ayo collab',NULL,NULL,NULL,0,765,'ccv_emjeluvepep__20260704_123916_5912.webp'),
(262,31,'Mizy',29,'tiktok',2,131900,0,0,6,101600,'konten_mizy_20260704_134300_8403.webp',NULL,'live_mizy_20260704_134300_8403.webp','2026-07-04 13:43:00','2026-07-04 13:43:27','valid','Bagus bang Mizy, nnt kita collab ya',NULL,NULL,NULL,0,399,'ccv_mizy_20260704_134300_8403.webp'),
(263,32,'hanscream11',30,'tiktok',3,30900,0,0,11,26100,'konten_hanscream11_20260704_141123_5605.webp',NULL,'live_hanscream11_20260704_141123_5605.webp','2026-07-04 14:11:23','2026-07-04 14:11:47','valid','Bagus kaka hans, Kita collab caster lagi yak mingdep',NULL,NULL,NULL,0,513,'ccv_hanscream11_20260704_141123_5605.webp'),
(265,33,'eLva',31,'tiktok',0,103000,0,0,0,0,'konten_elva_20260704_143509_2157.webp',NULL,'live_elva_20260704_143509_2157.webp','2026-07-04 14:35:10','2026-07-04 14:35:41','valid','bagus el, jgn sering2 skip live',NULL,NULL,NULL,0,0,'ccv_elva_20260704_143509_2157.webp'),
(266,34,'Valtz strike',32,'tiktok',4,239000,0,0,1,325,'konten_valtz_strike_20260704_212624_4750.webp',NULL,'live_valtz_strike_20260704_212624_4750.webp','2026-07-04 21:26:24','2026-07-04 21:27:04','valid','Bagus Mas',NULL,NULL,NULL,0,4,'ccv_valtz_strike_20260704_212624_4750.webp'),
(267,6,'errmentok',3,'tiktok',5,564900,0,0,4,54400,'konten_errmentok_20260704_220159_7578.webp',NULL,'live_errmentok_20260704_220159_7578.webp','2026-07-04 22:02:00','2026-07-04 22:02:30','valid','Bagus Kak ermen',NULL,NULL,NULL,0,1140,'ccv_errmentok_20260704_220159_7578.webp'),
(268,35,'haizua',33,'tiktok',2,148100,0,0,2,10600,'konten_haizua_20260704_224006_1843.webp',NULL,'live_haizua_20260704_224006_1843.webp','2026-07-04 22:40:07','2026-07-04 22:40:24','valid','bagus bang',NULL,NULL,NULL,0,220,'ccv_haizua_20260704_224006_1843.webp'),
(269,36,'radagelo',34,'tiktok',12,209000,0,0,2,1400,'konten_radagelo_20260704_230335_5576.webp',NULL,'live_radagelo_20260704_230335_5576.webp','2026-07-04 23:03:35','2026-07-04 23:04:02','valid','bagus',NULL,NULL,NULL,0,17,'ccv_radagelo_20260704_230335_5576.webp'),
(270,38,'Panjiwcs ',36,'tiktok',15,178000,0,0,3,3400,'konten_panjiwcs__20260704_233648_5897.webp',NULL,'live_panjiwcs__20260704_233648_5897.webp','2026-07-04 23:36:49','2026-07-21 14:23:34','valid','Keren bang',NULL,NULL,NULL,0,37,'ccv_panjiwcs__20260704_233648_5897.webp'),
(271,37,'Rusli',35,'tiktok',4,166800,0,0,0,0,'konten_rusli_20260704_233847_8613.webp',NULL,'live_rusli_20260704_233847_8613.webp','2026-07-04 23:38:47','2026-07-04 23:41:33','valid','bagus bang',NULL,NULL,NULL,0,0,'ccv_rusli_20260704_233847_8613.webp'),
(279,3,'kaiser',11,'tiktok',5,200000,0,0,6,50000,'https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/konten_kaiser_20260720_232556_7584.png',NULL,'https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/live_kaiser_20260720_232556_7584.png','2026-07-20 23:25:57','2026-07-20 23:31:23','valid','',NULL,NULL,NULL,0,1400,'https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/ccv_kaiser_20260720_232556_7584.png'),
(286,3,'kaiser',11,'youtube',5,20000,4,40000,0,0,'https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/konten_kaiser_20260731_060358_9408.png','https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/shorts_kaiser_20260731_060358_9408.png','https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/live_kaiser_20260731_060358_9408.png','2026-07-31 06:04:00','2026-08-01 15:18:31','pending','Bagus bang kaiser, kedepannya kita akan kolaborasi dgn anime ..... nnti. ada reward berupa uang dan jaket aot',NULL,NULL,NULL,1,0,'https://jmiarzipxfkbkusuafls.supabase.co/storage/v1/object/public/kreator-hub/laporan/ccv_kaiser_20260731_060358_9408.png');
/*!40000 ALTER TABLE `laporan_mingguan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `media_kreator`
--

DROP TABLE IF EXISTS `media_kreator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_kreator` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kreator_id` int(11) unsigned NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_kreator`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `media_kreator` WRITE;
/*!40000 ALTER TABLE `media_kreator` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_kreator` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2026-04-06-041935','App\\Database\\Migrations\\KreatorAndMedia','default','App',1783086887,1),
(2,'2026-04-06-045058','App\\Database\\Migrations\\LaporanMingguan','default','App',1783086887,1),
(3,'2026-04-06-045742','App\\Database\\Migrations\\AddStatus','default','App',1783086887,1),
(4,'2026-04-06-052117','App\\Database\\Migrations\\CreateUsersTable','default','App',1783086887,1),
(5,'2026-04-06-091949','App\\Database\\Migrations\\AddUserIdToLaporan','default','App',1783086887,1),
(6,'2026-04-06-101216','App\\Database\\Migrations\\AddIdGameToUsers','default','App',1783086887,1),
(7,'2026-04-11-061919','App\\Database\\Migrations\\AddCcvToLaporanMingguan','default','App',1783086887,1),
(8,'2026-04-13-095744','App\\Database\\Migrations\\AddSocialLinksToKreator','default','App',1783086887,1),
(9,'2026-04-13-102800','App\\Database\\Migrations\\AddPlatformToLaporan','default','App',1783086887,1),
(10,'2026-04-13-103900','App\\Database\\Migrations\\AddAdminMessageToLaporan','default','App',1783086887,1),
(11,'2026-04-13-110700','App\\Database\\Migrations\\AddShortsToLaporan','default','App',1783086887,1),
(12,'2026-04-13-124348','App\\Database\\Migrations\\SettingsTable','default','App',1783086887,1),
(13,'2026-04-13-124359','App\\Database\\Migrations\\CascadeDeletes','default','App',1783086887,1),
(14,'2026-04-15-070000','App\\Database\\Migrations\\AddLastUidUpdateToKreator','default','App',1783086887,1),
(15,'2026-04-20-064153','App\\Database\\Migrations\\AddStatusToKreator','default','App',1783086887,1),
(16,'2026-06-05-152400','App\\Database\\Migrations\\RenameEmailToNoTelp','default','App',1783086887,1),
(17,'2026-06-05-161800','App\\Database\\Migrations\\CreateRedeemCodesTable','default','App',1783086887,1),
(18,'2026-06-15-153900','App\\Database\\Migrations\\AddUniqueIndexIdGame','default','App',1783086887,1),
(19,'2026-06-15-154200','App\\Database\\Migrations\\CleanDuplicateNoTelpIndex','default','App',1783086887,1),
(20,'2026-06-15-154400','App\\Database\\Migrations\\FixLaporanColumnTypes','default','App',1783086887,1),
(21,'2026-07-03-000000','App\\Database\\Migrations\\RenamePrimaryKeys','default','App',1783097021,2),
(22,'2026-07-03-000001','App\\Database\\Migrations\\RenameRedeemKeys','default','App',1783097302,3),
(23,'2026-08-01-050000','App\\Database\\Migrations\\AddBandingToLaporanAndSuperAdminRole','default','App',1785563728,4),
(24,'2026-08-01-060000','App\\Database\\Migrations\\AddIndexesForPerformance','default','App',1785563728,4),
(25,'2026-08-01-070000','App\\Database\\Migrations\\AddEmailToUsers','default','App',1785567055,5),
(26,'2026-08-01-080000','App\\Database\\Migrations\\AddEmailToKreator','default','App',1785573285,6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `redeem_codes`
--

DROP TABLE IF EXISTS `redeem_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `redeem_codes` (
  `redeem_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `used_by` int(11) unsigned DEFAULT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`redeem_id`),
  UNIQUE KEY `code` (`code`),
  KEY `idx_is_used` (`is_used`),
  KEY `idx_used_by` (`used_by`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redeem_codes`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `redeem_codes` WRITE;
/*!40000 ALTER TABLE `redeem_codes` DISABLE KEYS */;
INSERT INTO `redeem_codes` VALUES
(1,'BS-88CRTN',0,NULL,NULL,1,'2026-06-05 16:26:23','2026-06-05 16:26:23'),
(2,'BS-FRSRR2',1,4,'2026-06-05 16:36:44',1,'2026-06-05 16:29:44','2026-06-05 16:36:44'),
(3,'BS-RQ94K7',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(4,'BS-UJFVM9',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(5,'BS-NBVMR8',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(6,'BS-B68X4P',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(7,'BS-W5DGGJ',1,37,'2026-07-04 23:17:11',1,'2026-06-05 16:29:44','2026-07-04 23:17:11'),
(8,'BS-J8TCKU',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(9,'BS-4S5VJF',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(10,'BS-JQGNGX',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(11,'BS-ACV2MT',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(12,'BS-H6YSQ5',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(13,'BS-VDAMZ7',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(14,'BS-9P23ZD',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(15,'BS-HBDSY8',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(16,'BS-R8XERC',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(17,'BS-7YY8V9',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(18,'BS-F9T75F',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(19,'BS-JYC2EX',0,NULL,NULL,1,'2026-06-05 16:29:44','2026-06-05 16:29:44'),
(20,'BS-WD2DD3',1,39,'2026-07-21 13:58:47',1,'2026-06-05 16:29:44','2026-07-21 13:58:47'),
(21,'BS-YFQUHD',1,38,'2026-07-04 23:28:39',1,'2026-06-05 16:29:44','2026-07-04 23:28:39'),
(22,'BS-WQ3Z8S',1,36,'2026-07-04 22:56:07',1,'2026-06-15 12:30:43','2026-07-04 22:56:07'),
(23,'BS-NMNQCR',1,35,'2026-07-04 22:25:30',1,'2026-06-15 12:30:43','2026-07-04 22:25:30'),
(24,'BS-QQJMKF',1,34,'2026-07-04 21:16:36',1,'2026-06-15 12:30:43','2026-07-04 21:16:36'),
(25,'BS-SHPEQF',1,33,'2026-07-04 14:29:29',1,'2026-06-15 12:30:43','2026-07-04 14:29:29'),
(26,'BS-BFQRYB',1,32,'2026-07-04 14:01:14',1,'2026-06-15 12:30:43','2026-07-04 14:01:14'),
(27,'BS-RBDSRJ',1,31,'2026-07-04 13:33:35',1,'2026-06-15 12:30:43','2026-07-04 13:33:35'),
(28,'BS-BFCN6Z',1,29,'2026-07-03 11:27:52',1,'2026-06-15 12:30:44','2026-07-03 11:27:52'),
(29,'BS-KGA26S',1,30,'2026-07-04 12:20:12',1,'2026-06-15 12:30:44','2026-07-04 12:20:12'),
(31,'BS-HFEHA2',1,5,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(32,'BS-EX877E',1,6,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(33,'BS-FSN69S',1,7,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(34,'BS-MCDHSD',1,8,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(36,'BS-JUBRDS',1,10,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(37,'BS-KTEYF7',1,11,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(38,'BS-R4YJ5D',1,2,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(39,'BS-C9K38F',1,3,'2026-06-15 12:44:15',1,'2026-06-15 12:44:15','2026-06-15 12:44:15'),
(40,'BS-38D91302',1,15,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(41,'BS-7CA5DCDA',1,16,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(42,'BS-5F01FB1B',1,17,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(43,'BS-DB191373',1,18,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(44,'BS-1B880756',1,19,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(45,'BS-B7C83058',1,20,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(46,'BS-063E922A',1,21,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(47,'BS-44594607',1,NULL,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(48,'BS-EF0DB5C6',1,23,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(49,'BS-999AA927',1,12,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(50,'BS-248B5E4D',1,24,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(51,'BS-0DBE2540',1,25,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(52,'BS-49EDC248',1,26,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(53,'BS-081A5A2E',1,27,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(54,'BS-2C6C9646',1,NULL,'2026-05-01 08:30:00',1,'2026-05-01 08:00:00','2026-05-01 08:30:00'),
(55,'BS-YT9RTY',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(56,'BS-FA5J3A',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(57,'BS-9TCT23',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(58,'BS-R28SDY',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(59,'BS-8Y8A6Y',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(60,'BS-GTQQRN',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(61,'BS-E2YW9T',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(62,'BS-P2DZ8V',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(63,'BS-24GA4W',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(64,'BS-R42K8P',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(65,'BS-M9QPQM',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(66,'BS-8FMX4V',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(67,'BS-XARJWC',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(68,'BS-WTHPM3',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(69,'BS-5QWGNJ',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(70,'BS-63TMVF',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(71,'BS-2UAJUF',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(72,'BS-29QZNS',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(73,'BS-558MZ4',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(74,'BS-EJ328U',0,NULL,NULL,39,'2026-07-21 14:58:07','2026-07-21 14:58:07'),
(75,'BS-7TK5BH',0,NULL,NULL,1,'2026-07-22 18:46:59','2026-07-22 18:46:59'),
(76,'BS-Z6J5X7',0,NULL,NULL,1,'2026-07-22 18:47:03','2026-07-22 18:47:03'),
(77,'BS-7273HJ',0,NULL,NULL,1,'2026-07-22 18:55:59','2026-07-22 18:55:59'),
(78,'BS-8VF6U5',0,NULL,NULL,1,'2026-07-22 18:56:05','2026-07-22 18:56:05'),
(79,'BS-ZYUJCT',1,43,'2026-07-30 22:56:32',1,'2026-07-22 18:56:05','2026-07-30 22:56:32'),
(80,'BS-EQBSVN',1,41,'2026-07-27 15:21:33',1,'2026-07-22 18:56:05','2026-07-27 15:21:33'),
(81,'BS-G2G6AN',1,40,'2026-07-22 18:59:22',1,'2026-07-22 18:56:05','2026-07-22 18:59:22'),
(82,'BS-CV2ACK',0,NULL,NULL,1,'2026-07-22 18:56:05','2026-07-22 18:56:05');
/*!40000 ALTER TABLE `redeem_codes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `setting_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sys_key` varchar(100) NOT NULL,
  `sys_value` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `sys_key` (`sys_key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'tier1_ccv','900','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(2,'tier1_yt','40000','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(3,'tier1_tt','80000','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(4,'tier2_ccv','300','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(5,'tier2_yt','20000','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(6,'tier2_tt','50000','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(7,'tier3_ccv','100','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(8,'tier3_yt','10000','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(9,'tier3_tt','30000','2026-04-13 19:44:53','2026-07-31 09:51:42'),
(10,'form_submission_override','1','2026-04-20 12:57:21','2026-08-01 15:30:41');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `id_game` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','super_admin') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `no_telp` (`no_telp`),
  UNIQUE KEY `uq_users_id_game` (`id_game`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin_bs','amkaiser768@gmail.com','081111111111','44423','$2y$10$ghx3MBtsDOBi/q7LqhpZQOnwFLq4qjpVvqpr94B7bEG5N7sM3TcGm','admin',NULL,'2026-08-01 13:53:35'),
(2,'superadmin',NULL,'082222222222','8888888777','$2y$10$rRq.vIRSDWHG81Sex2TkcuCFAta5GyV8NjcrDfguKjpRBil.ud9Wq','super_admin',NULL,'2026-08-01 12:55:47'),
(3,'kaiser','fendy.fendy740@gmail.com','08123142134123','123456','$2y$10$2DkK30kakzj2hf8d54MTj.bZ9Fws4HwhijEIGwya0hYuCK.2wETyG','user','2026-06-05 15:27:49','2026-08-01 15:44:34'),
(4,'Budi',NULL,'0812312351243','31212353342','$2y$10$4ttxEOm5Qjjd4I2anmee8.2QD3nowa7aYB1oMTQ16zYFpncFPZUoW','user','2026-06-05 16:36:44','2026-06-05 16:36:44'),
(6,'errmentok',NULL,'081398765432','100008','$2y$10$cPWNkzW8v/vDgNDhIOwpfugQtikhIP0DnR8s8Z7gudqHvvNDWPxhK','user','2026-06-15 12:44:15','2026-07-04 21:43:13'),
(7,'xval',NULL,'081712345678','100029','$2y$10$C1IpN99pcMFOGi8okgXal.lxeXl/BP/Ve2U6olLgFdkf3lvX1K95S','user','2026-06-15 12:44:15','2026-06-15 12:44:15'),
(8,'aurest',NULL,'081987654321','100001','$2y$10$xVsL1OKvixunsvYG9IQQ7eiUC5ZZIPh6yP8bXiItH42aSZng.xXgK','user','2026-06-15 12:44:15','2026-06-15 12:44:15'),
(9,'benjamin889',NULL,'085212345678','8888888327','$2y$10$jL/DzQ.qlCCrP.NTXOKQWuE8Q4YrGNkZYoXdVLeGCDqSZwfi4vXje','user','2026-06-15 12:44:15','2026-06-15 12:44:15'),
(10,'hans7',NULL,'085787654321','100012','$2y$10$9zUb27se0L21NK3PyG0SH.56hNSfsCboD5U3jtl0mLmkqNzh74eWy','user','2026-06-15 12:44:15','2026-06-15 12:44:15'),
(11,'batman',NULL,'089612345678','8888888106','$2y$10$dnBPdi.719Nixz5K2CXaZO.Y22h.e6aeRRWk73L.BhChSTgSt0032','user','2026-06-15 12:44:15','2026-06-15 12:44:15'),
(12,'fenzy',NULL,'089787654321','100015','$2y$10$pmtgvyjWgarN3ryYgzmBneb2jIglRDfzbEc8Uew6fW1OErN75JAU.','user','2026-06-15 12:44:15','2026-06-15 12:44:15'),
(15,'jerry_tiktok',NULL,'081234560100010','100010','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(17,'feels_gaming',NULL,'081234560100006','100006','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(18,'kaolla',NULL,'081234560100018','100018','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(19,'benjamin_889',NULL,'081234560100003','100003','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(20,'lynch',NULL,'081234560100035','100035','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(21,'paat',NULL,'081234560100013','100013','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(24,'cukup_tampan',NULL,'081234560100004','100004','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(25,'aisyah',NULL,'081234560100016','100016','$2y$10$PRRPZM6vNFW/QEWBdsw1JeMBR3RId6OKkVqOhRc8xNQ6WEmTcu/KW','user','2026-05-01 08:00:00','2026-07-21 14:57:02'),
(26,'tearyu',NULL,'081234560100023','100023','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(27,'vindragon',NULL,'081234560100025','100025','$2y$10$FddjPSS6B/k0ehJvVq/MQOp7BYu13VLXgZAuXNRmCU44Mz3tB4xli','user','2026-05-01 08:00:00','2026-05-01 08:00:00'),
(30,'emjeluvepep ',NULL,'081265259310','12345678910','$2y$10$0jxwtXbB5XIBDv3DxeNnmeIbkMBQNfxoqtYlkf48zbG8aAdeG3sua','user','2026-07-04 12:20:12','2026-07-04 12:20:12'),
(31,'Mizy',NULL,'0895701261864','586014813642','$2y$10$RahGaMMWMrWMg2F8YPRxV.YWYc2.xm6e2bypxFTotTtWD4ZyE/8DK','user','2026-07-04 13:33:35','2026-07-04 13:33:35'),
(32,'hanscream11',NULL,'087724416660','586024048389','$2y$10$c7u0kRnC7X4SxV.JRpkZc.UzbQqdSw3Uyh2.RoYPTTdsCD6ys2Mjq','user','2026-07-04 14:01:14','2026-07-04 14:02:10'),
(33,'eLva',NULL,'085137690038','31007018689299','$2y$10$q4ug.WlGpdajzm.GK7J4xuw34ZBmjslGYPyPfB5mQjw4vjvN16DJO','user','2026-07-04 14:29:29','2026-07-21 15:01:43'),
(34,'Valtz strike',NULL,'081527573278','586014366028','$2y$10$6KhweWB8riEcV122YbLbOuEUTVQtNO/VuSpimULxzAM5AScMrzEQC','user','2026-07-04 21:16:36','2026-07-04 21:16:36'),
(35,'haizua',NULL,'089672808153','586016851413','$2y$10$e1a7JGNovQcFf/e1TwhtO.N2aRmTZfH0yk3VojuwyGhF7kp2aWMRu','user','2026-07-04 22:25:30','2026-07-04 22:25:30'),
(36,'radagelo',NULL,'085323428717','586024730751','$2y$10$Pph2UOr.K2o19bqchImnYOxIcpTTy1io6zUwFSf0oeDeYCVeYxDMu','user','2026-07-04 22:56:07','2026-07-04 22:57:31'),
(37,'Rusli',NULL,'085880221680','313295314797','$2y$10$qHOKsxbyB.Rf7Hu/q5IuHe82VzcM3VDxsOyn3X14yBa6UhxDpqjTC','user','2026-07-04 23:17:11','2026-07-04 23:23:55'),
(38,'Panjiwcs ',NULL,'085793900267','310062264557','$2y$10$Kyi.KhyVR0KAh8j4O1swRudPI2Mxpl4y.ODBvefFLyuY4Vv7iLc4q','user','2026-07-04 23:28:39','2026-07-04 23:28:39'),
(39,'MiminBS',NULL,'081113804767','51123456789012','$2y$10$zgTYyUwE00HK8XQscn2OYO7SXMBNLYIW0e3MUFXEnLJR9c1FOqFea','admin','2026-07-21 13:58:47','2026-07-21 15:01:02'),
(42,'melyanto',NULL,'085393552116','88992387782','$2y$10$UPnCxNEqwCcdbAwPMiWwe.eAKWjSyCDi5Z1xacJ53CoxcT.lVujvi','user','2026-07-30 10:13:19','2026-07-30 10:13:19'),
(43,'akuntesting',NULL,'081231342354','88849562341','$2y$10$eAyOzGitTqObW04h8MG.nuIrPTJRy.0iXeDSG96zeAuId8HDS6tde','user','2026-07-30 22:56:32','2026-07-30 22:56:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-08-02  9:25:29
