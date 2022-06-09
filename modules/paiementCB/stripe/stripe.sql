-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 10 mai 2022 à 16:42
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stripe`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `date`) VALUES
('', 'Dalhoum', 'Rihane', 'dalhoumrihane@gmail.com', '2022-05-10 11:43:34'),
('cus_LespXFpXfV5qGi', 'Dalhoum', 'Rihane', 'riroudal@gmail.com', '2022-05-09 17:03:54'),
('cus_LfAyqUdGzJrnQP', 'Dalhoum', 'Rihane', 'dalhoumrihane@gmail.com', '2022-05-10 11:48:53'),
('cus_LfB3SPXvtdHbV0', 'Dalhoum', 'Rihane', 'riroudal@gmail.com', '2022-05-10 11:53:52'),
('cus_LfB4KZvD2RO2Zc', 'Dalhoum', 'Rihane', 'dalhoumrihane@gmail.com', '2022-05-10 11:55:13'),
('cus_LfDM12Qw2cvbWa', 'Dalhoum', 'Rihane', 'dalhoumrihane@gmail.com', '2022-05-10 14:16:38'),
('cus_LfDTBuuz0gKYOb', 'Dalhoum', 'Rihane', 'riroudal@gmail.com', '2022-05-10 14:23:36'),
('cus_LfEVrR4hUJrxtO', 'Dalhoum', 'Rihane', 'dalhoumrihane@gmail.com', '2022-05-10 15:28:12');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `produit` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `devise` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `client_id`, `produit`, `prix`, `devise`, `status`, `created_at`) VALUES
('ch_3Kxqih2VYugoKSBz0DUPGFA5', '', 'Test', '', '', 'succeeded', '2022-05-10 11:55:13'),
('ch_3KxsvY2VYugoKSBz1y0kzcXO', '', 'Test', '', '', 'succeeded', '2022-05-10 14:16:40'),
('ch_3Kxt2J2VYugoKSBz1FOGwyB4', '', 'Test', '', '', 'succeeded', '2022-05-10 14:23:37'),
('ch_3Kxu2o2VYugoKSBz0kn3FLWr', '', 'Test', '', '', 'succeeded', '2022-05-10 15:28:12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
