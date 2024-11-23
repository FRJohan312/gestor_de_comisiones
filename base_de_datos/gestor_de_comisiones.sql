-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-11-2024 a las 04:48:44
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_de_comisiones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('Presente','Ausente') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identificacion` (`identificacion`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `identificacion`, `fecha`, `estado`) VALUES
(1, '1088258342', '2024-01-08', 'Presente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonificaciones`
--

DROP TABLE IF EXISTS `bonificaciones`;
CREATE TABLE IF NOT EXISTS `bonificaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(50) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_asignacion` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identificacion` (`identificacion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `bonificaciones`
--

INSERT INTO `bonificaciones` (`id`, `identificacion`, `motivo`, `monto`, `fecha_asignacion`) VALUES
(1, '1088258342', 'Desempleo', 1.00, '2024-11-22'),
(2, '1088258342', 'Desempleo', 13000000.00, '2024-11-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas_ventas`
--

DROP TABLE IF EXISTS `metas_ventas`;
CREATE TABLE IF NOT EXISTS `metas_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(50) NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `meta` decimal(10,2) NOT NULL,
  `ventas_actuales` decimal(10,2) DEFAULT '0.00',
  `cumplida` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `identificacion` (`identificacion`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `metas_ventas`
--

INSERT INTO `metas_ventas` (`id`, `identificacion`, `periodo`, `meta`, `ventas_actuales`, `cumplida`) VALUES
(6, '11170163701', '2024-01', 5000.00, 5000.00, 1),
(5, '1088258342', '2024-01', 12000.00, 12000.00, 1),
(7, '66907540', '2024-01', 5000.00, 5000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes_desempeno`
--

DROP TABLE IF EXISTS `reportes_desempeno`;
CREATE TABLE IF NOT EXISTS `reportes_desempeno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(50) NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `ventas_totales` decimal(10,2) DEFAULT '0.00',
  `metas_cumplidas` int DEFAULT '0',
  `bonificaciones_totales` decimal(10,2) DEFAULT '0.00',
  `porcentaje_cumplimiento` decimal(5,2) DEFAULT '0.00',
  `dias_trabajados` int DEFAULT '0',
  `ausencias` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `identificacion` (`identificacion`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reportes_desempeno`
--

INSERT INTO `reportes_desempeno` (`id`, `identificacion`, `periodo`, `ventas_totales`, `metas_cumplidas`, `bonificaciones_totales`, `porcentaje_cumplimiento`, `dias_trabajados`, `ausencias`) VALUES
(1, '66907540', '2024-01', 5000.00, 1, 0.00, 100.00, 0, 0),
(2, '11170163701', '2024-01', 5000.00, 1, 0.00, 100.00, 0, 0),
(3, '1088258342', '2024-01', 12000.00, 1, 0.00, 100.00, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
CREATE TABLE IF NOT EXISTS `vendedores` (
  `identificacion` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`identificacion`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`identificacion`, `nombre`, `correo`, `telefono`, `fecha_registro`) VALUES
('1088258342', 'johan gomez', 'johan.gomez@utp.edu.co', '272812382738', '2024-11-22 17:17:03'),
('1117016370', 'johan gomez', 'johan37021@gmail.com', '3187477491', '2024-11-22 17:48:40'),
('11170163701', 'asddsa', 'johan370212@gmail.com', '3187477491', '2024-11-23 03:44:16'),
('66907540', 'Alejandro Perez Osoario', 'johan.gomeaz@utp.edu.co', '3187477491', '2024-11-23 04:34:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(50) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `cantidad` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_venta` date NOT NULL,
  `comision` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `identificacion` (`identificacion`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `identificacion`, `producto`, `cantidad`, `total`, `fecha_venta`, `comision`) VALUES
(14, '66907540', 'Tv', 1, 5000.00, '2024-01-09', 500.00),
(13, '11170163701', 'Tv', 1, 5000.00, '2024-01-08', 500.00),
(12, '1088258342', 'Tv', 1, 4000.00, '2024-01-09', 400.00),
(11, '1088258342', 'Tv', 2, 8000.00, '2024-01-08', 800.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
