-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 21, 2026 at 06:47 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.26

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
  `id` int NOT NULL,
  `about` mediumtext COLLATE utf8mb4_general_ci,
  `image` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `description`
--

INSERT INTO `description` (`id`, `about`, `image`) VALUES
(3, 'IndoNorway Connect is a collaborative platform jointly developed by the Indian Institute of Technology Madras and the Norwegian University of Science and Technology to strengthen academic and research exchange between India and Norway. The initiative supports mutual goals in education, research, and internationalization, creating meaningful opportunities for students and researchers to engage in cross-border academic experiences. Since 2019, the Departments of Chemical Engineering at IIT Madras and NTNU have been working closely through research collaborations, mobility programmes, and bilateral projects. IndoNorway Connect builds on this foundation to offer semester exchanges, research stays, and summer internships, supported by monthly allowances and travel funding. Open to students at all academic levels, the program promotes active collaboration between various academic and research environments at both institutions. It encourages interdisciplinary learning and contributes to addressing global challenges in areas such as energy, environment, climate, health, and sustainable development. With a shared commitment to academic excellence and international cooperation, IndoNorway Connect brings together the strengths of IIT Madras and NTNU to create a platform for impactful learning, research, and cultural exchange.', 'about-placeholder-img.webp');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `image` varchar(2000) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `title` varchar(2000) NOT NULL,
  `event_date` varchar(500) DEFAULT NULL,
  `event_time` varchar(500) DEFAULT NULL,
  `venue` varchar(2000) DEFAULT NULL,
  `speaker` longtext,
  `description` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `image`, `tag`, `title`, `event_date`, `event_time`, `venue`, `speaker`, `description`, `created_at`) VALUES
(1, 'pexels-edward-jenner-4031418-r02.webp', NULL, 'List of students accepted for the Global Mobility Programme 2025', '12 SEPTEMBER 2025', NULL, NULL, NULL, NULL, '2026-01-21 14:37:55'),
(2, 'pexels-olly-3778603-r01.webp', 'SEMINAR', 'Sample news item contained on this page. Aliquam arcu velit, suscipit sed auctor a, facilisis eget augue.', '18 August 2025', '4:00 pm', 'NAC 101', 'Maecenas scelerisque dapibus dolor non tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam risus mi, tincidunt non lobortis nec, gravida vel erat. Nam quis turpis eu risus vulputate commodo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'Sed in est sed tellus facilisis tincidunt. Phasellus semper justo et mauris egestas ornare. Maecenas eu ex dolor. Aenean facilisis ut turpis sed semper. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare ut orci ac lobortis. Donec rutrum metus ut risus mattis laoreet. Fusce commodo diam eget egestas dictum. Vestibulum sed porta urna. Donec tincidunt vitae leo id bibendum. Morbi purus felis, molestie quis semper at, consequat vitae diam. Maecenas finibus tellus vitae lacus vehicula, sed molestie metus pellentesque. Maecenas mollis dui non arcu dapibus, bibendum iaculis quam interdum. Aliquam arcu velit, suscipit sed auctor a, facilisis eget augue. Curabitur et libero tincidunt, accumsan nisi non, semper lacus. Vivamus rhoncus dignissim consequat. Donec euismod, tortor id varius luctus, nisl enim tincidunt nibh, sed laoreet enim mi vitae purus. Ut leo nibh, commodo a augue ut, porta mollis velit. Mauris sollicitudin augue at faucibus pharetra. Maecenas scelerisque dapibus dolor non tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam risus mi, tincidunt non lobortis nec, gravida vel erat.', '2026-01-21 14:37:55'),
(3, NULL, 'RECENT PUBLICATION', '', NULL, NULL, NULL, NULL, 'Krishnamurthy, S., Sudhakar, S., & Mani, E. (2022). Kinetics of aggregation of amyloid β under different shearing conditions: Experimental and modelling analyses. Colloids and surfaces. B, Biointerfaces, 209 (Pt 1), 112156. <a href=\"https://doi.org/10.1016/j.colsurfb.2021.112156\" target=\"_blank\">doi.org/10.1016/j.colsurfb.2021.112156</a>', '2026-01-21 14:10:13'),
(4, NULL, NULL, 'Applications open for Project Title (Last date: 13 July 2025)', '30 JUNE 2025', NULL, NULL, NULL, NULL, '2026-01-21 14:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `event_sections`
--

CREATE TABLE `event_sections` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `subtitle` varchar(2000) DEFAULT NULL,
  `sub_description` longtext,
  `section_order` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_sections`
--

INSERT INTO `event_sections` (`id`, `event_id`, `subtitle`, `sub_description`, `section_order`) VALUES
(1, 2, 'Important Steps', 'Sed quis purus rhoncus, consectetur lectus id, auctor lectus. Aenean placerat lorem turpis, quis iaculis justo mattis ac. Nullam diam neque, lacinia quis mauris a, sagittis fermentum sapien. Integer eu placerat nisl. Nunc eu ligula at lectus vestibulum consectetur. Sed ultricies tempor elit et sodales. Nullam efficitur lectus sit amet fermentum iaculis.\r\nSuspendisse potenti. Sed mollis posuere dui. Nullam vitae pretium libero, ac eleifend nunc. Vestibulum semper iaculis erat. Sed dignissim ullamcorper urna. Aliquam gravida, sem non viverra gravida, ligula tortor rutrum magna, ac facilisis sem nibh nec enim. Aliquam iaculis, lectus in iaculis imperdiet, massa diam tincidunt mauris, at consectetur dui tortor eu velit. Morbi ut sem placerat, dapibus neque egestas, volutpat elit. Donec nec risus eu neque auctor pellentesque. Donec viverra in ante at pulvinar. In sed venenatis magna. Quisque pellentesque, nibh eu mattis porttitor, lectus felis ultrices dolor, in iaculis nunc ligula sit amet odio. Donec dictum magna vel libero sodales, eu maximus augue mattis. Phasellus at velit vehicula, auctor lorem et, viverra sem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut rhoncus suscipit arcu sit amet fringilla.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `herobanner`
--

CREATE TABLE `herobanner` (
  `id` int NOT NULL,
  `image` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL
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
  `id` int NOT NULL,
  `image` varchar(10000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL
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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_sections`
--
ALTER TABLE `event_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_sections`
--
ALTER TABLE `event_sections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `herobanner`
--
ALTER TABLE `herobanner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_sections`
--
ALTER TABLE `event_sections`
  ADD CONSTRAINT `event_sections_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
