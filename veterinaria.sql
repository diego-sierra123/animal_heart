-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 09-06-2026 a las 03:31:52
-- Versión del servidor: 8.0.46
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `id_articulo` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `mascota` varchar(50) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `tamano_mascota` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `etapa_vida` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `valor` int NOT NULL,
  `costo_conseguido` int NOT NULL,
  `stock` int NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `foto` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_tipo_articulo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`id_articulo`, `nombre`, `descripcion`, `mascota`, `marca`, `tamano_mascota`, `etapa_vida`, `valor`, `costo_conseguido`, `stock`, `fecha_vencimiento`, `foto`, `id_proveedor`, `id_tipo_articulo`) VALUES
(1, 'Hills cachorro paws 1 Kg', 'Nutrición diseñada para las necesidades de desarrollo de cachorros pequeños.', 'Perros', 'Hills', 'Pequeños', 'Cachorros', 37000, 25000, 89, '2026-12-31', 'img/1.png', 1, 1),
(2, 'Hills Science Diet Adult Indoor Cat', 'Alimento especial para gatos para su nutrición.', 'Gatos', 'Hills', '-----', 'Adultos', 71576, 55000, 97, '2026-12-31', 'img/2.jpg', 1, 1),
(3, 'Comida de aves de 2.5 a 5 Libras', 'Alimento para aves contiene entre 2.5 a 5 libras.', 'Aves', 'Smart Selects', 'Cualquiera', 'Cualquiera', 37000, 27000, 99, '2026-12-31', 'img/3.jpg', 11, 1),
(4, 'Comida de roedores de 2 a 5 Libras', 'Comida para todos los roedores contiene entre 2 a ...', 'Roedores', 'Sunburst', 'Cualquiera', 'Cualquiera', 32700, 28000, 99, '2026-12-31', 'img/4.jpg', 11, 1),
(5, 'Lata de comida de peces de 2.2 a 7.06 Onzas', 'Lata de alimentación para los preces contiene entr...', 'Peces', 'Tetra Min', 'Cualquiera', 'Cualquiera', 29000, 29000, 99, '2026-12-31', 'img/5.jpg', 11, 1),
(6, 'Hills cachorro small paws 2 Kg', 'Nutrición diseñada para las necesidades únicas de ...', 'Perros', 'Hills', 'Pequeños', 'Cachorros', 75000, 55000, 99, '2026-12-31', 'img/6.jpg', 1, 1),
(7, 'Hills cachorro paws 2 Kg', 'Nutrición diseñada para perros pequeños.', 'Perros', 'Hills', 'Pequeños', 'Cachorros', 75000, 65000, 98, '2026-12-31', 'img/7.jpg', 1, 1),
(8, 'Evolve classic dog chicken para adultos', 'Alimento natural, con proteína de pollo 100%, nutr...', 'Perros', 'Evolve', 'Cualquiera', 'Adultos', 12500, 10000, 99, '2026-12-31', 'img/8.jpg', 2, 1),
(9, 'Reelds TGI para perro adultos', 'Alimento natural húmedo para perros adultos, Diseñ...', 'Perros', 'Medical Pet', 'Cualquiera', 'Cualquiera', 11000, 75000, 99, '2026-12-31', 'img/9.jpg', 3, 1),
(10, 'Ronik pate de salmon por 500 gr', 'Alimento natural húmedo, protegen las funciones de...', 'Perros', 'Ronik', 'Cualquiera', 'Cualquiera', 8500, 5000, 99, '2026-12-31', 'img/10.jpg', 3, 1),
(11, 'Neoclean 4 Kg', 'contiene 100% bentonita de sodio, es súper absorbe...', 'Perros', 'Neo Clean', 'Cualquiera', 'Cualquiera', 140000, 8000, 99, '2026-12-31', 'img/11.jpg', 4, 1),
(12, 'Dog chow adulto raza grande 475 Gr', 'Alimento para razas grandes es un producto altamen...', 'Perros', 'Dog Chow', 'Grandes', 'Adultos', 45000, 40000, 99, '2026-12-31', 'img/12.jpg', 5, 1),
(13, 'Dog show raza chica 2 Kg', 'Alimento para razas pequeñas es un producto altame...', 'Perros', 'Dog Chow', 'Pequeños', 'Adultos', 25500, 20000, 99, '2026-12-31', 'img/13.png', 4, 1),
(14, 'Dog chow mini y chico 2 Kg', 'Alimento de perros adultos medianos/grandes, consu...', 'Perros', 'Dog Chow', 'Pequeños', 'Cachorros', 26500, 20000, 99, '2026-12-31', 'img/14.jpg', 1, 1),
(15, 'Dog chow mini y chicos 475 Gr', 'Este alimento es para perros adultos medianos/gran...', 'Perros', 'Dog Chow', 'Pequeños', 'Cachorros', 4600, 25000, 99, '2026-12-31', 'img/15.jpg', 5, 1),
(16, 'Chunky adulto raza chica 500 Gr', 'Alimento completo para ser suministrado a perros a...', 'Perros', 'Chunky', 'Pequeños', 'Adultos', 4800, 2340, 99, '2026-12-31', 'img/16.jpg', 5, 1),
(17, 'Nutrecan Adultos razas chicas por 800 Gr', 'Alimento completo y balanceado para los perros de ...', 'Perros', 'Nutre Can', 'Pequeños', 'Cualquiera', 8000, 4500, 99, '2026-12-31', 'img/17.jpg', 7, 1),
(18, 'Nutrecan Adultos razas chicas por 2 Kg', 'Alimento completo para los perros de razas pequeña...', 'Perros', 'Nutre Can', 'Pequeños', 'Adultos', 16800, 9800, 99, '2026-12-31', 'img/18.jpg', 7, 1),
(19, 'Nutrecan adultos RM y RG por 800 Gr', 'Alimento completo para los perros adultos.', 'Perros', 'Nutre Can', 'Grandes', 'Adutos', 6500, 3500, 99, '2026-12-31', 'img/19.jpg', 7, 1),
(20, 'Nutrecan adultos RM y RG por 2 Kg', 'Alimento completo recomendado para los perros adul...', 'Perros', 'Nutre Can', 'Grandes', 'Adultos', 16800, 8700, 99, '2026-12-31', 'img/20.jpg', 7, 1),
(21, 'Chunky cachorro por 2 Kg', 'Concentrado para cachorros que aportará los nivele...', 'Perros', 'Chuncky', 'Grandes', 'Cachorros', 20200, 4500, 99, '2026-12-31', 'img/21.jpg', 8, 1),
(22, 'Healthy love Perro cachorros 100 Gr', 'Alimento completo para perros de óptimo balance nu...', 'Perros', 'Healthy', 'Pequeños', 'Cachorros', 3500, 2500, 99, '2026-12-31', 'img/22.jpg', 3, 1),
(23, 'Birbo cachorros por 1 Kg', 'Alimento para cachorros, ayuda al desarrollo nutri...', 'Perros', 'Birbo', 'Pequeños', 'Cachorros', 14200, 10000, 99, '2026-12-31', 'img/23.jpg', 7, 1),
(24, 'Birbo perros por 1 Kg', 'Alimento para perros, ayuda al desarrollo nutricio...', 'Perros', 'Birbo', 'Cualquiera', 'Cualquiera', 12000, 8700, 99, '2026-12-31', 'img/24.jpg', 7, 1),
(25, 'Hills gato C/D 1.5 Kg', 'Concentrado especialmente diseñado para tratar pro...', 'Gatos', 'Hills', 'Cualquiera', 'Cualquiera', 125000, 100000, 99, '2026-12-31', 'img/25.jpg', 1, 1),
(26, 'Evolve gato lata naranja pavo para adultos', 'Alimento húmedo de pavo para gatos adultos.', 'Gatos', 'Evolve', 'Grandes', 'Adultos', 7600, 3400, 99, '2026-12-31', 'img/26.jpg', 1, 1),
(27, 'Evolve gato frutos del mar para adultos', 'Alimento para gatos adultos ayuda a evitar alergía...', 'Gatos', 'Evolve', 'Grandes', 'Adultos', 7600, 4500, 99, '2026-12-31', 'img/27.jpg', 2, 1),
(28, 'Evolve pouch gato salmon x gr para adultos', 'Nutrición necesaria para la salud y la vitalidad d...', 'Gatos', 'Evolve', 'Grandes', 'Adultos', 5700, 4500, 99, '2026-12-31', 'img/28.jpg', 2, 1),
(29, 'Nutra Nuggets 3 Kg gato mantenimiento', 'Concentrado para gatos con sabor a pollo.', 'Gatos', 'Nutra Nuggets', 'Cualquiera', 'Cualquiera', 55000, 45000, 99, '2026-12-31', 'img/29.jpg', 9, 1),
(30, 'Felix adulto carne pouch para adultos', 'Alimento húmedo con rico sabor a carne y atrayente...', 'Gatos', 'Felix', 'Grandes', 'Adultos', 3200, 1800, 99, '2026-12-31', 'img/30.jpg', 11, 1),
(31, 'Felix salmon 85 Gr pouch', 'Comida húmeda para gatos con rico sabor a Salmón.', 'Gatos', 'Felix', 'Cualquiera', 'Cualquiera', 3200, 2200, 99, '2026-12-31', 'img/31.jpg', 11, 1),
(32, 'Oh mai gat gaticos 1.5 Kg', 'Concentrado que favorece la salud intestinal de tu...', 'Gatos', 'Oh mai gat', 'Pequeños', 'Gatitos', 28500, 22000, 99, '2026-12-31', 'img/32.jpg', 11, 1),
(33, 'Donkat gatitos 500 Gr', 'Alimento completo seco para gatos cachorros de tod...', 'Gatos', 'Don Kat', 'Pequeños', 'Gatitos', 4800, 2300, 99, '2026-12-31', 'img/33.jpg', 11, 1),
(34, 'Donkat adultos 500 Gr', 'Alimento completo seco para gatos adultos de todas...', 'Gatos', 'Don Kat', 'Grandes', 'Adultos', 9000, 4800, 99, '2026-12-31', 'img/34.jpg', 11, 1),
(35, 'Donkat gatitos 1 Kg', 'Alimento seco para gatos cachorros de todas las ra...', 'Gatos', 'Don Kat', 'Pequeños', 'Gatitos', 4500, 2200, 99, '2026-12-31', 'img/35.jpg', 11, 1),
(36, 'Donkat adultos 1 Kg', 'Alimento seco para gatos adultos de todas las raza...', 'Gatos', 'Don Kat', 'Grandes', 'Adultos', 8500, 3800, 99, '2026-12-31', 'img/36.jpg', 11, 1),
(37, 'Gatsy adultos carne por 500 Gr', 'Concentrado para gatos completo y balanceado formu...', 'Gatos', 'Gatsy', 'Grandes', 'Adultos', 54000, 58000, 99, '2026-12-31', 'img/37.jpg', 11, 1),
(38, 'Fancy feast lata', 'Alimento para gatos altamente recomendado por expe...', 'Gatos', 'Fancy Feast', 'Cualquiera', 'Cualquiera', 4800, 4500, 99, '2026-12-31', 'img/38.jpg', 2, 1),
(39, 'Mirringo 1 Kg', 'Alimento Seco Para Gato Adultos.', 'Gatos', 'Mirringo', 'Grandes', 'Adultos', 8500, 4200, 99, '2026-12-31', 'img/39.jpg', 11, 1),
(40, 'Chunky gatitos pollo por 1.5 Kg', 'Concentrado para gatos, cuya fórmula está hecha co...', 'Gatos', 'Chunky', 'Pequeños', 'Gatitos', 23200, 20000, 99, '2026-12-31', 'img/40.jpg', 8, 1),
(41, 'Agility god Gatos de todas las edades 1.5 Kg', 'Concentrado ideal para suministrar en todas las et...', 'Gatos', 'Agulity God', 'Grandes', 'Adultos', 14900, 12000, 99, '2026-12-31', 'img/41.jpg', 8, 1),
(42, 'TOW Rocky Mountain por 500 Gr', 'Concentrado para gatos libre de granos que proporc...', 'Gatos', 'Taste of the wild', 'Grandes', 'Adultos', 22000, 19000, 99, '2026-12-31', 'img/42.jpg', 11, 1),
(43, 'Country gato por 500 Gr', 'Alimento con una fuente de proteína de pollo espec...', 'Gatos', 'Country Value', 'Grandes', 'Adultos', 8500, 4300, 99, '2026-12-31', 'img/43.jpg', 11, 1),
(44, 'Nutra Nuggets 1 Kg gato mantenimiento', 'Concentrado para gatos que contiene especialmente ...', 'Gatos', 'Nutra Nuggets', 'Grandes', 'Adultos', 20000, 17500, 99, '2026-12-31', 'img/44.jpg', 9, 1),
(45, 'Healthy love Gatos cachorros 100 Gr', 'Alimento completo de óptimo balance nutricional.', 'Gatos', 'Healthy', 'Pequeños', 'Gatitos', 3700, 2500, 99, '2026-12-31', 'img/45.jpg', 3, 1),
(46, 'Max profesional line gatos por 1 Kg', 'Concentrado Premium Especial cuya fórmula proporci...', 'Gatos', 'Max Cat', 'Grandes', 'Adultos', 19700, 35000, 99, '2026-12-31', 'img/46.png', 1, 1),
(47, 'Max profesional line gatitos por 1 Kg', 'Alimento enriquecido con vitaminas del complejo A,...', 'Gatos', 'Max Cat', 'Pequeños', 'Gatitos', 17000, 15000, 99, '2026-12-31', 'img/47.jpg', 1, 1),
(48, 'Birbo gatos por 1 Kg', 'Proporcionar una alimentación completa y balancead...', 'Gatos', 'Birbo', 'Grandes', 'Adultos', 14200, 12000, 99, '2026-12-31', 'img/48.jpg', 7, 1),
(49, 'Birbo gatitos por 1 Kg', 'Proporcionar una alimentación completa y balancead...', 'Gatos', 'Birbo', 'Pequeños', 'Gatitos', 16600, 14000, 99, '2026-12-31', 'img/49.jpg', 7, 1),
(50, 'Alpiste por 500gr', 'Semillas de alimentación para aves.', 'Aves', 'Alpiste', 'Cualquiera', 'Cualquiera', 3500, 2000, 99, '2026-12-31', 'img/50.jpg', 7, 1),
(51, 'Sudes Pet mixtura alimento aves 500 Gr', 'Mixtura Alimento para Aves Sudes-Pet.', 'Aves', 'Sudes Pet', 'Cualquiera', 'Cualquiera', 2900, 1950, 99, '2026-12-31', 'img/51.jpg', 7, 1),
(52, 'Mijo Rojo por 500 Gr', 'Semillas para aves que son semillas imprescindible...', 'Aves', 'Mijo Rojo', 'Cualquiera', 'Cualquiera', 3800, 2900, 99, '2026-12-31', 'img/52.jpg', 7, 1),
(53, 'Cacahuates por 250 Gr', 'Cacahuates de fuente natural de proteínas de alta ...', 'Roedores', 'Yucarrico', 'Grandes', 'Adultos', 3900, 2800, 99, '2026-12-31', 'img/53.jpg', 7, 1),
(54, 'Semillas de girasol por 500 Gr', 'Alimento natural con grandes propiedades nutricion...', 'Roedores', 'Frutos & Semillas', 'Cualquiera', 'Cualquiera', 4700, 4500, 99, '2026-12-31', 'img/54.jpg', 7, 1),
(55, 'Alimento para Hámster por 500 Gr', 'Alimento completo para hamsters con banana y grano...', 'Roedores', 'Tropifit', 'Cualquiera', 'Cualquiera', 3000, 2500, 99, '2026-12-31', 'img/55.jpg', 7, 1),
(56, 'Br for small pets cookies por 100 Gr', 'Suplemento alimenticio para suministrar como premi...', 'Roedores', 'Br For Small Pets', 'Pequeños', 'Crías', 3500, 2500, 99, '2026-12-31', 'img/56.jpg', 7, 1),
(57, 'Br rabbit alimento 1 Kg', 'Alimento completo para conejos y animales pequeños...', 'Roedores', 'Br Rabbit', 'Grandes', 'Adultos', 4500, 2500, 99, '2026-12-31', 'img/57.jpg', 7, 1),
(58, 'Nutripez por 20 Gr', 'Alimento completo para peces ornamentales.', 'Peces', 'Nutripez', 'Cualquiera', 'Cualquiera', 3000, 2800, 99, '2026-12-31', 'img/58.jpg', 7, 1),
(59, 'Incros por 14.2 Gr', 'Alimento de alta calidad para la alimentación de p...', 'Peces', 'Incros', 'Cualquiera', 'Cualquiera', 3500, 2500, 99, '2026-12-31', 'img/59.jpg', 7, 1),
(60, 'Digestar fibra', 'Laxante extremadamente útil para la prevención y e...', 'Perros y gatos', 'Digestar', 'Cualquiera', 'Cualquiera', 3000, 1500, 96, '2026-12-31', 'img/60.jpg', 5, 2),
(61, 'Medicamento de suspension lactobonavet', 'Suplemento alimenticio para cachorros.', 'Perros y gatos', 'Lactobonavet', 'Pequños', 'Cachorros y/o gatitos', 40000, 35000, 99, '2026-12-31', 'img/61.jpg', 11, 2),
(62, 'Medicamento de suspension rondel adulto 10 ml', 'Antihelmíntico ayuda a eliminar todos estados larv...', 'Perros y gatos', 'Rondel', 'Grandes', 'Adultos', 22000, 18000, 99, '2026-12-31', 'img/62.jpg', 11, 2),
(63, 'Medicamento de suspension rondel puppy 5 ml', 'Antihelmíntico ayuda a eliminar los estados larvar...', 'Perros y gatos', 'Rondel', 'Grandes', 'Adultos', 18000, 14000, 99, '2026-12-31', 'img/63.jpg', 11, 2),
(64, 'Antiparasitorio interno one desparasintante', 'Antiparasitario oral para perros para el control y...', 'Perros', 'One', 'Cualquiera', 'Cualquiera', 12000, 7800, 99, '2026-12-31', 'img/64.jpg', 11, 2),
(65, 'Medicamento de suspension canex 2 ml', 'Antiparasitario interno antihelmíntico en forma de...', 'Perros y gatos', 'Cannex', 'Cualquiera', 'Cualquiera', 13000, 9000, 99, '2026-12-31', 'img/65.jpg', 11, 2),
(66, 'Medicamento de suspension Vermiplex 5 ml', 'Antiparasitario interno antihelmíntico en forma de...', 'Perros y gatos', 'Vermiplex', 'Cualquiera', 'Cualquiera', 17000, 12000, 99, '2026-12-31', 'img/66.jpg', 11, 2),
(67, 'Medicamento de suspension dermisin crema 20 Gr', 'Antifúngico/Antiinflamatorio utilizado para tratar...', 'Perros y gatos', 'Dermicin', 'Cualquiera', 'Cualquiera', 17000, 5000, 99, '2026-12-31', 'img/67.jpg', 11, 2),
(68, 'Medicamento de suspension diarrisin', 'Antiácido y antiinflamatorio ayuda a proteger la m...', 'Perros y gatos', 'Diarrisin', 'Cualquiera', 'Cualquiera', 16000, 9000, 99, '2026-12-31', 'img/68.jpg', 11, 2),
(69, 'Tranquilan tableta', 'Es un tranquilizante para animales usado para perr...', 'Perros', 'Tranquilán', 'Cualquiera', 'Cualquiera', 5000, 3500, 99, '2026-12-31', 'img/69.jpg', 11, 2),
(70, 'Articflex', 'Es un compuesto naturalmente presente en el organi...', 'Perros y gatos', 'Art Flex', 'Cualquiera', 'Cualquiera', 36000, 20000, 99, '2026-12-31', 'img/70.jpg', 11, 2),
(71, 'Mieltertos', 'Es un fármaco muy útil para tratar las molestias o...', 'Perros', 'Mieltertos', 'Cualquiera', 'Cualquiera', 26500, 20000, 99, '2026-12-31', 'img/71.jpg', 11, 2),
(72, 'Nutre min lacduo 300 Gr', 'Es un suplemento alimenticio en polvo para reconst...', 'Perros y gatos', 'Lac Duo', 'Cualquiera', 'Cualquiera', 60000, 42000, 99, '2026-12-31', 'img/72.jpg', 11, 2),
(73, 'Nutre min pet senior 300 Gr', 'Suplemento a base de vitaminas, minerales y levadu...', 'Perros', 'Nutre Min', 'Cualquiera', 'Adultos', 50000, 4000, 99, '2026-12-31', 'img/73.jpg', 11, 2),
(74, 'Antiparasitos externos perro LP.A 9 a 25kg', 'Antiparasitario interno y externo para Perros de 1...', 'Perros', 'Advocate', 'Cualquiera', 'Cualquiera', 20000, 14000, 99, '2026-12-31', 'img/74.jpg', 11, 2),
(75, 'Maxipulguin por 10 ml', 'Antiséptico de uso veterinario a base de Clorhexid...', 'Perros', 'Maxipulguin', 'Cualquiera', 'Cualquiera', 8000, 4500, 99, '2026-12-31', 'img/75.jpg', 11, 2),
(76, 'Antiparasitario de perros simpa rica trio 5 a 10 K...', 'Acción inmediata contra pulgas y garrapatas.', 'Perros', 'Simparica Trio', 'Cualquiera', 'Cualquiera', 45500, 38000, 99, '2026-12-31', 'img/76.jpg', 11, 2),
(77, 'Antiparasitario de perros simpa rica trio 2.5 a 5 ...', 'Antiparasitario usado via oral 1 al mes ayuda cont...', 'Perros', 'Simparica Trio', 'Cualquiera', 'Cualquiera', 38000, 23000, 99, '2026-12-31', 'img/77.jpg', 11, 2),
(78, 'Antiparasitario de perros simpa rica trio 20 a 40 ...', 'Acción inmediata contra pulgas y garrapatas.', 'Perros', 'Simparica Trio', 'Cualquiera', 'Cualquiera', 60000, 45000, 99, '2026-12-31', 'img/78.jpg', 11, 2),
(79, 'Antiparasitario externo simpa rica 20 a 40 Kg', 'Antiparasitario para el tratamiento de infestacion...', 'Perros', 'Simparica', 'Cualquiera', 'Cualquiera', 46000, 45000, 99, '2026-12-31', 'img/79.jpg', 1, 2),
(80, 'Antiparasitario externo simpa rica 10 a 20 Kg', 'Antiparasitario para el tratamiento de infestacion...', 'Perros', 'Simparica', 'Cualquiera', 'Cualquiera', 36000, 34000, 99, '2026-12-31', 'img/80.jpg', 1, 2),
(81, 'Antiparasitario externo simpa rica 2.5 – 5 Kg', 'Antiparasitario para el tratamiento y control de i...', 'Perros', 'Simparica', 'Cualquiera', 'Cualquiera', 32000, 28000, 99, '2026-12-31', 'img/81.jpg', 1, 2),
(82, 'Antiparasitarios externos de perros Nexgard 2 a 4 ...', 'Antipulgas que protegerá a tu perro de contraer pa...', 'Perros', 'Nex Gard', 'Cualquiera', 'Cualquiera', 37000, 35000, 99, '2026-12-31', 'img/82.png', 1, 2),
(83, 'Antiparasitario de gatos Credelio gatos 0.5 a 2 Kg', 'Tratamiento eficaz contra garrapatas y pulgas cont...', 'Gatos', 'Credelio', 'Cualquiera', 'Cualquiera', 28000, 23000, 99, '2026-12-31', 'img/83.jpg', 1, 2),
(84, 'Antiparasitario de gatos Credelio gatos 2 a 8 Kg', 'Tratamiento eficaz contra garrapatas y pulgas cont...', 'Gatos', 'Credelio', 'Cualquiera', 'Cualquiera', 32000, 18000, 99, '2026-12-31', 'img/84.jpg', 1, 2),
(85, 'Antiparasitario externo e interno Revolution Plus ...', 'Antiparasitario para prevenir infestaciones con pu...', 'Gatos', 'Revolution', 'Cualquiera', 'Cualquiera', 52000, 28000, 99, '2026-12-31', 'img/85.jpg', 1, 2),
(86, 'Antiparasitario externo e interno Revolution Plus ...', 'Antipulgas para acabar con los parásitos.', 'Gatos', 'Revolution', 'Cualquiera', 'Cualquiera', 40000, 25000, 99, '2026-12-31', 'img/86.jpg', 1, 2),
(87, 'BEAUTY PETS TAPETES HIGIÉNICOS POR UNIDAD', 'Antialérgico a prueba de derrames, útiles para cac...', 'Perros', 'Beauty Pets', 'Cualquiera', 'Cualquiera', 25000, 23000, 99, '2026-12-31', 'img/87.jpg', 4, 3),
(88, 'Hushpet cambiadores 12 L', 'Efectiva y simple para hembras en calor, perros co...', 'Perros', 'Hushpet', 'Cualquiera', 'Cualquiera', 18000, 14000, 99, '2026-12-31', 'img/88.jpg', 9, 3),
(89, 'Peludos shampoo anti pulgas', 'Shampoo para perros, ayuda a protegerlos de parási...', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 3000, 2000, 99, NULL, 'img/89.jpg', 4, 3),
(90, 'Shampoo sobre dog cat sarna', 'Shampoo exclusivo para combatir sarna sabañones, h...', 'Perros', 'Sarna', 'Cualquiera', 'Cualquiera', 3000, 1800, 99, NULL, 'img/90.jpg', 4, 3),
(91, 'Hushpet cambiadores 12 M', 'Pañales desechables Hushpet para hembras en calor,...', 'Perros', 'Asuntol', 'Cualquiera', 'Cualquiera', 14500, 8900, 99, NULL, 'img/91.jpg', 4, 3),
(92, 'Jabon asuntol', 'Usado para el tratamiento de la sarna.', 'Perros', 'Splend', 'Cualquiera', 'Cualquiera', 7000, 5000, 99, NULL, 'img/92.jpg', 4, 1),
(93, 'Jabon splend', 'Jabón insecticida para perros y gatos.', 'Perros', 'Avenae', 'Cualquiera', 'Cualquiera', 9500, 7400, 99, NULL, 'img/93.jpg', 7, 3),
(94, 'Avenae clean 120 ml', 'Champoo de avena que facilita el manejo, forma y p...', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 2000, 1800, 99, NULL, 'img/94.jpg', 11, 3),
(95, 'Enpapadores humedos 10 unidades', 'Elaborados pensando en el aseo corporal entre baño...', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 25000, 22000, 99, NULL, 'img/95.jpg', 11, 3),
(96, 'Petys empapadores humedos 50 unidades', 'Toallitas hipoalergénicas que no afectarán la piel...', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 12000, 9500, 96, NULL, 'img/96.jpg', 7, 3),
(97, 'Petys empapadores humedos 80 unidades', 'Toallitas hipoalergénicas que no afectarán la piel...', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 15000, 12000, 99, NULL, 'img/97.jpg', 7, 3),
(98, 'Petys clorhexidina 40 unidades', 'Limpian, neutralizan el mal olor y ayudan al contr...', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 9000, 7500, 99, NULL, 'img/98.jpg', 11, 3),
(99, 'Petys empapadores humedos lavando 50 unidades', 'Paños húmedos para mascotas.', 'Perros y gatos', 'Petys', 'Cualquiera', 'Cualquiera', 11000, 10000, 99, NULL, 'img/99.jpg', 11, 3),
(100, 'Monami pet shampoo con acondicionar', 'Shapoo de higiene con acondicionar.', 'Perros y gatos', 'Monami', 'Cualquiera', 'Cualquiera', 15000, 12000, 99, NULL, 'img/100.jpg', 11, 3),
(101, 'Monami pet Repelente', 'con ingredientes naturales, como el acei...', 'Perros', 'Monami', 'Cualquiera', 'Cualquiera', 24000, 22000, 99, NULL, 'img/101.jpg', 11, 3),
(102, 'Jabon can amor anti pulgas', 'Es un jabón ideal para el tratamiento y control de...', 'Perros', 'Can Amor', 'Cualquiera', 'Cualquiera', 11000, 9500, 99, NULL, 'img/102.jpg', 11, 3),
(103, 'Shampoo arbol de te can amor', 'Sirve para proteger la piel y el pelo.', 'Perros', 'Can Amor', 'Cualquiera', 'Cualquiera', 4000, 2500, 99, NULL, 'img/103.jpg', 11, 3),
(104, 'Arena para gatos arena maxi cat 10 Kg', 'Arena que absorbe y neutraliza los olores de la or...', 'Gatos', 'Maxi Cat', 'Cualquiera', 'Cualquiera', 54000, 34000, 99, NULL, 'img/104.jpg', 7, 3),
(105, 'Arena para gatos arena maxi cat 5 Kg', 'Arena que absorbe y neutraliza los olores de la or...', 'Gatos', 'Maxi Cat', 'Cualquiera', 'Cualquiera', 22000, 18500, 99, NULL, 'img/105.jpg', 7, 3),
(106, 'Arena sanitaria mirringo 5 Kg', 'Producto diseñado para la comodidad de cualquier g...', 'Gatos', 'Mirringo', 'Cualquiera', 'Cualquiera', 29000, 25000, 99, NULL, 'img/106.jpg', 5, 3),
(107, 'Cobijas o mantas para las mascotas', 'Cobijas o mantas para las mascotas hechas especial...', 'Cualquiera', 'Ninguna', 'Cualquiera', 'Cualquiera', 15500, 12000, 99, NULL, 'img/107.jpg', 4, 4),
(108, 'Limpiador de patas', 'Ayuda a eliminar la suciedad y el barro de la pata...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 24000, 21000, 99, NULL, 'img/108.jpg', 11, 4),
(109, 'Camas / Iglus/Cubos chicas', 'Camas para gatos o perros pequeños.', 'Perros y gatos', 'Ninguna', 'Pequeños', 'Cualquiera', 25000, 22000, 97, NULL, 'img/109.jpg', 4, 4),
(110, 'Camas / Iglus/Cubos medias', 'Camas para gatos o perros medianos.', 'Perros y gatos', 'Ninguna', 'Medianos', 'Cualquiera', 55000, 45000, 99, NULL, 'img/110.jpg', 4, 4),
(111, 'Camas / Iglus/Cubos grandes', 'Camas para gatos o perros grandes.', 'Perros', 'Ninguna', 'Grandes', 'Cualquiera', 75000, 55000, 99, NULL, 'img/111.jpg', 11, 4),
(112, 'KONG BALL CORESTRENGTH', 'Juguete Dental y Masticable de Larga Duración.', 'Perros', 'kong', 'Cualquiera', 'Cualquiera', 30000, 25000, 99, NULL, 'img/112.jpg', 2, 4),
(113, 'CAJA BOLSAS ECOLOGICAS 136', 'Bolsas para recoger el excremento del animal.', 'Perros', 'Pobby', 'Cualquiera', 'Cualquiera', 13500, 9800, 99, NULL, 'img/113.jpg', 4, 4),
(114, 'COLLAR CON UN LAZO', 'Collar con moño para colocarle al perro.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 12000, 8700, 99, NULL, 'img/114.jpg', 4, 4),
(115, 'LAZO SOMBRERO NAVIDEÑO UNIDAD', 'Moño con un sombrero navideño para colocarle al pe...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 5000, 4500, 99, NULL, 'img/115.jpg', 4, 4),
(116, 'PELOTA ÁTOMO GRANDE', 'Pelota con forma de átomo para que juegue la masco...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 12000, 9000, 99, NULL, 'img/116.jpg', 4, 4),
(117, 'PELOTA DURA PLAY', 'Pelota que ayuda a su mascota a aliviar su aburrim...', 'Perros', 'Dura Play', 'Cualquiera', 'Cualquiera', 15000, 9000, 99, NULL, 'img/117.jpg', 2, 4),
(118, 'KONG SQUIGGLES', 'Juguete elástico, flexible y sonoro que ofrecen di...', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 25000, 22000, 99, NULL, 'img/118.jpg', 2, 4),
(119, 'BUNZAR CONO GRANDE', 'Especie de cono para que no logren lamerse las her...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 40000, 37000, 99, NULL, 'img/119.jpg', 2, 4),
(120, 'KONG EXTREME', 'Juguete diseñado especialmente para perros de mord...', 'Perros', 'Kong', 'Grandes', 'Adultos', 40000, 38000, 99, NULL, 'img/120.jpg', 2, 4),
(121, 'KONG FLYER', 'Disco de goma blanda y flexible para los perros.', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 55000, 45000, 99, NULL, 'img/121.jpg', 2, 4),
(122, 'KONG MEDIUM ROJA', 'Pelota Kong está hecha de caucho natural de color ...', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 43500, 38800, 99, NULL, 'img/122.jpg', 4, 4),
(123, 'KONG BALL MEDIO NEGRA', 'Juguete elaborado con caucho negro natural, garant...', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 54000, 44000, 99, NULL, 'img/123.jpg', 2, 4),
(124, 'KONG BALL SMALL NEGRA', 'Pelotica para perros de gran resistencia.', 'Perros', 'Kong', 'Grandes', 'Adultos', 42500, 39500, 99, NULL, 'img/124.jpg', 2, 4),
(125, 'KONG TIRES LLANTA PORTA COMIDA', 'Juguete con forma de neumático con resistente cauc...', 'Perros', 'Kong', 'Grandes', 'Adultos', 45000, 34000, 99, NULL, 'img/125.jpg', 2, 4),
(126, 'KONG SIGNATURE', 'Pelota resistente para una diversión de recoger du...', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 35000, 33000, 99, NULL, 'img/126.jpg', 2, 4),
(127, 'KONG BALL CORESTRENGTH HUESO', 'Juguete masticable para perros para masticadores a...', 'Perros', 'Kong', 'Grandes', 'Adultos', 32000, 24000, 99, NULL, 'img/127.jpg', 11, 4),
(128, 'KONG TWISTZ', 'Pelota con fácil agarre, tiene rebote impredecible...', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 24000, 22000, 99, NULL, 'img/128.jpg', 2, 4),
(129, 'SQUEEZZ PELOTA CRUSH', 'Juguete ideal para juegos de lanzar y recoger.', 'Perros', 'Kong', 'Cualquiera', 'Cualquiera', 17900, 14000, 99, NULL, 'img/129.jpg', 11, 4),
(130, 'PELOTA MONILA', 'Pelota verde con gran rebote.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 8500, 4500, 99, NULL, 'img/130.jpg', 11, 4),
(131, 'FAJA POST CX TALLA S', 'Faja de talla S para la intervención quirúrgica en...', 'Perros', 'Ninguna', 'Pequeños', 'Cualquiera', 25000, 22000, 99, NULL, 'img/131.jpg', 11, 4),
(132, 'FAJA POST CX TALLA M', 'Faja de talla M para la intervención quirúrgica en...', 'Perros', 'Ninguna', 'Medianos', 'Cualquiera', 35000, 25000, 99, NULL, 'img/132.jpg', 11, 4),
(133, 'FAJA POST CX TALLA L', 'Faja de talla L para la intervención quirúrgica en...', 'Perros', 'Ninguna', 'Grandes', 'Cualquiera', 40000, 35000, 99, NULL, 'img/133.jpg', 11, 4),
(134, 'PLATO PORTA COMIDA CHICO', 'Plato para colocar la comida del animal.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 7000, 4500, 99, NULL, 'img/134.jpg', 4, 4),
(135, 'PELUCHE HUESO', 'Peluche en forma de hueso con refuerzo de entretel...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 7500, 5500, 99, NULL, 'img/135.jpg', 11, 4),
(136, 'FORRO PARA CARRO SILLA DE ATRAS', 'Forro para las sillas del carro de atras para que ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 29900, 25900, 99, NULL, 'img/136.jpg', 4, 4),
(137, 'DONA RIGIDA', 'Producto para perros hecho de algodón liviano para...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 5000, 4000, 99, NULL, 'img/137.jpg', 11, 4),
(138, 'DISFRAZ', 'Disfraz o traje para su mascota que retiene la suc...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 42000, 24999, 99, NULL, 'img/138.jpg', 11, 4),
(139, 'PORTA BOLSA GOTCHA', 'Sirve para cargar las bolsas de tu mascota.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 70000, 55000, 99, NULL, 'img/139.jpg', 11, 4),
(140, 'PINZAS PARA LAS PATAS PERROS', 'Herramienta ideal para cuidar el estado de las uña...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 10000, 78000, 99, NULL, 'img/140.jpg', 4, 4),
(141, 'HUESO MACIZO KMT', 'Hueso para que los perros se distraigan.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 4500, 2500, 99, NULL, 'img/141.jpg', 4, 4),
(142, 'PLACA', 'Fuente de información, sirve para colocar informac...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 2800, 1800, 99, NULL, 'img/142.jpg', 4, 4),
(143, 'CUCOS TALLA 4', 'Cucos que miden desde la base del cuello hasta la ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 26000, 18000, 99, NULL, 'img/143.jpg', 11, 4),
(144, 'CUCOS TALLA 6', 'Cucos que miden desde la base del cuello hasta la ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 27000, 24000, 99, NULL, 'img/144.jpg', 11, 4),
(145, 'CUCOS TALLA 8', 'Cucos que miden desde la base del cuello hasta la ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 28000, 14500, 99, NULL, 'img/145.jpg', 11, 4),
(146, 'CUCOS TALLA 10', 'Cucos que miden desde la base del cuello hasta la ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 30000, 22000, 99, NULL, 'img/146.jpg', 11, 4),
(147, 'CORREAS', 'Herramienta que permite sacar a la mascota de pase...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 12000, 7500, 99, NULL, 'img/147.jpg', 11, 4),
(148, 'COMEDORES METALICOS MEDIANOS', 'Comedor metálico mediano para colocarle comida a s...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 14400, 9800, 99, NULL, 'img/148.jpg', 11, 4),
(149, 'COMEDORES METALICOS CHICOS', 'Comedor metálico pequeño para colocarle comida a s...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 9000, 7500, 99, NULL, 'img/149.jpg', 11, 4),
(150, 'COMEDORES METALICOS GRANDES', 'Comedor metálico grande para colocarle comida a su...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 20000, 18000, 99, NULL, 'img/150.jpg', 11, 4),
(151, 'COLLAR ISABELINO XL', 'Collar xl para evitar que acceda a zonas de su cue...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 20000, 17500, 99, NULL, 'img/151.jpg', 11, 4),
(152, 'COLLAR ISABELINO XXL', 'Collar xxl para evitar que acceda a zonas de su cu...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 28000, 23000, 99, NULL, 'img/152.jpg', 11, 4),
(153, 'COLLAR ISABELINO XXXL', 'Collar xxxl para evitar que acceda a zonas de su c...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 30000, 29000, 99, NULL, 'img/153.jpg', 11, 4),
(154, 'MALETA/CARGADORES', 'Maleta o cargador para transportar a su mascota o ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 45000, 34000, 99, NULL, 'img/154.jpg', 11, 4),
(155, 'CAMAS', 'Camas comodas para su mascota o perro.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 58000, 44000, 99, NULL, 'img/155.jpg', 11, 4),
(156, 'BEBEDORES', 'Sirve como fuente de agua para proporcionar agua f...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 32000, 28000, 99, NULL, 'img/156.jpg', 11, 4),
(157, 'BUZOS S', 'Buzos para perro de talla S.', 'Perros', 'Ninguna', 'Pequeños', 'Cualquiera', 18000, 12000, 99, NULL, 'img/157.jpg', 11, 4),
(158, 'BUZOS M', 'Buzos para perro de talla M.', 'Perros', 'Ninguna', 'Medianos', 'Cualquiera', 20000, 19000, 99, NULL, 'img/158.jpg', 11, 4),
(159, 'BUZOS L', 'Buzos para perro de talla L.', 'Perros', 'Ninguna', 'Grandes', 'Cualquiera', 23500, 18500, 99, NULL, 'img/159.jpg', 11, 4),
(160, 'Cepillo doble cara pelo largo', 'Ayuda a eliminar el cabello de la capa superior e ...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 18500, 12000, 99, NULL, 'img/160.jpg', 9, 4),
(161, 'Peluche hueso', 'Peluche en forma de hueso con refuerzo de entretel...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 7500, 5500, 99, NULL, 'img/161.jpg', 4, 4),
(162, 'Carda china peto', 'Cepillo con finas púas para cepillar el pelo gener...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 16500, 12500, 99, NULL, 'img/162.jpg', 4, 4),
(163, 'Bozal grande', 'Para perros grandes evitar que un perro coma ya se...', 'Perros', 'Ninguna', 'Grandes', 'Cualquiera', 20000, 17500, 99, NULL, 'img/163.jpg', 4, 4),
(164, 'Bozal chico', 'Para perros pequeños evitar que un perro coma ya s...', 'Perros', 'Ninguna', 'Pequeños', 'Cualquiera', 14000, 9000, 99, NULL, 'img/164.jpg', 4, 4),
(165, 'Cadenas acero grande', 'Cadenas de acero grande para perros.', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 55000, 38000, 99, NULL, 'img/165.jpg', 11, 4),
(166, 'Bandana talla S', 'Pañoletas para perro de talla S.', 'Perros', 'Ninguna', 'Pequeños', 'Cualquiera', 6500, 3800, 99, NULL, 'img/166.jpg', 11, 4),
(167, 'Bandana talla L', 'Pañoletas para perro de talla L.', 'Perros', 'Ninguna', 'Grandes', 'Cualquiera', 7000, 4500, 99, NULL, 'img/167.jpg', 11, 4),
(168, 'Tapetes absorbentes', 'Tapetes elaborados a base de polipropileno, un mat...', 'Perros', 'Ninguna', 'Cualquiera', 'Cualquiera', 10000, 8500, 99, NULL, 'img/168.jpg', 4, 4),
(169, 'Juguete raton con resorte grande', 'Juguete ratón con resorte grande para gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 25000, 22000, 99, NULL, 'img/169.jpg', 4, 4),
(170, 'Palas cara de gato', 'Pala en forma de gato para colocarlo en la arena y...', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 4500, 2800, 99, NULL, 'img/170.jpg', 4, 4),
(171, 'Rascador de carton de pared', 'Repone las garras de los gatos y mantener las garr...', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 11000, 9500, 99, NULL, 'img/171.jpg', 4, 4),
(172, 'Pala metalica petmate', 'Sirve para levantar grandes y pesados terrones del...', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 60000, 45000, 99, NULL, 'img/172.jpg', 4, 4),
(173, 'Ratones mini concatnip', 'Ratones mini para que jueguen y se distraigan los ...', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 3000, 2800, 99, NULL, 'img/173.jpg', 2, 4),
(174, 'Varita premium Kong', 'Varita para que los gatos tengan un juego interact...', 'Gatos', 'Kong', 'Cualquiera', 'Cualquiera', 34000, 28000, 99, NULL, 'img/174.jpg', 2, 4),
(175, 'Filtro para arenero de 10 – 15 cm', 'Filtros que proporciona un ambiente sin olores y m...', 'Gatos', 'Filter', 'Cualquiera', 'Cualquiera', 18000, 12000, 99, NULL, 'img/175.jpg', 9, 4),
(176, 'Juguete raton con resorte', 'Juguete de ratón con resorte para los gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 7000, 5500, 99, NULL, 'img/176.jpg', 4, 4),
(177, 'Maleta mershop', 'Maleta para cargar a los gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 130000, 125000, 99, NULL, 'img/177.jpg', 11, 4),
(178, 'Cepillo doble cara hello Mickey para gato', 'Cepillo de doble cara usado para los gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 11000, 9000, 99, NULL, 'img/178.jpg', 11, 4),
(179, 'PINZAS PARA LAS PATAS GATOS', 'Corta uñas para gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 8500, 7500, 99, NULL, 'img/179.jpg', 11, 4),
(180, 'Juguete de pelota', 'Juguete de pelota para los gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 25800, 22800, 99, NULL, 'img/180.jpg', 11, 4),
(181, 'Maletas gato', 'Maletas para cualquier gato.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 125000, 98000, 99, NULL, 'img/181.jpg', 11, 4),
(182, 'Raton vibrador', 'Sirve para que los gatos estimulen sus sentidos y ...', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 8000, 7500, 99, NULL, 'img/182.jpg', 11, 4),
(183, 'Raton y pelota', 'Ratón y pelota para que se distraigan los gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 7000, 3500, 99, NULL, 'img/183.jpg', 4, 4),
(184, 'Tapetes', 'Tapetes especiales para gatos.', 'Gatos', 'Ninguna', 'Cualquiera', 'Cualquiera', 14000, 8500, 99, NULL, 'img/184.jpg', 4, 4),
(185, 'Bebedero hamster abierto', 'Bebederos para los hámster.', 'Roedores', 'Ninguna', 'Cualquiera', 'Cualquiera', 3500, 2800, 99, NULL, 'img/185.jpg', 11, 4),
(186, 'Bola del hamster', 'Bolas para que los hámster entren y corren, sin pe...', 'Roedores', 'Ninguna', 'Cualquiera', 'Cualquiera', 25000, 18000, 99, NULL, 'img/186.jpg', 11, 4),
(187, 'Cargador hamster', 'Cargadores para llevar a al hámster y para que ten...', 'Roedores', 'Ninguna', 'Cualquiera', 'Cualquiera', 35000, 29500, 99, NULL, 'img/187.jpg', 4, 4),
(188, 'Nido de fique chico', 'Nido de fique para las aves.', 'Aves', 'Ninguna', 'Cualquiera', 'Cualquiera', 5000, 4500, 99, NULL, 'img/188.jpg', 11, 4),
(189, 'Nido para ave', 'Nido en plástico para aves.', 'Aves', 'Ninguna', 'Cualquiera', 'Cualquiera', 2600, 2200, 99, NULL, 'img/189.jpg', 11, 4),
(190, '1 OPCION: Consulta veterinaria', 'Consultas veterinarias rapidas pero hay que tener ...', 'Cualquiera', 'No aplica', 'Cualquiera', 'Cualquiera', 12000, 0, 2147483647, NULL, 'img/190.jpg', 12, 5),
(191, '2 OPCION: Consulta veterinaria', 'Consultas veterinarias medio tardías pero hay que ...', 'Cualquiera', 'No aplica', 'Cualquiera', 'Cualquiera', 18000, 0, 2147483647, NULL, 'img/191.jpg', 12, 5),
(192, '3 OPCION: Consulta veterinaria', 'Consultas veterinarias muy tardías pero hay que te...', 'Cualquiera', 'No aplica', 'Cualquiera', 'Cualquiera', 25000, 0, 2147483647, NULL, 'img/192.jpg', 12, 5),
(193, '1 VACUNA: Puppy o especial cachorros', 'Se aplica entre las 6 a 8 semanas y sirve para la ...', 'Perros', '-----', 'Pequeños', 'Cachorros', 198800, 178800, 99, '2026-12-31', 'img/193.jpg', 11, 6),
(194, '2 VACUNA: Polivalente canina', 'Se aplica entre las 8 a 10 semanas y sirve para la...', 'Perros', '-----', 'Pequeños', 'Cachorros', 133000, 95000, 99, '2026-12-31', 'img/194.jpg', 11, 6),
(195, '3 VACUNA: Polivalente canina 2', 'Se aplica entre las 12 a 14 semanas y sirve para l...', 'Perros', '-----', 'Medianos', 'Juventud', 138000, 118000, 99, '2026-12-31', 'img/195.jpg', 11, 6),
(196, '4 VACUNA: Traqueo bronquitis', 'Se aplica entre las 16 a 18 semanas y sirve para l...', 'Perros', '-----', 'Medianos', 'Juventud', 198000, 148000, 99, '2026-12-31', 'img/196.jpg', 11, 6),
(197, '5 VACUNA: Antirrabica', 'Se aplica entre las 20 a 24 semanas y sirve para l...', 'Perros', '-----', 'Grandes', 'Adultos', 795000, 588000, 99, '2026-12-31', 'img/197.jpg', 11, 6),
(198, '6 VACUNA: Antirrabica, Polivalente y bronquitis', 'Se aplica anualmente sirve contra la inmunidad a P...', 'Perros', '-----', 'Grandes', 'Adultos', 87000, 84000, 99, '2026-12-31', 'img/198.jpg', 11, 6),
(199, '1 VACUNA: Triple felina', 'Se aplica en la 6 semana y sirve para la inmunidad...', 'Gatos', '-----', 'Pequeños', 'Gatitos', 107364, 87364, 99, '2026-12-31', 'img/199.jpg', 11, 6),
(200, '2 VACUNA: Triple felina 2da dosis', 'Se aplica entre la semana 9 a 10 y sirve para la i...', 'Gatos', '-----', 'Pequeños', 'Gatitos', 107364, 85000, 99, '2026-12-31', 'img/200.jpg', 11, 6),
(201, '3 VACUNA: Triple felina 3ra dosis', 'Se aplica entre la semana 12 a 14 y sirve para la ...', 'Gatos', '-----', 'Medianos', 'Juventud', 107364, 97364, 99, '2026-12-31', 'img/201.jpg', 11, 6),
(202, '4 VACUNA: Rabia', 'Se aplica entre la semana 12 a 16 y sirve para la ...', 'Gatos', '-----', 'Medianos', 'Juventud', 71576, 58500, 99, '2026-12-31', 'img/202.jpg', 11, 6),
(203, '5 VACUNA: Triple felina 4ta dosis', 'Se aplica entre la semana 16 a 18 y sirve para la ...', 'Gatos', '-----', 'Grandes', 'Adultos', 107364, 97000, 99, '2026-12-31', 'img/203.jpg', 11, 6),
(204, '6 VACUNA: Triple felina y rabia', 'Se aplica anualmente sirve para la inmunidad a pan...', 'Gatos', '-----', 'Pequeños', 'Gatitos', 46000, 42000, 99, '2026-12-31', 'img/204.jpg', 11, 6),
(205, '7 VACUNA: Leucemia felina', 'Vacuna opcional sirve para la inmunidad a la leuce...', 'Gatos', '-----', 'Grandes', 'Adultos', 135200, 128000, 99, '2026-12-31', 'img/205.jpg', 11, 6),
(206, 'Desparasitacion interna para perros', 'Sirve contra lombrices y parásitos intestinales.', 'Perros', '-----', 'Cualquiera', 'Cualquiera', 55000, 52000, 99, '2026-12-31', 'img/206.jpg', 11, 7),
(207, 'Desparasitacion externa para perros', 'Sirve contra pulgas y garrapatas.', 'Perros', '-----', 'Cualquiera', 'Cualquiera', 102000, 98000, 99, '2026-12-31', 'img/207.jpg', 11, 7),
(208, 'Desparasitacion interna para gatos', 'Sirve contra lombrices y parásitos intestinales.', 'Gatos', '-----', 'Cualquiera', 'Cualquiera', 40000, 28800, 99, '2026-12-31', 'img/208.jpg', 11, 7),
(209, 'Desparasitacion externa para gatos', 'Sirve contra pulgas y garrapatas.', 'Gatos', '-----', 'Cualquiera', 'Cualquiera', 85000, 68000, 99, '2026-12-31', 'img/209.jpg', 11, 7),
(210, 'Perro chico cabello corto', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Pequeños', 'Cualquiera', 50000, 0, 2147483647, NULL, 'img/210.jpg', 12, 8),
(211, 'Perro mediano cabello corto', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Medianos', 'Cualquiera', 65000, 0, 2147483647, NULL, 'img/211.jpg', 12, 8),
(212, 'Perro grande cabello corto', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Grandes', 'Cualquiera', 75000, 0, 2147483647, NULL, 'img/212.jpg', 12, 8),
(213, 'Perro gigante cabello corto', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Grandes', 'Cualquiera', 110000, 0, 2147483647, NULL, 'img/213.jpg', 12, 8),
(214, 'Perro chico cabello grande', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Pequeños', 'Cualquiera', 60000, 0, 2147483647, NULL, 'img/214.jpg', 12, 8),
(215, 'Perro mediano cabello largo', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Medianos', 'Cualquiera', 70000, 0, 2147483647, NULL, 'img/215.jpg', 12, 8),
(216, 'Perro grande cabello largo', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Grandes', 'Cualquiera', 85000, 0, 2147483647, NULL, 'img/216.jpg', 12, 8),
(217, 'Perro gigante cabello largo', 'Este valor es para el servicio de estética para pe...', 'Perros', 'No aplica', 'Grandes', 'Cualquiera', 125000, 0, 2147483647, NULL, 'img/217.jpg', 12, 8),
(218, 'Gato chico cabello corto', 'Este valor es para el servicio de estética y aseo ...', 'Gatos', 'No aplica', 'Pequeños', 'Cualquiera', 50000, 0, 2147483647, NULL, 'img/218.jpg', 12, 8),
(219, 'Gato grande cabello corto', 'Este valor es para el servicio de estética y aseo ...', 'Gatos', 'No aplica', 'Grandes', 'Cualquiera', 70000, 0, 2147483647, NULL, 'img/219.jpg', 12, 8),
(220, 'Gato chico cabello largo', 'Este valor es para el servicio de estética y aseo ...', 'Gatos', 'No aplica', 'Pequeños', 'Cualquiera', 60000, 0, 2147483647, NULL, 'img/220.jpg', 12, 8),
(221, 'Gato grande cabello largo', 'Este valor es para el servicio de estética y aseo ...', 'Gatos', 'No aplica', 'Grandes', 'Cualquiera', 80000, 0, 2147483647, NULL, 'img/221.png', 12, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_cliente` int NOT NULL,
  `id_mascota` int NOT NULL,
  `id_estado_cita` int NOT NULL,
  `id_nom_servicio` int NOT NULL,
  `descripcion` text COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_ver` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ciudad` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `barrio` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `t_documento` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `n_documento` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `contrasena` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_rol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombres`, `apellidos`, `telefono`, `ciudad`, `barrio`, `direccion`, `t_documento`, `n_documento`, `correo`, `contrasena`, `id_rol`) VALUES
(2, 'Diego Alejandro', 'Sierra Hernández', '3166451562', 'Tunja', 'Tunja', 'Calle 20', 'TI', '1050603225', 'sierradiego972@gmail.com', '123456', 3),
(4, 'Samuel', 'Gonzalez', '3126512312', 'Tunja', 'Cooservicios', 'Calle 122', 'CC', '1231231233', 'samuel@gmail.com', '123456', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_proveedor`
--

CREATE TABLE `compra_proveedor` (
  `id_compra_proveedor` int NOT NULL,
  `fecha` date NOT NULL,
  `id_proveedor` int NOT NULL,
  `valor_total` int NOT NULL,
  `foto` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desparasitante`
--

CREATE TABLE `desparasitante` (
  `id_desparasitante` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `desparasitante`
--

INSERT INTO `desparasitante` (`id_desparasitante`, `nombre`) VALUES
(1, 'N/A'),
(2, 'Desparasitación interna para perros'),
(3, 'Desparasitación externa para perros'),
(4, 'Desparasitación interna para gatos'),
(5, 'Desparasitación externa para gatos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle_factura` int NOT NULL,
  `cantidad` int NOT NULL,
  `valor` int NOT NULL,
  `valor_total` int NOT NULL,
  `id_factura` int NOT NULL,
  `id_articulo` int NOT NULL,
  `id_tipo_articulo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle_factura`, `cantidad`, `valor`, `valor_total`, `id_factura`, `id_articulo`, `id_tipo_articulo`) VALUES
(1, 2, 37000, 74000, 4, 1, 1),
(2, 1, 37000, 37000, 5, 1, 1),
(3, 1, 37000, 37000, 6, 1, 1),
(4, 2, 25000, 50000, 7, 109, 4),
(5, 1, 37000, 37000, 8, 1, 1),
(6, 2, 71576, 143152, 8, 2, 1),
(8, 1, 37000, 37000, 10, 1, 1),
(9, 2, 37000, 74000, 10, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura_temp`
--

CREATE TABLE `detalle_factura_temp` (
  `id_detalle_factura_temp` int NOT NULL,
  `cantidad` int NOT NULL,
  `valor` int NOT NULL,
  `valor_total` int NOT NULL,
  `id_factura` int NOT NULL,
  `id_articulo` int NOT NULL,
  `id_tipo_articulo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `t_documento` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `n_documento` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ciudad` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `barrio` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `contrasena` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_rol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `t_documento`, `n_documento`, `ciudad`, `barrio`, `direccion`, `telefono`, `correo`, `contrasena`, `id_rol`) VALUES
(1, 'Jaime López', 'CE', 'N/A', 'Tunja', 'Suárez', 'N/A', 'N/A', 'jaime@gmail.com', '123456', 1),
(2, 'Sandra Liliana', 'CE', 'N/A', 'Tunja', 'Suárez', 'N/A', 'N/A', 'sandra@gmail.com', '123456', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cita`
--

CREATE TABLE `estado_cita` (
  `id_estado_cita` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `estado_cita`
--

INSERT INTO `estado_cita` (`id_estado_cita`, `nombre`) VALUES
(1, 'Por atender'),
(2, 'Atendido'),
(3, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_factura`
--

CREATE TABLE `estado_factura` (
  `id_estado_factura` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `estado_factura`
--

INSERT INTO `estado_factura` (`id_estado_factura`, `nombre`) VALUES
(1, 'Pagado'),
(2, 'Anulado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int NOT NULL,
  `fecha` date NOT NULL,
  `total_factura` int NOT NULL,
  `id_veterinaria` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_empleado` int NOT NULL,
  `id_estado_factura` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `fecha`, `total_factura`, `id_veterinaria`, `id_cliente`, `id_empleado`, `id_estado_factura`) VALUES
(4, '2026-03-12', 74000, 1, 2, 1, 2),
(5, '2026-03-12', 37000, 1, 2, 1, 1),
(6, '2026-03-12', 37000, 1, 2, 2, 1),
(7, '2026-03-12', 50000, 1, 2, 1, 2),
(8, '2026-05-02', 180152, 1, 2, 1, 1),
(10, '2026-05-03', 111000, 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clinico`
--

CREATE TABLE `historial_clinico` (
  `id_historial_clinico` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_mascota` int NOT NULL,
  `fecha_visita` date NOT NULL,
  `diagnostico` text COLLATE utf8mb3_spanish2_ci,
  `id_tratamiento` int DEFAULT NULL,
  `instrucciones` text COLLATE utf8mb3_spanish2_ci,
  `pulso` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cardio` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `peso` varchar(500) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_vacuna` int DEFAULT NULL,
  `fecha_vacuna` date DEFAULT NULL,
  `id_desparasitante` int DEFAULT NULL,
  `fecha_desparasitante` date DEFAULT NULL,
  `id_empleado` int NOT NULL,
  `id_nom_servicio` int NOT NULL,
  `fecha_proxima_cita` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `historial_clinico`
--

INSERT INTO `historial_clinico` (`id_historial_clinico`, `id_cliente`, `id_mascota`, `fecha_visita`, `diagnostico`, `id_tratamiento`, `instrucciones`, `pulso`, `cardio`, `peso`, `id_vacuna`, `fecha_vacuna`, `id_desparasitante`, `fecha_desparasitante`, `id_empleado`, `id_nom_servicio`, `fecha_proxima_cita`) VALUES
(18, 4, 2, '2026-03-25', '', 1, '', '32', '32', '', 1, NULL, 1, NULL, 1, 1, NULL),
(20, 2, 1, '2026-03-25', '', 1, '', '23', '23', '', 1, NULL, 1, NULL, 1, 1, NULL),
(21, 2, 1, '2026-03-30', '', 1, '', '213', '123', '', 7, '2026-03-30', 1, NULL, 1, 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `id_mascota` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `sexo` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_tipo_mascota` int NOT NULL,
  `id_raza` int NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `id_cliente` int NOT NULL,
  `fecha_registro` date NOT NULL,
  `observaciones` text COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`id_mascota`, `nombre`, `sexo`, `id_tipo_mascota`, `id_raza`, `fecha_nacimiento`, `id_cliente`, `fecha_registro`, `observaciones`) VALUES
(1, 'Zeus', 'Macho', 1, 6, '2026-03-24', 2, '2026-03-24', 'sadasd'),
(2, 'Margarita', 'Hembra', 2, 16, '2026-03-16', 4, '2026-03-24', 'Ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nom_servicio`
--

CREATE TABLE `nom_servicio` (
  `id_nom_servicio` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `nom_servicio`
--

INSERT INTO `nom_servicio` (`id_nom_servicio`, `nombre`) VALUES
(1, 'Consultas veterinaria'),
(2, 'Vacunación'),
(3, 'Desparasitación'),
(4, 'Estética y aseo canino/felino'),
(5, 'Otro motivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `nit` varchar(50) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `nit`, `telefono`) VALUES
(1, 'Gabrica', '12387234-4', '3627173612'),
(2, 'IconoPet', '3653424-5', '3127635545'),
(3, 'Reels', '31763127-5', '3217636721'),
(4, 'Distribuidora Angeles con Cola', '3261357-3', '3726176319'),
(5, 'Agromarket', '321312366-7', '3127312673'),
(6, 'Renacer Agropecuario', '213561239-3', '3172631788'),
(7, 'ANIMALITOS', '25145313-3', '3126516235'),
(8, 'ITALCOL', '651253699-4', '3712671273'),
(9, 'Jarapets', '521512372-4', '3218736717'),
(10, 'Valbagro', '23132342-5', '3217612638'),
(11, 'Una entidad', '-----', '-----'),
(12, 'Ninguna', 'Ninguna', 'ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE `raza` (
  `id_raza` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `id_tipo_mascota` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`id_raza`, `nombre`, `id_tipo_mascota`) VALUES
(1, 'Sin raza definida', 1),
(2, 'Sin raza definida', 2),
(3, 'Sin raza definida', 3),
(4, 'Sin raza definida', 4),
(5, 'Sin raza definida', 5),
(6, 'Bichón Frisé', 1),
(7, 'Bobtail', 1),
(8, 'Bulldog Inglés', 1),
(9, 'Dálmata', 1),
(10, 'Golden Retriever', 1),
(11, 'Gran Danés', 1),
(12, 'Labrador', 1),
(13, 'Pug', 1),
(14, 'Cavalier King Charles', 1),
(15, 'Boxér', 1),
(16, 'Maine Coon', 2),
(17, 'Persa', 2),
(18, 'Chartreux', 2),
(19, 'Bengalí', 2),
(20, 'Scottish Fold', 2),
(21, 'Tetras', 3),
(22, 'Pez ángel', 3),
(23, 'Betta', 3),
(24, 'Guppy', 3),
(25, 'Guramis', 3),
(26, 'Hámster', 5),
(27, 'Periquitos', 4),
(28, 'Loros', 4),
(29, 'Canarios', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'Administrador - Medico Veterinario'),
(2, 'Empleado - Trabajador'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_articulo`
--

CREATE TABLE `tipo_articulo` (
  `id_tipo_articulo` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_articulo`
--

INSERT INTO `tipo_articulo` (`id_tipo_articulo`, `nombre`) VALUES
(1, 'Alimentos'),
(2, 'Medicamentos'),
(3, 'Productos de aseo'),
(4, 'Accesorios'),
(5, 'Consultas medicas'),
(6, 'Vacunas'),
(7, 'Desparasitantes'),
(8, 'Estética y aseo canino/felino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mascota`
--

CREATE TABLE `tipo_mascota` (
  `id_tipo_mascota` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_mascota`
--

INSERT INTO `tipo_mascota` (`id_tipo_mascota`, `nombre`) VALUES
(1, 'Perros'),
(2, 'Gatos'),
(3, 'Peces'),
(4, 'Aves'),
(5, 'Roedores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `tratamiento` (
  `id_tratamiento` int NOT NULL,
  `id_mascota` int NOT NULL,
  `medicamentos` text COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` text COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tratamiento`
--

INSERT INTO `tratamiento` (`id_tratamiento`, `id_mascota`, `medicamentos`, `fecha`, `observaciones`) VALUES
(1, 1, 'N/A', '0000-00-00', 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacuna`
--

CREATE TABLE `vacuna` (
  `id_vacuna` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `vacuna`
--

INSERT INTO `vacuna` (`id_vacuna`, `nombre`) VALUES
(1, 'N/A'),
(2, 'Puppy o especial cachorros'),
(3, 'Polivalente canina'),
(4, 'Polivalente canina 2'),
(5, 'Traqueo bronquitis'),
(6, 'Antirrábica'),
(7, 'Antirrábica, Polivalente y bronquitis'),
(8, 'Triple felina'),
(9, 'Triple felina 2da dosis'),
(10, 'Triple felina 3ra dosis'),
(11, 'Rabia'),
(12, 'Triple felina 4ta dosis'),
(13, 'Triple felina y rabia'),
(14, 'Leucemia felina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ver`
--

CREATE TABLE `ver` (
  `id_ver` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `ver`
--

INSERT INTO `ver` (`id_ver`, `nombre`) VALUES
(1, 'Visto'),
(2, 'No visto'),
(3, 'listo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinaria`
--

CREATE TABLE `veterinaria` (
  `id_veterinaria` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `nom_barrio` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `veterinaria`
--

INSERT INTO `veterinaria` (`id_veterinaria`, `nombre`, `direccion`, `telefono`, `nom_barrio`, `correo`) VALUES
(1, 'Animal Heart', 'Cra. 10 #11-28', '3112048186 - 3102884927', 'Aquimin', 'AnimalHeart.Vet@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`id_articulo`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_tipo_articulo` (`id_tipo_articulo`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_estado_cita` (`id_estado_cita`),
  ADD KEY `id_nom_servicio` (`id_nom_servicio`),
  ADD KEY `id_ver` (`id_ver`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `compra_proveedor`
--
ALTER TABLE `compra_proveedor`
  ADD PRIMARY KEY (`id_compra_proveedor`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `desparasitante`
--
ALTER TABLE `desparasitante`
  ADD PRIMARY KEY (`id_desparasitante`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle_factura`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_articulo` (`id_articulo`),
  ADD KEY `id_tipo_articulo` (`id_tipo_articulo`);

--
-- Indices de la tabla `detalle_factura_temp`
--
ALTER TABLE `detalle_factura_temp`
  ADD PRIMARY KEY (`id_detalle_factura_temp`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_articulo` (`id_articulo`),
  ADD KEY `id_tipo_articulo` (`id_tipo_articulo`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  ADD PRIMARY KEY (`id_estado_cita`);

--
-- Indices de la tabla `estado_factura`
--
ALTER TABLE `estado_factura`
  ADD PRIMARY KEY (`id_estado_factura`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_veterinaria` (`id_veterinaria`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_estado_factura` (`id_estado_factura`);

--
-- Indices de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD PRIMARY KEY (`id_historial_clinico`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_tratamiento` (`id_tratamiento`),
  ADD KEY `id_vacuna` (`id_vacuna`),
  ADD KEY `id_desparasitante` (`id_desparasitante`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_nom_servicio` (`id_nom_servicio`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_tipo_mascota` (`id_tipo_mascota`),
  ADD KEY `id_raza` (`id_raza`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `nom_servicio`
--
ALTER TABLE `nom_servicio`
  ADD PRIMARY KEY (`id_nom_servicio`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `raza`
--
ALTER TABLE `raza`
  ADD PRIMARY KEY (`id_raza`),
  ADD KEY `id_tipo_mascota` (`id_tipo_mascota`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tipo_articulo`
--
ALTER TABLE `tipo_articulo`
  ADD PRIMARY KEY (`id_tipo_articulo`);

--
-- Indices de la tabla `tipo_mascota`
--
ALTER TABLE `tipo_mascota`
  ADD PRIMARY KEY (`id_tipo_mascota`);

--
-- Indices de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD PRIMARY KEY (`id_tratamiento`),
  ADD KEY `id_mascota` (`id_mascota`);

--
-- Indices de la tabla `vacuna`
--
ALTER TABLE `vacuna`
  ADD PRIMARY KEY (`id_vacuna`);

--
-- Indices de la tabla `ver`
--
ALTER TABLE `ver`
  ADD PRIMARY KEY (`id_ver`);

--
-- Indices de la tabla `veterinaria`
--
ALTER TABLE `veterinaria`
  ADD PRIMARY KEY (`id_veterinaria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `id_articulo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compra_proveedor`
--
ALTER TABLE `compra_proveedor`
  MODIFY `id_compra_proveedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `desparasitante`
--
ALTER TABLE `desparasitante`
  MODIFY `id_desparasitante` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle_factura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_factura_temp`
--
ALTER TABLE `detalle_factura_temp`
  MODIFY `id_detalle_factura_temp` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  MODIFY `id_estado_cita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estado_factura`
--
ALTER TABLE `estado_factura`
  MODIFY `id_estado_factura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  MODIFY `id_historial_clinico` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `id_mascota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `nom_servicio`
--
ALTER TABLE `nom_servicio`
  MODIFY `id_nom_servicio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id_raza` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_articulo`
--
ALTER TABLE `tipo_articulo`
  MODIFY `id_tipo_articulo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipo_mascota`
--
ALTER TABLE `tipo_mascota`
  MODIFY `id_tipo_mascota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `id_tratamiento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vacuna`
--
ALTER TABLE `vacuna`
  MODIFY `id_vacuna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ver`
--
ALTER TABLE `ver`
  MODIFY `id_ver` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `veterinaria`
--
ALTER TABLE `veterinaria`
  MODIFY `id_veterinaria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  ADD CONSTRAINT `articulo_ibfk_2` FOREIGN KEY (`id_tipo_articulo`) REFERENCES `tipo_articulo` (`id_tipo_articulo`);

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`),
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`id_estado_cita`) REFERENCES `estado_cita` (`id_estado_cita`),
  ADD CONSTRAINT `cita_ibfk_4` FOREIGN KEY (`id_nom_servicio`) REFERENCES `nom_servicio` (`id_nom_servicio`),
  ADD CONSTRAINT `cita_ibfk_5` FOREIGN KEY (`id_ver`) REFERENCES `ver` (`id_ver`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `compra_proveedor`
--
ALTER TABLE `compra_proveedor`
  ADD CONSTRAINT `compra_proveedor_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`),
  ADD CONSTRAINT `detalle_factura_ibfk_3` FOREIGN KEY (`id_tipo_articulo`) REFERENCES `tipo_articulo` (`id_tipo_articulo`);

--
-- Filtros para la tabla `detalle_factura_temp`
--
ALTER TABLE `detalle_factura_temp`
  ADD CONSTRAINT `detalle_factura_temp_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `detalle_factura_temp_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`),
  ADD CONSTRAINT `detalle_factura_temp_ibfk_3` FOREIGN KEY (`id_tipo_articulo`) REFERENCES `tipo_articulo` (`id_tipo_articulo`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_veterinaria`) REFERENCES `veterinaria` (`id_veterinaria`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `factura_ibfk_4` FOREIGN KEY (`id_estado_factura`) REFERENCES `estado_factura` (`id_estado_factura`);

--
-- Filtros para la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD CONSTRAINT `historial_clinico_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `historial_clinico_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`),
  ADD CONSTRAINT `historial_clinico_ibfk_3` FOREIGN KEY (`id_tratamiento`) REFERENCES `tratamiento` (`id_tratamiento`),
  ADD CONSTRAINT `historial_clinico_ibfk_4` FOREIGN KEY (`id_vacuna`) REFERENCES `vacuna` (`id_vacuna`),
  ADD CONSTRAINT `historial_clinico_ibfk_5` FOREIGN KEY (`id_desparasitante`) REFERENCES `desparasitante` (`id_desparasitante`),
  ADD CONSTRAINT `historial_clinico_ibfk_6` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `historial_clinico_ibfk_7` FOREIGN KEY (`id_nom_servicio`) REFERENCES `nom_servicio` (`id_nom_servicio`);

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `mascota_ibfk_1` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tipo_mascota` (`id_tipo_mascota`),
  ADD CONSTRAINT `mascota_ibfk_2` FOREIGN KEY (`id_raza`) REFERENCES `raza` (`id_raza`),
  ADD CONSTRAINT `mascota_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Filtros para la tabla `raza`
--
ALTER TABLE `raza`
  ADD CONSTRAINT `raza_ibfk_1` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tipo_mascota` (`id_tipo_mascota`);

--
-- Filtros para la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `tratamiento_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
