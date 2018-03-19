-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Mar-2018 às 22:45
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rodoviaria`
--
CREATE DATABASE IF NOT EXISTS `db_rodoviaria` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_rodoviaria`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `dt_ida` date NOT NULL,
  `hr_ida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `horarios`
--

INSERT INTO `horarios` (`id`, `dt_ida`, `hr_ida`) VALUES
(7, '2018-03-10', '18:00:00'),
(8, '2018-03-10', '08:00:00'),
(9, '2018-03-10', '13:30:00'),
(11, '2018-03-06', '12:00:00'),
(12, '2018-03-19', '06:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `passagens`
--

CREATE TABLE `passagens` (
  `id` int(11) NOT NULL,
  `id_rota` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `dt_nascimento` date NOT NULL,
  `num_poltrona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `passagens`
--

INSERT INTO `passagens` (`id`, `id_rota`, `nome`, `cpf`, `dt_nascimento`, `num_poltrona`) VALUES
(1, 8, 'Joséfredo Joestar', '11111111111', '2000-03-04', 42),
(2, 8, 'Maria Francisca', '87290466020', '1980-04-05', 21),
(3, 8, 'Josénildo', '29226233004', '1990-02-04', 1),
(4, 8, 'Felipe Soares', '91542767059', '1998-01-10', 2),
(5, 8, 'Carla Silva', '75605296078', '1998-03-05', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rodoviarias`
--

CREATE TABLE `rodoviarias` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `rodoviarias`
--

INSERT INTO `rodoviarias` (`id`, `estado`, `cidade`) VALUES
(1, 'CE', 'Fortaleza'),
(2, 'CE', 'Sobral'),
(3, 'CE', 'Aracaú'),
(4, 'CE', 'Banabuiú'),
(5, 'CE', 'Quixeramobim'),
(6, 'CE', 'Quixadá'),
(7, 'SP', 'São Paulo'),
(8, 'RJ', 'Rio de Janeiro'),
(9, 'PR', 'Recife'),
(10, 'AM', 'Manaus');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

CREATE TABLE `rotas` (
  `id` int(11) NOT NULL,
  `id_rodoviaria_origem` int(11) NOT NULL,
  `id_rodoviaria_destino` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `preco` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `rotas`
--

INSERT INTO `rotas` (`id`, `id_rodoviaria_origem`, `id_rodoviaria_destino`, `id_horario`, `preco`) VALUES
(8, 1, 2, 9, 100),
(10, 1, 7, 8, 330),
(14, 2, 6, 8, 100),
(17, 9, 5, 9, 250),
(18, 7, 9, 8, 250),
(20, 2, 1, 11, 90),
(22, 10, 5, 8, 100),
(23, 7, 8, 12, 90),
(24, 1, 4, 11, 95);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passagens`
--
ALTER TABLE `passagens`
  ADD PRIMARY KEY (`id`,`id_rota`),
  ADD KEY `fk_passagens_rotas1_idx` (`id_rota`);

--
-- Indexes for table `rodoviarias`
--
ALTER TABLE `rodoviarias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rotas`
--
ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id`,`id_rodoviaria_origem`,`id_rodoviaria_destino`,`id_horario`),
  ADD KEY `fk_rota_rodoviaria_idx` (`id_rodoviaria_origem`),
  ADD KEY `fk_rota_rodoviaria1_idx` (`id_rodoviaria_destino`),
  ADD KEY `fk_rota_horario1_idx` (`id_horario`),
  ADD KEY `id_rodoviaria_origem` (`id_rodoviaria_origem`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `passagens`
--
ALTER TABLE `passagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rodoviarias`
--
ALTER TABLE `rodoviarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `passagens`
--
ALTER TABLE `passagens`
  ADD CONSTRAINT `fk_passagens_rotas1` FOREIGN KEY (`id_rota`) REFERENCES `rotas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `rotas`
--
ALTER TABLE `rotas`
  ADD CONSTRAINT `fk_rota_horario1` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rota_rodoviaria` FOREIGN KEY (`id_rodoviaria_origem`) REFERENCES `rodoviarias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rota_rodoviaria1` FOREIGN KEY (`id_rodoviaria_destino`) REFERENCES `rodoviarias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
