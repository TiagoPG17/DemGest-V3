/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: demgest
-- ------------------------------------------------------
-- Server version	5.7.44

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
-- Table structure for table `afcs`
--

DROP TABLE IF EXISTS `afcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `afcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afcs`
--

LOCK TABLES `afcs` WRITE;
/*!40000 ALTER TABLE `afcs` DISABLE KEYS */;
INSERT INTO `afcs` VALUES
(1,'COLFONDOS','2025-07-09 18:09:17','2025-07-09 18:09:17'),
(2,'FONDO NACIONAL DEL AHORRO','2025-07-09 18:09:17','2025-07-09 18:09:17'),
(3,'PORVENIR','2025-07-09 18:09:17','2025-07-09 18:09:17'),
(4,'PROTECCIÓN','2025-07-09 18:09:17','2025-07-09 18:09:17');
/*!40000 ALTER TABLE `afcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `afp`
--

DROP TABLE IF EXISTS `afp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `afp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afp`
--

LOCK TABLES `afp` WRITE;
/*!40000 ALTER TABLE `afp` DISABLE KEYS */;
INSERT INTO `afp` VALUES
(1,'Protección'),
(2,'Porvenir'),
(3,'Colfondos'),
(4,'Old Mutual');
/*!40000 ALTER TABLE `afp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archivos_adjuntos`
--

DROP TABLE IF EXISTS `archivos_adjuntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos_adjuntos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empleado_id` bigint(20) unsigned NOT NULL,
  `beneficiario_id` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_archivos_empleado` (`empleado_id`),
  KEY `fk_archivos_beneficiario` (`beneficiario_id`),
  CONSTRAINT `fk_archivos_beneficiario` FOREIGN KEY (`beneficiario_id`) REFERENCES `beneficiarios` (`id_beneficiario`) ON DELETE CASCADE,
  CONSTRAINT `fk_archivos_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos_adjuntos`
--

LOCK TABLES `archivos_adjuntos` WRITE;
/*!40000 ALTER TABLE `archivos_adjuntos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos_adjuntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arl`
--

DROP TABLE IF EXISTS `arl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `arl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arl`
--

LOCK TABLES `arl` WRITE;
/*!40000 ALTER TABLE `arl` DISABLE KEYS */;
INSERT INTO `arl` VALUES
(1,'ARL Sura'),
(2,'ARL Colpatria'),
(3,'ARL Bolívar');
/*!40000 ALTER TABLE `arl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barrio`
--

DROP TABLE IF EXISTS `barrio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `barrio` (
  `id_barrio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_barrio` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_barrio`),
  KEY `barrio_municipio_id_foreign` (`municipio_id`),
  CONSTRAINT `barrio_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id_municipio`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barrio`
--

LOCK TABLES `barrio` WRITE;
/*!40000 ALTER TABLE `barrio` DISABLE KEYS */;
INSERT INTO `barrio` VALUES
(5,'Aguas Frías',1,NULL,NULL),
(6,'Aldea Pablo VI',1,NULL,NULL),
(7,'Alejandro Echavarría',1,NULL,NULL),
(8,'Alejandría',1,NULL,NULL),
(9,'Alfonso López',1,NULL,NULL),
(10,'Altamira',1,NULL,NULL),
(11,'Altavista',1,NULL,NULL),
(12,'Altavista Sector Central',1,NULL,NULL),
(13,'Altos del Poblado',1,NULL,NULL),
(14,'Andalucía',1,NULL,NULL),
(15,'Antonio Nariño',1,NULL,NULL),
(16,'Aranjuez',1,NULL,NULL),
(17,'Asomadera No.1',1,NULL,NULL),
(18,'Asomadera No.2',1,NULL,NULL),
(19,'Asomadera No.3',1,NULL,NULL),
(20,'Astorga',1,NULL,NULL),
(21,'Aures No.1',1,NULL,NULL),
(22,'Aures No.2',1,NULL,NULL),
(23,'B. Cerro El Volador',1,NULL,NULL),
(24,'Barrio Caicedo',1,NULL,NULL),
(25,'Barrio Colombia',1,NULL,NULL),
(26,'Barrio Colón',1,NULL,NULL),
(27,'Barrio Cristóbal',1,NULL,NULL),
(28,'Barrios de Jesús',1,NULL,NULL),
(29,'Barro Blanco',1,NULL,NULL),
(30,'Batallón Cuarta Brigada',1,NULL,NULL),
(31,'Batallón Girardot',1,NULL,NULL),
(32,'Belalcázar',1,NULL,NULL),
(33,'Belencito',1,NULL,NULL),
(34,'Bello Horizonte',1,NULL,NULL),
(35,'Belén',1,NULL,NULL),
(36,'Berlín',1,NULL,NULL),
(37,'Bermejal-Los Álamos',1,NULL,NULL),
(38,'Betania',1,NULL,NULL),
(39,'Blanquizal',1,NULL,NULL),
(40,'Bolivariana',1,NULL,NULL),
(41,'Bomboná No.1',1,NULL,NULL),
(42,'Bomboná No.2',1,NULL,NULL),
(43,'Boquerón',1,NULL,NULL),
(44,'Bosques de San Pablo',1,NULL,NULL),
(45,'Boston',1,NULL,NULL),
(46,'Boyacá',1,NULL,NULL),
(47,'Brasilia',1,NULL,NULL),
(48,'Buenos Aires',1,NULL,NULL),
(49,'Buga Patio Bonito',1,NULL,NULL),
(50,'Cabecera Urbana Corregimiento San Cristóbal',1,NULL,NULL),
(51,'Calasanz',1,NULL,NULL),
(52,'Calasanz Parte Alta',1,NULL,NULL),
(53,'Calle Nueva',1,NULL,NULL),
(54,'Campo Alegre',1,NULL,NULL),
(55,'Campo Amor',1,NULL,NULL),
(56,'Campo Valdés No.1',1,NULL,NULL),
(57,'Campo Valdés No.2',1,NULL,NULL),
(58,'Caribe',1,NULL,NULL),
(59,'Carlos E. Restrepo',1,NULL,NULL),
(60,'Carpinelo',1,NULL,NULL),
(61,'Castilla',1,NULL,NULL),
(62,'Castropol',1,NULL,NULL),
(63,'Cataluña',1,NULL,NULL),
(64,'Cementerio Universal',1,NULL,NULL),
(65,'Centro Administrativo',1,NULL,NULL),
(66,'Cerro Nutibara',1,NULL,NULL),
(67,'Corazón de Jesús',1,NULL,NULL),
(68,'Cristo Rey',1,NULL,NULL),
(69,'Cuarta Brigada',1,NULL,NULL),
(70,'Cucaracho',1,NULL,NULL),
(71,'Córdoba',1,NULL,NULL),
(72,'Diego Echavarría',1,NULL,NULL),
(73,'Doce de Octubre No.1',1,NULL,NULL),
(74,'Doce de Octubre No.2',1,NULL,NULL),
(75,'Ecoparque Cerro El Volador',1,NULL,NULL),
(76,'Eduardo Santos',1,NULL,NULL),
(77,'El Astillero',1,NULL,NULL),
(78,'El Carmelo',1,NULL,NULL),
(79,'El Castillo',1,NULL,NULL),
(80,'El Cerro',1,NULL,NULL),
(81,'El Chagualo',1,NULL,NULL),
(82,'El Compromiso',1,NULL,NULL),
(83,'El Corazón',1,NULL,NULL),
(84,'El Corazón El Morro',1,NULL,NULL),
(85,'El Danubio',1,NULL,NULL),
(86,'El Diamante',1,NULL,NULL),
(87,'El Diamante No.2',1,NULL,NULL),
(88,'El Jardín',1,NULL,NULL),
(89,'El Llano',1,NULL,NULL),
(90,'El Llano SE',1,NULL,NULL),
(91,'El Nogal-Los Almendros',1,NULL,NULL),
(92,'El Patio',1,NULL,NULL),
(93,'El Pesebre',1,NULL,NULL),
(94,'El Picacho',1,NULL,NULL),
(95,'El Pinal',1,NULL,NULL),
(96,'El Placer',1,NULL,NULL),
(97,'El Plan',1,NULL,NULL),
(98,'El Poblado',1,NULL,NULL),
(99,'El Pomar',1,NULL,NULL),
(100,'El Progreso',1,NULL,NULL),
(101,'El Raizal',1,NULL,NULL),
(102,'El Rincón',1,NULL,NULL),
(103,'El Rodeo',1,NULL,NULL),
(104,'El Salado',1,NULL,NULL),
(105,'El Salvador',1,NULL,NULL),
(106,'El Socorro',1,NULL,NULL),
(107,'El Tesoro',1,NULL,NULL),
(108,'El Triunfo',1,NULL,NULL),
(109,'El Uvito',1,NULL,NULL),
(110,'El Velódromo',1,NULL,NULL),
(111,'Enciso',1,NULL,NULL),
(112,'Estación Villa',1,NULL,NULL),
(113,'Estadio',1,NULL,NULL),
(114,'Facultad Veterinaria y Zootecnia U.de.A.',1,NULL,NULL),
(115,'Facultad de Minas',1,NULL,NULL),
(116,'Facultad de Minas U. Nacional',1,NULL,NULL),
(117,'Ferrini',1,NULL,NULL),
(118,'Florencia',1,NULL,NULL),
(119,'Florida Nueva',1,NULL,NULL),
(120,'Francisco Antonio Zea',1,NULL,NULL),
(121,'Fuente Clara',1,NULL,NULL),
(122,'Fátima',1,NULL,NULL),
(123,'Gerona',1,NULL,NULL),
(124,'Girardot',1,NULL,NULL),
(125,'Granada',1,NULL,NULL),
(126,'Granizal',1,NULL,NULL),
(127,'Guayabal',1,NULL,NULL),
(128,'Guayaquil',1,NULL,NULL),
(129,'Hospital San Vicente de Paúl',1,NULL,NULL),
(130,'Héctor Abad Gómez',1,NULL,NULL),
(131,'Jardín Botánico',1,NULL,NULL),
(132,'Jesús Nazareno',1,NULL,NULL),
(133,'Juan Pablo II',1,NULL,NULL),
(134,'Juan XXIII La Quiebra',1,NULL,NULL),
(135,'Kennedy',1,NULL,NULL),
(136,'La Aguacatala',1,NULL,NULL),
(137,'La Aldea',1,NULL,NULL),
(138,'La Alpujarra',1,NULL,NULL),
(139,'La América',1,NULL,NULL),
(140,'La Avanzada',1,NULL,NULL),
(141,'La Candelaria',1,NULL,NULL),
(142,'La Castellana',1,NULL,NULL),
(143,'La Colina',1,NULL,NULL),
(144,'La Cruz',1,NULL,NULL),
(145,'La Cuchilla',1,NULL,NULL),
(146,'La Esperanza',1,NULL,NULL),
(147,'La Esperanza No.2',1,NULL,NULL),
(148,'La Floresta',1,NULL,NULL),
(149,'La Florida',1,NULL,NULL),
(150,'La Francia',1,NULL,NULL),
(151,'La Frisola',1,NULL,NULL),
(152,'La Frontera',1,NULL,NULL),
(153,'La Gloria',1,NULL,NULL),
(154,'La Hondonada',1,NULL,NULL),
(155,'La Ilusión',1,NULL,NULL),
(156,'La Isla',1,NULL,NULL),
(157,'La Ladera',1,NULL,NULL),
(158,'La Libertad',1,NULL,NULL),
(159,'La Loma',1,NULL,NULL),
(160,'La Loma de Los Bernal',1,NULL,NULL),
(161,'La Mansión',1,NULL,NULL),
(162,'La Milagrosa',1,NULL,NULL),
(163,'La Mota',1,NULL,NULL),
(164,'La Palma',1,NULL,NULL),
(165,'La Pilarica',1,NULL,NULL),
(166,'La Piñuela',1,NULL,NULL),
(167,'La Pradera',1,NULL,NULL),
(168,'La Rosa',1,NULL,NULL),
(169,'La Salle',1,NULL,NULL),
(170,'La Sierra',1,NULL,NULL),
(171,'La Sucia',1,NULL,NULL),
(172,'La Suiza',1,NULL,NULL),
(173,'La Verde',1,NULL,NULL),
(174,'Lalinde',1,NULL,NULL),
(175,'Las Acacias',1,NULL,NULL),
(176,'Las Brisas',1,NULL,NULL),
(177,'Las Esmeraldas',1,NULL,NULL),
(178,'Las Estancias',1,NULL,NULL),
(179,'Las Granjas',1,NULL,NULL),
(180,'Las Independencias',1,NULL,NULL),
(181,'Las Lomas No.1',1,NULL,NULL),
(182,'Las Lomas No.2',1,NULL,NULL),
(183,'Las Mercedes',1,NULL,NULL),
(184,'Las Palmas',1,NULL,NULL),
(185,'Las Playas',1,NULL,NULL),
(186,'Las Violetas',1,NULL,NULL),
(187,'Laureles',1,NULL,NULL),
(188,'Llanaditas',1,NULL,NULL),
(189,'Lorena',1,NULL,NULL),
(190,'Loreto',1,NULL,NULL),
(191,'Los Alcázares',1,NULL,NULL),
(192,'Los Alpes',1,NULL,NULL),
(193,'Los Balsos No.1',1,NULL,NULL),
(194,'Los Balsos No.2',1,NULL,NULL),
(195,'Los Cerros El Vergel',1,NULL,NULL),
(196,'Los Colores',1,NULL,NULL),
(197,'Los Conquistadores',1,NULL,NULL),
(198,'Los Mangos',1,NULL,NULL),
(199,'Los Naranjos',1,NULL,NULL),
(200,'Los Pinos',1,NULL,NULL),
(201,'Los Ángeles',1,NULL,NULL),
(202,'López de  Mesa',1,NULL,NULL),
(203,'Manila',1,NULL,NULL),
(204,'Manrique Central No.1',1,NULL,NULL),
(205,'Manrique Central No.2',1,NULL,NULL),
(206,'Manrique Oriental',1,NULL,NULL),
(207,'María Cano-Carambolas',1,NULL,NULL),
(208,'Mazo',1,NULL,NULL),
(209,'Media Luna',1,NULL,NULL),
(210,'Metropolitano',1,NULL,NULL),
(211,'Mirador del Doce',1,NULL,NULL),
(212,'Miraflores',1,NULL,NULL),
(213,'Miranda',1,NULL,NULL),
(214,'Miravalle',1,NULL,NULL),
(215,'Montañita',1,NULL,NULL),
(216,'Monteclaro',1,NULL,NULL),
(217,'Moravia',1,NULL,NULL),
(218,'Moscú No.1',1,NULL,NULL),
(219,'Moscú No.2',1,NULL,NULL),
(220,'Naranjal',1,NULL,NULL),
(221,'Nueva Villa de La Iguaná',1,NULL,NULL),
(222,'Nueva Villa del Aburrá',1,NULL,NULL),
(223,'Nuevos Conquistadores',1,NULL,NULL),
(224,'Ocho de Marzo',1,NULL,NULL),
(225,'Olaya Herrera',1,NULL,NULL),
(226,'Oleoducto',1,NULL,NULL),
(227,'Oriente',1,NULL,NULL),
(228,'Pablo VI',1,NULL,NULL),
(229,'Pajarito',1,NULL,NULL),
(230,'Palenque',1,NULL,NULL),
(231,'Palermo',1,NULL,NULL),
(232,'Palmitas Sector Central',1,NULL,NULL),
(233,'Parque Juan Pablo II',1,NULL,NULL),
(234,'Parque Norte',1,NULL,NULL),
(235,'Patio Bonito',1,NULL,NULL),
(236,'Pedregal',1,NULL,NULL),
(237,'Pedregal Alto',1,NULL,NULL),
(238,'Perpetuo Socorro',1,NULL,NULL),
(239,'Picachito',1,NULL,NULL),
(240,'Picacho',1,NULL,NULL),
(241,'Piedra Gorda',1,NULL,NULL),
(242,'Piedras Blancas - Matasano',1,NULL,NULL),
(243,'Playón de Los Comuneros',1,NULL,NULL),
(244,'Plaza de Ferias',1,NULL,NULL),
(245,'Popular',1,NULL,NULL),
(246,'Potrera Miserenga',1,NULL,NULL),
(247,'Potrerito',1,NULL,NULL),
(248,'Prado',1,NULL,NULL),
(249,'Progreso No.2',1,NULL,NULL),
(250,'Robledo',1,NULL,NULL),
(251,'Rosales',1,NULL,NULL),
(252,'San Antonio',1,NULL,NULL),
(253,'San Antonio de Prado',1,NULL,NULL),
(254,'San Benito',1,NULL,NULL),
(255,'San Bernardo',1,NULL,NULL),
(256,'San Diego',1,NULL,NULL),
(257,'San Germán',1,NULL,NULL),
(258,'San Isidro',1,NULL,NULL),
(259,'San Javier No.1',1,NULL,NULL),
(260,'San Javier No.2',1,NULL,NULL),
(261,'San Joaquín',1,NULL,NULL),
(262,'San José',1,NULL,NULL),
(263,'San José La Cima No.1',1,NULL,NULL),
(264,'San José La Cima No.2',1,NULL,NULL),
(265,'San José de La Montaña',1,NULL,NULL),
(266,'San José del Manzanillo',1,NULL,NULL),
(267,'San Lucas',1,NULL,NULL),
(268,'San Martín de Porres',1,NULL,NULL),
(269,'San Miguel',1,NULL,NULL),
(270,'San Pablo',1,NULL,NULL),
(271,'San Pedro',1,NULL,NULL),
(272,'Santa Cruz',1,NULL,NULL),
(273,'Santa Elena Sector Central',1,NULL,NULL),
(274,'Santa Fé',1,NULL,NULL),
(275,'Santa Inés',1,NULL,NULL),
(276,'Santa Lucía',1,NULL,NULL),
(277,'Santa Margarita',1,NULL,NULL),
(278,'Santa María de Los Ángeles',1,NULL,NULL),
(279,'Santa Mónica',1,NULL,NULL),
(280,'Santa Rosa de Lima',1,NULL,NULL),
(281,'Santa Teresita',1,NULL,NULL),
(282,'Santander',1,NULL,NULL),
(283,'Santo Domingo Savio No.1',1,NULL,NULL),
(284,'Santo Domingo Savio No.2',1,NULL,NULL),
(285,'Sevilla',1,NULL,NULL),
(286,'Simón Bolívar',1,NULL,NULL),
(287,'Sin Nombre',1,NULL,NULL),
(288,'Sucre',1,NULL,NULL),
(289,'Suramericana',1,NULL,NULL),
(290,'Tejelo',1,NULL,NULL),
(291,'Tenche',1,NULL,NULL),
(292,'Terminal de Transporte',1,NULL,NULL),
(293,'Toscana',1,NULL,NULL),
(294,'Travesías',1,NULL,NULL),
(295,'Trece de Noviembre',1,NULL,NULL),
(296,'Tricentenario',1,NULL,NULL),
(297,'Trinidad',1,NULL,NULL),
(298,'U.D. Atanasio Girardot',1,NULL,NULL),
(299,'U.P.B',1,NULL,NULL),
(300,'Universidad Nacional',1,NULL,NULL),
(301,'Universidad de Antioquia',1,NULL,NULL),
(302,'Urquitá',1,NULL,NULL),
(303,'Veinte de Julio',1,NULL,NULL),
(304,'Versalles No.1',1,NULL,NULL),
(305,'Versalles No.2',1,NULL,NULL),
(306,'Villa Carlota',1,NULL,NULL),
(307,'Villa Flora',1,NULL,NULL),
(308,'Villa Guadalupe',1,NULL,NULL),
(309,'Villa Hermosa',1,NULL,NULL),
(310,'Villa Lilliam',1,NULL,NULL),
(311,'Villa Niza',1,NULL,NULL),
(312,'Villa Nueva',1,NULL,NULL),
(313,'Villa Turbay',1,NULL,NULL),
(314,'Villa del Socorro',1,NULL,NULL),
(315,'Villatina',1,NULL,NULL),
(316,'Volcana Guayabal',1,NULL,NULL),
(317,'Yarumalito',1,NULL,NULL),
(318,'Yolombo',1,NULL,NULL),
(319,'Área de Expansión Altavista',1,NULL,NULL),
(320,'Área de Expansión Belén Rincón',1,NULL,NULL),
(321,'Área de Expansión El Noral',1,NULL,NULL),
(322,'Área de Expansión Pajarito',1,NULL,NULL),
(323,'Área de Expansión San Antonio de Prado',1,NULL,NULL),
(324,'Área de Expansión San Cristóbal',1,NULL,NULL),
(325,'NIQUIA',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(326,'GRAN AVENIDA',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(327,'CAVAÑAS',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(328,'NIQUIA CAMACOL',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(329,'EL DUCADO',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(330,'LA CASCADA DE RIACHUELOS',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(331,'LA GABRIELA',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(332,'SAN MARTIN',2,'2025-08-11 19:55:45','2025-08-11 19:55:45'),
(333,'El Rosario',3,'2025-08-11 19:58:32','2025-08-11 19:58:32'),
(334,'La Cruz',3,'2025-08-11 19:58:32','2025-08-11 19:58:32'),
(335,'Induamérica',3,'2025-08-11 19:58:32','2025-08-11 19:58:32'),
(336,'Las Margaritas',4,'2025-08-11 20:01:05','2025-08-11 20:01:05'),
(337,'El Plan de San Rafael',4,'2025-08-11 20:01:05','2025-08-11 20:01:05'),
(338,'San Rafael',4,'2025-08-11 20:01:05','2025-08-11 20:01:05'),
(339,'La Florida',4,'2025-08-11 20:01:05','2025-08-11 20:01:05'),
(340,'Barrio Mesa',4,'2025-08-11 20:01:05','2025-08-11 20:01:05'),
(341,'La Primavera',4,'2025-08-11 20:01:05','2025-08-11 20:01:05'),
(342,'Calle Larga',76,'2025-08-11 20:56:46','2025-08-11 20:56:46'),
(343,'Restrepo Naranjo',76,'2025-08-11 20:56:46','2025-08-11 20:56:46'),
(344,'San José',76,'2025-08-11 20:56:46','2025-08-11 20:56:46'),
(345,'Holanda',76,'2025-08-11 20:56:46','2025-08-11 20:56:46'),
(346,'Villa Campestre',76,'2025-08-11 20:56:46','2025-08-11 20:56:46'),
(347,'Escobar',77,'2025-08-11 21:03:51','2025-08-11 21:03:51'),
(348,'Dorado',77,'2025-08-11 21:03:51','2025-08-11 21:03:51'),
(349,'La Inmaculada 2',77,'2025-08-11 21:03:51','2025-08-11 21:03:51'),
(350,'Alabama Unidad',77,'2025-08-11 21:03:51','2025-08-11 21:03:51'),
(351,'Pueblo Viejo',77,'2025-08-11 21:03:51','2025-08-11 21:03:51'),
(352,'Vereda La Chuscala',78,'2025-08-11 21:09:45','2025-08-11 21:09:45'),
(353,'Bellavista',78,'2025-08-11 21:09:45','2025-08-11 21:09:45'),
(354,'Villanueva',79,'2025-08-11 21:09:45','2025-08-11 21:09:45');
/*!40000 ALTER TABLE `barrio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficiarios`
--

DROP TABLE IF EXISTS `beneficiarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `beneficiarios` (
  `id_beneficiario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `contacto_emergencia` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_beneficiario`),
  KEY `beneficiarios_empleado_id_foreign` (`empleado_id`),
  KEY `beneficiarios_tipo_documento_id_foreign` (`tipo_documento_id`),
  CONSTRAINT `beneficiarios_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  CONSTRAINT `beneficiarios_tipo_documento_id_foreign` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id_tipo_documento`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiarios`
--

LOCK TABLES `beneficiarios` WRITE;
/*!40000 ALTER TABLE `beneficiarios` DISABLE KEYS */;
INSERT INTO `beneficiarios` VALUES
(68,167,'KATERINE VERGARA','Cónyuge','1988-01-17',1,'1037586533','Técnico','2025-08-05 17:26:50','2025-08-05 17:26:50',1,0,'3147785561'),
(69,168,'DIONE ALVAREZ','Cónyuge',NULL,1,NULL,'Secundaria','2025-08-11 21:04:10','2025-08-11 21:04:10',1,1,'3174508447'),
(70,169,'SILVIA ZULETA','Madre','1982-02-28',1,'43906301','Secundaria','2025-08-11 21:14:45','2025-08-11 21:14:45',1,0,'3206162208'),
(71,170,'HELLEN NICOLE OREJUELA','Hijo/a','2012-03-23',2,'1032023045','Secundaria','2025-08-13 17:54:40','2025-08-13 17:54:40',1,1,NULL),
(72,171,'RODRIGO ALBERTO YEPES','Padre','1948-11-29',1,'8290704','Secundaria','2025-08-13 18:16:34','2025-08-13 18:16:34',1,0,'3127874133'),
(73,172,'JOSELINE ELIANA LIZA','Cónyuge','1994-06-30',3,'524184','Secundaria','2025-08-13 18:26:57','2025-08-13 18:26:57',1,1,'6044221743'),
(74,173,'MARTA RESTREPO','Madre','1957-02-12',1,'42820117','Secundaria','2025-08-13 19:06:58','2025-08-13 19:06:58',1,1,'3015119042');
/*!40000 ALTER TABLE `beneficiarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id_cargo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `centro_costo_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cargo`),
  KEY `fk_cargo_centro_costo` (`centro_costo_id`),
  CONSTRAINT `fk_cargo_centro_costo` FOREIGN KEY (`centro_costo_id`) REFERENCES `centro_costos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES
(1,'ASESOR',1,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(2,'AUXILIAR ADMINISTRATIVA',1,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(3,'SECRETARIO GENERAL',1,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(4,'DIRECTOR DE PLANEACION FINANCIERA',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(5,'GERENTE',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(6,'GERENTE CORPORATIVA',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(7,'LIDER DE INVESTIGACIÓN DE MERCADOS',2,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(8,'ANALISTA DE FORMACION Y DESARROLLO',3,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(9,'COORD SEGURIDAD Y SALUD EN EL TRABAJO',3,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(10,'ASISTENTE FINANCIERO',4,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(11,'AUXILIAR CARTERA Y COBRANZAS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(12,'AUXILIAR DE COSTOS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(13,'CONTADOR (A)',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(14,'COORDINADOR DE COSTOS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(15,'DIRECTOR DE CONTABILIDAD',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(16,'LIDER DE COSTOS E INVENTARIOS',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(17,'SUPERNUMERARIA',5,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(18,'ARQUITECTO DE SOFTWARE',6,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(19,'ASISTENTE DE COMPRAS',8,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(20,'ASESOR TECNICO DE NEGOCIOS',9,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(21,'ASISTENTE COMERCIAL',9,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(22,'EJECUTIVO DE CUENTA',10,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(23,'SERVICIO AL CLIENTE',10,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(24,'AUXILIAR DE ALMACENAMIENTO Y DESPACHO',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(25,'AUXILIAR DE BODEGA (ALMACENISTA)',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(26,'AUXILIAR DE FACTURACION Y DESPACHOS',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(27,'IMPRESOR NP1',12,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(28,'IMPRESOR NP2',13,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(29,'IMPRESOR NP3',14,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(30,'IMPRESORA KOPACK',15,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(31,'AUXILIAR DE IMPRESION',16,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(32,'REBOBINADOR (A)',17,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(33,'COORDINADOR DE IMPRESION',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(34,'AUXILIAR ADMINISTRATIVA',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(35,'OFICIOS VARIOS',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(36,'SERVICIOS GENERALES',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(37,'OPERARIO DE PRODUCCION',18,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(38,'COORDINADOR DE PRODUCCION',19,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(39,'ELECTROMECANICO',20,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(40,'MECANICO DE MANTENIMIENTO',20,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(41,'OPERARIO MANUAL PREPRENSA',21,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(42,'COORDINADOR PREPENSA',22,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(43,'MONTAJISTA DIGITAL',22,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(44,'ANALISTA DE CALIDAD',23,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(45,'AUXILIAR DE CALIDAD',23,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(46,'COORDINADOR DE PROGRAMACIÓN',24,'2025-07-07 21:52:22','2025-07-07 21:52:22'),
(47,'AUXILIAR DE TINTAS',25,'2025-07-07 21:52:22','2025-07-07 21:52:22');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccf`
--

DROP TABLE IF EXISTS `ccf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccf`
--

LOCK TABLES `ccf` WRITE;
/*!40000 ALTER TABLE `ccf` DISABLE KEYS */;
INSERT INTO `ccf` VALUES
(1,'Comfama'),
(2,'Comfenalco'),
(3,'Compensar'),
(4,'Cafam');
/*!40000 ALTER TABLE `ccf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centro_costos`
--

DROP TABLE IF EXISTS `centro_costos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `centro_costos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_costos`
--

LOCK TABLES `centro_costos` WRITE;
/*!40000 ALTER TABLE `centro_costos` DISABLE KEYS */;
INSERT INTO `centro_costos` VALUES
(1,'10000','Administración','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(2,'10001','Gerencia General','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(3,'10002','Gestion Humana','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(4,'10003','Gerencia Financiera','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(5,'10004','Dirección Contable','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(6,'10005','Dirección Sistemas','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(7,'10006','Nómina','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(8,'10007','Dirección de compras','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(9,'20000','Ventas','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(10,'20001','Comercial (Vendedores)','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(11,'20002','Despachos y bodega','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(12,'30001','Impresora NP1','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(13,'30002','Impresora NP2','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(14,'30003','Impresora NP3','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(15,'30004','Impresora Kopack','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(16,'30005','Mano de obra directa operarios (aux)','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(17,'30006','Mano de obra directa rebobinado','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(18,'40000','APOYO PRODUCCION','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(19,'40001','Gerencia de planta','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(20,'40003','Mantenimiento','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(21,'40004','Laboratorio','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(22,'40005','Preprensa digital','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(23,'40006','Calidad','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(24,'40007','Programacion','2025-07-07 21:05:11','2025-07-07 21:05:11'),
(25,'40009','Tintas','2025-07-07 21:05:11','2025-07-07 21:05:11');
/*!40000 ALTER TABLE `centro_costos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudades_laborales`
--

DROP TABLE IF EXISTS `ciudades_laborales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciudades_laborales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudades_laborales`
--

LOCK TABLES `ciudades_laborales` WRITE;
/*!40000 ALTER TABLE `ciudades_laborales` DISABLE KEYS */;
INSERT INTO `ciudades_laborales` VALUES
(1,'medellin',NULL,NULL),
(2,'Sabaneta','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ciudades_laborales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento` (
  `id_departamento` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_departamento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_departamento`),
  KEY `departamento_pais_id_foreign` (`pais_id`),
  CONSTRAINT `departamento_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id_pais`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES
(1,'Antioquia',1,NULL,NULL),
(2,'Cundinamarca',1,NULL,NULL),
(3,'Valle del Cauca',1,NULL,NULL),
(4,'Atlántico',1,NULL,NULL),
(5,'Santander',1,NULL,NULL),
(6,'Madrid',2,NULL,NULL),
(7,'Cataluña',2,NULL,NULL),
(8,'Andalucía',2,NULL,NULL),
(9,'Galicia',2,NULL,NULL),
(10,'Valencia',2,NULL,NULL),
(11,'Distrito Capital',3,NULL,NULL),
(12,'Miranda',3,NULL,NULL),
(13,'Zulia',3,NULL,NULL),
(14,'Lara',3,NULL,NULL),
(15,'Carabobo',3,NULL,NULL);
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discapacidad`
--

DROP TABLE IF EXISTS `discapacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `discapacidad` (
  `id_discapacidad` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_discapacidad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado_discapacidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_diagnostico_discapacidad` date DEFAULT NULL,
  `enfermedad_base` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_discapacidad`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discapacidad`
--

LOCK TABLES `discapacidad` WRITE;
/*!40000 ALTER TABLE `discapacidad` DISABLE KEYS */;
INSERT INTO `discapacidad` VALUES
(1,'Sensorial','Moderado','2018-03-01','Sí','2025-05-30 18:02:16','2025-05-30 18:02:16'),
(6,'Física','Leve','2024-09-24',NULL,NULL,NULL),
(8,'Visual','Moderada','2024-09-19',NULL,NULL,NULL),
(9,'Intelectual','Leve','2025-06-01','f41546456415',NULL,NULL),
(10,'Visual','Leve','2025-06-19','54465',NULL,NULL),
(11,'Psicosocial','Moderada',NULL,'87587663873',NULL,NULL),
(12,'Física','Severa',NULL,'87587663873',NULL,NULL),
(13,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(14,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(15,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(16,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(17,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(18,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(19,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(20,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(21,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(22,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(23,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(24,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(25,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(26,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(27,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(28,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(29,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(30,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(31,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(32,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(33,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(34,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(35,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(36,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(37,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(38,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(39,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(40,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(41,'Física','Moderada','2025-03-13','87587663873',NULL,NULL),
(42,'Intelectual','Moderada','2024-11-08',NULL,NULL,NULL),
(43,'Intelectual','Moderada','2024-11-08',NULL,NULL,NULL),
(44,'Visual','Severa','2024-10-10',NULL,NULL,NULL),
(47,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(48,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(49,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(50,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(51,'Física','Leve','2025-06-01','87587663873',NULL,NULL),
(52,'Física','Leve','2025-06-01',NULL,NULL,NULL),
(53,'Visual','Severa','2024-10-10',NULL,NULL,NULL),
(54,'Visual','Moderada','2025-07-09',NULL,NULL,NULL),
(55,'Visual','Severa','2025-07-07',NULL,NULL,NULL),
(56,'Física','Leve','2024-09-24',NULL,NULL,NULL),
(57,'Visual','Leve','2025-02-13',NULL,NULL,NULL),
(58,'Visual','Leve','2025-02-13',NULL,NULL,NULL);
/*!40000 ALTER TABLE `discapacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado_discapacidad`
--

DROP TABLE IF EXISTS `empleado_discapacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado_discapacidad` (
  `empleado_id` bigint(20) unsigned NOT NULL,
  `discapacidad_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`empleado_id`,`discapacidad_id`),
  KEY `empleado_discapacidad_discapacidad_id_foreign` (`discapacidad_id`),
  CONSTRAINT `empleado_discapacidad_discapacidad_id_foreign` FOREIGN KEY (`discapacidad_id`) REFERENCES `discapacidad` (`id_discapacidad`) ON DELETE CASCADE,
  CONSTRAINT `empleado_discapacidad_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado_discapacidad`
--

LOCK TABLES `empleado_discapacidad` WRITE;
/*!40000 ALTER TABLE `empleado_discapacidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleado_discapacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado_pais_ubicacion`
--

DROP TABLE IF EXISTS `empleado_pais_ubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado_pais_ubicacion` (
  `id_empleado_pais_ubicacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empleado_id` bigint(20) unsigned NOT NULL,
  `pais_id` bigint(20) unsigned NOT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `barrio_id` int(11) unsigned DEFAULT NULL,
  `tipo_ubicacion` enum('NACIMIENTO','RESIDENCIA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_empleado_pais_ubicacion`),
  UNIQUE KEY `empleado_pais_ubicacion_empleado_id_tipo_ubicacion_unique` (`empleado_id`,`tipo_ubicacion`),
  KEY `empleado_pais_ubicacion_pais_id_foreign` (`pais_id`),
  CONSTRAINT `empleado_pais_ubicacion_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  CONSTRAINT `empleado_pais_ubicacion_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  CONSTRAINT `empleado_pais_ubicacion_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id_pais`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=537 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado_pais_ubicacion`
--

LOCK TABLES `empleado_pais_ubicacion` WRITE;
/*!40000 ALTER TABLE `empleado_pais_ubicacion` DISABLE KEYS */;
INSERT INTO `empleado_pais_ubicacion` VALUES
(513,166,1,1,1,NULL,'NACIMIENTO','2025-08-05 17:14:45','2025-08-05 17:14:45'),
(514,166,1,1,3,38,'RESIDENCIA','2025-08-05 17:14:45','2025-08-05 17:14:45'),
(515,167,1,1,1,NULL,'NACIMIENTO','2025-08-05 17:26:50','2025-08-05 17:26:50'),
(516,167,1,1,1,53,'RESIDENCIA','2025-08-05 17:26:50','2025-08-05 17:26:50'),
(517,168,1,1,1,NULL,'NACIMIENTO','2025-08-11 21:04:10','2025-08-11 21:04:10'),
(518,168,1,1,3,277,'RESIDENCIA','2025-08-11 21:04:10','2025-08-11 21:04:10'),
(519,169,1,1,1,NULL,'NACIMIENTO','2025-08-11 21:14:45','2025-08-11 21:14:45'),
(520,169,1,1,3,336,'RESIDENCIA','2025-08-11 21:14:45','2025-08-11 21:14:45'),
(523,170,1,1,1,NULL,'NACIMIENTO','2025-08-13 17:54:40','2025-08-13 17:54:40'),
(524,170,1,1,2,325,'RESIDENCIA','2025-08-13 17:54:40','2025-08-13 17:54:40'),
(525,171,1,1,1,NULL,'NACIMIENTO','2025-08-13 18:16:34','2025-08-13 18:16:34'),
(526,171,1,1,4,336,'RESIDENCIA','2025-08-13 18:16:34','2025-08-13 18:16:34'),
(527,172,1,1,1,NULL,'NACIMIENTO','2025-08-13 18:26:57','2025-08-13 18:26:57'),
(528,172,1,1,1,250,'RESIDENCIA','2025-08-13 18:26:57','2025-08-13 18:26:57'),
(529,173,1,1,1,NULL,'NACIMIENTO','2025-08-13 19:06:58','2025-08-13 19:06:58'),
(530,173,1,1,76,149,'RESIDENCIA','2025-08-13 19:06:58','2025-08-13 19:06:58');
/*!40000 ALTER TABLE `empleado_pais_ubicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado_patologia`
--

DROP TABLE IF EXISTS `empleado_patologia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado_patologia` (
  `empleado_id` bigint(20) unsigned NOT NULL,
  `patologia_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`empleado_id`,`patologia_id`),
  KEY `empleado_patologia_patologia_id_foreign` (`patologia_id`),
  CONSTRAINT `empleado_patologia_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  CONSTRAINT `empleado_patologia_patologia_id_foreign` FOREIGN KEY (`patologia_id`) REFERENCES `patologia` (`id_patologia`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado_patologia`
--

LOCK TABLES `empleado_patologia` WRITE;
/*!40000 ALTER TABLE `empleado_patologia` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleado_patologia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `id_empleado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_documento_id` bigint(20) unsigned NOT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_completo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('MASCULINO','FEMENINO','OTRO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OTRO',
  `estado_civil` enum('Soltero(a)','Casado(a)','Union Libre','Viudo(a)','Divorciado(a)') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Soltero(a)',
  `nivel_educativo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rango_edad_id` bigint(20) unsigned DEFAULT NULL,
  `eps_id` int(11) DEFAULT NULL,
  `afp_id` int(11) DEFAULT NULL,
  `arl_id` int(11) DEFAULT NULL,
  `ccf_id` int(11) DEFAULT NULL,
  `afc_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_fijo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_vivienda` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estrato` int(11) DEFAULT NULL,
  `vehiculo_propio` tinyint(1) DEFAULT NULL,
  `tipo_vehiculo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movilidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institucion_educativa` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intereses_personales` text COLLATE utf8mb4_unicode_ci,
  `idiomas` text COLLATE utf8mb4_unicode_ci,
  `padre_o_madre` tinyint(1) DEFAULT NULL,
  `etnia_id` bigint(20) unsigned DEFAULT NULL,
  `grupo_sanguineo_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `empleados_numero_documento_unique` (`numero_documento`),
  KEY `empleados_tipo_documento_id_foreign` (`tipo_documento_id`),
  KEY `empleados_rango_edad_id_foreign` (`rango_edad_id`),
  KEY `fk_eps` (`eps_id`),
  KEY `fk_afp` (`afp_id`),
  KEY `fk_arl` (`arl_id`),
  KEY `fk_ccf` (`ccf_id`),
  KEY `fk_empleados_etnia` (`etnia_id`),
  KEY `fk_empleados_grupo_sanguineo` (`grupo_sanguineo_id`),
  KEY `afc_id` (`afc_id`),
  CONSTRAINT `empleados_rango_edad_id_foreign` FOREIGN KEY (`rango_edad_id`) REFERENCES `rango_edad` (`id_rango`),
  CONSTRAINT `empleados_tipo_documento_id_foreign` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id_tipo_documento`),
  CONSTRAINT `fk_afc_empleado` FOREIGN KEY (`afc_id`) REFERENCES `afcs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_afp` FOREIGN KEY (`afp_id`) REFERENCES `afp` (`id`),
  CONSTRAINT `fk_arl` FOREIGN KEY (`arl_id`) REFERENCES `arl` (`id`),
  CONSTRAINT `fk_ccf` FOREIGN KEY (`ccf_id`) REFERENCES `ccf` (`id`),
  CONSTRAINT `fk_empleados_etnia` FOREIGN KEY (`etnia_id`) REFERENCES `etnias` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_empleados_grupo_sanguineo` FOREIGN KEY (`grupo_sanguineo_id`) REFERENCES `grupo_sanguineo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_eps` FOREIGN KEY (`eps_id`) REFERENCES `eps` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES
(166,1,'43826066','ANA MARIA ZULUAGA BARRERO','1974-02-22','FEMENINO','Soltero(a)','Secundaria',7,1,2,1,1,3,'2025-08-05 17:14:45','2025-08-05 17:14:45',NULL,'anamzuluagab13@gmail.com','3217820428','CALLE 82 # 55 G 10',NULL,'ARRENDADA',2,1,'MOTO','MOTO','INDECAP','SALIR A CAMINAR','NATAL',1,10,1),
(167,1,'8163571','JUAN DAVID MONTOYA RODAS','1983-04-25','MASCULINO','Casado(a)','Técnico',4,1,2,1,1,3,'2025-08-05 17:26:50','2025-08-05 17:26:50',NULL,'juanda4312@hotmail.com','3146831087','CR 46  75 SUR 150 AP 1211',NULL,'PROPIA',3,1,'CARRO','CARRO','SENA','COMPARTIR EN FAMILIA','NATAL',1,NULL,1),
(168,1,'15333871','CARLOS MARIO MIRA HOLGUIN','1960-01-02','MASCULINO','Casado(a)','Secundaria',9,1,NULL,NULL,1,NULL,'2025-08-11 21:04:10','2025-08-11 21:04:10',NULL,NULL,'3054470186','CL 43 N° 55 A 160',NULL,'PROPIA',2,0,'NO','TRANSPORTE PÚBLICO','-','COMPARTIR EN FAMILIA','NATAL',1,NULL,7),
(169,1,'1000439533','ESTEFANIA PEREZ ZULETA','2000-11-17','FEMENINO','Soltero(a)','Tecnólogo',1,1,2,1,1,4,'2025-08-11 21:14:45','2025-08-11 21:14:45',NULL,'estefaniaperez1718@gmail.com','3041152456','CALLE 36 # 50 A 21',NULL,'FAMILIAR',3,0,'NO','TRANSPORTE PÚBLICO','IECOMI','COMPARTIR EN FAMILIA','NATAL',0,NULL,7),
(170,1,'43910837','VIVIANA ANDREA ZAPATA DURANGO','1982-08-18','FEMENINO','Casado(a)','Profesional',5,1,3,1,1,1,'2025-08-13 17:49:47','2025-08-13 17:49:47',NULL,'adurango385@gmail.com','3144026515','AVENIDA 33 # 56 - 42',NULL,'ARRENDADA',3,0,'NO TIENE VEHÍCULO','TRANSPORTE PÚBLICO','UNIMINUTO','FAMILIA Y CURSOS DE NATACIÓN','NATAL',1,NULL,7),
(171,1,'43869582','LAURA NATALIA YEPES MUÑOZ','1980-05-03','FEMENINO','Casado(a)','Profesional',5,1,1,1,1,4,'2025-08-13 18:16:34','2025-08-13 18:16:34',NULL,'lnyepesm@gmail.com','3234526986','TRANSVERSAL 34E SUR # 32C - 127','6043067722','ARRENDADA',3,0,'NO TIENE VEHÍCULO','TRANSPORTE PÚBLICO','EAFIT','FAMILIA Y PAREJA','NATAL',1,NULL,1),
(172,1,'71756337','YEISON ANDRES ZAPATA SANDOVAL','1975-08-10','MASCULINO','Union Libre','Tecnólogo',6,1,NULL,1,1,2,'2025-08-13 18:26:57','2025-08-13 18:26:57',NULL,'yeison71756@gmail.com','300 8766161','CR 90 65 C 10','6044221743','PROPIA',3,0,'NO TIENE VEHÍCULO','TRASPORTE PÚBLICO','ITM','COMPATIR CON LA FAMILIA, FUTBOL','NATAL',1,NULL,7),
(173,1,'8105859','JUAN ESTEBAN TORO RESTREPO','1983-06-05','MASCULINO','Soltero(a)','Secundaria',5,1,2,1,1,4,'2025-08-13 19:06:58','2025-08-13 19:06:58',NULL,'offjtr@hotmail.com','3136328419','CALLE 61 B SUR # 39 A 71',NULL,'FAMILIAR',2,1,'BICICLETA','BICICLETA','LICEO CONCEJO SABANETA','MONTAR BICICLETA','NATAL',0,NULL,5);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id_empresa` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit_empresa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  UNIQUE KEY `empresa_nit_empresa_unique` (`nit_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES
(1,'Contiflex','900123456','Calle 123 #45-67',NULL,NULL),
(2,'Formacol','900987654','Carrera 10 #20-30',NULL,NULL);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eps`
--

DROP TABLE IF EXISTS `eps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `eps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eps`
--

LOCK TABLES `eps` WRITE;
/*!40000 ALTER TABLE `eps` DISABLE KEYS */;
INSERT INTO `eps` VALUES
(1,'Sura'),
(2,'Sanitas'),
(3,'Nueva EPS'),
(4,'Compensar'),
(5,'Cafesalud');
/*!40000 ALTER TABLE `eps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_cargo`
--

DROP TABLE IF EXISTS `estado_cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_cargo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `estado_id` bigint(20) unsigned NOT NULL,
  `cargo_id` bigint(20) unsigned NOT NULL,
  `centro_costo_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `estado_id` (`estado_id`),
  KEY `cargo_id` (`cargo_id`),
  KEY `centro_costo_id` (`centro_costo_id`),
  CONSTRAINT `estado_cargo_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `informacion_laboral` (`id_estado`) ON DELETE CASCADE,
  CONSTRAINT `estado_cargo_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id_cargo`) ON DELETE CASCADE,
  CONSTRAINT `estado_cargo_ibfk_3` FOREIGN KEY (`centro_costo_id`) REFERENCES `centro_costos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_cargo`
--

LOCK TABLES `estado_cargo` WRITE;
/*!40000 ALTER TABLE `estado_cargo` DISABLE KEYS */;
INSERT INTO `estado_cargo` VALUES
(79,138,45,23,'2025-08-05 17:14:56','2025-08-05 17:14:56'),
(80,139,27,12,'2025-08-05 17:26:50','2025-08-05 17:26:50'),
(81,140,35,18,'2025-08-11 21:04:10','2025-08-11 21:04:10'),
(82,141,2,1,'2025-08-11 21:14:45','2025-08-11 21:14:45'),
(83,142,9,3,'2025-08-13 17:49:47','2025-08-13 17:49:47'),
(84,143,38,19,'2025-08-13 18:16:34','2025-08-13 18:16:34'),
(85,144,27,12,'2025-08-13 18:26:57','2025-08-13 18:26:57'),
(86,145,31,16,'2025-08-13 19:06:58','2025-08-13 19:06:58');
/*!40000 ALTER TABLE `estado_cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etnias`
--

DROP TABLE IF EXISTS `etnias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `etnias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etnias`
--

LOCK TABLES `etnias` WRITE;
/*!40000 ALTER TABLE `etnias` DISABLE KEYS */;
INSERT INTO `etnias` VALUES
(1,'Indígena',NULL,NULL),
(2,'Rom (Gitano)',NULL,NULL),
(3,'Raizal del Archipiélago de San Andrés',NULL,NULL),
(4,'Palenquero de San Basilio',NULL,NULL),
(5,'Afrocolombiano',NULL,NULL),
(6,'Negro',NULL,NULL),
(7,'Mulato',NULL,NULL),
(8,'Mestizo',NULL,NULL),
(9,'Blanco',NULL,NULL),
(10,'Otro',NULL,NULL);
/*!40000 ALTER TABLE `etnias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_sanguineo`
--

DROP TABLE IF EXISTS `grupo_sanguineo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo_sanguineo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_sanguineo`
--

LOCK TABLES `grupo_sanguineo` WRITE;
/*!40000 ALTER TABLE `grupo_sanguineo` DISABLE KEYS */;
INSERT INTO `grupo_sanguineo` VALUES
(1,'A+'),
(2,'A-'),
(5,'AB+'),
(6,'AB-'),
(3,'B+'),
(4,'B-'),
(7,'O+'),
(8,'O-');
/*!40000 ALTER TABLE `grupo_sanguineo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informacion_laboral`
--

DROP TABLE IF EXISTS `informacion_laboral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `informacion_laboral` (
  `id_estado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empleado_id` bigint(20) unsigned NOT NULL,
  `empresa_id` bigint(20) unsigned NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `cantidad_prorroga` int(10) unsigned NOT NULL DEFAULT '0',
  `duracion_prorrogas` int(10) unsigned DEFAULT NULL,
  `fecha_prorroga` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_contrato` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `ubicacion_fisica` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciudad_laboral_id` int(11) DEFAULT NULL,
  `aplica_dotacion` tinyint(1) DEFAULT NULL,
  `talla_camisa` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `talla_pantalon` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `talla_zapatos` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relacion_laboral` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Relación laboral actual',
  `relacion_sindical` tinyint(1) DEFAULT NULL COMMENT '1 = Sí, 0 = No',
  `tipo_vinculacion` enum('Directo','Indirecto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Directo',
  PRIMARY KEY (`id_estado`),
  KEY `estado_empleado_id_foreign` (`empleado_id`),
  KEY `estado_empresa_id_foreign` (`empresa_id`),
  KEY `fk_ciudad_laboral` (`ciudad_laboral_id`),
  CONSTRAINT `estado_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  CONSTRAINT `estado_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_ciudad_laboral` FOREIGN KEY (`ciudad_laboral_id`) REFERENCES `ciudades_laborales` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informacion_laboral`
--

LOCK TABLES `informacion_laboral` WRITE;
/*!40000 ALTER TABLE `informacion_laboral` DISABLE KEYS */;
INSERT INTO `informacion_laboral` VALUES
(138,166,1,'2024-10-01',NULL,4,3,'2025-08-22 00:00:00','2025-08-05 17:14:45','2025-08-05 17:14:48','Fijo',NULL,NULL,2,1,'L','M','37','Ley 50',0,'Directo'),
(139,167,2,'2022-04-01',NULL,5,12,'2024-02-23 00:00:00','2025-08-05 17:26:50','2025-08-05 17:26:50','Fijo',NULL,NULL,1,1,'M','M','40','Sin ninguna prestación',0,'Directo'),
(140,168,2,'2025-01-02',NULL,3,3,'2025-08-23 00:00:00','2025-08-11 21:04:10','2025-08-11 21:04:10','Fijo',NULL,NULL,1,1,NULL,NULL,NULL,'Sin ninguna prestación',0,'Directo'),
(141,169,1,'2023-11-08',NULL,5,12,'2025-09-30 00:00:00','2025-08-11 21:14:45','2025-08-11 21:14:45','Fijo',NULL,NULL,2,1,'XL','12','38','Ley 50',0,'Directo'),
(142,170,1,'2024-02-26',NULL,5,12,'2026-01-18 00:00:00','2025-08-13 17:49:47','2025-08-13 17:54:40','Fijo',NULL,NULL,2,0,'L',NULL,'39',NULL,NULL,'Directo'),
(143,171,1,'2024-01-23',NULL,5,12,'2025-12-15 00:00:00','2025-08-13 18:16:34','2025-08-13 18:16:34','Fijo',NULL,NULL,2,1,'L',NULL,'39','Ley 50',0,'Directo'),
(144,172,1,'2015-01-13',NULL,5,12,'2016-12-06 00:00:00','2025-08-13 18:26:57','2025-08-13 18:26:57','Indefinido',NULL,NULL,2,1,'M',NULL,'38','Ley 50',0,'Directo'),
(145,173,1,'2025-02-06',NULL,3,3,'2025-09-30 00:00:00','2025-08-13 19:06:58','2025-08-13 19:06:58','Fijo',NULL,NULL,2,1,'M',NULL,'41','Ley 50',0,'Directo');
/*!40000 ALTER TABLE `informacion_laboral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
INSERT INTO `migrations` VALUES
(1,'2025_05_21_205035_create_initial_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `municipio`
--

DROP TABLE IF EXISTS `municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `municipio` (
  `id_municipio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_municipio` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departamento_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `municipio_departamento_id_foreign` (`departamento_id`),
  CONSTRAINT `municipio_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES
(1,'Medellín',1,NULL,NULL),
(2,'Bello',1,NULL,NULL),
(3,'Itagüí',1,NULL,NULL),
(4,'Envigado',1,NULL,NULL),
(5,'Apartadó',1,NULL,NULL),
(6,'Soacha',2,NULL,NULL),
(7,'Zipaquirá',2,NULL,NULL),
(8,'Chía',2,NULL,NULL),
(9,'Facatativá',2,NULL,NULL),
(10,'Fusagasugá',2,NULL,NULL),
(11,'Cali',3,NULL,NULL),
(12,'Palmira',3,NULL,NULL),
(13,'Buenaventura',3,NULL,NULL),
(14,'Tuluá',3,NULL,NULL),
(15,'Jamundí',3,NULL,NULL),
(16,'Barranquilla',4,NULL,NULL),
(17,'Soledad',4,NULL,NULL),
(18,'Malambo',4,NULL,NULL),
(19,'Sabanalarga',4,NULL,NULL),
(20,'Baranoa',4,NULL,NULL),
(21,'Bucaramanga',5,NULL,NULL),
(22,'Floridablanca',5,NULL,NULL),
(23,'Barrancabermeja',5,NULL,NULL),
(24,'Girón',5,NULL,NULL),
(25,'Piedecuesta',5,NULL,NULL),
(26,'Madrid',6,NULL,NULL),
(27,'Móstoles',6,NULL,NULL),
(28,'Alcalá de Henares',6,NULL,NULL),
(29,'Fuenlabrada',6,NULL,NULL),
(30,'Leganés',6,NULL,NULL),
(31,'Barcelona',7,NULL,NULL),
(32,'L\'Hospitalet de Llobregat',7,NULL,NULL),
(33,'Badalona',7,NULL,NULL),
(34,'Terrassa',7,NULL,NULL),
(35,'Sabadell',7,NULL,NULL),
(36,'Sevilla',8,NULL,NULL),
(37,'Málaga',8,NULL,NULL),
(38,'Córdoba',8,NULL,NULL),
(39,'Granada',8,NULL,NULL),
(40,'Jerez de la Frontera',8,NULL,NULL),
(41,'Vigo',9,NULL,NULL),
(42,'A Coruña',9,NULL,NULL),
(43,'Ourense',9,NULL,NULL),
(44,'Lugo',9,NULL,NULL),
(45,'Santiago de Compostela',9,NULL,NULL),
(46,'València',10,NULL,NULL),
(47,'Alicante',10,NULL,NULL),
(48,'Elche',10,NULL,NULL),
(49,'Castelló de la Plana',10,NULL,NULL),
(50,'Torrevieja',10,NULL,NULL),
(51,'Caracas (Municipio Libertador)',11,NULL,NULL),
(52,'Petare (Municipio Sucre)',11,NULL,NULL),
(53,'Chacao',11,NULL,NULL),
(54,'Baruta',11,NULL,NULL),
(55,'El Hatillo',11,NULL,NULL),
(56,'Los Teques',12,NULL,NULL),
(57,'Guatire',12,NULL,NULL),
(58,'Ocumare del Tuy',12,NULL,NULL),
(59,'Santa Teresa del Tuy',12,NULL,NULL),
(60,'Caucagua',12,NULL,NULL),
(61,'Maracaibo',13,NULL,NULL),
(62,'Cabimas',13,NULL,NULL),
(63,'San Francisco',13,NULL,NULL),
(64,'Ciudad Ojeda',13,NULL,NULL),
(65,'Lagunillas',13,NULL,NULL),
(66,'Barquisimeto',14,NULL,NULL),
(67,'Cabudare',14,NULL,NULL),
(68,'Carora',14,NULL,NULL),
(69,'El Tocuyo',14,NULL,NULL),
(70,'Quíbor',14,NULL,NULL),
(71,'Valencia',15,NULL,NULL),
(72,'Guacara',15,NULL,NULL),
(73,'Puerto Cabello',15,NULL,NULL),
(74,'Mariara',15,NULL,NULL),
(75,'Naguanagua',15,NULL,NULL),
(76,'Sabaneta',1,'2025-08-11 20:55:24','2025-08-11 20:55:24'),
(77,'La Estrella',1,'2025-08-11 21:01:06','2025-08-11 21:01:06'),
(78,'Caldas',1,'2025-08-11 21:08:33','2025-08-11 21:08:33'),
(79,'Copacabana',1,'2025-08-11 21:08:33','2025-08-11 21:08:33');
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pais` (
  `id_pais` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_pais` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pais`),
  UNIQUE KEY `pais_nombre_pais_unique` (`nombre_pais`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES
(1,'Colombia',NULL,NULL),
(2,'España',NULL,NULL),
(3,'Venezuela',NULL,NULL);
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patologia`
--

DROP TABLE IF EXISTS `patologia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `patologia` (
  `id_patologia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_patologia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_diagnostico` date DEFAULT NULL,
  `descripcion_patologia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravedad_patologia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tratamiento_actual_patologia` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_patologia`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patologia`
--

LOCK TABLES `patologia` WRITE;
/*!40000 ALTER TABLE `patologia` DISABLE KEYS */;
INSERT INTO `patologia` VALUES
(1,'Diabetes',NULL,'Crónica','Alta','Insulina','2025-05-30 17:56:07','2025-05-30 17:56:07'),
(2,'ugajfk','2025-01-14','Nose...','Grave','ffwfewfwefw',NULL,NULL),
(3,'Asma','2025-06-01','fgtmnfgnfdnffdgdg','Moderada','gdngdgfddfndfndfgdfngdf',NULL,NULL),
(4,'Diabetes','2020-01-14','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','Muy Grave','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',NULL,NULL),
(5,'Asma','2025-04-03','XXXXXXXXXXXXXXXXX','Moderada','XXXXXXXXXXXXXXXXX',NULL,NULL),
(6,'Diabetes','2025-02-14','XXXXXXXXXXXXXXXXXXXXXXXXX','Moderada','XXXXXXXXXXXXXXXXXXXXXXXXX',NULL,NULL),
(7,'Diabetes','2025-06-17','Esta puteado','Moderada','Desconocido',NULL,NULL),
(8,'Diabetes',NULL,NULL,NULL,NULL,NULL,NULL),
(9,'Diabetes',NULL,NULL,NULL,NULL,NULL,NULL),
(10,'Diabetes',NULL,NULL,NULL,NULL,NULL,NULL),
(11,'Diabetes',NULL,NULL,NULL,NULL,NULL,NULL),
(12,'Diabetes',NULL,NULL,NULL,NULL,NULL,NULL),
(13,'Diabetes',NULL,NULL,NULL,NULL,NULL,NULL),
(14,'Diabetes','2025-05-01',NULL,'Moderada','XXXXXXXXXXXXXXXXX',NULL,NULL),
(15,'Diabetes','2025-05-01',NULL,'Moderada','XXXXXXXXXXXXXXXXX',NULL,NULL),
(16,'Diabetes','2025-04-01',NULL,'Moderada','XXXXXXXXXXXXXXXX',NULL,NULL),
(17,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(18,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(19,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(20,'Diabetes',NULL,'XXXXXXXXXXXXXXX','Moderada','Insulina',NULL,NULL),
(21,'Disautonomia','2024-09-05','XXXXXXXXXXXX','Moderada','XXXXXXXXXXXX',NULL,NULL),
(22,'Hiper tenso','2025-02-27','XXXXXXXXXXXXXXXXXXXXXXXXXXX','Grave','XXXXXXXXXXXXXXXXXXXXXXXXXXX',NULL,NULL),
(23,'RINITIS, SINUSITIS','2024-09-04','INFLACIÓN DE CODOS','Grave','NO TIENE CONOCIMIENTO, Y SE LE DEBE HACER SEGUIMIENTO',NULL,NULL),
(26,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(27,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(28,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(29,'Diabetes','2025-02-07','XXXXXXXXXXXX','Leve','XXXXXXXXXXXX',NULL,NULL),
(30,'Diabetes','2025-02-07','XXXXXXXXXXXX','Leve','XXXXXXXXXXXX',NULL,NULL),
(31,'Diabetes','2025-02-07','XXXXXXXXXXXX','Leve','XXXXXXXXXXXX',NULL,NULL),
(32,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(33,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(34,'Diabetes','2025-05-13','XXXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXX',NULL,NULL),
(35,'Hiper tenso','2025-02-27','XXXXXXXXXXXXXXXXXXXXXXXXXXX','Grave','XXXXXXXXXXXXXXXXXXXXXXXXXXX',NULL,NULL),
(36,'Diabetes','2025-03-06','XXXXXXXXXXXXXXXXX','Moderada','XXXXXXXXXXXXXXXXXX',NULL,NULL),
(37,'RINITIS, SINUSITIS','2025-01-02','xxxxxxxxxxxxxxxxxxxxxxXXX','Leve','xxxxxxxxxxxxxxxxxxxxxxXXX',NULL,NULL),
(38,'RINITIS, SINUSITIS','2025-01-02','xxxxxxxxxxxxxxxxxxxxxxXXX','Leve','xxxxxxxxxxxxxxxxxxxxxxXXX',NULL,NULL),
(39,'RINITIS, SINUSITIS','2025-01-02','xxxxxxxxxxxxxxxxxxxxxxXXX','Leve','xxxxxxxxxxxxxxxxxxxxxxXXX',NULL,NULL),
(40,'RINITIS, SINUSITIS','2025-01-02','xxxxxxxxxxxxxxxxxxxxxxXXX','Leve','xxxxxxxxxxxxxxxxxxxxxxXXX',NULL,NULL),
(41,'Diabetes','2024-06-06','XXXXXXXXXXXXXXXXXX','Grave','XXXXXXXXXXXXXXXXXX',NULL,NULL),
(42,'Diabetes','2025-02-07','XXXXXXXXXXXX','Leve','XXXXXXXXXXXX',NULL,NULL),
(43,'Diabetes','2024-09-04','XXXXXXXXXXXXXXXXXX','Moderada','XXXXXXXXXXXXXXXXXXXXX',NULL,NULL),
(44,'Diabetes','2025-05-08','XXXXXXXXXXXXXXX','Leve','XXXXXXXXXXXXXXX',NULL,NULL);
/*!40000 ALTER TABLE `patologia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rango_edad`
--

DROP TABLE IF EXISTS `rango_edad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rango_edad` (
  `id_rango` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `edad_minima` int(11) DEFAULT NULL,
  `edad_maxima` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rango`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rango_edad`
--

LOCK TABLES `rango_edad` WRITE;
/*!40000 ALTER TABLE `rango_edad` DISABLE KEYS */;
INSERT INTO `rango_edad` VALUES
(1,18,25,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(2,25,30,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(3,30,35,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(4,35,40,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(5,40,45,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(6,45,50,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(7,50,55,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(8,55,60,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(9,60,65,'2025-07-07 18:36:26','2025-07-07 18:36:26'),
(10,65,70,'2025-07-07 18:36:26','2025-07-07 18:36:26');
/*!40000 ALTER TABLE `rango_edad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_documento` (
  `id_tipo_documento` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo_documento` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_documento`),
  UNIQUE KEY `tipo_documento_nombre_tipo_documento_unique` (`nombre_tipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documento`
--

LOCK TABLES `tipo_documento` WRITE;
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
INSERT INTO `tipo_documento` VALUES
(1,'Cédula de Ciudadanía',NULL,NULL),
(2,'Tarjeta de Identidad',NULL,NULL),
(3,'Cédula de Extranjería',NULL,NULL);
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-13 19:23:12
