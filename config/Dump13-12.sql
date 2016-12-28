CREATE DATABASE  IF NOT EXISTS `Dstswitch` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `Dstswitch`;
-- MySQL dump 10.13  Distrib 5.5.52, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Dstswitch
-- ------------------------------------------------------
-- Server version	5.5.52-0ubuntu0.14.04.1

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
-- Table structure for table `destiny`
--

DROP TABLE IF EXISTS `destiny`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destiny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destiny`
--

LOCK TABLES `destiny` WRITE;
/*!40000 ALTER TABLE `destiny` DISABLE KEYS */;
INSERT INTO `destiny` VALUES (1,'FijosLocales'),(2,'FijosInterurbanos'),(3,'CelularesUrbanos'),(4,'CelularesInterurbanos'),(5,'Internacionales'),(6,'CeroOchocientos');
/*!40000 ALTER TABLE `destiny` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_dest`
--

DROP TABLE IF EXISTS `grupo_dest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_dest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `id_dest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_dest` (`id_dest`),
  CONSTRAINT `grupo_dest_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `grupo_dest_ibfk_2` FOREIGN KEY (`id_dest`) REFERENCES `destiny` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_dest`
--

LOCK TABLES `grupo_dest` WRITE;
/*!40000 ALTER TABLE `grupo_dest` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_dest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exten`
--
DROP TABLE IF EXISTS `exten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exten` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `extension` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exten`
--

LOCK TABLES `exten` WRITE;
/*!40000 ALTER TABLE `exten` DISABLE KEYS */;
/*!40000 ALTER TABLE `exten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_exten`
--

DROP TABLE IF EXISTS `grupo_exten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_exten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `exten` varchar(45) NOT NULL,
  UNIQUE (`exten`), 
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `grupo_exten_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_exten`
--

LOCK TABLES `grupo_exten` WRITE;
/*!40000 ALTER TABLE `grupo_exten` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_exten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pin`
--

DROP TABLE IF EXISTS `pin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pinNumber` varchar(45) NOT NULL,
  `pinName` varchar(45) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pinNumber_UNIQUE` (`pinNumber`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `pin_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pin`
--

LOCK TABLES `pin` WRITE;
/*!40000 ALTER TABLE `pin` DISABLE KEYS */;
/*!40000 ALTER TABLE `pin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarifa`
--

DROP TABLE IF EXISTS `tarifa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarifa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarifa`
--

LOCK TABLES `tarifa` WRITE;
/*!40000 ALTER TABLE `tarifa` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarifa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarifa_destino`
--

DROP TABLE IF EXISTS `tarifa_destino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarifa_destino` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_destino` int(11) NOT NULL,
  `id_tarifa` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `precio` float(5,2) DEFAULT NULL,
  `precio_minimo` FLOAT(5,2) NULL,
  `tiempo_precio_minimo` INT(11),
  PRIMARY KEY (`id`),
  KEY `id_destino` (`id_destino`),
  KEY `id_tarifa` (`id_tarifa`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `tarifa_destino_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `destiny` (`id`),
  CONSTRAINT `tarifa_destino_ibfk_2` FOREIGN KEY (`id_tarifa`) REFERENCES `tarifa` (`id`),
  CONSTRAINT `tarifa_destino_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarifa_destino`
--

LOCK TABLES `tarifa_destino` WRITE;
/*!40000 ALTER TABLE `tarifa_destino` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarifa_destino` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `pass` blob,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin',aes_encrypt('clave','admin'));
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mycdr`
--

DROP TABLE IF EXISTS `mycdr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mycdr` (
`calldate` datetime NOT NULL,
`src` varchar(80) NOT NULL,
`dst` varchar(80) NOT NULL,
`billsec` int(11) NOT NULL,
`accountcode` varchar(32) NOT NULL,
`userfield` int(11) DEFAULT NULL,
`amount` float(4,2) DEFAULT NULL,
`uniqueid` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-11 18:17:04