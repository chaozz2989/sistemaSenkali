-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2017 a las 22:32:47
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `senkalidb`
--
CREATE DATABASE IF NOT EXISTS `senkalidb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `senkalidb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'Bebidas'),
(2, 'Alimentos'),
(3, 'Combos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_clientes` int(11) NOT NULL AUTO_INCREMENT,
  `id_estadoUsu` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dui` varchar(9) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_clientes`),
  KEY `id_estadoUsu_idx` (`id_estadoUsu`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `id_estadoUsu`, `usuario`, `clave`, `nombre`, `apellido`, `dui`, `telefono`, `email`, `direccion`) VALUES
(1, 1, 'cliente', 'cliente', 'juan', 'perez', '11111111', '12121212', 'jperez@senkali.com', 'san salvador'),
(2, 1, 'ymelendez', 'ymelendez', 'Yanira', 'Melendez', '123456789', '88888888', 'correo@mail.com', 'San Salvador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_pago`
--

DROP TABLE IF EXISTS `comprobante_pago`;
CREATE TABLE IF NOT EXISTS `comprobante_pago` (
  `id_comprobante` int(11) NOT NULL AUTO_INCREMENT,
  `id_orden` int(11) NOT NULL,
  `pago_recibido` float NOT NULL,
  `esDescuento` tinyint(1) NOT NULL COMMENT 'Define si se realiza algún tipo de descuento a la venta.',
  PRIMARY KEY (`id_comprobante`),
  KEY `id_orden_idx` (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_orden`
--

DROP TABLE IF EXISTS `detalles_orden`;
CREATE TABLE IF NOT EXISTS `detalles_orden` (
  `id_detOrden` int(11) NOT NULL AUTO_INCREMENT,
  `id_orden` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_estado_detalleOrd` int(11) NOT NULL,
  `cantidad_prod` int(11) NOT NULL,
  `subtotal_orden` float NOT NULL,
  PRIMARY KEY (`id_detOrden`),
  KEY `id_orden_idx` (`id_orden`),
  KEY `id_producto_idx` (`id_producto`),
  KEY `id_estado_detalleOrd_idx` (`id_estado_detalleOrd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_consumo_cliente`
--

DROP TABLE IF EXISTS `detalle_consumo_cliente`;
CREATE TABLE IF NOT EXISTS `detalle_consumo_cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL,
  PRIMARY KEY (`id_cliente`,`id_orden`),
  KEY `id_cliente_idx` (`id_cliente`),
  KEY `id_orden_idx` (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_descuento`
--

DROP TABLE IF EXISTS `detalle_descuento`;
CREATE TABLE IF NOT EXISTS `detalle_descuento` (
  `id_detalleDesc` int(11) NOT NULL AUTO_INCREMENT,
  `id_comprobante` int(11) NOT NULL,
  `descuento_realizado` double NOT NULL,
  PRIMARY KEY (`id_detalleDesc`),
  KEY `id_comprobante_idx` (`id_comprobante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_monedero`
--

DROP TABLE IF EXISTS `detalle_monedero`;
CREATE TABLE IF NOT EXISTS `detalle_monedero` (
  `id_orden` int(11) NOT NULL,
  `id_monedero` int(11) NOT NULL,
  `cantidad_mov` double NOT NULL,
  `movimiento` tinyint(1) NOT NULL COMMENT 'Movimiento define si es una acumulación o una redención de dinero.\n0-Acumula, 1-Redime',
  `fecha_movimiento` datetime NOT NULL COMMENT 'El requisito estará definido por el consumo mínimo calculado a lo últimos 30 días, lo cuál será tomado de la tabla de Ordenes.\n\nNO es mensual.',
  PRIMARY KEY (`id_orden`,`id_monedero`),
  KEY `id_orden_idx` (`id_orden`),
  KEY `id_monedero_idx` (`id_monedero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prod_ingred`
--

DROP TABLE IF EXISTS `detalle_prod_ingred`;
CREATE TABLE IF NOT EXISTS `detalle_prod_ingred` (
  `id_ingrediente` int(11) NOT NULL,
  `id_prod_esp` int(11) NOT NULL,
  PRIMARY KEY (`id_ingrediente`,`id_prod_esp`),
  KEY `id_ingrediente_idx` (`id_ingrediente`),
  KEY `id_prod_idx` (`id_prod_esp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_orden_reserva`
--

DROP TABLE IF EXISTS `det_orden_reserva`;
CREATE TABLE IF NOT EXISTS `det_orden_reserva` (
  `id_reserva` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`,`id_orden`),
  KEY `id_reserva_idx` (`id_reserva`),
  KEY `id_orden_idx` (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `id_sucursal` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_estadoUsuario` int(11) NOT NULL,
  `usu_empleado` varchar(45) NOT NULL,
  `clave_empleado` varchar(45) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `dui` varchar(9) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id_empleado`),
  KEY `id_rol_idx` (`id_rol`),
  KEY `id_sucursal_idx` (`id_sucursal`),
  KEY `id_estadioUsuario_idx` (`id_estadoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_sucursal`, `id_rol`, `id_estadoUsuario`, `usu_empleado`, `clave_empleado`, `nombres`, `apellidos`, `dui`, `nit`, `direccion`, `telefono`, `email`) VALUES
(1, 1, 1, 1, 'ochavez', 'ochavez', 'Osiris', 'Chavez', '123495788', '22121212121212', 'San Salvador', '77777777', 'osiris@senkali.com'),
(2, 1, 2, 1, 'empleado1', 'empleado1', 'Juan Pablo', 'Pérez Monterrey', '033787511', '05231615462521', 'San Salvador', '77777777', 'correo@correo.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_orden`
--

DROP TABLE IF EXISTS `estados_orden`;
CREATE TABLE IF NOT EXISTS `estados_orden` (
  `id_estadosOrden` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(15) NOT NULL,
  PRIMARY KEY (`id_estadosOrden`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estados_orden`
--

INSERT INTO `estados_orden` (`id_estadosOrden`, `estado`) VALUES
(1, 'Pendiente'),
(2, 'Atendida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_usuario`
--

DROP TABLE IF EXISTS `estados_usuario`;
CREATE TABLE IF NOT EXISTS `estados_usuario` (
  `id_estUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `estado_usuario` varchar(45) NOT NULL,
  PRIMARY KEY (`id_estUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estados_usuario`
--

INSERT INTO `estados_usuario` (`id_estUsuario`, `estado_usuario`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_reservas`
--

DROP TABLE IF EXISTS `estado_reservas`;
CREATE TABLE IF NOT EXISTS `estado_reservas` (
  `id_estadoRes` int(11) NOT NULL AUTO_INCREMENT,
  `estado_reserva` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estadoRes`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_reservas`
--

INSERT INTO `estado_reservas` (`id_estadoRes`, `estado_reserva`) VALUES
(1, 'Pendiente'),
(2, 'Cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gerente_sucursal`
--

DROP TABLE IF EXISTS `gerente_sucursal`;
CREATE TABLE IF NOT EXISTS `gerente_sucursal` (
  `id_gerente_suc` int(11) NOT NULL AUTO_INCREMENT,
  `id_empleado` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_gerente_suc`),
  KEY `relacion_gerente_idx` (`id_empleado`),
  KEY `relacion_sucursal_idx` (`id_sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `id_historico` int(11) NOT NULL AUTO_INCREMENT,
  `id_movHistorico` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_hora` date NOT NULL,
  `detalle` varchar(300) NOT NULL,
  PRIMARY KEY (`id_historico`),
  KEY `id_movHistorico_idx` (`id_movHistorico`),
  KEY `id_empleado_idx` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE IF NOT EXISTS `ingredientes` (
  `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT,
  `ingrediente` varchar(50) NOT NULL,
  `costo` double NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_ingrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

DROP TABLE IF EXISTS `mesas`;
CREATE TABLE IF NOT EXISTS `mesas` (
  `id_mesa` int(11) NOT NULL AUTO_INCREMENT,
  `id_sucursal` int(11) NOT NULL,
  `cod_mesa` varchar(6) NOT NULL,
  PRIMARY KEY (`id_mesa`),
  KEY `id_sucursal_idx` (`id_sucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `id_sucursal`, `cod_mesa`) VALUES
(1, 1, 'Mesa1'),
(2, 1, 'Mesa2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas_reserva`
--

DROP TABLE IF EXISTS `mesas_reserva`;
CREATE TABLE IF NOT EXISTS `mesas_reserva` (
  `id_reserva` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`,`id_mesa`),
  KEY `id_mesa_reserva_idx` (`id_mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedero`
--

DROP TABLE IF EXISTS `monedero`;
CREATE TABLE IF NOT EXISTS `monedero` (
  `id_monedero` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `total_acumulado` double NOT NULL,
  PRIMARY KEY (`id_monedero`),
  KEY `id_cliente_idx` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_historico`
--

DROP TABLE IF EXISTS `movimientos_historico`;
CREATE TABLE IF NOT EXISTS `movimientos_historico` (
  `id_movHistorico` int(11) NOT NULL AUTO_INCREMENT,
  `movimiento` varchar(45) NOT NULL,
  PRIMARY KEY (`id_movHistorico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
CREATE TABLE IF NOT EXISTS `ordenes` (
  `id_ordenes` int(11) NOT NULL AUTO_INCREMENT,
  `id_mesa` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_tipoOrden` int(11) NOT NULL,
  `id_estadoOrden` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total_orden` float NOT NULL,
  `es_cliente` tinyint(1) NOT NULL COMMENT 'Este campo define si la orden pertenece a un Cliente o no.\nEn caso de pertenecer a un cliente, está será relacionada con la tabla "detalle_consumo_cliente".',
  PRIMARY KEY (`id_ordenes`),
  KEY `id_mesa_idx` (`id_mesa`),
  KEY `id_empleado_idx` (`id_empleado`),
  KEY `id_estadoOrden_idx` (`id_estadoOrden`),
  KEY `id_tipoOrden_idx` (`id_tipoOrden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_productos` int(11) NOT NULL AUTO_INCREMENT,
  `id_subCat` int(11) NOT NULL,
  `nombre_prod` varchar(45) NOT NULL,
  `precio_prod` float NOT NULL,
  `especialidad` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_productos`),
  KEY `id_subCat_idx` (`id_subCat`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `id_subCat`, `nombre_prod`, `precio_prod`, `especialidad`) VALUES
(1, 1, 'Horchata Senkali', 2.5, 1),
(2, 2, 'Bebida 2', 3.5, 0),
(3, 1, 'Soda Senkali', 3.5, 1),
(4, 1, 'Agua Senkali', 8, 1),
(5, 1, 'Bebida Natural', 10, 1),
(6, 1, 'Bebida No Natural', 663, 0),
(7, 1, 'Bebida 1', 90, 0),
(8, 2, 'Agua Milagrosa', 12.25, 1),
(9, 2, 'Horchata de Coco', 0.9, 0),
(10, 2, 'Agua de Maravilla', 2.99, 0),
(11, 2, 'Agua de Manantial', 3.99, 0),
(12, 3, 'Queso con loroco', 0.6, 0),
(13, 3, 'Revuelta', 0.5, 0),
(14, 3, 'Loca', 1.5, 0),
(15, 4, 'Yuca con Pepesca', 2.5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion`
--

DROP TABLE IF EXISTS `promocion`;
CREATE TABLE IF NOT EXISTS `promocion` (
  `id_promocion` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `promocion` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` varchar(45) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_promocion`),
  KEY `id_producto_idx` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id_reservas` int(11) NOT NULL AUTO_INCREMENT,
  `id_estadoRes` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tipoEvento` int(11) NOT NULL,
  `codigo_reserva` varchar(10) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `cant_personas` int(11) NOT NULL,
  PRIMARY KEY (`id_reservas`),
  KEY `id_estadoRes_idx` (`id_estadoRes`),
  KEY `id_empleado_idx` (`id_empleado`),
  KEY `id_cliente_idx` (`id_cliente`),
  KEY `id_tipoEvento_idx` (`id_tipoEvento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reservas`, `id_estadoRes`, `id_empleado`, `id_cliente`, `id_tipoEvento`, `codigo_reserva`, `descripcion`, `fecha`, `hora_inicio`, `hora_final`, `cant_personas`) VALUES
(1, 1, 1, 1, 2, 'AA0123444', 'Boda de Canelo', '2017-08-08', '00:00:00', '00:00:00', 20),
(2, 1, 1, 1, 1, '0012ss', 'Boda de Arnulfo', '2017-08-16', '00:00:00', '00:00:00', 60),
(3, 1, 1, 1, 2, 'CDJ', 'Cumple de Juan', '2017-08-31', '00:00:00', '00:00:00', 60),
(4, 2, 1, 1, 3, 'CA2020', 'Evento parrilleron', '2017-08-23', '00:00:00', '00:00:00', 50),
(5, 2, 1, 1, 1, '2233', 'Boda #3', '2017-09-07', '00:00:00', '00:00:00', 70),
(6, 1, 1, 1, 2, 'AA0123', 'Boda #4', '2017-09-11', '00:00:00', '00:00:00', 55),
(7, 1, 1, 1, 1, 'ccdq', 'Boda #4', '2017-09-11', '00:00:00', '00:00:00', 66),
(8, 1, 1, 1, 2, 'BO2036', 'Boda #4', '2017-10-18', '12:45:00', '12:45:00', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
CREATE TABLE IF NOT EXISTS `subcategorias` (
  `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_subcategoria`),
  KEY `id_categoria_idx` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id_subcategoria`, `id_categoria`, `nombre`) VALUES
(1, 1, 'Calientes'),
(2, 1, 'Frías'),
(3, 2, 'Pupusas'),
(4, 2, 'Típicos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE IF NOT EXISTS `sucursales` (
  `id_sucursal` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_suc` varchar(100) NOT NULL,
  `direccion_suc` varchar(200) NOT NULL,
  `telefono_suc` varchar(11) NOT NULL,
  PRIMARY KEY (`id_sucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id_sucursal`, `descripcion_suc`, `direccion_suc`, `telefono_suc`) VALUES
(1, 'Sucursal Principal', 'Antiguo Cuscatlan', '77777777');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_orden`
--

DROP TABLE IF EXISTS `tipos_orden`;
CREATE TABLE IF NOT EXISTS `tipos_orden` (
  `id_tipoOrd` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_orden` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipoOrd`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_orden`
--

INSERT INTO `tipos_orden` (`id_tipoOrd`, `tipo_orden`) VALUES
(1, 'Web'),
(2, 'Presencial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_evento`
--

DROP TABLE IF EXISTS `tipo_evento`;
CREATE TABLE IF NOT EXISTS `tipo_evento` (
  `id_tipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `evento` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipoEvento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_evento`
--

INSERT INTO `tipo_evento` (`id_tipoEvento`, `evento`) VALUES
(1, 'Boda'),
(2, 'Aniversario'),
(3, 'Informal');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `id_estadoUsu` FOREIGN KEY (`id_estadoUsu`) REFERENCES `estados_usuario` (`id_estUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comprobante_pago`
--
ALTER TABLE `comprobante_pago`
  ADD CONSTRAINT `id_orden_comprobante` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_ordenes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalles_orden`
--
ALTER TABLE `detalles_orden`
  ADD CONSTRAINT `id_estado_detalleOrd` FOREIGN KEY (`id_estado_detalleOrd`) REFERENCES `estados_orden` (`id_estadosOrden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relacion_orden_detall` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_ordenes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relacion_producto_detalle` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_consumo_cliente`
--
ALTER TABLE `detalle_consumo_cliente`
  ADD CONSTRAINT `relacion_cliente_orden` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_ordenes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relacion_orden_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_descuento`
--
ALTER TABLE `detalle_descuento`
  ADD CONSTRAINT `id_comprobante` FOREIGN KEY (`id_comprobante`) REFERENCES `comprobante_pago` (`id_comprobante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_monedero`
--
ALTER TABLE `detalle_monedero`
  ADD CONSTRAINT `id_monedero_orden` FOREIGN KEY (`id_monedero`) REFERENCES `monedero` (`id_monedero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_orden_monedero` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_ordenes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_prod_ingred`
--
ALTER TABLE `detalle_prod_ingred`
  ADD CONSTRAINT `relacion_ingrediente_producto` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relacion_producto_ingrediente` FOREIGN KEY (`id_prod_esp`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `det_orden_reserva`
--
ALTER TABLE `det_orden_reserva`
  ADD CONSTRAINT `relacion_orden_reserva` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_ordenes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relacion_reserva_orden` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reservas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `id_estadoUsuario` FOREIGN KEY (`id_estadoUsuario`) REFERENCES `estados_usuario` (`id_estUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_rol_empleado` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_sucursal_empleado` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `gerente_sucursal`
--
ALTER TABLE `gerente_sucursal`
  ADD CONSTRAINT `relacion_gerente` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relacion_sucursal` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `id_empleado_historico` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_movHistorico` FOREIGN KEY (`id_movHistorico`) REFERENCES `movimientos_historico` (`id_movHistorico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `id_sucursal_mesa` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mesas_reserva`
--
ALTER TABLE `mesas_reserva`
  ADD CONSTRAINT `id_mesa_reserva` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reservas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `monedero`
--
ALTER TABLE `monedero`
  ADD CONSTRAINT `id_cliente_monedero` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `id_empleado_orden` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_estadoOrden_orden` FOREIGN KEY (`id_estadoOrden`) REFERENCES `estados_orden` (`id_estadosOrden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_mesa_orden` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_tipoOrden_orden` FOREIGN KEY (`id_tipoOrden`) REFERENCES `tipos_orden` (`id_tipoOrd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `id_subCat` FOREIGN KEY (`id_subCat`) REFERENCES `subcategorias` (`id_subcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `promocion`
--
ALTER TABLE `promocion`
  ADD CONSTRAINT `relacion_producto_promocion` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `id_cliente_reserva` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_empleado_reserva` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_estadoRes_reseva` FOREIGN KEY (`id_estadoRes`) REFERENCES `estado_reservas` (`id_estadoRes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_tipoEvento_reserva` FOREIGN KEY (`id_tipoEvento`) REFERENCES `tipo_evento` (`id_tipoEvento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
