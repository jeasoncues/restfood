-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2020 a las 14:27:09
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` bigint(20) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `codigo` bigint(20) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rolid` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`codigo`, `nombre`, `precio`, `fecha`, `rolid`) VALUES
(1, 'gas', '20.00', '2020-11-21 00:00:00', 1),
(5, 'Limones', '10.00', '2020-11-21 00:00:00', 1),
(6, 'yucas', '9.00', '2020-11-21 00:00:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` bigint(20) NOT NULL,
  `titulo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Dashboard', 'Dashboard', 1),
(2, 'Usuarios', 'Usuarios del sistema', 1),
(3, 'Clientes', 'Clientes del Restaurante', 1),
(4, 'Productos', 'Todos los productos', 1),
(5, 'Pedidos', 'Pedidos', 1),
(7, 'Caja', 'Caja', 1),
(8, 'Gastos', 'Gastos ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` bigint(20) NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `moduloid` bigint(20) NOT NULL,
  `r` int(11) NOT NULL DEFAULT '0',
  `w` int(11) NOT NULL DEFAULT '0',
  `u` int(11) NOT NULL DEFAULT '0',
  `d` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(36, 8, 1, 1, 1, 1, 1),
(37, 8, 2, 0, 0, 0, 0),
(38, 8, 3, 0, 0, 0, 0),
(39, 8, 4, 0, 0, 0, 0),
(40, 8, 5, 0, 0, 0, 0),
(41, 8, 7, 1, 1, 1, 0),
(42, 4, 1, 1, 0, 0, 0),
(43, 4, 2, 0, 0, 0, 0),
(44, 4, 3, 0, 0, 0, 0),
(45, 4, 4, 0, 0, 0, 0),
(46, 4, 5, 1, 1, 1, 1),
(47, 4, 7, 1, 1, 1, 1),
(68, 2, 1, 0, 0, 0, 0),
(69, 2, 2, 0, 0, 0, 0),
(70, 2, 3, 0, 0, 0, 0),
(71, 2, 4, 0, 0, 0, 0),
(72, 2, 5, 0, 0, 0, 0),
(73, 2, 7, 0, 0, 0, 0),
(74, 2, 8, 1, 1, 1, 1),
(75, 1, 1, 1, 1, 1, 1),
(76, 1, 2, 1, 1, 1, 1),
(77, 1, 3, 1, 1, 1, 1),
(78, 1, 4, 1, 1, 1, 1),
(79, 1, 5, 1, 1, 1, 1),
(80, 1, 7, 1, 1, 1, 1),
(81, 1, 8, 1, 1, 1, 1),
(82, 3, 1, 1, 1, 1, 1),
(83, 3, 2, 1, 1, 1, 1),
(84, 3, 3, 1, 1, 1, 1),
(85, 3, 4, 1, 1, 1, 1),
(86, 3, 5, 1, 1, 1, 1),
(87, 3, 7, 1, 1, 1, 1),
(88, 3, 8, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` bigint(20) NOT NULL,
  `identificacion` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email_user` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nit` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombrefiscal` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `direccionfiscal` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `identificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `password`, `nit`, `nombrefiscal`, `direccionfiscal`, `token`, `rolid`, `datecreated`, `status`) VALUES
(1, '2632434', 'Juana', 'Palacios Chiroque', 930034027, 'juanapalaciosch@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '', 2, '2020-11-09 15:37:14', 0),
(2, '74237028', 'Jeason', 'Cueva Espinoza', 999134381, 'jeasoncues@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '32c58e2d1839f148022ef03f08384de04193e75206a42b93e02c82444ed3baef', 3, '2020-11-09 16:02:35', 1),
(3, '83219392', 'Pepe Lucho', 'Pancracio Teodro', 98382930, 'pepelucho@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '', 4, '2020-11-11 16:52:15', 1),
(4, '123211241', 'Hector', 'Crisostomo', 983273213, 'hector2020@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '', 2, '2020-11-14 10:45:05', 1),
(5, '28378930', 'Gino', 'Olivares Rivera', 934225249, 'gino2020@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '8d86287975a3ce913a4feaedbae93fffec6b3dbbe83f81745e8d956ff47b1645', 3, '2020-11-17 13:15:25', 1),
(6, '361253717', 'Guillermo', 'Silva Sanchez', 993727388, 'guillermo2020@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '', 3, '2020-11-17 14:55:50', 0),
(7, '12323141', 'Rodrigo', 'Cueva Espinoza', 983231239, 'rodri2200@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '', 1, '2020-11-19 22:32:39', 1),
(8, '263243432', 'Yeyo', 'Cueva', 938283219, 'yeyeo2002@gmail.com', '9c6a781401b193601d846cf59d82b7661c5e180ed19aacc9d314e192cabdc073', '', '', '', '', 1, '2020-11-20 00:09:55', 1),
(9, '2147483647', 'School', 'Bonny', 932183129, 'santi2020@gmail.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '', '', '', '', 1, '2020-11-20 00:11:42', 1),
(10, '21838', 'Sagne', 'Overth', 983839292, 'overth293@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '', '', '', '', 1, '2020-11-21 21:36:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `categoriaid` bigint(20) NOT NULL,
  `codigo` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `nombrerol` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Administrador', 1),
(2, 'Supervisores', 'Supervisores', 1),
(3, 'Super Administrador', 'Administrador', 1),
(4, 'Mozo', 'Servicio al Cliente', 1),
(5, 'Ejemplo1', 'Ejemplo1', 0),
(6, 'Ventas', 'Ventas', 0),
(7, 'ejemplo2', 'Ventas1', 0),
(8, 'Cliente', 'Cliente del Restaurante', 1),
(9, 'Cajero', 'Cajero', 0),
(10, 'Donattos', 'hola', 0),
(11, 'Donattos1', 'Hola mundo', 0),
(12, 'Donattos3', 'Hola amigos', 0),
(13, 'Delivery', 'Holamundo', 0),
(14, 'Delivery2', 'HOLAMUNDO', 0),
(15, 'Administrador10', 'Hola amigos', 0),
(16, 'holi', 'holi frod', 0),
(17, 'Cocinero', 'Cocinero', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `rolid` (`rolid`),
  ADD KEY `moduloid` (`moduloid`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `categoriaid` (`categoriaid`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `codigo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`idmodulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoriaid`) REFERENCES `categoria` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
