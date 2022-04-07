-- MySQL dump 10.13  Distrib 8.0.27, for macos11 (arm64)
--
-- Host: localhost    Database: lawoodfactory
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D4E6F81A76ED395` (`user_id`),
  CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (7,2,'Maison','Lio','Humb',NULL,'21 rue Léon Leman','59960','Neuville en Ferrain','FR','0685014482'),(9,3,'Maison','John','Doe',NULL,'5 rue de la rue','044444','Ma Ville','FR','0607080900'),(10,3,'Travil','John','Doe','Doe Enterprise','14 rue du travail de moi','04440','Job City','FR','0607080900'),(11,6,'Maison','Jane','Doe',NULL,'21 rue de la rue','55555','Une ville','FR','0000000000');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrier`
--

DROP TABLE IF EXISTS `carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrier`
--

LOCK TABLES `carrier` WRITE;
/*!40000 ALTER TABLE `carrier` DISABLE KEYS */;
INSERT INTO `carrier` VALUES (2,'Chronopost','Profitez d\'une livraison le lendemain avant 13h.',23.5),(5,'UPS','Avec ups, profitez d\'une livraison sous 72h.',19.9);
/*!40000 ALTER TABLE `carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526C4584665A` (`product_id`),
  KEY `IDX_9474526C727ACA70` (`parent_id`),
  CONSTRAINT `FK_9474526C4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_9474526C727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (39,2,18,NULL,'Ceci est un commentaire pour cet article.',1,'2022-03-24 13:15:13'),(46,2,15,NULL,'Le top ! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',1,'2022-04-07 05:36:31');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condition`
--

DROP TABLE IF EXISTS `condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condition`
--

LOCK TABLES `condition` WRITE;
/*!40000 ALTER TABLE `condition` DISABLE KEYS */;
INSERT INTO `condition` VALUES (1,'<h1><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</strong></h1>\r\n\r\n<p>Vivamus condimentum pharetra quam, nec feugiat turpis imperdiet id. Nunc est dolor, cursus a tristique vel, tempus quis massa. In lacinia mi quis quam aliquet, non lobortis leo varius. Ut mollis lobortis metus, eu vulputate diam dignissim id. Phasellus vitae arcu vulputate erat suscipit rutrum. Pellentesque gravida lectus nec enim pharetra sodales in in turpis. Sed lorem mi, interdum et tincidunt non, interdum sit amet dui. Donec id rutrum felis. Donec id hendrerit metus. Morbi lacus mi, pulvinar ac mauris quis, scelerisque congue justo. Mauris dapibus nulla ac ultrices tempus. In cursus purus ut aliquet porta. Aenean eleifend arcu sit amet lectus finibus, in dapibus lectus gravida. Donec scelerisque diam sed orci aliquet, in vehicula mi suscipit.</p>\r\n\r\n<p>Vivamus sagittis augue semper augue ultricies ultrices. In risus mi, auctor id risus non, euismod commodo ante. Ut sed felis eu massa facilisis vulputate ut sit amet mi. Fusce in vulputate libero. Duis mattis faucibus ligula vel bibendum. Nam diam diam, gravida ut hendrerit ac, accumsan eget turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam ut ultrices quam. Duis ullamcorper imperdiet quam, vitae pellentesque risus ullamcorper et. Suspendisse potenti. Suspendisse iaculis tristique leo non aliquam. Proin nec quam metus. Etiam imperdiet nec leo id pretium. In maximus non augue nec tincidunt.</p>\r\n\r\n<h1>In aliquet orci et lorem dictum gravida.</h1>\r\n\r\n<h2>Proin metus sem, accumsan et consequat non, imperdiet et elit.</h2>\r\n\r\n<p>Quisque a purus libero. Donec arcu felis, tristique vel porta et, sodales at purus. Pellentesque luctus ligula eu lorem imperdiet, at tempus nisi egestas. Fusce sed sem euismod, aliquam tortor a, vestibulum lectus. Aenean fermentum nisl in egestas venenatis. In hac habitasse platea dictumst. Quisque nunc ante, pretium sit amet vestibulum sit amet, faucibus eget est. Donec molestie tempor nibh, ac tincidunt velit rhoncus in. Donec felis purus, commodo non fringilla eget, elementum nec lacus. Nullam vitae faucibus metus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam tristique pretium consequat. Duis tincidunt felis dui, vitae mattis diam scelerisque eu. Donec efficitur aliquam orci ac finibus.</p>\r\n\r\n<h2>Nulla sit amet fringilla velit. Donec quis iaculis nulla.</h2>\r\n\r\n<p>Donec efficitur, erat nec congue congue, sapien enim lacinia odio, non dapibus ligula orci at lectus. Sed egestas pretium odio, a euismod enim bibendum at. Ut ornare velit nec eros tempus ullamcorper. Ut dignissim fringilla magna ultricies lobortis. Nullam pharetra justo quis felis imperdiet, et dapibus ante suscipit.</p>\r\n\r\n<p>In dapibus dui in purus porttitor tincidunt. Nunc eu urna in arcu tristique sodales sed vitae eros. Mauris laoreet dolor ligula, interdum dictum mi pulvinar et. Morbi viverra nulla massa. Mauris venenatis a leo ut convallis. Sed eget dolor iaculis, tempus sapien at, gravida ex. Vestibulum finibus orci erat, a iaculis velit vulputate ac.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>\r\n\r\n<p>Vivamus condimentum pharetra quam, nec feugiat turpis imperdiet id. Nunc est dolor, cursus a tristique vel, tempus quis massa. In lacinia mi quis quam aliquet, non lobortis leo varius. Ut mollis lobortis metus, eu vulputate diam dignissim id. Phasellus vitae arcu vulputate erat suscipit rutrum. Pellentesque gravida lectus nec enim pharetra sodales in in turpis. Sed lorem mi, interdum et tincidunt non, interdum sit amet dui. Donec id rutrum felis. Donec id hendrerit metus. Morbi lacus mi, pulvinar ac mauris quis, scelerisque congue justo. Mauris dapibus nulla ac ultrices tempus. In cursus purus ut aliquet porta. Aenean eleifend arcu sit amet lectus finibus, in dapibus lectus gravida. Donec scelerisque diam sed orci aliquet, in vehicula mi suscipit.</p>\r\n\r\n<h1>Vivamus sagittis augue semper augue ultricies ultrices.</h1>\r\n\r\n<p>In risus mi, auctor id risus non, euismod commodo ante. Ut sed felis eu massa facilisis vulputate ut sit amet mi. Fusce in vulputate libero. Duis mattis faucibus ligula vel bibendum. Nam diam diam, gravida ut hendrerit ac, accumsan eget turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam ut ultrices quam. Duis ullamcorper imperdiet quam, vitae pellentesque risus ullamcorper et. Suspendisse potenti. Suspendisse iaculis tristique leo non aliquam. Proin nec quam metus. Etiam imperdiet nec leo id pretium. In maximus non augue nec tincidunt.</p>\r\n\r\n<p>In aliquet orci et lorem dictum gravida. Proin metus sem, accumsan et consequat non, imperdiet et elit. Quisque a purus libero. Donec arcu felis, tristique vel porta et, sodales at purus. Pellentesque luctus ligula eu lorem imperdiet, at tempus nisi egestas. Fusce sed sem euismod, aliquam tortor a, vestibulum lectus. Aenean fermentum nisl in egestas venenatis. In hac habitasse platea dictumst. Quisque nunc ante, pretium sit amet vestibulum sit amet, faucibus eget est. Donec molestie tempor nibh, ac tincidunt velit rhoncus in. Donec felis purus, commodo non fringilla eget, elementum nec lacus. Nullam vitae faucibus metus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam tristique pretium consequat. Duis tincidunt felis dui, vitae mattis diam scelerisque eu. Donec efficitur aliquam orci ac finibus.</p>\r\n\r\n<p>Nulla sit amet fringilla velit. Donec quis iaculis nulla. Donec efficitur, erat nec congue congue, sapien enim lacinia odio, non dapibus ligula orci at lectus. Sed egestas pretium odio, a euismod enim bibendum at. Ut ornare velit nec eros tempus ullamcorper. Ut dignissim fringilla magna ultricies lobortis. Nullam pharetra justo quis felis imperdiet, et dapibus ante suscipit.</p>\r\n\r\n<p>In dapibus dui in purus porttitor tincidunt. Nunc eu urna in arcu tristique sodales sed vitae eros. Mauris laoreet dolor ligula, interdum dictum mi pulvinar et. Morbi viverra nulla massa. Mauris venenatis a leo ut convallis. Sed eget dolor iaculis, tempus sapien at, gravida ex. Vestibulum finibus orci erat, a iaculis velit vulputate ac.</p>');
/*!40000 ALTER TABLE `condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220317131851','2022-03-17 14:19:00',52),('DoctrineMigrations\\Version20220317134434','2022-03-17 14:44:41',62),('DoctrineMigrations\\Version20220317203558','2022-03-17 21:36:08',75),('DoctrineMigrations\\Version20220318101948','2022-03-18 11:20:02',77),('DoctrineMigrations\\Version20220318102616','2022-03-18 11:26:24',73),('DoctrineMigrations\\Version20220318195347','2022-03-18 20:53:53',107),('DoctrineMigrations\\Version20220319115221','2022-03-19 12:52:52',73),('DoctrineMigrations\\Version20220319143210','2022-03-19 15:32:18',66),('DoctrineMigrations\\Version20220320133804','2022-03-20 14:38:12',69),('DoctrineMigrations\\Version20220324061946','2022-03-24 07:19:56',110),('DoctrineMigrations\\Version20220324084908','2022-03-24 09:49:18',99),('DoctrineMigrations\\Version20220327092231','2022-03-27 11:22:48',75),('DoctrineMigrations\\Version20220328071222','2022-03-28 09:12:31',69),('DoctrineMigrations\\Version20220328091918','2022-03-28 11:19:32',87),('DoctrineMigrations\\Version20220329113447','2022-03-29 13:34:55',85),('DoctrineMigrations\\Version20220401073559','2022-04-01 09:36:06',65),('DoctrineMigrations\\Version20220401091536','2022-04-01 11:15:44',64),('DoctrineMigrations\\Version20220403070746','2022-04-03 09:07:52',84),('DoctrineMigrations\\Version20220404043813','2022-04-04 06:38:22',80),('DoctrineMigrations\\Version20220404090441','2022-04-04 11:04:48',56),('DoctrineMigrations\\Version20220406123646','2022-04-06 14:38:47',156);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `illustration`
--

DROP TABLE IF EXISTS `illustration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `illustration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D67B9A424584665A` (`product_id`),
  CONSTRAINT `FK_D67B9A424584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `illustration`
--

LOCK TABLES `illustration` WRITE;
/*!40000 ALTER TABLE `illustration` DISABLE KEYS */;
INSERT INTO `illustration` VALUES (12,7,'461d16b846cc0aa17beda37819bf81da.jpg'),(13,8,'02ed97b87a2fc62656848bac0142111d.jpg'),(14,8,'df0b9c1e2e3e3a97806dafdb899c68ef.jpg'),(15,9,'a17241f5f4ba6f9f9183ffc18a2922c3.jpg'),(16,9,'b60a63ed016d4c8ea095be9e868212ec.jpg'),(17,10,'554e579e1b92bc988b4cf330da432527.jpg'),(18,10,'ca7b7ef96a0b8a8402896f8b3fb24854.jpg'),(19,12,'ab575d549e7f112366413687833ea76c.jpg'),(20,12,'33bcb4268f2126dd9c2743f8ae0782c6.jpg'),(21,14,'8fd5fc9c60c2fcfbc9d366dd7961c036.jpg'),(22,15,'03d6f59c3490adf9c8bcd776bb817d80.jpg'),(23,16,'f82ed69e6fe1bbdc96233bc5171b87f1.jpg'),(24,17,'8e6219961fa74b745f2fbfdc7a6b3808.jpg'),(25,17,'10c9c20cadaf237b3153dd5d0e6bbe67.jpg'),(26,18,'bc59b821784e8dd6e2ebf68ad1490c28.jpg'),(27,19,'32be8a7b2024fab4e6842ba5133a933b.jpg'),(28,20,'be26e2f12ae15a378f2eaea23fc4a152.jpg');
/*!40000 ALTER TABLE `illustration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `like`
--

DROP TABLE IF EXISTS `like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `like` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC6340B34584665A` (`product_id`),
  KEY `IDX_AC6340B3A76ED395` (`user_id`),
  CONSTRAINT `FK_AC6340B34584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_AC6340B3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like`
--

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
INSERT INTO `like` VALUES (10,18,2,'2022-03-24 14:41:19'),(11,12,2,'2022-03-27 10:00:15'),(12,15,2,'2022-04-07 05:35:57');
/*!40000 ALTER TABLE `like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `carrier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrier_price` double NOT NULL,
  `delivery` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5299398A76ED395` (`user_id`),
  CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (18,3,'2022-04-01 07:42:52','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246acfcb59d4',NULL,1),(19,3,'2022-04-01 07:46:33','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246add99144c',NULL,1),(20,3,'2022-04-01 07:46:56','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246adf085e37',NULL,1),(21,3,'2022-04-01 07:52:33','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246af419240c',NULL,1),(22,3,'2022-04-01 08:49:30','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bc9a15f66',NULL,1),(23,3,'2022-04-01 08:59:02','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bed63d088',NULL,1),(24,3,'2022-04-01 08:59:50','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bf06a6cbf',NULL,1),(25,3,'2022-04-01 09:00:15','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bf1f85e3a',NULL,2),(26,3,'2022-04-01 09:02:27','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bfa380663',NULL,2),(27,3,'2022-04-01 09:03:19','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bfd75906a',NULL,2),(28,3,'2022-04-01 09:03:30','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bfe2660a8',NULL,2),(29,3,'2022-04-01 09:03:32','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bfe4038e8',NULL,2),(30,3,'2022-04-01 09:03:54','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246bffa0c852',NULL,2),(31,3,'2022-04-01 09:04:17','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246c01115080',NULL,2),(32,3,'2022-04-01 09:05:38','UPS',19.9,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246c0622fb2f',NULL,2),(33,3,'2022-04-01 09:18:05','UPS',19.9,'John Doe<br/>Doe Enterprise<br>14 rue du travail de moi<br>04440 Job City<br>0607080900','01042022-6246c34db3912',NULL,2),(34,3,'2022-04-01 11:43:26','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-6246e55e16fc5','cs_test_b1XYNcgFCQ1l2P0070eMHIUOm4dgmlUQZhIlFM3wYCSVEFaLrcGc2kWzU3',1),(35,3,'2022-04-01 12:28:02','Chronopost',23.5,'John Doe<br/>Doe Enterprise<br>14 rue du travail de moi<br>04440 Job City<br>0607080900','01042022-6246efd24b58a','cs_test_b1Nt3UthEYKC4PE06H3B9FJPreNMUntPe5quhRlwvjaH7umL1ZNKvLnXR0',1),(36,3,'2022-04-01 12:28:39','Chronopost',23.5,'John Doe<br/>Doe Enterprise<br>14 rue du travail de moi<br>04440 Job City<br>0607080900','01042022-6246eff72b450','cs_test_b1XCbBy578GeiIyOXE9cUU9ELdNWAwJFktKkAI2m8OrLXOVI4UDoEJENCS',1),(37,3,'2022-04-01 15:59:05','UPS',19.9,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-624721496df29','cs_test_b14RmE0HL1w0ZR9SMSGu9UvT4wW3I0k7IUbsVnvrAQUhDxHpDqAdjUljYY',1),(38,3,'2022-04-01 17:40:22','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','01042022-624739066f1ef','cs_test_b1ZPX5wzVACd3JxvVXXUmz63jB4dfv0dFbSuf82vNVAFstLKp7C68SS33l',1),(39,3,'2022-04-03 07:24:09','Chronopost',23.5,'John Doe<br/>5 rue de la rue<br>044444 Ma Ville<br>0607080900','03042022-62494b9968da9','cs_test_b1YLVJMKpnDfkLHz8e17RaaMzveRnlZIi3xoN1c8NRKFeVgQOOXiSSFGB0',1),(40,3,'2022-04-03 07:28:08','UPS',19.9,'John Doe<br/>Doe Enterprise<br>14 rue du travail de moi<br>04440 Job City<br>0607080900','03042022-62494c880ca50','cs_test_b1muc2SZqVwkNRu8jP9fh24rTky5ijhA1H7xNyz6erZzN1sxGib0EeqJ1J',4),(41,6,'2022-04-03 11:29:25','UPS',19.9,'Jane Doe<br/>21 rue de la rue<br>55555 Une ville<br>0000000000','03042022-62498515b8d99','cs_test_b1m8zT3zdyf29QXLOtuOvjfqBQqw3BJFUQIzOCKAZmj9xFuGmL7mmvAKoa',3),(42,6,'2022-04-03 11:35:34','Chronopost',23.5,'Jane Doe<br/>21 rue de la rue<br>55555 Une ville<br>0000000000','03042022-624986868110b','cs_test_b1phl8QGo3BBfwb03XpxkrjrZXKRmbGsa2u6lMqVgtvXHHu6NnHOFQz5Tj',3),(43,2,'2022-04-07 05:36:52','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e787434157',NULL,0),(44,2,'2022-04-07 05:38:23','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e78cfb42b6',NULL,0),(45,2,'2022-04-07 05:40:51','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e7963c4e8f',NULL,0),(46,2,'2022-04-07 05:41:36','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e79906a315',NULL,0),(47,2,'2022-04-07 05:42:24','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e79c046ac9',NULL,0),(48,2,'2022-04-07 05:52:53','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e7c35bf8c1',NULL,0),(49,2,'2022-04-07 05:52:57','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e7c3965c21',NULL,0),(50,2,'2022-04-07 05:53:58','UPS',19.9,'Lio Humb<br/>21 rue Léon Leman<br>59960 Neuville en Ferrain<br>0685014482','07042022-624e7c7650e1a','cs_test_b1Q0O6llFWnNoEFLTJ413IRBtVWp7McjK0f2K0V9bM4fxaIXuA98Ejkb6d',1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `my_order_id` int NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_845CA2C1BFCDF877` (`my_order_id`),
  CONSTRAINT `FK_845CA2C1BFCDF877` FOREIGN KEY (`my_order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (32,18,'Le petit cerf',2,12.9,25.8),(33,18,'L\'échelle porte serviette',1,33.9,33.9),(34,18,'Le Spinosaurus',3,9.9,29.7),(35,19,'Le petit cerf',2,12.9,25.8),(36,19,'L\'échelle porte serviette',1,33.9,33.9),(37,19,'Le Spinosaurus',3,9.9,29.7),(38,20,'Le petit cerf',2,12.9,25.8),(39,20,'L\'échelle porte serviette',1,33.9,33.9),(40,20,'Le Spinosaurus',3,9.9,29.7),(41,21,'Le petit cerf',2,12.9,25.8),(42,21,'L\'échelle porte serviette',1,33.9,33.9),(43,21,'Le Spinosaurus',3,9.9,29.7),(44,22,'Le petit cerf',2,12.9,25.8),(45,22,'L\'échelle porte serviette',1,33.9,33.9),(46,22,'Le Spinosaurus',3,9.9,29.7),(47,23,'Le petit cerf',2,12.9,25.8),(48,23,'L\'échelle porte serviette',1,33.9,33.9),(49,23,'Le Spinosaurus',3,9.9,29.7),(50,24,'Le petit cerf',2,12.9,25.8),(51,24,'L\'échelle porte serviette',1,33.9,33.9),(52,24,'Le Spinosaurus',3,9.9,29.7),(53,25,'Le petit cerf',2,12.9,25.8),(54,25,'L\'échelle porte serviette',1,33.9,33.9),(55,25,'Le Spinosaurus',3,9.9,29.7),(56,26,'Le petit cerf',2,12.9,25.8),(57,26,'L\'échelle porte serviette',1,33.9,33.9),(58,26,'Le Spinosaurus',3,9.9,29.7),(59,27,'Le petit cerf',2,12.9,25.8),(60,27,'L\'échelle porte serviette',1,33.9,33.9),(61,27,'Le Spinosaurus',3,9.9,29.7),(62,28,'Le petit cerf',2,12.9,25.8),(63,28,'L\'échelle porte serviette',1,33.9,33.9),(64,28,'Le Spinosaurus',3,9.9,29.7),(65,29,'Le petit cerf',2,12.9,25.8),(66,29,'L\'échelle porte serviette',1,33.9,33.9),(67,29,'Le Spinosaurus',3,9.9,29.7),(68,30,'Le petit cerf',2,12.9,25.8),(69,30,'L\'échelle porte serviette',1,33.9,33.9),(70,30,'Le Spinosaurus',3,9.9,29.7),(71,31,'Le petit cerf',2,12.9,25.8),(72,31,'L\'échelle porte serviette',1,33.9,33.9),(73,31,'Le Spinosaurus',3,9.9,29.7),(74,32,'L\'arche de bébé',2,24.5,49),(75,33,'Le bureau épuré',1,110.5,110.5),(76,34,'Le bureau épuré',2,110.5,221),(77,35,'Le bureau épuré',2,110.5,221),(78,36,'Le bureau épuré',2,110.5,221),(79,37,'Le Jenga',3,19.99,59.97),(80,37,'Le petit cerf',2,12.9,25.8),(81,37,'L\'étagère du plombier',1,99.99,99.99),(82,38,'L\'arche de bébé',1,24.5,24.5),(83,38,'Le Jenga',1,19.99,19.99),(84,38,'La maison de poupée',1,44.9,44.9),(85,39,'Le Jenga',2,19.99,39.98),(86,39,'Le porte cintre',1,36.5,36.5),(87,40,'Le Jenga',3,19.99,59.97),(88,40,'Le porte cintre',1,36.5,36.5),(89,41,'Le Super-Copter',1,9.9,9.9),(90,42,'La maison de poupée',1,44.9,44.9),(91,42,'Le Spinosaurus',2,9.9,19.8),(92,43,'Le Super-Copter',3,9.9,29.7),(93,43,'Le porte cintre',1,36.5,36.5),(94,44,'Le Super-Copter',3,9.9,29.7),(95,44,'Le porte cintre',1,36.5,36.5),(96,45,'Le Super-Copter',3,9.9,29.7),(97,45,'Le porte cintre',1,36.5,36.5),(98,46,'Le Super-Copter',3,9.9,29.7),(99,46,'Le porte cintre',1,36.5,36.5),(100,47,'Le Super-Copter',3,9.9,29.7),(101,47,'Le porte cintre',1,36.5,36.5),(102,48,'Le Super-Copter',3,9.9,29.7),(103,48,'Le porte cintre',1,36.5,36.5),(104,49,'Le Super-Copter',3,9.9,29.7),(105,49,'Le porte cintre',1,36.5,36.5),(106,50,'Le Super-Copter',3,9.9,29.7),(107,50,'Le porte cintre',1,36.5,36.5);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `longueur` double DEFAULT NULL,
  `largeur` double DEFAULT NULL,
  `poids` double DEFAULT NULL,
  `is_best` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (7,'L\'échelle porte serviette','lechelle-porte-serviette','Le porte serviette pour un retour à la nature !','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus pretium dui id leo fermentum convallis. Phasellus scelerisque laoreet arcu ac mollis. Maecenas vulputate nisi ut condimentum sollicitudin. Aliquam erat volutpat. Mauris a odio in velit sagittis ullamcorper quis dignissim quam. Nullam posuere leo viverra erat consectetur venenatis. Proin suscipit nunc interdum mollis sagittis. Donec magna mauris, tempor sit amet malesuada at, bibendum vel enim. Nullam vehicula odio ac mi tristique, in gravida enim lacinia. Donec venenatis risus in fermentum consectetur. Nunc consectetur vel felis sed suscipit.',33.9,'2022-03-20 14:19:16',1,200,40,2.54,0),(8,'Le Jenga','le-jenga','Le jenga fait main !','Nam sit amet imperdiet ligula, in eleifend tellus. Nullam volutpat diam turpis, eget molestie lacus posuere a. In hac habitasse platea dictumst. Mauris massa metus, interdum ac arcu non, porta eleifend odio. Duis maximus volutpat tellus, in consectetur mauris scelerisque vitae. Etiam volutpat erat ipsum, non malesuada lorem mollis a. Morbi tincidunt congue nisi pellentesque iaculis. Vestibulum commodo risus vel pellentesque suscipit. Mauris et nibh in justo placerat vestibulum eget quis est. Suspendisse ac finibus nulla. Morbi dictum facilisis leo, vel convallis libero ornare a. In vitae faucibus libero. Morbi id augue velit.',19.99,'2022-03-20 14:23:46',1,NULL,NULL,3.5,1),(9,'Le Spinosaurus','le-spinosaurus','Bienvenue à Jurassic Wood !','Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut ultricies nulla fermentum est varius, feugiat faucibus diam semper. Praesent et turpis eget ex iaculis consequat sed nec metus. Vivamus sed auctor urna. Proin eu pulvinar lorem. Curabitur at est vel sem vehicula aliquam. Etiam porta felis ut diam vehicula, at dignissim elit vestibulum. Sed dignissim, purus efficitur egestas imperdiet, diam turpis dictum lorem, quis consequat nibh sem eget mi.',9.9,'2022-03-20 14:26:18',1,NULL,NULL,0.5,0),(10,'Le Triceratops','le-triceratops','Bienvenue à Jurassic Wood !','Curabitur orci libero, porta vitae tempus non, pellentesque sit amet diam. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt ligula nec orci consectetur congue. Ut sollicitudin orci eget malesuada condimentum. Pellentesque aliquam nisl arcu, eget condimentum turpis tincidunt vitae. Donec hendrerit ante eu aliquet ullamcorper. Cras nec est lobortis, varius nibh in, porta lectus. In aliquet lacus a scelerisque porttitor. Integer cursus varius tortor sit amet consectetur. Phasellus lacinia est nibh. Quisque diam lectus, gravida et tortor eget, scelerisque sagittis enim. Vivamus volutpat pharetra condimentum.',9.9,'2022-03-20 14:27:37',1,NULL,NULL,0.5,0),(12,'Le Super-Copter','le-super-copter-1','Pour aller sur l\'île de Jurassic Wood !','Proin pretium ipsum sem, nec suscipit augue laoreet vitae. Ut non dui quis augue vehicula tempor. Integer a purus diam. Sed fermentum lectus eget risus consectetur efficitur. Phasellus lacinia lobortis turpis ac dictum. Nulla pulvinar euismod nulla, nec vehicula nunc faucibus vulputate. Duis eros velit, efficitur ut convallis sit amet, posuere vel velit. Praesent gravida non velit feugiat luctus. Nam vestibulum lacus at malesuada luctus. Aenean nec bibendum arcu. Vestibulum ultricies enim ut risus imperdiet, eu scelerisque ipsum tincidunt. Donec iaculis libero eget tellus congue, id auctor nisl semper. Fusce tempus laoreet congue.',9.9,'2022-03-20 14:30:26',1,NULL,NULL,0.5,0),(14,'L\'étagère du plombier','letagere-du-plombier','Entre menuisier et plombier !','Quisque vel cursus metus, vitae posuere est. Vestibulum eget nisi enim. Curabitur blandit lectus metus, a interdum turpis rhoncus sed. In ultrices felis nec sem congue eleifend. Ut vel quam venenatis, faucibus diam at, maximus ex. Maecenas mauris velit, dapibus id vulputate condimentum, eleifend sit amet felis. Suspendisse mollis bibendum mollis. Sed in risus id urna ultrices ornare. Morbi commodo malesuada tellus, in rhoncus ex mollis vel.',99.99,'2022-03-20 14:36:54',1,220,220,22,0),(15,'Le porte cintre','le-porte-cintre','Le porte cintre ficelle, un classique !','Cras in ipsum a odio pulvinar finibus eget eu odio. Vivamus et sagittis tellus. Morbi ac ante sit amet lorem dictum lobortis. Sed fermentum orci quis ex rutrum hendrerit. Nunc ut sagittis augue. Morbi ac augue scelerisque, porttitor sapien eget, sollicitudin ex. Nam vel scelerisque sapien. Mauris dictum tempus odio, at bibendum leo consequat ut. Sed vel ante non risus semper porta a in enim. Morbi pretium ut metus id porta. Ut sed pretium elit. Sed et blandit arcu, sed fermentum sem. Donec et gravida metus, in suscipit nisi. Morbi at consectetur est, a tristique erat.',36.5,'2022-03-20 14:38:14',1,NULL,NULL,1.1,1),(16,'L\'arche de bébé','larche-de-bebe','S\'il s\'appelle Noé c\'est encore mieux !','Maecenas a vestibulum lectus, vel placerat nibh. Donec et rhoncus metus. Nullam mattis diam ac metus pretium egestas. Sed bibendum, quam vitae blandit mattis, ex lorem tincidunt diam, eu congue ipsum metus ac mi. Curabitur varius tortor eget lacus malesuada, sed vestibulum lectus suscipit. Nam velit neque, faucibus varius mauris at, consequat accumsan dolor. Mauris aliquet sit amet nunc nec vulputate. Nullam nec enim magna. Nam sodales metus quam, vitae euismod urna aliquam vitae. Aliquam erat volutpat. Cras sodales augue nec dolor egestas, finibus pellentesque nisl dignissim. Nam et urna mauris.',24.5,'2022-03-20 14:40:33',1,30,60,1.5,0),(17,'La maison de poupée','la-maison-de-poupee','Idéal pour Barbie & Ken !','Donec ultrices purus id risus volutpat, et gravida velit condimentum. Praesent id tincidunt nunc. Aliquam nec purus justo. In hac habitasse platea dictumst. Aenean eu justo mauris. Duis ac rhoncus elit. Aliquam laoreet odio sit amet nisl molestie, rutrum vestibulum turpis egestas. Donec eget accumsan justo.',44.9,'2022-03-20 14:42:21',1,60,50,0.95,0),(18,'Le petit cerf','le-petit-cerf','Bambi à roulette !','Morbi vestibulum enim ac enim laoreet, at elementum justo laoreet. Integer sed pulvinar diam. Pellentesque nec dapibus odio. Sed tincidunt aliquet mattis. Nunc ut mi laoreet, pharetra velit ut, aliquam dolor. Pellentesque nec sodales ipsum, quis aliquam erat. Suspendisse sodales elit et mi tincidunt, sed porttitor ante laoreet. Mauris ac accumsan augue, ac elementum arcu. Nam fringilla et augue vel luctus. Fusce ultricies sollicitudin ipsum, in consequat diam tempor sit amet. Nulla quam tortor, consequat et mauris eget, pellentesque tincidunt lectus. Aliquam dapibus nec libero ac commodo. Curabitur ullamcorper quis orci vel imperdiet.',12.9,'2022-03-20 14:43:31',1,NULL,NULL,0.75,0),(19,'Le banc rustique','le-banc-rustique','Le top des bancs pour poser son chapeau !','Vestibulum a eros ut nisl efficitur eleifend. Praesent vestibulum convallis risus, quis molestie purus aliquet ut. Integer iaculis lectus non nulla faucibus, non fermentum arcu egestas. Suspendisse sit amet bibendum risus. Sed est lacus, rhoncus a ornare vel, molestie ac enim. Quisque vulputate lorem vitae porttitor varius. Morbi sollicitudin justo elit, vel iaculis neque aliquet sed. Etiam nec dignissim felis, at gravida enim. In dapibus enim felis. Proin at convallis ligula.',39.9,'2022-03-20 14:45:09',1,180,60,2.5,0),(20,'Le bureau épuré','le-bureau-epure','Le bureau idéal pour avoir les idées claires','Nunc et ligula aliquam, varius diam sit amet, congue nisi. Curabitur posuere accumsan lacinia. Maecenas commodo fringilla lobortis. Nulla bibendum volutpat risus quis blandit. Vestibulum pellentesque, lectus at ullamcorper molestie, eros purus ultricies leo, sed varius risus purus nec leo. Donec mattis magna et nulla elementum, quis porttitor metus eleifend. Suspendisse potenti. Cras dignissim quam quis augue elementum auctor. Fusce id nisi mollis, auctor nibh eget, rhoncus leo. Cras quis sem quam. Cras porta quis dui ac tincidunt. Aliquam eu ex quis dolor convallis dictum.',110.5,'2022-03-20 14:46:49',1,150,50,10.9,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9983CE5A76ED395` (`user_id`),
  CONSTRAINT `FK_B9983CE5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password`
--

LOCK TABLES `reset_password` WRITE;
/*!40000 ALTER TABLE `reset_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cguv` tinyint(1) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  FULLTEXT KEY `IDX_8D93D649E7927C7483A00E683124B5B6` (`email`,`firstname`,`lastname`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'helloliohumb@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$VPZxaXecT4ulCLrSOp5f2OshL5Od.xW2N1sMQM5vsOK.EGVdU02de','Lio','Humb',1,NULL,'2022-03-19 09:43:03',1),(3,'john@doe.fr','[\"ROLE_USER\"]','$2y$13$ndzQe63Hiv56qUbEeAhHWOG3ATwa6aOyH87i78EXHKNHCkvpPNIey','John','Doe',1,'<null>','2022-03-29 15:47:55',1),(6,'emailpourtesterdestrucs@gmail.com','[\"ROLE_USER\"]','$2y$13$Vun6DdoXErYEWg2eKWhsEOfO/SIBCgmR97gDiMcAnLhMEQ1fIERYq','Jane','Doe',1,NULL,'2022-04-03 11:27:09',1),(7,'emailpourencoretesterdestrucs@gmail.com','[\"ROLE_USER\"]','$2y$13$H82NYjBAMP9PgMGRRoKTROkOt9eAnnmYdZcRf2i5Hkw8S7dkdLYiW','Tony','Stark',1,NULL,'2022-04-06 09:05:14',1),(8,'rovifel511@yeafam.com','[\"ROLE_USER\"]','$2y$13$CsFzUPQO/hwrqk3Zgy8jI.YQz.wLCBr0WrTGw7oNk1RHl09EDynKe','kjkljlkj','ljkkljl',1,NULL,'2022-04-07 06:10:34',1),(9,'mekedo7528@vsooc.com','[\"ROLE_USER\"]','$2y$13$/ZeMUJMp1XDFyV46Zlax/uposx97dlG.rFvmdCKm6QvYCG..zW2dq','testeur','klfldclks',1,NULL,'2022-04-07 06:13:24',1),(10,'vetov40249@yeafam.com','[\"ROLE_USER\"]','$2y$13$mB54VEvJ55GI19OOqTtnLONpZX/wiaMTBrqvP.gfPSp1ZoPEO/SuG','testeur2','lkjlkj',1,NULL,'2022-04-07 06:15:32',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-07 10:27:37
