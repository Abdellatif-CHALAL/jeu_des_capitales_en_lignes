-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 12, 2019 at 11:46 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jeu_capitals`
--

-- --------------------------------------------------------

--
-- Table structure for table `partie`
--

CREATE TABLE `partie` (
  `id_quest` int(11) NOT NULL,
  `id_ut` int(11) NOT NULL,
  `score` int(20) NOT NULL,
  `numero_question` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id_question` int(11) NOT NULL,
  `id_quest` int(11) DEFAULT NULL,
  `quest` text CHARACTER SET utf8,
  `url_img` text,
  `url_pays` text NOT NULL,
  `url_flag` text NOT NULL,
  `nom_pays` varchar(255) CHARACTER SET utf8 NOT NULL,
  `surface_pays` int(255) NOT NULL,
  `desciption_pays` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id_question`, `id_quest`, `quest`, `url_img`, `url_pays`, `url_flag`, `nom_pays`, `surface_pays`, `desciption_pays`) VALUES
(1, 1, 'Quel est le pays qui a pour capitale Paris ? ', '../public/image/france.jpg', '../model/countries/data/fra.geo.json', '../model/countries/data/fra.svg', 'France', 643801, 'La France, pays de l\'Europe occidentale, compte des villes médiévales, des villages alpins et des plages. Paris, sa capitale, est célèbre pour ses maisons de mode, ses musées d\'art classique, dont celui du Louvre, et ses monuments comme la Tour Eiffel.'),
(2, 1, 'Quel est le pays qui a pour capitale Tananarive ?', '../public/image/madagascar.jpg', '../model/countries/data/mdg.geo.json', '../model/countries/data/mdg.svg', 'Madagascar', 587041, 'Madagascar est une ?le immense et un pays situ? au large de la c?te sud-est de l Afrique. Il abrite des milliers d  esp?ces animales end?miques comme les l?muriens, ainsi que des for?ts tropicales, des plages et des r?cifs.'),
(3, 1, 'Quel est le pays qui a pour capitale Mexico ?', '../public/image/mexique.jpg', '../model/countries/data/mex.geo.json', '../model/countries/data/mex.svg', 'Mexique', 1973000, 'Situé entre les états-Unis et l\'Amérique centrale, le Mexique est un pays réputé pour ses plages du Pacifique et du golfe du Mexique, ainsi que pour ses paysages variés - entre montagnes, déserts et jungles.'),
(4, 1, 'Quel est le pays qui a pour capitale Séoul ?', '../public/image/Coree.jpg', '../model/countries/data/kor.geo.json', '../model/countries/data/kor.svg', 'Corée du Sud', 100210, 'La Corée du Sud, un pays d\'Asie de l\'Est, occupe la moitié sud de la péninsule de Corée. Elle partage l\'une des frontières les plus fortement militarisées du monde avec la Corée du Nord.'),
(5, 1, 'Quel est le pays qui a pour capitale Ankara ?', '../public/image/turquie.jpg', '../model/countries/data/tur.geo.json', '../model/countries/data/tur.svg', 'Turquie', 783562, 'La Turquie s étend de l Europe de l Est à l Asie Mineure. Culturellement, elle est liée aux anciens empires grec, perse, romain, byzantin et ottoman. Istanbul, ville cosmopolite sur le détroit du Bosphore, abrite la célèbre église Sainte-Sophie, avec sa coupole aérienne et ses mosaïques chrétiennes, la gigantesque Mosquée bleue du XVIIe siècle et le palais de Topkapı (env. 1460), ancienne demeure des sultans. Ankara est la capitale de la Turquie moderne.'),
(6, 1, 'Quel est le pays qui a pour capitale Buenos Aires ?', '../public/image/argentine.jpg', '../model/countries/data/arg.geo.json', '../model/countries/data/arg.svg', 'Argentine', 2780000, 'L Argentine est un grand pays d Amérique du Sud au relief très varié où se côtoient les montagnes des Andes, les lacs glaciaires et la pampa, de grandes plaines de pâturage où paissent les célèbres bovins du pays. L Argentine est réputée pour le tango et la musique.');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE `questionnaire` (
  `id_quest` int(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questionnaire`
--

INSERT INTO `questionnaire` (`id_quest`, `description`) VALUES
(1, 'séléctionner sur la map le pays qui correspond à la capitale donnée ');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_ut` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`id_ut`,`id_quest`),
  ADD KEY `id_quest` (`id_quest`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_quest` (`id_quest`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`id_quest`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_ut`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `id_quest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`id_ut`) REFERENCES `utilisateur` (`id_ut`),
  ADD CONSTRAINT `partie_ibfk_2` FOREIGN KEY (`id_quest`) REFERENCES `questionnaire` (`id_quest`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_quest`) REFERENCES `questionnaire` (`id_quest`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
