-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2025 a las 15:53:43
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
-- Base de datos: `sgt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contraseñas`
--

CREATE TABLE `contraseñas` (
  `id` int(3) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contraseñas`
--

INSERT INTO `contraseñas` (`id`, `usuario`, `contraseña`) VALUES
(1, 'kevin.garciaj', '1001132918'),
(2, 'dairon.montes', '1001686081'),
(3, 'isabella.vasquezg', '1000438341');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(3) NOT NULL,
  `numero activo` varchar(20) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `codigo ubicacion` varchar(50) NOT NULL,
  `codigo responsable` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `numero activo`, `marca`, `modelo`, `codigo ubicacion`, `codigo responsable`) VALUES
(1, 'EQ101', 'Philips', 'IntelliVue MX450', 'U101', 'R101'),
(2, 'EQ102', 'GE', 'CARESCAPE V100', 'U102', 'R103'),
(3, 'EQ103', 'Dräger', 'Evita Infinity', 'U104', 'R102'),
(4, 'EQ104', 'Mindray', 'BeneHeart D6', 'U103', 'R105'),
(5, 'EQ105', 'Siemens', 'SOMATOM Go Now', 'U107', 'R104'),
(6, 'EQ106', 'Philips', 'Ingenia 1.5T', 'U108', 'R106'),
(7, 'EQ107', 'Beckman', 'AU480 Analyzer', 'U109', 'R107'),
(8, 'EQ108', 'Terumo', 'Sarns 8000', 'U105', 'R108'),
(9, 'EQ109', 'Olympus', 'CV-150', 'U110', 'R109'),
(10, 'EQ110', 'Fresenius', '4008S', 'U112', 'R110'),
(11, 'EQ111', 'EQ111', 'Carescape B650', 'U113', 'R111'),
(12, 'EQ112', 'Philips', 'SureSigns VS3', 'U114', 'R112'),
(13, 'EQ113', 'Dräger', 'Fabius Plus', 'U106', 'R113'),
(14, 'EQ114', 'Welch Allyn', 'Connex Spot', 'U115', 'R114'),
(15, 'EQ115', 'Roche', 'Cobas e411', 'U109', 'R115'),
(16, 'EQ116', 'EQ116', 'Sigma Spectrum', 'U116', 'R116'),
(17, 'EQ117', 'Philips', 'Affiniti 50', 'U117', 'R117'),
(18, 'EQ118', 'GE', 'LOGIQ F8', 'U118', 'R118');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id` int(3) NOT NULL,
  `codigo asignado` varchar(20) NOT NULL,
  `documento de identidad` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id`, `codigo asignado`, `documento de identidad`, `nombre`, `apellido`, `cargo`, `telefono`) VALUES
(1, 'R101', '1023456789', 'Juan', 'Pérez Gómez', 'Médico Especialista', '3102001'),
(2, 'R102', '9876543210', 'María', 'Torres López', 'Enfermera Jefe', '3102002'),
(3, 'R103', '1122334455', 'Andrés', 'Ramírez Díaz', 'Auxiliar de Enfermería', '3102003'),
(4, 'R104', '2233445566', 'Laura', 'Gutiérrez Ruiz', 'Ingeniera Biomédica', '3102005'),
(5, 'R105', '3344556677', 'Carlos', 'Rodríguez Peña', 'Técnico Biomédico', '3102005'),
(6, 'R106', '4455667788', 'Diana', 'Morales Salazar', 'Especialista en Pediatría', '3102006'),
(7, 'R107', '5566778899', 'Jorge', 'Castillo Vargas', 'Neuro Cirujano', '3102007'),
(8, 'R108', '6677889900', 'Sofía', 'Mendoza Torres', 'Enfermera Auxiliar', '3102008'),
(9, 'R109', '7788990011', 'Felipe', 'Herrera Castaño', 'Radiólogo', '3102009'),
(10, 'R110', '8899001122', 'Camila', 'Sánchez Mora', 'Radióloga', '3102010'),
(11, 'R111', '9900112233', 'Luis', 'Martínez Ríos', 'Director Médico', '3102011'),
(12, 'R112', '1011122233', 'Natalia', 'Jiménez Reyes', 'Auxiliar de Laboratorio', '3102012'),
(13, 'R113', '1213141516', 'Ricardo', 'Pineda Silva', 'Técnico de Mantenimiento', '3102013'),
(14, 'R114', '1314151617', 'Valentina', 'Ortiz León', 'Especialista en Oncología', '3102014'),
(15, 'R115', '1001132918', 'Kevin', 'García Jaramillo', 'Ingeniero Biomedico', '3102015'),
(16, 'R116', '1001686081', 'Dairon', 'Montes Barrada', 'Ingeniero Biomedico', '3102016'),
(17, 'R117', '1000438341', 'Isabella', 'Vásquez García', 'Ingeniera Biomédica', '3102017'),
(18, 'R118', '1718192021', 'Gabriela', 'Castro Pardo', 'Jefe de UCI Pediátrica', '3102018');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(3) NOT NULL,
  `codigoAsignado` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `codigoAsignado`, `nombre`, `ubicacion`, `telefono`) VALUES
(1, 'U101', 'Urgencias', 'Piso 1, ala principal', '3001001'),
(2, 'U102', 'Pediatría', 'Piso 3, ala norte', '3001002'),
(3, 'U103', 'UCI Adultos', 'Piso 2, ala este', '3001003'),
(4, 'U104', 'UCI Neonatal', 'Piso 3, ala este', '3001004'),
(5, 'U105', 'Quirófano 1', 'Piso 2, bloque quirúrgico', '3001005'),
(6, 'U106', 'Quirófano 2', 'Piso 2, bloque quirúrgico', '3001006'),
(7, 'U107', 'Imagenología (Rayos X)', 'Piso 1, ala sur', '3001007'),
(8, 'U108', 'Imagenología (Resonancia Magnética)', 'Piso 1, ala sur', '3001008'),
(9, 'U109', 'Laboratorio Clínico', 'Piso 1, ala oeste', '3001009'),
(10, 'U110', 'Banco de Sangre', 'Piso 1, ala oeste', '3001010'),
(11, 'U111', 'Farmacia', 'Piso 1, ala norte', '3001011'),
(12, 'U112', 'Central de Esterilización', 'Piso 2, ala oeste', '3001012'),
(13, 'U113', 'Sala de Recuperación', 'Piso 2, ala central', '3001013'),
(14, 'U114', 'Consulta Externa', 'Piso 3, ala oeste', '3001014'),
(15, 'U115', 'Ginecología y Obstetricia', 'Piso 3, ala central', '3001015'),
(16, 'U116', 'Cardiología', 'Piso 3, ala sur', '3001016'),
(17, 'U117', 'Oncología', 'Piso 4, ala norte', '3001017'),
(18, 'U118', 'Medicina Interna', 'Piso 4, ala este', '3001018');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contraseñas`
--
ALTER TABLE `contraseñas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contraseñas`
--
ALTER TABLE `contraseñas`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
