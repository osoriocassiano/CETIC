-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2016 at 07:10 AM
-- Server version: 5.5.20
-- PHP Version: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_antivirus`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_antivirus_pc`
--

CREATE TABLE IF NOT EXISTS `tbl_antivirus_pc` (
  `apc_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `apc_serial_antiv` varchar(36) NOT NULL,
  `apc_serial_pc` varchar(36) NOT NULL,
  `apc_data_registo` date NOT NULL,
  `apc_validade` int(11) NOT NULL,
  `apc_data_vencimento` date NOT NULL,
  `apc_marca_antiv` int(11) NOT NULL,
  `apc_responsavel_registo` int(11) NOT NULL,
  `apc_ultima_actualizacao` datetime NOT NULL,
  PRIMARY KEY (`apc_codigo`),
  KEY `FK_SERIAL_PC_idx` (`apc_serial_pc`),
  KEY `FK_MARCA_ANTIV_idx` (`apc_marca_antiv`),
  KEY `FK_RESPONSAVEL_REGISTO_idx` (`apc_responsavel_registo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_antivirus_pc`
--

INSERT INTO `tbl_antivirus_pc` (`apc_codigo`, `apc_serial_antiv`, `apc_serial_pc`, `apc_data_registo`, `apc_validade`, `apc_data_vencimento`, `apc_marca_antiv`, `apc_responsavel_registo`, `apc_ultima_actualizacao`) VALUES
(4, '11111-22222-33333-44444', '12345678', '2016-12-22', 8, '2016-12-30', 4, 2, '2016-12-22 03:14:11'),
(5, 'WUHFR-T89HG-8YGR5', 'drt34q78', '2016-12-22', 365, '2017-12-22', 4, 2, '2016-12-22 03:20:49'),
(6, '11111-22222-33333-44444', 'wet54kb8', '2016-12-08', 8, '2016-12-16', 4, 2, '2016-12-22 03:29:27'),
(7, '11111-22222-33333-44444', 'wet54kb8', '2016-12-22', 80, '2017-03-12', 4, 3, '2016-12-22 04:05:44'),
(8, 'JKMNG-DRAYG-OKLAF', 'mhjk5aft', '2016-12-22', 365, '2017-12-22', 4, 3, '2016-12-22 04:03:14');

--
-- Triggers `tbl_antivirus_pc`
--
DROP TRIGGER IF EXISTS `tr_insere_data_vencimento`;
DELIMITER //
CREATE TRIGGER `tr_insere_data_vencimento` BEFORE INSERT ON `tbl_antivirus_pc`
 FOR EACH ROW BEGIN
	SET NEW.apc_data_vencimento = DATE_ADD(NEW.apc_data_registo, INTERVAL NEW.apc_validade DAY);
SET NEW.apc_ultima_actualizacao = NOW();

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actualiza_data_vencimento`;
DELIMITER //
CREATE TRIGGER `tr_actualiza_data_vencimento` BEFORE UPDATE ON `tbl_antivirus_pc`
 FOR EACH ROW BEGIN
	SET NEW.apc_data_vencimento = DATE_ADD(NEW.apc_data_registo, INTERVAL NEW.apc_validade DAY);
SET NEW.apc_ultima_actualizacao = NOW();

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cargos`
--

CREATE TABLE IF NOT EXISTS `tbl_cargos` (
  `carg_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `carg_nome` varchar(70) NOT NULL,
  PRIMARY KEY (`carg_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_cargos`
--

INSERT INTO `tbl_cargos` (`carg_codigo`, `carg_nome`) VALUES
(1, 'Director'),
(2, 'Chefe do DES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dias_remanescentes`
--

CREATE TABLE IF NOT EXISTS `tbl_dias_remanescentes` (
  `dr_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `dr_nome` int(11) NOT NULL,
  PRIMARY KEY (`dr_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_dias_remanescentes`
--

INSERT INTO `tbl_dias_remanescentes` (`dr_codigo`, `dr_nome`) VALUES
(1, 10),
(2, 30),
(3, 60),
(5, 90);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_marca_antiv`
--

CREATE TABLE IF NOT EXISTS `tbl_marca_antiv` (
  `mar_ant_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `mar_ant_nome` varchar(60) NOT NULL,
  PRIMARY KEY (`mar_ant_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_marca_antiv`
--

INSERT INTO `tbl_marca_antiv` (`mar_ant_codigo`, `mar_ant_nome`) VALUES
(4, 'Kaspersky'),
(5, 'Norton');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tbl_tipo_usuario` (
  `tpu_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tpu_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`tpu_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_tipo_usuario`
--

INSERT INTO `tbl_tipo_usuario` (`tpu_codigo`, `tpu_nome`) VALUES
(1, 'Administrador'),
(2, 'Comum');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usuario_computador`
--

CREATE TABLE IF NOT EXISTS `tbl_usuario_computador` (
  `uc_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `uc_serial` varchar(36) NOT NULL,
  `uc_nome` varchar(50) DEFAULT NULL,
  `uc_apelido` varchar(50) DEFAULT NULL,
  `uc_data_registo` date NOT NULL,
  PRIMARY KEY (`uc_codigo`),
  KEY `uc_serial` (`uc_serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tbl_usuario_computador`
--

INSERT INTO `tbl_usuario_computador` (`uc_codigo`, `uc_serial`, `uc_nome`, `uc_apelido`, `uc_data_registo`) VALUES
(28, '12345678', 'Osorio', 'Malache', '2016-12-22'),
(29, 'wet54kb8', 'Leontinev', 'Malache', '2016-12-20'),
(30, 'drt34q78', 'Lucio', 'Chuck', '2016-12-22'),
(31, 'mhjk5aft', 'Mila', 'Mala', '2016-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usuario_sistema`
--

CREATE TABLE IF NOT EXISTS `tbl_usuario_sistema` (
  `us_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `us_nome` varchar(45) DEFAULT NULL,
  `us_apelido` varchar(45) DEFAULT NULL,
  `us_cargo` int(11) DEFAULT NULL,
  `us_tipo` int(11) DEFAULT NULL,
  `us_usuario` varchar(45) DEFAULT NULL,
  `us_senha` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`us_codigo`),
  KEY `FK_CARGO_idx` (`us_cargo`),
  KEY `FK_TIPO_USUARIO_idx` (`us_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_usuario_sistema`
--

INSERT INTO `tbl_usuario_sistema` (`us_codigo`, `us_nome`, `us_apelido`, `us_cargo`, `us_tipo`, `us_usuario`, `us_senha`) VALUES
(2, 'Osorio', 'Malache', 1, 1, 'osoriocassiano', '123'),
(3, 'Leo', 'Fatima', 1, 1, 'leofatima', '123');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_antivirus_pc`
--
ALTER TABLE `tbl_antivirus_pc`
  ADD CONSTRAINT `FK_MARCA_ANTIV` FOREIGN KEY (`apc_marca_antiv`) REFERENCES `tbl_marca_antiv` (`mar_ant_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RESPONSAVEL_REGISTO` FOREIGN KEY (`apc_responsavel_registo`) REFERENCES `tbl_usuario_sistema` (`us_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_SERIAL_PC` FOREIGN KEY (`apc_serial_pc`) REFERENCES `tbl_usuario_computador` (`uc_serial`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_usuario_sistema`
--
ALTER TABLE `tbl_usuario_sistema`
  ADD CONSTRAINT `FK_CARGO` FOREIGN KEY (`us_cargo`) REFERENCES `tbl_cargos` (`carg_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TIPO_USUARIO` FOREIGN KEY (`us_tipo`) REFERENCES `tbl_tipo_usuario` (`tpu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
