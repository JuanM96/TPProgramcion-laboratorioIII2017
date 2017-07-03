-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2017 a las 05:35:54
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `estacionamiento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `box`
--

CREATE TABLE `box` (
  `id` int(11) NOT NULL,
  `patente` varchar(11) NOT NULL,
  `piso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(100) COLLATE utf16_spanish2_ci NOT NULL,
  `Apellido` varchar(100) COLLATE utf16_spanish2_ci NOT NULL,
  `Email` varchar(150) COLLATE utf16_spanish2_ci NOT NULL,
  `DNI` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `Password` varchar(20) COLLATE utf16_spanish2_ci NOT NULL,
  `suspendido` tinyint(1) NOT NULL,
  `Admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`ID`, `Nombre`, `Apellido`, `Email`, `DNI`, `Password`, `suspendido`, `Admin`) VALUES
(1, 'Rozele', 'Varfalameev', 'rvarfalameev2@ebay.co.uk', '34074088', 'FC2fOUk2Fz', 0, 0),
(2, 'Lila', 'Fesby', 'lfesby0@altervista.org', '14841800', 'eKKjADqD', 1, 0),
(3, 'Ruddy', 'Maletratt', 'rmaletratt1@twitter.com', '28194643', 'XSkrDzn', 1, 0),
(5, 'pruebaNombre', 'pruebaApellido', 'pruebaEmail', '123456789', '12345', 0, 0),
(6, 'pruebaNombre2', 'pruebaApellido2', 'pruebaEmail2', '123456789312', '12345434', 0, 0),
(100, 'admin', 'admin', 'admin@gmail.com', '1', 'admin', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estacionamiento`
--

CREATE TABLE `estacionamiento` (
  `id` int(11) NOT NULL,
  `cantPisos` int(11) NOT NULL,
  `cantBoxXPisos` int(11) NOT NULL,
  `precioXHora` int(11) NOT NULL,
  `precioXMedioDia` int(11) NOT NULL,
  `precioXDia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estacionamiento`
--

INSERT INTO `estacionamiento` (`id`, `cantPisos`, `cantBoxXPisos`, `precioXHora`, `precioXMedioDia`, `precioXDia`) VALUES
(1, 3, 20, 10, 90, 170);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logempleado`
--

CREATE TABLE `logempleado` (
  `dni` varchar(20) NOT NULL,
  `logIn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `id` int(11) NOT NULL,
  `idBox` int(11) NOT NULL,
  `idPiso` int(11) NOT NULL,
  `idVehiculo` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `entrada` date NOT NULL,
  `salida` date DEFAULT NULL,
  `costo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`id`, `idBox`, `idPiso`, `idVehiculo`, `idEmpleado`, `entrada`, `salida`, `costo`) VALUES
(1, 15, 1, 86, 1, '0000-00-00', '0000-00-00', 24),
(2, 18, 3, 66, 2, '0000-00-00', '0000-00-00', 60),
(3, 13, 3, 34, 2, '0000-00-00', '0000-00-00', 31),
(4, 4, 2, 84, 3, '0000-00-00', '0000-00-00', 91),
(5, 6, 3, 44, 1, '0000-00-00', '0000-00-00', 45),
(6, 15, 2, 36, 1, '0000-00-00', '0000-00-00', 34),
(7, 12, 2, 69, 3, '0000-00-00', '0000-00-00', 23),
(8, 1, 1, 69, 1, '0000-00-00', '0000-00-00', 76),
(9, 12, 2, 11, 2, '0000-00-00', '0000-00-00', 71),
(10, 14, 3, 83, 3, '0000-00-00', '0000-00-00', 64),
(11, 10, 3, 58, 2, '0000-00-00', '0000-00-00', 58),
(12, 5, 2, 1, 1, '0000-00-00', '0000-00-00', 77),
(13, 18, 1, 26, 3, '0000-00-00', '0000-00-00', 73),
(14, 13, 3, 2, 3, '0000-00-00', '0000-00-00', 13),
(15, 9, 2, 27, 2, '0000-00-00', '0000-00-00', 99),
(16, 6, 2, 23, 3, '0000-00-00', '0000-00-00', 32),
(17, 13, 2, 99, 2, '0000-00-00', '0000-00-00', 8),
(18, 17, 3, 53, 3, '0000-00-00', '0000-00-00', 99),
(19, 10, 3, 8, 3, '0000-00-00', '0000-00-00', 99),
(20, 3, 1, 91, 3, '0000-00-00', '0000-00-00', 39),
(21, 5, 1, 94, 2, '0000-00-00', '0000-00-00', 55),
(22, 2, 2, 84, 3, '0000-00-00', '0000-00-00', 2),
(23, 13, 1, 46, 3, '0000-00-00', '0000-00-00', 64),
(24, 13, 3, 86, 2, '0000-00-00', '0000-00-00', 83),
(25, 7, 2, 41, 2, '0000-00-00', '0000-00-00', 51),
(26, 9, 2, 43, 2, '0000-00-00', '0000-00-00', 31),
(27, 7, 1, 36, 1, '0000-00-00', '0000-00-00', 6),
(28, 15, 1, 65, 1, '0000-00-00', '0000-00-00', 49),
(29, 10, 3, 39, 2, '0000-00-00', '0000-00-00', 88),
(30, 4, 3, 63, 2, '0000-00-00', '0000-00-00', 50),
(31, 6, 1, 34, 3, '0000-00-00', '0000-00-00', 37),
(32, 18, 1, 74, 2, '0000-00-00', '0000-00-00', 97),
(33, 3, 2, 86, 3, '0000-00-00', '0000-00-00', 39),
(34, 14, 3, 31, 2, '0000-00-00', '0000-00-00', 71),
(35, 14, 2, 35, 2, '0000-00-00', '0000-00-00', 88),
(36, 19, 2, 76, 1, '0000-00-00', '0000-00-00', 51),
(37, 14, 2, 34, 2, '0000-00-00', '0000-00-00', 76),
(38, 17, 1, 17, 2, '0000-00-00', '0000-00-00', 48),
(39, 12, 3, 31, 2, '0000-00-00', '0000-00-00', 20),
(40, 18, 1, 74, 2, '0000-00-00', '0000-00-00', 13),
(41, 15, 3, 94, 3, '0000-00-00', '0000-00-00', 29),
(42, 6, 3, 89, 3, '0000-00-00', '0000-00-00', 58),
(43, 4, 1, 67, 3, '0000-00-00', '0000-00-00', 92),
(44, 4, 1, 39, 2, '0000-00-00', '0000-00-00', 86),
(45, 17, 3, 5, 1, '0000-00-00', '0000-00-00', 8),
(46, 6, 3, 8, 3, '0000-00-00', '0000-00-00', 12),
(47, 2, 1, 100, 1, '0000-00-00', '0000-00-00', 52),
(48, 8, 2, 23, 2, '0000-00-00', '0000-00-00', 62),
(49, 19, 1, 74, 2, '0000-00-00', '0000-00-00', 4),
(50, 16, 1, 60, 2, '0000-00-00', '0000-00-00', 88),
(51, 6, 3, 36, 3, '0000-00-00', '0000-00-00', 16),
(52, 17, 3, 89, 3, '0000-00-00', '0000-00-00', 11),
(53, 16, 1, 64, 2, '0000-00-00', '0000-00-00', 66),
(54, 8, 2, 19, 3, '0000-00-00', '0000-00-00', 83),
(55, 9, 2, 85, 3, '0000-00-00', '0000-00-00', 100),
(56, 6, 1, 19, 2, '0000-00-00', '0000-00-00', 62),
(57, 10, 3, 34, 2, '0000-00-00', '0000-00-00', 25),
(58, 12, 2, 70, 2, '0000-00-00', '0000-00-00', 20),
(59, 7, 1, 74, 2, '0000-00-00', '0000-00-00', 72),
(60, 8, 2, 69, 2, '0000-00-00', '0000-00-00', 76),
(61, 13, 2, 48, 3, '0000-00-00', '0000-00-00', 34),
(62, 15, 1, 37, 2, '0000-00-00', '0000-00-00', 54),
(63, 11, 2, 4, 1, '0000-00-00', '0000-00-00', 72),
(64, 17, 3, 94, 3, '0000-00-00', '0000-00-00', 97),
(65, 8, 2, 22, 1, '0000-00-00', '0000-00-00', 52),
(66, 16, 2, 73, 3, '0000-00-00', '0000-00-00', 31),
(67, 7, 3, 13, 3, '0000-00-00', '0000-00-00', 85),
(68, 5, 2, 65, 3, '0000-00-00', '0000-00-00', 88),
(69, 9, 1, 22, 1, '0000-00-00', '0000-00-00', 79),
(70, 12, 1, 99, 2, '0000-00-00', '0000-00-00', 32),
(71, 10, 3, 48, 3, '0000-00-00', '0000-00-00', 98),
(72, 8, 1, 3, 2, '0000-00-00', '0000-00-00', 21),
(73, 9, 2, 32, 1, '0000-00-00', '0000-00-00', 46),
(74, 16, 1, 25, 1, '0000-00-00', '0000-00-00', 78),
(75, 11, 2, 24, 2, '0000-00-00', '0000-00-00', 35),
(76, 9, 2, 49, 2, '0000-00-00', '0000-00-00', 54),
(77, 14, 3, 33, 3, '0000-00-00', '0000-00-00', 72),
(78, 2, 2, 60, 1, '0000-00-00', '0000-00-00', 70),
(79, 1, 2, 56, 3, '0000-00-00', '0000-00-00', 79),
(80, 14, 2, 75, 2, '0000-00-00', '0000-00-00', 60),
(81, 8, 1, 9, 1, '0000-00-00', '0000-00-00', 16),
(82, 2, 1, 6, 3, '0000-00-00', '0000-00-00', 9),
(83, 18, 1, 93, 1, '0000-00-00', '0000-00-00', 96),
(84, 8, 2, 91, 1, '0000-00-00', '0000-00-00', 14),
(85, 13, 1, 98, 1, '0000-00-00', '0000-00-00', 99),
(86, 3, 1, 20, 1, '0000-00-00', '0000-00-00', 17),
(87, 6, 2, 18, 2, '0000-00-00', '0000-00-00', 40),
(89, 9, 2, 36, 2, '0000-00-00', '0000-00-00', 93),
(90, 11, 3, 63, 2, '0000-00-00', '0000-00-00', 86),
(91, 8, 1, 15, 1, '0000-00-00', '0000-00-00', 3),
(92, 9, 3, 30, 3, '0000-00-00', '0000-00-00', 98),
(93, 3, 2, 4, 1, '0000-00-00', '0000-00-00', 2),
(94, 12, 1, 38, 1, '0000-00-00', '0000-00-00', 94),
(95, 15, 3, 47, 2, '0000-00-00', '0000-00-00', 38),
(96, 17, 3, 80, 3, '0000-00-00', '0000-00-00', 51),
(97, 8, 1, 17, 1, '0000-00-00', '0000-00-00', 66),
(98, 10, 3, 70, 1, '0000-00-00', '0000-00-00', 41),
(99, 10, 3, 6, 1, '0000-00-00', '0000-00-00', 100),
(100, 3, 2, 98, 1, '0000-00-00', '0000-00-00', 96);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piso`
--

CREATE TABLE `piso` (
  `id` int(11) NOT NULL,
  `cantBox` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `piso`
--

INSERT INTO `piso` (`id`, `cantBox`) VALUES
(1, 20),
(2, 20),
(3, 20),
(1, 20),
(2, 20),
(3, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id` int(11) NOT NULL,
  `dueño` varchar(100) COLLATE utf16_spanish2_ci NOT NULL,
  `patente` varchar(30) COLLATE utf16_spanish2_ci NOT NULL,
  `marca` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `color` varchar(50) COLLATE utf16_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `estacionamiento`
--
ALTER TABLE `estacionamiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `estacionamiento`
--
ALTER TABLE `estacionamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
