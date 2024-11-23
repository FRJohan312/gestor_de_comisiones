-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-11-2024 a las 20:47:25
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `bonificaciones`
--

INSERT INTO `bonificaciones` (`id`, `identificacion`, `motivo`, `monto`, `fecha_asignacion`) VALUES
(1, '1117016370', 'Bonificación por cumplimiento de meta en 2024-01', 300000.00, '2024-11-23'),
(2, '123456789', 'Bonificación por cumplimiento de meta en 2024-01', 300000.00, '2024-11-23'),
(3, '123456789', 'por lindo', 5000000.00, '2024-11-23');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `metas_ventas`
--

INSERT INTO `metas_ventas` (`id`, `identificacion`, `periodo`, `meta`, `ventas_actuales`, `cumplida`) VALUES
(1, '1117016370', '2024-01', 5000.00, 5000.00, 1),
(2, '123456789', '2024-01', 5000.00, 16000.00, 1),
(3, '123456789', '2024-01', 80000.00, 16000.00, 0),
(4, '123456789', '2024-02', 16000.00, 8000.00, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reportes_desempeno`
--

INSERT INTO `reportes_desempeno` (`id`, `identificacion`, `periodo`, `ventas_totales`, `metas_cumplidas`, `bonificaciones_totales`, `porcentaje_cumplimiento`, `dias_trabajados`, `ausencias`) VALUES
(1, '1117016370', '2024-01', 5000.00, 1, 0.00, 100.00, 1, 0),
(2, '123456789', '2024-01', 16000.00, 1, 0.00, 50.00, 1, 1),
(3, '123456789', '2024-03', 8000.00, 0, 0.00, 0.00, 0, 0),
(4, '1117016370', '2024-02', 8000.00, 0, 0.00, 0.00, 0, 0),
(5, '123456789', '2024-02', 8000.00, 0, 0.00, 0.00, 0, 0);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `contraseña`, `nombre`, `fecha_registro`) VALUES
(1, 'johan.gomez@utp.edu.co', 'asdasdadsd', 'Johan Alejandro Gómez Cifuentes', '2024-11-23 17:26:08'),
(2, 'johan37021@gmail.com', 'johangomez', 'Johan Alejandro Gómez Cifuentes', '2024-11-23 17:31:22'),
(3, 'cristian.giraldo4@utp.edu.co', '12345678', 'Cristian Giraldo Osorio', '2024-11-23 20:25:45');

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
('1117016370', 'Johan Alejandro Gómez Cifuentes', 'johan.gomez@utp.edu.co', '3187477491', '2024-11-23 16:42:29'),
('123456789', 'Cristian Giraldo Osorio', 'cristian.giraldo4@utp.edu.co', '1828128', '2024-11-23 20:13:43');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `identificacion`, `producto`, `cantidad`, `total`, `fecha_venta`, `comision`) VALUES
(1, '1117016370', 'Tv', 1, 5000.00, '2024-01-08', 500.00),
(2, '123456789', 'Gasimba', 1, 8000.00, '2024-01-10', 800.00),
(3, '123456789', 'Gasimba', 1, 8000.00, '2024-01-11', 800.00),
(4, '123456789', 'Gasimba', 1, 8000.00, '2024-03-11', 800.00),
(5, '1117016370', 'Gasimba', 1, 8000.00, '2024-02-11', 800.00),
(6, '123456789', 'Gasimba', 1, 8000.00, '2024-02-11', 800.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
