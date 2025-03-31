-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: flipkart_db
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (41,1,2,1,'2025-03-31 20:40:09','2025-03-31 20:40:09'),(42,1,3,1,'2025-03-31 20:40:10','2025-03-31 20:40:10');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Mobile','Smartphones and feature phones'),(2,'Laptops','Gaming, business, and personal laptops'),(3,'Tablets','Android, iOS, and Windows tablets'),(4,'Televisions','LED, OLED, QLED, and smart TVs'),(5,'Home Appliances','Refrigerators, washing machines, and more'),(6,'Fashion - Men','Clothing, footwear, and accessories for men'),(7,'Fashion - Women','Clothing, footwear, and accessories for women'),(8,'Fashion - Kids','Clothing, footwear, and accessories for kids'),(9,'Beauty & Personal Care','Makeup, skincare, and grooming products'),(10,'Furniture','Beds, sofas, dining sets, and home decor'),(11,'Groceries','Daily essentials, food, and beverages'),(12,'Sports & Fitness','Gym equipment, sports gear, and accessories'),(13,'Toys & Baby Care','Toys, baby diapers, and baby essentials'),(14,'Books','Fiction, non-fiction, and academic books'),(15,'Automotive','Car and bike accessories, spare parts'),(16,'Jewelry','Gold, silver, and fashion jewelry'),(17,'Musical Instruments','Guitars, keyboards, and audio gear'),(18,'Gaming','Consoles, gaming accessories, and video games'),(19,'Cameras & Accessories','DSLRs, mirrorless, and camera accessories'),(20,'Stationery & Office Supplies','Pens, notebooks, and office essentials'),(21,'Tools','some small tools\n');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(5,2) DEFAULT '0.00',
  `category_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image_path` varchar(100) NOT NULL DEFAULT 'admin/uploads/images/apache.png',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'Samsung Galaxy S232','Flagship smartphone with Snapdragon 8 Gen 2',999.01,1.01,1,'2025-03-27 16:06:17','2025-03-31 18:03:02','/admin/uploads/product-images/apache.png'),(3,'OnePlus 11','Premium Android phone with Hasselblad camera',699.99,50.00,1,'2025-03-27 16:06:17','2025-03-31 18:54:03','/admin/uploads/product-images/apache.png'),(4,'Google Pixel 7','Pure Android experience with best-in-class camera',599.99,70.00,1,'2025-03-27 16:06:17','2025-03-31 18:54:10','/admin/uploads/product-images/apache.png'),(5,'MacBook Air M2','Apple MacBook Air with M2 Chip',1199.99,0.00,2,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(6,'Dell XPS 15','Dell premium ultrabook with i7 processor',1499.99,0.00,2,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(7,'HP Spectre x360','Convertible laptop with OLED display',1399.99,0.00,2,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(8,'Asus ROG Strix G15','Gaming laptop with RTX 4070',1799.99,0.00,2,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(9,'iPad Pro 12.9\"','Apple iPad Pro with M2 chip',1099.99,0.00,3,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(10,'Samsung Galaxy Tab S8','Premium Android tablet with AMOLED display',799.99,0.00,3,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(11,'Microsoft Surface Pro 9','2-in-1 laptop-tablet hybrid',999.99,0.00,3,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(12,'Lenovo Tab P11','Budget-friendly Android tablet',349.99,0.00,3,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(13,'Sony Bravia 55-inch 4K','Smart TV with OLED panel',1299.99,0.00,4,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(14,'Samsung QLED 65-inch','4K UHD TV with QLED technology',1499.99,0.00,4,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(15,'LG C2 OLED 48-inch','Premium OLED TV with deep blacks',1199.99,0.00,4,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(16,'TCL 50-inch 4K','Budget-friendly smart TV with Dolby Vision',499.99,0.00,4,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(17,'LG 260L Refrigerator','Frost-free double-door refrigerator',499.99,0.00,5,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(18,'Samsung 7kg Washing Machine','Fully automatic top-load washer',349.99,0.00,5,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(19,'Dyson V12 Vacuum Cleaner','Cordless vacuum with powerful suction',699.99,0.00,5,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(20,'Philips Air Fryer','Oil-free cooking with rapid air technology',199.99,0.00,5,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(21,'Nike Air Max 90','Men’s running shoes with Air cushioning',129.99,0.00,6,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(22,'Levi’s 501 Jeans','Classic straight-fit denim jeans',59.99,0.00,6,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(23,'Puma Sports T-shirt','Breathable activewear for men',29.99,0.00,6,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(24,'Ray-Ban Aviator Sunglasses','Polarized sunglasses for men',149.99,0.00,6,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(25,'Adidas Women’s Jacket','Sportswear jacket for women',89.99,0.00,7,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(26,'Zara Floral Dress','Elegant floral print dress',79.99,0.00,7,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(27,'Michael Kors Handbag','Luxury leather handbag',249.99,0.00,7,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(28,'H&M Cotton T-shirt','Casual round-neck t-shirt',19.99,0.00,7,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(29,'L’Oréal Face Serum','Vitamin C serum for glowing skin',29.99,0.00,9,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(30,'Maybelline Lipstick','Long-lasting matte lipstick',12.99,0.00,9,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(31,'Philips Hair Dryer','Professional hair styling tool',39.99,0.00,9,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(32,'Nivea Body Lotion','Moisturizing body lotion with almond oil',9.99,0.00,9,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(33,'Ikea Sofa Set','Comfortable 3-seater fabric sofa',399.99,0.00,10,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(34,'Wooden Dining Table','6-seater solid wood dining table',699.99,0.00,10,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(35,'Memory Foam Mattress','Orthopedic memory foam mattress',499.99,0.00,10,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(36,'Ergonomic Office Chair','Adjustable office chair with lumbar support',199.99,0.00,10,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(37,'Adidas Football','Official size FIFA-approved football',29.99,0.00,12,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(38,'Yonex Badminton Racket','Carbon graphite racket for professionals',49.99,0.00,12,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(39,'Dumbbell Set (20kg)','Adjustable steel dumbbells',79.99,0.00,12,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(40,'Treadmill - ProForm','Motorized treadmill with digital display',599.99,0.00,12,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(41,'Sony PlayStation 5','Next-gen gaming console',499.99,0.00,18,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(42,'Xbox Series X','Powerful 4K gaming console by Microsoft',499.99,0.00,18,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(43,'Nintendo Switch OLED','Hybrid gaming console',349.99,0.00,18,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(44,'Razer Gaming Mouse','Ergonomic RGB gaming mouse',79.99,0.00,18,'2025-03-27 16:06:17','2025-03-28 15:15:34','/admin/uploads/product-images/apache.png'),(72,'abcs','cas',334.00,21.00,2,'2025-03-31 17:33:50','2025-03-31 17:33:50','/admin/uploads/product-images/Screenshot from 2025-03-12 23-16-32.png'),(73,'abcs','cas',334.00,21.00,2,'2025-03-31 17:34:02','2025-03-31 17:34:02','/admin/uploads/product-images/Screenshot from 2025-03-12 23-16-32.png'),(81,'asdsa','safda',213.00,13.00,1,'2025-03-31 18:00:58','2025-03-31 18:01:06','/admin/uploads/product-images/Screenshot from 2025-03-14 10-24-53.png');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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
INSERT INTO `users` VALUES (1,'admin','admin','admin','admin@example.com','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3','2025-03-19 01:46:13'),(2,'raj','raj','raj','raj@raj.com','raj','2025-03-26 04:09:17'),(3,'jane_smith','Jane','Smith','jane.smith@example.com','securepass','2025-03-24 06:48:03'),(4,'mike_jones','Mike','Jones','mike.jones@example.com','pass1234','2025-03-24 06:48:03'),(5,'sarah_lee','Sarah','Lee','sarah.lee@example.com','mypass','2025-03-24 06:48:03'),(6,'david_clark','David','Clark','david.clark@example.com','password456','2025-03-24 06:48:03'),(7,'emma_white','Emma','White','emma.white@example.com','whitepass','2025-03-24 06:48:03'),(8,'chris_brown','Chris','Brown','chris.brown@example.com','brown123','2025-03-24 06:48:03'),(9,'lisa_wilson','Lisa','Wilson','lisa.wilson@example.com','wilsonpass','2025-03-24 06:48:03'),(10,'jason_miller','Jason','Miller','jason.miller@example.com','millertime','2025-03-24 06:48:03'),(11,'nancy_hall','Nancy','Hall','nancy.hall@example.com','hallpass','2025-03-24 06:48:03'),(12,'tom_adams','Tom','Adams','tom.adams@example.com','tompass','2025-03-24 06:48:03'),(13,'lucas_perez','Lucas','Perez','lucas.perez@example.com','perez123','2025-03-24 06:48:03'),(14,'emma_gonzalez','Emma','Gonzalez','emma.gonzalez@example.com','emmapass','2025-03-24 06:48:03'),(15,'ryan_scott','Ryan','Scott','ryan.scott@example.com','scottpass','2025-03-24 06:48:03'),(16,'olivia_moore','Olivia','Moore','olivia.moore@example.com','moorepass','2025-03-24 06:48:03'),(17,'alex_taylor','Alex','Taylor','alex.taylor@example.com','taylor123','2025-03-24 06:48:03'),(18,'sophia_thomas','Sophia','Thomas','sophia.thomas@example.com','sophiapass','2025-03-24 06:48:03'),(19,'brian_martin','Brian','Martin','brian.martin@example.com','martinpass','2025-03-24 06:48:03'),(20,'zoe_roberts','Zoe','Roberts','zoe.roberts@example.com','zoepass','2025-03-24 06:48:03'),(21,'matthew_anderson','Matthew','Anderson','matthew.anderson@example.com','mattpass','2025-03-24 06:48:03'),(22,'karen_harris','Karen','Harris','karen.harris@example.com','karenpass','2025-03-24 06:48:03'),(23,'steven_morris','Steven','Morris','steven.morris@example.com','stevenpass','2025-03-24 06:48:03'),(24,'jessica_walker','Jessica','Walker','jessica.walker@example.com','jesspass','2025-03-24 06:48:03'),(25,'nathan_carter','Nathan','Carter','nathan.carter@example.com','nathanpass','2025-03-24 06:48:03'),(26,'rebecca_king','Rebecca','King','rebecca.king@example.com','rebeccapass','2025-03-24 06:48:03'),(27,'kevin_mitchell','Kevin','Mitchell','kevin.mitchell@example.com','kevinpass','2025-03-24 06:48:03'),(28,'laura_perez','Laura','Perez','laura.perez@example.com','laurapass','2025-03-24 06:48:03'),(29,'benjamin_cooper','Benjamin','Cooper','benjamin.cooper@example.com','benpass','2025-03-24 06:48:03'),(30,'elizabeth_hall','Elizabeth','Hall','elizabeth.hall@example.com','elizabethpass','2025-03-24 06:48:03'),(31,'daniel_edwards','Daniel','Edwards','daniel.edwards@example.com','danielpass','2025-03-24 06:48:03'),(32,'hannah_turner','Hannah','Turner','hannah.turner@example.com','hannahpass','2025-03-24 06:48:03'),(33,'peter_baker','Peter','Baker','peter.baker@example.com','peterpass','2025-03-24 06:48:03'),(34,'victoria_collins','Victoria','Collins','victoria.collins@example.com','victoriapass','2025-03-24 06:48:03'),(35,'jacob_hill','Jacob','Hill','jacob.hill@example.com','jacobpass','2025-03-24 06:48:03'),(36,'samantha_adams','Samantha','Adams','samantha.adams@example.com','samanthapass','2025-03-24 06:48:03'),(37,'mark_rodriguez','Mark','Rodriguez','mark.rodriguez@example.com','markpass','2025-03-24 06:48:03'),(38,'katie_bennett','Katie','Bennett','katie.bennett@example.com','katiepass','2025-03-24 06:48:03'),(39,'jeffrey_wright','Jeffrey','Wright','jeffrey.wright@example.com','jeffreypass','2025-03-24 06:48:03'),(40,'madison_lopez','Madison','Lopez','madison.lopez@example.com','madisonpass','2025-03-24 06:48:03'),(41,'nicholas_green','Nicholas','Green','nicholas.green@example.com','nicholaspas','2025-03-24 06:48:03');
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

-- Dump completed on 2025-04-01  2:11:35
