-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2022 a las 17:15:59
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(55) NOT NULL,
  `telefono` int(9) NOT NULL,
  `email_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `nombre`, `apellido`, `telefono`, `email_usuario`) VALUES
(1, 'Maria', 'Cañas', 123456789, 'user1@gmail.com'),
(2, 'Raul', 'Perez', 657423111, 'user1@gmail.com'),
(3, 'Carlos', 'Alcaraz', 657423110, 'user2@gmail.com'),
(4, 'Ismael', 'Bartolome', 657123110, 'user2@gmail.com'),
(5, 'Maria', 'Sanz', 123456789, 'user3@gmail.com'),
(6, 'Maria', 'Sanz', 123456789, 'user2@gmail.com'),
(7, 'Manu', 'Sanz', 987654321, 'user1@gmail.com'),
(8, 'Mari ', 'Sol', 987654321, 'user3@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `email_usuario` varchar(50) NOT NULL,
  `telefono_contacto` int(9) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(4) NOT NULL,
  `duracion_min` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`email_usuario`, `telefono_contacto`, `fecha`, `hora`, `duracion_min`, `id`) VALUES
('user1@gmail.com', 657423111, '2022-04-07', '09:57:46.0000', 30, 1),
('user1@gmail.com', 123456789, '2022-05-09', '21:26:52.0000', 50, 2),
('user1@gmail.com', 123456789, '2021-12-07', '06:57:46.0000', 20, 4),
('user2@gmail.com', 657123110, '2022-04-29', '04:27:46.0000', 15, 5),
('user3@gmail.com', 987654321, '2002-03-01', '04:57:46.0000', 4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `email_usuario` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasenia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`email_usuario`, `nombre`, `apellido`, `contrasenia`) VALUES
('user1@gmail.com', 'Maria', 'Cañas', 'userpass'),
('user2@gmail.com', 'Carlos', 'Sanchez', 'passCarlos'),
('user3@gmail.com', 'Manuel', 'Casado', 'casadopass');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `id_usuario` (`email_usuario`),
  ADD KEY `telefono` (`telefono`),
  ADD KEY `email_usuario` (`email_usuario`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_usuario` (`email_usuario`,`telefono_contacto`),
  ADD KEY `telefono_contacto` (`telefono_contacto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`email_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`email_usuario`) REFERENCES `usuario` (`email_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`email_usuario`) REFERENCES `usuario` (`email_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`telefono_contacto`) REFERENCES `contacto` (`telefono`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
