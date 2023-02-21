-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 05 jan. 2023 à 09:53
-- Version du serveur : 8.0.31-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données de l'exo 1 et 2 : `Arborescence3`
/*commande pour inserer la base de donnée: sudo mysql -u root -p < sql/Arborescence3.sql*/
--
CREATE DATABASE Arborescence3;
USE Arborescence3
-- --------------------------------------------------------

--
-- Structure de la table `Arbre`
--

CREATE TABLE `Arbre` (
  `id` int NOT NULL,
  `fichier` varchar(100) DEFAULT NULL,
  `pathe` varchar(100) DEFAULT NULL,
  `dossier` varchar(100) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `taille` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Arbre`
--

INSERT INTO `Arbre` (`id`, `fichier`, `pathe`, `dossier`, `extension`, `taille`) VALUES
(1, 'document1', '/home/docx', 'rep1', '.docx', 5),
(2, 'document2', '/home/text', 'rep2', '.txt', 5),
(3, 'document3', '/home/csv', 'rep3', '.csv', 5),
(4, 'document4', '/home/py', 'rep4', '.py', 5),
(5, 'document5', '/home/exe', 'rep5', '.exe', 5),
(6, 'document6', '/home/c', 'rep6', '.c', 5),
(7, 'document7', '/home/viz', 'rep7', '.viz', 10),
(8, 'document8', '/home/image', 'rep8', '.jpg', 20),
(9, 'document9', '/home/image', 'rep9', '.jpeg', 20),
(10, 'document10', '/home/image', 'rep9z', '.jpeg', 20),
(11, 'document11', '/home/image', 'rep9', '.jpeg', 20),
(12, 'document12', '/home/image', 'rep9', '.jpeg', 20),
(13, 'document13', '/home/image', 'rep9', '.jpeg', 20),
(14, 'document14', '/home/image', 'rep9', '.jpeg', 20),
(15, 'document15', '/home/image', 'rep9', '.jpeg', 20),
(16, 'document16', '/home/image', 'rep9', '.jpeg', 20),
(17, 'document17', '/home/image', 'rep9', '.jpeg', 20),
(18, 'document18', '/home/image', 'rep9', '.jpeg', 30),
(19, 'document19', '/home/image', 'rep9', '.jpeg', 15),
(20, 'document20', '/home/image', 'rep9', '.jpeg', 20),
(21, 'document21', '/home/image', 'rep9', '.jpeg', 20),
(22, 'document22', '/home/image', 'rep9', '.jpg', 12),
(23, 'document23', '/home/image', 'rep9', '.pdf', 20),
(24, 'document24', '/home/image', 'rep9', '.jpeg', 300),
(25, 'table.php', 'upload/table.php', 'upload/', 'php', 2983);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Arbre`
--
ALTER TABLE `Arbre`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Arbre`
--
ALTER TABLE `Arbre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
