-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 03 Avril 2017 à 23:56
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `app`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` varchar(50) NOT NULL,
  `rai` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `registreCommerce` varchar(30) NOT NULL,
  `telClient` varchar(10) NOT NULL,
  `emailClient` varchar(255) NOT NULL,
  `ripClient` varchar(255) NOT NULL,
  `fax` varchar(9) NOT NULL,
  `nif` varchar(255) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `ai` varchar(255) NOT NULL,
  `id_wilaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id_client`, `rai`, `adresse`, `registreCommerce`, `telClient`, `emailClient`, `ripClient`, `fax`, `nif`, `nis`, `ai`, `id_wilaya`) VALUES
('kkkkk', 'kkkk', 'kkkk', '15654', '012365478', 'siemaj@dayen.com', '/kkkkk.jpeg', '021659874', 'sss', 'sd', 'dzzd', 1);

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `matricule` tinyint(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privileges` varchar(1) NOT NULL,
  `hasCount` tinyint(1) NOT NULL,
  `sexe` varchar(6) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `date_de_naissance` varchar(10) NOT NULL,
  `lieu_de_naissance` varchar(100) NOT NULL,
  `titre_de_poste` varchar(50) NOT NULL,
  `deparetement` varchar(50) NOT NULL,
  `duree_de_contrat` varchar(50) NOT NULL,
  `date_debut_contrat` varchar(10) NOT NULL,
  `date_fin_contrat` varchar(10) NOT NULL,
  `date_depart` varchar(10) NOT NULL,
  `nature_de_contrat` varchar(3) NOT NULL,
  `vehicule_service` tinyint(1) NOT NULL,
  `diplome` varchar(20) NOT NULL,
  `experience` varchar(20) NOT NULL,
  `group_sanguin` varchar(3) NOT NULL,
  `mobilePro` varchar(10) NOT NULL,
  `numero_securite_social` int(11) NOT NULL,
  `motif_depart` varchar(50) NOT NULL,
  `rip` varchar(100) NOT NULL,
  `outils` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personnel`
--

INSERT INTO `personnel` (`matricule`, `nom`, `prenom`, `adresse`, `mobile`, `email`, `password`, `privileges`, `hasCount`, `sexe`, `photo`, `date_de_naissance`, `lieu_de_naissance`, `titre_de_poste`, `deparetement`, `duree_de_contrat`, `date_debut_contrat`, `date_fin_contrat`, `date_depart`, `nature_de_contrat`, `vehicule_service`, `diplome`, `experience`, `group_sanguin`, `mobilePro`, `numero_securite_social`, `motif_depart`, `rip`, `outils`) VALUES
(2, 'asma', 'lcc', '', '0222222222', 'asma@gamil.com', 'b5ea6077afc6f904643f772b86358b0e42aa3c41e7e6420c2c2d6c6a027294a0', 'd', 1, '', '/2asmalcc', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 0, '', '', ''),
(5, 'kjkjkj', 'kjkj', '', '0988776655', '', 'b5ea6077afc6f904643f772b86358b0e42aa3c41e7e6420c2c2d6c6a027294a0', 'd', 1, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 0, '', '', ''),
(19, 'le reste', 'josef', 'elkherba', '0222333444', 'siemaj@dayen.com', 'b5ea6077afc6f904643f772b86358b0e42aa3c41e7e6420c2c2d6c6a027294a0', 'c', 1, 'Male', '/19Le Restejosef.jpeg', '02/04/1994', 'bougu&acirc;a', 'web master', 'Engennring', '32 mois', '15/03/2017', '', '', 'CDD', 0, 'Master inptic', '0', 'A+', '0999888777', 13587496, '', '/19Le Restejosef.jpeg', 'PC, chargeur, Batterie, '),
(20, 'admin', 'admin', '', '0986532658', '', 'b5ea6077afc6f904643f772b86358b0e42aa3c41e7e6420c2c2d6c6a027294a0', 'a', 1, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id_projet` varchar(50) NOT NULL,
  `titre_projet` varchar(255) NOT NULL,
  `nature_traveaux` varchar(100) NOT NULL,
  `id_client` varchar(50) NOT NULL,
  `date_debut` varchar(20) NOT NULL,
  `date_fin` varchar(20) NOT NULL,
  `budget` int(15) UNSIGNED NOT NULL,
  `chef` int(11) NOT NULL,
  `pays` varchar(15) NOT NULL,
  `nombre_employes_assigne` int(11) NOT NULL,
  `duree` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `id_site` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `nature` varchar(255) NOT NULL,
  `id_client` varchar(50) NOT NULL,
  `id_persone` int(10) NOT NULL,
  `id_projet` varchar(50) NOT NULL,
  `id_wilaya` int(2) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `altitude` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wilaya`
--

CREATE TABLE `wilaya` (
  `id_wilaya` int(11) NOT NULL,
  `nom_wilaya` varchar(255) NOT NULL,
  `matricule_wilaya` int(11) NOT NULL,
  `nombre_communes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `wilaya`
--

INSERT INTO `wilaya` (`id_wilaya`, `nom_wilaya`, `matricule_wilaya`, `nombre_communes`) VALUES
(1, 'Setif', 19, 64),
(2, 'Tizi ouzou', 15, 67),
(3, 'Alger', 16, 57),
(4, 'Bejaia', 6, 56);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`matricule`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id_projet`);

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id_site`);

--
-- Index pour la table `wilaya`
--
ALTER TABLE `wilaya`
  ADD PRIMARY KEY (`id_wilaya`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `matricule` tinyint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `wilaya`
--
ALTER TABLE `wilaya`
  MODIFY `id_wilaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
