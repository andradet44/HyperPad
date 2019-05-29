-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 29 mai 2019 à 19:35
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
(222, 'SDSD', 'qsd', 'EMPLOYE COMMERCIAL', 'PGC', 0, 0),
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
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22223;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
