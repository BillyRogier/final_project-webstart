-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 26 juin 2023 à 10:06
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
(58, '64dbd02f6549d5038f506d968d74403e.jpg', 'Tamper 58mm avec manche en bois damier', 1, 34),
(59, '41d79673fec297f8f99168c744a0a922.jpg', 'Tamper 58mm avec manche en bois', 1, 35),
(60, '8f2215a2a0de3ab0901b9cc96000d3c1.jpg', 'Tamper 58mm avec manche en bois damier', 1, 36),
(61, '58270f35229adb0f58becc1ec1311fc6.jpg', 'Tamper 57mm noir', 1, 37),
(62, '6e6650cffba5a2031b93b56dbdef0c58.jpg', 'Tamper 57mm noir', 2, 37),
(65, 'be9106b386ad3091ec175302adfddff0.jpg', 'Tamper 54mm noir', 1, 38),
(66, 'c29a64b5082477dd2b884c05223ca929.png', 'Tamper 54mm bleu marine', 1, 39),
(67, 'b615d606a5a4815345016d71ec92d483.png', 'Tamper 58mm rouge', 1, 40),
(68, '732528d2961359821df62ced8ac188a7.png', 'Tamper 57mm en acier inoxydable', 1, 41),
(69, '6740f4e0f403a1b6c1c022de9ca79e87.png', 'Tamper 58mm avec manche en bois de noyer', 1, 42),
(70, '97aefb01cf8b1ac7e213d857a5cc2e7d.png', 'Tamper 58mm avec manche en bois d\'olivier', 1, 43),
(71, '6bf7a115c08329e544711debedbe47eb.jpg', 'Porte filtre 58mm 1 bec', 1, 44),
(72, '10a46c29217db8ac8ca5bfee7d5bc3d0.jpg', 'Porte filtre 58mm 1 bec', 1, 45),
(73, 'f6ee1a69f044ae2e521562fd521775f7.jpg', 'Porte filtre 57mm 2 bec', 1, 46),
(74, 'a378116da3a258140cbbff89c39a25a3.jpg', 'Porte filtre 57mm 1 bec', 1, 47),
(75, 'e7784c7ba67de23fc28c69c343e55297.jpg', 'Porte filtre bottomless 58mm', 1, 48),
(76, '294c8be65e58178db4fe0b1e0bddbcb2.jpg', 'Porte filtre bottomless 54mm avec manche en bois', 1, 49),
(78, 'da8eb6a72bdef02ab76878b59c062462.jpg', 'Porte filtre bottomless 51mm avec manche en bois', 1, 50),
(79, 'b050d83b5ca76d38d48397912afd6445.jpg', 'Porte filtre bottomless 51mm avec manche en bois', 2, 50),
(80, '4d33bbaca7da086bd8031ad6b06466a4.jpg', 'Porte filtre bottomless 51mm avec manche en bois', 3, 50),
(81, '6499555dbb68b.jpg', 'Porte filtre bottomless 51mm avec manche en bois', 4, 50),
(82, '649955e69f40d.jpg', 'Tamper 54mm noir', 3, 38),
(83, '6499561028026.jpg', 'Tamper 54mm noir', 2, 38),
(84, '895b1388e603f0704ea3cce8a7ea082b.jpg', 'Porte filtre bottomless 54mm avec manche en bois', 1, 51),
(85, '76c604c924c15584b95387e1aa492681.jpg', 'Porte filtre bottomless 58mm avec manche en bois', 1, 52),
(86, '2ef817fb6acf48bf0e99880939a7b240.jpg', 'Porte filtre bottomless 58mm avec manche en bois', 2, 52),
(87, '2a375d4905638aa1657c738656f09b50.jpg', 'Porte filtre bottomless 58mm avec manche en bois', 3, 52),
(88, '0b3603258b34d9663aaa75694a4b3128.jpg', 'Porte filtre bottomless 58mm avec manche en bois', 4, 52),
(89, '18e6f1b2650d2d0609f010366e3a976f.jpg', 'Porte filtre 58mm 2 becs avec manche en bois', 1, 53),
(90, '8727ec3ace45f5c7d5dc1a768d0e52ec.jpg', 'Porte filtre 58mm 2 becs avec manche en bois', 2, 53),
(91, '8d60d1379ee3db88e165fd6f8d6e8137.jpg', 'Porte filtre 58mm 2 becs avec manche en bois', 3, 53),
(92, 'f18f8ab2b34dd45232d3032982d9d113.jpg', 'Répartiteurs de mouture 58mm', 1, 54),
(93, 'a48a25a7042569986aafe64923d87eec.jpg', 'Répartiteurs de mouture 58mm', 2, 54),
(94, 'ac236e9734288af3bec7244991dc8e8a.jpg', 'Répartiteurs de mouture 58mm finition bois', 1, 55),
(95, '0509d2ec5eeae4a91002a7bdda3d33f6.jpg', 'Répartiteurs de mouture 58mm finition bois', 2, 55),
(96, 'a151e463b9f384f7d25437dfc3c18226.jpg', 'Répartiteurs de mouture 54mm', 1, 56),
(97, '3a3129da7a7df9a9ff1ff02d8e3fa536.jpg', 'Répartiteurs de mouture 57mm', 1, 57),
(98, 'a6fad7ab9907189d1959359fab889f7a.png', 'Répartiteurs de mouture 54mm finition bois', 1, 58),
(99, '980b5cc4cd375d38cfdc33cde80c6e57.jpg', 'Répartiteurs de mouture 54mm finition bois', 2, 58),
(100, 'd7ca59a3a488fe4328ee69018e653c71.jpg', 'Répartiteurs de mouture 57mm finition bois', 1, 59),
(101, '50a00fd907ea3d0a09796ccfcf3b628a.jpg', 'Répartiteurs de mouture 54mm', 1, 60),
(102, 'f7d7c71432b393840845abd3b4e02cb6.jpg', 'Répartiteurs de mouture 54mm', 2, 60),
(103, 'cf51543838c12764713a7d4b1dbd27a8.jpg', 'Répartiteurs de mouture 54mm', 3, 60),
(104, '72da6bfc321f5ee9dde1e3d54bd9fe93.jpg', 'Répartiteurs de mouture 54mm', 4, 60),
(105, 'c70e5d1c9bca75b9706a16b1fb0753c3.jpg', 'Répartiteurs de mouture 51mm finition bois', 1, 61),
(106, '6ed3d75e6f25a2a78287b1fe1cba5f6f.jpg', 'Répartiteurs de mouture 51mm finition bois', 2, 61),
(107, '9b146cd6893a77ba721f88b0b920dd2d.jpg', 'Répartiteurs de mouture 51mm finition bois', 3, 61),
(108, '3baa24ee431c85d49d70a7a0c0ddf37e.jpg', 'Répartiteurs de mouture 51mm finition bois', 4, 61),
(109, 'de66f2ff67b75c1aefb27e23ff16d417.jpg', 'Répartiteurs de mouture 51mm', 1, 62),
(110, 'e8314973ec75cfb49add31f125438a0e.jpg', 'Répartiteurs de mouture 51mm', 2, 62),
(111, 'aa40be45f7d25050138195497ce6dbbf.jpg', 'Répartiteurs de mouture 58mm', 1, 63),
(112, '388a910de873352bced24469573f8e51.jpg', 'Répartiteurs de mouture 58mm', 2, 63),
(113, 'ec010e0390f278091cee3b83d68b5e22.jpg', 'Répartiteurs de mouture 58mm', 3, 63),
(114, '28c298d4bf5f96707c24fe728cb96e82.jpg', 'Répartiteurs de mouture 58mm', 4, 63);

-- --------------------------------------------------------

--
-- Structure de la table `categorys`
--

CREATE TABLE `categorys` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_img` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorys`
--

INSERT INTO `categorys` (`category_id`, `category_name`, `category_img`, `alt`, `url`) VALUES
(14, 'Tampers', '1687766860.jpg', 'Tampers', 'tampers'),
(15, 'Porte-filtres', '1687767081.jpg', 'Porte-filtres', 'porte-filtres'),
(16, 'Répartiteurs de mouture', '1687766898.jpg', 'Répartiteurs de mouture', 'repartiteurs-de-mouture');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(34, 'Tamper 58mm avec manche en bois damier', 'Le Tamper 58mm avec manche en bois damier est un accessoire de café haut de gamme. Avec son design élégant et son manche en bois damier, il apporte une touche de sophistication à votre expérience de préparation du café. Ce tamper de précision est conçu pour tasser uniformément la mouture dans le porte-filtre, assurant ainsi une extraction optimale des arômes. Son diamètre de 58mm convient parfaitement aux machines à café professionnelles et domestiques. Offrez-vous ce Tamper 58mm manche bois damier pour sublimer votre rituel café et obtenir des résultats exceptionnels à chaque tasse.', 100, 14, 1),
(35, 'Tamper 58mm avec manche en bois', 'Le Tamper 58mm avec manche bois est l&#039;outil idéal pour tasser uniformément votre café moulu dans le porte-filtre de votre machine à expresso. Avec son diamètre de 58mm, il convient parfaitement à la plupart des machines professionnelles et domestiques. Son manche en bois offre une prise en main confortable et apporte une touche d&#039;élégance à votre rituel du café. Obtenez une extraction optimale et savourez des shots d&#039;espresso parfaitement équilibrés grâce au Tamper 58mm avec manche bois.', 150, 14, 1),
(36, 'Tamper 58mm avec manche en bois damier', 'Le Tamper 58mm manche bois damier est un accessoire de café haut de gamme. Avec son design élégant et son manche en bois damier, il apporte une touche de sophistication à votre expérience de préparation du café. Ce tamper de précision est conçu pour tasser uniformément la mouture dans le porte-filtre, assurant ainsi une extraction optimale des arômes. Son diamètre de 58mm convient parfaitement aux machines à café professionnelles et domestiques. Offrez-vous ce Tamper 58mm manche bois damier pour sublimer votre rituel café et obtenir des résultats exceptionnels à chaque tasse.', 35, 14, 1),
(37, 'Tamper 57mm noir', 'Le Tamper 57mm noir est un outil essentiel pour les amateurs de café. Fabriqué avec soin, il est conçu pour tasser uniformément la mouture dans le porte-filtre, garantissant ainsi une extraction optimale des arômes. Avec son diamètre de 57mm, il convient parfaitement aux machines à espresso professionnelles et domestiques. Son design élégant en noir lui confère une allure moderne et sophistiquée. Pratique et facile à utiliser, le Tamper 57mm noir est l&#039;accessoire indispensable pour obtenir un café parfaitement préparé à chaque fois.', 30, 14, 1),
(38, 'Tamper 54mm noir', 'Le Tamper 54mm noir est l&#039;accessoire parfait pour les amateurs de café exigeants. Avec son design élégant et sa finition noire, il ajoute une touche de sophistication à votre expérience de préparation du café. Fabriqué avec des matériaux de haute qualité, ce tamper assure une pression uniforme et constante pour tasser votre café moulu, vous permettant ainsi d&#039;obtenir une extraction optimale de vos arômes préférés. Compact et facile à utiliser, le Tamper 54mm noir est un indispensable pour tous les passionnés de café à la recherche de la perfection.', 35, 14, 1),
(39, 'Tamper 54mm bleu marine', 'Le Tamper 54mm bleu marine est un outil essentiel pour tous les amateurs de café. Avec sa taille compacte et sa couleur élégante, il offre une prise en main confortable et facilite le tassage précis de votre café moulu dans le porte-filtre. Fabriqué avec des matériaux de haute qualité, ce tamper assure une pression uniforme pour obtenir une extraction optimale et une délicieuse tasse de café. Son design minimaliste et sa finition bleu marine en font également un ajout esthétique à votre collection d&#039;accessoires de café.', 50, 14, 1),
(40, 'Tamper 58mm rouge', 'Tamper 58mm rouge est un accessoire indispensable pour tous les amateurs de café. Avec son design élégant et sa couleur rouge vibrante, ce tamper ajoute une touche de style à votre rituel du matin. Fabriqué avec des matériaux de haute qualité, il offre une prise en main confortable et une résistance durable. Son diamètre de 58mm le rend idéal pour tasser uniformément la mouture de café dans votre porte-filtre, garantissant ainsi une extraction parfaite de votre espresso. Le Tamper 58mm rouge est un choix parfait pour les baristas amateurs ou professionnels qui cherchent à améliorer leur expérience de préparation du café.', 25, 14, 1),
(41, 'Tamper 57mm en acier inoxydable', 'Le Tamper en acier inoxydable de 57mm est un outil indispensable pour les amateurs de café exigeants. Fabriqué entièrement en acier inoxydable, ce tamper offre une durabilité exceptionnelle et une résistance à la corrosion. Avec un diamètre de 57mm, il est parfaitement adapté aux filtres à café de taille standard. Sa conception ergonomique offre une prise en main confortable, permettant une utilisation précise et efficace. Le Tamper en acier inoxydable de 57mm est l&#039;accessoire idéal pour préparer un café parfaitement tassé et savoureux.', 50, 14, 1),
(42, 'Tamper 58mm avec manche en bois de noyer', 'Le Tamper 58mm avec manche en bois de noyer est l&#039;accessoire idéal pour les amateurs de café exigeants. Avec son design élégant et sa construction de haute qualité, ce tamper offre une prise en main confortable grâce à son manche en bois de noyer naturellement résistant et durable. Sa base de 58mm assure une répartition uniforme de la pression lors du tassage du café, permettant ainsi d&#039;obtenir une extraction optimale des arômes. Ajoutez une touche de sophistication à votre rituel café avec le Tamper 58mm en bois de noyer.', 40, 14, 1),
(43, 'Tamper 58mm avec manche en bois d&#039;olivier', 'Le Tamper 58mm avec manche en bois d&#039;olivier est un accessoire élégant et fonctionnel pour les amateurs de café exigeants. Fabriqué avec soin, il est doté d&#039;un manche en bois d&#039;olivier de qualité supérieure, offrant une sensation naturelle et agréable lors de la préparation du café. Avec un diamètre de 58mm, ce tamper est parfaitement adapté pour tasser le café moulu dans le porte-filtre de votre machine à espresso, assurant ainsi une extraction optimale des arômes. Sa conception solide et son esthétique raffinée en font un outil indispensable pour les passionnés de café qui recherchent la perfection à chaque tasse.', 50, 14, 1),
(44, 'Porte filtre 58mm 1 bec', 'Le porte-filtre 58mm 1 bec est un accessoire pratique pour les amateurs de café. Ce porte-filtre compact et polyvalent vous permet de préparer facilement une délicieuse tasse de café. Il est conçu pour s&#039;adapter aux machines à café standard équipées d&#039;un porte-filtre de 58mm. Sa conception robuste et son bec unique facilitent le processus de préparation du café, en assurant une extraction optimale des arômes et en offrant un contrôle précis du débit. Que vous soyez un passionné de café à domicile ou un barista professionnel, le porte-filtre 58mm 1 bec est l&#039;accessoire idéal pour sublimer votre expérience de dégustation du café.', 50, 15, 1),
(45, 'Porte filtre 58mm 2 bec', 'Le porte-filtre 58mm 2 becs est un accessoire pratique et polyvalent pour les amateurs de photographie. Il est spécialement conçu pour accueillir des filtres de 58 mm de diamètre et dispose de deux becs, ce qui permet d&#039;utiliser simultanément deux filtres différents pour obtenir des effets créatifs ou ajuster la lumière selon vos besoins. Fabriqué avec des matériaux de qualité, ce porte-filtre offre une installation facile et sécurisée sur votre objectif, garantissant ainsi des résultats professionnels. Que vous soyez un photographe débutant ou expérimenté, le porte-filtre 58mm 2 becs sera un outil essentiel pour améliorer votre créativité et votre maîtrise de la lumière lors de vos prises de vue.', 60, 15, 1),
(46, 'Porte filtre 57mm 2 bec', 'Le porte-filtre 57mm à 2 becs est un accessoire pratique et polyvalent pour les amateurs de café. Conçu pour s&#039;adapter aux machines à expresso, ce porte-filtre permet de préparer simultanément deux tasses de café délicieusement aromatique. Sa taille compacte facilite son utilisation et son rangement, tandis que sa construction robuste garantit une durabilité à long terme. Ajoutez une touche de sophistication à votre expérience de dégustation de café avec ce porte-filtre élégant et fonctionnel.', 60, 15, 1),
(47, 'Porte filtre 57mm 1 bec', 'Le porte-filtre de 57 mm à un bec est un accessoire pratique et essentiel pour les amateurs de café. Il est conçu pour maintenir fermement le filtre à café et permettre un passage fluide de l&#039;eau chaude à travers le café moulu. Avec son diamètre de 57 mm, il s&#039;adapte parfaitement à la plupart des machines à café. Son bec permet un versement précis et contrôlé de l&#039;eau, offrant ainsi une expérience de brassage optimale. Fabriqué avec des matériaux durables et de haute qualité, ce porte-filtre est conçu pour durer et garantir une extraction de café exceptionnelle à chaque utilisation.', 50, 15, 1),
(48, 'Porte filtre bottomless 58mm', 'Le porte-filtre bottomless de 58 mm est un accessoire essentiel pour les amateurs de café exigeants. Conçu pour les machines à espresso professionnelles, ce porte-filtre permet une extraction optimale de l&#039;arôme et de la saveur du café. Sa conception sans fond offre une vue dégagée du processus d&#039;infusion, permettant de contrôler précisément la qualité de l&#039;extraction. Fabriqué avec des matériaux de haute qualité, ce porte-filtre est à la fois robuste et durable. Offrez-vous une expérience café exceptionnelle avec le porte-filtre bottomless 58 mm.', 60, 15, 1),
(49, 'Porte filtre bottomless 54mm avec manche en bois', 'Le porte-filtre bottomless de 54 mm avec manche en bois est un accessoire élégant et pratique pour les amateurs de café. Sa conception unique sans fond permet de visualiser le processus d&#039;extraction, ce qui permet de perfectionner la technique et d&#039;obtenir des résultats optimaux. Fabriqué avec un manche en bois de qualité, il offre une prise en main confortable et une esthétique chaleureuse. Cet accessoire est un incontournable pour les connaisseurs de café qui souhaitent découvrir tous les arômes et les nuances de leur boisson préférée.', 70, 15, 1),
(50, 'Porte filtre bottomless 51mm avec manche en bois', 'Le porte-filtre bottomless 51mm avec manche en bois est un accessoire essentiel pour les amateurs de café. Fabriqué avec soin, ce porte-filtre de qualité supérieure offre une expérience de brassage exceptionnelle. Sa conception sans fond permet une visualisation claire de l&#039;extraction du café, ce qui permet d&#039;ajuster facilement la mouture et la distribution du café pour obtenir des résultats parfaits. Le manche en bois ajoute une touche d&#039;élégance et offre une prise en main confortable. Cet accessoire est idéal pour les baristas et les passionnés de café qui souhaitent atteindre l&#039;excellence dans leur tasse.', 70, 15, 1),
(51, 'Porte filtre bottomless 54mm avec manche en bois', 'Le porte-filtre bottomless de 54 mm avec manche en bois est un accessoire de qualité pour les amateurs de café. Sa conception sans fond permet de visualiser la formation du café, offrant une expérience de brassage unique. Le manche en bois apporte une touche d&#039;élégance et de chaleur, ajoutant une sensation agréable lors de la manipulation. Ce porte-filtre est parfait pour les connaisseurs de café qui recherchent à la fois esthétisme et fonctionnalité.', 60, 15, 1),
(52, 'Porte filtre bottomless 58mm avec manche en bois', 'Le porte-filtre bottomless de 58 mm avec manche en bois est l&#039;accessoire parfait pour les amateurs de café. Sa conception élégante et fonctionnelle permet de préparer un espresso de qualité supérieure. Le manche en bois ajoute une touche de chaleur et de sophistication, tandis que le fond ouvert du porte-filtre offre une visualisation claire de l&#039;écoulement du café, permettant ainsi un contrôle optimal du processus d&#039;extraction. Cet outil est un incontournable pour tous les passionnés de café qui recherchent une expérience de brassage exceptionnelle.', 90, 15, 1),
(53, 'Porte filtre 58mm 2 becs avec manche en bois', 'Le porte-filtre 58mm à double bec avec manche en bois est l&#039;accessoire parfait pour les amateurs de café. Fabriqué avec soin, il vous permet de préparer facilement et rapidement votre café filtré préféré. Son design compact et élégant s&#039;adapte à tous les types de tasses et de mugs. La poignée en bois offre une prise en main confortable et ajoute une touche naturelle à votre expérience café. Que vous soyez chez vous, au bureau ou en déplacement, ce porte-filtre pratique est un incontournable pour les amateurs de café exigeants.', 100, 15, 1),
(54, 'Répartiteurs de mouture 58mm', 'Les Répartiteurs de mouture 58mm sont des outils essentiels pour les passionnés de café. Avec leur conception précise et leur taille idéale de 58mm, ils permettent une répartition uniforme de la mouture dans le porte-filtre. Cela garantit une extraction optimale des arômes, donnant ainsi une tasse de café parfaite à chaque fois. Les Répartiteurs de mouture 58mm sont indispensables pour les baristas professionnels et les amateurs exigeants qui recherchent une expérience café exceptionnelle.', 30, 16, 1),
(55, 'Répartiteurs de mouture 58mm finition bois', 'Les Répartiteurs de mouture 58mm finition bois sont des outils élégants et pratiques pour les amateurs de café. Fabriqués avec soin, ils offrent une répartition précise et uniforme de la mouture, garantissant ainsi une extraction optimale des arômes. Leur design en bois apporte une touche chaleureuse et naturelle à votre rituel de préparation du café. Les Répartiteurs de mouture 58mm finition bois sont l&#039;accessoire parfait pour les connaisseurs de café qui recherchent à la fois la performance et l&#039;esthétique.', 50, 16, 1),
(56, 'Répartiteurs de mouture 54mm', 'Les Répartiteurs de mouture 54mm sont des outils indispensables pour les amateurs de café exigeants. Avec leur design compact et ergonomique, ces répartiteurs vous permettent de répartir uniformément la mouture dans votre porte-filtre, garantissant ainsi une extraction optimale des arômes. Leur taille de 54 mm les rend parfaits pour une utilisation avec des machines à expresso domestiques et professionnelles. Simplifiez votre processus de préparation du café et obtenez des résultats de qualité supérieure grâce aux Répartiteurs de mouture 54mm.', 30, 16, 1),
(57, 'Répartiteurs de mouture 57mm', 'Les répartiteurs de mouture 57 mm sont des outils essentiels pour les amateurs de café qui veulent obtenir une mouture uniforme et précise. Grâce à leur design compact et ergonomique, ces répartiteurs facilitent le nivellement de la mouture dans le panier du porte-filtre. Ils sont conçus pour s&#039;adapter parfaitement aux moulins à café de 57 mm et offrent une distribution régulière du café moulu, ce qui permet d&#039;obtenir une extraction optimale et une tasse de café délicieusement équilibrée. Avec les répartiteurs de mouture 57 mm, préparer un café de qualité professionnelle est à la portée de tous les passionnés de café.', 30, 16, 1),
(58, 'Répartiteurs de mouture 54mm finition bois', 'Les Répartiteurs de mouture 54mm en finition bois sont des accessoires pratiques et esthétiques pour les amateurs de café. Ces répartiteurs de mouture de haute qualité sont conçus pour une utilisation précise et uniforme de la mouture de café. Leur finition en bois ajoute une touche d&#039;élégance à votre rituel de préparation du café. Profitez d&#039;une distribution homogène de votre mouture et d&#039;une expérience de café exceptionnelle avec ces répartiteurs de mouture 54mm en finition bois.', 50, 16, 1),
(59, 'Répartiteurs de mouture 57mm finition bois', 'Les répartiteurs de mouture 57mm avec finition bois sont des outils pratiques et esthétiques pour les amateurs de café. Ces répartiteurs de mouture sont conçus avec précision pour distribuer uniformément la mouture dans le porte-filtre de votre machine à café. Leur taille compacte de 57mm les rend faciles à utiliser et à manipuler. De plus, leur finition en bois ajoute une touche chaleureuse et élégante à votre rituel de préparation du café. Les répartiteurs de mouture 57mm avec finition bois sont un choix idéal pour les passionnés de café qui recherchent à la fois fonctionnalité et esthétique dans leurs accessoires de café.', 45, 16, 1),
(60, 'Répartiteurs de mouture 54mm', 'Les Répartiteurs de mouture 54mm sont des outils essentiels pour les amateurs de café qui cherchent à obtenir une extraction parfaite. Avec leur conception précise et leur diamètre de 54 mm, ces répartiteurs assurent une distribution uniforme de la mouture dans le porte-filtre. Cela permet d&#039;obtenir une extraction homogène, en maximisant les saveurs et les arômes du café. Les répartiteurs de mouture 54mm sont l&#039;accessoire idéal pour les passionnés de café qui recherchent une tasse de qualité professionnelle à chaque préparation.', 30, 16, 1),
(61, 'Répartiteurs de mouture 51mm finition bois', 'Les répartiteurs de mouture 51mm avec finition bois sont des outils élégants et pratiques pour les amateurs de café. Leur conception compacte et leur finition en bois ajoutent une touche de sophistication à votre expérience de préparation du café. Ces répartiteurs sont conçus pour distribuer uniformément la mouture dans le porte-filtre, garantissant ainsi une extraction optimale des arômes et une tasse de café délicieuse à chaque fois. Avec leur taille de 51mm, ils conviennent parfaitement aux machines à expresso domestiques et professionnelles. Simplifiez votre rituel de préparation du café avec les répartiteurs de mouture 51mm finition bois, et profitez d&#039;un café parfaitement préparé chez vous.', 35, 16, 1),
(62, 'Répartiteurs de mouture 51mm', 'Les Répartiteurs de Mouture 51mm sont des outils essentiels pour les amateurs de café exigeants. Avec leur taille compacte, ces répartiteurs de haute qualité permettent de distribuer uniformément la mouture dans le porte-filtre. Grâce à leur précision et à leur design ergonomique, ils garantissent une extraction optimale des arômes du café. Les Répartiteurs de Mouture 51mm sont l&#039;accessoire parfait pour obtenir une tasse de café parfaite à chaque fois.', 30, 16, 1),
(63, 'Répartiteurs de mouture 58mm', 'Les répartiteurs de mouture 58mm sont des outils essentiels pour les passionnés de café. Ils sont conçus pour distribuer de manière uniforme la mouture du café dans le panier de la machine à espresso. Grâce à leur taille de 58mm, ils s&#039;adaptent parfaitement aux portes-filtres couramment utilisés dans les machines à espresso professionnelles et domestiques. Les répartiteurs de mouture assurent une extraction homogène du café, ce qui permet d&#039;obtenir des shots d&#039;espresso de qualité supérieure, avec une extraction maximale des arômes et des saveurs. Cet accessoire pratique et précis vous aidera à atteindre une cohérence parfaite dans la préparation de votre café, pour des résultats savoureux à chaque tasse.', 35, 16, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review_title` varchar(255) NOT NULL,
  `review_description` text NOT NULL,
  `review_img` varchar(255) DEFAULT NULL,
  `grade` tinyint(1) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `host_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `location`, `email`, `email_pass`, `server`, `port`, `email_security`, `num`, `facebook`, `instagram`, `etp_name`, `first_name`, `last_name`, `statut`, `immatriculation_number`, `host_name`, `host_location`, `host_number`) VALUES
(1, '123 Rue du Café, 75000 Paris, France', 'billy.rogier@free.fr', '', '', '', '', '0102030405', 'https://www.facebook.com', 'https://www.instagram.com', 'Espresso Tools', '', '', '', '', 'Hostinger', 'UAB Rue Jonavos 60C, Kaunas 44192 Lituanie', '+3 70 64 50 33 78');

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
(19, 'Billy', 'Rogier', 'billy.rogier@free.fr', '$2y$10$Sc3.Jb.HabMn/fJwYvnGMO5Jm6ycVb2h69Qp/x6R4MW/G4KaKDEey', '', 'grsthdrthdrth drtdrt hthr', 2, '2023-06-23 15:08:45');

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
  MODIFY `carousel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT pour la table `categorys`
--
ALTER TABLE `categorys`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
