-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: flipkart_db
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.20.04.1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Mobiles & Tablets','Latest smartphones, feature phones, and tablets'),(2,'Laptops & Accessorie','Laptops, keyboards, mouse, and other accessories'),(3,'Televisions & Appliances','LED, Smart TVs, refrigerators, washing machines'),(4,'Fashion - Men','Men\'s clothing, footwear, accessories, and more'),(5,'Fashion - Women','Women\'s clothing, footwear, jewelry, and accessories'),(6,'Beauty & Personal Care','Skincare, haircare, and grooming essentials'),(7,'Home & Kitchen','Furniture, decor, kitchen appliances, and essentials'),(8,'Sports & Fitness','Gym equipment, bicycles, outdoor sports gear'),(9,'Toys & Baby Products','Toys, baby clothes, diapers, and more'),(10,'Books & Stationery','Novels, academic books, office supplies'),(11,'Automotive','Car accessories, bike helmets, cleaning supplies'),(12,'Groceries','Fresh fruits, vegetables, packaged food items'),(90,'mobile','sa'),(91,'cxz','xcv'),(94,'u1ykj','jytrjt'),(95,'12','asd'),(96,'aSD','SF');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `uq_user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin','admin@example.com','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3','2025-03-19 07:16:13'),(2,'raj','raj','raj','raj@raj.com','raj','2025-03-26 09:39:17'),(3,'jane_smith','Jane','Smith','jane.smith@example.com','securepass','2025-03-24 12:18:03'),(4,'mike_jones','Mike','Jones','mike.jones@example.com','pass1234','2025-03-24 12:18:03'),(5,'sarah_lee','Sarah','Lee','sarah.lee@example.com','mypass','2025-03-24 12:18:03'),(6,'david_clark','David','Clark','david.clark@example.com','password456','2025-03-24 12:18:03'),(7,'emma_white','Emma','White','emma.white@example.com','whitepass','2025-03-24 12:18:03'),(8,'chris_brown','Chris','Brown','chris.brown@example.com','brown123','2025-03-24 12:18:03'),(9,'lisa_wilson','Lisa','Wilson','lisa.wilson@example.com','wilsonpass','2025-03-24 12:18:03'),(10,'jason_miller','Jason','Miller','jason.miller@example.com','millertime','2025-03-24 12:18:03'),(11,'nancy_hall','Nancy','Hall','nancy.hall@example.com','hallpass','2025-03-24 12:18:03'),(12,'tom_adams','Tom','Adams','tom.adams@example.com','tompass','2025-03-24 12:18:03'),(13,'lucas_perez','Lucas','Perez','lucas.perez@example.com','perez123','2025-03-24 12:18:03'),(14,'emma_gonzalez','Emma','Gonzalez','emma.gonzalez@example.com','emmapass','2025-03-24 12:18:03'),(15,'ryan_scott','Ryan','Scott','ryan.scott@example.com','scottpass','2025-03-24 12:18:03'),(16,'olivia_moore','Olivia','Moore','olivia.moore@example.com','moorepass','2025-03-24 12:18:03'),(17,'alex_taylor','Alex','Taylor','alex.taylor@example.com','taylor123','2025-03-24 12:18:03'),(18,'sophia_thomas','Sophia','Thomas','sophia.thomas@example.com','sophiapass','2025-03-24 12:18:03'),(19,'brian_martin','Brian','Martin','brian.martin@example.com','martinpass','2025-03-24 12:18:03'),(20,'zoe_roberts','Zoe','Roberts','zoe.roberts@example.com','zoepass','2025-03-24 12:18:03'),(21,'matthew_anderson','Matthew','Anderson','matthew.anderson@example.com','mattpass','2025-03-24 12:18:03'),(22,'karen_harris','Karen','Harris','karen.harris@example.com','karenpass','2025-03-24 12:18:03'),(23,'steven_morris','Steven','Morris','steven.morris@example.com','stevenpass','2025-03-24 12:18:03'),(24,'jessica_walker','Jessica','Walker','jessica.walker@example.com','jesspass','2025-03-24 12:18:03'),(25,'nathan_carter','Nathan','Carter','nathan.carter@example.com','nathanpass','2025-03-24 12:18:03'),(26,'rebecca_king','Rebecca','King','rebecca.king@example.com','rebeccapass','2025-03-24 12:18:03'),(27,'kevin_mitchell','Kevin','Mitchell','kevin.mitchell@example.com','kevinpass','2025-03-24 12:18:03'),(28,'laura_perez','Laura','Perez','laura.perez@example.com','laurapass','2025-03-24 12:18:03'),(29,'benjamin_cooper','Benjamin','Cooper','benjamin.cooper@example.com','benpass','2025-03-24 12:18:03'),(30,'elizabeth_hall','Elizabeth','Hall','elizabeth.hall@example.com','elizabethpass','2025-03-24 12:18:03'),(31,'daniel_edwards','Daniel','Edwards','daniel.edwards@example.com','danielpass','2025-03-24 12:18:03'),(32,'hannah_turner','Hannah','Turner','hannah.turner@example.com','hannahpass','2025-03-24 12:18:03'),(33,'peter_baker','Peter','Baker','peter.baker@example.com','peterpass','2025-03-24 12:18:03'),(34,'victoria_collins','Victoria','Collins','victoria.collins@example.com','victoriapass','2025-03-24 12:18:03'),(35,'jacob_hill','Jacob','Hill','jacob.hill@example.com','jacobpass','2025-03-24 12:18:03'),(36,'samantha_adams','Samantha','Adams','samantha.adams@example.com','samanthapass','2025-03-24 12:18:03'),(37,'mark_rodriguez','Mark','Rodriguez','mark.rodriguez@example.com','markpass','2025-03-24 12:18:03'),(38,'katie_bennett','Katie','Bennett','katie.bennett@example.com','katiepass','2025-03-24 12:18:03'),(39,'jeffrey_wright','Jeffrey','Wright','jeffrey.wright@example.com','jeffreypass','2025-03-24 12:18:03'),(40,'madison_lopez','Madison','Lopez','madison.lopez@example.com','madisonpass','2025-03-24 12:18:03'),(41,'nicholas_green','Nicholas','Green','nicholas.green@example.com','nicholaspas','2025-03-24 12:18:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-26 18:15:54