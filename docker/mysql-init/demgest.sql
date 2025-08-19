-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-07-2025 a las 14:36:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `demgest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afcs`
--

CREATE TABLE `afcs` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `afcs`
--

INSERT INTO `afcs` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'COLFONDOS', '2025-07-09 18:09:17', '2025-07-09 18:09:17'),
(2, 'FONDO NACIONAL DEL AHORRO', '2025-07-09 18:09:17', '2025-07-09 18:09:17'),
(3, 'PORVENIR', '2025-07-09 18:09:17', '2025-07-09 18:09:17'),
(4, 'PROTECCIÓN', '2025-07-09 18:09:17', '2025-07-09 18:09:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afp`
--

CREATE TABLE `afp` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `afp`
--

INSERT INTO `afp` (`id`, `nombre`) VALUES
(1, 'Protección'),
(2, 'Porvenir'),
(3, 'Colfondos'),
(4, 'Old Mutual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_adjuntos`
--

CREATE TABLE `archivos_adjuntos` (
  `id` int(10) UNSIGNED NOT NULL,
  `empleado_id` bigint(20) UNSIGNED NOT NULL,
  `beneficiario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos_adjuntos`
--

INSERT INTO `archivos_adjuntos` (`id`, `empleado_id`, `beneficiario_id`, `nombre`, `ruta`, `tipo`, `created_at`, `updated_at`) VALUES
(2, 155, NULL, '1752265986_GFPI-F-165SELECCIONMODIFICACIONALTERNATIVAETAPAPRODUCTIVA2_nuevo (1) (2).xlsx', 'adjuntos_empleados/155/adjunto1/1752265986_GFPI-F-165SELECCIONMODIFICACIONALTERNATIVAETAPAPRODUCTIVA2_nuevo (1) (2).xlsx', 'xlsx', '2025-07-12 01:33:06', '2025-07-12 01:33:06'),
(3, 155, NULL, '1752265986_BITACORA2.pdf', 'adjuntos_empleados/155/adjunto2/1752265986_BITACORA2.pdf', 'pdf', '2025-07-12 01:33:06', '2025-07-12 01:33:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arl`
--

CREATE TABLE `arl` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arl`
--

INSERT INTO `arl` (`id`, `nombre`) VALUES
(1, 'ARL Sura'),
(2, 'ARL Colpatria'),
(3, 'ARL Bolívar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrio`
--

CREATE TABLE `barrio` (
  `id_barrio` bigint(20) UNSIGNED NOT NULL,
  `nombre_barrio` varchar(100) NOT NULL,
  `municipio_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `barrio`
--

INSERT INTO `barrio` (`id_barrio`, `nombre_barrio`, `municipio_id`, `created_at`, `updated_at`) VALUES
(5, 'Aguas Frías', 1, NULL, NULL),
(6, 'Aldea Pablo VI', 1, NULL, NULL),
(7, 'Alejandro Echavarría', 1, NULL, NULL),
(8, 'Alejandría', 1, NULL, NULL),
(9, 'Alfonso López', 1, NULL, NULL),
(10, 'Altamira', 1, NULL, NULL),
(11, 'Altavista', 1, NULL, NULL),
(12, 'Altavista Sector Central', 1, NULL, NULL),
(13, 'Altos del Poblado', 1, NULL, NULL),
(14, 'Andalucía', 1, NULL, NULL),
(15, 'Antonio Nariño', 1, NULL, NULL),
(16, 'Aranjuez', 1, NULL, NULL),
(17, 'Asomadera No.1', 1, NULL, NULL),
(18, 'Asomadera No.2', 1, NULL, NULL),
(19, 'Asomadera No.3', 1, NULL, NULL),
(20, 'Astorga', 1, NULL, NULL),
(21, 'Aures No.1', 1, NULL, NULL),
(22, 'Aures No.2', 1, NULL, NULL),
(23, 'B. Cerro El Volador', 1, NULL, NULL),
(24, 'Barrio Caicedo', 1, NULL, NULL),
(25, 'Barrio Colombia', 1, NULL, NULL),
(26, 'Barrio Colón', 1, NULL, NULL),
(27, 'Barrio Cristóbal', 1, NULL, NULL),
(28, 'Barrios de Jesús', 1, NULL, NULL),
(29, 'Barro Blanco', 1, NULL, NULL),
(30, 'Batallón Cuarta Brigada', 1, NULL, NULL),
(31, 'Batallón Girardot', 1, NULL, NULL),
(32, 'Belalcázar', 1, NULL, NULL),
(33, 'Belencito', 1, NULL, NULL),
(34, 'Bello Horizonte', 1, NULL, NULL),
(35, 'Belén', 1, NULL, NULL),
(36, 'Berlín', 1, NULL, NULL),
(37, 'Bermejal-Los Álamos', 1, NULL, NULL),
(38, 'Betania', 1, NULL, NULL),
(39, 'Blanquizal', 1, NULL, NULL),
(40, 'Bolivariana', 1, NULL, NULL),
(41, 'Bomboná No.1', 1, NULL, NULL),
(42, 'Bomboná No.2', 1, NULL, NULL),
(43, 'Boquerón', 1, NULL, NULL),
(44, 'Bosques de San Pablo', 1, NULL, NULL),
(45, 'Boston', 1, NULL, NULL),
(46, 'Boyacá', 1, NULL, NULL),
(47, 'Brasilia', 1, NULL, NULL),
(48, 'Buenos Aires', 1, NULL, NULL),
(49, 'Buga Patio Bonito', 1, NULL, NULL),
(50, 'Cabecera Urbana Corregimiento San Cristóbal', 1, NULL, NULL),
(51, 'Calasanz', 1, NULL, NULL),
(52, 'Calasanz Parte Alta', 1, NULL, NULL),
(53, 'Calle Nueva', 1, NULL, NULL),
(54, 'Campo Alegre', 1, NULL, NULL),
(55, 'Campo Amor', 1, NULL, NULL),
(56, 'Campo Valdés No.1', 1, NULL, NULL),
(57, 'Campo Valdés No.2', 1, NULL, NULL),
(58, 'Caribe', 1, NULL, NULL),
(59, 'Carlos E. Restrepo', 1, NULL, NULL),
(60, 'Carpinelo', 1, NULL, NULL),
(61, 'Castilla', 1, NULL, NULL),
(62, 'Castropol', 1, NULL, NULL),
(63, 'Cataluña', 1, NULL, NULL),
(64, 'Cementerio Universal', 1, NULL, NULL),
(65, 'Centro Administrativo', 1, NULL, NULL),
(66, 'Cerro Nutibara', 1, NULL, NULL),
(67, 'Corazón de Jesús', 1, NULL, NULL),
(68, 'Cristo Rey', 1, NULL, NULL),
(69, 'Cuarta Brigada', 1, NULL, NULL),
(70, 'Cucaracho', 1, NULL, NULL),
(71, 'Córdoba', 1, NULL, NULL),
(72, 'Diego Echavarría', 1, NULL, NULL),
(73, 'Doce de Octubre No.1', 1, NULL, NULL),
(74, 'Doce de Octubre No.2', 1, NULL, NULL),
(75, 'Ecoparque Cerro El Volador', 1, NULL, NULL),
(76, 'Eduardo Santos', 1, NULL, NULL),
(77, 'El Astillero', 1, NULL, NULL),
(78, 'El Carmelo', 1, NULL, NULL),
(79, 'El Castillo', 1, NULL, NULL),
(80, 'El Cerro', 1, NULL, NULL),
(81, 'El Chagualo', 1, NULL, NULL),
(82, 'El Compromiso', 1, NULL, NULL),
(83, 'El Corazón', 1, NULL, NULL),
(84, 'El Corazón El Morro', 1, NULL, NULL),
(85, 'El Danubio', 1, NULL, NULL),
(86, 'El Diamante', 1, NULL, NULL),
(87, 'El Diamante No.2', 1, NULL, NULL),
(88, 'El Jardín', 1, NULL, NULL),
(89, 'El Llano', 1, NULL, NULL),
(90, 'El Llano SE', 1, NULL, NULL),
(91, 'El Nogal-Los Almendros', 1, NULL, NULL),
(92, 'El Patio', 1, NULL, NULL),
(93, 'El Pesebre', 1, NULL, NULL),
(94, 'El Picacho', 1, NULL, NULL),
(95, 'El Pinal', 1, NULL, NULL),
(96, 'El Placer', 1, NULL, NULL),
(97, 'El Plan', 1, NULL, NULL),
(98, 'El Poblado', 1, NULL, NULL),
(99, 'El Pomar', 1, NULL, NULL),
(100, 'El Progreso', 1, NULL, NULL),
(101, 'El Raizal', 1, NULL, NULL),
(102, 'El Rincón', 1, NULL, NULL),
(103, 'El Rodeo', 1, NULL, NULL),
(104, 'El Salado', 1, NULL, NULL),
(105, 'El Salvador', 1, NULL, NULL),
(106, 'El Socorro', 1, NULL, NULL),
(107, 'El Tesoro', 1, NULL, NULL),
(108, 'El Triunfo', 1, NULL, NULL),
(109, 'El Uvito', 1, NULL, NULL),
(110, 'El Velódromo', 1, NULL, NULL),
(111, 'Enciso', 1, NULL, NULL),
(112, 'Estación Villa', 1, NULL, NULL),
(113, 'Estadio', 1, NULL, NULL),
(114, 'Facultad Veterinaria y Zootecnia U.de.A.', 1, NULL, NULL),
(115, 'Facultad de Minas', 1, NULL, NULL),
(116, 'Facultad de Minas U. Nacional', 1, NULL, NULL),
(117, 'Ferrini', 1, NULL, NULL),
(118, 'Florencia', 1, NULL, NULL),
(119, 'Florida Nueva', 1, NULL, NULL),
(120, 'Francisco Antonio Zea', 1, NULL, NULL),
(121, 'Fuente Clara', 1, NULL, NULL),
(122, 'Fátima', 1, NULL, NULL),
(123, 'Gerona', 1, NULL, NULL),
(124, 'Girardot', 1, NULL, NULL),
(125, 'Granada', 1, NULL, NULL),
(126, 'Granizal', 1, NULL, NULL),
(127, 'Guayabal', 1, NULL, NULL),
(128, 'Guayaquil', 1, NULL, NULL),
(129, 'Hospital San Vicente de Paúl', 1, NULL, NULL),
(130, 'Héctor Abad Gómez', 1, NULL, NULL),
(131, 'Jardín Botánico', 1, NULL, NULL),
(132, 'Jesús Nazareno', 1, NULL, NULL),
(133, 'Juan Pablo II', 1, NULL, NULL),
(134, 'Juan XXIII La Quiebra', 1, NULL, NULL),
(135, 'Kennedy', 1, NULL, NULL),
(136, 'La Aguacatala', 1, NULL, NULL),
(137, 'La Aldea', 1, NULL, NULL),
(138, 'La Alpujarra', 1, NULL, NULL),
(139, 'La América', 1, NULL, NULL),
(140, 'La Avanzada', 1, NULL, NULL),
(141, 'La Candelaria', 1, NULL, NULL),
(142, 'La Castellana', 1, NULL, NULL),
(143, 'La Colina', 1, NULL, NULL),
(144, 'La Cruz', 1, NULL, NULL),
(145, 'La Cuchilla', 1, NULL, NULL),
(146, 'La Esperanza', 1, NULL, NULL),
(147, 'La Esperanza No.2', 1, NULL, NULL),
(148, 'La Floresta', 1, NULL, NULL),
(149, 'La Florida', 1, NULL, NULL),
(150, 'La Francia', 1, NULL, NULL),
(151, 'La Frisola', 1, NULL, NULL),
(152, 'La Frontera', 1, NULL, NULL),
(153, 'La Gloria', 1, NULL, NULL),
(154, 'La Hondonada', 1, NULL, NULL),
(155, 'La Ilusión', 1, NULL, NULL),
(156, 'La Isla', 1, NULL, NULL),
(157, 'La Ladera', 1, NULL, NULL),
(158, 'La Libertad', 1, NULL, NULL),
(159, 'La Loma', 1, NULL, NULL),
(160, 'La Loma de Los Bernal', 1, NULL, NULL),
(161, 'La Mansión', 1, NULL, NULL),
(162, 'La Milagrosa', 1, NULL, NULL),
(163, 'La Mota', 1, NULL, NULL),
(164, 'La Palma', 1, NULL, NULL),
(165, 'La Pilarica', 1, NULL, NULL),
(166, 'La Piñuela', 1, NULL, NULL),
(167, 'La Pradera', 1, NULL, NULL),
(168, 'La Rosa', 1, NULL, NULL),
(169, 'La Salle', 1, NULL, NULL),
(170, 'La Sierra', 1, NULL, NULL),
(171, 'La Sucia', 1, NULL, NULL),
(172, 'La Suiza', 1, NULL, NULL),
(173, 'La Verde', 1, NULL, NULL),
(174, 'Lalinde', 1, NULL, NULL),
(175, 'Las Acacias', 1, NULL, NULL),
(176, 'Las Brisas', 1, NULL, NULL),
(177, 'Las Esmeraldas', 1, NULL, NULL),
(178, 'Las Estancias', 1, NULL, NULL),
(179, 'Las Granjas', 1, NULL, NULL),
(180, 'Las Independencias', 1, NULL, NULL),
(181, 'Las Lomas No.1', 1, NULL, NULL),
(182, 'Las Lomas No.2', 1, NULL, NULL),
(183, 'Las Mercedes', 1, NULL, NULL),
(184, 'Las Palmas', 1, NULL, NULL),
(185, 'Las Playas', 1, NULL, NULL),
(186, 'Las Violetas', 1, NULL, NULL),
(187, 'Laureles', 1, NULL, NULL),
(188, 'Llanaditas', 1, NULL, NULL),
(189, 'Lorena', 1, NULL, NULL),
(190, 'Loreto', 1, NULL, NULL),
(191, 'Los Alcázares', 1, NULL, NULL),
(192, 'Los Alpes', 1, NULL, NULL),
(193, 'Los Balsos No.1', 1, NULL, NULL),
(194, 'Los Balsos No.2', 1, NULL, NULL),
(195, 'Los Cerros El Vergel', 1, NULL, NULL),
(196, 'Los Colores', 1, NULL, NULL),
(197, 'Los Conquistadores', 1, NULL, NULL),
(198, 'Los Mangos', 1, NULL, NULL),
(199, 'Los Naranjos', 1, NULL, NULL),
(200, 'Los Pinos', 1, NULL, NULL),
(201, 'Los Ángeles', 1, NULL, NULL),
(202, 'López de  Mesa', 1, NULL, NULL),
(203, 'Manila', 1, NULL, NULL),
(204, 'Manrique Central No.1', 1, NULL, NULL),
(205, 'Manrique Central No.2', 1, NULL, NULL),
(206, 'Manrique Oriental', 1, NULL, NULL),
(207, 'María Cano-Carambolas', 1, NULL, NULL),
(208, 'Mazo', 1, NULL, NULL),
(209, 'Media Luna', 1, NULL, NULL),
(210, 'Metropolitano', 1, NULL, NULL),
(211, 'Mirador del Doce', 1, NULL, NULL),
(212, 'Miraflores', 1, NULL, NULL),
(213, 'Miranda', 1, NULL, NULL),
(214, 'Miravalle', 1, NULL, NULL),
(215, 'Montañita', 1, NULL, NULL),
(216, 'Monteclaro', 1, NULL, NULL),
(217, 'Moravia', 1, NULL, NULL),
(218, 'Moscú No.1', 1, NULL, NULL),
(219, 'Moscú No.2', 1, NULL, NULL),
(220, 'Naranjal', 1, NULL, NULL),
(221, 'Nueva Villa de La Iguaná', 1, NULL, NULL),
(222, 'Nueva Villa del Aburrá', 1, NULL, NULL),
(223, 'Nuevos Conquistadores', 1, NULL, NULL),
(224, 'Ocho de Marzo', 1, NULL, NULL),
(225, 'Olaya Herrera', 1, NULL, NULL),
(226, 'Oleoducto', 1, NULL, NULL),
(227, 'Oriente', 1, NULL, NULL),
(228, 'Pablo VI', 1, NULL, NULL),
(229, 'Pajarito', 1, NULL, NULL),
(230, 'Palenque', 1, NULL, NULL),
(231, 'Palermo', 1, NULL, NULL),
(232, 'Palmitas Sector Central', 1, NULL, NULL),
(233, 'Parque Juan Pablo II', 1, NULL, NULL),
(234, 'Parque Norte', 1, NULL, NULL),
(235, 'Patio Bonito', 1, NULL, NULL),
(236, 'Pedregal', 1, NULL, NULL),
(237, 'Pedregal Alto', 1, NULL, NULL),
(238, 'Perpetuo Socorro', 1, NULL, NULL),
(239, 'Picachito', 1, NULL, NULL),
(240, 'Picacho', 1, NULL, NULL),
(241, 'Piedra Gorda', 1, NULL, NULL),
(242, 'Piedras Blancas - Matasano', 1, NULL, NULL),
(243, 'Playón de Los Comuneros', 1, NULL, NULL),
(244, 'Plaza de Ferias', 1, NULL, NULL),
(245, 'Popular', 1, NULL, NULL),
(246, 'Potrera Miserenga', 1, NULL, NULL),
(247, 'Potrerito', 1, NULL, NULL),
(248, 'Prado', 1, NULL, NULL),
(249, 'Progreso No.2', 1, NULL, NULL),
(250, 'Robledo', 1, NULL, NULL),
(251, 'Rosales', 1, NULL, NULL),
(252, 'San Antonio', 1, NULL, NULL),
(253, 'San Antonio de Prado', 1, NULL, NULL),
(254, 'San Benito', 1, NULL, NULL),
(255, 'San Bernardo', 1, NULL, NULL),
(256, 'San Diego', 1, NULL, NULL),
(257, 'San Germán', 1, NULL, NULL),
(258, 'San Isidro', 1, NULL, NULL),
(259, 'San Javier No.1', 1, NULL, NULL),
(260, 'San Javier No.2', 1, NULL, NULL),
(261, 'San Joaquín', 1, NULL, NULL),
(262, 'San José', 1, NULL, NULL),
(263, 'San José La Cima No.1', 1, NULL, NULL),
(264, 'San José La Cima No.2', 1, NULL, NULL),
(265, 'San José de La Montaña', 1, NULL, NULL),
(266, 'San José del Manzanillo', 1, NULL, NULL),
(267, 'San Lucas', 1, NULL, NULL),
(268, 'San Martín de Porres', 1, NULL, NULL),
(269, 'San Miguel', 1, NULL, NULL),
(270, 'San Pablo', 1, NULL, NULL),
(271, 'San Pedro', 1, NULL, NULL),
(272, 'Santa Cruz', 1, NULL, NULL),
(273, 'Santa Elena Sector Central', 1, NULL, NULL),
(274, 'Santa Fé', 1, NULL, NULL),
(275, 'Santa Inés', 1, NULL, NULL),
(276, 'Santa Lucía', 1, NULL, NULL),
(277, 'Santa Margarita', 1, NULL, NULL),
(278, 'Santa María de Los Ángeles', 1, NULL, NULL),
(279, 'Santa Mónica', 1, NULL, NULL),
(280, 'Santa Rosa de Lima', 1, NULL, NULL),
(281, 'Santa Teresita', 1, NULL, NULL),
(282, 'Santander', 1, NULL, NULL),
(283, 'Santo Domingo Savio No.1', 1, NULL, NULL),
(284, 'Santo Domingo Savio No.2', 1, NULL, NULL),
(285, 'Sevilla', 1, NULL, NULL),
(286, 'Simón Bolívar', 1, NULL, NULL),
(287, 'Sin Nombre', 1, NULL, NULL),
(288, 'Sucre', 1, NULL, NULL),
(289, 'Suramericana', 1, NULL, NULL),
(290, 'Tejelo', 1, NULL, NULL),
(291, 'Tenche', 1, NULL, NULL),
(292, 'Terminal de Transporte', 1, NULL, NULL),
(293, 'Toscana', 1, NULL, NULL),
(294, 'Travesías', 1, NULL, NULL),
(295, 'Trece de Noviembre', 1, NULL, NULL),
(296, 'Tricentenario', 1, NULL, NULL),
(297, 'Trinidad', 1, NULL, NULL),
(298, 'U.D. Atanasio Girardot', 1, NULL, NULL),
(299, 'U.P.B', 1, NULL, NULL),
(300, 'Universidad Nacional', 1, NULL, NULL),
(301, 'Universidad de Antioquia', 1, NULL, NULL),
(302, 'Urquitá', 1, NULL, NULL),
(303, 'Veinte de Julio', 1, NULL, NULL),
(304, 'Versalles No.1', 1, NULL, NULL),
(305, 'Versalles No.2', 1, NULL, NULL),
(306, 'Villa Carlota', 1, NULL, NULL),
(307, 'Villa Flora', 1, NULL, NULL),
(308, 'Villa Guadalupe', 1, NULL, NULL),
(309, 'Villa Hermosa', 1, NULL, NULL),
(310, 'Villa Lilliam', 1, NULL, NULL),
(311, 'Villa Niza', 1, NULL, NULL),
(312, 'Villa Nueva', 1, NULL, NULL),
(313, 'Villa Turbay', 1, NULL, NULL),
(314, 'Villa del Socorro', 1, NULL, NULL),
(315, 'Villatina', 1, NULL, NULL),
(316, 'Volcana Guayabal', 1, NULL, NULL),
(317, 'Yarumalito', 1, NULL, NULL),
(318, 'Yolombo', 1, NULL, NULL),
(319, 'Área de Expansión Altavista', 1, NULL, NULL),
(320, 'Área de Expansión Belén Rincón', 1, NULL, NULL),
(321, 'Área de Expansión El Noral', 1, NULL, NULL),
(322, 'Área de Expansión Pajarito', 1, NULL, NULL),
(323, 'Área de Expansión San Antonio de Prado', 1, NULL, NULL),
(324, 'Área de Expansión San Cristóbal', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios`
--

CREATE TABLE `beneficiarios` (
  `id_beneficiario` bigint(20) UNSIGNED NOT NULL,
  `empleado_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_beneficiario` varchar(255) NOT NULL,
  `parentesco` varchar(50) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `tipo_documento_id` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_documento` varchar(255) DEFAULT NULL,
  `nivel_educativo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reside_con_empleado` tinyint(1) DEFAULT NULL COMMENT '\r\n',
  `depende_economicamente` tinyint(1) DEFAULT NULL,
  `contacto_emergencia` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `beneficiarios`
--

INSERT INTO `beneficiarios` (`id_beneficiario`, `empleado_id`, `nombre_beneficiario`, `parentesco`, `fecha_nacimiento`, `tipo_documento_id`, `numero_documento`, `nivel_educativo`, `created_at`, `updated_at`, `reside_con_empleado`, `depende_economicamente`, `contacto_emergencia`) VALUES
(4, 84, 'marquiños jr', 'Hijo/a', '1995-10-20', 2, '8955269254', 'Secundaria', '2025-06-20 19:18:12', '2025-06-20 19:18:12', NULL, NULL, NULL),
(21, 85, 'Pepito', 'Cónyuge', '2025-06-11', 1, '1477266993', 'Primaria', '2025-06-25 00:55:05', '2025-06-25 00:55:05', NULL, NULL, NULL),
(55, 145, 'Pepito', 'Padre', '2023-12-06', 1, '87444557', 'Preescolar', '2025-07-08 02:10:15', '2025-07-08 02:10:15', 1, 1, '3692695948'),
(58, 135, 'Pepito', 'Madre', '2023-01-10', 2, '3320145149', 'Primaria', '2025-07-09 18:30:11', '2025-07-09 18:30:11', 1, 1, '2147483647'),
(63, 147, 'JAVIER ANTONIO CORDOBA PALENCIA', 'Cónyuge', '1963-03-13', 1, '71603765', NULL, '2025-07-09 19:31:45', '2025-07-09 19:31:45', 1, 0, '3154043389'),
(64, 148, 'marquiños jr', 'Hijo/a', '2023-12-14', 1, '6345215', 'Primaria', '2025-07-10 00:01:16', '2025-07-10 00:01:16', 1, 1, '3012378915'),
(65, 149, 'XXXXXXXXXXXXXXXXXX', 'Hijo/a', '2024-02-29', 1, '2453453745', 'Primaria', '2025-07-12 00:18:04', '2025-07-12 00:18:04', 1, 1, '3001238915');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` bigint(20) UNSIGNED NOT NULL,
  `nombre_cargo` varchar(250) NOT NULL,
  `centro_costo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre_cargo`, `centro_costo_id`, `created_at`, `updated_at`) VALUES
(1, 'ASESOR', 1, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(2, 'AUXILIAR ADMINISTRATIVA', 1, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(3, 'SECRETARIO GENERAL', 1, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(4, 'DIRECTOR DE PLANEACION FINANCIERA', 2, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(5, 'GERENTE', 2, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(6, 'GERENTE CORPORATIVA', 2, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(7, 'LIDER DE INVESTIGACIÓN DE MERCADOS', 2, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(8, 'ANALISTA DE FORMACION Y DESARROLLO', 3, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(9, 'COORD SEGURIDAD Y SALUD EN EL TRABAJO', 3, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(10, 'ASISTENTE FINANCIERO', 4, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(11, 'AUXILIAR CARTERA Y COBRANZAS', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(12, 'AUXILIAR DE COSTOS', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(13, 'CONTADOR (A)', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(14, 'COORDINADOR DE COSTOS', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(15, 'DIRECTOR DE CONTABILIDAD', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(16, 'LIDER DE COSTOS E INVENTARIOS', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(17, 'SUPERNUMERARIA', 5, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(18, 'ARQUITECTO DE SOFTWARE', 6, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(19, 'ASISTENTE DE COMPRAS', 8, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(20, 'ASESOR TECNICO DE NEGOCIOS', 9, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(21, 'ASISTENTE COMERCIAL', 9, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(22, 'EJECUTIVO DE CUENTA', 10, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(23, 'SERVICIO AL CLIENTE', 10, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(24, 'AUXILIAR DE ALMACENAMIENTO Y DESPACHO', 12, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(25, 'AUXILIAR DE BODEGA (ALMACENISTA)', 12, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(26, 'AUXILIAR DE FACTURACION Y DESPACHOS', 12, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(27, 'IMPRESOR NP1', 12, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(28, 'IMPRESOR NP2', 13, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(29, 'IMPRESOR NP3', 14, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(30, 'IMPRESORA KOPACK', 15, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(31, 'AUXILIAR DE IMPRESION', 16, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(32, 'REBOBINADOR (A)', 17, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(33, 'COORDINADOR DE IMPRESION', 18, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(34, 'AUXILIAR ADMINISTRATIVA', 18, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(35, 'OFICIOS VARIOS', 18, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(36, 'SERVICIOS GENERALES', 18, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(37, 'OPERARIO DE PRODUCCION', 18, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(38, 'COORDINADOR DE PRODUCCION', 19, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(39, 'ELECTROMECANICO', 20, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(40, 'MECANICO DE MANTENIMIENTO', 20, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(41, 'OPERARIO MANUAL PREPRENSA', 21, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(42, 'COORDINADOR PREPENSA', 22, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(43, 'MONTAJISTA DIGITAL', 22, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(44, 'ANALISTA DE CALIDAD', 23, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(45, 'AUXILIAR DE CALIDAD', 23, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(46, 'COORDINADOR DE PROGRAMACIÓN', 24, '2025-07-07 21:52:22', '2025-07-07 21:52:22'),
(47, 'AUXILIAR DE TINTAS', 25, '2025-07-07 21:52:22', '2025-07-07 21:52:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ccf`
--

CREATE TABLE `ccf` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ccf`
--

INSERT INTO `ccf` (`id`, `nombre`) VALUES
(1, 'Comfama'),
(2, 'Comfenalco'),
(3, 'Compensar'),
(4, 'Cafam');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_costos`
--

CREATE TABLE `centro_costos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centro_costos`
--

INSERT INTO `centro_costos` (`id`, `codigo`, `nombre`, `created_at`, `updated_at`) VALUES
(1, '10000', 'Administración', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(2, '10001', 'Gerencia General', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(3, '10002', 'Gestion Humana', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(4, '10003', 'Gerencia Financiera', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(5, '10004', 'Dirección Contable', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(6, '10005', 'Dirección Sistemas', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(7, '10006', 'Nómina', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(8, '10007', 'Dirección de compras', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(9, '20000', 'Ventas', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(10, '20001', 'Comercial (Vendedores)', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(11, '20002', 'Despachos y bodega', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(12, '30001', 'Impresora NP1', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(13, '30002', 'Impresora NP2', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(14, '30003', 'Impresora NP3', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(15, '30004', 'Impresora Kopack', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(16, '30005', 'Mano de obra directa operarios (aux)', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(17, '30006', 'Mano de obra directa rebobinado', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(18, '40000', 'APOYO PRODUCCION', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(19, '40001', 'Gerencia de planta', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(20, '40003', 'Mantenimiento', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(21, '40004', 'Laboratorio', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(22, '40005', 'Preprensa digital', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(23, '40006', 'Calidad', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(24, '40007', 'Programacion', '2025-07-07 21:05:11', '2025-07-07 21:05:11'),
(25, '40009', 'Tintas', '2025-07-07 21:05:11', '2025-07-07 21:05:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades_laborales`
--

CREATE TABLE `ciudades_laborales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades_laborales`
--

INSERT INTO `ciudades_laborales` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'medellin', NULL, NULL),
(2, 'Sabaneta', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` bigint(20) UNSIGNED NOT NULL,
  `nombre_departamento` varchar(100) NOT NULL,
  `pais_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre_departamento`, `pais_id`, `created_at`, `updated_at`) VALUES
(1, 'Antioquia', 1, NULL, NULL),
(2, 'Cundinamarca', 1, NULL, NULL),
(3, 'Valle del Cauca', 1, NULL, NULL),
(4, 'Atlántico', 1, NULL, NULL),
(5, 'Santander', 1, NULL, NULL),
(6, 'Madrid', 2, NULL, NULL),
(7, 'Cataluña', 2, NULL, NULL),
(8, 'Andalucía', 2, NULL, NULL),
(9, 'Galicia', 2, NULL, NULL),
(10, 'Valencia', 2, NULL, NULL),
(11, 'Distrito Capital', 3, NULL, NULL),
(12, 'Miranda', 3, NULL, NULL),
(13, 'Zulia', 3, NULL, NULL),
(14, 'Lara', 3, NULL, NULL),
(15, 'Carabobo', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discapacidad`
--

CREATE TABLE `discapacidad` (
  `id_discapacidad` bigint(20) UNSIGNED NOT NULL,
  `tipo_discapacidad` varchar(100) NOT NULL,
  `grado_discapacidad` varchar(100) DEFAULT NULL,
  `fecha_diagnostico_discapacidad` date DEFAULT NULL,
  `enfermedad_base` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `discapacidad`
--

INSERT INTO `discapacidad` (`id_discapacidad`, `tipo_discapacidad`, `grado_discapacidad`, `fecha_diagnostico_discapacidad`, `enfermedad_base`, `created_at`, `updated_at`) VALUES
(1, 'Sensorial', 'Moderado', '2018-03-01', 'Sí', '2025-05-30 18:02:16', '2025-05-30 18:02:16'),
(6, 'Física', 'Leve', '2024-09-24', NULL, NULL, NULL),
(8, 'Visual', 'Moderada', '2024-09-19', NULL, NULL, NULL),
(9, 'Intelectual', 'Leve', '2025-06-01', 'f41546456415', NULL, NULL),
(10, 'Visual', 'Leve', '2025-06-19', '54465', NULL, NULL),
(11, 'Psicosocial', 'Moderada', NULL, '87587663873', NULL, NULL),
(12, 'Física', 'Severa', NULL, '87587663873', NULL, NULL),
(13, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(14, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(15, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(16, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(17, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(18, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(19, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(20, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(21, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(22, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(23, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(24, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(25, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(26, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(27, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(28, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(29, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(30, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(31, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(32, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(33, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(34, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(35, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(36, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(37, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(38, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(39, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(40, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(41, 'Física', 'Moderada', '2025-03-13', '87587663873', NULL, NULL),
(42, 'Intelectual', 'Moderada', '2024-11-08', NULL, NULL, NULL),
(43, 'Intelectual', 'Moderada', '2024-11-08', NULL, NULL, NULL),
(44, 'Visual', 'Severa', '2024-10-10', NULL, NULL, NULL),
(47, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(48, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(49, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(50, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(51, 'Física', 'Leve', '2025-06-01', '87587663873', NULL, NULL),
(52, 'Física', 'Leve', '2025-06-01', NULL, NULL, NULL),
(53, 'Visual', 'Severa', '2024-10-10', NULL, NULL, NULL),
(54, 'Visual', 'Moderada', '2025-07-09', NULL, NULL, NULL),
(55, 'Visual', 'Severa', '2025-07-07', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` bigint(20) UNSIGNED NOT NULL,
  `tipo_documento_id` bigint(20) UNSIGNED NOT NULL,
  `numero_documento` varchar(255) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('MASCULINO','FEMENINO','OTRO') NOT NULL DEFAULT 'OTRO',
  `estado_civil` enum('Soltero(a)','Casado(a)','Union Libre','Viudo(a)','Divorciado(a)') NOT NULL DEFAULT 'Soltero(a)',
  `nivel_educativo` varchar(100) DEFAULT NULL,
  `rango_edad_id` bigint(20) UNSIGNED DEFAULT NULL,
  `eps_id` int(11) DEFAULT NULL,
  `afp_id` int(11) DEFAULT NULL,
  `arl_id` int(11) DEFAULT NULL,
  `ccf_id` int(11) DEFAULT NULL,
  `afc_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono_fijo` varchar(20) DEFAULT NULL,
  `tipo_vivienda` varchar(100) DEFAULT NULL,
  `estrato` int(11) DEFAULT NULL,
  `vehiculo_propio` tinyint(1) DEFAULT NULL,
  `tipo_vehiculo` varchar(100) DEFAULT NULL,
  `movilidad` varchar(100) DEFAULT NULL,
  `institucion_educativa` varchar(150) DEFAULT NULL,
  `intereses_personales` text DEFAULT NULL,
  `idiomas` text DEFAULT NULL,
  `padre_o_madre` tinyint(1) DEFAULT NULL,
  `etnia_id` bigint(20) UNSIGNED DEFAULT NULL,
  `grupo_sanguineo_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `tipo_documento_id`, `numero_documento`, `nombre_completo`, `fecha_nacimiento`, `sexo`, `estado_civil`, `nivel_educativo`, `rango_edad_id`, `eps_id`, `afp_id`, `arl_id`, `ccf_id`, `afc_id`, `created_at`, `updated_at`, `deleted_at`, `email`, `telefono`, `direccion`, `telefono_fijo`, `tipo_vivienda`, `estrato`, `vehiculo_propio`, `tipo_vehiculo`, `movilidad`, `institucion_educativa`, `intereses_personales`, `idiomas`, `padre_o_madre`, `etnia_id`, `grupo_sanguineo_id`) VALUES
(1, 1, '10123123', 'JUAN PÉREZ GONZALEZ', '1997-11-01', 'MASCULINO', 'Soltero(a)', 'Tecnólogo', 2, 2, 3, 3, 2, NULL, '2025-05-30 17:51:42', '2025-07-08 23:19:08', NULL, 'santig..o.918171@gmail.com', '3012378915', 'Calle Falsa 123', NULL, 'Propia', 2, 1, 'Carro', 'privado', 'Alfonso lopez pumarejo', 'XXXXXXXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXXX', 1, 2, 1),
(29, 1, '1066795268', 'Santiago Perea', '2002-02-22', 'MASCULINO', 'Soltero(a)', 'Primaria', 1, NULL, NULL, NULL, NULL, NULL, '2025-05-28 17:27:49', '2025-06-17 00:15:14', NULL, 'santigo918171@gmail.com', '3007181813', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 1, '1022145156', 'Santiago Perez Gonzalez', '2006-01-17', 'MASCULINO', 'Soltero(a)', 'Tecnólogo', 1, NULL, NULL, NULL, NULL, NULL, '2025-06-04 18:46:36', '2025-06-06 22:55:05', NULL, 'santigo918112@gmail.com', '+57300718181', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 1, '7895632567', 'marquiños', '1993-10-15', 'MASCULINO', 'Soltero(a)', 'Profesional', 1, NULL, NULL, NULL, NULL, NULL, '2025-06-20 19:18:12', '2025-06-20 19:18:12', NULL, 'santigo9@gmail.com', '3012378111', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 1, '1022141696', 'Pancho chamaco', '1996-01-31', 'MASCULINO', 'Casado(a)', 'Tecnólogo', 1, NULL, NULL, NULL, NULL, NULL, '2025-06-25 00:55:04', '2025-06-25 00:55:04', NULL, 'santigo9181748888888888884848484841@gmail.com', '3001594836', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 2, '1020463183', 'Jaime Andres Cañas Velez', '1994-09-04', 'MASCULINO', 'Casado(a)', 'Tecnólogo', 2, NULL, NULL, NULL, NULL, NULL, '2025-06-25 01:51:05', '2025-06-25 01:51:05', NULL, 'jaime.canas@formacol.com', '3207304094', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 1, '1128051525', 'Hansel Alarcon Arango', '1986-10-15', 'MASCULINO', 'Casado(a)', 'Profesional', 2, NULL, NULL, NULL, NULL, NULL, '2025-06-25 02:04:50', '2025-06-25 02:04:50', NULL, 'hansel.alarcon@formacol.com', '3207304094', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 1, '1035850707', 'Yeison Alejandro Sepulveda Villa', '2004-09-11', 'MASCULINO', 'Soltero(a)', 'Técnico', 1, NULL, NULL, NULL, NULL, NULL, '2025-06-25 02:12:43', '2025-06-25 02:12:43', NULL, 'yei@formacol.com', '3007181813', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 1, '1552219505', 'Yunior Alexander bravo Cuadrados', '1997-10-25', 'MASCULINO', 'Soltero(a)', 'Secundaria', 1, NULL, NULL, NULL, NULL, NULL, '2025-06-28 02:16:21', '2025-06-28 02:16:21', NULL, 'yunioralexanderbravo11@gmail.com', '3042374688', 'CARRERA 39a #67-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 1, '102211', 'tomas muller', '1997-07-16', 'MASCULINO', 'Soltero(a)', 'Especialización', 4, NULL, NULL, NULL, NULL, NULL, '2025-07-01 19:53:42', '2025-07-01 19:53:42', NULL, 'san@ti171gmail.com', '3007181813', 'calle 56 be #20b 108', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 1, '1055797123', 'pepinillo de mar', '1998-03-05', 'MASCULINO', 'Union Libre', 'Profesional', 3, NULL, NULL, NULL, NULL, NULL, '2025-07-02 23:33:33', '2025-07-02 23:33:33', NULL, 'jnasqw46e2@foracol.com', '3554126882', 'CARRERA 39a #67-23', NULL, 'Propia', 3, 1, 'Carro', 'privado', 'Alfonso lopez pumarejo', 'AAAAAAAAAAAAA', 'ingles puteado y valiendo monda', 1, 2, 2),
(118, 1, '152797123', 'pepinillo de mar', '1998-03-05', 'MASCULINO', 'Union Libre', 'Profesional', 3, NULL, NULL, NULL, NULL, NULL, '2025-07-02 23:40:35', '2025-07-02 23:40:35', NULL, 'jna12e2@foracol.com', '3784126882', 'CARRERA 39a #67-23', NULL, 'Propia', 3, 1, 'Carro', 'privado', 'Alfonso lopez pumarejo', 'AAAAAAAAAAAAA', 'ingles puteado y valiendo monda', 1, 2, 2),
(135, 2, '8456189', 'PEPE', '1995-07-05', 'MASCULINO', 'Casado(a)', 'Técnico', 2, 2, 2, 2, 1, NULL, '2025-07-04 20:26:50', '2025-07-09 18:30:11', NULL, 'santadsasdas18171@gmail.com', '3001941813', 'calle 56 be #20b 108', NULL, 'Propia', 2, 1, 'Carro', 'privado', 'Alfonso lopez pumarejo', 'XXXXXXXXXXXX', 'XXXXXXXXXXXX', 1, 1, 2),
(140, 1, '43826066', 'ANA MARIA ZULUAGA BARRERO', '1974-02-22', 'FEMENINO', 'Soltero(a)', 'Secundaria', 4, 1, 2, 1, 1, NULL, '2025-07-05 01:44:53', '2025-07-05 01:44:53', NULL, 'anamzuluagab13@gmail.com', '3217820428', 'CALLE 82 # 55 G 10', NULL, 'Arrendada', 2, 1, 'MOTO', 'MOTO', 'INDECAP', 'SALIR A CAMINAR', 'NATAL', 1, NULL, 1),
(145, 1, '10231213', 'Santiago Perez Gonzalez', '1978-06-13', 'MASCULINO', 'Casado(a)', 'Profesional', 8, 1, 2, 3, 2, NULL, '2025-07-08 02:10:15', '2025-07-08 02:10:15', NULL, 'sanqerasdo918171@gmail.com', '3056985648', 'calle 56 be #20b 108', '4654658', 'Propia', 2, 1, 'Carro', 'Carro', 'Alfonso lopez pumarejo', NULL, NULL, 1, 1, 5),
(147, 1, '43725298', 'CARMEN ESTER GUTIERREZ GIRALDO', '1969-08-27', 'FEMENINO', 'Casado(a)', 'Profesional', 8, 1, 1, 1, 1, NULL, '2025-07-09 19:24:28', '2025-07-09 19:28:30', NULL, 'carmengu2825@gmail.com', '3052324312', 'CALLE 77 A SUR # 55 - 110', NULL, 'Propia', 4, 1, 'Carro', 'Carro', 'JAIME ISAZA CADAVID', 'AMA DE CASA, DEPORTE, LEER', 'Natal', 1, NULL, 1),
(148, 2, '10229139', 'PEPE', '1999-03-10', 'FEMENINO', 'Soltero(a)', 'Técnico', 6, 2, 3, 2, 1, 1, '2025-07-10 00:01:16', '2025-07-10 00:01:16', NULL, 'safasdasdgo918171@gmail.com', '3684596245', 'calle 56 be #20b 108', '8741146963', 'Propia', 4, 0, 'Carro', 'MOTO', 'JAIME ISAZA CADAVID', 'ninguno', 'Ingles', 0, 3, 2),
(149, 1, '10754157', 'PEPE', '1996-07-10', 'MASCULINO', 'Casado(a)', 'Profesional', 5, 2, 1, 1, 2, 2, '2025-07-12 00:18:03', '2025-07-12 00:18:03', NULL, 'santasdasdsigo918171@gmail.com', '3003261813', 'calle 56 be #20b 108', '58945546', 'Propia', 3, 1, 'Carro', 'MOTO', 'Alfonso lopez pumarejo', 'XXXXXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXXX', 0, 5, 1),
(155, 1, '107122357', 'PEPE', '1996-07-10', 'MASCULINO', 'Casado(a)', 'Profesional', 5, 2, 1, 1, 2, 2, '2025-07-12 01:33:06', '2025-07-12 01:33:06', NULL, 'santasdas321312dsigo918171@gmail.com', '3333261813', 'calle 56 be #20b 108', '58945546', 'Propia', 3, 1, 'Carro', 'MOTO', 'Alfonso lopez pumarejo', 'XXXXXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXXX', 0, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_discapacidad`
--

CREATE TABLE `empleado_discapacidad` (
  `empleado_id` bigint(20) UNSIGNED NOT NULL,
  `discapacidad_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleado_discapacidad`
--

INSERT INTO `empleado_discapacidad` (`empleado_id`, `discapacidad_id`, `created_at`, `updated_at`) VALUES
(1, 52, NULL, NULL),
(85, 8, NULL, NULL),
(88, 8, NULL, NULL),
(135, 53, NULL, NULL),
(145, 6, NULL, NULL),
(147, 55, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_pais_ubicacion`
--

CREATE TABLE `empleado_pais_ubicacion` (
  `id_empleado_pais_ubicacion` bigint(20) UNSIGNED NOT NULL,
  `empleado_id` bigint(20) UNSIGNED NOT NULL,
  `pais_id` bigint(20) UNSIGNED NOT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `barrio_id` int(11) UNSIGNED DEFAULT NULL,
  `tipo_ubicacion` enum('NACIMIENTO','RESIDENCIA') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleado_pais_ubicacion`
--

INSERT INTO `empleado_pais_ubicacion` (`id_empleado_pais_ubicacion`, `empleado_id`, `pais_id`, `departamento_id`, `municipio_id`, `barrio_id`, `tipo_ubicacion`, `created_at`, `updated_at`) VALUES
(44, 29, 1, 1, 3, NULL, 'RESIDENCIA', '2025-05-28 17:27:49', '2025-05-28 17:27:49'),
(208, 65, 1, 1, 2, NULL, 'NACIMIENTO', '2025-06-16 18:52:02', '2025-06-16 18:52:02'),
(216, 29, 2, 8, 39, NULL, 'NACIMIENTO', '2025-06-17 00:15:14', '2025-06-17 00:15:14'),
(252, 84, 1, 1, 2, NULL, 'NACIMIENTO', '2025-06-20 19:18:12', '2025-06-20 19:18:12'),
(275, 85, 2, 7, 32, NULL, 'NACIMIENTO', '2025-06-25 00:55:04', '2025-06-25 00:55:04'),
(277, 87, 1, 1, 2, NULL, 'NACIMIENTO', '2025-06-25 01:51:05', '2025-06-25 01:51:05'),
(278, 88, 1, 1, 1, NULL, 'NACIMIENTO', '2025-06-25 02:04:50', '2025-06-25 02:04:50'),
(279, 89, 1, 1, 2, NULL, 'NACIMIENTO', '2025-06-25 02:12:43', '2025-06-25 02:12:43'),
(299, 100, 2, 7, 32, NULL, 'NACIMIENTO', '2025-06-28 02:16:21', '2025-06-28 02:16:21'),
(300, 100, 2, 7, 33, 309, 'RESIDENCIA', '2025-06-28 02:16:21', '2025-06-28 02:16:21'),
(329, 105, 3, 13, 62, NULL, 'NACIMIENTO', '2025-07-01 23:21:27', '2025-07-01 23:21:27'),
(330, 105, 2, 8, 38, 18, 'RESIDENCIA', '2025-07-01 23:21:27', '2025-07-01 23:21:27'),
(353, 117, 1, 4, 18, NULL, 'NACIMIENTO', '2025-07-02 23:33:33', '2025-07-02 23:33:33'),
(354, 117, 2, 7, 33, 19, 'RESIDENCIA', '2025-07-02 23:33:33', '2025-07-02 23:33:33'),
(355, 118, 1, 1, 2, NULL, 'NACIMIENTO', '2025-07-02 23:40:35', '2025-07-02 23:40:35'),
(356, 118, 2, 8, 38, 19, 'RESIDENCIA', '2025-07-02 23:40:35', '2025-07-02 23:40:35'),
(423, 140, 1, 1, 1, NULL, 'NACIMIENTO', '2025-07-05 01:44:53', '2025-07-05 01:44:53'),
(424, 140, 1, 1, 3, 95, 'RESIDENCIA', '2025-07-05 01:44:53', '2025-07-05 01:44:53'),
(451, 145, 2, 8, 37, NULL, 'NACIMIENTO', '2025-07-08 02:10:15', '2025-07-08 02:10:15'),
(452, 145, 3, 12, 57, 11, 'RESIDENCIA', '2025-07-08 02:10:15', '2025-07-08 02:10:15'),
(457, 1, 3, 11, 51, NULL, 'NACIMIENTO', '2025-07-09 18:22:08', '2025-07-09 18:22:08'),
(458, 1, 2, 8, 11, 17, 'RESIDENCIA', '2025-07-09 18:22:08', '2025-07-09 18:22:08'),
(459, 135, 2, 6, 29, NULL, 'NACIMIENTO', '2025-07-09 18:30:11', '2025-07-09 18:30:11'),
(460, 135, 1, 3, 13, 17, 'RESIDENCIA', '2025-07-09 18:30:11', '2025-07-09 18:30:11'),
(469, 147, 1, 1, 1, NULL, 'NACIMIENTO', '2025-07-09 19:31:45', '2025-07-09 19:31:45'),
(470, 147, 1, 1, 4, 61, 'RESIDENCIA', '2025-07-09 19:31:45', '2025-07-09 19:31:45'),
(471, 148, 1, 2, 9, NULL, 'NACIMIENTO', '2025-07-10 00:01:16', '2025-07-10 00:01:16'),
(472, 148, 1, 2, 8, 19, 'RESIDENCIA', '2025-07-10 00:01:16', '2025-07-10 00:01:16'),
(473, 149, 2, 8, 37, NULL, 'NACIMIENTO', '2025-07-12 00:18:04', '2025-07-12 00:18:04'),
(474, 149, 1, 4, 18, 17, 'RESIDENCIA', '2025-07-12 00:18:04', '2025-07-12 00:18:04'),
(485, 155, 1, 2, 8, NULL, 'NACIMIENTO', '2025-07-12 01:33:06', '2025-07-12 01:33:06'),
(486, 155, 2, 8, 37, 17, 'RESIDENCIA', '2025-07-12 01:33:06', '2025-07-12 01:33:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_patologia`
--

CREATE TABLE `empleado_patologia` (
  `empleado_id` bigint(20) UNSIGNED NOT NULL,
  `patologia_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleado_patologia`
--

INSERT INTO `empleado_patologia` (`empleado_id`, `patologia_id`, `created_at`, `updated_at`) VALUES
(1, 34, NULL, NULL),
(85, 6, NULL, NULL),
(135, 35, NULL, NULL),
(145, 31, NULL, NULL),
(147, 40, NULL, NULL),
(149, 41, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `nit_empresa` varchar(255) NOT NULL,
  `direccion_empresa` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre_empresa`, `nit_empresa`, `direccion_empresa`, `created_at`, `updated_at`) VALUES
(1, 'Contiflex', '900123456', 'Calle 123 #45-67', NULL, NULL),
(2, 'Formacol', '900987654', 'Carrera 10 #20-30', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eps`
--

CREATE TABLE `eps` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eps`
--

INSERT INTO `eps` (`id`, `nombre`) VALUES
(1, 'Sura'),
(2, 'Sanitas'),
(3, 'Nueva EPS'),
(4, 'Compensar'),
(5, 'Cafesalud');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cargo`
--

CREATE TABLE `estado_cargo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estado_id` bigint(20) UNSIGNED NOT NULL,
  `cargo_id` bigint(20) UNSIGNED NOT NULL,
  `centro_costo_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_cargo`
--

INSERT INTO `estado_cargo` (`id`, `estado_id`, `cargo_id`, `centro_costo_id`, `created_at`, `updated_at`) VALUES
(2, 45, 15, 5, '2025-06-19 22:12:17', '2025-07-07 23:09:34'),
(6, 64, 27, 1, '2025-06-20 19:18:12', '2025-06-20 19:18:12'),
(9, 65, 27, 1, '2025-06-25 00:55:04', '2025-06-25 00:55:04'),
(11, 67, 35, 2, '2025-06-25 01:51:05', '2025-06-25 01:51:05'),
(12, 68, 28, 2, '2025-06-25 02:04:50', '2025-06-25 02:04:50'),
(13, 69, 30, 3, '2025-06-25 02:12:43', '2025-06-25 02:12:43'),
(18, 77, 26, 1, '2025-06-28 02:16:21', '2025-06-28 02:16:21'),
(22, 81, 32, 4, '2025-07-01 19:53:42', '2025-07-01 23:21:27'),
(31, 90, 31, 3, '2025-07-02 23:33:33', '2025-07-02 23:33:33'),
(32, 91, 31, 3, '2025-07-02 23:40:35', '2025-07-02 23:40:35'),
(48, 107, 30, 15, '2025-07-04 20:26:50', '2025-07-09 18:30:11'),
(53, 112, 29, 2, '2025-07-05 01:44:53', '2025-07-05 01:44:53'),
(58, 117, 35, 18, '2025-07-08 02:10:15', '2025-07-08 02:10:15'),
(60, 119, 16, 5, '2025-07-09 19:24:28', '2025-07-09 19:24:28'),
(61, 120, 3, 1, '2025-07-10 00:01:16', '2025-07-10 00:01:16'),
(62, 121, 2, 1, '2025-07-12 00:18:04', '2025-07-12 00:18:04'),
(68, 127, 2, 1, '2025-07-12 01:33:06', '2025-07-12 01:33:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etnias`
--

CREATE TABLE `etnias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `etnias`
--

INSERT INTO `etnias` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Indígena', NULL, NULL),
(2, 'Rom (Gitano)', NULL, NULL),
(3, 'Raizal del Archipiélago de San Andrés', NULL, NULL),
(4, 'Palenquero de San Basilio', NULL, NULL),
(5, 'Afrocolombiano', NULL, NULL),
(6, 'Negro', NULL, NULL),
(7, 'Mulato', NULL, NULL),
(8, 'Mestizo', NULL, NULL),
(9, 'Blanco', NULL, NULL),
(10, 'Otro', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_sanguineo`
--

CREATE TABLE `grupo_sanguineo` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo_sanguineo`
--

INSERT INTO `grupo_sanguineo` (`id`, `nombre`) VALUES
(1, 'A+'),
(2, 'A-'),
(5, 'AB+'),
(6, 'AB-'),
(3, 'B+'),
(4, 'B-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_laboral`
--

CREATE TABLE `informacion_laboral` (
  `id_estado` bigint(20) UNSIGNED NOT NULL,
  `empleado_id` bigint(20) UNSIGNED NOT NULL,
  `empresa_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `cantidad_prorroga` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `duracion_prorrogas` int(10) UNSIGNED DEFAULT NULL,
  `fecha_prorroga` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_contrato` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `ubicacion_fisica` varchar(150) DEFAULT NULL,
  `ciudad_laboral_id` int(11) DEFAULT NULL,
  `aplica_dotacion` tinyint(1) DEFAULT NULL,
  `talla_camisa` varchar(10) DEFAULT NULL,
  `talla_pantalon` varchar(10) DEFAULT NULL,
  `talla_zapatos` varchar(10) DEFAULT NULL,
  `relacion_laboral` varchar(255) DEFAULT NULL COMMENT 'Relación laboral actual',
  `relacion_sindical` tinyint(1) DEFAULT NULL COMMENT '1 = Sí, 0 = No',
  `tipo_vinculacion` enum('Directo','Indirecto') NOT NULL DEFAULT 'Directo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informacion_laboral`
--

INSERT INTO `informacion_laboral` (`id_estado`, `empleado_id`, `empresa_id`, `fecha_ingreso`, `fecha_salida`, `cantidad_prorroga`, `duracion_prorrogas`, `fecha_prorroga`, `created_at`, `updated_at`, `tipo_contrato`, `observaciones`, `ubicacion_fisica`, `ciudad_laboral_id`, `aplica_dotacion`, `talla_camisa`, `talla_pantalon`, `talla_zapatos`, `relacion_laboral`, `relacion_sindical`, `tipo_vinculacion`) VALUES
(21, 29, 2, '2025-01-01', NULL, 3, 3, '2025-08-22 00:00:00', '2025-05-28 17:27:49', '2025-06-17 00:15:14', 'Aprendizaje', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(44, 65, 2, '2025-05-25', '2025-06-05', 1, 3, '2025-07-16 00:00:00', '2025-06-04 18:46:36', '2025-06-16 18:52:02', 'Indefinido', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(45, 1, 2, '2025-05-16', NULL, 2, 3, '2025-10-07 00:00:00', '2025-06-04 20:08:58', '2025-07-09 18:22:08', 'Fijo', NULL, NULL, 1, 0, 'M', '34', '40', NULL, 0, 'Directo'),
(64, 84, 1, '2024-11-08', NULL, 0, NULL, NULL, '2025-06-20 19:18:12', '2025-06-20 19:18:12', 'Fijo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(65, 85, 2, '2020-01-16', NULL, 0, NULL, NULL, '2025-06-25 00:55:04', '2025-06-25 00:55:04', 'Aprendizaje', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(67, 87, 2, '2024-10-15', NULL, 4, 3, '2025-07-30 00:00:00', '2025-06-25 01:51:05', '2025-06-25 01:52:02', 'Fijo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(68, 88, 1, '2023-11-01', NULL, 5, 12, '2025-09-24 00:00:00', '2025-06-25 02:04:50', '2025-06-25 02:24:17', 'Fijo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(69, 89, 2, '2024-10-01', NULL, 0, NULL, NULL, '2025-06-25 02:12:43', '2025-06-25 02:12:43', 'Fijo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(77, 100, 1, '2024-04-25', NULL, 0, NULL, NULL, '2025-06-28 02:16:21', '2025-06-28 02:16:21', 'Fijo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(81, 105, 1, '2025-01-01', NULL, 3, 3, '2025-08-22 00:00:00', '2025-07-01 19:53:42', '2025-07-01 23:21:27', 'Indefinido', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Directo'),
(90, 117, 2, '2024-09-17', NULL, 0, NULL, NULL, '2025-07-02 23:33:33', '2025-07-02 23:33:33', 'Fijo', NULL, NULL, 1, 1, 'M', '34', '40', NULL, NULL, 'Directo'),
(91, 118, 2, '2024-09-17', NULL, 0, NULL, NULL, '2025-07-02 23:40:35', '2025-07-02 23:40:35', 'Fijo', NULL, NULL, 1, 1, 'M', '34', '40', NULL, NULL, 'Directo'),
(107, 135, 2, '2024-11-13', '2025-07-08', 1, 3, '2025-01-04 00:00:00', '2025-07-04 20:26:50', '2025-07-09 18:30:11', 'Fijo', NULL, NULL, 1, 0, 'M', '34', '40', NULL, NULL, 'Directo'),
(112, 140, 1, '2024-01-10', NULL, 0, NULL, NULL, '2025-07-05 01:44:53', '2025-07-05 01:44:53', 'Fijo', NULL, NULL, 1, 1, 'M', '34', '40', 'Ley 50', 0, 'Directo'),
(117, 145, 2, '2023-04-25', NULL, 5, 12, '2025-03-16 00:00:00', '2025-07-08 02:10:15', '2025-07-08 02:10:15', 'Fijo', NULL, NULL, 1, 1, 'M', '34', '40', 'Ley 50', 0, 'Directo'),
(119, 147, 1, '1997-04-11', NULL, 5, 12, '1999-03-02 00:00:00', '2025-07-09 19:24:28', '2025-07-09 19:31:45', 'Indefinido', NULL, NULL, 2, 0, 'S', '38', '36', NULL, 0, 'Directo'),
(120, 148, 1, '2025-02-27', NULL, 2, 3, '2025-07-20 00:00:00', '2025-07-10 00:01:16', '2025-07-10 00:01:16', 'Obra Labor', NULL, NULL, 1, 1, 'M', '34', '38', 'Ley 50,Salario Integral', 0, 'Directo'),
(121, 149, 1, '2024-02-08', NULL, 5, 12, '2026-01-01 00:00:00', '2025-07-12 00:18:04', '2025-07-12 00:18:04', 'Fijo', NULL, NULL, 1, 1, 'M', '34', '34', 'Ley 50', 0, 'Directo'),
(127, 155, 1, '2024-02-08', NULL, 5, 12, '2026-01-01 00:00:00', '2025-07-12 01:33:06', '2025-07-12 01:33:06', 'Fijo', NULL, NULL, 1, 1, 'M', '34', '34', 'Ley 50', 0, 'Directo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_05_21_205035_create_initial_tables', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id_municipio` bigint(20) UNSIGNED NOT NULL,
  `nombre_municipio` varchar(100) NOT NULL,
  `departamento_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_municipio`, `nombre_municipio`, `departamento_id`, `created_at`, `updated_at`) VALUES
(1, 'Medellín', 1, NULL, NULL),
(2, 'Bello', 1, NULL, NULL),
(3, 'Itagüí', 1, NULL, NULL),
(4, 'Envigado', 1, NULL, NULL),
(5, 'Apartadó', 1, NULL, NULL),
(6, 'Soacha', 2, NULL, NULL),
(7, 'Zipaquirá', 2, NULL, NULL),
(8, 'Chía', 2, NULL, NULL),
(9, 'Facatativá', 2, NULL, NULL),
(10, 'Fusagasugá', 2, NULL, NULL),
(11, 'Cali', 3, NULL, NULL),
(12, 'Palmira', 3, NULL, NULL),
(13, 'Buenaventura', 3, NULL, NULL),
(14, 'Tuluá', 3, NULL, NULL),
(15, 'Jamundí', 3, NULL, NULL),
(16, 'Barranquilla', 4, NULL, NULL),
(17, 'Soledad', 4, NULL, NULL),
(18, 'Malambo', 4, NULL, NULL),
(19, 'Sabanalarga', 4, NULL, NULL),
(20, 'Baranoa', 4, NULL, NULL),
(21, 'Bucaramanga', 5, NULL, NULL),
(22, 'Floridablanca', 5, NULL, NULL),
(23, 'Barrancabermeja', 5, NULL, NULL),
(24, 'Girón', 5, NULL, NULL),
(25, 'Piedecuesta', 5, NULL, NULL),
(26, 'Madrid', 6, NULL, NULL),
(27, 'Móstoles', 6, NULL, NULL),
(28, 'Alcalá de Henares', 6, NULL, NULL),
(29, 'Fuenlabrada', 6, NULL, NULL),
(30, 'Leganés', 6, NULL, NULL),
(31, 'Barcelona', 7, NULL, NULL),
(32, 'L\'Hospitalet de Llobregat', 7, NULL, NULL),
(33, 'Badalona', 7, NULL, NULL),
(34, 'Terrassa', 7, NULL, NULL),
(35, 'Sabadell', 7, NULL, NULL),
(36, 'Sevilla', 8, NULL, NULL),
(37, 'Málaga', 8, NULL, NULL),
(38, 'Córdoba', 8, NULL, NULL),
(39, 'Granada', 8, NULL, NULL),
(40, 'Jerez de la Frontera', 8, NULL, NULL),
(41, 'Vigo', 9, NULL, NULL),
(42, 'A Coruña', 9, NULL, NULL),
(43, 'Ourense', 9, NULL, NULL),
(44, 'Lugo', 9, NULL, NULL),
(45, 'Santiago de Compostela', 9, NULL, NULL),
(46, 'València', 10, NULL, NULL),
(47, 'Alicante', 10, NULL, NULL),
(48, 'Elche', 10, NULL, NULL),
(49, 'Castelló de la Plana', 10, NULL, NULL),
(50, 'Torrevieja', 10, NULL, NULL),
(51, 'Caracas (Municipio Libertador)', 11, NULL, NULL),
(52, 'Petare (Municipio Sucre)', 11, NULL, NULL),
(53, 'Chacao', 11, NULL, NULL),
(54, 'Baruta', 11, NULL, NULL),
(55, 'El Hatillo', 11, NULL, NULL),
(56, 'Los Teques', 12, NULL, NULL),
(57, 'Guatire', 12, NULL, NULL),
(58, 'Ocumare del Tuy', 12, NULL, NULL),
(59, 'Santa Teresa del Tuy', 12, NULL, NULL),
(60, 'Caucagua', 12, NULL, NULL),
(61, 'Maracaibo', 13, NULL, NULL),
(62, 'Cabimas', 13, NULL, NULL),
(63, 'San Francisco', 13, NULL, NULL),
(64, 'Ciudad Ojeda', 13, NULL, NULL),
(65, 'Lagunillas', 13, NULL, NULL),
(66, 'Barquisimeto', 14, NULL, NULL),
(67, 'Cabudare', 14, NULL, NULL),
(68, 'Carora', 14, NULL, NULL),
(69, 'El Tocuyo', 14, NULL, NULL),
(70, 'Quíbor', 14, NULL, NULL),
(71, 'Valencia', 15, NULL, NULL),
(72, 'Guacara', 15, NULL, NULL),
(73, 'Puerto Cabello', 15, NULL, NULL),
(74, 'Mariara', 15, NULL, NULL),
(75, 'Naguanagua', 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` bigint(20) UNSIGNED NOT NULL,
  `nombre_pais` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id_pais`, `nombre_pais`, `created_at`, `updated_at`) VALUES
(1, 'Colombia', NULL, NULL),
(2, 'España', NULL, NULL),
(3, 'Venezuela', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologia`
--

CREATE TABLE `patologia` (
  `id_patologia` bigint(20) UNSIGNED NOT NULL,
  `nombre_patologia` varchar(255) NOT NULL,
  `fecha_diagnostico` date DEFAULT NULL,
  `descripcion_patologia` varchar(100) DEFAULT NULL,
  `gravedad_patologia` varchar(50) DEFAULT NULL,
  `tratamiento_actual_patologia` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patologia`
--

INSERT INTO `patologia` (`id_patologia`, `nombre_patologia`, `fecha_diagnostico`, `descripcion_patologia`, `gravedad_patologia`, `tratamiento_actual_patologia`, `created_at`, `updated_at`) VALUES
(1, 'Diabetes', NULL, 'Crónica', 'Alta', 'Insulina', '2025-05-30 17:56:07', '2025-05-30 17:56:07'),
(2, 'ugajfk', '2025-01-14', 'Nose...', 'Grave', 'ffwfewfwefw', NULL, NULL),
(3, 'Asma', '2025-06-01', 'fgtmnfgnfdnffdgdg', 'Moderada', 'gdngdgfddfndfndfgdfngdf', NULL, NULL),
(4, 'Diabetes', '2020-01-14', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'Muy Grave', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', NULL, NULL),
(5, 'Asma', '2025-04-03', 'XXXXXXXXXXXXXXXXX', 'Moderada', 'XXXXXXXXXXXXXXXXX', NULL, NULL),
(6, 'Diabetes', '2025-02-14', 'XXXXXXXXXXXXXXXXXXXXXXXXX', 'Moderada', 'XXXXXXXXXXXXXXXXXXXXXXXXX', NULL, NULL),
(7, 'Diabetes', '2025-06-17', 'Esta puteado', 'Moderada', 'Desconocido', NULL, NULL),
(8, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Diabetes', '2025-05-01', NULL, 'Moderada', 'XXXXXXXXXXXXXXXXX', NULL, NULL),
(15, 'Diabetes', '2025-05-01', NULL, 'Moderada', 'XXXXXXXXXXXXXXXXX', NULL, NULL),
(16, 'Diabetes', '2025-04-01', NULL, 'Moderada', 'XXXXXXXXXXXXXXXX', NULL, NULL),
(17, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(18, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(19, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(20, 'Diabetes', NULL, 'XXXXXXXXXXXXXXX', 'Moderada', 'Insulina', NULL, NULL),
(21, 'Disautonomia', '2024-09-05', 'XXXXXXXXXXXX', 'Moderada', 'XXXXXXXXXXXX', NULL, NULL),
(22, 'Hiper tenso', '2025-02-27', 'XXXXXXXXXXXXXXXXXXXXXXXXXXX', 'Grave', 'XXXXXXXXXXXXXXXXXXXXXXXXXXX', NULL, NULL),
(23, 'RINITIS, SINUSITIS', '2024-09-04', 'INFLACIÓN DE CODOS', 'Grave', 'NO TIENE CONOCIMIENTO, Y SE LE DEBE HACER SEGUIMIENTO', NULL, NULL),
(26, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(27, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(28, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(29, 'Diabetes', '2025-02-07', 'XXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXX', NULL, NULL),
(30, 'Diabetes', '2025-02-07', 'XXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXX', NULL, NULL),
(31, 'Diabetes', '2025-02-07', 'XXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXX', NULL, NULL),
(32, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(33, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(34, 'Diabetes', '2025-05-13', 'XXXXXXXXXXXXXXXX', 'Leve', 'XXXXXXXXXXXXX', NULL, NULL),
(35, 'Hiper tenso', '2025-02-27', 'XXXXXXXXXXXXXXXXXXXXXXXXXXX', 'Grave', 'XXXXXXXXXXXXXXXXXXXXXXXXXXX', NULL, NULL),
(36, 'Diabetes', '2025-03-06', 'XXXXXXXXXXXXXXXXX', 'Moderada', 'XXXXXXXXXXXXXXXXXX', NULL, NULL),
(37, 'RINITIS, SINUSITIS', '2025-01-02', 'xxxxxxxxxxxxxxxxxxxxxxXXX', 'Leve', 'xxxxxxxxxxxxxxxxxxxxxxXXX', NULL, NULL),
(38, 'RINITIS, SINUSITIS', '2025-01-02', 'xxxxxxxxxxxxxxxxxxxxxxXXX', 'Leve', 'xxxxxxxxxxxxxxxxxxxxxxXXX', NULL, NULL),
(39, 'RINITIS, SINUSITIS', '2025-01-02', 'xxxxxxxxxxxxxxxxxxxxxxXXX', 'Leve', 'xxxxxxxxxxxxxxxxxxxxxxXXX', NULL, NULL),
(40, 'RINITIS, SINUSITIS', '2025-01-02', 'xxxxxxxxxxxxxxxxxxxxxxXXX', 'Leve', 'xxxxxxxxxxxxxxxxxxxxxxXXX', NULL, NULL),
(41, 'Diabetes', '2024-06-06', 'XXXXXXXXXXXXXXXXXX', 'Grave', 'XXXXXXXXXXXXXXXXXX', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rango_edad`
--

CREATE TABLE `rango_edad` (
  `id_rango` bigint(20) UNSIGNED NOT NULL,
  `edad_minima` int(11) DEFAULT NULL,
  `edad_maxima` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rango_edad`
--

INSERT INTO `rango_edad` (`id_rango`, `edad_minima`, `edad_maxima`, `created_at`, `updated_at`) VALUES
(1, 18, 25, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(2, 25, 30, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(3, 30, 35, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(4, 35, 40, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(5, 40, 45, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(6, 45, 50, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(7, 50, 55, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(8, 55, 60, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(9, 60, 65, '2025-07-07 18:36:26', '2025-07-07 18:36:26'),
(10, 65, 70, '2025-07-07 18:36:26', '2025-07-07 18:36:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` bigint(20) UNSIGNED NOT NULL,
  `nombre_tipo_documento` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `nombre_tipo_documento`, `created_at`, `updated_at`) VALUES
(1, 'Cédula de Ciudadanía', NULL, NULL),
(2, 'Tarjeta de Identidad', NULL, NULL),
(3, 'Cédula de Extranjería', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `afcs`
--
ALTER TABLE `afcs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `afp`
--
ALTER TABLE `afp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `archivos_adjuntos`
--
ALTER TABLE `archivos_adjuntos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_archivos_empleado` (`empleado_id`),
  ADD KEY `fk_archivos_beneficiario` (`beneficiario_id`);

--
-- Indices de la tabla `arl`
--
ALTER TABLE `arl`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `barrio`
--
ALTER TABLE `barrio`
  ADD PRIMARY KEY (`id_barrio`),
  ADD KEY `barrio_municipio_id_foreign` (`municipio_id`);

--
-- Indices de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`id_beneficiario`),
  ADD KEY `beneficiarios_empleado_id_foreign` (`empleado_id`),
  ADD KEY `beneficiarios_tipo_documento_id_foreign` (`tipo_documento_id`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`),
  ADD KEY `fk_cargo_centro_costo` (`centro_costo_id`);

--
-- Indices de la tabla `ccf`
--
ALTER TABLE `ccf`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `ciudades_laborales`
--
ALTER TABLE `ciudades_laborales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `departamento_pais_id_foreign` (`pais_id`);

--
-- Indices de la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  ADD PRIMARY KEY (`id_discapacidad`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `empleados_numero_documento_unique` (`numero_documento`),
  ADD KEY `empleados_tipo_documento_id_foreign` (`tipo_documento_id`),
  ADD KEY `empleados_rango_edad_id_foreign` (`rango_edad_id`),
  ADD KEY `fk_eps` (`eps_id`),
  ADD KEY `fk_afp` (`afp_id`),
  ADD KEY `fk_arl` (`arl_id`),
  ADD KEY `fk_ccf` (`ccf_id`),
  ADD KEY `fk_empleados_etnia` (`etnia_id`),
  ADD KEY `fk_empleados_grupo_sanguineo` (`grupo_sanguineo_id`),
  ADD KEY `afc_id` (`afc_id`);

--
-- Indices de la tabla `empleado_discapacidad`
--
ALTER TABLE `empleado_discapacidad`
  ADD PRIMARY KEY (`empleado_id`,`discapacidad_id`),
  ADD KEY `empleado_discapacidad_discapacidad_id_foreign` (`discapacidad_id`);

--
-- Indices de la tabla `empleado_pais_ubicacion`
--
ALTER TABLE `empleado_pais_ubicacion`
  ADD PRIMARY KEY (`id_empleado_pais_ubicacion`),
  ADD UNIQUE KEY `empleado_pais_ubicacion_empleado_id_tipo_ubicacion_unique` (`empleado_id`,`tipo_ubicacion`),
  ADD KEY `empleado_pais_ubicacion_pais_id_foreign` (`pais_id`);

--
-- Indices de la tabla `empleado_patologia`
--
ALTER TABLE `empleado_patologia`
  ADD PRIMARY KEY (`empleado_id`,`patologia_id`),
  ADD KEY `empleado_patologia_patologia_id_foreign` (`patologia_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD UNIQUE KEY `empresa_nit_empresa_unique` (`nit_empresa`);

--
-- Indices de la tabla `eps`
--
ALTER TABLE `eps`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_cargo`
--
ALTER TABLE `estado_cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_id` (`estado_id`),
  ADD KEY `cargo_id` (`cargo_id`),
  ADD KEY `centro_costo_id` (`centro_costo_id`);

--
-- Indices de la tabla `etnias`
--
ALTER TABLE `etnias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo_sanguineo`
--
ALTER TABLE `grupo_sanguineo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  ADD PRIMARY KEY (`id_estado`),
  ADD KEY `estado_empleado_id_foreign` (`empleado_id`),
  ADD KEY `estado_empresa_id_foreign` (`empresa_id`),
  ADD KEY `fk_ciudad_laboral` (`ciudad_laboral_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id_municipio`),
  ADD KEY `municipio_departamento_id_foreign` (`departamento_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`),
  ADD UNIQUE KEY `pais_nombre_pais_unique` (`nombre_pais`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `patologia`
--
ALTER TABLE `patologia`
  ADD PRIMARY KEY (`id_patologia`);

--
-- Indices de la tabla `rango_edad`
--
ALTER TABLE `rango_edad`
  ADD PRIMARY KEY (`id_rango`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`),
  ADD UNIQUE KEY `tipo_documento_nombre_tipo_documento_unique` (`nombre_tipo_documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `afcs`
--
ALTER TABLE `afcs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `afp`
--
ALTER TABLE `afp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `archivos_adjuntos`
--
ALTER TABLE `archivos_adjuntos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `arl`
--
ALTER TABLE `arl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `barrio`
--
ALTER TABLE `barrio`
  MODIFY `id_barrio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  MODIFY `id_beneficiario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `ccf`
--
ALTER TABLE `ccf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `ciudades_laborales`
--
ALTER TABLE `ciudades_laborales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  MODIFY `id_discapacidad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `empleado_pais_ubicacion`
--
ALTER TABLE `empleado_pais_ubicacion`
  MODIFY `id_empleado_pais_ubicacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eps`
--
ALTER TABLE `eps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_cargo`
--
ALTER TABLE `estado_cargo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `etnias`
--
ALTER TABLE `etnias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `grupo_sanguineo`
--
ALTER TABLE `grupo_sanguineo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  MODIFY `id_estado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id_municipio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id_pais` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `rango_edad`
--
ALTER TABLE `rango_edad`
  MODIFY `id_rango` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos_adjuntos`
--
ALTER TABLE `archivos_adjuntos`
  ADD CONSTRAINT `fk_archivos_beneficiario` FOREIGN KEY (`beneficiario_id`) REFERENCES `beneficiarios` (`id_beneficiario`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_archivos_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `barrio`
--
ALTER TABLE `barrio`
  ADD CONSTRAINT `barrio_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id_municipio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD CONSTRAINT `beneficiarios_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiarios_tipo_documento_id_foreign` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id_tipo_documento`) ON DELETE SET NULL;

--
-- Filtros para la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `fk_cargo_centro_costo` FOREIGN KEY (`centro_costo_id`) REFERENCES `centro_costos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id_pais`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_rango_edad_id_foreign` FOREIGN KEY (`rango_edad_id`) REFERENCES `rango_edad` (`id_rango`),
  ADD CONSTRAINT `empleados_tipo_documento_id_foreign` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id_tipo_documento`),
  ADD CONSTRAINT `fk_afc_empleado` FOREIGN KEY (`afc_id`) REFERENCES `afcs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_afp` FOREIGN KEY (`afp_id`) REFERENCES `afp` (`id`),
  ADD CONSTRAINT `fk_arl` FOREIGN KEY (`arl_id`) REFERENCES `arl` (`id`),
  ADD CONSTRAINT `fk_ccf` FOREIGN KEY (`ccf_id`) REFERENCES `ccf` (`id`),
  ADD CONSTRAINT `fk_empleados_etnia` FOREIGN KEY (`etnia_id`) REFERENCES `etnias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_empleados_grupo_sanguineo` FOREIGN KEY (`grupo_sanguineo_id`) REFERENCES `grupo_sanguineo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eps` FOREIGN KEY (`eps_id`) REFERENCES `eps` (`id`);

--
-- Filtros para la tabla `empleado_discapacidad`
--
ALTER TABLE `empleado_discapacidad`
  ADD CONSTRAINT `empleado_discapacidad_discapacidad_id_foreign` FOREIGN KEY (`discapacidad_id`) REFERENCES `discapacidad` (`id_discapacidad`) ON DELETE CASCADE,
  ADD CONSTRAINT `empleado_discapacidad_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleado_pais_ubicacion`
--
ALTER TABLE `empleado_pais_ubicacion`
  ADD CONSTRAINT `empleado_pais_ubicacion_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `empleado_pais_ubicacion_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `empleado_pais_ubicacion_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id_pais`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleado_patologia`
--
ALTER TABLE `empleado_patologia`
  ADD CONSTRAINT `empleado_patologia_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `empleado_patologia_patologia_id_foreign` FOREIGN KEY (`patologia_id`) REFERENCES `patologia` (`id_patologia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estado_cargo`
--
ALTER TABLE `estado_cargo`
  ADD CONSTRAINT `estado_cargo_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `informacion_laboral` (`id_estado`) ON DELETE CASCADE,
  ADD CONSTRAINT `estado_cargo_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id_cargo`) ON DELETE CASCADE,
  ADD CONSTRAINT `estado_cargo_ibfk_3` FOREIGN KEY (`centro_costo_id`) REFERENCES `centro_costos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  ADD CONSTRAINT `estado_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `estado_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_ciudad_laboral` FOREIGN KEY (`ciudad_laboral_id`) REFERENCES `ciudades_laborales` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `municipio_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
