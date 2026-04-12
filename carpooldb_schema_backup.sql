-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: carpooldb
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calificaciones` (
  `IdCalificacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdViaje` bigint(20) unsigned NOT NULL,
  `IdUsuario` bigint(20) unsigned NOT NULL,
  `IdEmisor` bigint(20) unsigned NOT NULL,
  `Estrellas` int(11) NOT NULL,
  `Comentario` text DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdCalificacion`),
  KEY `calificaciones_idviaje_foreign` (`IdViaje`),
  KEY `calificaciones_idusuario_foreign` (`IdUsuario`),
  KEY `calificaciones_idemisor_foreign` (`IdEmisor`),
  CONSTRAINT `calificaciones_idemisor_foreign` FOREIGN KEY (`IdEmisor`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_idviaje_foreign` FOREIGN KEY (`IdViaje`) REFERENCES `viajes` (`IdViaje`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estadossolicitud`
--

DROP TABLE IF EXISTS `estadossolicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadossolicitud` (
  `IdEstado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(50) NOT NULL,
  PRIMARY KEY (`IdEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estadosviaje`
--

DROP TABLE IF EXISTS `estadosviaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadosviaje` (
  `IdEstado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(50) NOT NULL,
  PRIMARY KEY (`IdEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes` (
  `IdMensaje` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdViaje` bigint(20) unsigned NOT NULL,
  `IdRemitente` bigint(20) unsigned NOT NULL,
  `Contenido` text NOT NULL,
  `FechaEnvio` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdMensaje`),
  KEY `mensajes_idviaje_foreign` (`IdViaje`),
  KEY `mensajes_idremitente_foreign` (`IdRemitente`),
  CONSTRAINT `mensajes_idremitente_foreign` FOREIGN KEY (`IdRemitente`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE,
  CONSTRAINT `mensajes_idviaje_foreign` FOREIGN KEY (`IdViaje`) REFERENCES `viajes` (`IdViaje`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participantesviaje`
--

DROP TABLE IF EXISTS `participantesviaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participantesviaje` (
  `IdViaje` bigint(20) unsigned NOT NULL,
  `IdUsuario` bigint(20) unsigned NOT NULL,
  `IdSolicitud` bigint(20) unsigned DEFAULT NULL,
  `FechaSalida` datetime DEFAULT NULL,
  PRIMARY KEY (`IdViaje`,`IdUsuario`),
  KEY `participantesviaje_idusuario_foreign` (`IdUsuario`),
  KEY `participantesviaje_idsolicitud_foreign` (`IdSolicitud`),
  CONSTRAINT `participantesviaje_idsolicitud_foreign` FOREIGN KEY (`IdSolicitud`) REFERENCES `solicitudesviaje` (`IdSolicitud`) ON DELETE CASCADE,
  CONSTRAINT `participantesviaje_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE,
  CONSTRAINT `participantesviaje_idviaje_foreign` FOREIGN KEY (`IdViaje`) REFERENCES `viajes` (`IdViaje`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rutas`
--

DROP TABLE IF EXISTS `rutas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rutas` (
  `IdRuta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdOrigen` bigint(20) unsigned NOT NULL,
  `IdDestino` bigint(20) unsigned NOT NULL,
  `DistanciaKm` decimal(8,2) DEFAULT NULL,
  `DuracionEstimada` time DEFAULT NULL,
  PRIMARY KEY (`IdRuta`),
  KEY `rutas_idorigen_foreign` (`IdOrigen`),
  KEY `rutas_iddestino_foreign` (`IdDestino`),
  CONSTRAINT `rutas_iddestino_foreign` FOREIGN KEY (`IdDestino`) REFERENCES `ubicaciones` (`IdUbicacion`) ON DELETE CASCADE,
  CONSTRAINT `rutas_idorigen_foreign` FOREIGN KEY (`IdOrigen`) REFERENCES `ubicaciones` (`IdUbicacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `solicitudesviaje`
--

DROP TABLE IF EXISTS `solicitudesviaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitudesviaje` (
  `IdSolicitud` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdViaje` bigint(20) unsigned NOT NULL,
  `IdUsuario` bigint(20) unsigned NOT NULL,
  `AsientosSolicitados` int(11) NOT NULL,
  `IdEstado` bigint(20) unsigned NOT NULL,
  `FechaRespuesta` datetime DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdSolicitud`),
  KEY `solicitudesviaje_idviaje_foreign` (`IdViaje`),
  KEY `solicitudesviaje_idusuario_foreign` (`IdUsuario`),
  KEY `solicitudesviaje_idestado_foreign` (`IdEstado`),
  CONSTRAINT `solicitudesviaje_idestado_foreign` FOREIGN KEY (`IdEstado`) REFERENCES `estadossolicitud` (`IdEstado`) ON DELETE CASCADE,
  CONSTRAINT `solicitudesviaje_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE,
  CONSTRAINT `solicitudesviaje_idviaje_foreign` FOREIGN KEY (`IdViaje`) REFERENCES `viajes` (`IdViaje`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ubicaciones`
--

DROP TABLE IF EXISTS `ubicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ubicaciones` (
  `IdUbicacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Ciudad` varchar(255) NOT NULL,
  PRIMARY KEY (`IdUbicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehiculos` (
  `IdVehiculo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdUsuario` bigint(20) unsigned NOT NULL,
  `Modelo` varchar(255) NOT NULL,
  `Placas` varchar(255) NOT NULL,
  `Color` varchar(255) NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1,
  `FotoUrl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdVehiculo`),
  UNIQUE KEY `vehiculos_placas_unique` (`Placas`),
  KEY `vehiculos_idusuario_foreign` (`IdUsuario`),
  CONSTRAINT `vehiculos_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `viajes`
--

DROP TABLE IF EXISTS `viajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viajes` (
  `IdViaje` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdRuta` bigint(20) unsigned NOT NULL,
  `IdConductor` bigint(20) unsigned NOT NULL,
  `IdVehiculo` bigint(20) unsigned NOT NULL,
  `FechaSalida` datetime NOT NULL,
  `LlegadaEstimada` datetime DEFAULT NULL,
  `AsientosTotales` int(11) NOT NULL,
  `AsientosDisponibles` int(11) NOT NULL,
  `PrecioPorPasajero` decimal(8,2) DEFAULT NULL,
  `Notas` text DEFAULT NULL,
  `IdEstado` bigint(20) unsigned NOT NULL,
  `FechaPublicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdViaje`),
  KEY `viajes_idruta_foreign` (`IdRuta`),
  KEY `viajes_idconductor_foreign` (`IdConductor`),
  KEY `viajes_idvehiculo_foreign` (`IdVehiculo`),
  KEY `viajes_idestado_foreign` (`IdEstado`),
  CONSTRAINT `viajes_idconductor_foreign` FOREIGN KEY (`IdConductor`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE,
  CONSTRAINT `viajes_idestado_foreign` FOREIGN KEY (`IdEstado`) REFERENCES `estadosviaje` (`IdEstado`) ON DELETE CASCADE,
  CONSTRAINT `viajes_idruta_foreign` FOREIGN KEY (`IdRuta`) REFERENCES `rutas` (`IdRuta`) ON DELETE CASCADE,
  CONSTRAINT `viajes_idvehiculo_foreign` FOREIGN KEY (`IdVehiculo`) REFERENCES `vehiculos` (`IdVehiculo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-11 18:19:33
