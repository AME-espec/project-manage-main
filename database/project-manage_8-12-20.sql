# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.30)
# Database: project-manage
# Generation Time: 2020-12-08 13:55:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tareas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tareas`;

CREATE TABLE `tareas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(255) CHARACTER SET latin1 NOT NULL,
  `comentario` varchar(255) CHARACTER SET latin1 NOT NULL,
  `estatus` enum('E','P','C') CHARACTER SET latin1 NOT NULL DEFAULT 'E' COMMENT 'E => Espera; P => Proceso; C => Cancelado',
  `estado` enum('1','0') CHARACTER SET latin1 NOT NULL DEFAULT '1',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `completed_by` int(11) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_proyecto` (`id_proyecto`),
  CONSTRAINT `FK2_id_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tareas` WRITE;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;

INSERT INTO `tareas` (`id`, `id_proyecto`, `descripcion`, `comentario`, `estatus`, `estado`, `fecha_inicio`, `fecha_final`, `fecha_limite`, `completed_by`, `fecha_registro`)
VALUES
	(1,1,'Desarrollar modulo de registro de clientes upd','algunos comentarios de la tarea por aqui up...','C','0','2020-11-17','2020-11-19','2020-11-30',NULL,'2020-11-17 15:04:45'),
	(2,1,'Desarrollar modulo de registro de proveedores','algunos comentarios de la tarea por aqui... xDDD','C','1','2020-11-15','2020-12-08','2020-11-20',NULL,'2020-11-17 15:05:03'),
	(3,1,'Desarrollar modulo de cotizacion','algunos comentarios de la tarea por aqui...','P','1','2020-12-05',NULL,'2020-12-15',NULL,'2020-11-17 15:05:18'),
	(4,2,'Modulo de registro de empleados','descripcion o notas de la tarea aqui','C','1','2020-11-18','2020-12-08','2020-12-15',NULL,'2020-11-17 19:51:51'),
	(5,1,'sddsfas','asdfasdf','C','1','2020-12-10','2020-12-08','2020-12-18',2,'2020-12-06 00:13:52'),
	(6,1,'sddsfas','wesdfsdf','P','1','2020-12-17','2020-12-08','2020-12-08',NULL,'2020-12-06 00:21:17'),
	(7,2,'sddsfas','wesdfsdf','P','1','2020-12-17','2020-12-11','2020-12-08',NULL,'2020-12-06 00:24:07'),
	(8,1,'sddsfas','wesdfsdf','P','1','2020-12-17','2020-12-11','2020-12-08',NULL,'2020-12-06 00:27:27'),
	(9,1,'sddsfas','wesdfsdf','C','0','2020-12-17','2020-12-08','2020-12-08',NULL,'2020-12-06 00:28:05'),
	(10,1,'sddsfas','wesdfsdf','P','0','2020-12-17','2020-12-11','2020-12-08',NULL,'2020-12-06 00:28:27'),
	(11,1,'sddsfas','wesdfsdf','C','0','2020-12-17','2020-12-08','2020-12-08',NULL,'2020-12-06 00:29:30'),
	(12,1,'sddsfas','wesdfsdf','C','1','2020-12-17','2020-12-08','2020-12-08',NULL,'2020-12-06 00:29:51'),
	(13,1,'prueba','dfssfdsf','C','1','2020-12-10','2020-12-08','2020-12-09',NULL,'2020-12-08 03:38:37'),
	(14,1,'sddsfas','vczxvcxv','C','1','2020-12-17','2020-12-08','2020-12-09',2,'2020-12-08 04:03:32'),
	(15,1,'sddsfas','kjlkhj','E','1','2020-12-17','2020-12-17','2020-12-11',NULL,'2020-12-08 06:56:37'),
	(16,2,'sddsfas','asdasd','P','1','2020-12-09','2020-12-10','2020-12-31',NULL,'2020-12-08 07:58:58'),
	(17,3,'sddsfas','sdsdfsdf','E','1','2020-12-17','2020-12-22','2020-12-10',NULL,'2020-12-08 08:31:38');

/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
