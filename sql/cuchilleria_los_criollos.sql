-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2022 a las 12:45:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cuchilleria_los_criollos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `segmento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `segmento`) VALUES
(1, 'Cuchillos', 'Bronce'),
(2, 'Juegos', 'Oro'),
(3, 'Parrilleros', 'Plata'),
(4, 'Materos', 'Bronce'),
(22, 'Categoria 1', 'Bronce'),
(23, 'Categoria 2', 'Plata'),
(24, 'Categoria 3', 'Oro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `precio` double NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `imagen`, `precio`, `id_categoria`) VALUES
(21, 'Puñal Verijero', 'Cuchillo pequeño en hoja de acero inoxidable 8cm, con vaina de cuero', 'uploaded_files/634c72988a7e8cuchillos.png', 2000, 1),
(22, 'Cuchillo de Asador', 'Cuchillo en hoja de acero inoxidable 14cm, con vaina de cuero ', 'uploaded_files/634c749b939ee20200823_112554.jpg', 3500, 1),
(23, 'Juego de Trinchar', 'Cuchillo en hoja de acero inoxidable 14cm y tenedor haciendo juego, en estuche de cuero trenzado en ', 'uploaded_files/634c7878eca6220200805_220821.jpg', 6500, 2),
(24, 'Juego de 24 piezas', 'Juego de 12 cuchillos en hoja de acero inoxidable, con 12 tenedores haciendo juego, en caja exhibido', 'uploaded_files/634c7cb7cbc01WhatsApp Image 2022-10-16 at 18.43.29.jpeg', 85000, 2),
(25, 'Disco Grande', 'Disco de arado 65cm de diámetro, pared 15cm de alto, con tapa y 4 patas', 'uploaded_files/634c7dc47b622WhatsApp Image 2022-10-16 at 18.53.47.jpeg', 4500, 3),
(26, 'Planchetta Gde', 'Plancha de acero, tamaño grande que ocupa 2 hornallas, con asas', 'uploaded_files/634c7e7356bafWhatsApp Image 2022-10-16 at 18.55.58.jpeg', 4350, 3),
(27, 'Bombilla', 'Bombilla de alpaca grabada a mano', 'uploaded_files/634c7e9f6b1faWhatsApp Image 2022-10-16 at 18.44.08.jpeg', 350, 4),
(28, 'item 1', 'descripcion 1', 'uploaded_files/634c7f383da1dcriollos-logo.png', 11111, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', '$2y$10$LefSXebGIpBNn7FeGW0Pm.MZdJow0AeexH7v9T4RjYJU4GjrUf4Au');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
