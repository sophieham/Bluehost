-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 02 déc. 2020 à 15:21
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bluehost`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `taille` enum('10x15','30x40','100x150','200x150') NOT NULL,
  `date_achat` timestamp NOT NULL DEFAULT current_timestamp(),
  `nom` varchar(75) NOT NULL,
  `prenom` varchar(75) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `prix` enum('4.99','7.99','15.99','22.99') NOT NULL,
  `cp` int(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id_img` int(11) NOT NULL,
  `chemin` varchar(200) NOT NULL,
  `chemin_mini` varchar(200) DEFAULT NULL,
  `nom` varchar(250) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('video','audio','image','') NOT NULL,
  `poids` float NOT NULL,
  `id_user` int(11) NOT NULL,
  `bonne_note` int(11) NOT NULL,
  `mauvaise_note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_img`, `chemin`, `chemin_mini`, `nom`, `private`, `date`, `type`, `poids`, `id_user`, `bonne_note`, `mauvaise_note`) VALUES
(1, 'upload/20201005152921.jpg', 'gallerie/mini_20201005152921.jpg', 'dessin', 0, '2020-10-05 13:29:21', 'image', 37290, 2, 0, 0),
(2, 'upload/20201005152936.jpg', 'gallerie/mini_20201005152936.jpg', 'sword art online', 0, '2020-10-05 13:29:36', 'image', 559513, 3, 0, 0),
(3, 'upload/20201005153001.jpg', 'gallerie/mini_20201005153001.jpg', 'cutie', 0, '2020-10-05 13:30:01', 'image', 52952, 6, 0, 0),
(4, 'upload/20201005153017.mp3', NULL, 'good music', 0, '2020-10-05 13:30:17', 'audio', 5212990, 5, 0, 0),
(5, 'upload/20201005153034.png', 'gallerie/mini_20201005153034.png', 'texture bois', 0, '2020-10-05 13:30:34', 'image', 2720, 1, 0, 0),
(6, 'upload/20201005153053.mp4', NULL, 'faune et flore', 0, '2020-10-05 13:30:53', 'video', 4686950, 3, 0, 0),
(7, 'upload/20201005153110.mp3', NULL, 'dabin', 0, '2020-10-05 13:31:10', 'audio', 4793730, 8, 0, 0),
(8, 'upload/20201005153126.mp3', NULL, 'no regrets', 0, '2020-10-05 13:31:26', 'audio', 4115040, 8, 0, 0),
(9, 'upload/20201202151557.jpg', 'galerie/mini_20201202151557.jpg', 'background', 0, '2020-12-02 14:15:57', 'image', 50699, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `date_inscription`) VALUES
(1, 'Anonyme', '', '', '2020-10-04 14:31:52'),
(2, 'bluedino', 'bluedino@gmail.com', '$2y$10$1OVW/H2L7A6DfpGmj2UTEuU5/iHo6KpThzxt0uWRgcMePIw.TrXpm', '2020-10-03 22:00:00'),
(3, 'WarPoney', 'WarPoney@gmail.com', '$2y$10$8JDlh5lgbag6QeaHCI53fui2LLjwwvgvkxqEQMGDHm05pfDiAH33.', '2020-10-05 13:20:35'),
(4, 'bees', 'bees@gmail.com', '$2y$10$IH6La0L0nSGUzvS3OwEiqO6Z6GXLFLhfqStDUZEFL1ViNDkT1Z2ie', '2020-10-05 13:24:39'),
(5, 'CanardVirus', 'CanardVirus@gmail.com', '$2y$10$Upc25.BQX/lDBq/gkjvYdeXtHpO2DsX/3UqN2WRNMXnUMn1WJNB2C', '2020-10-05 13:26:31'),
(6, 'LotusSnake', 'LotusSnake@mail.fr', '$2y$10$RgPdmSIJixdNLg.ByFelBuhLPGYXdTFMu0WM562Y7BN1/kXtunqhq', '2020-10-05 13:27:15'),
(7, 'DogChocolatine', 'DogChocolatine@hotmail.com', '$2y$10$BQ4K99pSHMwBdKubZA/DweyAg4S0qUSErGZzaaiKE2riJbxv6TnyG', '2020-10-05 13:27:40'),
(8, 'ZeSushi', 'ZeSushi@tty.fr', '$2y$10$D4Q30VlDyZkJpFwbFBnskeT0WRQJXrnWN9AWC.ingLcfApdq9QD.6', '2020-10-05 13:28:20'),
(9, 'elchapo', 'chapo@gmail.com', '$2y$10$ylep.KSwkcL.iCZq/c5SYePG/TlCsNGgAj.z1qIJxnCeMRTXrqiHG', '2020-10-05 19:07:43');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `fk_userid` (`id_user`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
