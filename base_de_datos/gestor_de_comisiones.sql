-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-11-2024 a las 03:06:59
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `identificacion`, `fecha`, `estado`) VALUES
(1, '1117016370', '2024-01-15', 'Presente'),
(2, '123456789', '2024-01-01', 'Ausente'),
(3, '123456789', '2024-01-02', 'Presente');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `bonificaciones`
--

INSERT INTO `bonificaciones` (`id`, `identificacion`, `motivo`, `monto`, `fecha_asignacion`) VALUES
(1, '1117016370', 'Bonificación por cumplimiento de meta en 2024-01', 300000.00, '2024-11-23'),
(2, '123456789', 'Bonificación por cumplimiento de meta en 2024-01', 300000.00, '2024-11-23'),
(3, '123456789', 'por lindo', 5000000.00, '2024-11-23'),
(4, '1231232123', 'Bonificación por cumplimiento de meta en 2024-02', 300000.00, '2024-11-24'),
(5, '1117016370', 'Bonificación por cumplimiento de meta en 2024-02', 300000.00, '2024-11-24');

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
  UNIQUE KEY `uc_identificacion_periodo` (`identificacion`,`periodo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `metas_ventas`
--

INSERT INTO `metas_ventas` (`id`, `identificacion`, `periodo`, `meta`, `ventas_actuales`, `cumplida`) VALUES
(7, '1117016370', '2024-01', 5000.00, 40000.00, 1),
(8, '1117016370', '2024-02', 10000.00, 50000.00, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reportes_desempeno`
--

INSERT INTO `reportes_desempeno` (`id`, `identificacion`, `periodo`, `ventas_totales`, `metas_cumplidas`, `bonificaciones_totales`, `porcentaje_cumplimiento`, `dias_trabajados`, `ausencias`) VALUES
(1, '1117016370', '2024-02', 50000.00, 1, 0.00, 100.00, 0, 0),
(2, '1117016370', '2024-01', 40000.00, 1, 0.00, 100.00, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rol` enum('admin','empleado') NOT NULL DEFAULT 'empleado',
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `contraseña`, `nombre`, `fecha_registro`, `rol`, `activo`) VALUES
(8, 'johan37021@gmail.com', '$2y$10$gtO6ViDEA2Gh5yYnQPL4juOX9iYyCzfNqqrxL954u/dED4QRSSBBi', 'Johan Alejandro Gómez Cifuentes', '2024-11-24 03:46:50', 'empleado', 1),
(10, 'johan37021@admin.com', '$2y$10$bioAEMUnROvw1uj7Nl5aCuOQlgUsRgkzqJAS4GAvCNaskJqd52x2m', 'Johan Alejandro Gómez Cifuentes', '2024-11-24 04:32:00', 'admin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
CREATE TABLE IF NOT EXISTS `vendedores` (
  `identificacion` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`identificacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`identificacion`, `nombre`, `correo`, `telefono`, `activo`) VALUES
('1117016370', 'Johan Alejandro Gómez Cifuentes', 'johan37021@gmail.com', '2334788', 1),
('1231232123', 'Cristian Giraldo Osorio', 'cristian.giraldo4@utp.edu.co', '2334788', 1);

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
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `identificacion` (`identificacion`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `identificacion`, `producto`, `cantidad`, `total`, `fecha_venta`, `comision`, `activo`) VALUES
(33, '1117016370', 'Tv', 1, 50000.00, '2024-02-06', 5000.00, 1),
(32, '1117016370', 'Tv', 1, 10000.00, '2024-01-02', 1000.00, 1),
(30, '1117016370', 'Tv', 1, 10000.00, '2024-01-02', 1000.00, 1),
(31, '1117016370', 'Tv', 1, 10000.00, '2024-01-02', 1000.00, 1),
(29, '1117016370', 'Tv', 1, 10000.00, '2024-01-09', 1000.00, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
