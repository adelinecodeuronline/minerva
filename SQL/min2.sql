-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 26 fév. 2022 à 09:11
-- Version du serveur : 5.7.33
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `min2`
--

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `projet_id` int(11) NOT NULL,
  `projet_importance` varchar(255) NOT NULL,
  `projet_type` varchar(255) NOT NULL,
  `projet_description` longtext NOT NULL,
  `projet_visuel` varchar(255) DEFAULT NULL,
  `projet_client` varchar(255) DEFAULT NULL,
  `projet_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`projet_id`, `projet_importance`, `projet_type`, `projet_description`, `projet_visuel`, `projet_client`, `projet_date`) VALUES
(1, '', 'site web', 'Un site internet pour l\'entreprise AdaLovelaceCorp', NULL, 'Ada Lovelace', '2022-02-16'),
(2, 'moyen', 'Refonte [modif2]', 'Refonte d\'un site existant pour mettre en avant son prix Nobel', '620f9b301d1fd9.28718613.', 'Jocelyn Bell', '2022-02-18');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `ticket_statut` varchar(100) NOT NULL DEFAULT 'new',
  `ticket_titre` text NOT NULL,
  `ticket_message` longtext NOT NULL,
  `ticket_date` date NOT NULL,
  `ticket_importance` varchar(255) DEFAULT NULL,
  `ticket_origineprob` varchar(255) DEFAULT NULL,
  `ticket_fichier` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_client` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `ticket_statut`, `ticket_titre`, `ticket_message`, `ticket_date`, `ticket_importance`, `ticket_origineprob`, `ticket_fichier`, `user_id`, `ticket_client`) VALUES
(9, 'new', 'Connexion satellite', 'Bug connexion', '2022-02-24', 'Important', 'technique', '6217b267870b18.66666775.jpg', 2, NULL),
(11, 'resolu', 'Bug serveur', 'Problème affichage', '2022-02-24', NULL, '', '6217b267870b18.66666775.jpg', 2, 'Creola Katherine Coleman Johnson'),
(13, 'new', 'Site web [modif]', 'Navigation à revoir', '2022-02-24', '13', 'visuel', '6217b267870b18.66666775.jpg', 3, 'Marie Curie'),
(14, 'new', 'Un autre ticket de programmation', 'Test ticket de programmation', '2022-02-25', NULL, 'hébergement', '6218b6e7400457.71430864.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tickets_comments`
--

CREATE TABLE `tickets_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_message` longtext NOT NULL,
  `comment_date` date NOT NULL,
  `ticket_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tickets_comments`
--

INSERT INTO `tickets_comments` (`comment_id`, `comment_message`, `comment_date`, `ticket_id`) VALUES
(1, 'Test commentaire', '2022-02-18', 9),
(3, 'Ce commentaire au sujet d\'un problème de programmation', '2022-02-25', 14),
(4, 'Voici un autre commentaire : Affichage ok...', '2022-02-25', 11);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_role` varchar(100) NOT NULL DEFAULT 'user',
  `user_name` varchar(255) NOT NULL,
  `user_entreprise` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_imageprofil` varchar(255) DEFAULT NULL,
  `user_tel` varchar(255) DEFAULT NULL,
  `user_adresse` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `user_name`, `user_entreprise`, `user_email`, `user_password`, `ticket_id`, `comment_id`, `user_imageprofil`, `user_tel`, `user_adresse`) VALUES
(1, 'user', 'Adalovelace', 'Adalovalacecorp', 'contact@adalovelacecorp.com', '$2y$10$o1uOL4b0duWAN.YSR3fzNua6vNCFugUdLzi4Y4S.6LaduPtcM1C9u', 14, NULL, '6218c9368941d9.02135060.jpg', '', ''),
(2, 'user', 'Gracehopper', 'gracehopperCorp', 'contact@gracehoppercorp.com', '$2y$10$PEi5Qor9T1OoqEMu0gV1UOvxDQNh5AONNjRIXMbVDiweM5UwKoKge', 9, NULL, '6218b2a909cee0.39253448.svg', '', ''),
(3, 'admin', 'testadmin', 'testadminCorp', 'contact@testadmincorp.com', '$2y$10$W0cOlNJYOs2xQOq2zm8sReAqgoJW4rVXV93EG34bWkbLz6PIfsmKu', NULL, NULL, '6218b293d5fd00.82255324.svg', '', ''),
(5, 'user', 'Jocelyn Bell', 'BellCorp', 'contact@NoBellCorp.com', '$2y$10$jxWaCQcGwiRRevQO7cWE3uyxGdCXFF0bksfwY85/EwzbAHIgdIcqa', NULL, NULL, NULL, '0081854271', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`projet_id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `tickets_comments`
--
ALTER TABLE `tickets_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `projet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `tickets_comments`
--
ALTER TABLE `tickets_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
