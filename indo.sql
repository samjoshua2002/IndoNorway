-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 05:51 PM
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
-- Database: `indo`
--

-- --------------------------------------------------------

--
-- Table structure for table `description`
--

CREATE TABLE `description` (
  `id` int(11) NOT NULL,
  `about` mediumtext DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `description`
--

INSERT INTO `description` (`id`, `about`, `image`) VALUES
(3, 'IndoNorway Connect is a collaborative platform jointly developed by the Indian Institute of Technology Madras and the Norwegian University of Science and Technology to strengthen academic and research exchange between India and Norway. The initiative supports mutual goals in education, research, and internationalization, creating meaningful opportunities for students and researchers to engage in cross-border academic experiences. Since 2019, the Departments of Chemical Engineering at IIT Madras and NTNU have been working closely through research collaborations, mobility programmes, and bilateral projects. IndoNorway Connect builds on this foundation to offer semester exchanges, research stays, and summer internships, supported by monthly allowances and travel funding. Open to students at all academic levels, the program promotes active collaboration between various academic and research environments at both institutions. It encourages interdisciplinary learning and contributes to addressing global challenges in areas such as energy, environment, climate, health, and sustainable development. With a shared commitment to academic excellence and international cooperation, IndoNorway Connect brings together the strengths of IIT Madras and NTNU to create a platform for impactful learning, research, and cultural exchange.', 'about-placeholder-img.webp');

-- --------------------------------------------------------

--
-- Table structure for table `herobanner`
--

CREATE TABLE `herobanner` (
  `id` int(11) NOT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `herobanner`
--

INSERT INTO `herobanner` (`id`, `image`, `title`, `description`) VALUES
(1, 'lander-slider-gc.webp', 'IndoNorway Connect', 'A collaborative platform to strengthen academic and research exchange between India and Norway'),
(2, 'lander-slider-ntnu-trondheim.webp', 'IndoNorway Connect', 'Facilitating student mobility and joint projects across borders');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `image` varchar(10000) DEFAULT NULL,
  `title` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `image`, `title`) VALUES
(1, 'partner-iitm.svg', 'Indian Institute of Technology Madras'),
(2, 'partner-ntnu.svg', 'Norwegian University of Science and Technology');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `herobanner`
--
ALTER TABLE `herobanner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `herobanner`
--
ALTER TABLE `herobanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
