-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2021 at 08:24 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xcmsl`
--

-- --------------------------------------------------------

--
-- Table structure for table `appconfig`
--

CREATE TABLE `appconfig` (
  `appid` int(11) NOT NULL,
  `prop` varchar(80) NOT NULL,
  `val` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appconfig`
--

INSERT INTO `appconfig` (`appid`, `prop`, `val`) VALUES
(40, 'inicio', 'inicio.xml'),
(40, 'conexión', 'conectate.xml'),
(40, 'eventos', 'blog.xml'),
(40, 'nosotros', 'nosotros.xml'),
(40, 'contacto', 'contacto.xml'),
(40, 'logo_left', './img/logo_l.png'),
(40, 'logo_right', './img/logo_r.png'),
(40, 'ios', ''),
(40, 'android', ''),
(40, 'fb', ''),
(40, 'twitter', ''),
(40, 'youtube', ''),
(40, 'insta', ''),
(40, 'applogo', ''),
(40, 'template', 'template1');

-- --------------------------------------------------------

--
-- Table structure for table `appprogress`
--

CREATE TABLE `appprogress` (
  `progressid` int(11) NOT NULL,
  `categid` int(11) NOT NULL,
  `team` varchar(120) NOT NULL,
  `title` varchar(120) NOT NULL,
  `percent` decimal(10,0) NOT NULL,
  `notes` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appprogress`
--

INSERT INTO `appprogress` (`progressid`, `categid`, `team`, `title`, `percent`, `notes`) VALUES
(1, 413, 'SD01', 'ESTA EL SITE TITLE CORRECTO?', '0', ''),
(2, 413, 'SD02', 'ESTA EL SITE TAG LINE CORRECTO?', '0', ''),
(3, 413, 'SD03', 'ESTA EL PERMALINK CORRECTO? ', '0', ''),
(4, 413, 'SD04', 'ESTA CON LA INFO DE COPYRIGHT Y HECHO EL LINK?', '0', ''),
(5, 413, 'SD05', 'ESTA EL LOGOTIPO DE E2OUTLOOK EN LA SECCION DE COPYRIGHT A LA IZQUIERDA', '0', ''),
(6, 413, 'SD06', 'BASADO EN EL LOGO ESTA EL FAVICON LISTO Y SUBIDO?', '0', ''),
(7, 413, 'SD07', 'ESTA EL FAVICON ACTUALIZADO', '0', ''),
(8, 413, 'SD08', 'ESTAN LOS ICONOS DE LAS REDES SOCIALES DE E2OUTLOOK A LA DERECHA', '0', ''),
(9, 414, 'RS01', 'FACEBOOK CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?', '0', ''),
(10, 414, 'RS02', 'TWITTER CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?', '0', ''),
(11, 414, 'RS03', 'GOOGLE PLUS CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?', '0', ''),
(12, 414, 'RS04', 'LINKEDIN CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?', '0', ''),
(13, 414, 'RS05', 'INSTAGRAM CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?', '0', ''),
(14, 414, 'RS06', 'CUENTAS REGISTRADAS EN HOOTSUITE?', '0', ''),
(15, 414, 'RS07', 'DISE&Ntilde;O GRAFICO DE BANNER LISTO?', '0', ''),
(16, 414, 'RS08', 'DISE&Ntilde;O GRAFICO DE FOTO DE PERFIL LISTO?', '0', ''),
(17, 415, 'HDR-001', 'ESTA EL HEADER #14 PUESTO?', '0', ''),
(18, 415, 'HDR-002', 'LOGO #1 ESTA?', '0', ''),
(19, 415, 'HDR-003', 'LOGO #2 ESTA?', '0', ''),
(20, 415, 'HDR-004', 'LOGO #2 LINK?', '0', ''),
(21, 416, 'MNU-001', 'ESTA CREADO EL MENU PRINCIPAL?', '0', ''),
(22, 416, 'MNU-002', 'ASIGNARON EL HOME PAGE EN SETTING', '0', ''),
(23, 416, 'MNU-003', 'TODAS LAS PAGINAS FUERON CREADAS?', '0', ''),
(24, 416, 'MNU-004', 'ESTA LAS REDES SOCIALES EN EL MENU?', '0', ''),
(25, 416, 'MNU-005', 'ESTAN LAS REDES LINKED EN EL MENU A SUS PAGINAS APROPIADAS?', '0', ''),
(26, 416, 'MNU-006', 'HICIERON COMBINACION DE COLORES AL MENU', '0', ''),
(27, 417, 'SL01', 'HICIERON LOS 5 SLIDERS - DISE&Ntilde;O GRAFICO?', '0', ''),
(28, 417, 'SL02', 'HICIERON LINK A TODOS LOS SLIDERS', '0', ''),
(29, 417, 'SL03', 'HICIERON QUE DEN VUELTA LOS SLIDERS ELLOS MISMOS?', '0', ''),
(30, 417, 'SL04', 'HAY LAS FLECHAS EN LOS SLIDERS?', '0', ''),
(31, 417, 'SL05', 'SE VEN BIEN LOS SLIDER PROPORCIONAL CON LA PAGINA?', '0', ''),
(32, 418, 'CT01', 'INSTALARON USE THIS FONT? Y PUSIERON LA LICENCIA?', '0', ''),
(33, 418, 'CT02', 'ASIGNARON UN TEXTO A HEADINGS?', '0', ''),
(34, 418, 'CT03', 'ASIGNARON UN TEXTO ESPECIAL A TEXTO DE PARAGRAPH?', '0', ''),
(35, 418, 'CT04', 'LOS COLORES DE LOS LINKS COMBINAN CON EL LOGO?', '0', ''),
(36, 418, 'CT05', 'LE AJUSTARON EL TAMA&Ntilde;O AL TEXTO?', '0', ''),
(37, 418, 'CT06', 'TODAS LAS PAGINAS TIENEN UN DISE&Ntilde;O COMPLETO Y TEXTO?', '0', ''),
(38, 418, '', 'PAGINA INICIO DISE&Ntilde;O COMPLETO Y TEXTO?', '0', ''),
(39, 418, '', 'PAGINA QUIENES SOMOS DESE&Ntilde;O COMPLETO Y TEXTO?', '0', ''),
(40, 418, '', 'PAGINA LA EMPRESA DISE&Ntilde;O COMPLETO Y TEXTO?', '0', ''),
(41, 418, '', 'PAGINA SERVICIOS DISE&Ntilde;O COMPLETO Y TEXTO?', '0', ''),
(42, 418, '', 'PAGINA PRODUCTOS DESE&Ntilde;O COMPLETO Y TEXTO?', '0', ''),
(43, 418, '', 'PAGINA CONTACT US DISE&Ntilde;O COMPLETO Y TEXTO', '0', ''),
(44, 418, '', 'ENCONTRARON LINKS QUE NO FUNCIONAN?', '0', ''),
(45, 419, 'FM01', 'INSTALARON EL PLUGIN DE FORMULARIOS?', '0', ''),
(46, 419, 'FM02', 'EL FORMULARIO TIENE LICENCIA? ESTA ACTUALIZADO?', '0', ''),
(47, 419, 'FM03', 'HICIERON EL FORMULARIO DE CONTACTO?', '0', ''),
(48, 419, 'FM04', 'SIGUIERON EL FORMATO DE NOMBRAR LOS FORMULARIOS? (NOMBREDEFORMULARIO_PROYECTO)', '0', ''),
(49, 419, 'FM05', 'LOS BOTONES ESTAN DEL MISMO COLOR AL LOGO?', '0', ''),
(50, 419, 'FM06', 'FUNCIONAN TODOS LOS BOTONES', '0', ''),
(51, 420, 'THOP-001', 'DESHABILITARON BREADCRUMBS?', '0', ''),
(52, 420, 'THOP-002', 'ESTA EL HEADER 14 ACTIVADO?', '0', ''),
(53, 420, 'THOP-003', 'EL BODY WRAPPER ESTA EN FULL?', '0', ''),
(54, 420, 'THOP-004', 'ESTA EL WIDTH DE LOGO EN GENERAL 375?', '0', ''),
(55, 420, 'THOP-005', 'ESTA DESHABILITADO LA OPCION DE SIDEBAR?', '0', ''),
(56, 420, 'THOP-006', 'ESTA POST&gt;SINGLE POST, PAGE LAYOUT EN FULL WIDTH?', '0', ''),
(57, 420, 'THOP-007', 'ESTA POST&gt;SINGLE POST, POST LAYOUT EN MEDIUM?', '0', ''),
(58, 421, 'PG01', 'SE INSTALO USE ANY FONT?', '0', ''),
(59, 421, 'PG02', 'SE INSTALO SIMPLE LIGHTBOX?', '0', ''),
(60, 421, 'PG03', 'SE INSTALO EL ULTIMO MASTER SLIDER?', '0', ''),
(61, 421, 'PG04', 'SE INSTALO EL ULTIMO PORTO THEME?', '0', ''),
(62, 421, 'PG05', 'SE INSTALO EL PORTO WIDGETS?', '0', ''),
(63, 421, 'PG06', 'SE INSTALO EL ULTIMO PORTO CONTENT TYPES?', '0', ''),
(64, 421, 'PG07', 'SE INSTALO EL ULTIMO WP BAKERY VISUAL COMPOSER?', '0', ''),
(65, 421, 'PG08', 'SE INSTALO EL ULTIMATE ADD-ONS FOR VISUAL COMPOSER?', '0', ''),
(66, 421, 'PG09', 'SE INSTALO EL ULTIMO MANAGEWP?', '0', ''),
(67, 421, 'PG10', 'SE INSTALO EL ULTIMO GRAVITY FORMS?', '0', ''),
(68, 421, 'PG11', 'SE INSTALO EL ULTIMO AKISMET?', '0', ''),
(69, 421, 'PG12', 'SE INSTALO EL ULTIMO DYNAMIC FEATURED IMAGE?', '0', ''),
(70, 421, 'PG13', 'SE INSTALO Y ACTIVO JETPACK?', '0', ''),
(71, 421, 'PG14', 'SE REVISO QUE LOS COMENTARIOS ESTEN BORRADOS?', '0', ''),
(72, 422, 'FT01', 'FOOTER COMPLETO?', '0', ''),
(73, 422, 'FT02', 'FOOTER #1- &Aacute;REA 1?', '0', ''),
(74, 422, 'FT03', 'FOOTER #1- &Aacute;REA 2?', '0', ''),
(75, 422, 'FT04', 'FOOTER #1- &Aacute;REA 3?', '0', ''),
(76, 422, 'FT05', 'FOOTER #1- &Aacute;REA 4?', '0', ''),
(77, 422, 'FT06', 'ESTA TODO EL TEXTO EN EL MISMO COLOR EN EL FOOTER?', '0', ''),
(78, 422, 'FT07', 'ESTA EL FOOTER EL MISMO COLOR A LA IMAGEN COOPERATIVO?', '0', ''),
(79, 422, 'FT08', 'ESTA LAS REDES SOCIALES DEL CLIENTE CON ICONOS ESTANDAR EN EL FOOTER?', '0', ''),
(80, 422, 'FT09', 'ESTAN LAS REDES SOCIALES DEL CLIENTE / E2OUTLOOK LINKED EN EL FOOTER A SUS PAGINAS APROPIADAS?', '0', ''),
(81, 423, '', 'NOMBRE DE LA COMPA&Ntilde;IA', '0', ''),
(82, 423, '', 'AREA DE NEGOCIO', '0', ''),
(83, 423, '', 'DIRECCION', '0', ''),
(84, 423, '', 'E-MAIL', '0', ''),
(85, 423, '', 'TELEFONO', '0', ''),
(86, 423, '', 'HORARIO DE TRABAJO', '0', ''),
(87, 423, '', 'MANAGER', '0', ''),
(88, 423, '', 'AREA DE UBICACION', '0', ''),
(89, 423, '', 'CIUDAD', '0', ''),
(90, 423, '', 'A&Ntilde;O DE FUNDACION DE LA EMPRESA', '0', ''),
(91, 423, '', 'DOMINIO SELECCIONADO PARA NUEVA PAGINA', '0', ''),
(92, 423, '', 'SERVICIOS', '0', ''),
(93, 423, '', 'NOMBRE', '0', ''),
(94, 423, '', 'NUMERO DE TELEFONO', '0', ''),
(95, 423, '', 'E-MAIL', '0', ''),
(96, 423, '', 'IDIOMA DE LA PAGINA', '0', ''),
(97, 423, '', 'PAGINAS DE MENU', '0', ''),
(98, 423, '', 'SUBPAGINAS DE SUBMENU', '0', ''),
(99, 423, '', 'SLOGAN', '0', ''),
(100, 423, '', 'LOGO1', '0', ''),
(101, 423, '', 'COLORES DEL LOGO', '0', ''),
(102, 423, '', 'COLOR PAGINA', '0', ''),
(103, 423, '', 'HISTORIA', '0', ''),
(104, 423, '', 'BIBLIOGRAFIA', '0', ''),
(105, 423, '', 'FOTOS', '0', ''),
(106, 423, '', 'QUE QUIERE RESALTAR DE LA PAGINA', '0', ''),
(107, 423, '', 'PAGINAS DE REFERENCIA', '0', ''),
(108, 423, '', 'GALER&Iacute;A DE FOTOS', '0', ''),
(109, 423, '', 'CREACION DE REDES SOCIALES', '0', ''),
(110, 423, '', 'PUBLICACIONES A CARGAR EN LAS REDES SOCIALES', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `appprogresscateg`
--

CREATE TABLE `appprogresscateg` (
  `categid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `categname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appprogresscateg`
--

INSERT INTO `appprogresscateg` (`categid`, `appid`, `categname`) VALUES
(413, 40, 'SITE DATA'),
(414, 40, 'REDES SOCIALES'),
(415, 40, 'HEADER'),
(416, 40, 'MENU'),
(417, 40, 'SLIDERS'),
(418, 40, 'CUERPO TEXTO'),
(419, 40, 'FORMULARIOS'),
(420, 40, 'THEME OPTIONS'),
(421, 40, 'PLUGINS'),
(422, 40, 'FOOTER'),
(423, 40, 'CLIENT');

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `appid` int(11) NOT NULL,
  `appname` varchar(120) NOT NULL,
  `apppath` varchar(120) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`appid`, `appname`, `apppath`) VALUES
(40, 'MyApp', './app/MyApp');

-- --------------------------------------------------------

--
-- Table structure for table `appsusers`
--

CREATE TABLE `appsusers` (
  `appid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appsusers`
--

INSERT INTO `appsusers` (`appid`, `userid`) VALUES
(40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticketmessages`
--

CREATE TABLE `ticketmessages` (
  `messageid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `message` varchar(600) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `status` varchar(60) NOT NULL,
  `priority` varchar(60) NOT NULL,
  `category` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticketsstaff`
--

CREATE TABLE `ticketsstaff` (
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$lNjWg2gvz/lZsFv9d2XlpebYbkcoFxLWg9AzDmRPOHESOLfJ6h1au', 'shdkpr2008@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appconfig`
--
ALTER TABLE `appconfig`
  ADD KEY `appid` (`appid`);

--
-- Indexes for table `appprogress`
--
ALTER TABLE `appprogress`
  ADD PRIMARY KEY (`progressid`),
  ADD KEY `categid` (`categid`);

--
-- Indexes for table `appprogresscateg`
--
ALTER TABLE `appprogresscateg`
  ADD PRIMARY KEY (`categid`),
  ADD KEY `appid` (`appid`);

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`appid`);

--
-- Indexes for table `appsusers`
--
ALTER TABLE `appsusers`
  ADD KEY `appid` (`appid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `ticketmessages`
--
ALTER TABLE `ticketmessages`
  ADD PRIMARY KEY (`messageid`),
  ADD KEY `ticketid` (`ticketid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketid`),
  ADD KEY `appid` (`appid`);

--
-- Indexes for table `ticketsstaff`
--
ALTER TABLE `ticketsstaff`
  ADD KEY `ticketid` (`ticketid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appprogress`
--
ALTER TABLE `appprogress`
  MODIFY `progressid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `appprogresscateg`
--
ALTER TABLE `appprogresscateg`
  MODIFY `categid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `appid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ticketmessages`
--
ALTER TABLE `ticketmessages`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appconfig`
--
ALTER TABLE `appconfig`
  ADD CONSTRAINT `appconfig_ibfk_1` FOREIGN KEY (`appid`) REFERENCES `apps` (`appid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appprogress`
--
ALTER TABLE `appprogress`
  ADD CONSTRAINT `appprogress_ibfk_2` FOREIGN KEY (`categid`) REFERENCES `appprogresscateg` (`categid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appprogresscateg`
--
ALTER TABLE `appprogresscateg`
  ADD CONSTRAINT `appprogresscateg_ibfk_1` FOREIGN KEY (`appid`) REFERENCES `apps` (`appid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appsusers`
--
ALTER TABLE `appsusers`
  ADD CONSTRAINT `appsusers_app` FOREIGN KEY (`appid`) REFERENCES `apps` (`appid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appsusers_user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ticketmessages`
--
ALTER TABLE `ticketmessages`
  ADD CONSTRAINT `ticketmessages_ibfk_1` FOREIGN KEY (`ticketid`) REFERENCES `tickets` (`ticketid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticketmessages_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`appid`) REFERENCES `apps` (`appid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticketsstaff`
--
ALTER TABLE `ticketsstaff`
  ADD CONSTRAINT `ticketsstaff_ibfk_1` FOREIGN KEY (`ticketid`) REFERENCES `tickets` (`ticketid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticketsstaff_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
