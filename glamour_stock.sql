-- ============================================================
-- Glamour Stock – Base de datos para MVC_PRUEBA
-- Contraseña para todos los usuarios: "password"
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `g_s`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `g_s`;

-- --------------------------------------------------------
DROP TABLE IF EXISTS `citas`;
DROP TABLE IF EXISTS `servicios`;
DROP TABLE IF EXISTS `usuarios`;

-- Tabla: usuarios
CREATE TABLE `usuarios` (
  `id`             int NOT NULL AUTO_INCREMENT,
  `nombre`         varchar(100) NOT NULL,
  `correo`         varchar(100) NOT NULL,
  `telefono`       varchar(20) DEFAULT NULL,
  `contraseña`     varchar(255) NOT NULL,
  `rol`            enum('admin','empleado','cliente') NOT NULL DEFAULT 'cliente',
  `activo`         tinyint(1) NOT NULL DEFAULT '1',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contraseña: "password" para todos
INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `telefono`, `contraseña`, `rol`, `activo`) VALUES
(1, 'Administrador Glamour', 'admin@glamourstock.com',     '3126907061', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',    1),
(2, 'Yulieth Ramírez',       'empleada@glamourstock.com',  '3200000001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'empleado', 1),
(3, 'Ana Paula Gómez',       'cliente@glamourstock.com',   '3105903731', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente',  1),
(4, 'Tatiana Galvis',        'tati@glamourstock.com',      '3456789067', '$2y$10$CVGQ5F.hvD0YjEkiPuwAbOUPxog.cRGRnzPlk3fli85QGhUUJi9Ri', 'empleado', 1);

-- Tabla: servicios
CREATE TABLE `servicios` (
  `id`          int NOT NULL AUTO_INCREMENT,
  `nombre`      varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio`      decimal(10,2) DEFAULT NULL,
  `duracion`    int DEFAULT NULL,
  `categoria`   varchar(50) DEFAULT NULL,
  `activo`      tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `precio`, `duracion`, `categoria`, `activo`) VALUES
(1, 'Manicura Clásica',      'Esmaltado perfecto con preparación de cutículas y forma',     20000.00, 40, 'Uñas',     1),
(2, 'Pedicura Spa',          'Exfoliación, hidratación, masaje y esmaltado',                30000.00, 50, 'Uñas',     1),
(3, 'Uñas Acrílicas',        'Extensión profesional con diseño personalizado',              40000.00, 75, 'Uñas',     1),
(4, 'Uñas en Gel',           'Acabado brillante y flexible de larga duración',              35000.00, 60, 'Uñas',     1),
(5, 'Diseño de Cejas',       'Diseño y depilación con técnica de hilo y pinza',             15000.00, 20, 'Cejas',    1),
(6, 'Extensión de Pestañas', 'Efecto natural o dramático con fibras de seda',               45000.00, 60, 'Pestañas', 1),
(7, 'Lifting de Pestañas',   'Rizador permanente de larga duración',                        38000.00, 45, 'Pestañas', 1),
(8, 'Tinte de Cejas',        'Coloración profesional para cejas definidas',                 12000.00, 15, 'Cejas',    1);

-- Tabla: citas
CREATE TABLE `citas` (
  `id`             int NOT NULL AUTO_INCREMENT,
  `usuario_id`     int NOT NULL,
  `empleado_id`    int DEFAULT NULL,
  `servicio_id`    int NOT NULL,
  `fecha`          date NOT NULL,
  `hora`           time NOT NULL,
  `estado`         enum('pendiente','confirmada','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `comentarios`    text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id`  (`usuario_id`),
  KEY `empleado_id` (`empleado_id`),
  KEY `servicio_id` (`servicio_id`),
  CONSTRAINT `citas_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `citas_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `citas_usuario`  FOREIGN KEY (`usuario_id`)  REFERENCES `usuarios`  (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `citas` (`id`, `usuario_id`, `empleado_id`, `servicio_id`, `fecha`, `hora`, `estado`, `comentarios`) VALUES
(1, 3, 2, 7, '2026-03-10', '09:00:00', 'confirmada',  'Primera vez'),
(2, 3, 2, 5, '2026-03-12', '14:30:00', 'pendiente',   ''),
(3, 3, NULL, 1, '2026-02-20', '10:00:00', 'completada', 'Todo perfecto'),
(4, 3, NULL, 3, '2026-02-15', '16:00:00', 'completada', ''),
(5, 3, NULL, 6, '2026-02-10', '11:00:00', 'cancelada',  'No pude asistir');

COMMIT;
