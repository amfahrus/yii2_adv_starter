-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: daycare
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('Root','1',1501315218),('Root','2',1501319453);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1501315007,1501315007),('/admin/*',2,NULL,NULL,NULL,1501314991,1501314991),('/admin/assignment/*',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/assignment/assign',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/assignment/index',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/assignment/revoke',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/assignment/view',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/default/*',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/default/index',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/menu/*',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/menu/create',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/menu/delete',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/menu/index',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/menu/update',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/menu/view',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/*',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/permission/assign',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/create',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/delete',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/index',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/remove',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/update',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/permission/view',2,NULL,NULL,NULL,1501314989,1501314989),('/admin/role/*',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/assign',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/create',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/delete',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/index',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/remove',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/update',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/role/view',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/route/*',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/route/assign',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/route/create',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/route/index',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/route/refresh',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/route/remove',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/rule/*',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/rule/create',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/rule/delete',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/rule/index',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/rule/update',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/rule/view',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/*',2,NULL,NULL,NULL,1501314991,1501314991),('/admin/user/activate',2,NULL,NULL,NULL,1501314991,1501314991),('/admin/user/change-password',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/delete',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/index',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/login',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/logout',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/reset-password',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/signup',2,NULL,NULL,NULL,1501314990,1501314990),('/admin/user/view',2,NULL,NULL,NULL,1501314990,1501314990),('/debug/*',2,NULL,NULL,NULL,1501314991,1501314991),('/debug/default/*',2,NULL,NULL,NULL,1501314991,1501314991),('/debug/default/db-explain',2,NULL,NULL,NULL,1501314991,1501314991),('/debug/default/download-mail',2,NULL,NULL,NULL,1501314991,1501314991),('/debug/default/index',2,NULL,NULL,NULL,1501314991,1501314991),('/debug/default/toolbar',2,NULL,NULL,NULL,1501314991,1501314991),('/debug/default/view',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/*',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/default/*',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/default/action',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/default/diff',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/default/index',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/default/preview',2,NULL,NULL,NULL,1501314991,1501314991),('/gii/default/view',2,NULL,NULL,NULL,1501314991,1501314991),('/site/*',2,NULL,NULL,NULL,1501315007,1501315007),('/site/error',2,NULL,NULL,NULL,1501315007,1501315007),('/site/index',2,NULL,NULL,NULL,1501315007,1501315007),('/site/login',2,NULL,NULL,NULL,1501315007,1501315007),('/site/logout',2,NULL,NULL,NULL,1501315007,1501315007),('/unit/*',2,NULL,NULL,NULL,1501317978,1501317978),('/unit/create',2,NULL,NULL,NULL,1501317978,1501317978),('/unit/delete',2,NULL,NULL,NULL,1501317978,1501317978),('/unit/index',2,NULL,NULL,NULL,1501317978,1501317978),('/unit/update',2,NULL,NULL,NULL,1501317978,1501317978),('/unit/view',2,NULL,NULL,NULL,1501317978,1501317978),('/userdata-internal/*',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/assign',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/create',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/delete',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/index',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/remove',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/update',2,NULL,NULL,NULL,1501318318,1501318318),('/userdata-internal/view',2,NULL,NULL,NULL,1501318318,1501318318),('Root',1,'Super Admin',NULL,NULL,1501315184,1501315184);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('Root','/*'),('Root','/admin/*'),('Root','/admin/assignment/*'),('Root','/admin/assignment/assign'),('Root','/admin/assignment/index'),('Root','/admin/assignment/revoke'),('Root','/admin/assignment/view'),('Root','/admin/default/*'),('Root','/admin/default/index'),('Root','/admin/menu/*'),('Root','/admin/menu/create'),('Root','/admin/menu/delete'),('Root','/admin/menu/index'),('Root','/admin/menu/update'),('Root','/admin/menu/view'),('Root','/admin/permission/*'),('Root','/admin/permission/assign'),('Root','/admin/permission/create'),('Root','/admin/permission/delete'),('Root','/admin/permission/index'),('Root','/admin/permission/remove'),('Root','/admin/permission/update'),('Root','/admin/permission/view'),('Root','/admin/role/*'),('Root','/admin/role/assign'),('Root','/admin/role/create'),('Root','/admin/role/delete'),('Root','/admin/role/index'),('Root','/admin/role/remove'),('Root','/admin/role/update'),('Root','/admin/role/view'),('Root','/admin/route/*'),('Root','/admin/route/assign'),('Root','/admin/route/create'),('Root','/admin/route/index'),('Root','/admin/route/refresh'),('Root','/admin/route/remove'),('Root','/admin/rule/*'),('Root','/admin/rule/create'),('Root','/admin/rule/delete'),('Root','/admin/rule/index'),('Root','/admin/rule/update'),('Root','/admin/rule/view'),('Root','/admin/user/*'),('Root','/admin/user/activate'),('Root','/admin/user/change-password'),('Root','/admin/user/delete'),('Root','/admin/user/index'),('Root','/admin/user/login'),('Root','/admin/user/logout'),('Root','/admin/user/request-password-reset'),('Root','/admin/user/reset-password'),('Root','/admin/user/signup'),('Root','/admin/user/view'),('Root','/debug/*'),('Root','/debug/default/*'),('Root','/debug/default/db-explain'),('Root','/debug/default/download-mail'),('Root','/debug/default/index'),('Root','/debug/default/toolbar'),('Root','/debug/default/view'),('Root','/gii/*'),('Root','/gii/default/*'),('Root','/gii/default/action'),('Root','/gii/default/diff'),('Root','/gii/default/index'),('Root','/gii/default/preview'),('Root','/gii/default/view'),('Root','/site/*'),('Root','/site/error'),('Root','/site/index'),('Root','/site/login'),('Root','/site/logout'),('Root','/unit/*'),('Root','/unit/create'),('Root','/unit/delete'),('Root','/unit/index'),('Root','/unit/update'),('Root','/unit/view'),('Root','/userdata-internal/*'),('Root','/userdata-internal/assign'),('Root','/userdata-internal/create'),('Root','/userdata-internal/delete'),('Root','/userdata-internal/index'),('Root','/userdata-internal/remove'),('Root','/userdata-internal/update'),('Root','/userdata-internal/view');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Gii',NULL,'/gii/default/index',1,NULL),(2,'Debug',NULL,'/debug/default/index',2,NULL),(3,'RBAC',NULL,NULL,3,NULL),(4,'Route',3,'/admin/route/index',1,NULL),(5,'Permission',3,'/admin/permission/index',2,NULL),(6,'Menu',3,'/admin/menu/index',3,NULL),(7,'Role',3,'/admin/role/index',4,NULL),(8,'Assignment',3,'/admin/assignment/index',5,NULL),(9,'User',3,'/admin/user/index',6,NULL),(10,'Master Unit',NULL,'/unit/index',4,NULL),(11,'User',NULL,'/userdata-internal/index',5,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1501313445),('m130524_201442_init',1501313447),('m140506_102106_rbac_init',1501314306),('m140602_111327_create_menu_table',1501314243),('m160312_050000_create_user',1501314243);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p_master_unit`
--

DROP TABLE IF EXISTS `p_master_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p_master_unit` (
  `p_master_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(45) NOT NULL,
  `unit_code` varchar(45) NOT NULL,
  `unit_status` int(11) NOT NULL,
  `unit_parent` int(11) DEFAULT '0',
  PRIMARY KEY (`p_master_unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p_master_unit`
--

LOCK TABLES `p_master_unit` WRITE;
/*!40000 ALTER TABLE `p_master_unit` DISABLE KEYS */;
INSERT INTO `p_master_unit` VALUES (1,'Domain A','DMA',1,NULL);
/*!40000 ALTER TABLE `p_master_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user_unit`
--

DROP TABLE IF EXISTS `t_user_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user_unit` (
  `t_user_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `p_master_unit_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_user` int(11) NOT NULL DEFAULT '0',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`t_user_unit_id`),
  KEY `fk_t_user_unit_1_idx` (`user_id`),
  KEY `fk_t_user_unit_2_idx` (`p_master_unit_id`),
  CONSTRAINT `fk_t_user_unit_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_user_unit_2` FOREIGN KEY (`p_master_unit_id`) REFERENCES `p_master_unit` (`p_master_unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user_unit`
--

LOCK TABLES `t_user_unit` WRITE;
/*!40000 ALTER TABLE `t_user_unit` DISABLE KEYS */;
INSERT INTO `t_user_unit` VALUES (1,2,1,'2017-07-29 16:10:50',0,'2017-07-29 16:10:50',0);
/*!40000 ALTER TABLE `t_user_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_userdata_internal`
--

DROP TABLE IF EXISTS `t_userdata_internal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_userdata_internal` (
  `t_userdata_internal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(64) DEFAULT NULL,
  `nik` varchar(45) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_user` int(11) NOT NULL DEFAULT '0',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`t_userdata_internal_id`),
  KEY `fk_t_userdata_internal_1_idx` (`user_id`),
  CONSTRAINT `fk_t_userdata_internal_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_userdata_internal`
--

LOCK TABLES `t_userdata_internal` WRITE;
/*!40000 ALTER TABLE `t_userdata_internal` DISABLE KEYS */;
INSERT INTO `t_userdata_internal` VALUES (1,2,'Asep Muhammad Fahrus','1234567','2017-07-29 16:10:45',0,'2017-07-29 16:10:45',0);
/*!40000 ALTER TABLE `t_userdata_internal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','5EbRR4FwogRlFMswpkQgp7SxaKaruqKh','$2y$13$5f4QX3O7VgkTxhYOunpmUO3AbLbeYJu1tJ1W/lKGYa3vO6S8iWqZG',NULL,'amfahrus@yahoo.co.id',10,1501313766,1501313766),(2,'blackwiz','nsH8q4uIj2k3CgnTnPsfo2fSQvcYNXrp','$2y$13$dUPsqx6fLedfZhEwU4bzSOm7nuwxjeu/7kAW3vVgh1LQHLkf6ouA2',NULL,'wiz.stalker@gmail.com',10,1501319445,1501319445);
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

-- Dump completed on 2017-07-29 16:11:42
