-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2017 a las 23:01:16
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `constructor_horarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `id_aula` int(11) NOT NULL,
  `numero` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` int(11) NOT NULL,
  `tipo` enum('General','Laboratorio','Otro') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id_aula`, `numero`, `capacidad`, `tipo`) VALUES
(2, 'A-003', 45, 'General'),
(18, 'B-02', 30, 'General'),
(19, 'Laboratorio A', 20, 'Laboratorio'),
(20, 'Laboratorio B', 20, 'Laboratorio'),
(21, 'Cancha multiusos', 300, 'Otro'),
(22, 'A-004', 45, 'General'),
(23, 'A-002', 45, 'General');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `id_escuela` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuela`
--

CREATE TABLE `escuela` (
  `id_escuela` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `imagen` tinytext COLLATE utf8_unicode_ci,
  `rif` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `escuela`
--

INSERT INTO `escuela` (`id_escuela`, `nombre`, `direccion`, `imagen`, `rif`, `telefono`, `correo`) VALUES
(1, 'Colegio de Maracaibo', 'Av 13A con calle 50, parroquia coquivacoa.', 'img/usuarios/logo.png', 'J-30900745-9', '(026) 171-9435', 'colegio@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE `grado` (
  `id_grado` int(11) NOT NULL,
  `numero` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grado`
--

INSERT INTO `grado` (`id_grado`, `numero`, `estado`) VALUES
(1, '1° Año', 'activo'),
(2, '2° Año', 'activo'),
(3, '3° Año', 'activo'),
(4, '4° Año', 'activo'),
(5, '5° Año', 'activo'),
(6, '6° ', 'inactivo'),
(7, '1º Grado', 'inactivo'),
(8, '2º Grado', 'inactivo'),
(9, '3º Grado', 'inactivo'),
(10, '4º Grado', 'inactivo'),
(11, '5º Grado', 'inactivo'),
(12, '6º Grado', 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado_materia_horas`
--

CREATE TABLE `grado_materia_horas` (
  `id_grado` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `hora` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grado_materia_horas`
--

INSERT INTO `grado_materia_horas` (`id_grado`, `id_materia`, `hora`) VALUES
(1, 1, 4),
(1, 4, 6),
(1, 5, 4),
(1, 1000, 4),
(2, 1, 4),
(2, 4, 6),
(2, 5, 4),
(3, 1, 4),
(3, 2, 4),
(3, 3, 5),
(3, 4, 6),
(3, 6, 4),
(4, 1, 4),
(4, 2, 4),
(4, 3, 4),
(4, 4, 6),
(4, 6, 4),
(5, 1, 4),
(5, 2, 4),
(5, 3, 4),
(5, 4, 4),
(5, 6, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hora`
--

CREATE TABLE `hora` (
  `id_hora` int(11) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `hora`
--

INSERT INTO `hora` (`id_hora`, `hora`) VALUES
(1, '07:00:00'),
(2, '07:40:00'),
(3, '08:20:00'),
(4, '08:25:00'),
(5, '09:05:00'),
(6, '09:45:00'),
(7, '09:50:00'),
(8, '10:30:00'),
(9, '11:10:00'),
(10, '11:50:00'),
(11, '12:30:00'),
(12, '01:10:00'),
(13, '01:50:00'),
(14, '02:30:00'),
(15, '03:10:00'),
(16, '04:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  `estado` enum('Listo','Incompleto') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `id_seccion`, `estado`) VALUES
(28, 3, 'Listo'),
(29, 2, 'Incompleto'),
(30, 4, 'Listo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(145) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `nombre`, `descripcion`) VALUES
(1, 'Castellano', 'Tiene como propósito desarrollar en los estudiantes  destrezas en el área de la escritura y la lingüística permitiendo un mejor dominio de la gra'),
(2, 'Fisica', ''),
(3, 'Química', ''),
(4, 'Inglés y otras lenguas extranjeras', ''),
(5, 'Ciencias naturales', ''),
(6, 'Biología', ''),
(999, 'Receso', NULL),
(1000, 'Matemáticas', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nivel_acceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre`, `nivel_acceso`) VALUES
(1, 'Administrador', 1),
(2, 'Docente', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_departamento`
--

CREATE TABLE `perfil_departamento` (
  `id_perfil` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(145) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dni` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(54) CHARACTER SET utf8 DEFAULT NULL,
  `usuario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(145) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre`, `apellido`, `telefono`, `direccion`, `dni`, `correo`, `usuario`, `clave`, `imagen`) VALUES
(1, 'Samuel', 'Villegas', '0414', 'Una casa', '26173916', '', 'lyons', '1234', 'img/usuarios/avatar1.png'),
(2, 'José ', 'Alarcón', '(124) 687-6976', '', '24404909', 'jose@gmail.com', 'josealarcon', '123456', 'img/usuarios/avatar2.png'),
(3, 'Test', 'pagina', '(012) 456-7999', 'Direccion de la empresa', '123456', 'hola@hotmail.com', 'test_user', '123456', 'img/usuarios/constructor_horarios definitvo_2.png'),
(4, 'Ingrid', 'ruiz', '(414) 167-5644', 'maracaibo\r\nmaracaibo', '123', '', 'iruiz', '123456', 'img/usuarios/2.jpg'),
(5, 'Benji', 'Harper', '(012) 455-9944', 'Casa azul', '2655846', '', 'bharper', '123456', 'img/usuarios/avatar1.png'),
(6, 'Penelope', 'Thorton', '(141) 556-5656', 'Mara Norte I Etapa\r\ntransversal C Nro 07-29', '12458697', 'vanellop@muyreal.com', 'teacher', '123456', 'img/usuarios/avatar6.png'),
(7, 'Pablo', 'Gutierritos', '(141) 496-6496', 'Av 6 con calle 6', '25684', 'gutierritos@emailmuyreal.com', 'pgutierritos', '1234', 'img/usuarios/avatar4.png'),
(10, 'Marcela', 'Estevez', '(414) 545-5445', '', '311454227', 'mar_este@unemail.com', 'm_lyons', '123456', 'img/usuarios/belong-here.jpg'),
(11, 'Jaime', 'Lannister', '(414) 123-3564', '', '08141454', 'hh@gmail.com', 'lannister1', '123456', 'img/usuarios/intro.jpg'),
(12, 'Rick', 'Sanchez', '(414) 546-5644', 'desconocido', '81262164', 'ricky@fakeemail.com', 'noseasunlarry', '123456', 'img/usuarios/Rick_Sanchez.png'),
(13, 'Yenisey', 'Gonzalez', '(042) 658-4213', 'Altos del sol amada', '91112310', 'yeniseygonzalez@hotmail.com', 'yeniseyg', '147258', 'img/usuarios/Koala.jpg'),
(14, 'Robertina', 'Perez', '(426) 824-1245', 'Los haticos', '9178941', 'robertinaperez@gmail.com', 'robertinap', '258147', 'img/usuarios/Koala.jpg'),
(15, 'Angel', 'Nava', '(426) 845-1369', 'La polar', '1621046', 'angel@escuela.com', 'angeln', '147258', 'img/usuarios/avatar.png'),
(16, 'Yurban', 'Chourio', '(424) 982-4753', 'San francisco', '1621475', 'yurbanchourio@gmail.com', 'yurbanc', '147258', 'img/usuarios/avatar4.png'),
(17, 'Eudo', 'Boscan', '(424) 647-8645', 'La polar', '14257936', '', 'eudob', '147258', 'img/usuarios/avatar3.png'),
(18, 'Renny ', 'Medina', '(424) 957-8965', 'Curva de molina', '15214596', 'rennymedina@gmail.com', 'rennym', '147258', 'img/usuarios/avatar.png'),
(19, 'Manolo', 'Figueroa', '(424) 957-8965', 'Los haticos', '13012423', 'manolo@gmail.com', 'manolofig', '123456', 'img/usuarios/avatar3.png'),
(20, 'Yefran', 'Rondon', '(424) 957-8654', 'Altos del sol amada', '9745812', 'yefranrondon@gmail.com', 'yefranr', '147258', 'img/usuarios/avatar3.png'),
(21, 'Yoherica', 'Nava', '(424) 956-7865', 'Los olivos', '14524125', 'yohr@gmail.com', 'yoherican', '147258', 'img/usuarios/avatar6.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_materia`
--

CREATE TABLE `persona_materia` (
  `id_persona` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `persona_materia`
--

INSERT INTO `persona_materia` (`id_persona`, `id_materia`) VALUES
(2, 4),
(2, 1000),
(4, 2),
(5, 3),
(6, 1),
(10, 4),
(12, 3),
(13, 6),
(17, 5),
(18, 5),
(20, 2),
(20, 6),
(21, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_perfil`
--

CREATE TABLE `persona_perfil` (
  `id_persona` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `persona_perfil`
--

INSERT INTO `persona_perfil` (`id_persona`, `id_perfil`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina`
--

CREATE TABLE `rutina` (
  `id_rutina` int(11) NOT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_aula` int(11) DEFAULT NULL,
  `id_hora_inicio` int(11) DEFAULT NULL,
  `id_hora_fin` int(11) DEFAULT NULL,
  `dia` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_horario` int(11) DEFAULT NULL,
  `color` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rutina`
--

INSERT INTO `rutina` (`id_rutina`, `id_materia`, `id_persona`, `id_aula`, `id_hora_inicio`, `id_hora_fin`, `dia`, `id_horario`, `color`) VALUES
(16, 1, 6, 2, 8, 15, '1', 29, '#C0BDD0'),
(17, 1, 6, 2, 8, 15, '5', 29, 'rgb(192, 189, 208)'),
(20, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(21, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(22, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(23, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(24, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(25, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(26, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(27, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(28, 1, 2, 23, 2, 6, '1', 28, '#47BDCC'),
(29, 3, 5, 2, 1, 5, '2', 30, '#B24132');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id_seccion` int(11) NOT NULL,
  `numero_nombre` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `id_grado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id_seccion`, `numero_nombre`, `id_grado`) VALUES
(1, 'A', 1),
(2, 'B', 1),
(3, 'U', 2),
(4, 'A', 3),
(5, 'B', 3),
(6, 'C', 3),
(7, 'A', 4),
(8, 'B', 4),
(9, 'U', 5),
(10, 'C', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`id_aula`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `escuela`
--
ALTER TABLE `escuela`
  ADD PRIMARY KEY (`id_escuela`);

--
-- Indices de la tabla `grado`
--
ALTER TABLE `grado`
  ADD PRIMARY KEY (`id_grado`);

--
-- Indices de la tabla `grado_materia_horas`
--
ALTER TABLE `grado_materia_horas`
  ADD PRIMARY KEY (`id_grado`,`id_materia`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `hora`
--
ALTER TABLE `hora`
  ADD PRIMARY KEY (`id_hora`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id_materia`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `perfil_departamento`
--
ALTER TABLE `perfil_departamento`
  ADD PRIMARY KEY (`id_perfil`,`id_departamento`),
  ADD KEY `id_departamento` (`id_departamento`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `persona_materia`
--
ALTER TABLE `persona_materia`
  ADD PRIMARY KEY (`id_persona`,`id_materia`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `persona_perfil`
--
ALTER TABLE `persona_perfil`
  ADD PRIMARY KEY (`id_persona`,`id_perfil`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- Indices de la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD PRIMARY KEY (`id_rutina`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_aula` (`id_aula`),
  ADD KEY `id_hora_inicio` (`id_hora_inicio`),
  ADD KEY `id_fin_inicio` (`id_hora_fin`),
  ADD KEY `id_horario` (`id_horario`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id_seccion`),
  ADD KEY `id_grado` (`id_grado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `escuela`
--
ALTER TABLE `escuela`
  MODIFY `id_escuela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `grado`
--
ALTER TABLE `grado`
  MODIFY `id_grado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `hora`
--
ALTER TABLE `hora`
  MODIFY `id_hora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `rutina`
--
ALTER TABLE `rutina`
  MODIFY `id_rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuela` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grado_materia_horas`
--
ALTER TABLE `grado_materia_horas`
  ADD CONSTRAINT `grado_materia_horas_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grado` (`id_grado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grado_materia_horas_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `perfil_departamento`
--
ALTER TABLE `perfil_departamento`
  ADD CONSTRAINT `perfil_departamento_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `perfil_departamento_ibfk_2` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona_materia`
--
ALTER TABLE `persona_materia`
  ADD CONSTRAINT `persona_materia_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_materia_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona_perfil`
--
ALTER TABLE `persona_perfil`
  ADD CONSTRAINT `persona_perfil_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD CONSTRAINT `rutina_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutina_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutina_ibfk_3` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutina_ibfk_4` FOREIGN KEY (`id_hora_inicio`) REFERENCES `hora` (`id_hora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutina_ibfk_5` FOREIGN KEY (`id_hora_fin`) REFERENCES `hora` (`id_hora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutina_ibfk_6` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grado` (`id_grado`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
