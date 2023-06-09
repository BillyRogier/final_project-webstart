-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 06 juin 2023 à 15:47
-- Version du serveur : 5.7.24
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `final_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `carousel`
--

CREATE TABLE `carousel` (
  `carousel_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `alt` text NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `carousel`
--

INSERT INTO `carousel` (`carousel_id`, `img`, `alt`, `type`, `product_id`) VALUES
(35, '64625e8fc0779.jpg', 'xdfb', 1, 24),
(36, '6462611b26c9c.webp', 'xdfb', 2, 24),
(37, '6463174fe87d0.webp', 'sdv', 1, 25),
(41, '2a74ad51ed95049236cb6f633949081b.jpg', 'erg', 1, 27),
(42, '4b0adb2a2b385ae83083871500c86122.jpg', 'esrgser', 2, 27),
(43, '984f2c2564c872100911b11ca4b1f8e0.webp', 'sergserg', 1, 28),
(44, '9f8edce20a6adec861b6499740916f5d.jpg', 'serg', 1, 29);

-- --------------------------------------------------------

--
-- Structure de la table `categorys`
--

CREATE TABLE `categorys` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_img` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorys`
--

INSERT INTO `categorys` (`category_id`, `category_name`, `category_img`, `alt`) VALUES
(8, 'sqdv', '1684066476.webp', 'akira nakai poster'),
(9, 'fdxf', '1684168320.jpg', 'xdfg');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `quantity`, `order_date`, `order_num`) VALUES
(1, 5, 25, 76, '2023-06-02 13:24:56', '4924e98913a90f4c48c8ecc57af2a8ac'),
(4, 5, 25, 15, '2023-06-02 13:28:09', '7e277093c5f83ee399703636fc408a16'),
(5, 5, 25, 5, '2023-06-02 16:30:59', '18157acdb875b446dbee1653166da330'),
(6, 5, 27, 1, '2023-06-02 16:30:59', '18157acdb875b446dbee1653166da330');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `visibility`) VALUES
(24, 'xfdbugui', 'xdfb', 55, 8, 3),
(25, 'sd', 'sdv', 5, 8, 1),
(27, 'sergesrg', 'sergsergserger', 55, 8, 1),
(28, 'ergsrg', 'gresgserg', 55, 8, 1),
(29, 'sergserg', 'sergserg', 5, 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_description` text NOT NULL,
  `grade` tinyint(1) NOT NULL,
  `review_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `review_description`, `grade`, `review_date`) VALUES
(1, 24, 5, 'hdfhrth', 5, '2023-05-27 11:36:41'),
(2, 25, 5, 'ergsegreg', 4, '2023-06-02 19:28:41'),
(3, 25, 5, 'rg ergserg drt g dtrg tr', 5, '2023-06-02 19:29:46'),
(4, 25, 5, 'nfht ftynft ftyn  fyt', 5, '2023-06-02 19:31:31'),
(5, 27, 5, 'rtyhryth ytr hry', 2, '2023-06-02 19:32:10');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `location` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_pass` varchar(255) NOT NULL,
  `server` varchar(255) NOT NULL,
  `port` varchar(11) NOT NULL,
  `email_security` varchar(255) NOT NULL,
  `num` varchar(20) NOT NULL,
  `facebook` text NOT NULL,
  `instagram` text NOT NULL,
  `etp_name` text NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `immatriculation_number` varchar(15) NOT NULL,
  `host_name` varchar(255) NOT NULL,
  `host_location` text NOT NULL,
  `host_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `location`, `email`, `email_pass`, `server`, `port`, `email_security`, `num`, `facebook`, `instagram`, `etp_name`, `first_name`, `last_name`, `statut`, `immatriculation_number`, `host_name`, `host_location`, `host_number`) VALUES
(1, '', 'billy.rogier@free.fr', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `num` varchar(20) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `num`, `adress`, `type`, `creation_date`) VALUES
(5, 'billy', 'drht', 'billy.rogier@free.fr', '$2y$10$MiyatJfiWmxzv8RaKSm3n.h6WAdIqct8Cn9fnRpLAZfdyBEobIbS6', '', 'drth', 2, '2023-05-17 20:37:54'),
(14, '', '', 'sylvie.rogier@free.fr', '$2y$10$mIMiUyz8eMplSAgH0i1bKu4p5Pdw4TCnkT5zOuTjq0Fe/WK.sizum', '', '', 0, '2023-06-02 12:10:58');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`carousel_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`category_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`category_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `carousel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `categorys`
--
ALTER TABLE `categorys`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `carousel`
--
ALTER TABLE `carousel`
  ADD CONSTRAINT `carousel_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categorys` (`category_id`);

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
