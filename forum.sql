-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de table forum_erwin. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.category : ~7 rows (environ)
INSERT INTO `category` (`id_category`, `name`, `photo`) VALUES
	(34, 'football', 'image football.jpg'),
	(35, 'basket', 'basket.jpg'),
	(36, 'handball', 'handball.jpg'),
	(37, 'volleyball', 'volleyball.jpg'),
	(38, 'tennis de table', 'tennis de table.png'),
	(39, 'athl&eacute;tisme', 'athletisme.jpg'),
	(40, 'tennis', 'tennis.jpeg');

-- Listage de la structure de table forum_erwin. commentpost
CREATE TABLE IF NOT EXISTS `commentpost` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `text` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `commentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` int DEFAULT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_comment`) USING BTREE,
  KEY `FK_commentpost_post` (`post_id`),
  KEY `FK_commentpost_user` (`user_id`),
  CONSTRAINT `FK_commentpost_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id_message`) ON DELETE CASCADE,
  CONSTRAINT `FK_commentpost_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=332 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.commentpost : ~168 rows (environ)
INSERT INTO `commentpost` (`id_comment`, `text`, `commentDate`, `post_id`, `user_id`) VALUES
	(17, 'Pelé est une légende, mais Messi a prouvé qu\'il est l\'ultime talent de l\'histoire du football.', '2025-01-24 17:10:10', 179, 13),
	(18, 'Pelé a aussi eu une équipe formidable autour de lui, ce qui explique son succès.', '2025-01-24 17:10:10', 179, 14),
	(19, 'Mais Pelé a dominé une époque entière, ce qui est impressionnant.', '2025-01-24 17:10:10', 179, 15),
	(20, 'Pelé a joué dans une équipe moins compétitive, ce qui n\'enlève rien à ses performances.', '2025-01-24 17:10:10', 179, 19),
	(21, 'Messi a joué contre de nombreuses équipes européennes de haut niveau, ce qui le place au-dessus.', '2025-01-24 17:10:10', 179, 23),
	(22, 'Messi est inégalable, Ronaldo a toujours eu de l\'aide autour de lui.', '2025-01-24 17:16:43', 180, 1),
	(23, 'Ronaldo a marqué dans toutes les ligues, il faut le reconnaître.', '2025-01-24 17:16:43', 180, 13),
	(24, 'Messi a ce quelque chose en plus, c\'est un joueur unique dans l\'histoire du football.', '2025-01-24 17:16:43', 180, 15),
	(25, 'Ronaldo est un travailleur acharné, mais Messi a plus de talent brut.', '2025-01-24 17:16:43', 180, 19),
	(26, 'Ronaldo a une meilleure condition physique, mais Messi est plus créatif.', '2025-01-24 17:16:43', 180, 23),
	(32, 'Le Barça a encore de bons jeunes talents, mais ils doivent se reconstruire autour d\'un leader.', '2025-01-24 17:21:43', 181, 14),
	(33, 'Je pense qu\'ils peuvent revenir, mais cela va prendre plusieurs années.', '2025-01-24 17:21:43', 181, 19),
	(34, 'Ils doivent investir dans un nouveau projet et repenser leur approche.', '2025-01-24 17:21:43', 181, 23),
	(35, 'Le Barça devra aussi se renforcer en défense s\'ils veulent revenir au plus haut niveau.', '2025-01-24 17:21:43', 181, 13),
	(36, 'Avec les bons choix, je suis sûr qu\'ils reviendront, mais ils doivent changer de stratégie.', '2025-01-24 17:21:43', 181, 1),
	(37, 'La Premier League reste au-dessus grâce à son niveau global et ses équipes compétitives.', '2025-01-24 17:25:19', 182, 13),
	(38, 'La Liga est plus technique, mais la Premier League a plus d\'intensité.', '2025-01-24 17:25:19', 182, 14),
	(39, 'La Premier League a plus de clubs compétitifs chaque année.', '2025-01-24 17:25:19', 182, 19),
	(40, 'La Liga reste un championnat plus technique, mais la Premier League a un meilleur niveau général.', '2025-01-24 17:25:19', 182, 23),
	(42, 'L\'Allemagne avait une équipe ultra-cohérente, c\'est ce qui les a menés à la victoire.', '2025-01-24 17:27:36', 183, 2),
	(43, 'Ils étaient incroyablement solides défensivement et avaient une attaque redoutable.', '2025-01-24 17:27:36', 183, 19),
	(44, 'L\'Allemagne a toujours été une équipe très bien structurée avec un mental d\'acier.', '2025-01-24 17:27:36', 183, 23),
	(46, 'Le collectif allemand a fait la différence face à des équipes plus talentueuses mais moins organisées.', '2025-01-24 17:27:36', 183, 13),
	(48, 'Les équipes africaines ont du talent, mais elles ont besoin de plus de stabilité pour gagner.', '2025-01-24 17:29:27', 185, 26),
	(49, 'Les meilleures équipes africaines peuvent rivaliser avec les meilleures d\'Europe, c\'est juste une question de mentalité.', '2025-01-24 17:29:27', 185, 1),
	(50, 'Avec les bons investissements et un peu de chance, une équipe africaine peut finir championne.', '2025-01-24 17:29:27', 185, 14),
	(51, 'Les équipes africaines sont déjà très compétitives, mais la pression est différente en Coupe du Monde.', '2025-01-24 17:29:27', 185, 19),
	(52, 'Le football féminin progresse de manière impressionnante, il faut encore plus de visibilité.', '2025-01-24 17:31:36', 186, 1),
	(54, 'Il est grand temps que les ligues féminines aient plus de financement et de visibilité.', '2025-01-24 17:31:36', 186, 26),
	(55, 'Les progrès du football féminin sont évidents, mais il y a encore du travail à faire pour l\'égalité.', '2025-01-24 17:31:36', 186, 19),
	(56, 'Les équipes féminines commencent à attirer plus de fans, ce qui est encourageant.', '2025-01-24 17:31:36', 186, 23),
	(57, 'Le PSG doit se concentrer sur la création d\'un collectif plutôt que d\'accumuler les stars.', '2025-01-24 17:37:29', 187, 2),
	(58, 'Le PSG a les ressources pour continuer à dominer, mais ils doivent résoudre leurs problèmes internes.', '2025-01-24 17:37:29', 187, 13),
	(59, 'Ils ont l\'équipe pour gagner, mais l\'équilibre est essentiel pour arriver à leurs objectifs.', '2025-01-24 17:37:29', 187, 23),
	(61, 'Je pense que le PSG pourrait devenir une dynastie si leur équipe se stabilise.', '2025-01-24 17:37:29', 187, 1),
	(62, 'Les supporters jouent un rôle essentiel, surtout dans les moments cruciaux des matchs.', '2025-01-24 17:39:04', 184, 19),
	(63, 'Ils sont la motivation qui permet aux équipes de donner le meilleur d\'elles-mêmes.', '2025-01-24 17:39:04', 184, 23),
	(65, 'Mais parfois la pression des supporters peut aussi rendre les joueurs nerveux.', '2025-01-24 17:39:04', 184, 1),
	(66, 'Une équipe qui a des supporters en feu peut aller très loin dans un tournoi.', '2025-01-24 17:39:04', 184, 13),
	(67, 'Certains joueurs ne réussissent pas car l\'adaptation à un nouveau système ou à une nouvelle pression est difficile.', '2025-01-24 17:41:13', 188, 13),
	(68, 'Le manque de confiance et d\'adaptation est souvent la raison des échecs après un transfert.', '2025-01-24 17:41:13', 188, 14),
	(69, 'Un changement d\'environnement peut perturber un joueur, surtout si l\'équipe ne correspond pas à son style.', '2025-01-24 17:41:13', 188, 19),
	(70, 'Le problème peut aussi être dans la gestion des attentes : trop de pression, parfois.', '2025-01-24 17:41:13', 188, 23),
	(72, 'Jordan a dominé son époque, mais LeBron a un impact bien plus global.', '2025-01-24 17:57:03', 189, 13),
	(73, 'LeBron est plus complet, mais Jordan reste l\'icône du basket pour les fans de la vieille école.', '2025-01-24 17:57:03', 189, 14),
	(74, 'Jordan a remporté six titres NBA, il n\'y a pas de débat, c\'est le GOAT.', '2025-01-24 17:57:03', 189, 1),
	(75, 'LeBron a aussi une incroyable longévité, mais Jordan reste le plus dominant dans ses années.', '2025-01-24 17:57:03', 189, 19),
	(77, 'Ils ont remporté 2 titres ensemble, mais leur domination n\'a pas duré assez longtemps pour vraiment entrer dans l\'histoire.', '2025-01-24 18:00:36', 190, 13),
	(78, 'Ils ont transformé la NBA et ont dominé pendant quelques années, mais l\'histoire retient les équipes à long terme.', '2025-01-24 18:00:36', 190, 14),
	(79, 'Ils ont redéfini le "superteam", mais la longévité des autres dynasties les place au-dessus.', '2025-01-24 18:00:36', 190, 15),
	(80, 'LeBron et Wade ont dû se partager les responsabilités, ce qui rend leur titre encore plus impressionnant.', '2025-01-24 18:00:36', 190, 19),
	(81, 'Ils ont eu des années incroyables, mais la domination des autres équipes de la même époque les place moins haut dans le palmarès.', '2025-01-24 18:00:36', 190, 23),
	(82, 'Les Lakers restent un gros nom, mais ils doivent se renforcer pour revenir au sommet.', '2025-01-24 18:03:54', 191, 14),
	(83, 'Avec LeBron et Anthony Davis, ils peuvent toujours rivaliser avec les meilleures équipes, mais le temps joue contre eux.', '2025-01-24 18:03:54', 191, 15),
	(84, 'Les Lakers sont toujours une franchise attractive, mais ils doivent récupérer des jeunes talents pour l\'avenir.', '2025-01-24 18:03:54', 191, 19),
	(85, 'Ils ont de la profondeur, mais le manque de régularité de certaines de leurs stars les empêche de dominer à nouveau.', '2025-01-24 18:03:54', 191, 23),
	(87, 'Ils ont un bon noyau avec Garland et Mobley, mais il leur manque encore quelques pièces pour concurrencer.', '2025-01-24 18:06:36', 192, 15),
	(88, 'Cleveland doit absolument bien entourer ses jeunes joueurs pour construire une équipe compétitive sur le long terme.', '2025-01-24 18:06:36', 192, 19),
	(89, 'L\'équipe a du potentiel, mais ils ont besoin de plus d\'expérience pour aller au niveau des top équipes.', '2025-01-24 18:06:36', 192, 23),
	(91, 'Le potentiel est là, mais Cleveland doit faire attention à ne pas trop accélérer leur développement.', '2025-01-24 18:06:36', 192, 26),
	(92, 'Le jeu est plus excitant, mais il manque parfois la rigueur défensive qui faisait la beauté de la NBA des années 90.', '2025-01-24 18:09:02', 193, 14),
	(93, 'La NBA est en train de devenir plus une ligue offensive, mais cela ne veut pas dire que les équipes défensives sont obsolètes.', '2025-01-24 18:09:02', 193, 19),
	(94, 'Le rythme est beaucoup plus rapide, mais je pense que certaines équipes doivent encore se concentrer sur la défense pour être compétitives.', '2025-01-24 18:09:02', 193, 23),
	(96, 'Les jeunes talents apportent une nouvelle dynamique, mais cela nécessite un réajustement dans les systèmes de jeu.', '2025-01-24 18:09:02', 193, 26),
	(97, 'Jordan est celui qui a redéfini la notion de compétitivité en NBA, son mental était incroyable.', '2025-01-24 18:11:36', 194, 13),
	(98, 'Sa capacité à gagner dans les moments-clés fait de lui le meilleur, personne n’a la même intensité.', '2025-01-24 18:11:36', 194, 14),
	(99, 'Jordan a marqué les années 90 et a transcendé son équipe pour en faire une dynastie.', '2025-01-24 18:11:36', 194, 23),
	(101, 'Sa capacité à remporter six titres sans perdre une finale NBA est sans précédent.', '2025-01-24 18:11:36', 194, 26),
	(113, 'Luka Doncic a déjà montré qu\'il pouvait être un leader, c\'est une star qui n\'a pas encore atteint son sommet.', '2025-01-24 18:21:59', 195, 26),
	(114, 'J\'ajouterais Ja Morant à la liste, il est explosif et déjà capable de mener une équipe.', '2025-01-24 18:21:59', 195, 14),
	(115, 'Je pense que Trae Young est également un joueur à suivre, il est déjà super influent à Atlanta.', '2025-01-24 18:21:59', 195, 15),
	(116, 'Les talents sont là, mais il faut voir comment ces jeunes joueurs s’adaptent à la pression des années à venir.', '2025-01-24 18:21:59', 195, 19),
	(123, 'Ils ont de bons joueurs comme Zach LaVine, mais ils ont besoin de plus de stabilité et de leadership pour retourner au sommet.', '2025-01-24 18:24:06', 196, 23),
	(124, 'Je pense que si la gestion de l\'équipe change et qu\'ils recrutent mieux, les Bulls pourraient retrouver leur compétitivité.', '2025-01-24 18:24:06', 196, 19),
	(125, 'Les Bulls ont le potentiel, mais ils doivent absolument éviter de refaire les mêmes erreurs qu\'avant.', '2025-01-24 18:24:06', 196, 14),
	(126, 'La franchise a une bonne base avec LaVine et Vucevic, mais ils ont besoin de plus de profondeur de banc.', '2025-01-24 18:24:06', 196, 15),
	(127, 'La défense reste primordiale, mais les équipes actuelles ont un style de jeu plus orienté vers l\'offensive, ce qui réduit l\'importance de la défense.', '2025-01-24 18:27:12', 197, 19),
	(128, 'Une équipe avec une défense solide et des joueurs capables de prendre des tirs clés sera toujours dangereuse.', '2025-01-24 18:27:12', 197, 14),
	(129, 'Si tu ne peux pas défendre, tu peux pas espérer aller loin en playoffs, la défense est cruciale.', '2025-01-24 18:27:12', 197, 13),
	(130, 'Les meilleures équipes comme les Milwaukee Bucks ont prouvé qu\'une bonne défense combinée avec une attaque efficace donne des résultats.', '2025-01-24 18:27:12', 197, 15),
	(132, 'Le basket européen a beaucoup de talents, mais il n\'a pas encore l\'attractivité et les ressources de la NBA.', '2025-01-24 18:30:20', 198, 19),
	(133, 'La NBA attire les meilleurs talents mondiaux, ce qui la place au-dessus des ligues européennes.', '2025-01-24 18:30:20', 198, 14),
	(134, 'L\'Europe produit de plus en plus de jeunes joueurs, mais la NBA reste l\'objectif ultime pour ces talents.', '2025-01-24 18:30:20', 198, 13),
	(136, 'Le basket européen a son propre charme, et même si la NBA est dominante, les ligues européennes peuvent coexister et attirer des talents.', '2025-01-24 18:30:20', 198, 26),
	(137, 'Karabatic est incroyable, mais il y a aussi des légendes comme Mikkel Hansen qui méritent d\'être mentionnées.', '2025-01-24 18:39:11', 199, 14),
	(138, 'Hansen est un monstre en attaque, mais Karabatic excelle sur tous les aspects du jeu.', '2025-01-24 18:39:11', 199, 19),
	(139, 'Hansen a porté le Danemark sur ses épaules, Karabatic est plus un leader collectif.', '2025-01-24 18:39:11', 199, 13),
	(140, 'Karabatic a joué à un niveau exceptionnel pendant plus de 15 ans, c\'est une longévité impressionnante.', '2025-01-24 18:39:11', 199, 15),
	(141, 'Il est difficile de choisir entre eux, mais Karabatic reste un joueur complet et plus équilibré que d\'autres.', '2025-01-24 18:39:11', 199, 23),
	(143, 'Le handball français a une structure bien rodée, ce qui lui permet de produire des talents exceptionnels.', '2025-01-24 18:41:33', 200, 19),
	(144, 'La France a aussi une culture du travail en équipe et de la solidarité qui la distingue.', '2025-01-24 18:41:33', 200, 14),
	(145, 'Il faut aussi saluer les investissements en infrastructures, qui permettent au handball français de briller.', '2025-01-24 18:41:33', 200, 23),
	(146, 'La grande performance de l\'équipe est aussi liée à une gestion des joueurs qui s\'étend sur de nombreuses années.', '2025-01-24 18:41:33', 200, 13),
	(147, 'Je suis d\'accord, mais il ne faut pas que ça réduise la stratégie des équipes. Le handball est déjà un sport rapide.', '2025-01-24 18:43:39', 201, 15),
	(148, 'Il faudrait peut-être aussi revoir les sanctions pour les fautes techniques qui sont trop sévères à certains moments.', '2025-01-24 18:43:39', 201, 14),
	(149, 'Je pense qu\'augmenter la durée d\'un match pourrait le rendre plus épuisant et risquer de blesser les joueurs.', '2025-01-24 18:43:39', 201, 23),
	(150, 'Les règles doivent rester équilibrées pour préserver l\'esprit du jeu, sinon on risque de dénaturer ce sport.', '2025-01-24 18:43:39', 201, 19),
	(152, 'Le PSG et Barcelone sont des monstres financiers, mais Kiel est un club qui reste au top grâce à sa stabilité et son projet sur le long terme.', '2025-01-24 18:46:48', 202, 19),
	(153, 'Kiel a l\'avantage d\'être une institution, mais le PSG investit lourdement pour être compétitif sur la scène européenne.', '2025-01-24 18:46:48', 202, 23),
	(155, 'Les clubs allemands, comme Kiel, sont très solides sur le plan tactique, c\'est un modèle pour les autres clubs.', '2025-01-24 18:46:48', 202, 13),
	(156, 'La concurrence en Europe est féroce, mais ces trois clubs restent indiscutables à la tête du handball européen.', '2025-01-24 18:46:48', 202, 26),
	(157, 'L\'évolution des technologies a changé la manière dont le jeu est perçu, mais il y a aussi eu un gros changement dans la préparation physique des joueurs.', '2025-01-24 18:53:49', 203, 19),
	(159, 'L\'aspect tactique est devenu bien plus important, et les équipes doivent désormais être plus polyvalentes pour s\'adapter à différents styles de jeu.', '2025-01-24 18:53:49', 203, 14),
	(160, 'Le handball féminin a aussi énormément évolué, en termes de vitesse et de technique.', '2025-01-24 18:53:49', 203, 13),
	(161, 'Il serait intéressant de voir si le handball continuera à évoluer dans la même direction avec l\'augmentation des investissements et de la popularité.', '2025-01-24 18:53:49', 203, 26),
	(162, 'Les joueurs comme Mikkel Hansen et Nikola Karabatic sont des légendes de la Ligue des Champions, mais de jeunes talents commencent à émerger.', '2025-01-24 18:55:52', 204, 23),
	(164, 'Mikkel Hansen a une capacité de jeu incroyable, et son influence sur les matchs est inégalée à ce jour.', '2025-01-24 18:55:52', 204, 14),
	(165, 'Les jeunes joueurs, comme Dika Mem, montrent de plus en plus leur talent, il faudra voir s\'ils arriveront à prendre la relève des anciens.', '2025-01-24 18:55:52', 204, 13),
	(166, 'La Ligue des Champions est un terrain de jeu idéal pour les joueurs de haut niveau pour prouver qu\'ils sont vraiment les meilleurs.', '2025-01-24 18:55:52', 204, 26),
	(167, 'Les jeunes joueurs français, comme Elohim Prandi et Ludovic Fabregas, sont définitivement à surveiller cette saison.', '2025-01-24 18:58:27', 205, 19),
	(168, 'En plus de Prandi et Fabregas, on ne peut pas ignorer des talents comme Romain Lagarde, qui a un énorme potentiel.', '2025-01-24 18:58:27', 205, 23),
	(169, 'Il y a aussi de nouveaux talents à l\'international, comme les joueurs serbes et norvégiens qui commencent à dominer sur la scène européenne.', '2025-01-24 18:58:27', 205, 14),
	(170, 'Je pense que certains joueurs des clubs allemands, comme Patrick Wiencek, vont être des éléments clés cette saison.', '2025-01-24 18:58:27', 205, 13),
	(171, 'On ne peut pas négliger l\'impact des jeunes dans la Ligue des Champions, et certains de ces joueurs risquent de surprendre cette saison.', '2025-01-24 18:58:27', 205, 26),
	(172, 'La finale de la Ligue des Champions 2017 entre Vardar et Nantes est un de ces matchs inoubliables.', '2025-01-24 19:00:19', 206, 19),
	(173, 'Le match de 2012, où la France a battu la Croatie pour le titre olympique, reste l\'un des plus marquants.', '2025-01-24 19:00:19', 206, 23),
	(175, 'Le duel entre le PSG Handball et Barcelone en 2018 est un autre exemple de l\'intensité de la compétition européenne.', '2025-01-24 19:00:19', 206, 14),
	(176, 'Les matchs entre les équipes des pays scandinaves, comme la Suède et le Danemark, ont souvent été d\'une rare intensité.', '2025-01-24 19:00:19', 206, 26),
	(177, 'Il manque clairement un plus grand investissement dans les médias pour promouvoir le handball à une échelle mondiale.', '2025-01-24 19:02:12', 207, 23),
	(179, 'Peut-être que les fédérations devraient investir davantage dans les ligues de jeunes pour créer un engouement dès le plus jeune âge.', '2025-01-24 19:02:12', 207, 14),
	(180, 'Il faudrait aussi rendre les matchs plus accessibles au grand public, avec des retransmissions plus fréquentes.', '2025-01-24 19:02:12', 207, 13),
	(181, 'Le manque de médiatisation est clairement un frein, mais les récents efforts pour introduire des compétitions en dehors de l\'Europe pourraient améliorer la situation.', '2025-01-24 19:02:12', 207, 26),
	(182, 'Il est vrai que le handball féminin progresse, mais il manque encore des investissements pour lui donner la visibilité qu\'il mérite.', '2025-01-24 19:09:53', 209, 19),
	(184, 'Les performances des équipes féminines, comme la Norvège et la France, ont attiré plus de spectateurs et d\'investisseurs, mais il faut encore aller plus loin.', '2025-01-24 19:09:53', 209, 14),
	(185, 'Le succès du handball féminin dépend aussi de l\'infrastructure, du soutien médiatique et de la formation dès le plus jeune âge.', '2025-01-24 19:09:53', 209, 13),
	(186, 'Les femmes dans le handball gagnent en visibilité, mais il est important d\'accélérer cette dynamique pour qu\'elles puissent rivaliser au même niveau que les hommes.', '2025-01-24 19:09:53', 209, 26),
	(187, 'Giba a marqué l\'histoire avec ses performances incroyables avec le Brésil, mais Karch Kiraly a aussi un palmarès impressionnant.', '2025-01-24 19:39:46', 212, 13),
	(188, 'Tetyukhin a été un monstre sur le terrain avec la Russie, mais Giba a dominé avec ses partenaires brésiliens à une époque où la concurrence était forte.', '2025-01-24 19:39:46', 212, 14),
	(189, 'Les deux ont des carrières exceptionnelles, mais le palmarès de Karch Kiraly, qui a joué sur plusieurs décennies, est inégalé.', '2025-01-24 19:39:46', 212, 19),
	(190, 'Je pense que Giba a l\'avantage pour la polyvalence et ses performances en compétitions internationales, il a été un acteur clé des titres olympiques du Brésil.', '2025-01-24 19:39:46', 212, 23),
	(197, 'Le niveau de la Ligue A a vraiment augmenté ces dernières années, avec des équipes qui recrutent des joueurs internationaux de qualité.', '2025-01-24 19:40:47', 213, 19),
	(198, 'Les équipes comme Paris et Montpellier investissent beaucoup pour attirer les meilleurs joueurs, ce qui explique cette compétitivité.', '2025-01-24 19:40:47', 213, 14),
	(199, 'C\'est vrai, et avec une ligue plus équilibrée, il y a plus de suspense, chaque équipe peut battre l\'autre.', '2025-01-24 19:40:47', 213, 23),
	(200, 'Le championnat a également un meilleur suivi médiatique, ce qui attire des talents étrangers pour renforcer la compétition.', '2025-01-24 19:40:47', 213, 26),
	(201, 'La Ligue A devient de plus en plus attractive pour les joueurs internationaux grâce à sa visibilité en Europe.', '2025-01-24 19:40:47', 213, 13),
	(202, 'Les tactiques modernes comme le "6-2" ont permis aux équipes de s\'adapter rapidement aux différents adversaires et aux situations de jeu.', '2025-01-24 19:40:47', 214, 13),
	(203, 'La défense a aussi pris une place prépondérante, avec des libéros de plus en plus polyvalents et capables de couvrir tout le terrain.', '2025-01-24 19:40:47', 214, 23),
	(204, 'Le contre en volleyball moderne est devenu une arme de plus en plus importante, chaque équipe doit absolument être solide dans ce domaine.', '2025-01-24 19:40:47', 214, 14),
	(206, 'Les coachs sont de plus en plus stratégiques, et l\'adaptation pendant les matchs devient un facteur clé pour gagner.', '2025-01-24 19:40:47', 214, 26),
	(208, 'Trentino est une équipe exceptionnelle avec des joueurs de classe mondiale comme Ivan Zaytsev et le niveau de leur jeu est toujours élevé.', '2025-01-24 19:40:47', 215, 23),
	(209, 'Le Volley Modène a toujours été un club historique avec de grands noms du volleyball, mais l\'arrivée de nouvelles équipes les pousse à se renouveler.', '2025-01-24 19:40:47', 215, 14),
	(210, 'Des équipes comme Civitanova et Lube montent en force et rivalisent de plus en plus avec ces mastodontes du volleyball européen.', '2025-01-24 19:40:47', 215, 19),
	(211, 'C\'est intéressant de voir comment ces clubs réussissent à attirer des talents internationaux tout en gardant une identité forte.', '2025-01-24 19:40:47', 215, 26),
	(212, 'Les femmes dans le volleyball gagnent en visibilité, mais il reste encore du chemin à parcourir pour atteindre un vrai équivalent au niveau masculin.', '2025-01-24 19:40:47', 216, 19),
	(214, 'Les opportunités se développent, mais il faudrait encore plus de soutien pour les équipes et les jeunes talents à l\'échelle mondiale.', '2025-01-24 19:40:47', 216, 13),
	(215, 'Des ligues comme la Superligue russe et la Serie A féminine en Italie donnent une plateforme plus importante pour les athlètes.', '2025-01-24 19:40:47', 216, 14),
	(216, 'Il y a une énorme progression dans la reconnaissance des équipes féminines, mais cela doit encore se traduire par plus de ressources et de visibilité.', '2025-01-24 19:40:47', 216, 26),
	(217, 'Le libéro est vraiment essentiel, sa capacité à réceptionner les services et à effectuer des passes parfaites change la dynamique du match.', '2025-01-24 19:40:47', 217, 19),
	(218, 'En effet, le libéro permet de stabiliser la réception, ce qui est un facteur clé pour la réussite d\'une équipe.', '2025-01-24 19:40:47', 217, 13),
	(219, 'Le libéro n\'a pas le droit de bloquer, mais sa capacité à défendre et à récupérer les balles est un atout décisif dans le volleyball moderne.', '2025-01-24 19:40:47', 217, 23),
	(220, 'Certains libéros, comme Jenia Grebennikov, montrent à quel point ce poste est stratégique dans le volleyball moderne.', '2025-01-24 19:40:47', 217, 14),
	(221, 'La position de libéro est souvent négligée dans les discussions, mais sans lui, les équipes ne seraient pas aussi solides sur la réception.', '2025-01-24 19:40:47', 217, 26),
	(223, 'Le volleyball olympique a vraiment cette dimension spéciale, c\'est un moment de gloire pour de nombreux joueurs', '2025-01-24 19:40:47', 218, 14),
	(224, 'La pression et l\'atmosphère des JO transforment chaque match en un événement légendaire, chaque set est comme une finale.', '2025-01-24 19:40:47', 218, 13),
	(225, 'C\'est un vrai spectacle ! La qualité de jeu, surtout en finale, est juste incroyable. Ça nous donne des frissons.', '2025-01-24 19:40:47', 218, 26),
	(226, 'J’ai toujours aimé voir l\'émotion des joueurs après avoir remporté une médaille olympique, c’est un sentiment unique.', '2025-01-24 19:40:47', 218, 19),
	(227, 'Ngapeth est un joueur complet, il possède une technique et un mental incroyables. Il est définitivement l\'un des meilleurs de sa génération.', '2025-01-24 19:40:47', 219, 14),
	(228, 'Zimmermann a montré un niveau impressionnant, sa vision du jeu et ses passes sont exceptionnelles. C’est un futur très grand.', '2025-01-24 19:40:47', 219, 23),
	(229, 'Il y a aussi des talents émergents en Russie et en Pologne, des joueurs comme Dmitriy Muserskiy qui pourraient prendre le relais.', '2025-01-24 19:40:47', 219, 19),
	(230, 'Ce n’est pas seulement Ngapeth, mais aussi des jeunes comme Maksym Drozd qui ont déjà montré leur potentiel sur le terrain international.', '2025-01-24 19:40:47', 219, 13),
	(232, 'Le beach-volley est vraiment un autre monde, plus intime et spectaculaire. L\'intensité des matchs sur la plage est incomparable.', '2025-01-24 19:40:47', 220, 14),
	(233, 'Les athlètes de beach-volley doivent être incroyablement complets, c’est du haut niveau, tant techniquement que physiquement.', '2025-01-24 19:40:47', 220, 13),
	(234, 'Les compétitions comme le Championnat du Monde ou les JO de beach-volley sont fascinantes, surtout avec des légendes comme Alison et Bruno.', '2025-01-24 19:40:47', 220, 19),
	(235, 'Le côté décontracté du beach-volley en fait aussi un sport très attractif. La plage, le soleil et les champions, c’est tout un spectacle !', '2025-01-24 19:40:47', 220, 23),
	(327, 'C’est un sport fascinant, mais il manque de visibilité médiatique. La plupart des gens ne réalisent pas l’intensité du jeu.', '2025-01-24 19:41:24', 221, 23),
	(329, 'Le problème vient aussi du fait qu’il y a des sports comme le football et le rugby qui accaparent presque toute la couverture médiatique.', '2025-01-24 19:41:24', 221, 19),
	(330, 'Je pense qu’il faudrait plus d’initiatives pour promouvoir le volleyball dès le plus jeune âge, afin d’attirer une plus large audience.', '2025-01-24 19:41:24', 221, 14),
	(331, 'C’est un sport magnifique, et même si la France est en retrait par rapport à d’autres pays, il y a une belle dynamique qui commence à émerger.', '2025-01-24 19:41:24', 221, 26);

-- Listage de la structure de table forum_erwin. commentpublication
CREATE TABLE IF NOT EXISTS `commentpublication` (
  `content` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `commentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publication_id` int NOT NULL,
  `user_id` int NOT NULL,
  KEY `FK_commentpublication_publication` (`publication_id`),
  KEY `FK_commentpublication_user` (`user_id`),
  CONSTRAINT `FK_commentpublication_publication` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id_publication`),
  CONSTRAINT `FK_commentpublication_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.commentpublication : ~0 rows (environ)

-- Listage de la structure de table forum_erwin. event
CREATE TABLE IF NOT EXISTS `event` (
  `id_event` int NOT NULL AUTO_INCREMENT,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `eventDate` date NOT NULL,
  `eventHours` time NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT '',
  `limit` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_event`),
  KEY `FK_event_user` (`user_id`),
  CONSTRAINT `FK_event_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.event : ~1 rows (environ)
INSERT INTO `event` (`id_event`, `creationDate`, `photo`, `title`, `text`, `eventDate`, `eventHours`, `city`, `country`, `limit`, `user_id`) VALUES
	(9, '2025-01-03 22:55:24', 'tennis de table.png', 'Rencontre amical', 'Journ&eacute;e porte ouverte', '2025-01-17', '09:00:00', 'mulhouse', 'France', 20, 23);

-- Listage de la structure de table forum_erwin. favorites
CREATE TABLE IF NOT EXISTS `favorites` (
  `id_favorites` int NOT NULL AUTO_INCREMENT,
  `favoritesDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publication_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_favorites`),
  KEY `FK_favoris_publication` (`publication_id`),
  KEY `FK_favoris_user` (`user_id`),
  CONSTRAINT `FK_favoris_publication` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id_publication`) ON DELETE CASCADE,
  CONSTRAINT `FK_favoris_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.favorites : ~0 rows (environ)

-- Listage de la structure de table forum_erwin. follow
CREATE TABLE IF NOT EXISTS `follow` (
  `dateFollow` datetime NOT NULL,
  `user_id` int NOT NULL,
  `user_id_1` int NOT NULL,
  KEY `FK_follow_user` (`user_id`),
  KEY `FK_follow_user_2` (`user_id_1`),
  CONSTRAINT `FK_follow_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `FK_follow_user_2` FOREIGN KEY (`user_id_1`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.follow : ~3 rows (environ)
INSERT INTO `follow` (`dateFollow`, `user_id`, `user_id_1`) VALUES
	('2024-12-21 14:47:13', 13, 1),
	('2024-12-22 20:20:50', 13, 2),
	('2025-01-07 19:16:17', 23, 1);

-- Listage de la structure de table forum_erwin. likepost
CREATE TABLE IF NOT EXISTS `likepost` (
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  KEY `FK_likemesssage_post` (`post_id`),
  KEY `FK_likemesssage_user` (`user_id`),
  CONSTRAINT `FK_likemesssage_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id_message`) ON DELETE CASCADE,
  CONSTRAINT `FK_likemesssage_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.likepost : ~0 rows (environ)

-- Listage de la structure de table forum_erwin. message
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `dateMessage` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `messages` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('read','unread') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'unread',
  `user_id` int NOT NULL,
  `user_id_1` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `FK_message_user` (`user_id`),
  KEY `FK_message_user_2` (`user_id_1`),
  CONSTRAINT `FK_message_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `FK_message_user_2` FOREIGN KEY (`user_id_1`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.message : ~2 rows (environ)
INSERT INTO `message` (`id_message`, `dateMessage`, `messages`, `status`, `user_id`, `user_id_1`) VALUES
	(19, '2025-01-12 15:40:29', 'ZGGZRGRGEGR', 'unread', 23, 1),
	(20, '2025-01-12 15:42:49', 'rgrgerqzrg', 'unread', 23, 1);

-- Listage de la structure de table forum_erwin. newsletters
CREATE TABLE IF NOT EXISTS `newsletters` (
  `id_subscribers` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '0',
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_subscribers`),
  KEY `FK_subscribers_user` (`user_id`),
  CONSTRAINT `FK_subscribers_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.newsletters : ~0 rows (environ)

-- Listage de la structure de table forum_erwin. participant
CREATE TABLE IF NOT EXISTS `participant` (
  `id_participant` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_participant`),
  KEY `FK_participant_event` (`event_id`),
  KEY `FK_participant_user` (`user_id`),
  CONSTRAINT `FK_participant_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id_event`) ON DELETE CASCADE,
  CONSTRAINT `FK_participant_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.participant : ~0 rows (environ)

-- Listage de la structure de table forum_erwin. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `text` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_message`) USING BTREE,
  KEY `FK_post_user` (`user_id`),
  KEY `FK_post_topic` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.post : ~40 rows (environ)
INSERT INTO `post` (`id_message`, `text`, `creationDate`, `user_id`, `topic_id`) VALUES
	(179, 'Pelé est de loin le meilleur joueur de tous les temps. Rien ne vaut sa carrière.', '2025-01-24 17:07:18', 1, 100),
	(180, 'Messi est incomparable. Aucun autre joueur n\'a son niveau de créativité sur le terrain.', '2025-01-24 17:07:18', 27, 101),
	(181, 'Le Barça doit revoir sa structure, mais je suis confiant qu\'ils reviendront au plus haut niveau.', '2025-01-24 17:07:18', 13, 102),
	(182, 'La Premier League reste la plus forte. La compétition est beaucoup plus équilibrée que la Liga.', '2025-01-24 17:07:18', 14, 103),
	(183, 'L\'Allemagne a tout simplement dominé la Coupe du Monde avec un collectif exceptionnel.', '2025-01-24 17:07:18', 15, 104),
	(184, 'Les supporters ont un impact énorme, mais parfois ils sont aussi trop exigeants.', '2025-01-24 17:07:18', 19, 105),
	(185, 'Je pense que les équipes africaines peuvent surprendre. Il leur manque juste un peu plus de cohésion.', '2025-01-24 17:07:18', 23, 106),
	(186, 'Le football féminin a beaucoup évolué ces dernières années, il mérite plus d\'attention.', '2025-01-24 17:07:18', 27, 107),
	(187, 'Le PSG a beaucoup investi, mais ils doivent maintenant trouver l\'équilibre entre stars et collectif.', '2025-01-24 17:07:18', 26, 108),
	(188, 'Le transfert de certains joueurs ne se passe pas bien, surtout quand l\'adaptation à un nouveau style de jeu est difficile.', '2025-01-24 17:07:18', 2, 109),
	(189, 'Jordan est sans aucun doute le plus grand joueur, mais LeBron a une carrière plus complète.', '2025-01-24 17:55:54', 1, 110),
	(190, 'Le Big Three des Miami Heat (LeBron, Wade, Bosh) a marqué l\'histoire, mais ils n\'ont pas eu la longévité pour être considérés comme une légende.', '2025-01-24 17:59:42', 2, 111),
	(191, 'Les Lakers ont eu une période de domination, mais leur avenir est incertain avec les blessures de LeBron et AD.', '2025-01-24 18:01:55', 13, 112),
	(192, 'Les Cleveland Cavaliers ont un avenir prometteur avec des jeunes talents, mais ils doivent éviter les erreurs passées.', '2025-01-24 18:05:37', 14, 113),
	(193, 'La NBA moderne est devenue un jeu plus rapide avec plus de tirs à trois points et moins de défense.', '2025-01-24 18:07:59', 15, 114),
	(194, 'Michael Jordan reste le GOAT car il a une mentalité incomparable et a dominé la ligue durant toute sa carrière.', '2025-01-24 18:10:37', 19, 115),
	(195, 'La NBA regorge de jeunes talents, mais je pense que Luka Doncic et Zion Williamson sont ceux à suivre de près dans les années à venir.', '2025-01-24 18:18:02', 23, 116),
	(196, 'Les Chicago Bulls ont une histoire magnifique, mais leur avenir semble flou avec un roster inconstant et des blessures à répétition.', '2025-01-24 18:23:00', 26, 117),
	(197, 'La défense est toujours essentielle, même dans un jeu moderne axé sur l\'offensive, une bonne défense peut gagner des titres.', '2025-01-24 18:25:43', 26, 118),
	(198, 'La NBA est la meilleure ligue au monde, mais le basket européen continue de se développer et pourrait bien devenir une alternative sérieuse à l\'avenir.', '2025-01-24 18:29:34', 15, 119),
	(199, 'Je pense que Nikola Karabatic est sans doute le meilleur joueur de handball de tous les temps, son palmarès et sa longévité sont impressionnants.', '2025-01-24 18:38:13', 27, 120),
	(200, 'La France a su mettre en place une formation de très haute qualité, ce qui explique sa domination sur la scène internationale.', '2025-01-24 18:40:33', 26, 121),
	(201, 'Je trouve que certaines règles, comme la durée des matchs, devraient être revues pour augmenter le rythme et l\'excitation.', '2025-01-24 18:42:55', 13, 122),
	(202, 'Les clubs européens comme le PSG Handball, Barcelone et Kiel sont les plus dominants, mais d\'autres clubs peuvent surprendre.', '2025-01-24 18:45:40', 14, 123),
	(203, 'Le handball a connu de grandes évolutions tactiques et technologiques ces dernières années, notamment avec l\'introduction de la vidéo et de nouvelles règles.', '2025-01-24 18:52:36', 23, 124),
	(204, 'Les meilleurs joueurs de la Ligue des Champions ont un énorme impact sur leurs équipes, que ce soit en attaque ou en défense.', '2025-01-24 18:55:04', 19, 125),
	(205, 'La saison actuelle nous offre de nombreux jeunes joueurs talentueux à surveiller, notamment ceux des équipes montantes.', '2025-01-24 18:57:42', 27, 126),
	(206, 'Il y a certains matchs qui resteront gravés dans l\'histoire du handball, que ce soit pour leur intensité ou leur signification.', '2025-01-24 18:59:41', 14, 127),
	(207, 'Malgré la qualité du jeu, le handball reste encore assez peu populaire, notamment en dehors des pays européens.', '2025-01-24 19:01:24', 19, 128),
	(209, 'Le handball féminin a fait d\'énormes progrès ces dernières années, mais il reste encore beaucoup à faire pour atteindre la même reconnaissance que le sport masculin.', '2025-01-24 19:08:43', 23, 129),
	(212, 'Le volleyball a vu des légendes comme Giba, Karch Kiraly et Sergey Tetyukhin. Mais qui est réellement le meilleur joueur de tous les temps ?', '2025-01-24 19:28:31', 14, 139),
	(213, 'La Ligue A française est l\'une des plus compétitives d\'Europe, avec des clubs comme Tours et Montpellier qui se battent pour les premières places.', '2025-01-24 19:28:31', 27, 140),
	(214, 'Le volleyball moderne a beaucoup évolué tactiquement, notamment avec l\'introduction de la "pipe" et l\'évolution des systèmes de défense.', '2025-01-24 19:28:31', 19, 141),
	(215, 'Les clubs comme Zenit Kazan, Trentino et le Volley Modène sont des références en Europe, mais de nouvelles équipes montent en puissance.', '2025-01-24 19:28:31', 13, 142),
	(216, 'Le volleyball féminin offre de plus en plus d\'opportunités aux jeunes talents, avec une meilleure reconnaissance et plus de tournois.', '2025-01-24 19:28:31', 23, 143),
	(217, 'Le libéro a une importance cruciale dans l\'équipe, bien que son rôle soit souvent sous-estimé. Il doit être rapide, tactiquement intelligent et capable de sauver des points cruciaux.', '2025-01-24 19:28:31', 27, 144),
	(218, 'Le volleyball est l\'un des sports les plus spectaculaires aux Jeux Olympiques. La tension, l\'intensité et la qualité des matchs sont incomparables.', '2025-01-24 19:28:31', 15, 145),
	(219, 'Les jeunes joueurs comme Earvin Ngapeth ou Jan Zimmermann sont les nouveaux leaders du volleyball. Il faut aussi observer les talents émergents pour l\'avenir du sport.', '2025-01-24 19:28:31', 26, 146),
	(220, 'Le beach-volley attire de plus en plus de jeunes et devient un sport spectaculaire à part entière avec des compétitions de plus en plus populaires.', '2025-01-24 19:28:31', 27, 147),
	(221, 'En France, le volleyball ne bénéficie pas de la même popularité que d’autres sports. Pourtant, c’est un sport spectaculaire et exigeant.', '2025-01-24 19:28:31', 14, 148);

-- Listage de la structure de table forum_erwin. publication
CREATE TABLE IF NOT EXISTS `publication` (
  `id_publication` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `publicationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `video` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_publication`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_publication_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.publication : ~2 rows (environ)
INSERT INTO `publication` (`id_publication`, `content`, `publicationDate`, `photo`, `video`, `user_id`) VALUES
	(42, 'je le suis', '2025-01-04 00:14:13', 'handball.jpg', NULL, 23),
	(43, 'hdhdfghhhgh', '2025-01-04 00:14:58', 'volleyball.jpg', NULL, 23);

-- Listage de la structure de table forum_erwin. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int NOT NULL,
  `closed` tinyint DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_users` (`user_id`),
  KEY `FK_topic_category` (`category_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.topic : ~40 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `user_id`, `category_id`, `creationDate`, `views`, `closed`) VALUES
	(100, 'Quel est le meilleur joueur de football de tous les temps ?', 1, 34, '2025-01-24 16:19:36', 3, 0),
	(101, 'La domination de Messi ou Ronaldo ?', 27, 34, '2025-01-24 16:19:36', 0, 0),
	(102, 'Le FC Barcelone peut-il retrouver son niveau ?', 13, 34, '2025-01-24 16:19:36', 1, 0),
	(103, 'La Premier League ou La Liga ? Quel championnat est le plus fort ?', 14, 34, '2025-01-24 16:19:36', 1, 0),
	(104, 'Pourquoi l\'Allemagne a-t-elle dominé la Coupe du Monde 2014 ?', 15, 34, '2025-01-24 16:19:36', 0, 0),
	(105, 'L\'impact des supporters sur les résultats des matchs ?', 19, 34, '2025-01-24 16:19:36', 0, 0),
	(106, 'Les équipes africaines peuvent-elles gagner la Coupe du Monde ?', 23, 34, '2025-01-24 16:19:36', 1, 0),
	(107, 'L\'évolution du football féminin', 27, 34, '2025-01-24 16:19:36', 0, 0),
	(108, 'Quel est l\'avenir du Paris Saint-Germain ?', 26, 34, '2025-01-24 16:19:36', 0, 0),
	(109, 'Pourquoi certains joueurs ne réussissent pas après leur transfert ?', 2, 34, '2025-01-24 16:19:36', 0, 0),
	(110, 'Qui est le meilleur joueur de basket de tous les temps ?', 1, 35, '2025-01-24 17:53:54', 1, 0),
	(111, 'Le Big Three des Miami Heat : Légende ou pas ?', 2, 35, '2025-01-24 17:53:54', 0, 0),
	(112, 'Les Los Angeles Lakers peuvent-ils encore dominer ?', 13, 35, '2025-01-24 17:53:54', 0, 0),
	(113, 'Quel avenir pour les Cleveland Cavaliers ?', 14, 35, '2025-01-24 17:53:54', 0, 0),
	(114, 'L\'évolution de la NBA moderne', 15, 35, '2025-01-24 17:53:54', 0, 0),
	(115, 'Pourquoi Michael Jordan reste le GOAT ?', 19, 35, '2025-01-24 17:53:54', 0, 0),
	(116, 'Les jeunes talents en NBA : qui est la future star ?', 23, 35, '2025-01-24 17:53:54', 0, 0),
	(117, 'Les Chicago Bulls ont-ils encore un avenir en NBA ?', 27, 35, '2025-01-24 17:53:54', 0, 0),
	(118, 'L\'importance de la défense dans le basket moderne', 26, 35, '2025-01-24 17:53:54', 0, 0),
	(119, 'Le basket européen : menacé par la NBA ?', 15, 35, '2025-01-24 17:53:54', 0, 0),
	(120, 'Qui est le meilleur joueur de handball de tous les temps ?', 27, 36, '2025-01-24 18:36:51', 0, 0),
	(121, 'Pourquoi le handball français est-il si dominant ?', 26, 36, '2025-01-24 18:36:51', 0, 0),
	(122, 'Les règles du handball ont-elles besoin d\'évoluer ?', 13, 36, '2025-01-24 18:36:51', 0, 0),
	(123, 'Les meilleurs clubs européens de handball', 14, 36, '2025-01-24 18:36:51', 0, 0),
	(124, 'Comment le handball a évolué au fil des années ?', 23, 36, '2025-01-24 18:36:51', 0, 0),
	(125, 'Les joueurs les plus influents de la Ligue des Champions', 19, 36, '2025-01-24 18:36:51', 0, 0),
	(126, 'Quels sont les joueurs à surveiller cette saison ?', 27, 36, '2025-01-24 18:36:51', 0, 0),
	(127, 'Les plus grands matchs de l\'histoire du handball', 14, 36, '2025-01-24 18:36:51', 0, 0),
	(128, 'Pourquoi le handball n\'est-il pas plus populaire ?', 19, 36, '2025-01-24 18:36:51', 0, 0),
	(129, 'Les femmes dans le handball, quels progrès ?', 23, 36, '2025-01-24 18:36:51', 0, 0),
	(139, 'Qui est le meilleur joueur de volleyball de tous les temps ?', 14, 37, '2025-01-24 19:18:13', 4, 0),
	(140, 'Pourquoi la Ligue A est-elle si compétitive ?', 27, 37, '2025-01-24 19:18:13', 0, 0),
	(141, 'L\'évolution des tactiques en volleyball moderne', 19, 37, '2025-01-24 19:18:13', 1, 0),
	(142, 'Les meilleurs clubs de volleyball en Europe', 13, 37, '2025-01-24 19:18:13', 0, 0),
	(143, 'Le volleyball féminin : quelles opportunités pour la relève ?', 23, 37, '2025-01-24 19:18:13', 0, 0),
	(144, 'Le rôle du libéro en volleyball', 27, 37, '2025-01-24 19:18:13', 0, 0),
	(145, 'Les jeux Olympiques et le volleyball : un duel incontournable', 15, 37, '2025-01-24 19:18:13', 0, 0),
	(146, 'Les jeunes talents en volleyball : qui est le futur ?', 26, 37, '2025-01-24 19:18:13', 0, 0),
	(147, 'Le beach-volley : une autre dimension du volleyball', 27, 37, '2025-01-24 19:18:13', 0, 0),
	(148, 'Pourquoi le volleyball est un sport sous-estimé en France ?', 14, 37, '2025-01-24 19:18:13', 2, 0);

-- Listage de la structure de table forum_erwin. undercommentpost
CREATE TABLE IF NOT EXISTS `undercommentpost` (
  `text` varchar(255) NOT NULL,
  `commentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `comment_id` int NOT NULL,
  KEY `FK_undercommentpost_user` (`user_id`),
  KEY `FK_undercommentpost_commentpost` (`comment_id`),
  CONSTRAINT `FK_undercommentpost_commentpost` FOREIGN KEY (`comment_id`) REFERENCES `commentpost` (`id_comment`) ON DELETE CASCADE,
  CONSTRAINT `FK_undercommentpost_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.undercommentpost : ~45 rows (environ)
INSERT INTO `undercommentpost` (`text`, `commentDate`, `user_id`, `comment_id`) VALUES
	('Je suis d\'accord, Messi a plus de vision de jeu et est plus complet que Pelé.', '2025-01-24 17:11:01', 27, 17),
	('Messi a été un phénomène dans un contexte ultra-compétitif, c\'est là où il surpasse Pelé.', '2025-01-24 17:11:01', 26, 17),
	('Messi est plus créatif, mais Ronaldo a un mental plus fort.', '2025-01-24 17:19:21', 27, 22),
	('Ronaldo est effectivement plus physique, mais Messi est plus un génie du jeu.', '2025-01-24 17:19:21', 26, 22),
	('Oui, c\'est la clé, renforcer la défense pour une meilleure stabilité.', '2025-01-24 17:23:24', 27, 32),
	('Ils doivent aussi être plus réalistes sur leur futur et ne pas se comparer à leur époque dorée.', '2025-01-24 17:23:24', 26, 32),
	('C\'est vrai, en Premier League il y a toujours des surprises, tout peut arriver.', '2025-01-24 17:26:37', 26, 37),
	('En Premier League, c\'est plus physique, mais la technique de la Liga reste impressionnante.', '2025-01-24 17:26:37', 1, 37),
	('C\'est ce que j\'appelle un travail d\'équipe. Le mental et la stratégie ont tout changé.', '2025-01-24 17:28:31', 26, 42),
	('Exactement, l\'équipe était tellement bien construite que la performance était inévitable.', '2025-01-24 17:28:31', 1, 42),
	('Oui, mais il faut un soutien plus fort pour permettre une vraie égalité dans les infrastructures et la médiatisation.', '2025-01-24 17:32:10', 1, 52),
	('L\'augmentation de l\'engouement pour les compétitions féminines est un pas dans la bonne direction.', '2025-01-24 17:32:10', 14, 52),
	('Le PSG doit aussi se concentrer sur le long terme et ne pas rechercher uniquement des succès immédiats.', '2025-01-24 17:38:00', 14, 57),
	('Ils ont un bel effectif, mais la gestion du groupe est la clé de leur réussite future.', '2025-01-24 17:38:00', 19, 57),
	('Les supporters peuvent aussi être un poids psychologique pour certains joueurs.', '2025-01-24 17:39:59', 27, 62),
	('Oui, mais le vrai impact vient quand l\'équipe répond à la pression de manière positive.', '2025-01-24 17:39:59', 26, 62),
	('L\'adaptation à un style de jeu peut prendre du temps, mais il faut aussi que l\'entraîneur le soutienne.', '2025-01-24 17:42:11', 26, 67),
	('Certaines fois, c\'est l\'environnement externe qui devient difficile à gérer pour les joueurs.', '2025-01-24 17:42:11', 13, 67),
	('LeBron a eu une carrière plus longue, mais Jordan a dominé en quelques années, ce qui est impressionnant.', '2025-01-24 17:58:44', 26, 72),
	('Jordan n\'a jamais eu la compétition que LeBron a dû affronter, c\'est ça qui fait la différence.', '2025-01-24 17:58:44', 2, 72),
	('Ils auraient pu faire plus, mais les blessures et la retraite prématurée de Bosh les ont freinés.', '2025-01-24 18:01:07', 27, 77),
	('Avec une meilleure longévité, ils auraient clairement marqué l\'histoire des années 2010.', '2025-01-24 18:01:07', 26, 77),
	('Ils doivent repenser leur effectif et recruter des jeunes talents à fort potentiel.', '2025-01-24 18:04:50', 26, 82),
	('Ils doivent être patients et ne pas se précipiter dans leurs décisions de recrutement.', '2025-01-24 18:07:08', 1, 87),
	('C’est une évolution nécessaire, mais la défense a toujours son rôle à jouer dans cette ère moderne.', '2025-01-24 18:09:34', 2, 92),
	('La mentalité de gagnant qu’il a apportée est ce qui manque à de nombreux joueurs aujourd\'hui.', '2025-01-24 18:12:31', 1, 97),
	('L\'équilibre entre défense et attaque est essentiel, trop se concentrer sur une seule partie du jeu peut être préjudiciable.', '2025-01-24 18:27:54', 26, 127),
	('L\'Europe a un style différent, mais les ligues comme la Liga ACB ou l\'Euroleague sont très compétitives.', '2025-01-24 18:31:56', 15, 132),
	('Il est vrai que Mikkel Hansen a porté son équipe à plusieurs reprises, mais la polyvalence de Karabatic est inégalée.', '2025-01-24 18:39:57', 27, 138),
	('C\'est vrai, le handball est déjà très rapide, l\'ajout d\'une durée de match plus longue pourrait effectivement nuire à l\'intensité.', '2025-01-24 18:45:08', 26, 147),
	('Je suis totalement d\'accord, Kiel est un modèle de stabilité et de formation, tandis que Paris et Barcelone sont plus basés sur des recrutements de stars.', '2025-01-24 18:47:55', 14, 152),
	('Oui, et l\'impact de la vidéo-assistance a été crucial pour améliorer la précision des décisions arbitrales.', '2025-01-24 18:54:18', 27, 157),
	('C\'est clair, Hansen est un génie du jeu, et son impact en Ligue des Champions est indéniable, mais Karabatic reste le joueur à battre.', '2025-01-24 18:56:47', 14, 162),
	('Oui, Prandi et Fabregas sont des stars montantes. Leur énergie et leur détermination en font des joueurs clés pour cette saison.', '2025-01-24 18:59:07', 27, 167),
	('Effectivement, la finale 2017 était spectaculaire, avec des rebondissements à couper le souffle.', '2025-01-24 19:00:54', 14, 172),
	('L\'exposition médiatique est effectivement le point clé pour accroître la popularité du handball au niveau mondial.', '2025-01-24 19:07:36', 27, 177),
	('C\'est tout à fait vrai, mais les performances des équipes comme la France en compétitions internationales commencent à faire bouger les choses.', '2025-01-24 19:10:49', 14, 182),
	('Je suis d\'accord, mais l\'impact de Giba sur le volleyball brésilien et international reste sans précédent.', '2025-01-24 19:58:27', 14, 187),
	('Absolument, la montée en puissance des clubs français dans les compétitions européennes a été impressionnante.', '2025-01-24 19:58:27', 27, 197),
	('C\'est clair, l\'adoption du 6-2 a permis à certaines équipes de multiplier les possibilités d\'attaque et de faire face à n\'importe quelle défense.', '2025-01-24 19:58:27', 23, 202),
	('Zenit Kazan a été une équipe dominante, c\'est incroyable de voir leur régularité en Ligue des champions.', '2025-01-24 19:58:27', 23, 212),
	('Le volleyball féminin offre de plus en plus d\'opportunités aux jeunes talents, avec une meilleure reconnaissance et plus de tournois.', '2025-01-24 19:58:27', 23, 217),
	('Je suis d\'accord. Les libéros sont souvent les véritables héros derrière les coulisses, ce sont eux qui permettent aux attaques d\'aboutir.', '2025-01-24 19:58:27', 27, 37),
	('C\'est vrai, les matchs entre ces deux équipes sont toujours très attendus et ils offrent une qualité de jeu inégalée.', '2025-01-24 19:58:27', 23, 227),
	('Ngapeth est une star, mais il y a aussi un grand vivier de talents qui arrive derrière lui pour continuer à dominer le volleyball mondial.', '2025-01-24 19:58:27', 26, 232);

-- Listage de la structure de table forum_erwin. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dateInscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role` enum('SUPER_ADMIN','ROLE_ADMIN','ROLE_USER') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'ROLE_USER',
  `isBanned` enum('actif','inactif') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`nickName`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_erwin.user : ~9 rows (environ)
INSERT INTO `user` (`id_user`, `nickName`, `password`, `dateInscription`, `avatar`, `email`, `role`, `isBanned`) VALUES
	(1, 'josh', 'gfsgfgfsg', '2024-12-02 16:52:01', 'default-avatar.webp', 'gfgdfgdg@ffsf.com', 'SUPER_ADMIN', 'actif'),
	(2, 'manon', 'shthsrhrt', '2024-12-02 16:52:31', 'default-avatar.webp', 'gdgbcgxdg@fds.com', 'ROLE_USER', 'actif'),
	(13, 'ema', '$2y$10$8QTKlC.7aivwithn5M/1ie14f4BiBocm0wMpJ0F7DvJXDCA8y173a', '2024-12-13 15:41:51', 'default-avatar.webp', 'ema@exemple.com', 'ROLE_USER', 'actif'),
	(14, 'test', '$2y$10$IPH2M8qTJxHwnDgdK2WfFuZ4nPnBF2GrEOmxagwP7314uXMox9cJy', '2024-12-13 16:25:55', 'default-avatar.webp', 'test@test.fr', 'ROLE_USER', 'actif'),
	(15, 'test1', '$2y$10$oi/3kkR/JYba50FXrggbnOXoe/jpObVi3wOLuydRCGGjkGnTtMZx2', '2024-12-13 16:26:55', 'default-avatar.webp', 'test1@test.fr', 'ROLE_USER', 'actif'),
	(19, 'marv', '$2y$10$aACh.wU8pZODNs28Q/g63eZcb4RzzxtMbawcN0CZzH.awEz2jTHmC', '2024-12-22 22:47:45', 'default-avatar.webp', 'marv@exemple.com', 'ROLE_USER', 'actif'),
	(23, 'david', '$2y$10$emY6HeqMkiuRZ0CdrQ64A.JgLD18IQb3GBn/4zISC0Mec0lW3kWR.', '2024-12-24 16:11:42', 'R (1).jpg', 'david@exemple.com', 'ROLE_USER', 'actif'),
	(26, 'sku', '$2y$10$lTJk3zij1Cy26cDjkDLUTO8U8awQ1bSCvOPgCRj7mmqbrAPWHOosi', '2025-01-04 14:25:07', 'default-avatar.webp', 'erwin.philip68@gmail.com', 'ROLE_USER', 'actif'),
	(27, 'erwin', '$2y$10$NfKkRKBOj8lB2P0Kd02/q.GWpqYU2CmBUypJbSqzf.RQT/KfWD1z.', '2025-01-26 15:03:27', 'default-avatar.webp', 'erwin@exemple.com', 'ROLE_ADMIN', 'actif');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
