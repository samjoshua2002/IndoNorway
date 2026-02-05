-- 1. Create Data Table
CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `specification` varchar(255) DEFAULT NULL COMMENT 'Designation',
  `department` varchar(255) DEFAULT NULL,
  `college1` varchar(255) DEFAULT NULL,
  `college2` varchar(255) DEFAULT NULL,
  `college3` varchar(255) DEFAULT NULL,
  `college4` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL COMMENT 'Bio',
  `researchintest` text DEFAULT NULL COMMENT 'Research Interests',
  `contact` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Insert Data
-- Inserted individually to ensure clear mapping

-- Ethayaraja Mani
INSERT INTO `people` (`image`, `name`, `specification`, `department`, `college1`, `college2`, `college3`, `college4`, `about`, `researchintest`, `contact`) VALUES
('ethaya-crop.webp', 'Ethayaraja Mani', 'Professor', 'Department of Chemical Engineering', 'IIT Madras', '', '', '', 'Prof. Mani is a leading researcher and educator at IIT Madras, actively involved in the IndoNorway Connect initiative. His expertise and leadership have been instrumental in fostering collaboration and driving innovative research between IIT Madras and NTNU.', 'Molecular simulations, self-assembly, mathematical modeling', 'ethaya@iitm.ac.in');

-- Sulalit Bandyopadhyay
INSERT INTO `people` (`image`, `name`, `specification`, `department`, `college1`, `college2`, `college3`, `college4`, `about`, `researchintest`, `contact`) VALUES
('sulalit-crop.webp', 'Sulalit Bandyopadhyay', 'Associate Professor', 'Department of Chemical Engineering', 'Faculty of Natural Sciences', 'NTNU', '', '', 'Dr. Bandyopadhyay is a distinguished faculty member at NTNU, contributing significantly to the academic and research partnership with IIT Madras. His work supports the growth of interdisciplinary projects and student mobility under IndoNorway Connect.', 'Synthesis, characterization and functionalization of nanoparticles, development of nanoparticle-based hydrological tracers, drug delivery and modelling of nanosystems, recycling of lithium-ion batteries.', 'sulalit.bandyopadhyay@ntnu.no');

-- Ruth Catharina de Lange Davies
INSERT INTO `people` (`image`, `name`, `specification`, `department`, `college1`, `college2`, `college3`, `college4`, `about`, `researchintest`, `contact`) VALUES
('placeholder.png', 'Ruth Catharina de Lange Davies', 'Professor', 'Physics', 'NTNU', '', '', '', 'Lorem ipsum dolor sit amet', 'Biophysics, bio-nanotechnology, delivery of nanoparticles to tissue, advanced light microscopy.', 'mail@ntnu.no');

-- John de Mello
-- Parsed from: "Professor, Department of Chemistry, NTNU"
INSERT INTO `people` (`image`, `name`, `specification`, `department`, `college1`, `college2`, `college3`, `college4`, `about`, `researchintest`, `contact`) VALUES
('placeholder.png', 'John de Mello', 'Professor', 'Department of Chemistry', 'NTNU', '', '', '', '', 'His research is focused on controlled production processes for functional materials, and their application to photonic, electronic and bioelectronic devices. His group has been responsible for several innovations in nanoscience and flow chemistry, including the development of nanofabrication methods at the sub-5-nm level, the application of microfluidics to nanocrystal synthesis, and the first report of a fully autonomous self-optimizing flow reactor.', 'mail@ntnu.no');

-- Rita de Sousa Dias
-- Parsed from: "Associate Professor, Department of Physics, NTNU"
INSERT INTO `people` (`image`, `name`, `specification`, `department`, `college1`, `college2`, `college3`, `college4`, `about`, `researchintest`, `contact`) VALUES
('placeholder.png', 'Rita de Sousa Dias', 'Associate Professor', 'Department of Physics', 'NTNU', '', '', '', '', 'Control of DNA condensation using cationic surfactants and polyelectrolytes, adsorption and compaction of macromolecules onto model lipid membranes. MC simulations and studying nanoparticle - poly-acid interactions using Monte Carlo simulations.', 'mail@ntnu.no');

-- Edd Andres Blekkan
-- Parsed from: "Professor, Chemical Engineering, NTNU"
INSERT INTO `people` (`image`, `name`, `specification`, `department`, `college1`, `college2`, `college3`, `college4`, `about`, `researchintest`, `contact`) VALUES
('placeholder.png', 'Edd Andres Blekkan', 'Professor', 'Chemical Engineering', 'NTNU', '', '', '', '', 'Heterogeneous catalysis, natural gas conversion, petrochemistry, oil refining, biofuels and biorefineries, process technology', 'mail@ntnu.no');
