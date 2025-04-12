-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-04-2025 a las 08:12:27
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `desafio2dss`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Personajes'),
(2, 'Objetos mágicos'),
(3, 'Merchandising');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(150) NOT NULL,
  `url_imagen` varchar(2048) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `url_imagen`, `precio`, `stock`, `id_categoria`) VALUES
(1, 'Figura de Finn el Humano', 'https://i.ebayimg.com/thumbs/images/g/bS0AAOSwe1ZnAypj/s-l1200.jpg', '19.99', 20, 1),
(3, 'Figura de la Dulce Princesa', 'https://p.turbosquid.com/ts-thumb/oO/UGsfpK/DHdD0NBC/1/jpg/1522840419/600x600/fit_q87/194932272d3d289db77c78554941e13225bc6aef/1.jpg', '22.00', 15, 1),
(5, 'Figura de Marceline la Vampira', 'https://m.media-amazon.com/images/I/71KgZBXN4HL.jpg', '24.75', 10, 1),
(6, 'Espada Demoníaca de Finn', 'https://ih1.redbubble.net/image.5057549145.6110/st,medium,507x507-pad,600x600,f8f8f8.webp', '35.00', 10, 2),
(8, 'Manual del Enchiridion', 'https://m.media-amazon.com/images/I/71vUXQ1TqjL._AC_UF1000,1000_QL80_.jpg', '29.99', 8, 2),
(9, 'Hacha-Bajo de Marceline', 'https://m.media-amazon.com/images/I/61utAdKz5tL.jpg', '49.99', 4, 2),
(10, 'Camiseta de BMO', 'https://m.media-amazon.com/images/I/A1dbsmzbGeL._CLa%7C2140%2C2000%7C71QlX5i3duL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_UY1000_.png', '15.00', 25, 3),
(12, 'Mochila del Reino de Ooo', 'https://ih1.redbubble.net/image.1425540509.1141/ur,backpack_front,square,600x600.jpg', '27.00', 12, 3),
(13, 'Cuaderno de Jake', 'https://ih1.redbubble.net/image.1466987324.7349/sn,x600-pad,600x600,f8f8f8.u2.jpg', '9.99', 20, 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
