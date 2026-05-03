-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2026 a las 14:45:37
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
-- Base de datos: `ferreteria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `imagen`, `categoria_id`, `stock`) VALUES
(1, 'Construcción', NULL, 0, 0),
(2, 'Eléctricos', NULL, 0, 0),
(3, 'Herramientas', NULL, 0, 0),
(4, 'Jardinería', NULL, 0, 0),
(5, 'Pintura', NULL, 0, 0),
(6, 'Plomería', NULL, 0, 0),
(7, 'Baños', NULL, 0, 0),
(8, 'Cocina', NULL, 0, 0),
(9, 'Electrodomésticos', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(1, NULL, 4200.00, '2026-04-21 22:38:19'),
(2, NULL, 900.00, '2026-04-21 22:38:39'),
(3, 4, 5500.00, '2026-04-21 22:58:31'),
(4, 4, 1250.00, '2026-04-21 23:01:31'),
(5, 4, 1200.00, '2026-04-22 12:40:54'),
(6, 4, 2100.00, '2026-04-24 02:00:40'),
(7, 3, 5800.00, '2026-04-25 22:10:56'),
(8, 3, 5800.00, '2026-04-25 22:11:05'),
(9, 4, 22400.00, '2026-04-27 10:47:14'),
(10, 4, 200.00, '2026-04-27 10:48:25'),
(11, 4, 750.00, '2026-04-27 10:48:48'),
(12, 3, 900.00, '2026-04-27 10:50:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio`) VALUES
(1, 1, 97, 1, 4200.00),
(2, 2, 28, 1, 900.00),
(3, 3, 95, 1, 5500.00),
(4, 4, 26, 5, 250.00),
(5, 5, 3, 8, 150.00),
(6, 6, 74, 6, 350.00),
(7, 7, 94, 1, 5800.00),
(8, 8, 94, 1, 5800.00),
(9, 9, 96, 7, 3200.00),
(10, 10, 18, 1, 200.00),
(11, 11, 25, 1, 750.00),
(12, 12, 28, 1, 900.00);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `orden`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `orden` (
`id` int(11)
,`nombre` varchar(100)
,`precio` decimal(10,2)
,`imagen` varchar(100)
,`categoria_id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `ventas` int(11) DEFAULT 0,
  `producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `imagen`, `categoria_id`, `stock`, `ventas`, `producto_id`) VALUES
(1, 'Cemento blanco', 580.00, 'img/construccion/cemento blanco.png', 1, 90, 0, 0),
(2, 'Tarugos', 120.00, 'img/construccion/tarugos.png', 1, 5, 12, 0),
(3, 'Tornillos', 150.00, 'img/construccion/tornillos destria.png', 1, 76, 0, 0),
(4, 'Clavos', 100.00, 'img/construccion/clavos.png', 1, 90, 0, 0),
(5, 'Malla metalica', 3500.00, 'img/construccion/malla metalica.webp', 1, 90, 0, 0),
(6, 'Madera', 1200.00, 'img/construccion/madera.png', 1, 18, 0, 0),
(7, 'Varilla', 650.00, 'img/construccion/varilla.webp', 1, 12, 0, 0),
(8, 'Grava', 900.00, 'img/construccion/grava.png', 1, 90, 0, 0),
(9, 'Arena', 850.00, 'img/construccion/arena.avif', 1, 13, 0, 0),
(10, 'Ladrillo', 25.00, 'img/construccion/ladrillo.webp', 1, 18, 0, 0),
(11, 'Block', 45.00, 'img/construccion/block.png', 1, 19, 0, 0),
(12, 'Cemento gris', 550.00, 'img/construccion/cemento.webp', 1, 15, 0, 0),
(13, 'Interruptor termomagnetico', 950.00, 'img/electricos/interruptor termomagnetico.png', 2, 8, 0, 0),
(14, 'Transformador', 1800.00, 'img/electricos/transformador.webp', 2, 4, 0, 0),
(15, 'Tomacorriente', 120.00, 'img/electricos/tomacorriente.webp', 2, 10, 0, 0),
(16, 'Clips para cable', 60.00, 'img/electricos/clips para cable.png', 2, 8, 0, 0),
(17, 'Cinta aislante', 45.00, 'img/electricos/cinta aislante.png', 2, 20, 0, 0),
(18, 'Terminales y conectores', 200.00, 'img/electricos/terminales y conectores.png', 2, 17, 0, 0),
(19, 'Caja electrica', 300.00, 'img/electricos/caja electrica.png', 2, 20, 0, 0),
(20, 'Interruptor', 90.00, 'img/electricos/interruptor.png', 2, 6, 0, 0),
(21, 'Bombilla', 150.00, 'img/electricos/bombilla.png', 2, 20, 0, 0),
(22, 'Cable electrico', 35.00, 'img/electricos/cable electrico.png', 2, 6, 0, 0),
(25, 'Martillo de acero', 750.00, 'img/herramientas/martillo.jpg', 3, 76, 0, 0),
(26, 'Destornillador plano', 250.00, 'img/herramientas/destornillador_plano.jpg', 3, 84, 0, 0),
(27, 'Destornillador estrella', 275.00, 'img/herramientas/destornillador_estrella.jpg', 3, 77, 0, 0),
(28, 'Llave inglesa', 900.00, 'img/herramientas/llave_inglesa.jpg', 3, 89, 0, 0),
(29, 'Alicate universal', 500.00, 'img/herramientas/alicate.jpg', 3, 13, 0, 0),
(30, 'Taladro eléctrico', 3200.00, 'img/herramientas/taladro.jpg', 3, 3, 0, 0),
(31, 'Serrucho', 650.00, 'img/herramientas/serrucho.jpg', 3, 17, 0, 0),
(32, 'Cinta métrica', 220.00, 'img/herramientas/cinta_metrica.jpg', 3, 17, 0, 0),
(33, 'Nivel de burbuja', 400.00, 'img/herramientas/nivel.jpg', 3, 20, 0, 0),
(34, 'Llave Allen set', 550.00, 'img/herramientas/llave_allen.jpg', 3, 6, 0, 0),
(35, 'Caja de herramientas', 1800.00, 'img/herramientas/caja_herramientas.jpg', 3, 12, 0, 0),
(36, 'Cutter profesional', 180.00, 'img/herramientas/cutter.jpg', 3, 17, 0, 0),
(37, 'Pala de jardín', 850.00, 'img/jardineria/pala.jpg', 4, 15, 0, 0),
(38, 'Rastrillo metálico', 700.00, 'img/jardineria/rastrillo.jpg', 4, 12, 0, 0),
(39, 'Tijeras de podar', 600.00, 'img/jardineria/tijeras_podar.jpg', 4, 8, 0, 0),
(40, 'Manguera 10m', 1200.00, 'img/jardineria/manguera.jpg', 4, 6, 0, 0),
(41, 'Regadera plástica', 450.00, 'img/jardineria/regadera.jpg', 4, 18, 0, 0),
(42, 'Guantes de jardinería', 250.00, 'img/jardineria/guantes.jpg', 4, 20, 0, 0),
(43, 'Carretilla', 3500.00, 'img/jardineria/carretilla.jpg', 4, 17, 0, 0),
(44, 'Abono orgánico', 400.00, 'img/jardineria/abono.jpg', 4, 20, 0, 0),
(45, 'Maceta grande', 750.00, 'img/jardineria/maceta.jpg', 4, 12, 0, 0),
(46, 'Aspersor de agua', 550.00, 'img/jardineria/aspersor.jpg', 4, 18, 0, 0),
(47, 'Semillas variadas', 200.00, 'img/jardineria/semillas.jpg', 4, 13, 0, 0),
(48, 'Azadón', 800.00, 'img/jardineria/azadon.jpg', 4, 18, 0, 0),
(49, 'Pintura blanca 1 cubeta', 1800.00, 'img/pintura/pintura_blanca.jpg', 5, 90, 0, 0),
(50, 'Pintura azul 1 cubeta\r\n', 1850.00, 'img/pintura/pintura_azul.jpg', 5, 4, 0, 0),
(51, 'Rodillo', 350.00, 'img/pintura/rodillo.jpg', 5, 90, 0, 0),
(52, 'Brocha 2 pulgadas', 200.00, 'img/pintura/brocha.jpg', 5, 90, 0, 0),
(53, 'Bandeja para pintura', 300.00, 'img/pintura/bandeja.jpg', 5, 12, 0, 0),
(54, 'Cinta de enmascarar', 180.00, 'img/pintura/cinta.jpg', 5, 91, 0, 0),
(55, 'Pintura roja 1 cubeta', 1850.00, 'img/pintura/pintura_roja.jpg', 5, 90, 0, 0),
(56, 'Espátula', 320.00, 'img/pintura/espatula.jpg', 5, 15, 0, 0),
(57, 'Lija', 100.00, 'img/pintura/lija.jpg', 5, 16, 0, 0),
(58, 'Sellador', 1500.00, 'img/pintura/sellador.jpg', 5, 20, 0, 0),
(59, 'Diluyente', 500.00, 'img/pintura/diluyente.jpg', 5, 16, 0, 0),
(60, 'Pintura amarilla 1 cubeta', 1800.00, 'img/pintura/pintura_amarilla.jpg', 5, 19, 0, 0),
(61, 'Tubo PVC 1/2\"', 200.00, 'img/plomeria/tubo_pvc.jpg', 6, 4, 0, 0),
(62, 'Codo PVC', 80.00, 'img/plomeria/codo.jpg', 6, 87, 0, 0),
(63, 'Llave de paso', 450.00, 'img/plomeria/llave_paso.jpg', 6, 79, 0, 0),
(64, 'Grifo metálico', 1200.00, 'img/plomeria/grifo.jpg', 6, 88, 0, 0),
(65, 'Sifón', 300.00, 'img/plomeria/sifon.jpg', 6, 90, 0, 0),
(66, 'Cinta teflón', 70.00, 'img/plomeria/teflon.jpg', 6, 90, 0, 0),
(67, 'Bomba de agua', 4500.00, 'img/plomeria/bomba.jpg', 6, 8, 0, 0),
(68, 'Ducha', 900.00, 'img/plomeria/ducha.jpg', 6, 12, 0, 0),
(69, 'Conector PVC', 100.00, 'img/plomeria/conector.jpg', 6, 13, 0, 0),
(70, 'Manguera flexible', 350.00, 'img/plomeria/manguera_flexible.jpg', 6, 19, 0, 0),
(71, 'Llave grifa', 650.00, 'img/plomeria/llave_grifa.jpg', 6, 16, 0, 0),
(72, 'Desagüe', 400.00, 'img/plomeria/desague.jpg', 6, 11, 0, 0),
(73, 'Toallero', 120.00, 'img/banos/toallero.jpg', 7, 90, 0, 0),
(74, 'Espejo baño', 350.00, 'img/banos/espejo_bano.jpg', 7, 82, 0, 0),
(75, 'Jabonera', 80.00, 'img/banos/jabonera.jpg', 7, 65, 0, 0),
(76, 'Porta cepillo de dientes', 90.00, 'img/banos/porta_cepillo.jpg', 7, 76, 0, 0),
(77, 'Porta papel higiénico', 100.00, 'img/banos/porta_papel.jpg', 7, 80, 0, 0),
(78, 'Alfombra antideslizante', 150.00, 'img/banos/alfombra.jpg', 7, 40, 0, 0),
(79, 'Ducha eléctrica', 900.00, 'img/banos/ducha_electrica.jpg', 7, 90, 0, 0),
(80, 'Grifo lavabo', 450.00, 'img/banos/grifo_lavabo.jpg', 7, 11, 12, 0),
(81, 'Cortina para baño', 250.00, 'img/banos/cortina_bano.jpg', 7, 90, 0, 0),
(82, 'Espejo con luz LED', 1200.00, 'img/banos/espejo_led.jpg', 7, 14, 0, 0),
(83, 'Bote para basura baño', 180.00, 'img/banos/bote_basura.jpg', 7, 40, 0, 0),
(84, 'Jarra para enjuague', 130.00, 'img/banos/jarra_enjuague.jpg', 7, 20, 0, 0),
(85, 'Licuadora', 1500.00, 'img/electrodomesticos/licuadora.jpg', 8, 80, 0, 0),
(86, 'Microondas', 3200.00, 'img/electrodomesticos/microondas.jpg', 8, 8, 0, 0),
(87, 'Refrigerador', 7800.00, 'img/electrodomesticos/refrigerador.jpg', 8, 11, 0, 0),
(88, 'Plancha', 900.00, 'img/electrodomesticos/plancha.jpg', 8, 4, 0, 0),
(89, 'Tostadora', 700.00, 'img/electrodomesticos/tostadora.jpg', 8, 18, 0, 0),
(90, 'Cafetera', 1300.00, 'img/electrodomesticos/cafetera.jpg', 8, 16, 0, 0),
(91, 'Extractor de jugos', 1600.00, 'img/electrodomesticos/extractor_jugos.jpg', 8, 19, 0, 0),
(92, 'Ventilador', 800.00, 'img/electrodomesticos/ventilador.jpg', 8, 13, 0, 0),
(93, 'Calentador eléctrico', 2400.00, 'img/electrodomesticos/calentador.jpg', 8, 10, 0, 0),
(94, 'Lavadora', 5800.00, 'img/electrodomesticos/lavadora.jpg', 8, 10, 0, 0),
(95, 'Secadora', 5500.00, 'img/electrodomesticos/secadora.jpg', 8, 10, 0, 0),
(96, 'Horno eléctrico', 3200.00, 'img/electrodomesticos/horno.jpg', 8, 10, 0, 0),
(97, 'Estufa', 4200.00, 'img/cocina/estufa.jpg', 9, 10, 0, 0),
(98, 'Olla exprés', 500.00, 'img/cocina/olla_expres.jpg', 9, 10, 0, 0),
(99, 'Juego de sartenes', 1200.00, 'img/cocina/sartenes.jpg', 9, 90, 0, 0),
(100, 'Licuadora de mano', 650.00, 'img/cocina/licuadora_mano.jpg', 9, 18, 0, 0),
(101, 'Cuchillo chef', 300.00, 'img/cocina/cuchillo_chef.jpg', 9, 20, 0, 0),
(102, 'Tabla para picar', 200.00, 'img/cocina/tabla_picar.jpg', 9, 20, 0, 0),
(103, 'Tetera', 350.00, 'img/cocina/tetera.jpg', 9, 16, 0, 0),
(104, 'Sartén antiadherente', 450.00, 'img/cocina/sarten_antiadherente.jpg', 9, 19, 0, 0),
(105, 'Colador', 120.00, 'img/cocina/colador.jpg', 9, 20, 0, 0),
(106, 'Batidora', 800.00, 'img/cocina/batidora.jpg', 9, 17, 0, 0),
(107, 'Cafetera espresso', 2000.00, 'img/cocina/cafetera_espresso.jpg', 9, 17, 0, 0),
(108, 'Mandolina', 400.00, 'img/cocina/mandolina.jpg', 9, 17, 0, 0),
(111, 'Lámpara LED', 1000.00, 'img/prod_69cc190f560601.74208573.jpg', 2, 11, 0, 0),
(112, 'tiras led', 2000.00, 'img/prod_69d42097c296b8.44150417.png', 2, 4, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `rol` varchar(20) DEFAULT 'cliente',
  `fecha_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `email`, `clave`, `rol`, `fecha_registro`) VALUES
(3, 'shafar', 'jefferson', 'acosta', 'jefferson@gmail.com', '$2y$10$fTms8T07av8nyvqawpxOYezqKBW/EuApiR3l/q2iDlzLAWnE32px.', 'admin', '2026-04-20'),
(4, 'joyon', 'josue', 'morel', 'josue@gmail.com', '$2y$10$Q1rme6vMFhn2yJRm3.EDmeLkGFCPXK2rudXMBPTeFjnIaCBBqA6iK', 'cliente', '2026-04-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `producto_id` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `metodo_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`producto_id`, `precio`, `metodo_pago`) VALUES
(76, 90, 0),
(85, 1500, 0),
(2, 120, 0),
(50, 1850, 0),
(31, 650, 0),
(43, 3500, 0),
(35, 1800, 0),
(81, 250, 0),
(75, 80, 0),
(75, 80, 0),
(84, 130, 0),
(85, 1500, 0),
(78, 150, 0),
(70, 350, 0),
(104, 450, 0),
(18, 200, 0),
(14, 1800, 0),
(71, 650, 0),
(108, 400, 0),
(19, 300, 0),
(28, 900, 0),
(28, 900, 0),
(28, 900, 0),
(72, 400, 0),
(14, 1800, 0),
(11, 45, 0),
(58, 1500, 0),
(54, 180, 0),
(104, 450, 0),
(9, 850, 0),
(104, 450, 0),
(26, 250, 0),
(40, 1200, 0),
(3, 150, 0),
(51, 350, 0),
(65, 300, 0),
(2, 120, 0),
(43, 3500, 0),
(27, 275, 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `orden`
--
DROP TABLE IF EXISTS `orden`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `orden`  AS SELECT `productos`.`id` AS `id`, `productos`.`nombre` AS `nombre`, `productos`.`precio` AS `precio`, `productos`.`imagen` AS `imagen`, `productos`.`categoria_id` AS `categoria_id` FROM `productos` ORDER BY `productos`.`imagen` ASC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
