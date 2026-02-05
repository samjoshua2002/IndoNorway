-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2026 at 02:06 PM
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
(3, 'IndoNorway Connect is a collaborative platform jointly developed by the Indian Institute of Technology Madras and the Norwegian University of Science and Technology to strengthen academic and research exchange between India and Norway. The initiative supports mutual goals in education, research, and internationalization, creating meaningful opportunities for students and researchers to engage in cross-border academic experiences. Since 2019, the Departments of Chemical Engineering at IIT Madras and NTNU have been working closely through research collaborations, mobility programmes, and bilateral projects. IndoNorway Connect builds on this foundation to offer semester exchanges, research stays, and summer internships, supported by monthly allowances and travel funding. Open to students at all academic levels, the program promotes active collaboration between various academic and research environments at both institutions. It encourages interdisciplinary learning and contributes to addressing global challenges in areas such as energy, environment, climate, health, and sustainable development. With a shared commitment to academic excellence and international cooperation, IndoNorway Connect brings together the strengths of IIT Madras and NTNU to create a platform for impactful learning, research, and cultural exchange.', '1770283616_about-placeholder-img.webp');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `image` varchar(2000) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `title` varchar(2000) NOT NULL,
  `event_date` varchar(500) DEFAULT NULL,
  `event_time` varchar(500) DEFAULT NULL,
  `venue` varchar(2000) DEFAULT NULL,
  `speaker` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `image`, `tag`, `title`, `event_date`, `event_time`, `venue`, `speaker`, `description`, `created_at`) VALUES
(1, 'pexels-edward-jenner-4031418-r02.webp', 'Announcement', 'List of students accepted for the Global Mobility Programme 2025', '12 SEPTEMBER 2025', NULL, NULL, NULL, NULL, '2026-01-21 14:37:55'),
(2, 'pexels-olly-3778603-r01.webp', 'SEMINAR', 'Sample news item contained on this page. Aliquam arcu velit, suscipit sed auctor a, facilisis eget augue.', '18 August 2025', '4:00 pm', 'NAC 101', 'Maecenas scelerisque dapibus dolor non tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam risus mi, tincidunt non lobortis nec, gravida vel erat. Nam quis turpis eu risus vulputate commodo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'Sed in est sed tellus facilisis tincidunt. Phasellus semper justo et mauris egestas ornare. Maecenas eu ex dolor. Aenean facilisis ut turpis sed semper. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare ut orci ac lobortis. Donec rutrum metus ut risus mattis laoreet. Fusce commodo diam eget egestas dictum. Vestibulum sed porta urna. Donec tincidunt vitae leo id bibendum. Morbi purus felis, molestie quis semper at, consequat vitae diam. Maecenas finibus tellus vitae lacus vehicula, sed molestie metus pellentesque. Maecenas mollis dui non arcu dapibus, bibendum iaculis quam interdum. Aliquam arcu velit, suscipit sed auctor a, facilisis eget augue. Curabitur et libero tincidunt, accumsan nisi non, semper lacus. Vivamus rhoncus dignissim consequat. Donec euismod, tortor id varius luctus, nisl enim tincidunt nibh, sed laoreet enim mi vitae purus. Ut leo nibh, commodo a augue ut, porta mollis velit. Mauris sollicitudin augue at faucibus pharetra. Maecenas scelerisque dapibus dolor non tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam risus mi, tincidunt non lobortis nec, gravida vel erat.', '2026-01-21 14:37:55'),
(3, NULL, 'RECENT PUBLICATION', '', NULL, NULL, NULL, NULL, 'Krishnamurthy, S., Sudhakar, S., & Mani, E. (2022). Kinetics of aggregation of amyloid β under different shearing conditions: Experimental and modelling analyses. Colloids and surfaces. B, Biointerfaces, 209 (Pt 1), 112156. <a href=\"https://doi.org/10.1016/j.colsurfb.2021.112156\" target=\"_blank\">doi.org/10.1016/j.colsurfb.2021.112156</a>', '2026-01-21 14:10:13'),
(4, NULL, 'Announcement', 'Applications open for Project Title (Last date: 13 July 2025)', '30 JUNE 2025', NULL, NULL, NULL, NULL, '2026-01-21 14:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `event_sections`
--

CREATE TABLE `event_sections` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `subtitle` varchar(2000) DEFAULT NULL,
  `sub_description` longtext DEFAULT NULL,
  `section_order` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'lander-slider-ntnu-trondheim.webp', 'IndoNorway Connect', 'Facilitating student mobility and joint projects across borders'),
(5, '1770283715_1770283529_placeholder-nanomaterials.webp', 'testing', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `hero_images`
--

CREATE TABLE `hero_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_images`
--

INSERT INTO `hero_images` (`id`, `image_path`, `alt_text`, `display_order`, `created_at`) VALUES
(1, '1767782209_col11.png', 'Medical Conference 1', 1, '2026-01-07 10:18:56'),
(2, '1767782209_col23.png', 'Medical Conference 2', 2, '2026-01-07 10:18:56'),
(3, '1767782226_col24.png', 'Medical Conference 3', 3, '2026-01-07 10:18:56'),
(4, '1767782209_col12.png', 'Medical Conference 4', 4, '2026-01-07 10:18:56'),
(5, '1767782209_col15.png', 'Medical Conference 5', 5, '2026-01-07 10:18:56'),
(6, '1767782226_col25.png', 'About Us', 6, '2026-01-07 10:18:56');

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

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` text NOT NULL,
  `Description` longtext DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `investigator` text DEFAULT NULL,
  `funding_partner` text DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `mobilites` text DEFAULT NULL,
  `publication` text DEFAULT NULL,
  `overview` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `category`, `tag`, `image`, `title`, `Description`, `date`, `investigator`, `funding_partner`, `budget`, `mobilites`, `publication`, `overview`, `created_at`) VALUES
(1, 'ongoing', 'Erasmus+ Global Mobility', NULL, 'Erasmus+ Global Mobility Programme', 'The overall goal with the current project is to establish lasting academic and research collaborations among the partners. This is  expected to be achieved by\n\na) educating students through mobility and  exchange stays,\nb) educating students and young researchers through  participation in ongoing research activities in the partner  institutions,\nc) preparing and giving joint teaching courses and summer  schools at the master and PhD levels, and\nd) increasing professional and personal skills and competencies of educational staff and PhD/Master’s students by gaining experiences abroad.\n\nThus, the current proposal is  expected to prioritize NTNU’s international engagement in areas of both  international mobility as well as internationalization of programs of  study.  We expect the mobilities to bolster research collaborations in key areas such as carbon capture and utilization (CCU), catalysis, nanoscience  and technology - nanomedicine in particular, material science, renewable energy, and other topics in chemical engineering.\n\nThis project is funded by the European Union under the Erasmus+ program.', '2020–2026', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 12:47:37'),
(2, 'ongoing', 'UTFORSK', 'placeholder-batteries.webp', 'Integrating research & education in sustainable chemical engineering for batteries & water treatment', 'The overall goal with the current project is to establish lasting academic and research collaborations among the partners. This is  expected to be achieved by\n\na) educating students through mobility and  exchange stays,\nb) educating students and young researchers through  participation in ongoing research activities in the partner  institutions,\nc) preparing and giving joint teaching courses and summer  schools at the master and PhD levels, and\nd) increasing professional and personal skills and competencies of educational staff and PhD/Master’s students by gaining experiences abroad.\n\nThus, the current proposal is  expected to prioritize NTNU’s international engagement in areas of both  international mobility as well as internationalization of programs of  study.  We expect the mobilities to bolster research collaborations in key areas such as carbon capture and utilization (CCU), catalysis, nanoscience  and technology - nanomedicine in particular, material science, renewable energy, and other topics in chemical engineering.\n\nThis project is funded by the European Union under the Erasmus+ program.', '01 Jan 2025 – 31 Dec 2028', 'Dr. Ethayaraja Mani (PI – India)<br />Dr. Sulalit Bandyopadhyay (PI – Norway)<br />Dr. Nirmalya Bachhar (Co-PI, IISc - India)<br />Dr. Swathi Sudhakar (Co-PI, IITM – India)<br />Dr. Jan Genzer (Co-PI, NCSU – USA)', 'HK-dir (Norway)', NULL, NULL, NULL, 'In this project, NTNU, IIT Madras and North Carolina State University (NCSU) will work together to:\r\n\r\n(i) achieve internationalization and benchmarking of NTNU’s unique master’s program in Chemical Engineering  and Biotechnology (MSCHEMBI) with focus on assessing student-active learning, research-based education and study program connectivity;\r\n(ii) redesign specific components of study programs at IIT Madras, NCSU and NTNU with focus on resource recovery from secondary resources, lean process streams and water treatment; and\r\n(iii) lay the groundwork for the establishment of a Joint Degree program in Chemical Engineering focusing on case-based teaching modules toward professional careers fostering a symbiotic relationship between practice and theory.\r\n\r\nThe project will achieve these objectives through dedicated semester exchanges, research stays and/or summer internships in addition to workshops, seminars, conferences and faculty visits.\r\n\r\nThis project is funded by the Norwegian Directorate for Higher Education and Skills (HK-Dir).\r\n', '2026-01-29 12:47:37'),
(3, 'ongoing', 'Indo-Norwegian Cooperation Programme in Higher Education and Research (INCP2)', 'placeholder-nanomaterials.webp', 'Fostering safety in use of advanced nanomaterials in health sector', NULL, '01 Nov 2024 – 31 Dec 2027', 'Dr. Ethayaraja Mani (PI – India)<br />Dr. Sulalit Bandyopadhyay (PI – Norway)<br />Dr. Nirmalya Bachhar (Co-PI, IISc - India)<br />Dr. Swathi Sudhakar (Co-PI, IITM – India)', 'UGC (India)<br />HK-dir (Norway)', 'INR 124.7 lakh', NULL, NULL, NULL, '2026-01-29 12:47:37'),
(4, 'ongoing', 'Joint Faculty Bilateral Mobility Project (JFBM)', NULL, 'Rational design of magnetically-responsive polymeric nanoparticles for drug delivery', NULL, '11 Feb 2025 – 31 Jan 2026', 'Dr. Ethayaraja Mani (PI – India)<br />Dr. Sulalit Bandyopadhyay (PI – Norway)', 'IITM (India)<br />NTNU (Norway)', 'INR 7.24 lakh', NULL, NULL, NULL, '2026-01-29 12:47:37'),
(5, 'completed', 'Nano-Syn-Sens', NULL, 'High-throughput synthesis of non-spherical plasmonic nanoparticles for applications in sensing', NULL, '05 Feb 2021 – 04 Aug 2024', 'Dr. Ethayaraja Mani (PI – India)<br />Dr. Sulalit Bandyopadhyay (PI – Norway)<br />Dr. VVR Sai (Co-PI – India)', 'DST (India)<br />RCN (Norway)', 'INR 41.73 lakh', 'Katharina Zürbes (PhD scholar, NTNU→IITM)<br />Soumodeep Biswas (PhD scholar, IITM→NTNU)<br />Ethayaraja Mani (PI, IITM→NTNU)<br />Sulalit Bandyopadhyay (PI, NTNU→IITM)', '<div class=\"pub-item\">Krishnamurthy, S., Sudhakar, S., &amp; Mani, E. (2022). Kinetics of aggregation of amyloid β under different shearing conditions... <a href=\"https://doi.org/10.1016/j.colsurfb.2021.112156\" target=\"_blank\" class=\"citation-doi\">doi.org/10.1016/j.colsurfb.2021.112156</a></div><div class=\"pub-item\">Kalipillai, P., &amp; Mani, E. (2021). Adsorption of the amyloid β40 monomer... <a href=\"https://doi.org/10.1039/d1cp01652k\" target=\"_blank\" class=\"citation-doi\">doi.org/10.1039/d1cp01652k</a></div><div class=\"pub-item\">Kalipillai, P., Raghuram, E., Bandyopadhyay, S., &amp; Mani, E. (2022).... <a href=\"https://doi.org/10.1039/d2cp02202h\" target=\"_blank\" class=\"citation-doi\">doi.org/10.1039/d2cp02202h</a></div><div class=\"pub-item\">Kalipillai, P., Raghuram, E., &amp; Mani, E. (2023)... <a href=\"https://doi.org/10.1039/d2sm01581a\" target=\"_blank\" class=\"citation-doi\">doi.org/10.1039/d2sm01581a</a></div>', NULL, '2026-01-29 12:47:37'),
(6, 'upcoming', 'Category', 'placeholder-sample.webp', 'Sample project card with image placeholder 1', NULL, 'Date', 'To be updated', 'To be updated', 'To be updated', 'To be updated', 'To be updated', NULL, '2026-01-29 12:47:37'),
(7, 'ongoing', 'UTFORSK-Test', 'placeholder-batteries.webp', 'Integrating research & education ', 'The overall goal with the current project is to establish lasting academic and research collaborations among the partners. This is  expected to be achieved by\r\n\r\na) educating students through mobility and  exchange stays,\r\nb) educating students and young researchers through  participation in ongoing research activities in the partner  institutions,\r\nc) preparing and giving joint teaching courses and summer  schools at the master and PhD levels, and\r\nd) increasing professional and personal skills and competencies of educational staff and PhD/Master’s students by gaining experiences abroad.\r\n\r\nThus, the current proposal is  expected to prioritize NTNU’s international engagement in areas of both  international mobility as well as internationalization of programs of  study.  We expect the mobilities to bolster research collaborations in key areas such as carbon capture and utilization (CCU), catalysis, nanoscience  and technology - nanomedicine in particular, material science, renewable energy, and other topics in chemical engineering.\r\n\r\nThis project is funded by the European Union under the Erasmus+ program.', '01 Jan 2025 – 31 Dec 2028', 'Dr. Ethayaraja Mani (PI – India)<br />Dr. Sulalit Bandyopadhyay (PI – Norway)<br />Dr. Nirmalya Bachhar (Co-PI, IISc - India)<br />Dr. Swathi Sudhakar (Co-PI, IITM – India)<br />Dr. Jan Genzer (Co-PI, NCSU – USA)', 'HK-dir (Norway)', NULL, NULL, NULL, 'In this project, NTNU, IIT Madras and North Carolina State University (NCSU) will work together to:\r\n\r\n(i) achieve internationalization and benchmarking of NTNU’s unique master’s program in Chemical Engineering  and Biotechnology (MSCHEMBI) with focus on assessing student-active learning, research-based education and study program connectivity;\r\n(ii) redesign specific components of study programs at IIT Madras, NCSU and NTNU with focus on resource recovery from secondary resources, lean process streams and water treatment; and\r\n(iii) lay the groundwork for the establishment of a Joint Degree program in Chemical Engineering focusing on case-based teaching modules toward professional careers fostering a symbiotic relationship between practice and theory.\r\n\r\nThe project will achieve these objectives through dedicated semester exchanges, research stays and/or summer internships in addition to workshops, seminars, conferences and faculty visits.\r\n\r\nThis project is funded by the Norwegian Directorate for Higher Education and Skills (HK-Dir).\r\n', '2026-01-29 12:47:37');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin-indo', 'admin123');

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
-- Indexes for table `hero_images`
--
ALTER TABLE `hero_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_sections`
--
ALTER TABLE `event_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `herobanner`
--
ALTER TABLE `herobanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hero_images`
--
ALTER TABLE `hero_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
