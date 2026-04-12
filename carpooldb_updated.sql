SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `carpooldb`;
USE `carpooldb`;

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `IdUsuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Correo` varchar(120) NOT NULL,
  `Contrasena` varchar(150) NOT NULL,
  `NombreCompleto` varchar(150) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1,
  `FechaCreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `FechaActualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdUsuario`),
  UNIQUE KEY `Correo` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4;

INSERT INTO `usuarios` (`IdUsuario`, `Correo`, `Contrasena`, `NombreCompleto`, `Telefono`, `Activo`, `FechaCreacion`, `FechaActualizacion`) VALUES
(1, 'sergio@colima.tecnm.mx', '$2y$12$Lr6LZoLdDw4Q5XqtK9MLnugSTzpF0rdsaMcOwAq/fmnbXBAwV04Wa', 'Sergio Alejandro', '3121234567', 1, '2026-03-26 16:30:49', '2026-03-26 16:30:49'),
(2, 'santi@colima.tecnm.mx', '$2y$12$2jSQE3xTfSnlmgkklynjmOXg2jNzZ5KgiTJJeI8raZyVNK1YXSofW', 'Santi', '3120000001', 1, '2026-03-26 16:30:49', '2026-03-26 16:30:49'),
(3, 'paul@colima.tecnm.mx', '$2y$12$p5CUs8UEIQVaDWut0Csguu1AXiujBYg0pif03Fln4WOz3zMuMbFhq', 'Paul', '3120000002', 1, '2026-03-26 16:30:49', '2026-03-26 16:30:49');

COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
