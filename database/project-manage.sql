-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para project-manage
CREATE DATABASE IF NOT EXISTS `project-manage` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `project-manage`;

-- Volcando estructura para tabla project-manage.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla project-manage.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla project-manage.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla project-manage.migrations: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla project-manage.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla project-manage.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla project-manage.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_manager` bigint(20) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` enum('1','0') NOT NULL DEFAULT '1',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_proyecto`),
  KEY `id_manager` (`id_manager`),
  CONSTRAINT `FK1_id_manager` FOREIGN KEY (`id_manager`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla project-manage.proyectos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id_proyecto`, `id_manager`, `nombre`, `descripcion`, `estado`, `fecha_registro`) VALUES
	(1, 1, 'Sistema de facturacion', 'Sistema de factuacion wey, esto es una prueba, xDDDD', '1', '2020-11-14 15:01:49'),
	(2, 4, 'Proyecto de recursos humanos', 'Este proyecto es para gestionar recursos humanos', '1', '2020-11-14 20:03:45');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla project-manage.tareas
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(11) NOT NULL DEFAULT '0',
  `id_empleado` bigint(20) unsigned DEFAULT NULL,
  `descripcion` varchar(255) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `estatus` enum('E','P','C') NOT NULL DEFAULT 'E' COMMENT 'E => Espera; P => Proceso; C => Cancelado',
  `estado` enum('1','0') NOT NULL DEFAULT '1',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_proyecto` (`id_proyecto`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `FK1_id_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `users` (`id`),
  CONSTRAINT `FK2_id_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla project-manage.tareas: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` (`id`, `id_proyecto`, `id_empleado`, `descripcion`, `comentario`, `estatus`, `estado`, `fecha_inicio`, `fecha_final`, `fecha_limite`, `fecha_registro`) VALUES
	(1, 1, 2, 'Desarrollar modulo de registro de clientes upd', 'algunos comentarios de la tarea por aqui up...', 'C', '1', '2020-11-17', '2020-11-19', '2020-11-30', '2020-11-17 15:04:45'),
	(2, 1, 3, 'Desarrollar modulo de registro de proveedores', 'algunos comentarios de la tarea por aqui... xDDD', 'C', '1', '2020-11-15', '2020-11-18', '2020-11-20', '2020-11-17 15:05:03'),
	(3, 1, NULL, 'Desarrollar modulo de cotizacion', 'algunos comentarios de la tarea por aqui...', 'E', '1', NULL, NULL, '2020-12-15', '2020-11-17 15:05:18'),
	(4, 2, 2, 'Modulo de registro de empleados', 'descripcion o notas de la tarea aqui', 'P', '1', '2020-11-18', NULL, '2020-12-15', '2020-11-17 19:51:51');
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;

-- Volcando estructura para tabla project-manage.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('M','E') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'E',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla project-manage.users: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Manager 1', 'manager1@hotmail.com', 'M', NULL, '$2y$10$h0Xzy0vsP96.qqIXSVJXgu5uaWN.rvcV1S8UevO.LMrf360k.YmLO', 'OPiWF3NKsAq1OZxOpYyi8Le8zy1DkLAb5ARmPj2ck680BoUs1i9l7fIlRMy7', '2020-11-13 17:16:29', '2020-11-18 22:18:27'),
	(2, 'Empleado 1', 'empleado1@hotmail.com', 'E', NULL, '$2y$10$Gg.ZudplcImoC4PpVGuN2OPMu3pZrvpIbF/EOW8dA939eyzj9ukZm', NULL, '2020-11-14 20:30:14', '2020-11-18 22:19:26'),
	(3, 'Empleado 2', 'empleado2@hotmail.com', 'E', NULL, '$2y$10$n6bmdYrj4IQzI4jWMfk68.J0FpZYQL5y2r3549uzX6robYYJkotgK', NULL, '2020-11-15 01:40:01', '2020-11-18 22:20:05'),
	(4, 'Manager 2', 'manager2@hotmail.com', 'M', NULL, '$2y$10$rL4caeUq.SOEz8.Ajvv0a.B2TCy7MWgX5hKn6cHXDlu2r359Xa6GC', NULL, '2020-11-15 01:44:53', '2020-11-18 22:21:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
