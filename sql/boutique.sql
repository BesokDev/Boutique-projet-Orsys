-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 01 nov. 2022 à 12:56
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `membre_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `etat` enum('en_cours_de_traitement','envoye','livre') COLLATE utf8mb4_unicode_ci DEFAULT 'en_cours_de_traitement',
  PRIMARY KEY (`id_commande`),
  KEY `IDX_6EEAA67DA76ED395` (`membre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `membre_id`, `montant`, `date_enregistrement`, `etat`) VALUES
(13, 1, 130, '2022-10-31 04:08:56', 'en_cours_de_traitement');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

DROP TABLE IF EXISTS `details_commande`;
CREATE TABLE IF NOT EXISTS `details_commande` (
  `id_details_commande` int(11) NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(5) NOT NULL,
  `prix` int(5) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_details_commande`),
  KEY `FK_6EEAA67D4584665B` (`commande_id`),
  KEY `FK_6EEAA67D4584665C` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `commande_id`, `produit_id`, `quantite`, `prix`, `date_enregistrement`) VALUES
(7, 13, 1, 1, 80, '0000-00-00 00:00:00'),
(8, 13, 2, 2, 25, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civilite` enum('homme','femme') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` int(5) NOT NULL,
  `adresse` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` int(1) NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(1, 'Jojo', '$2y$10$EJEYu5yvTS0eRyLPl9wgyOOdqjxiuiG2cQhSPqOC/qKkYmKUO.aNK', 'Gredler', 'Jonathan', 'user@user.fr', 'homme', 'Paris', 24785, 'Rue du sentier', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taille` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public` enum('homme','femme','mixte','enfant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(1, 'AB001', 'Pull', 'Pull à capuche', 'Un pull chaud et stylé pour l\'hiver', 'vert', 'M', 'homme', 'http://localhost:80/E-Boutique_PHP-master/photo/AB001--01-naketano-feuerkralle-vii-1700-2001-0988-fancy-dark-grey-melange.jpg', '80', '11'),
(2, 'CD005', 'Tee-shirt', 'Teeshirt', 'Super teeshirt de l\'univers Dragon Ball et la belle Bulma.', 'blanc', 'M', 'mixte', 'http://localhost:80/E-Boutique_PHP-master/photo/CD005--henriette-h-t-shirt-goodbye-emmanuelle-blanc-bleu-coton-1.jpg', '25', '30');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DA76ED395` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`);

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `FK_6EEAA67D4584665B` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `FK_6EEAA67D4584665C` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
