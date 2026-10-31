-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2026 a las 16:20:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `e-commerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'binders'),
(2, 'cartas sueltas'),
(3, 'cartas OCG'),
(4, 'deckbox'),
(5, 'lotes'),
(6, 'playmats'),
(7, 'tins');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id_item`, `id_prod`, `id_venta`, `cantidad`, `precio`) VALUES
(1, 62, 1, 1, 30000.00),
(2, 35, 1, 1, 75000.00),
(3, 39, 2, 1, 9000.00),
(4, 33, 2, 1, 400000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `rareza` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `stock`, `rareza`, `id_categoria`, `activo`) VALUES
(1, 'forbidden droplet - ultra rare (RA01-EN064)', 8000.00, 1, 'ultra', 2, 1),
(2, 'evenly matched - ultra rare (RA01-EN074)', 6000.00, 1, 'ultra', 2, 1),
(3, 'evenly matched - secret rare (RA01-EN074)', 8000.00, 1, 'secret', 2, 1),
(4, 'evenly matched - secret rare (MP18-EN154)', 8000.00, 1, 'secret', 2, 1),
(5, 'forbidden droplet - secret rare (ROTD-EN065)', 15000.00, 3, 'secret', 2, 1),
(6, 'lightning storm - super rare (RA01-EN061)', 6000.00, 1, 'super', 2, 1),
(7, 'lightning storm - ultra rare (RA01-EN061)', 8000.00, 1, 'ultra', 2, 1),
(8, 'sixth sense - ultra rare (MAMO-EN113)', 5000.00, 1, 'ultra', 2, 1),
(9, 'transaction rollback - prismatic collector rare (RA04-EN105)', 8000.00, 1, 'prismatic collector', 2, 1),
(10, 'dark magician of chaos - platinum secret rare (RA03-EN134)', 20000.00, 1, 'platinum', 2, 1),
(11, 'dark ruler no more - super rare (RA01-EN060)', 6000.00, 1, 'super', 2, 1),
(12, 'dark ruler no more - prismatic secret rare (TN19-EN014)', 8000.00, 1, 'prismatic secret', 2, 1),
(13, 'dimension shifter - secret rare (RA01-EN014)', 5000.00, 1, 'secret', 2, 1),
(14, 'super starslayer TY-PHON - sky crisis - super rare (RA04-EN072)', 5000.00, 1, 'super', 2, 1),
(15, 'the winged dragon of ra - sphere mode - ultra rare (RA01-EN007)', 6000.00, 1, 'ultra', 2, 1),
(16, 'nibiru the primal being - ultra rare (RA01-EN015)', 5000.00, 1, 'ultra', 2, 1),
(17, 'super polymerization - ultra rare (RA03-EN053)', 8000.00, 1, 'ultra', 2, 1),
(18, 'pot of extravagance - quarter century secret rare (RA01-EN059)', 30000.00, 1, 'qcr', 2, 1),
(19, 'toadally awesome - quarter century secret rare (RA03-EN040)', 25000.00, 1, 'qcr', 2, 1),
(20, 'black whirlwind - quarter century secret rare (RA03-EN219)', 30000.00, 1, 'qcr', 2, 1),
(21, 'elemental HERO flare neos - ultra rare 1st edition NM (POTD-EN032)', 30000.00, 1, 'ultra', 2, 1),
(22, 'elemental HERO aqua neos - ultimate rare 1ra edicion NM (POTD-SP031)', 80000.00, 1, 'ultimate', 2, 1),
(23, 'elemental HERO dark neos - ultra rare 1st edition NM (POTD-EN033)', 30000.00, 1, 'ultra', 2, 1),
(24, 'elemental HERO air neos - ultra rare 1st edition LP (STON-EN034)', 500000.00, 1, 'ultra', 2, 1),
(25, 'elemental HERO glow neos - ultra rare 1st edition NM (STON-EN036)', 30000.00, 1, 'ultra', 2, 1),
(26, 'elemental HERO grand neos - ultra rare 1st edition NM (STON-EN035)', 30000.00, 1, 'ultra', 2, 1),
(27, 'elemental HERO neos lord - ultra rare (MAMO-EN076)', 4000.00, 1, 'ultra', 2, 1),
(28, 'elemental HERO liquid soldier - ultra rare (MAMO-EN047)', 5000.00, 1, 'ultra', 2, 1),
(29, 'polymerization (alternate art) - quarter century secret rare (RA03-EN051)', 30000.00, 1, 'qcr', 2, 1),
(30, 'neo space - ultimate rare 1st edition NM (POTD-EN046)', 40000.00, 1, 'ultimate', 2, 1),
(31, 'stardust dragon - ultimate rare 1st edition MP (TDGS-EN040)', 600000.00, 1, 'ultimate', 2, 1),
(32, 'red dragon archfiend - ultimate rare 1st edition MP (TDGS-EN041)', 350000.00, 1, 'ultimate', 2, 1),
(33, 'black rose dragon - ultimate rare NM (CSOC-EN039)', 400000.00, 1, 'ultimate', 2, 1),
(34, 'black-winged dragon - ultimate rare 1st edition NM (TSHD-EN040)', 100000.00, 1, 'ultimate', 2, 1),
(35, 'ancient fairy dragon - ultimate rare NM (ANPR-EN040)', 75000.00, 1, 'ultimate', 2, 1),
(36, 'power tool dragon - ultimate rare 1ra edicion LP (RGBT-SP042)', 80000.00, 1, 'ultimate', 2, 1),
(37, 'judgment dragon - ultimate rare MP (TU01-EN000)', 500000.00, 1, 'ultimate', 2, 1),
(38, 'chaos-end master - secret rare (RGBT-SP092)', 50000.00, 1, 'secret', 2, 1),
(39, 'black luster soldier - envoy of the beginning - ultra rare (MAMA-EN047)', 9000.00, 1, 'ultra', 2, 1),
(40, 'chaos-emperor dragon - envoy of the end - platinum secret rare (RA03-EN133)', 15000.00, 1, 'platinum', 2, 1),
(41, 'hino-kagu-tsuchi - ultra rare (LOD-070)', 40000.00, 1, 'ultra', 2, 1),
(42, 'demise - king of armageddon - super rare (SOI-EN035)', 8000.00, 1, 'super', 2, 1),
(43, 'VWXYZ-dragon catapult cannon - super rare 1st edition (EEN-EN031)', 12000.00, 1, 'super', 2, 1),
(44, 'immortal phoenix gearfried - ultra rare (TOCH-EN012)', 8000.00, 1, 'ultra', 2, 1),
(45, 'rainbow dragon - secret rare (TAEV-EN006)', 60000.00, 1, 'secret', 2, 1),
(46, 'swords of revealing light - super rare 1ra edicion NM (LDD-S101)', 20000.00, 1, 'super', 2, 1),
(47, 'flame swordsman - super rare 1ra edicion NM (LDD-S003)', 30000.00, 1, 'super', 2, 1),
(48, 'gaia the dragon champion - secret rare 1ra edicion LP (LDD-S125)', 50000.00, 1, 'secret', 2, 1),
(49, 'time wizard - ultra rare (MRD-065)', 40000.00, 1, 'ultra', 2, 1),
(50, 'blue-eyes white dragon - ultra rare NM (reimpresion) (LOB-001)', 80000.00, 1, 'ultra', 2, 1),
(51, 'playmat the shining darkness sneak peek', 50000.00, 1, 'otra', 6, 1),
(52, 'mega tin 2020 (vacia)', 5000.00, 1, 'otra', 7, 1),
(53, 'mega tin 2021 (vacia)', 5000.00, 1, 'otra', 7, 1),
(54, 'mega tin 2022 (vacia)', 5000.00, 1, 'otra', 7, 1),
(55, 'I:P masquerena 9-pocket duelist portfolio (usado)', 30000.00, 1, 'otra', 1, 1),
(56, 'carpeta xion 24 hojas de 9 bolsillos acolchada (usado)', 15000.00, 1, 'otra', 1, 1),
(57, 'premium binder top deck 360 cartas acolchada con cierre (usado)', 120000.00, 2, 'otra', 1, 1),
(58, 'deckbox imantada de alta calidad para 120 cartas (usado)', 30000.00, 1, 'otra', 4, 1),
(59, 'toon kingdom - quarter century secret rare (MP24-EN006)', 9000.00, 1, 'qcr', 2, 1),
(60, 'relinquished - ultra rare 1st edition LP (SDP-001)', 10000.00, 1, 'ultra', 2, 1),
(61, 'aqua madoor - secret rare unlimited (LCYW-EN221)', 8000.00, 1, 'secret', 2, 1),
(62, 'arcana force XXI - the world - ultimate rare NM (LODT-EN016)', 30000.00, 1, 'ultimate', 2, 1),
(63, 'ash blossom & joyous spring - gold rare (MAGO-EN011)', 8000.00, 1, 'gold', 2, 1),
(64, 'caius the mega monarch - ultra rare (SECE-EN035)', 8000.00, 1, 'ultra', 2, 1),
(65, 'mobius the mega monarch - secret rare (MP14-EN217)', 8000.00, 1, 'secret', 2, 1),
(66, 'thestalos the mega monarch - secret rare (MP15-EN021)', 8000.00, 1, 'secret', 2, 1),
(67, 'granmarg the mega monarch - secret rare (MP14-EN158)', 8000.00, 1, 'secret', 2, 1),
(68, 'raiza the mega monarch - secret rare (MP15-EN091)', 8000.00, 1, 'secret', 2, 1),
(69, 'zaborg the mega monarch - ultra rare (MP15-EN154)', 12000.00, 1, 'ultra', 2, 1),
(70, 'caius the shadow monarch - gold rare (PGLD-EN066)', 20000.00, 1, 'gold', 2, 1),
(71, 'chaos dragon levianeer - secret rare 1st edition NM (SOFU-EN025)', 15000.00, 1, 'secret', 2, 1),
(72, 'lightsworn dragonling - quarter century secret rare (LEDE-EN023)', 50000.00, 1, 'qcr', 2, 1),
(73, 'crossout designator - prismatic secret rare (MP22-EN265)', 5000.00, 1, 'prismatic secret', 2, 1),
(74, 'dark armed dragon - gold rare (PGLD-EN064)', 9000.00, 1, 'gold', 2, 1),
(75, 'dark magician girl - gold rare 1st edition LP (PGLD-EN033)', 15000.00, 1, 'gold', 2, 1),
(76, 'diviner of the herald - secret rare 1st edition (LIOV-EN000)', 10000.00, 1, 'secret', 2, 1),
(77, 'drill warrior - ultimate rare unlimited NM (ABPF-EN041)', 40000.00, 1, 'ultimate', 2, 1),
(78, 'turbo warrior - ultimate rare unlimited LP (CSOC-EN038)', 15000.00, 1, 'ultimate', 2, 1),
(79, 'jinzo - secret rare NM (CA-00)', 30000.00, 1, 'prismatic secret', 3, 1),
(80, 'gilford the lightning - prismatic secret rare (15AX-KRM17)', 8000.00, 1, 'prismatic secret', 3, 1),
(81, 'future fusion - ultra rare 1ra edicion (RYMP-SP064)', 8000.00, 1, 'ultra', 2, 1),
(82, 'gaia plate the earth giant - ultimate unlimited MP (ANPR-EN094)', 20000.00, 1, 'ultimate', 2, 1),
(83, 'gateway of the six - super rare (SOVR-EN089)', 10000.00, 2, 'super', 2, 1),
(84, 'ghost belle & haunted mansion - prismatic collector rare (RA01-EN011)', 10000.00, 1, 'prismatic collector', 2, 1),
(85, 'grave of the super ancient organism - ultra rare spanish (RGBT-SP078)', 8000.00, 1, 'ultra', 2, 1),
(86, 'graceful charity - black rare 1st edition (BP02-EN137)', 12000.00, 1, 'black rare', 2, 1),
(87, 'ghost sister & spooky dogwood - secret rare (RA03-EN020)', 6000.00, 1, 'secret', 2, 1),
(88, 'maxx \"c\" - platinum secret rare (RA04-EN150)', 15000.00, 1, 'platinum', 2, 1),
(89, 'mulcharmy fuwalos - prismatic collector rare (RA04-EN050)', 30000.00, 1, 'prismatic collector', 2, 1),
(90, 'high priestess of prophecy - secret rare 1st edition NM (REDU-EN020)', 30000.00, 1, 'secret', 2, 1),
(91, 'scrap dragon - ultimate rare 1ra edicion NM (DREV-SP043)', 60000.00, 1, 'ultimate', 2, 1),
(92, 'harmonic synchro fusion - collector\'s rare (MZMI-EN035)', 15000.00, 1, 'collector', 2, 1),
(93, 'infernity destroyer - secret rare unlimited (TSHD-EN098)', 8000.00, 1, 'secret', 2, 1),
(94, 'karma cut - gold rare (PGL2-PT067)', 8000.00, 1, 'gold', 2, 1),
(95, 'levia-dragon daedalus - secret rare unlimited (LCYW-EN249)', 8000.00, 1, 'secret', 2, 1),
(96, 'sabersaurus - secret rare 1st edition (LCJW-EN143)', 10000.00, 1, 'secret', 2, 1),
(97, 'macro cosmos - shatterfoil NM (DT06-EN096)', 8000.00, 1, 'shatterfoil', 2, 1),
(98, 'metal reflect slime - ultimate rare 1ra edicion MP (PTDN-SP094)', 15000.00, 1, 'ultimate', 2, 1),
(99, 'night beam - ultimate rare 1st edition (GAOV-EN055)', 8000.00, 1, 'ultimate', 2, 1),
(100, 'number 9: dyson sphere - ultimate rare unlimited (ABYR-EN044)', 10000.00, 1, 'ultimate', 2, 1),
(101, 'lote cartas secret legendary collection', 20000.00, 1, 'otra', 5, 1),
(102, 'lote monarcas', 30000.00, 1, 'otra', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `tipo` enum('admin','cliente') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `pass`, `email`, `telefono`, `direccion`, `provincia`, `ciudad`, `codigo_postal`, `tipo`) VALUES
(1, 'Matias Q', NULL, '$2y$10$mOOPMNXlM7kGLzybj3FRf.83HTzvzjX7cidZQLhenR9EPb/4yY4Gi', 'me1_66@hotmail.com', NULL, NULL, NULL, NULL, NULL, 'admin'),
(2, 'juan cito', NULL, '$2y$10$YiYKDmnKEkvECgUeH4mCseuzDaxguwqtMkCiBLWqulrlVfEQX5iDC', 'juan@gmail.com', NULL, NULL, NULL, NULL, NULL, 'cliente'),
(3, 'saul menem', NULL, '$2y$10$Tt8QRfs3.xBpjXDuuSFQG.KY8FmorUTy3v8IoC1yQ2PQaC/oN57ua', 'saulmenem@gmail.com', NULL, NULL, NULL, NULL, NULL, 'cliente'),
(4, 'pedro perez', NULL, '$2y$10$m4YgKgW9dKjaFUuttCLsmeebIJ0MokQwZivY0urs1RBbWUzDzGPIu', 'pedro@gmail.com', NULL, NULL, NULL, NULL, NULL, 'cliente'),
(5, 'matias2', NULL, '$2y$10$XzHeYgZCM2MDGGWtuabY1.XQU7tjjkPBE3DkRDwnbBcWOP1CzamKy', 'mdq@gmail.com', NULL, NULL, NULL, NULL, NULL, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_ventas`, `fecha`, `id_user`, `total`) VALUES
(1, '2026-10-16 13:19:23', 2, 105000.00),
(2, '2026-10-16 13:22:54', 2, 409000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_ventas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
