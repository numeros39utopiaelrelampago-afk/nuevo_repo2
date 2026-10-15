-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2026 a las 14:44:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

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
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `rareza` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `stock`, `rareza`, `categoria`) VALUES
(1, 'forbidden droplet - ultra rare (RA01-EN064)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(2, 'evenly matched - ultra rare (RA01-EN074)', 6000.00, 1, 'ultra', 'cartas sueltas'),
(3, 'evenly matched - secret rare (RA01-EN074)', 8000.00, 1, 'secret', 'cartas sueltas'),
(4, 'evenly matched - secret rare (MP18-EN154)', 8000.00, 1, 'secret', 'cartas sueltas'),
(5, 'forbidden droplet - secret rare (ROTD-EN065)', 15000.00, 3, 'secret', 'cartas sueltas'),
(6, 'lightning storm - super rare (RA01-EN061)', 6000.00, 1, 'super', 'cartas sueltas'),
(7, 'lightning storm - ultra rare (RA01-EN061)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(8, 'sixth sense - ultra rare (MAMO-EN113)', 5000.00, 1, 'ultra', 'cartas sueltas'),
(9, 'transaction rollback - prismatic collector rare (RA04-EN105)', 8000.00, 1, 'prismatic collector', 'cartas sueltas'),
(10, 'dark magician of chaos - platinum secret rare (RA03-EN134)', 20000.00, 1, 'platinum', 'cartas sueltas'),
(11, 'dark ruler no more - super rare (RA01-EN060)', 6000.00, 1, 'super', 'cartas sueltas'),
(12, 'dark ruler no more - prismatic secret rare (TN19-EN014)', 8000.00, 1, 'prismatic secret', 'cartas sueltas'),
(13, 'dimension shifter - secret rare (RA01-EN014)', 5000.00, 1, 'secret', 'cartas sueltas'),
(14, 'super starslayer TY-PHON - sky crisis - super rare (RA04-EN072)', 5000.00, 1, 'super', 'cartas sueltas'),
(15, 'the winged dragon of ra - sphere mode - ultra rare (RA01-EN007)', 6000.00, 1, 'ultra', 'cartas sueltas'),
(16, 'nibiru the primal being - ultra rare (RA01-EN015)', 5000.00, 1, 'ultra', 'cartas sueltas'),
(17, 'super polymerization - ultra rare (RA03-EN053)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(18, 'pot of extravagance - quarter century secret rare (RA01-EN059)', 30000.00, 1, 'qcr', 'cartas sueltas'),
(19, 'toadally awesome - quarter century secret rare (RA03-EN040)', 25000.00, 1, 'qcr', 'cartas sueltas'),
(20, 'black whirlwind - quarter century secret rare (RA03-EN219)', 30000.00, 1, 'qcr', 'cartas sueltas'),
(21, 'elemental HERO flare neos - ultra rare 1st edition (POTD-EN032)', 25000.00, 1, 'ultra', 'cartas sueltas'),
(22, 'elemental HERO aqua neos - ultimate rare 1ra edicion NM (POTD-SP031)', 80000.00, 1, 'ultimate', 'cartas sueltas'),
(23, 'elemental HERO dark neos - ultra rare 1st edition (POTD-EN033)', 25000.00, 1, 'ultra', 'cartas sueltas'),
(24, 'elemental HERO air neos - ultra rare 1st edition (STON-EN034)', 500000.00, 1, 'ultra', 'cartas sueltas'),
(25, 'elemental HERO glow neos - ultra rare 1st edition (STON-EN036)', 25000.00, 1, 'ultra', 'cartas sueltas'),
(26, 'elemental HERO grand neos - ultra rare 1st edition (STON-EN035)', 25000.00, 1, 'ultra', 'cartas sueltas'),
(27, 'elemental HERO neos lord - ultra rare (MAMO-EN076)', 4000.00, 1, 'ultra', 'cartas sueltas'),
(28, 'elemental HERO liquid soldier - ultra rare (MAMO-EN047)', 5000.00, 1, 'ultra', 'cartas sueltas'),
(29, 'polymerization (alternate art) - quarter century secret rare (RA03-EN051)', 30000.00, 1, 'qcr', 'cartas sueltas'),
(30, 'neo space - ultimate rare 1st edition NM (POTD-EN046)', 40000.00, 1, 'ultimate', 'cartas sueltas'),
(31, 'stardust dragon - ultimate rare 1st edition MP (TDGS-EN040)', 600000.00, 1, 'ultimate', 'cartas sueltas'),
(32, 'red dragon archfiend - ultimate rare 1st edition MP (TDGS-EN041)', 350000.00, 1, 'ultimate', 'cartas sueltas'),
(33, 'black rose dragon - ultimate rare NM (CSOC-EN039)', 400000.00, 1, 'ultimate', 'cartas sueltas'),
(34, 'black-winged dragon - ultimate rare 1st edition NM (TSHD-EN040)', 100000.00, 1, 'ultimate', 'cartas sueltas'),
(35, 'ancient fairy dragon - ultimate rare NM (ANPR-EN040)', 75000.00, 1, 'ultimate', 'cartas sueltas'),
(36, 'power tool dragon - ultimate rare 1ra edicion LP (RGBT-SP042)', 80000.00, 1, 'ultimate', 'cartas sueltas'),
(37, 'judgment dragon - ultimate rare MP (TU01-EN000)', 500000.00, 1, 'ultimate', 'cartas sueltas'),
(38, 'chaos-end master - secret rare (RGBT-SP092)', 50000.00, 1, 'secret', 'cartas sueltas'),
(39, 'black luster soldier - envoy of the beginning - ultra rare (MAMA-EN047)', 9000.00, 1, 'ultra', 'cartas sueltas'),
(40, 'chaos-emperor dragon - envoy of the end - platinum secret rare (RA03-EN133)', 15000.00, 1, 'platinum', 'cartas sueltas'),
(41, 'hino-kagu-tsuchi - ultra rare (LOD-070)', 40000.00, 1, 'ultra', 'cartas sueltas'),
(42, 'demise - king of armageddon - super rare (SOI-EN035)', 8000.00, 1, 'super', 'cartas sueltas'),
(43, 'VWXYZ-dragon catapult cannon - super rare 1st edition (EEN-EN031)', 12000.00, 1, 'super', 'cartas sueltas'),
(44, 'immortal phoenix gearfried - ultra rare (TOCH-EN012)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(45, 'rainbow dragon - secret rare (TAEV-EN006)', 60000.00, 1, 'secret', 'cartas sueltas'),
(46, 'swords of revealing light - super rare 1ra edicion NM (LDD-S101)', 20000.00, 1, 'super', 'cartas sueltas'),
(47, 'flame swordsman - super rare 1ra edicion NM (LDD-S003)', 30000.00, 1, 'super', 'cartas sueltas'),
(48, 'gaia the dragon champion - secret rare 1ra edicion LP (LDD-S125)', 50000.00, 1, 'secret', 'cartas sueltas'),
(49, 'time wizard - ultra rare (MRD-065)', 40000.00, 1, 'ultra', 'cartas sueltas'),
(50, 'blue-eyes white dragon - ultra rare NM (reimpresion) (LOB-001)', 80000.00, 1, 'ultra', 'cartas sueltas'),
(51, 'playmat the shining darkness sneak peek', 50000.00, 1, 'otra', 'playmats'),
(52, 'mega tin 2020 (vacia)', 5000.00, 1, 'otra', 'tins'),
(53, 'mega tin 2021 (vacia)', 5000.00, 1, 'otra', 'tins'),
(54, 'mega tin 2022 (vacia)', 5000.00, 1, 'otra', 'tins'),
(55, 'I:P masquerena 9-pocket duelist portfolio (usado)', 30000.00, 1, 'otra', 'binders'),
(56, 'carpeta xion 24 hojas de 9 bolsillos acolchada (usado)', 15000.00, 1, 'otra', 'binders'),
(57, 'premium binder top deck 360 cartas acolchada con cierre (usado)', 120000.00, 2, 'otra', 'binders'),
(58, 'deckbox imantada de alta calidad para 120 cartas (usado)', 30000.00, 1, 'otra', 'deckbox'),
(59, 'toon kingdom - quarter century secret rare (MP24-EN006)', 9000.00, 1, 'qcr', 'cartas sueltas'),
(60, 'relinquished - ultra rare 1st edition LP (SDP-001)', 10000.00, 1, 'ultra', 'cartas sueltas'),
(61, 'aqua madoor - secret rare unlimited (LCYW-EN221)', 8000.00, 1, 'secret', 'cartas sueltas'),
(62, 'arcana force XXI - the world - ultimate rare NM (LODT-EN016)', 30000.00, 1, 'ultimate', 'cartas sueltas'),
(63, 'ash blossom & joyous spring - gold rare (MAGO-EN011)', 8000.00, 1, 'gold', 'cartas sueltas'),
(64, 'caius the mega monarch - ultra rare (SECE-EN035)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(65, 'mobius the mega monarch - secret rare (MP14-EN217)', 8000.00, 1, 'secret', 'cartas sueltas'),
(66, 'thestalos the mega monarch - secret rare (MP15-EN021)', 8000.00, 1, 'secret', 'cartas sueltas'),
(67, 'granmarg the mega monarch - secret rare (MP14-EN158)', 8000.00, 1, 'secret', 'cartas sueltas'),
(68, 'raiza the mega monarch - secret rare (MP15-EN091)', 8000.00, 1, 'secret', 'cartas sueltas'),
(69, 'zaborg the mega monarch - ultra rare (MP15-EN154)', 12000.00, 1, 'ultra', 'cartas sueltas'),
(70, 'caius the shadow monarch - gold rare (PGLD-EN066)', 20000.00, 1, 'gold', 'cartas sueltas'),
(71, 'chaos dragon levianeer - secret rare 1st edition NM (SOFU-EN025)', 15000.00, 1, 'secret', 'cartas sueltas'),
(72, 'lightsworn dragonling - quarter century secret rare (LEDE-EN023)', 50000.00, 1, 'qcr', 'cartas sueltas'),
(73, 'crossout designator - prismatic secret rare (MP22-EN265)', 10000.00, 1, 'prismatic secret', 'cartas sueltas'),
(74, 'dark armed dragon - gold rare (PGLD-EN064)', 9000.00, 1, 'gold', 'cartas sueltas'),
(75, 'dark magician girl - gold rare 1st edition LP (PGLD-EN033)', 15000.00, 1, 'gold', 'cartas sueltas'),
(76, 'diviner of the herald - secret rare 1st edition (LIOV-EN000)', 10000.00, 1, 'secret', 'cartas sueltas'),
(77, 'drill warrior - ultimate rare unlimited NM (ABPF-EN041)', 40000.00, 1, 'ultimate', 'cartas sueltas'),
(78, 'turbo warrior - ultimate rare unlimited LP (CSOC-EN038)', 15000.00, 1, 'ultimate', 'cartas sueltas'),
(79, 'jinzo - secret rare NM (CA-00)', 30000.00, 1, 'prismatic secret', 'cartas OCG'),
(80, 'gilford the lightning - prismatic secret rare (15AX-KRM17)', 8000.00, 1, 'prismatic secret', 'cartas OCG'),
(81, 'future fusion - ultra rare 1ra edicion (RYMP-SP064)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(82, 'gaia plate the earth giant - ultimate unlimited (ANPR-EN094)', 20000.00, 1, 'ultimate', 'cartas sueltas'),
(83, 'gateway of the six - super rare (SOVR-EN089)', 10000.00, 2, 'super', 'cartas sueltas'),
(84, 'ghost belle & haunted mansion - prismatic collector rare (RA01-EN011)', 10000.00, 1, 'prismatic collector', 'cartas sueltas'),
(85, 'grave of the super ancient organism - ultra rare spanish (RGBT-SP078)', 8000.00, 1, 'ultra', 'cartas sueltas'),
(86, 'graceful charity - black rare 1st edition (BP02-EN137)', 12000.00, 1, 'black rare', 'cartas sueltas'),
(87, 'ghost sister & spooky dogwood - secret rare (RA03-EN020)', 6000.00, 1, 'secret', 'cartas sueltas'),
(88, 'maxx \"c\" - platinum secret rare (RA04-EN150)', 15000.00, 1, 'platinum', 'cartas sueltas'),
(89, 'mulcharmy fuwalos - prismatic collector rare (RA04-EN050)', 30000.00, 1, 'prismatic collector', 'cartas sueltas'),
(90, 'high priestess of prophecy - secret rare 1st edition NM (REDU-EN020)', 30000.00, 1, 'secret', 'cartas sueltas'),
(91, 'scrap dragon - ultimate rare 1ra edicion NM (DREV-SP043)', 60000.00, 1, 'ultimate', 'cartas sueltas'),
(92, 'harmonic synchro fusion - collector\'s rare (MZMI-EN035)', 15000.00, 1, 'collector', 'cartas sueltas'),
(93, 'infernity destroyer - secret rare unlimited (TSHD-EN098)', 8000.00, 1, 'secret', 'cartas sueltas'),
(94, 'karma cut - gold rare (PGL2-PT067)', 8000.00, 1, 'gold', 'cartas sueltas'),
(95, 'levia-dragon daedalus - secret rare unlimited (LCYW-EN249)', 8000.00, 1, 'secret', 'cartas sueltas'),
(96, 'sabersaurus - secret rare 1st edition (LCJW-EN143)', 10000.00, 1, 'secret', 'cartas sueltas'),
(97, 'macro cosmos - shatterfoil NM (DT06-EN096)', 8000.00, 1, 'shatterfoil', 'cartas sueltas'),
(98, 'metal reflect slime - ultimate rare 1ra edicion MP (PTDN-SP094)', 15000.00, 1, 'ultimate', 'cartas sueltas'),
(99, 'night beam - ultimate rare 1st edition (GAOV-EN055)', 8000.00, 1, 'ultimate', 'cartas sueltas'),
(100, 'number 9: dyson sphere - ultimate rare unlimited (ABYR-EN044)', 10000.00, 1, 'ultimate', 'cartas sueltas'),
(101, 'lote cartas secret legendary collection', 25000.00, 1, 'otra', 'lotes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` enum('admin','cliente') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `pass`, `email`, `tipo`) VALUES
(1, 'Matias Q', '$2y$10$mOOPMNXlM7kGLzybj3FRf.83HTzvzjX7cidZQLhenR9EPb/4yY4Gi', 'me1_66@hotmail.com', 'admin'),
(3, 'Saul Menem', '$2y$10$Tt8QRfs3.xBpjXDuuSFQG.KY8FmorUTy3v8IoC1yQ2PQaC/oN57ua', 'saulmenem@gmail.com', 'cliente'),
(4, 'pedro', '$2y$10$lWeME3Ji/a7KF.cJ6f2t.u.ROlaWR8AnT6HVnC3YZXHqIyTy60UNe', 'pedro@gmail.com', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
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
-- AUTO_INCREMENT de la tabla `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
