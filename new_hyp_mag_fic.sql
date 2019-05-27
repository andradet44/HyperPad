-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 27 mai 2019 à 19:03
-- Version du serveur :  10.1.33-MariaDB
-- Version de PHP :  7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `new_hyp_mag_fic`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `id_magasin`) VALUES
(0, 'adminfic', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 0),
(1, 'adminavn', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 1),
(2, 'adminsad', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 2),
(3, 'adminclu', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 3),
(4, 'adminbam', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 4),
(5, 'adminsdro', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 5),
(6, 'admindesc', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 6),
(7, 'admingc', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 7),
(8, 'adminana', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', 8);

-- --------------------------------------------------------

--
-- Structure de la table `defaillances_radiopads`
--

CREATE TABLE `defaillances_radiopads` (
  `id` int(11) NOT NULL,
  `id_radiopad` int(11) DEFAULT NULL,
  `panne` varchar(150) NOT NULL,
  `date_panne` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `magasins`
--

CREATE TABLE `magasins` (
  `id_magasin` int(11) NOT NULL,
  `departement` varchar(30) NOT NULL,
  `alias` varchar(5) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `enseigne` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `magasins`
--

INSERT INTO `magasins` (`id_magasin`, `departement`, `alias`, `nom`, `enseigne`) VALUES
(0, 'GUYANE', 'FIC', 'FICOBAM', 'Carrefour-Matoury'),
(1, 'GUYANE', 'AVN', 'AVENIR', 'Carrefour-Contact Remire'),
(2, 'MARTINIQUE', 'SAD', 'SADECO', 'Carrefour-Dillon'),
(3, 'MARTINIQUE', 'CLU', 'HCLUNY', 'Carrefour-Cluny'),
(4, 'MARTINIQUE', 'BAM', 'BAMELI', 'Carrefour-Genipa'),
(5, 'MARTINIQUE', 'SDRO', 'SDROHY', 'Euromarché Robert Oceanis'),
(6, 'GUADELOUPE', 'DESC', 'DESTRE', 'Carrefour-Destreland'),
(7, 'GUADELOUPE', 'GC', 'GRCAMP', 'Carrefour-Contact Grand-Camp'),
(8, 'GUADELOUPE', 'ANA', 'ANABAM', 'Carrefour-Contact St-François');

-- --------------------------------------------------------

--
-- Structure de la table `pannes_radiopads`
--

CREATE TABLE `pannes_radiopads` (
  `id` int(11) NOT NULL,
  `id_radiopad` int(11) DEFAULT NULL,
  `panne` varchar(150) NOT NULL,
  `date_panne` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_reparation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `id_magasin` int(11) NOT NULL,
  `ip_client` varchar(15) NOT NULL,
  `nom_societe` varchar(30) NOT NULL,
  `departement` varchar(30) NOT NULL,
  `alias_magasin` varchar(10) NOT NULL,
  `mail_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `prets`
--

CREATE TABLE `prets` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_radiopad` int(11) NOT NULL,
  `date_pret` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_retour` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_magasin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `radiopads`
--

CREATE TABLE `radiopads` (
  `id` int(11) NOT NULL,
  `id_radio` int(11) NOT NULL,
  `sn` bigint(20) NOT NULL,
  `modele` varchar(15) NOT NULL,
  `etat` varchar(15) NOT NULL,
  `radiopad` varchar(10) NOT NULL,
  `affectation` varchar(15) NOT NULL,
  `mac` varchar(17) NOT NULL,
  `date_achat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `batterie` date NOT NULL,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `radiopads`
--

INSERT INTO `radiopads` (`id`, `id_radio`, `sn`, `modele`, `etat`, `radiopad`, `affectation`, `mac`, `date_achat`, `batterie`, `id_magasin`) VALUES
(1, 101, 10170521101734, 'MC3090', 'REPARER', 'FIC101', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(2, 102, 11015521102119, 'MC3090', 'PROD', 'FIC102', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(3, 103, 11015521102085, 'MC3090', 'REBUS', 'FIC103', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(4, 104, 6294520100046, 'MC3090', 'REPARATION', 'FIC104', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(5, 105, 11015521102072, 'MC3090', 'REBUS', 'FIC105', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(6, 106, 11041521100779, 'MC3090', 'REPARATION', 'FIC106', '', '00:15:70:24:7D:4E', '0000-00-00 00:00:00', '0000-00-00', 0),
(7, 107, 10239521101118, 'MC3090', 'REBUS', 'FIC107', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(8, 108, 10261521100840, 'MC3090', 'REPARATION', 'FIC108', '', '00:23:68:A7:9C:63', '0000-00-00 00:00:00', '0000-00-00', 0),
(9, 109, 10170521101095, 'MC3090', 'PROD', 'FIC109', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(10, 110, 11041521100765, 'MC3090', 'REBUS', 'FIC110', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(11, 111, 11015521102128, 'MC3090', 'STOCK', 'FIC111', '', '00:23:68:B7:40:AF', '0000-00-00 00:00:00', '0000-00-00', 0),
(12, 112, 11041521100008, 'MC3090', 'REPARER', 'FIC112', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(13, 113, 11015521102191, 'MC3090', 'REPARER', 'FIC113', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(14, 114, 10154521103746, 'MC3090', 'STOCK', 'FIC114', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(15, 115, 10170521101619, 'MC3090', 'PROD', 'FIC115', '', '00:23:68:A4:9E:25', '0000-00-00 00:00:00', '0000-00-00', 0),
(16, 116, 11041521100242, 'MC3090', 'REPARER', 'FIC116', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(17, 117, 11041521100456, 'MC3090', 'PROD', 'FIC117', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(18, 118, 11041521100022, 'MC3090', 'PROD', 'FIC118', '', '00:23:68:B7:3E:B3', '0000-00-00 00:00:00', '0000-00-00', 0),
(19, 119, 10154521103917, 'MC3090', 'REBUS', 'FIC119', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(20, 120, 10154521104641, 'MC3090', 'PROD', 'FIC120', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(21, 121, 11015521102088, 'MC3090', 'STOCK', 'FIC121', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(22, 122, 11041521100334, 'MC3090', 'REBUS', 'FIC122', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(23, 123, 6322520101534, 'MC3090', 'REPARATION', 'FIC123', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(24, 124, 10111521101468, 'MC3090', 'REBUS', 'FIC124', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(25, 125, 11015521102096, 'MC3090', 'REBUS', 'FIC125', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(26, 126, 11041521100103, 'MC3090', 'REBUS', 'FIC126', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(27, 127, 6293520100757, 'MC3090', 'REBUS', 'FIC127', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(28, 128, 10037521101013, 'MC3090', 'REPARER', 'FIC149', '', '00:15:70:36:5B:25', '0000-00-00 00:00:00', '0000-00-00', 0),
(29, 129, 11041521100107, 'MC3090', 'REBUS', 'FIC129', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(30, 130, 11041521100577, 'MC3090', 'REBUS', 'FIC130', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(31, 131, 11015521102126, 'MC3090', 'PROD', 'FIC131', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(32, 132, 11041521100039, 'MC3090', 'REBUS', 'FIC132', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(33, 133, 11041521100354, 'MC3090', 'STOCK', 'FIC133', '', '00:23:68B7:47:2B', '0000-00-00 00:00:00', '0000-00-00', 0),
(34, 134, 11041521100732, 'MC3090', 'REBUS', 'FIC134', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(35, 135, 11015521102038, 'MC3090', 'REBUS', 'FIC135', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(36, 136, 11041521100737, 'MC3090', 'STOCK', 'FIC136', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(37, 137, 11015521102061, 'MC3090', 'STOCK', 'FIC137', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(38, 138, 7394, 'MC3090', 'REPARER', 'FIC138', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(39, 139, 11015521102146, 'MC3090', 'PROD', 'FIC139', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(40, 140, 11041521100109, 'MC3090', 'PROD', 'FIC140', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(41, 141, 11041521100461, 'MC3090', 'STOCK', 'FIC141', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(42, 142, 11015521102068, 'MC3090', 'REBUS', 'FIC142', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(43, 143, 11041521100035, 'MC3090', 'PROD', 'FIC143', '', '00:23:68:B7:44:E0', '0000-00-00 00:00:00', '0000-00-00', 0),
(44, 144, 11041521100744, 'MC3090', 'STOCK', 'FIC144', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(45, 145, 11041521100777, 'MC3090', 'STOCK', 'FIC145', '', '00:23:68:B7:3E:03', '0000-00-00 00:00:00', '0000-00-00', 0),
(46, 146, 11041521100189, 'MC3090', 'PROD', 'FIC146', '', '00:23:68:B7:40:18', '0000-00-00 00:00:00', '0000-00-00', 0),
(47, 147, 11015521102124, 'MC3090', 'STOCK', 'FIC147', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(48, 148, 11041521100767, 'MC3090', 'REBUS', 'FIC148', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(49, 149, 10037521101013, 'MC3090', 'REPARER', 'FIC149', '', '00:15:70:36:5B:25', '0000-00-00 00:00:00', '0000-00-00', 0),
(50, 150, 11041521100519, 'MC3090', 'STOCK', 'FIC150', '', '00:23:68:B7:47:33', '0000-00-00 00:00:00', '0000-00-00', 0),
(51, 151, 14191, 'MC3090', 'STOCK', 'FIC151', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(52, 152, 11041521100122, 'MC3090', 'REBUS', 'FIC152', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(53, 153, 6293520100744, 'MC3090', 'PROD', 'FIC153', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(54, 154, 11015521102113, 'MC3090', 'REPARER', 'FIC154', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(55, 155, 11041521100082, 'MC3090', 'REPARER', 'FIC155', '', '00:15:70:A3:A0:E8', '0000-00-00 00:00:00', '0000-00-00', 0),
(56, 156, 11041521100102, 'MC3090', 'STOCK', 'FIC156', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(57, 157, 15271523020293, 'MC3190', 'PROD', 'FIC157', '', '40:83:DE:8B:EF:46', '0000-00-00 00:00:00', '0000-00-00', 0),
(58, 158, 15271523020318, 'MC3190', 'PROD', 'FIC158', '', '40:83:DE:8B:EF:25', '0000-00-00 00:00:00', '0000-00-00', 0),
(59, 159, 15271523020316, 'MC3190', 'REPARER', 'FIC159', '', '40:83:DE:8B:ED:28', '0000-00-00 00:00:00', '0000-00-00', 0),
(60, 160, 15271523020303, 'MC3190', 'PROD', 'FIC160', '', '40:83:DE:8B:EF:6B', '0000-00-00 00:00:00', '0000-00-00', 0),
(61, 161, 15271523020284, 'MC3190', 'PROD', 'FIC161', '', '40:83:DE:8B:ED:25', '0000-00-00 00:00:00', '0000-00-00', 0),
(62, 162, 15271523024336, 'MC3190', 'PROD', 'FIC162', '', '40:83:DE:8C:05:7D', '0000-00-00 00:00:00', '0000-00-00', 0),
(63, 163, 15271523024531, 'MC3190', 'PROD', 'FIC163', '', '40:83:DE:8B:ED:1F', '0000-00-00 00:00:00', '0000-00-00', 0),
(64, 164, 15271523020315, 'MC3190', 'PROD', 'FIC164', '', '40:83:DE:8B:EE:77', '0000-00-00 00:00:00', '0000-00-00', 0),
(65, 165, 15127523021397, 'MC32N0', 'PROD', 'FIC165', '', '40:83:DE:83:7B:69', '2016-06-13 03:00:00', '0000-00-00', 0),
(66, 166, 11041521100039, 'MC32N0', 'REBUS', 'FIC132', '', '', '0000-00-00 00:00:00', '0000-00-00', 0),
(67, 167, 15155523021452, 'MC32N0', 'PROD', 'FIC167', '', '40:83:DE:84:40:D7', '2016-07-09 03:00:00', '0000-00-00', 0),
(68, 168, 15127523023402, 'MC32N0', 'REPARER', 'FIC168', '', '40:83:DE:83:7A:BE', '2016-07-09 03:00:00', '0000-00-00', 0),
(69, 169, 15127523023387, 'MC32N0', 'PROD', 'FIC169', '', '40:83:DE:83:7B:E1', '2016-07-09 03:00:00', '0000-00-00', 0),
(70, 170, 15114523021093, 'MC32N0', 'PROD', 'FIC170', '', '40:83:DE:83:B6:C1', '2016-07-09 03:00:00', '0000-00-00', 0),
(71, 171, 15114523021004, 'MC32N0', 'REPARER', 'FIC171', '', '40:83:DE:84:3D:ED', '2016-07-09 03:00:00', '0000-00-00', 0),
(72, 172, 15114523021003, 'MC32N0', 'STOCK', 'FIC172', '', '40:83:DE:83:9A:58', '2016-07-09 03:00:00', '0000-00-00', 0),
(73, 173, 15108523021305, 'MC32N0', 'PROD', 'FIC173', '', '40:83:DE:83:54:AE', '2016-07-09 03:00:00', '0000-00-00', 0),
(74, 174, 15155523022161, 'MC32N0', 'STOCK', 'FIC174', '', '40:83:DE:84:3D:ED', '2016-07-09 03:00:00', '0000-00-00', 0),
(75, 175, 17068523022636, 'MC32N0', 'STOCK', 'FIC175', '', '', '2018-05-29 03:00:00', '0000-00-00', 0),
(76, 176, 17083523020865, 'MC32N0', 'STOCK', 'FIC176', '', '40:83:DE:EF:06:2F', '2018-05-29 03:00:00', '0000-00-00', 0),
(77, 177, 17083523020659, 'MC32N0', 'STOCK', 'FIC177', '', '40:83:DE:EF:07:56', '2018-05-29 03:00:00', '0000-00-00', 0),
(78, 178, 17083523020689, 'MC32N0', 'STOCK', 'FIC178', '', '40:83:DE:EF:00:F2', '2018-05-29 03:00:00', '0000-00-00', 0),
(79, 179, 17068523021540, 'MC32N0', 'PROD', 'FIC179', '', '40:83:DE:CA:57:BC', '2018-05-29 03:00:00', '0000-00-00', 0),
(80, 180, 17068523021644, 'MC32N0', 'PROD', 'FIC180', '', '40:83:DE:CA:59:96', '2018-05-29 03:00:00', '0000-00-00', 0),
(81, 181, 17068523021961, 'MC32N0', 'PROD', 'FIC181', '', '40:83:DE:CA:56:FF', '2018-05-29 03:00:00', '0000-00-00', 0),
(82, 182, 17068523021655, 'MC32N0', 'STOCK', 'FIC182', '', '40:83:DE:CA:4B:6B', '2018-05-29 03:00:00', '0000-00-00', 0),
(83, 183, 16191523038007, 'MC32N0', 'PROD', 'FIC183', '', '40:83:DE:B0:72:D1', '2018-05-29 03:00:00', '0000-00-00', 0),
(84, 184, 17083523021162, 'MC32N0', 'STOCK', 'FIC184', '', '40:83:DE:EF:04:79', '2018-05-29 03:00:00', '0000-00-00', 0),
(85, 185, 17083523020254, 'MC32N0', 'PROD', 'FIC185', '', '40:83:DE:EF:17:2E', '2018-05-29 03:00:00', '0000-00-00', 0),
(86, 186, 16349523022486, 'MC32N0', 'PROD', 'FIC186', '', '40:83:DE:C8:B6:2C', '2018-05-29 03:00:00', '0000-00-00', 0),
(87, 187, 17068523021928, 'MC32N0', 'PROD', 'FIC187', '', '40:83:DE:CA:56:E2', '2018-05-29 03:00:00', '0000-00-00', 0),
(88, 188, 16354523021029, 'MC32N0', 'PROD', 'FIC188', '', '40:83:DE:C8:DB:BF', '2018-05-29 03:00:00', '0000-00-00', 0),
(89, 189, 16354523021152, 'MC32N0', 'STOCK', 'FIC189', '', '40:83:DE:C8:9F:59', '2018-05-29 03:00:00', '0000-00-00', 0),
(90, 500, 10170521101734, 'MC3090', 'REBUS', 'FIC101', '', '', '0000-00-00 00:00:00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(35) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(35) CHARACTER SET latin1 NOT NULL,
  `fonction` varchar(35) CHARACTER SET latin1 NOT NULL,
  `secteur` varchar(35) CHARACTER SET latin1 NOT NULL,
  `non_rendu` int(11) NOT NULL,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `fonction`, `secteur`, `non_rendu`, `id_magasin`) VALUES
(100, 'LACOUR', 'David', 'RESP INFORMATIQUE', 'Informatique', 0, 0),
(126, 'AIMABLE', 'Christian', 'CHEF DE SECTEUR PGC', 'PGC', 0, 0),
(127, 'HUSSAIN', 'Rolando', 'Comptable', 'Comptabilite', 0, 0),
(128, 'JEAN-ELIE', 'Didier', 'MANAGER DE RAYON', 'EPCS', 0, 0),
(132, 'LAM-CHAN', 'Naelle', 'ADJ CHEF DE RAYON', 'Poissonnerie', 0, 0),
(135, 'LAROCHE', 'Cindy', 'HÔTESSE DE CAISSE', '', 0, 0),
(156, 'VILHENA', 'Solange', 'Adjointe Chef de Rayon', 'EPCS', 0, 0),
(160, 'URSULET', 'Anais', 'Chef de secteur', 'Textile', 0, 0),
(161, 'ASSIER DE POMPIGNAN', 'Rodolphe', 'Chef de secteur', 'APLS', 0, 0),
(163, 'MASSOL-ARNAUD', 'Yvan', 'Chef de Rayon', 'PGC', 0, 0),
(165, 'LEBOULANGER', 'Francois', 'DIRECTEUR', 'Direction', 0, 0),
(166, 'VELAYANDOM', 'Rosiane', 'RESPONSABLE CAISSE', 'CAISSE', 0, 0),
(167, 'CHOUX', 'Caroline', 'ADJ RESP CAISSE', 'CAISSE', 0, 0),
(168, 'VOGT', 'Vincent', 'CONTROLEUR DE GESTION', 'GESTION', 0, 0),
(242, 'FRANCOIS', 'Milord', 'Employe commercial', 'PGC', 0, 0),
(250, 'SENA DE DEUS', 'Naim', 'Employée Commerciale', 'Boulangerie', 0, 0),
(281, 'LAMONTAGNE', 'Chantal', 'Employee Polyvalente', 'Traiteur', 0, 0),
(303, 'BRUTUS', 'Daniella', 'EMPLOYE COMMERCIAL', ' ', 0, 0),
(339, 'AGALLA', 'Loic', 'COMPTABLE', 'COMPTABILITE', 0, 0),
(350, 'KOUYOURI', 'Joffrey', 'Employe Commercial', 'EPCS', 0, 0),
(354, 'CORNETTE', 'Nicole', 'EMPLOYEE COMMERCIALE', 'MARCHE', 0, 0),
(358, 'MANGEARD', 'Maxence', 'EMPLOYE COMMERCIAL', 'TEXTILE', 0, 0),
(359, 'MICHAUD', 'Sandra', 'RECEPTIONNAIRE', '', 0, 0),
(369, 'DA SILVA', 'Katminy', 'EMPLOYEE COMMERCIALE', '', 0, 0),
(375, 'BRAGA', 'Francinildo', 'EMPLOYE COMMERCIAL', '', 0, 0),
(376, 'BARKER', 'Andrew', 'EMPLOYE COMMERCIAL', '', 0, 0),
(397, 'CHARLES', 'Witelande', 'EMPLOYEE POLYVALENTE', '', 0, 0),
(407, 'PAUL', 'Lucianna', 'HÔTESSE DE CAISSE', '', 0, 0),
(410, 'CELIMENE', 'Elisabeth', 'EMPLOYEE COMMERCIALE', '', 0, 0),
(411, 'MITCHEL', 'Marie-José', 'EMPLOYEE COMMERCIALE', '', 0, 0),
(425, 'FAVREAU', 'Frederic', 'MANAGER DE RAYON', '', 0, 0),
(437, 'GILTA', 'Caryl', 'EMPLOYE COMMERCIAL', '', 0, 0),
(448, 'MATHURIN', 'Kévin', 'EMPLOYE COMMERCIAL', '', 0, 0),
(457, 'FLORIMOND', 'Anne-Sophie', 'EMPLOYEE COMMERCIALE', '', 0, 0),
(459, 'ATALA', 'Jessica', 'COMPTABLE', '', 0, 0),
(466, 'ETIENNE', 'Esaïe', 'EMPLOYE COMMERCIAL', '', 0, 0),
(467, 'PETITJEAN', 'Tugdual', 'RECEPTIONNAIRE', '', 0, 0),
(475, 'APAYACA', 'Patrice', 'Employe Commercial', 'Boulangerie', 0, 0),
(476, 'VIGELANDZOON', 'Eugenie', 'Employee Commerciale', 'Boucherie', 0, 0),
(477, 'DANIEL', 'Tania', 'Employee Commerciale', 'PGC', 0, 0),
(479, 'PINEL', 'Fanny', 'Employee Commerciale', 'Patisserie', 0, 0),
(481, 'CARPOT', 'Georgie', 'Hôtesse de caisse', 'Caisse', 0, 0),
(491, 'LUCAS', 'Yannick', 'Employe Commercial', 'Bazar', 0, 0),
(492, 'BONJOUR', 'Julie', 'Adjoint Chef de Rayon', 'Textile', 0, 0),
(493, 'LAUTRIC', 'Nathan', 'Employe Commercial', 'Maree', 0, 0),
(500, 'BENVAR', 'Mathieu', 'Employe Commercial', 'APLS', 0, 0),
(506, 'DONATE', 'Eric', 'Chef de Rayon', 'MARCHE', 0, 0),
(507, 'VALENTE', 'Sergio', 'Employe commercial', 'Bazar', 0, 0),
(509, 'BRAGA DIAS', 'Sandra', 'Employee Commerciale', 'BAZAR', 0, 0),
(523, 'LADINE', 'Jordan', 'EMPLOYE COMMERCIAL', 'PGC', 0, 0),
(529, 'FUNG FONG YOU', 'Didier', 'Adj Chef de rayon', 'MARCHE', 0, 0),
(542, 'BRAGA DIAS', 'Sandra', 'EMPLOYEE COMMERCIALE', 'BAZAR', 0, 0),
(544, 'PRUDENT', 'Cindy', 'Employee Commerciale', 'BAZAR', 0, 0),
(545, 'SIQUEIRA BARBOSA', 'Allan', 'Employe Commercial', 'FRUITS ', 0, 0),
(546, 'DINAL', 'Leevai', 'Employe Commercial', 'PGC', 0, 0),
(547, 'MACIEL', 'Gisele', 'Employee Commerciale', 'PGC', 0, 0),
(549, 'JEANGOUDOUX', 'Marina', 'Employee Commerciale', 'Textile', 0, 0),
(552, 'ALEMIN', 'Muleha', 'Employe Commercial', 'PGC', 0, 0),
(553, 'RABAUD', 'Bernard', 'Boucher', 'MARCHE', 0, 0),
(556, 'JEAN', 'DASELINE', 'Employe commercial', 'MARCHE', 0, 0),
(600, 'DEL REY', 'Prisca', 'Employee Commerciale', 'APLS', 0, 0),
(603, 'SOPHIE', 'Cassandra', 'Employee Commerciale', 'BAZAR', 0, 0),
(605, 'VALENTE', 'Sergio', 'EMPLOYE COMMERCIAL', 'BAZAR', 0, 0),
(607, 'PALMEIRIM', 'Michelle', 'EMPLOYEE COMMERCIALE', 'TEXTILE', 0, 0),
(609, 'DE JESUS PEREIRA', 'Ronyelson', 'Employé Commercial', 'PGC', 0, 0),
(611, 'JOSEPH', 'Axel', 'Employe Commercial', 'EPCS', 0, 0),
(614, 'JOHNSON', 'Ronald', 'Chef de rayon', 'BAZAR', 0, 0),
(615, 'PEREIRA FRANCA', 'Charles', 'Employé commercial', 'APLS', 0, 0),
(616, 'POTEAU', 'Géraldine', 'Employée commerciale', 'BAZAR', 0, 0),
(617, 'SOPHIE', 'Cassandra', 'Employée commerciale', 'BAZAR', 0, 0),
(620, 'LUGSOR', 'Beatrix', 'Employe Commercial', 'BAZAR', 0, 0),
(622, 'DURAND', 'Anaïs', 'Employée Commerciale', 'PGC', 0, 0),
(624, 'BARBOSA', 'Jean-Rene', 'Employe Commercial', 'MARCHE', 0, 0),
(625, 'BARROS DIAS', 'Elias', 'Employe Commercial', 'BAZAR LEGER', 0, 0),
(626, 'GUY', 'Kevin', 'Employe Commercial', 'PGC', 0, 0),
(627, 'PETERS', 'Mark', 'Employe Commercial', 'PGC', 0, 0),
(628, 'LUNA SANCHEZ', 'Brian', 'Employe Commercial', 'PGC', 0, 0),
(629, 'BERTHOLO', 'Carlos', 'Employe Commercial', 'APLS', 0, 0),
(637, 'PRIVAT', 'Jean-Marc', 'Employe Commercial', 'MARCHE', 0, 0),
(638, 'DABREU', 'Jean-Yves', 'Employe Commercial', 'MARCHE', 0, 0),
(639, 'PIERRE', 'Valencia', 'Assistante Commerciale', 'NON AL', 0, 0),
(640, 'THES', 'Tassia', 'Employee Commerciale', 'MARCHE', 0, 0),
(641, 'SAVREUX', 'Mederic', 'Employe Commercial', 'APLS', 0, 0),
(642, 'BAUMAYER', 'Pierrick', 'Directeur Adjoint', 'MAGASIN', 0, 0),
(646, 'LEVEILLE', 'Geraldine', 'Employee Commerciale', 'PGC', 0, 0),
(647, 'DA SILVA SENA', 'Tiago', 'Employe Commercial', 'EPCS', 0, 0),
(650, 'DUBOIS', 'Erika', 'Employee Commerciale', 'BAZAR', 0, 0),
(651, 'SILVA DA COSTA', 'Elisabeth', 'Employee Commerciale', 'MARCHE', 0, 0),
(652, 'DA FONSECA PONTES', 'Thiago', 'EMPLOYE COMMERCIAL', 'PGC', 0, 0),
(663, 'DUBOIS', 'Erika', 'EMPLOYÉE COMMERCIALE', 'BAZAR', 0, 0),
(664, 'SILVA DA COSTA', 'Elisabeth', 'EMPLOYEE COMMERCIALE', 'STAND', 0, 0),
(665, 'GENEVIEVE', 'Junior', 'EMPLOYE COMMERCIALE', 'SURGELES', 0, 0),
(667, 'GUY', 'Daryl', 'EMPLOYE COMMERCIALE', 'STAND', 0, 0),
(668, 'GAUVAIN', 'Charles', 'CHEF DE RAYON LIQUIDE', 'PGC', 0, 0),
(672, 'LEMENE', 'Liciana', 'EMPLOYE COMMERCIAL', 'TEXTILE', 0, 0),
(673, 'GROCHATEAU', 'Emelyne', 'CHEF DE RAYON DPH', 'PGC', 0, 0),
(676, 'BARRONCE', 'Sebastien', 'Chef de Rayon', 'MARCHE', 0, 0),
(682, 'FAUVETTE', 'Grégory', 'Employé Commercial', 'BAZAR', 0, 0),
(683, 'DE LIMA BARROSSO', 'Caroline', 'Employee Commerciale', 'BAZAR', 0, 0),
(693, 'KERSIT', 'Jeanne', 'EMPLOYEE COMMERCIALE', 'EPCS', 0, 0),
(694, 'BROUSSOULOUX', 'Chris', 'EMPLOYE COMMERCIAL', 'BAZAR', 0, 0),
(698, 'CLET', 'Rodrigue', 'EMPLOYE COMMERCIAL', 'BAZAR', 0, 0),
(699, 'THOMAS', 'Jean-Julien', 'Chef de Secteur', 'BAZAR', 0, 0),
(700, 'POTEAU', 'Géraldine', 'EMPLOYEE COMMERCIALE', 'APLS', 0, 0),
(709, 'LACOUR.E', 'Elizabete', 'Employee Commerciale', 'APLS', 0, 0),
(710, 'ANTONIO-FELICIO', 'Frederick', 'Employe Commerciale', 'APLS', 0, 0),
(711, 'SPRIET', 'Maxime', 'Chef de Rayon', 'Bazar', 0, 0),
(716, 'FARIAS DE OLIVEIRA', 'Joel', 'EMPLOYE COMMERCIAL', 'BAZAR', 0, 0),
(717, 'GLISSANT', 'Murielle', 'EMPLOYEE COMMERCIALE', 'TEXTILE', 0, 0),
(718, 'GALOT', 'Christophe', 'EMPLOYE COMMERCIAL', 'BOUCHERIE', 0, 0),
(720, 'PETERS', 'Paula', 'EMPLOYEE COMMERCIALE', 'BAZAR', 0, 0),
(722, 'AJAISO', 'Marion', 'EMPLOYE COMMERCIAL', 'PGC', 0, 0),
(805, 'PAYET', 'Dionete', 'EMPLOYEE COMMERCIALE', 'PATISSERIE', 0, 0),
(806, 'RODRIGUEZ', 'Magdiel', 'Employe Commercial', 'BAZAR', 0, 0),
(807, 'FARIAS DE OLIVEIRA', 'Joel', 'Employe Commercial', 'BAZAR', 0, 0),
(808, 'SAINTE ROSE', 'Hans', 'Employe Commercial', 'BAZAR', 0, 0),
(809, 'HO CHONG LINE', 'Rayan', 'Employe Commercial', 'BAZAR', 0, 0),
(810, 'LABUTHIE', 'Sonny', 'Employe Commercial', 'PGC', 0, 0),
(811, 'LEGERME', 'Edzer', 'Adj Chef de Rayon', 'BAZAR', 0, 0),
(812, 'DOS REIS DE SOUSA', 'Rubens', 'Employe Commercial', 'EPCS', 0, 0),
(813, 'DOS SANTOS', 'Johny', 'Employ Commercial', 'APLS', 0, 0),
(821, 'BASQUIN', 'Marie-Aria', 'Employée commerciale', 'Pâtisserie', 0, 0),
(822, 'CETOUTE', 'Kerlyne', 'Employée commerciale', 'Traiteur', 0, 0),
(823, 'NELSON', 'Cédric', 'Employé commercial', 'Réception', 0, 0),
(824, 'SILVA MELO', 'Bruno', 'Employé commercial', 'DPH', 0, 0),
(835, 'DIXIT', 'Leila', 'Employe Commerciale', 'TEXTILE', 0, 0),
(836, 'DE LA CRUZ ', 'Rayniris', 'Employee Commerciale', 'EPCS', 0, 0),
(837, 'ALMEIDA', 'Franciléa', 'Employee Commerciale', 'PGC', 0, 0),
(838, 'BRUNO', 'Catherine', 'Employee Commerciale', 'MARCHE', 0, 0),
(839, 'GRANT', 'Maic', 'Employe Commercial', 'PGC', 0, 0),
(840, 'TOBIAS SOUSA', 'Maria-Daniela', 'Employee Commerciale', 'PGC', 0, 0),
(841, 'QUARESMA', 'Héléna', 'Employée Commerciale', 'ELS', 0, 0),
(842, 'LABONTE', 'Alison', 'EMPLOYE COMMERCIAL', 'RECEPTION', 0, 0),
(843, 'SIGUIER', 'Flavio', 'Employe Commercial', 'PGC', 0, 0),
(845, 'SEPHO', 'Solly', 'Employe Commercial', 'PGC', 0, 0),
(846, 'LAGUERRE', 'Jérémy', 'Employe Commercial', 'MARCHE', 0, 0),
(847, 'LUCIEN', 'Swann', 'Employe Commercial', 'MARCHE', 0, 0),
(848, 'SILVA BARROS', 'Fabricio', 'Employe Commercial', 'MARCHE', 0, 0),
(849, 'DORISSANT', 'Dornélie', 'Employee Commerciale', 'MARCHE', 0, 0),
(850, 'ALVES DOS SANTOS', 'Oziel', 'Employe Commercial', 'MARCHE', 0, 0),
(851, 'CARASCO', 'James', 'Employe Commercial', 'PGC', 0, 0),
(852, 'EDMOND', 'Catherine', 'Employee Commerciale', 'EPCS', 0, 0),
(854, 'ITALIEN', 'Jean-Frédéric', 'Employe Commercial', 'EPCS', 0, 0),
(855, 'BESSON', 'Faustine', 'EMPLOYEE COMMERCIALE', 'Boulangerie', 0, 0),
(856, 'PLUMER', 'Denis', 'EMPLOYE COMMERCIAL', 'Epicerie', 0, 0),
(857, 'SILVA BARROS ', 'Fabricio', 'EMPLOYE COMMERCIAL', 'Flegs', 0, 0),
(858, 'ABAD DOBLE', 'Andréa', 'EMPLOYEE COMMERCIALE', 'Poissonnerie', 0, 0),
(859, 'JEAN-PAUL', 'Annesitot', 'EMPLOYE COMMERCIAL', 'Surgelés', 0, 0),
(860, 'DOMINIQUE', 'Chris', 'EMPLOYE COMMERCIAL', 'Boucherie', 0, 0),
(861, 'NTIRORANYA', 'Idrissa', 'Employe Commercial', 'MARCHE', 0, 0),
(862, 'JEAN', 'Venante', 'Employee Commerciale', 'PGC', 0, 0),
(863, 'VANMEENEN', 'Lindsay', 'Employee Commerciale', 'APLS', 0, 0),
(867, 'RELLY', 'Lesly', 'Employee Commerciale', 'MARCHE', 0, 0),
(868, 'PELLETIER', 'Eric', 'EMPLOYE COMMERCIAL', 'STAND', 0, 0),
(869, 'ROMAIN', 'Miche', 'Assistant Commercial', 'PGC', 0, 0),
(870, 'LEE', 'Clive', 'EMPLOYE COMMERCIAL', 'EPCS', 0, 0),
(871, 'GONZALEZ', 'Moannah', 'Employee Commerciale', 'MARCHE', 0, 0),
(873, 'RINGUET', 'Amanda', 'Employee Commerciale', 'TEXTILE', 0, 0),
(874, 'PLUMER', 'Denis', 'Employe Commercial', 'MARCHE', 0, 0),
(876, 'MARAPENGOPI', 'Beatrice', 'Assistance Commerciale', 'PGC', 0, 0),
(877, 'BALKUMAR', 'Chris', 'Employe Commercial', 'APLS', 0, 0),
(878, 'MERENNA', 'Jean-Daniel', 'Employe Commercial', 'BAZAR', 0, 0),
(879, 'BERTHOD', 'Quentin', 'Employe Commercial', 'BAZAR', 0, 0),
(880, 'CASIMIR', 'Elysee', 'Employee Commercial', 'MARCHE', 0, 0),
(882, 'LEE', 'Celine', 'Cheffe de Rayon FLEG', 'MARCHE', 0, 0),
(903, 'MARC', 'Adony', 'Employe Commercial', 'MARCHE', 0, 0),
(906, 'XAVIER', 'Stephanie', 'Employee Commerciale', 'TEXTILE', 0, 0),
(908, 'BADETTE', 'Alex', 'EMPLOYE COMMERCIAL', 'FLEG', 0, 0),
(910, 'LISNYCHYI', 'Andrii', 'EMPLOYE COMMERCIAL', 'APLS', 0, 0),
(911, 'LEOTE', 'Jeff', 'EMPLOYE COMMERCIAL', 'MARCHE', 0, 0),
(913, 'ANGULO SANTANA', 'Aderlin', 'EMPLOYE COMMERCIAL', 'EPICERIE', 0, 0),
(914, 'LUXIN', 'Jacques-Daniel', 'EMPLOYE COMMERCIAL', 'EPCS', 0, 0),
(915, 'RAVILUS', 'Lorvélie', 'EMPLOYEE COMMERCIALE', 'APLS', 0, 0),
(916, 'AMAYOTA', 'Zico', 'EMPLOYE COMMERCIAL', 'SURGELES', 0, 0),
(917, 'MOREAU', 'Claire', 'EMPLOYEE COMMERCIALE', 'BOULANGERIE', 0, 0),
(918, 'REIS BARBIOSA', 'Joelson', 'EMPLOYE COMMERCIAL', 'BOULANGERIE', 0, 0),
(923, 'G. VALENTIN REIS', 'Jeane', 'EMPLOYEE COMMERCIALE', 'DPH', 0, 0),
(925, 'AJOME', 'Mickael', 'Employe Commercial', 'PGC', 0, 0),
(930, 'GALLIANO', 'Jessica', 'Employee Commerciale', 'MARCHE', 0, 0),
(931, 'FIOLET', 'Terence', 'Employe Commercial', 'PGC', 0, 0),
(945, 'PONTAT', 'Eddy', 'Chef de Projet', 'PGC', 0, 0),
(948, 'HERMILUS', 'Caleb', 'EMPLOYE COMMERCIAL', 'APLS', 0, 0),
(949, 'PAUL', 'Ismaël', 'EMPLOYE COMMERCIAL', 'PGC', 0, 0),
(955, 'DONDO', 'Greg', 'EMPLOYE COMMERCIAL', 'DPH', 0, 0),
(957, 'MODERNE', 'Joyline', 'EMPLOYEE COMMERCIALE', 'FLEG', 0, 0),
(958, 'FARIAS', 'Yale', 'EMPLOYE COMMERCIAL', 'BAZAR', 0, 0),
(960, 'LELIEN', 'Frantz', 'EMPLOYE COMMERCIAL', 'BAZAR', 0, 0),
(968, 'GERMAIN', 'Hilda', 'EMPLOYEE COMMERCIALE', 'BAZAR', 0, 0),
(969, 'CASSANG', 'Guillaume', 'ADJ. RESPONSABLE DE RAYON', 'BOULANGERIE PATISSERIE', 0, 0),
(971, 'CORNELUS', 'Erik', 'EMPLOYE COMMERCIAL', 'APLS', 0, 0),
(986, 'ATTAR', 'Khoddor', 'Employe Commercial', 'PGC', 0, 0),
(1000, 'CHERINE', 'Michel Ange', 'EMPLOYE COMMERCIAL', 'SURGELES', 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `defaillances_radiopads`
--
ALTER TABLE `defaillances_radiopads`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `magasins`
--
ALTER TABLE `magasins`
  ADD PRIMARY KEY (`id_magasin`);

--
-- Index pour la table `pannes_radiopads`
--
ALTER TABLE `pannes_radiopads`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `prets`
--
ALTER TABLE `prets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `radiopads`
--
ALTER TABLE `radiopads`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `defaillances_radiopads`
--
ALTER TABLE `defaillances_radiopads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `magasins`
--
ALTER TABLE `magasins`
  MODIFY `id_magasin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `pannes_radiopads`
--
ALTER TABLE `pannes_radiopads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `prets`
--
ALTER TABLE `prets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `radiopads`
--
ALTER TABLE `radiopads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
