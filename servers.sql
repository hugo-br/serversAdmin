-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 21 déc. 2018 à 05:15
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `servers`
--

-- --------------------------------------------------------

--
-- Structure de la table `server`
--

CREATE TABLE `server` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `server`
--

INSERT INTO `server` (`id`, `name`, `location`, `type`) VALUES
(1, 'Montreal Web 1', 'Montreal', 'Web Server'),
(2, 'Montreal Mail 2', 'Montreal', 'Mail Server'),
(15, 'Toronto Web 1', 'Toronto', 'Web Server'),
(16, 'Montreal Web 2', 'Montreal', 'Web Server'),
(19, 'Mail Montreal 3', 'Montreal', 'Mail Server'),
(20, 'Proxy Montreal 1', 'Montreal', 'Proxy Server'),
(21, 'Montreal Web 3', 'Montreal', 'Web Server'),
(22, 'Vancouver Proxy 1', 'Vancouver', 'Proxy Server'),
(23, 'Montreal Mail 1', 'Montreal', 'Mail Server'),
(24, 'Toronto Mail 1', 'Toronto', 'Mail Server'),
(25, 'Toronto Proxy 1', 'Toronto', 'Proxy Server'),
(26, 'Vancouver Web 1', 'Vancouver', 'Web Server'),
(27, 'Vancouver Web 2', 'Vancouver', 'Web Server'),
(28, 'Montreal Web 4', 'Montreal', 'Web Server'),
(29, 'Vancouver Mail 1', 'Vancouver', 'Mail Server'),
(30, 'Vancouver Mail 2', 'Vancouver', 'Mail Server'),
(31, 'Vancouver Proxy 2', 'Vancouver', 'Proxy Server'),
(32, 'Montreal FTP 1', 'Montreal', 'FTP Server'),
(33, 'Montreal FTP 2', 'Montreal', 'FTP Server'),
(34, 'Toronto FTP 1', 'Toronto', 'FTP Server'),
(35, 'Vancouver FTP 1', 'Vancouver', 'FTP Server'),
(36, 'Proxy Montreal 2', 'Montreal', 'Proxy Server');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(60) NOT NULL,
  `pw` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `pw`) VALUES
(3, 'test', '$2y$09$tutLVMl3qXBQVzRDOKK6ZeaHhX9M48LBAXkJ2Pf8ryyc9NjT9CXo.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `server`
--
ALTER TABLE `server`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
