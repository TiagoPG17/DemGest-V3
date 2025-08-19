-- MySQL dump 10.13  Distrib 5.7.44, for Linux (x86_64)
--
-- Host: localhost    Database: demgest
-- ------------------------------------------------------
-- Server version	5.7.44

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
-- Table structure for table `afcs`
--

DROP TABLE IF EXISTS `afcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afcs` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afcs`
--

LOCK TABLES `afcs` WRITE;
/*!40000 ALTER TABLE `afcs` DISABLE KEYS */;
INSERT INTO `afcs` VALUES (1,'COLFONDOS','2025-07-09 18:09:17','2025-07-09 18:09:17'),(2,'FONDO NACIONAL DEL AHORRO','2025-07-09 18:09:17','2025-07-09 18:09:17'),(3,'PORVENIR','2025-07-09 18:09:17','2025-07-09 18:09:17'),(4,'PROTECCIÓN','2025-07-09 18:09:17','2025-07-09 18:09:17');
/*!40000 ALTER TABLE `afcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `afp`
--

DROP TABLE IF EXISTS `afp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afp` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afp`
--

LOCK TABLES `afp` WRITE;
/*!40000 ALTER TABLE `afp` DISABLE KEYS */;
INSERT INTO `afp` VALUES (1,'Protección'),(2,'Porvenir'),(3,'Colfondos'),(4,'Old Mutual');
/*!40000 ALTER TABLE `afp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archivos_adjuntos`
--

DROP TABLE IF EXISTS `archivos_adjuntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archivos_adjuntos` (
  `id` int(10) unsigned NOT NULL,
  `empleado_id` bigint(20) unsigned NOT NULL,
  `beneficiario_id` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos_adjuntos`
--

LOCK TABLES `archivos_adjuntos` WRITE;
/*!40000 ALTER TABLE `archivos_adjuntos` DISABLE KEYS */;
INSERT INTO `archivos_adjuntos` VALUES (2,155,NULL,'1752265986_GFPI-F-165SELECCIONMODIFICACIONALTERNATIVAETAPAPRODUCTIVA2_nuevo (1) (2).xlsx','adjuntos_empleados/155/adjunto1/1752265986_GFPI-F-165SELECCIONMODIFICACIONALTERNATIVAETAPAPRODUCTIVA2_nuevo (1) (2).xlsx','xlsx','2025-07-12 01:33:06','2025-07-12 01:33:06'),(3,155,NULL,'1752265986_BITACORA2.pdf','adjuntos_empleados/155/adjunto2/1752265986_BITACORA2.pdf','pdf','2025-07-12 01:33:06','2025-07-12 01:33:06');
/*!40000 ALTER TABLE `archivos_adjuntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arl`
--

DROP TABLE IF EXISTS `arl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arl` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arl`
--

LOCK TABLES `arl` WRITE;
/*!40000 ALTER TABLE `arl` DISABLE KEYS */;
INSERT INTO `arl` VALUES (1,'ARL Sura'),(2,'ARL Colpatria'),(3,'ARL Bolívar');
/*!40000 ALTER TABLE `arl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barrio`
--

DROP TABLE IF EXISTS `barrio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barrio` (
  `id_barrio` bigint(20) unsigned NOT NULL,
  `nombre_barrio` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barrio`
--

LOCK TABLES `barrio` WRITE;
/*!40000 ALTER TABLE `barrio` DISABLE KEYS */;
INSERT INTO `barrio` VALUES (5,'Aguas Frías',1,NULL,NULL),(6,'Aldea Pablo VI',1,NULL,NULL),(7,'Alejandro Echavarría',1,NULL,NULL),(8,'Alejandría',1,NULL,NULL),(9,'Alfonso López',1,NULL,NULL),(10,'Altamira',1,NULL,NULL),(11,'Altavista',1,NULL,NULL),(12,'Altavista Sector Central',1,NULL,NULL),(13,'Altos del Poblado',1,NULL,NULL),(14,'Andalucía',1,NULL,NULL),(15,'Antonio Nariño',1,NULL,NULL),(16,'Aranjuez',1,NULL,NULL),(17,'Asomadera No.1',1,NULL,NULL),(18,'Asomadera No.2',1,NULL,NULL),(19,'Asomadera No.3',1,NULL,NULL),(20,'Astorga',1,NULL,NULL),(21,'Aures No.1',1,NULL,NULL),(22,'Aures No.2',1,NULL,NULL),(23,'B. Cerro El Volador',1,NULL,NULL),(24,'Barrio Caicedo',1,NULL,NULL),(25,'Barrio Colombia',1,NULL,NULL),(26,'Barrio Colón',1,NULL,NULL),(27,'Barrio Cristóbal',1,NULL,NULL),(28,'Barrios de Jesús',1,NULL,NULL),(29,'Barro Blanco',1,NULL,NULL),(30,'Batallón Cuarta Brigada',1,NULL,NULL),(31,'Batallón Girardot',1,NULL,NULL),(32,'Belalcázar',1,NULL,NULL),(33,'Belencito',1,NULL,NULL),(34,'Bello Horizonte',1,NULL,NULL),(35,'Belén',1,NULL,NULL),(36,'Berlín',1,NULL,NULL),(37,'Bermejal-Los Álamos',1,NULL,NULL),(38,'Betania',1,NULL,NULL),(39,'Blanquizal',1,NULL,NULL),(40,'Bolivariana',1,NULL,NULL),(41,'Bomboná No.1',1,NULL,NULL),(42,'Bomboná No.2',1,NULL,NULL),(43,'Boquerón',1,NULL,NULL),(44,'Bosques de San Pablo',1,NULL,NULL),(45,'Boston',1,NULL,NULL),(46,'Boyacá',1,NULL,NULL),(47,'Brasilia',1,NULL,NULL),(48,'Buenos Aires',1,NULL,NULL),(49,'Buga Patio Bonito',1,NULL,NULL),(50,'Cabecera Urbana Corregimiento San Cristóbal',1,NULL,NULL),(51,'Calasanz',1,NULL,NULL),(52,'Calasanz Parte Alta',1,NULL,NULL),(53,'Calle Nueva',1,NULL,NULL),(54,'Campo Alegre',1,NULL,NULL),(55,'Campo Amor',1,NULL,NULL),(56,'Campo Valdés No.1',1,NULL,NULL),(57,'Campo Valdés No.2',1,NULL,NULL),(58,'Caribe',1,NULL,NULL),(59,'Carlos E. Restrepo',1,NULL,NULL),(60,'Carpinelo',1,NULL,NULL),(61,'Castilla',1,NULL,NULL),(62,'Castropol',1,NULL,NULL),(63,'Cataluña',1,NULL,NULL),(64,'Cementerio Universal',1,NULL,NULL),(65,'Centro Administrativo',1,NULL,NULL),(66,'Cerro Nutibara',1,NULL,NULL),(67,'Corazón de Jesús',1,NULL,NULL),(68,'Cristo Rey',1,NULL,NULL),(69,'Cuarta Brigada',1,NULL,NULL),(70,'Cucaracho',1,NULL,NULL),(71,'Córdoba',1,NULL,NULL),(72,'Diego Echavarría',1,NULL,NULL),(73,'Doce de Octubre No.1',1,NULL,NULL),(74,'Doce de Octubre No.2',1,NULL,NULL),(75,'Ecoparque Cerro El Volador',1,NULL,NULL),(76,'Eduardo Santos',1,NULL,NULL),(77,'El Astillero',1,NULL,NULL),(78,'El Carmelo',1,NULL,NULL),(79,'El Castillo',1,NULL,NULL),(80,'El Cerro',1,NULL,NULL),(81,'El Chagualo',1,NULL,NULL),(82,'El Compromiso',1,NULL,NULL),(83,'El Corazón',1,NULL,NULL),(84,'El Corazón El Morro',1,NULL,NULL),(85,'El Danubio',1,NULL,NULL),(86,'El Diamante',1,NULL,NULL),(87,'El Diamante No.2',1,NULL,NULL),(88,'El Jardín',1,NULL,NULL),(89,'El Llano',1,NULL,NULL),(90,'El Llano SE',1,NULL,NULL),(91,'El Nogal-Los Almendros',1,NULL,NULL),(92,'El Patio',1,NULL,NULL),(93,'El Pesebre',1,NULL,NULL),(94,'El Picacho',1,NULL,NULL),(95,'El Pinal',1,NULL,NULL),(96,'El Placer',1,NULL,NULL),(97,'El Plan',1,NULL,NULL),(98,'El Poblado',1,NULL,NULL),(99,'El Pomar',1,NULL,NULL),(100,'El Progreso',1,NULL,NULL),(101,'El Raizal',1,NULL,NULL),(102,'El Rincón',1,NULL,NULL),(103,'El Rodeo',1,NULL,NULL),(104,'El Salado',1,NULL,NULL),(105,'El Salvador',1,NULL,NULL),(106,'El Socorro',1,NULL,NULL),(107,'El Tesoro',1,NULL,NULL),(108,'El Triunfo',1,NULL,NULL),(109,'El Uvito',1,NULL,NULL),(110,'El Velódromo',1,NULL,NULL),(111,'Enciso',1,NULL,NULL),(112,'Estación Villa',1,NULL,NULL),(113,'Estadio',1,NULL,NULL),(114,'Facultad Veterinaria y Zootecnia U.de.A.',1,NULL,NULL),(115,'Facultad de Minas',1,NULL,NULL),(116,'Facultad de Minas U. Nacional',1,NULL,NULL),(117,'Ferrini',1,NULL,NULL),(118,'Florencia',1,NULL,NULL),(119,'Florida Nueva',1,NULL,NULL),(120,'Francisco Antonio Zea',1,NULL,NULL),(121,'Fuente Clara',1,NULL,NULL),(122,'Fátima',1,NULL,NULL),(123,'Gerona',1,NULL,NULL),(124,'Girardot',1,NULL,NULL),(125,'Granada',1,NULL,NULL),(126,'Granizal',1,NULL,NULL),(127,'Guayabal',1,NULL,NULL),(128,'Guayaquil',1,NULL,NULL),(129,'Hospital San Vicente de Paúl',1,NULL,NULL),(130,'Héctor Abad Gómez',1,NULL,NULL),(131,'Jardín Botánico',1,NULL,NULL),(132,'Jesús Nazareno',1,NULL,NULL),(133,'Juan Pablo II',1,NULL,NULL),(134,'Juan XXIII La Quiebra',1,NULL,NULL),(135,'Kennedy',1,NULL,NULL),(136,'La Aguacatala',1,NULL,NULL),(137,'La Aldea',1,NULL,NULL),(138,'La Alpujarra',1,NULL,NULL),(139,'La América',1,NULL,NULL),(140,'La Avanzada',1,NULL,NULL),(141,'La Candelaria',1,NULL,NULL),(142,'La Castellana',1,NULL,NULL),(143,'La Colina',1,NULL,NULL),(144,'La Cruz',1,NULL,NULL),(145,'La Cuchilla',1,NULL,NULL),(146,'La Esperanza',1,NULL,NULL),(147,'La Esperanza No.2',1,NULL,NULL),(148,'La Floresta',1,NULL,NULL),(149,'La Florida',1,NULL,NULL),(150,'La Francia',1,NULL,NULL),(151,'La Frisola',1,NULL,NULL),(152,'La Frontera',1,NULL,NULL),(153,'La Gloria',1,NULL,NULL),(154,'La Hondonada',1,NULL,NULL),(155,'La Ilusión',1,NULL,NULL),(156,'La Isla',1,NULL,NULL),(157,'La Ladera',1,NULL,NULL),(158,'La Libertad',1,NULL,NULL),(159,'La Loma',1,NULL,NULL),(160,'La Loma de Los Bernal',1,NULL,NULL),(161,'La Mansión',1,NULL,NULL),(162,'La Milagrosa',1,NULL,NULL),(163,'La Mota',1,NULL,NULL),(164,'La Palma',1,NULL,NULL),(165,'La Pilarica',1,NULL,NULL),(166,'La Piñuela',1,NULL,NULL),(167,'La Pradera',1,NULL,NULL),(168,'La Rosa',1,NULL,NULL),(169,'La Salle',1,NULL,NULL),(170,'La Sierra',1,NULL,NULL),(171,'La Sucia',1,NULL,NULL),(172,'La Suiza',1,NULL,NULL),(173,'La Verde',1,NULL,NULL),(174,'Lalinde',1,NULL,NULL),(175,'Las Acacias',1,NULL,NULL),(176,'Las Brisas',1,NULL,NULL),(177,'Las Esmeraldas',1,NULL,NULL),(178,'Las Estancias',1,NULL,NULL),(179,'Las Granjas',1,NULL,NULL),(180,'Las Independencias',1,NULL,NULL),(181,'Las Lomas No.1',1,NULL,NULL),(182,'Las Lomas No.2',1,NULL,NULL),(183,'Las Mercedes',1,NULL,NULL),(184,'Las Palmas',1,NULL,NULL),(185,'Las Playas',1,NULL,NULL),(186,'Las Violetas',1,NULL,NULL),(187,'Laureles',1,NULL,NULL),(188,'Llanaditas',1,NULL,NULL),(189,'Lorena',1,NULL,NULL),(190,'Loreto',1,NULL,NULL),(191,'Los Alcázares',1,NULL,NULL),(192,'Los Alpes',1,NULL,NULL),(193,'Los Balsos No.1',1,NULL,NULL),(194,'Los Balsos No.2',1,NULL,NULL),(195,'Los Cerros El Vergel',1,NULL,NULL),(196,'Los Colores',1,NULL,NULL),(197,'Los Conquistadores',1,NULL,NULL),(198,'Los Mangos',1,NULL,NULL),(199,'Los Naranjos',1,NULL,NULL),(200,'Los Pinos',1,NULL,NULL),(201,'Los Ángeles',1,NULL,NULL),(202,'López de  Mesa',1,NULL,NULL),(203,'Manila',1,NULL,NULL),(204,'Manrique Central No.1',1,NULL,NULL),(205,'Manrique Central No.2',1,NULL,NULL),(206,'Manrique Oriental',1,NULL,NULL),(207,'María Cano-Carambolas',1,NULL,NULL),(208,'Mazo',1,NULL,NULL),(209,'Media Luna',1,NULL,NULL),(210,'Metropolitano',1,NULL,NULL),(211,'Mirador del Doce',1,NULL,NULL),(212,'Miraflores',1,NULL,NULL),(213,'Miranda',1,NULL,NULL),(214,'Miravalle',1,NULL,NULL),(215,'Montañita',1,NULL,NULL),(216,'Monteclaro',1,NULL,NULL),(217,'Moravia',1,NULL,NULL),(218,'Moscú No.1',1,NULL,NULL),(219,'Moscú No.2',1,NULL,NULL),(220,'Naranjal',1,NULL,NULL),(221,'Nueva Villa de La Iguaná',1,NULL,NULL),(222,'Nueva Villa del Aburrá',1,NULL,NULL),(223,'Nuevos Conquistadores',1,NULL,NULL),(224,'Ocho de Marzo',1,NULL,NULL),(225,'Olaya Herrera',1,NULL,NULL),(226,'Oleoducto',1,NULL,NULL),(227,'Oriente',1,NULL,NULL),(228,'Pablo VI',1,NULL,NULL),(229,'Pajarito',1,NULL,NULL),(230,'Palenque',1,NULL,NULL),(231,'Palermo',1,NULL,NULL),(232,'Palmitas Sector Central',1,NULL,NULL),(233,'Parque Juan Pablo II',1,NULL,NULL),(234,'Parque Norte',1,NULL,NULL),(235,'Patio Bonito',1,NULL,NULL),(236,'Pedregal',1,NULL,NULL),(237,'Pedregal Alto',1,NULL,NULL),(238,'Perpetuo Socorro',1,NULL,NULL),(239,'Picachito',1,NULL,NULL),(240,'Picacho',1,NULL,NULL),(241,'Piedra Gorda',1,NULL,NULL),(242,'Piedras Blancas - Matasano',1,NULL,NULL),(243,'Playón de Los Comuneros',1,NULL,NULL),(244,'Plaza de Ferias',1,NULL,NULL),(245,'Popular',1,NULL,NULL),(246,'Potrera Miserenga',1,NULL,NULL),(247,'Potrerito',1,NULL,NULL),(248,'Prado',1,NULL,NULL),(249,'Progreso No.2',1,NULL,NULL),(250,'Robledo',1,NULL,NULL),(251,'Rosales',1,NULL,NULL),(252,'San Antonio',1,NULL,NULL),(253,'San Antonio de Prado',1,NULL,NULL),(254,'San Benito',1,NULL,NULL),(255,'San Bernardo',1,NULL,NULL),(256,'San Diego',1,NULL,NULL),(257,'San Germán',1,NULL,NULL),(258,'San Isidro',1,NULL,NULL),(259,'San Javier No.1',1,NULL,NULL),(260,'San Javier No.2',1,NULL,NULL),(261,'San Joaquín',1,NULL,NULL),(262,'San José',1,NULL,NULL),(263,'San José La Cima No.1',1,NULL,NULL),(264,'San José La Cima No.2',1,NULL,NULL),(265,'San José de La Montaña',1,NULL,NULL),(266,'San José del Manzanillo',1,NULL,NULL),(267,'San Lucas',1,NULL,NULL),(268,'San Martín de Porres',1,NULL,NULL),(269,'San Miguel',1,NULL,NULL),(270,'San Pablo',1,NULL,NULL),(271,'San Pedro',1,NULL,NULL),(272,'Santa Cruz',1,NULL,NULL),(273,'Santa Elena Sector Central',1,NULL,NULL),(274,'Santa Fé',1,NULL,NULL),(275,'Santa Inés',1,NULL,NULL),(276,'Santa Lucía',1,NULL,NULL),(277,'Santa Margarita',1,NULL,NULL),(278,'Santa María de Los Ángeles',1,NULL,NULL),(279,'Santa Mónica',1,NULL,NULL),(280,'Santa Rosa de Lima',1,NULL,NULL),(281,'Santa Teresita',1,NULL,NULL),(282,'Santander',1,NULL,NULL),(283,'Santo Domingo Savio No.1',1,NULL,NULL),(284,'Santo Domingo Savio No.2',1,NULL,NULL),(285,'Sevilla',1,NULL,NULL),(286,'Simón Bolívar',1,NULL,NULL),(287,'Sin Nombre',1,NULL,NULL),(288,'Sucre',1,NULL,NULL),(289,'Suramericana',1,NULL,NULL),(290,'Tejelo',1,NULL,NULL),(291,'Tenche',1,NULL,NULL),(292,'Terminal de Transporte',1,NULL,NULL),(293,'Toscana',1,NULL,NULL),(294,'Travesías',1,NULL,NULL),(295,'Trece de Noviembre',1,NULL,NULL),(296,'Tricentenario',1,NULL,NULL),(297,'Trinidad',1,NULL,NULL),(298,'U.D. Atanasio Girardot',1,NULL,NULL),(299,'U.P.B',1,NULL,NULL),(300,'Universidad Nacional',1,NULL,NULL),(301,'Universidad de Antioquia',1,NULL,NULL),(302,'Urquitá',1,NULL,NULL),(303,'Veinte de Julio',1,NULL,NULL),(304,'Versalles No.1',1,NULL,NULL),(305,'Versalles No.2',1,NULL,NULL),(306,'Villa Carlota',1,NULL,NULL),(307,'Villa Flora',1,NULL,NULL),(308,'Villa Guadalupe',1,NULL,NULL),(309,'Villa Hermosa',1,NULL,NULL),(310,'Villa Lilliam',1,NULL,NULL),(311,'Villa Niza',1,NULL,NULL),(312,'Villa Nueva',1,NULL,NULL),(313,'Villa Turbay',1,NULL,NULL),(314,'Villa del Socorro',1,NULL,NULL),(315,'Villatina',1,NULL,NULL),(316,'Volcana Guayabal',1,NULL,NULL),(317,'Yarumalito',1,NULL,NULL),(318,'Yolombo',1,NULL,NULL),(319,'Área de Expansión Altavista',1,NULL,NULL),(320,'Área de Expansión Belén Rincón',1,NULL,NULL),(321,'Área de Expansión El Noral',1,NULL,NULL),(322,'Área de Expansión Pajarito',1,NULL,NULL),(323,'Área de Expansión San Antonio de Prado',1,NULL,NULL),(324,'Área de Expansión San Cristóbal',1,NULL,NULL);
/*!40000 ALTER TABLE `barrio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficiarios`
--

DROP TABLE IF EXISTS `beneficiarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beneficiarios` (
  `id_beneficiario` bigint(20) unsigned NOT NULL,
  `empleado_id` bigint(20) unsigned NOT NULL,
  `nombre_beneficiario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentesco` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `tipo_documento_id` bigint(20) unsigned DEFAULT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_educativo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reside_con_empleado` tinyint(1) DEFAULT NULL COMMENT '\r\n',
  `depende_economicamente` tinyint(1) DEFAULT NULL,
  `contacto_emergencia` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiarios`
--

LOCK TABLES `beneficiarios` WRITE;
/*!40000 ALTER TABLE `beneficiarios` DISABLE KEYS */;
INSERT INTO `beneficiarios` VALUES (4,84,'marquiños jr','Hijo/a','1995-10-20',2,'8955269254','Secundaria','2025-06-20 19:18:12','2025-06-20 19:18:12',NULL,NULL,NULL),(21,85,'Pepito','Cónyuge','2025-06-11',1,'1477266993','Primaria','2025-06-25 00:55:05','2025-06-25 00:55:05',NULL,NULL,NULL),(55,145,'Pepito','Padre','2023-12-06',1,'87444557','Preescolar','2025-07-08 02:10:15','2025-07-08 02:10:15',1,1,'3692695948'),(58,135,'Pepito','Madre','2023-01-10',2,'3320145149','Primaria','2025-07-09 18:30:11','2025-07-09 18:30:11',1,1,'2147483647'),(63,147,'JAVIER ANTONIO CORDOBA PALENCIA','Cónyuge','1963-03-13',1,'71603765',NULL,'2025-07-09 19:31:45','2025-07-09 19:31:45',1,0,'3154043389'),(64,148,'marquiños jr','Hijo/a','2023-12-14',1,'6345215','Primaria','2025-07-10 00:01:16','2025-07-10 00:01:16',1,1,'3012378915'),(65,149,'XXXXXXXXXXXXXXXXXX','Hijo/a','2024-02-29',1,'2453453745','Primaria','2025-07-12 00:18:04','2025-07-12 00:18:04',1,1,'3001238915');
/*!40000 ALTER TABLE `beneficiarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargo` (
  `id_cargo` bigint(20) unsigned NOT NULL,
  `nombre_cargo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `centro_costo_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'ASESOR',1,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(2,'AUXILIAR ADMINISTRATIVA',1,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(3,'SECRETARIO GENERAL',1,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(4,'DIRECTOR DE PLANEACION FINANCIERA',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(5,'GERENTE',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(6,'GERENTE CORPORATIVA',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(7,'LIDER DE INVESTIGACIÓN DE MERCADOS',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(8,'ANALISTA DE FORMACION Y DESARROLLO',3,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(9,'COORD SEGURIDAD Y SALUD EN EL TRABAJO',3,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(10,'ASISTENTE FINANCIERO',4,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(11,'AUXILIAR CARTERA Y COBRANZAS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(12,'AUXILIAR DE COSTOS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(13,'CONTADOR (A)',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(14,'COORDINADOR DE COSTOS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(15,'DIRECTOR DE CONTABILIDAD',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(16,'LIDER DE COSTOS E INVENTARIOS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(17,'SUPERNUMERARIA',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(18,'ARQUITECTO DE SOFTWARE',6,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(19,'ASISTENTE DE COMPRAS',8,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(20,'ASESOR TECNICO DE NEGOCIOS',9,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(21,'ASISTENTE COMERCIAL',9,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(22,'EJECUTIVO DE CUENTA',10,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(23,'SERVICIO AL CLIENTE',10,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(24,'AUXILIAR DE ALMACENAMIENTO Y DESPACHO',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(25,'AUXILIAR DE BODEGA (ALMACENISTA)',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(26,'AUXILIAR DE FACTURACION Y DESPACHOS',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(27,'IMPRESOR NP1',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(28,'IMPRESOR NP2',13,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(29,'IMPRESOR NP3',14,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(30,'IMPRESORA KOPACK',15,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(31,'AUXILIAR DE IMPRESION',16,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(32,'REBOBINADOR (A)',17,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(33,'COORDINADOR DE IMPRESION',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(34,'AUXILIAR ADMINISTRATIVA',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(35,'OFICIOS VARIOS',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(36,'SERVICIOS GENERALES',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(37,'OPERARIO DE PRODUCCION',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(38,'COORDINADOR DE PRODUCCION',19,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(39,'ELECTROMECANICO',20,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(40,'MECANICO DE MANTENIMIENTO',20,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(41,'OPERARIO MANUAL PREPRENSA',21,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(42,'COORDINADOR PREPENSA',22,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(43,'MONTAJISTA DIGITAL',22,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(44,'ANALISTA DE CALIDAD',23,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(45,'AUXILIAR DE CALIDAD',23,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(46,'COORDINADOR DE PROGRAMACIÓN',24,'2025-07-07 21:52:22','2025-07-07 21:52:22'),(47,'AUXILIAR DE TINTAS',25,'2025-07-07 21:52:22','2025-07-07 21:52:22');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccf`
--

DROP TABLE IF EXISTS `ccf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ccf` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccf`
--

LOCK TABLES `ccf` WRITE;
/*!40000 ALTER TABLE `ccf` DISABLE KEYS */;
INSERT INTO `ccf` VALUES (1,'Comfama'),(2,'Comfenalco'),(3,'Compensar'),(4,'Cafam');
/*!40000 ALTER TABLE `ccf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centro_costos`
--

DROP TABLE IF EXISTS `centro_costos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centro_costos` (
  `id` bigint(20) unsigned NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_costos`
--

LOCK TABLES `centro_costos` WRITE;
/*!40000 ALTER TABLE `centro_costos` DISABLE KEYS */;
INSERT INTO `centro_costos` VALUES (1,'10000','Administración','2025-07-07 21:05:11','2025-07-07 21:05:11'),(2,'10001','Gerencia General','2025-07-07 21:05:11','2025-07-07 21:05:11'),(3,'10002','Gestion Humana','2025-07-07 21:05:11','2025-07-07 21:05:11'),(4,'10003','Gerencia Financiera','2025-07-07 21:05:11','2025-07-07 21:05:11'),(5,'10004','Dirección Contable','2025-07-07 21:05:11','2025-07-07 21:05:11'),(6,'10005','Dirección Sistemas','2025-07-07 21:05:11','2025-07-07 21:05:11'),(7,'10006','Nómina','2025-07-07 21:05:11','2025-07-07 21:05:11'),(8,'10007','Dirección de compras','2025-07-07 21:05:11','2025-07-07 21:05:11'),(9,'20000','Ventas','2025-07-07 21:05:11','2025-07-07 21:05:11'),(10,'20001','Comercial (Vendedores)','2025-07-07 21:05:11','2025-07-07 21:05:11'),(11,'20002','Despachos y bodega','2025-07-07 21:05:11','2025-07-07 21:05:11'),(12,'30001','Impresora NP1','2025-07-07 21:05:11','2025-07-07 21:05:11'),(13,'30002','Impresora NP2','2025-07-07 21:05:11','2025-07-07 21:05:11'),(14,'30003','Impresora NP3','2025-07-07 21:05:11','2025-07-07 21:05:11'),(15,'30004','Impresora Kopack','2025-07-07 21:05:11','2025-07-07 21:05:11'),(16,'30005','Mano de obra directa operarios (aux)','2025-07-07 21:05:11','2025-07-07 21:05:11'),(17,'30006','Mano de obra directa rebobinado','2025-07-07 21:05:11','2025-07-07 21:05:11'),(18,'40000','APOYO PRODUCCION','2025-07-07 21:05:11','2025-07-07 21:05:11'),(19,'40001','Gerencia de planta','2025-07-07 21:05:11','2025-07-07 21:05:11'),(20,'40003','Mantenimiento','2025-07-07 21:05:11','2025-07-07 21:05:11'),(21,'40004','Laboratorio','2025-07-07 21:05:11','2025-07-07 21:05:11'),(22,'40005','Preprensa digital','2025-07-07 21:05:11','2025-07-07 21:05:11'),(23,'40006','Calidad','2025-07-07 21:05:11','2025-07-07 21:05:11'),(24,'40007','Programacion','2025-07-07 21:05:11','2025-07-07 21:05:11'),(25,'40009','Tintas','2025-07-07 21:05:11','2025-07-07 21:05:11');
/*!40000 ALTER TABLE `centro_costos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudades_laborales`
--

DROP TABLE IF EXISTS `ciudades_laborales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudades_laborales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudades_laborales`
--

LOCK TABLES `ciudades_laborales` WRITE;
/*!40000 ALTER TABLE `ciudades_laborales` DISABLE KEYS */;
INSERT INTO `ciudades_laborales` VALUES (1,'medellin',NULL,NULL),(2,'Sabaneta','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ciudades_laborales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `id_departamento` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_departamento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_01_01_000001_create_pais_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `id_pais` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-01 15:06:54
