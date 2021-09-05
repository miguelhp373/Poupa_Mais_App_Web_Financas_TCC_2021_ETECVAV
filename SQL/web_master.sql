-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2021 at 01:17 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventstableapplicartion`
--

CREATE TABLE `eventstableapplicartion` (
  `id` int(11) NOT NULL,
  `coduser` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eventstableapplicartion`
--


-- --------------------------------------------------------

--
-- Table structure for table `operationsapplication`
--

CREATE TABLE `operationsapplication` (
  `cod` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` float NOT NULL,
  `automatico` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userstableapplication`
--

CREATE TABLE `userstableapplication` (
  `cod` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `plano` varchar(100) NOT NULL,
  `pass_recover` int(11) DEFAULT NULL,
  `image_user` varchar(500) DEFAULT NULL,
  `saldo` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userstableapplication`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eventstableapplicartion`
--
ALTER TABLE `eventstableapplicartion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operationsapplication`
--
ALTER TABLE `operationsapplication`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `userstableapplication`
--
ALTER TABLE `userstableapplication`
  ADD PRIMARY KEY (`cod`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eventstableapplicartion`
--
ALTER TABLE `eventstableapplicartion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `operationsapplication`
--
ALTER TABLE `operationsapplication`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `userstableapplication`
--
ALTER TABLE `userstableapplication`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
