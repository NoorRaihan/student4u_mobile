-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: student4u
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `assign`
--

DROP TABLE IF EXISTS `assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assign` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `assign_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `assign_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assign`
--

LOCK TABLES `assign` WRITE;
/*!40000 ALTER TABLE `assign` DISABLE KEYS */;
INSERT INTO `assign` VALUES (3,2,''),(4,1,''),(8,2,'');
/*!40000 ALTER TABLE `assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club` (
  `club_id` int(11) NOT NULL AUTO_INCREMENT,
  `club_name` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club`
--

LOCK TABLES `club` WRITE;
/*!40000 ALTER TABLE `club` DISABLE KEYS */;
INSERT INTO `club` VALUES (1,'Compass','0000-00-00','0000-00-00'),(2,'Matics','0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint`
--

DROP TABLE IF EXISTS `complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_desc` varchar(255) NOT NULL,
  `comp_response` varchar(255) DEFAULT NULL,
  `attached_file` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `comp_status` varchar(100) NOT NULL DEFAULT 'IN PROGRESS',
  `user_id` int(11) NOT NULL,
  `hide` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`comp_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `complaint_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint`
--

LOCK TABLES `complaint` WRITE;
/*!40000 ALTER TABLE `complaint` DISABLE KEYS */;
INSERT INTO `complaint` VALUES (5,'cubaan','','','2022-06-18','2022-06-26','APPROVED',3,0),(7,'hnmnbmbnm','not a valid report','../view/uploads/649934bd250ee961d53823bbab39f61c.jpg','2022-06-21','2022-06-25','REJECTED',8,0),(12,'ubah 1\r\nDFGFDGD\r\n\r\nDFGDF\r\nG\r\nDF\r\nGDFGDFGDFGGDFG','yes we received your report','../view/uploads/a6f660d82a2d8fb01ca85c8deed46605.pdf','2022-06-22','2022-06-25','APPROVED',4,0),(13,'tgfdgdfg','','','2022-06-22','2022-06-25','REJECTED',4,1),(14,'ada masalah dekat tandas sr\r\n\r\nbilik: sr116 wing: a','alrite roger that','../view/uploads/complaint/6c6d794829da5fdac6f7635b6f6b401f.jpg','2022-06-26','2022-06-26','APPROVED',4,0),(25,'asdasdsadasda',NULL,'','2022-06-26','2022-06-26','IN PROGRESS',4,1);
/*!40000 ALTER TABLE `complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'student','uitm johor student'),(2,'mpp','uitm segamat mpp');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission`
--

DROP TABLE IF EXISTS `submission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submission` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL,
  `advisor` varchar(255) NOT NULL,
  `sender_role` varchar(255) NOT NULL,
  `attached_file` varchar(255) NOT NULL,
  `subs_response` varchar(255) DEFAULT NULL,
  `returned_file` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `sub_status` varchar(100) NOT NULL DEFAULT 'IN PROGRESS',
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  PRIMARY KEY (`sub_id`),
  KEY `club_id` (`club_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submission_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `submission_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission`
--

LOCK TABLES `submission` WRITE;
/*!40000 ALTER TABLE `submission` DISABLE KEYS */;
INSERT INTO `submission` VALUES (10,'Multimedia Competition Compass','Sir Raihan','Secretary','../view/uploads/paperwork/adabb01d175fd0aa2facbc79d4229f19.txt','donezo','','2022-06-25','2022-06-25','APPROVED',4,2),(11,'Event 1','Sir Raihannn','Project Lead','../view/uploads/paperwork/8a8896aa03acd8007ea7fddb74500372.txt','please redoit again','../view/uploads/return/1e4f817f7c3db600a2bc6c3ae829efef.png','2022-06-25','2022-06-25','REJECTED',4,1),(13,'Event Mewarna','Mdm Syafiqah','Project Lead','../view/uploads/paperwork/e8df6fd4fd65c3a3cb94db0f0234055c.txt','donezo semua tkde masalah','','2022-06-26','2022-06-26','APPROVED',4,1),(20,'asdsa','dassasd','asdsa','../view/uploads/paperwork/763cf70cf2b357adcc8641dd8f763a4e.jpg','good good','','2022-06-26','2022-06-26','APPROVED',4,1);
/*!40000 ALTER TABLE `submission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `matrix_no` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_gender` char(1) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phone` varchar(12) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `user_status` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,2020418738,'Muhammad Imtiaz','M','$argon2i$v=19$m=2048,t=4,p=1$L1Q2L1dNdmh3LjV1bE1Edw$hZAq4UvMIJ95hyXyUz84OqbENoZoi1YWT2hJ7SZoH+8','0143375721','test2@gmail.com','','2022-06-15','2022-06-15','ACTIVE'),(4,2020821002,'Noor Raihan','M','$argon2i$v=19$m=2048,t=4,p=1$Q2VFZ1hvU0lhU1JsVmJpRQ$r3YBci0h03L++6lkVo9Wcs7KjQqX9klUZsMQLuvTuM4','0177387782','blazerred71@gmail.com','','2022-06-15','2022-06-15','ACTIVE'),(6,1234,'TESTT','M','1234','0111','TESTTTT@gmail.com','','0000-00-00','0000-00-00','ACTIVE'),(8,12345678,'test user','M','$argon2i$v=19$m=2048,t=4,p=1$MXJOZXdhelp5dEZTQzg3aQ$48+nKVn89p22KVOgYmJi6+oJ2s5MTMfVfhLUzmjfTUc','0115677783','blazerred71@gmail.com','','2022-06-21','2022-06-21','ACTIVE');
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

-- Dump completed on 2022-06-27  1:28:07