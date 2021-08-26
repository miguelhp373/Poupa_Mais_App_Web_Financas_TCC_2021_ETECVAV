-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2021 at 11:23 PM
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
  `image_user` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userstableapplication`
--

INSERT INTO `userstableapplication` (`cod`, `Nome`, `email`, `cpf`, `telefone`, `senha`, `plano`, `pass_recover`, `image_user`) VALUES
(4, 'Miguel Henrique', 'miguelhp373@gmail.com', '482.312.708-09', '(11)94254-2038', '$2y$10$gQmlCjdIU1z/KoDizJBpeuPTUBJ2VERYvepiR3sYs9/YQFyGe.IYq', 'plano01', NULL, '/source/assets/avatar_profiles/image_9.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userstableapplication`
--
ALTER TABLE `userstableapplication`
  ADD PRIMARY KEY (`cod`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userstableapplication`
--
ALTER TABLE `userstableapplication`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
