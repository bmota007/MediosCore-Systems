/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.23-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: medios_core_db
-- ------------------------------------------------------
-- Server version	10.6.23-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `extensions`
--

DROP TABLE IF EXISTS `extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context` varchar(80) NOT NULL,
  `exten` varchar(40) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `app` varchar(40) NOT NULL,
  `appdata` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `context` (`context`),
  KEY `exten` (`exten`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extensions`
--

LOCK TABLES `extensions` WRITE;
/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
INSERT INTO `extensions` VALUES (1,'pronto-main','s',1,'Answer',''),(2,'pronto-main','s',2,'Background','custom/pronto-lang-menu'),(3,'pronto-main','s',3,'WaitExten','10'),(4,'pronto-main','1',1,'Goto','pronto-en,s,1'),(5,'pronto-main','2',1,'Goto','pronto-es,s,1'),(6,'pronto-en','s',1,'Set','CHANNEL(language)=en'),(7,'pronto-en','s',2,'Background','custom/pronto-en-menu'),(8,'pronto-en','1',1,'Dial','SIP/pronto-sales,20'),(9,'pronto-es','s',1,'Set','CHANNEL(language)=es'),(10,'pronto-es','s',2,'Background','custom/pronto-es-menu'),(11,'pronto-es','1',1,'Dial','SIP/pronto-sales,20'),(12,'prowork-main','s',1,'Answer',''),(13,'prowork-main','s',2,'Background','custom/prowork-lang-menu'),(14,'prowork-main','s',3,'WaitExten','10'),(15,'prowork-main','1',1,'Goto','prowork-en,s,1'),(16,'prowork-main','2',1,'Goto','prowork-es,s,1'),(17,'prowork-en','s',1,'Set','CHANNEL(language)=en'),(18,'prowork-en','s',2,'Background','custom/prowork-en-menu'),(19,'prowork-en','1',1,'Dial','SIP/prowork-sales,20'),(20,'prowork-es','s',1,'Set','CHANNEL(language)=es'),(21,'prowork-es','s',2,'Background','custom/prowork-es-menu'),(22,'prowork-es','1',1,'Dial','SIP/prowork-sales,20'),(23,'mc-main','s',1,'Answer',''),(24,'mc-main','s',2,'Set','CHANNEL(language)=en'),(25,'mc-main','s',3,'Wait','1'),(26,'mc-main','s',4,'Background','custom/mc-main-greeting'),(27,'mc-main','s',5,'WaitExten','10'),(28,'mc-main','1',1,'Goto','mc-en,s,1'),(29,'mc-main','2',1,'Goto','mc-es,s,1'),(30,'mc-main','9',1,'Goto','mc-main,s,1'),(31,'mc-main','t',1,'Goto','mc-main,s,1'),(32,'mc-main','i',1,'Playback','pbx-invalid'),(33,'mc-main','i',2,'Goto','mc-main,s,1'),(34,'mc-en','s',1,'Set','CHANNEL(language)=en'),(35,'mc-en','s',2,'Background','custom/mc-en-menu'),(36,'mc-en','s',3,'WaitExten','10'),(37,'mc-en','1',1,'Playback','custom/mc-en-websites'),(38,'mc-en','1',2,'VoiceMail','1101@medioscorp,u'),(39,'mc-en','1',3,'Hangup',''),(40,'mc-en','2',1,'Playback','custom/mc-en-pbx'),(41,'mc-en','2',2,'VoiceMail','1102@medioscorp,u'),(42,'mc-en','2',3,'Hangup',''),(43,'mc-en','3',1,'Playback','custom/mc-en-streaming'),(44,'mc-en','3',2,'VoiceMail','1103@medioscorp,u'),(45,'mc-en','3',3,'Hangup',''),(46,'mc-en','4',1,'Playback','custom/mc-en-support'),(47,'mc-en','4',2,'VoiceMail','1104@medioscorp,u'),(48,'mc-en','4',3,'Hangup',''),(49,'mc-en','5',1,'Playback','custom/mc-en-billing'),(50,'mc-en','5',2,'VoiceMail','1105@medioscorp,u'),(51,'mc-en','5',3,'Hangup',''),(52,'mc-es','s',1,'Set','CHANNEL(language)=es'),(53,'mc-es','s',2,'Background','custom/mc-es-menu'),(54,'mc-es','s',3,'WaitExten','10'),(55,'mc-es','1',1,'Playback','custom/mc-es-websites'),(56,'mc-es','1',2,'VoiceMail','2101@medioscorp,u'),(57,'mc-es','1',3,'Hangup',''),(58,'mc-es','2',1,'Playback','custom/mc-es-pbx'),(59,'mc-es','2',2,'VoiceMail','2102@medioscorp,u'),(60,'mc-es','2',3,'Hangup',''),(61,'mc-es','3',1,'Playback','custom/mc-es-streaming'),(62,'mc-es','3',2,'VoiceMail','2103@medioscorp,u'),(63,'mc-es','3',3,'Hangup',''),(64,'mc-es','4',1,'Playback','custom/mc-es-support'),(65,'mc-es','4',2,'VoiceMail','2104@medioscorp,u'),(66,'mc-es','4',3,'Hangup',''),(67,'mc-es','5',1,'Playback','custom/mc-es-billing'),(68,'mc-es','5',2,'VoiceMail','2105@medioscorp,u'),(69,'mc-es','5',3,'Hangup',''),(70,'mcs-main','s',1,'Answer',''),(71,'mcs-main','s',2,'Wait','1'),(72,'mcs-main','s',3,'Background','custom/her-main-greeting'),(73,'mcs-main','s',4,'WaitExten','10'),(74,'mcs-main','1',1,'Goto','mcs-en,s,1'),(75,'mcs-main','2',1,'Goto','mcs-es,s,1'),(76,'mcs-en','s',1,'Set','CHANNEL(language)=en'),(77,'mcs-en','s',2,'Wait','1'),(78,'mcs-en','s',3,'Background','custom/her-en-menu'),(79,'mcs-en','s',4,'WaitExten','10'),(80,'mcs-en','1',1,'Background','custom/her-residential'),(81,'mcs-en','1',2,'VoiceMail','3101@mcintosh,u'),(82,'mcs-en','1',3,'Hangup',''),(83,'mcs-en','2',1,'Background','custom/her-commercial'),(84,'mcs-en','2',2,'VoiceMail','3102@mcintosh,u'),(85,'mcs-en','2',3,'Hangup',''),(86,'mcs-en','3',1,'Background','custom/her-emergency'),(87,'mcs-en','3',2,'VoiceMail','3103@mcintosh,u'),(88,'mcs-en','3',3,'Hangup',''),(89,'mcs-en','4',1,'Background','custom/her-sales'),(90,'mcs-en','4',2,'VoiceMail','3104@mcintosh,u'),(91,'mcs-en','4',3,'Hangup',''),(92,'mcs-es','s',1,'Set','CHANNEL(language)=es'),(93,'mcs-es','s',2,'Wait','1'),(94,'mcs-es','s',3,'Background','custom/her-es-menu'),(95,'mcs-es','s',4,'WaitExten','10'),(96,'mcs-es','1',1,'Background','custom/her-residential-es'),(97,'mcs-es','1',2,'VoiceMail','3201@mcintosh,u'),(98,'mcs-es','1',3,'Hangup',''),(99,'mcs-es','2',1,'Background','custom/her-commercial-es'),(100,'mcs-es','2',2,'VoiceMail','3202@mcintosh,u'),(101,'mcs-es','2',3,'Hangup',''),(102,'mcs-es','3',1,'Background','custom/her-emergency-es'),(103,'mcs-es','3',2,'VoiceMail','3203@mcintosh,u'),(104,'mcs-es','3',3,'Hangup',''),(105,'mcs-es','4',1,'Background','custom/her-sales-es'),(106,'mcs-es','4',2,'VoiceMail','3204@mcintosh,u'),(107,'mcs-es','4',3,'Hangup',''),(108,'maga-main','s',1,'Answer',''),(109,'maga-main','s',2,'Set','CHANNEL(language)=en'),(110,'maga-main','s',3,'Background','custom/maga-welcome'),(111,'maga-main','s',4,'WaitExten','10'),(112,'maga-main','1',1,'Dial','SIP/maga-sales,20'),(113,'maga-main','1',2,'VoiceMail','magasales@default,u'),(114,'maga-main','1',3,'Hangup','');
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incoming_routing`
--

DROP TABLE IF EXISTS `incoming_routing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `incoming_routing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(20) NOT NULL,
  `destination_context` varchar(80) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `did` (`did`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incoming_routing`
--

LOCK TABLES `incoming_routing` WRITE;
/*!40000 ALTER TABLE `incoming_routing` DISABLE KEYS */;
INSERT INTO `incoming_routing` VALUES (1,'12815490674','mc-main','Medios Corporativos'),(2,'12815728322','mcs-main','McIntosh Cleaning'),(3,'15136940005','pronto-en','Pronto Painting'),(4,'15012741821','prowork-main','ProWork Painting');
/*!40000 ALTER TABLE `incoming_routing` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-05  7:26:29
