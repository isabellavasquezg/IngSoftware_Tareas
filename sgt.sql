-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2025 at 04:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgt`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipos_medicos`
--

CREATE TABLE `equipos_medicos` (
  `id` int(3) NOT NULL,
  `numeroActivo` varchar(20) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `codigoUbicacion` varchar(20) NOT NULL,
  `codigoResponsable` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipos_medicos`
--

INSERT INTO `equipos_medicos` (`id`, `numeroActivo`, `marca`, `modelo`, `codigoUbicacion`, `codigoResponsable`) VALUES
(2, 'EQA001', 'GE Healthcare', 'LOGIQ E9 (Ultrasonido)', 'U006', 'R003'),
(3, 'EQA003', 'Dräger', 'Ventilador Savina 300', 'U003', 'R013'),
(4, 'EQA004', 'Medtronic', 'Defibrillator Lifepak 20', 'U001', 'R005'),
(5, 'EQA005', 'Siemens', 'Aera 1.5T (Resonancia)', 'U006', 'R003'),
(6, 'EQA006', 'Zoll', 'ECG E-Series', 'U003', 'R017'),
(7, 'EQA007', 'Stryker', 'Mesa Quirúrgica 5085', 'U002', 'R021'),
(8, 'EQA008', 'Baxter', 'Bomba de Infusión Sigma', 'U004', 'R008'),
(9, 'EQA009', 'Olympus', 'Endoscopio CV-190', 'U011', 'R011'),
(10, 'EQA010', 'Mindray', 'Monitor BeneVision N1', 'U016', 'R006'),
(11, 'EQA011', 'Fresenius', 'Máquina de Diálisis 5008', 'U013', 'R007'),
(12, 'EQA012', 'B. Braun', 'Bomba de Infusión Space', 'U010', 'R010'),
(13, 'EQA013', 'Toshiba', 'Aquilion One (TAC)', 'U006', 'R009'),
(14, 'EQA014', 'Welch Allyn', 'Monitor de Signos Vitales', 'U009', 'R012'),
(15, 'EQA015', 'GE Healthcare', 'Máquina de Anestesia', 'U002', 'R021'),
(16, 'EQA016', 'Abbott', 'Sistema de Análisis i-STAT', 'U005', 'R016'),
(17, 'EQA017', 'Vyaire', 'Ventilador Bellavista', 'U016', 'R014'),
(18, 'EQA018', 'Karl Storz', 'Equipo Laparoscópico', 'U002', 'R021'),
(90, 'EQ55555', 'pepito', 'pettt', 'U008', 'R019');

-- --------------------------------------------------------

--
-- Table structure for table `responsables`
--

CREATE TABLE `responsables` (
  `id` int(3) NOT NULL,
  `codigoAsignado` varchar(20) NOT NULL,
  `documentoIdentidad` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responsables`
--

INSERT INTO `responsables` (`id`, `codigoAsignado`, `documentoIdentidad`, `nombre`, `apellido`, `cargo`, `telefono`) VALUES
(1, 'R021', '1001', 'Laura', 'Gómez', 'Enfermera Jefe', '3001112233'),
(2, 'R002', '1002', 'Carlos', 'Pérez', 'Técnico Radiología', '3002223344'),
(3, 'R003', '1003', 'Ana', 'Díaz', 'Especialista Tomografía', '3003334455'),
(5, 'R005', '1005', 'Sofía', 'Martínez', 'Paramédico Urgencias', '3005556677'),
(6, 'R006', '1006', 'Andrés', 'Hernández', 'Enfermero Neonatal', '3006667788'),
(7, 'R007', '1007', 'Valentina', 'López', 'Auxiliar Mantenimiento', '3007778899'),
(8, 'R008', '1008', 'Felipe', 'Ruiz', 'Enfermero Pediatría', '3008889900'),
(9, 'R009', '1009', 'Camila', 'Silva', 'Técnico Imagenología', '3009990011'),
(10, 'R010', '1010', 'Ricardo', 'Mora', 'Auxiliar de Enfermería', '3000001122'),
(11, 'R011', '1011', 'María', 'Castro', 'Especialista Endoscopia', '3001110001'),
(12, 'R012', '1012', 'Diego', 'Rojas', 'Médico Consulta Externa', '3002220002'),
(13, 'R013', '1013', 'Sara', 'Vargas', 'Terapeuta Respiratoria', '3003330003'),
(14, 'R014', '1014', 'Luis', 'García', 'Enfermero Jefe UCI', '3004440004'),
(16, 'R016', '1016', 'Javier', 'Pardo', 'Químico Laboratorio', '3006660006'),
(17, 'R017', '1017', 'Natalia', 'Blanco', 'Jefe de Urgencias', '3007770007'),
(18, 'R018', '1018', 'Pablo', 'Méndez', 'Técnico Ultrasonido', '3008880008'),
(19, 'R019', '1019', 'Isabella', 'Cruz', 'Radióloga', '3009990009'),
(20, 'R020', '1020', 'Gabriel', 'Núñez', 'Ginecólogo', '3000000010');

-- --------------------------------------------------------

--
-- Table structure for table `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(3) NOT NULL,
  `codigoAsignado` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `codigoAsignado`, `nombre`, `ubicacion`, `telefono`) VALUES
(1, 'U001', 'Emergencia', 'Shock Traumas', '3001118801'),
(2, 'U002', 'Cirugía', 'Quirófano Central 1', '3001118802'),
(3, 'U003', 'UCI Adultos', 'Cubículo 5', '3001118803'),
(4, 'U004', 'Pediatría', 'Sala de Observación', '3001118804'),
(5, 'U005', 'Laboratorio', 'Toma de Muestras', '3001118805'),
(6, 'U006', 'Imagenología', 'Resonancia Magnética 1', '3001118806'),
(7, 'U007', 'Farmacia', 'Almacén de Biológicos', '3001118807'),
(8, 'U008', 'Mantenimiento', 'Taller Biomédico', '3001118808'),
(9, 'U009', 'Consulta Externa', 'Consultorio 305', '3001118809'),
(10, 'U010', 'Fisioterapia', 'Gimnasio de Rehabilitación', '3001118810'),
(11, 'U011', 'Ginecología', 'Sala de Partos 2', '3001118811'),
(12, 'U012', 'Cardiología', 'Unidad de Cuidados Coronarios', '3001118812'),
(13, 'U013', 'Hemodiálisis', 'Puesto 12', '3001118813'),
(14, 'U014', 'Esterilización', 'Área de lavado', '3001118814'),
(15, 'U015', 'Almacén General', 'Nivel -1 Bodega C', '3001118815'),
(16, 'U016', 'UCI Neonatal', 'Incubadoras 1-5', '3001118816'),
(17, 'U017', 'Oncología', 'Sala de Quimioterapia 2', '3001118817'),
(18, 'U018', 'Oftalmología', 'Sala de Cirugía Menor', '3001118818'),
(55, 'R119', 'Kevin', 'eeeee', '2314267'),
(56, '054020', 'Jose', 'eeeee', '2314267');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(3) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`) VALUES
(1, 'kevin.garciaj', 'eb1dd2a33169a70c1b5c29f5c15d7c3e7c72660e395d6f27c35366e13d42cdeb'),
(2, 'dairon.montes', 'a6e4e3fa455c4a8dd84df3f44098a8d85524dbc96130f033c4bb106c8dd1dfb7'),
(3, 'isabella.vasquezg', '9bfa35ffae0020b5ee82a94e663d3cd5c26530baba1c0fc84933936efeb2f66e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipos_medicos`
--
ALTER TABLE `equipos_medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numeroActivo` (`numeroActivo`),
  ADD KEY `equipos_medicos_codigoAsignado_responsables` (`codigoResponsable`),
  ADD KEY `equipos_medicos_codigoAsignado_ubicaciones` (`codigoUbicacion`);

--
-- Indexes for table `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigoAsignado` (`codigoAsignado`),
  ADD UNIQUE KEY `codigoAsignado_2` (`codigoAsignado`),
  ADD UNIQUE KEY `documentoIdentidad` (`documentoIdentidad`);

--
-- Indexes for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigoAsignado` (`codigoAsignado`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipos_medicos`
--
ALTER TABLE `equipos_medicos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipos_medicos`
--
ALTER TABLE `equipos_medicos`
  ADD CONSTRAINT `equipos_medicos_codigoAsignado_responsables` FOREIGN KEY (`codigoResponsable`) REFERENCES `responsables` (`codigoAsignado`) ON UPDATE CASCADE,
  ADD CONSTRAINT `equipos_medicos_codigoAsignado_ubicaciones` FOREIGN KEY (`codigoUbicacion`) REFERENCES `ubicaciones` (`codigoAsignado`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
