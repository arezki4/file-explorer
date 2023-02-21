
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
-- Base de données : `Arbo4`
-- commande pour inserer la base de donnée de l'exo3: sudo mysql -u root -p < sql/Arbo4.sql
--
CREATE DATABASE Arbo4;
USE Arbo4
-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id_files` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `size` int NOT NULL,
  `parent_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `files`
--

INSERT INTO `files` (`id_files`, `name`, `size`, `parent_id`) VALUES
(1, 'slide9-kaki-fruit-main-12365069.jpg', 35645, 3),
(2, 'taro-1686669_1920-1024x683.jpg', 60943, 3),
(3, 'tree-3330097_1920-1024x768.jpg', 80206, 3),
(4, 'doc1.1.txt', 811, 2),
(5, 'mango-1239347_1920-1024x683.jpg', 67675, 2),
(6, 'papaya-771145_1920-1024x683.jpg', 47699, 2),
(7, 'passion-fruit-3519303_1920-1024x683.jpg', 52290, 2),
(8, 'doc1.txt', 811, 1),
(9, 'doc8.htm', 447482, 1),
(10, 'food-3062139_1920-1024x683.jpg', 96715, 1),
(11, 'fruit-2100688_1920-1024x768.jpg', 92248, 1),
(12, 'guava-2880259_1920-1024x683.jpg', 82247, 1),
(13, 'ARS_breadfruit49.jpg', 39194, 4),
(14, 'doc2.txt', 543, 4),
(15, 'doc3.txt', 1615, 4),
(16, 'doc9.htm', 466606, 4),
(17, 'iStock-1278315370-758x426.jpg', 82616, 4),
(18, 'vegetable-3559112_1920-1024x577.png', 109710, 4),
(19, 'yams-1557440_1920-1024x687.jpg', 76691, 4),
(20, 'slide4-mineolas%2520citrus%2520tangelo-ugli-lam2-019-main-12.jpg', 44862, 7),
(21, 'slide5-durian-durio-zibethinus-Lam2-03-main-12365052.png', 70159, 7),
(22, 'slide6-Physalis-peruviana-LAM1-main-12365074.jpg', 58094, 7),
(23, 'slide8-papaye-carica-retouche-main-12365051.jpg', 69253, 7),
(24, 'doc3.1.txt', 811, 6),
(25, 'pomegranate-3383814_1920-1024x680.png', 108124, 6),
(26, 'slide2-jujube-zizyphus-jujuba-retouche-main-12365055.jpg', 46127, 6),
(27, 'slide3-fruit-de-la-passion-passiflora-edulis-main-12365075.jpeg', 47684, 6),
(28, 'doc10.htm', 437922, 5),
(29, 'iStock-1279674489-758x426.jpg', 45736, 5),
(30, 'iStock-1283279353-758x426.png', 82127, 5),
(31, 'kiwano-2128077_1920-1024x576.jpg', 102405, 5),
(32, 'lychee-419611_1920-1024x681.png', 58218, 5),
(33, 'doc4.txt', 569, 0),
(34, 'doc5.txt', 1327, 0),
(35, 'doc6.html', 159791, 0),
(36, 'doc7.html', 445333, 0),
(37, 'iStock-1202274909-758x379.png', 77664, 0),
(38, 'iStock-1277110221-758x379.png', 93327, 0),
(39, 'header.php', 934, 3),
(40, 'connexion.php', 340, 7),
(41, 'table.sql', 2145, 1),
(42, 'table.sql', 2145, 8),
(43, 'file.txt', 0, 0),
(44, 'connexion.php', 340, 0),
(45, 'docs.zip', 0, 0),
(46, 'projet-chat-bot.tar.gz', 43885, 0),
(47, 'setup.py', 67, 5),
(48, 'projet-chat-bot.zip', 65354, 9);

-- --------------------------------------------------------

--
-- Structure de la table `folders`
--

CREATE TABLE `folders` (
  `id_folder` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `parent_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `folders`
--

INSERT INTO `folders` (`id_folder`, `name`, `parent_id`) VALUES
(1, 'dir1', 0),
(2, 'dir1.1', 1),
(3, 'dir1.1.1', 2),
(4, 'dir2', 0),
(5, 'dir3', 0),
(6, 'dir3.1', 5),
(7, 'dir3.1.1', 6),
(8, 'test', 2),
(9, 'test2', 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id_files`);

--
-- Index pour la table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id_folder`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id_files` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
