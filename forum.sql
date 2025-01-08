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

-- Listage des données de la table forum_erwin.category : ~7 rows (environ)
INSERT INTO `category` (`id_category`, `name`, `photo`) VALUES
	(34, 'football', 'image football.jpg'),
	(35, 'basket', 'basket.jpg'),
	(36, 'handball', 'handball.jpg'),
	(37, 'volleyball', 'volleyball.jpg'),
	(38, 'tennis de table', 'tennis de table.png'),
	(39, 'athl&eacute;tisme', 'athletisme.jpg'),
	(40, 'tennis', 'tennis.jpeg');

-- Listage des données de la table forum_erwin.commentpost : ~4 rows (environ)
INSERT INTO `commentpost` (`id_comment`, `text`, `commentDate`, `post_id`, `user_id`) VALUES
	(2, 'rgegehhthth', '2025-01-04 22:05:42', 29, 25),
	(7, 'hthfgjfjdhd', '2025-01-07 22:05:12', 29, 23),
	(8, 'erytyrturyuryuy', '2025-01-08 19:34:48', 29, 23),
	(9, 'chfcfxfgjfxcjxfhjhc', '2025-01-08 19:55:42', 29, 23);

-- Listage des données de la table forum_erwin.commentpublication : ~0 rows (environ)

-- Listage des données de la table forum_erwin.event : ~5 rows (environ)
INSERT INTO `event` (`id_event`, `creationDate`, `photo`, `title`, `text`, `eventDate`, `eventHours`, `city`, `country`, `user_id`) VALUES
	(2, '2025-01-02 16:07:50', 'volleyball.jpg', 'match de gala', 'les anciens vs les jeunes', '2025-05-10', '20:00:00', 'colmar', 'France', 25),
	(3, '2025-01-02 18:43:40', 'basket.jpg', 'match de basket', 'rencontre officiel', '2024-03-15', '15:00:00', 'mulhouse', 'France', 25),
	(5, '2025-01-02 19:02:50', 'athletisme.jpg', 'course &agrave; pied', 'course de partage', '2025-11-02', '15:00:00', 'strasbourg', 'France', 25),
	(6, '2025-01-02 19:03:59', 'tennis.jpeg', 'entrainement gratuit', 'entrainement de tennis avec vrai coach', '2025-02-05', '10:00:00', 'colmar', 'France', 25),
	(9, '2025-01-03 22:55:24', 'tennis de table.png', 'Rencontre amical', 'Journ&eacute;e porte ouverte', '2025-01-17', '09:00:00', 'mulhouse', 'France', 23);

-- Listage des données de la table forum_erwin.favorites : ~3 rows (environ)
INSERT INTO `favorites` (`id_favorites`, `favoritesDate`, `publication_id`, `user_id`) VALUES
	(26, '2025-01-03 00:10:11', 41, 25),
	(28, '2025-01-05 00:15:27', 42, 25),
	(29, '2025-01-06 14:50:46', 41, 23);

-- Listage des données de la table forum_erwin.follow : ~6 rows (environ)
INSERT INTO `follow` (`dateFollow`, `user_id`, `user_id_1`) VALUES
	('2024-12-21 14:47:13', 13, 1),
	('2024-12-22 20:20:50', 13, 2),
	('2025-01-05 23:09:46', 25, 23),
	('2025-01-05 23:10:00', 25, 1),
	('2025-01-07 19:16:17', 23, 1),
	('2025-01-07 20:24:18', 23, 25);

-- Listage des données de la table forum_erwin.likemessage : ~4 rows (environ)
INSERT INTO `likemessage` (`post_id`, `user_id`) VALUES
	(31, 23),
	(29, 23),
	(29, 25),
	(36, 23);

-- Listage des données de la table forum_erwin.message : ~0 rows (environ)

-- Listage des données de la table forum_erwin.newsletters : ~3 rows (environ)
INSERT INTO `newsletters` (`id_subscribers`, `email`, `creationDate`, `user_id`) VALUES
	(1, 'erwin@exemple.com', '2025-01-04 01:18:43', 25),
	(3, 'david@exemple.com', '2025-01-04 01:23:55', 25),
	(30, 'erwin.philip68@gmail.com', '2025-01-04 17:01:06', 26);

-- Listage des données de la table forum_erwin.post : ~11 rows (environ)
INSERT INTO `post` (`id_message`, `text`, `creationDate`, `user_id`, `topic_id`) VALUES
	(26, 'hgfffffffffffffhdfghfhfgfjjf', '2024-12-27 19:15:07', 23, 89),
	(27, 'hgfffffffffffffhdfghfhfgfjjf', '2024-12-27 19:17:29', 23, 90),
	(28, 'hgfffffffffffffhdfghfhfgfjjf', '2024-12-27 19:18:28', 23, 91),
	(29, 'ehtttttttttttttttttttttttttttttttzrfefghjukuk', '2024-12-27 19:21:28', 23, 92),
	(30, 'jtkutkkkkkkkkkkkkkkkkkk', '2024-12-27 19:23:27', 23, 93),
	(31, 'fxfjxhfxfxfxjxhfxfgxfgxfx', '2024-12-27 19:27:46', 23, 94),
	(32, 'tellement ch&egrave;re aujourd&#039;hui', '2024-12-28 14:03:57', 23, 95),
	(36, 'gjcgjcg', '2024-12-31 17:22:20', 23, 96),
	(37, 'hdfhdghdhdf', '2025-01-04 23:19:38', 25, 97),
	(38, 'hdfhdghdhdf', '2025-01-04 23:20:07', 25, 98),
	(39, 'hdfhdghdhdf', '2025-01-04 23:21:04', 25, 99);

-- Listage des données de la table forum_erwin.publication : ~4 rows (environ)
INSERT INTO `publication` (`id_publication`, `content`, `publicationDate`, `photo`, `video`, `user_id`) VALUES
	(41, 'puipipoiup', '2025-01-02 01:28:47', 'tennis de table.png', NULL, 25),
	(42, 'je le suis', '2025-01-04 00:14:13', 'handball.jpg', NULL, 23),
	(43, 'hdhdfghhhgh', '2025-01-04 00:14:58', 'volleyball.jpg', NULL, 23),
	(45, 'je le suis', '2025-01-05 21:56:48', 'logo erwin2.png', NULL, 25);

-- Listage des données de la table forum_erwin.topic : ~7 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `user_id`, `category_id`, `creationDate`, `views`, `closed`) VALUES
	(92, 'hteeeeeeeeee', 23, 34, '2024-12-27 19:21:28', 35, 0),
	(94, 'ghchfghhff', 23, 34, '2024-12-27 19:27:46', 9, 0),
	(95, 'le prix d&#039;un ballon de basket', 23, 35, '2024-12-28 14:03:57', 0, 0),
	(96, 'gchfxfxxhf', 23, 34, '2024-12-31 17:22:20', 4, 0),
	(97, 'dgfgfgf', 25, 34, '2025-01-04 23:19:38', 15, 0),
	(98, 'dgfgfgf', 25, 34, '2025-01-04 23:20:07', 3, 0),
	(99, 'dgfgfgf', 25, 34, '2025-01-04 23:21:04', 3, 0);

-- Listage des données de la table forum_erwin.undercommentpost : ~4 rows (environ)
INSERT INTO `undercommentpost` (`text`, `commentDate`, `user_id`, `comment_id`) VALUES
	('hbgdhghhghdg', '2025-01-06 23:59:44', 25, 2),
	('fbdfdfgfg', '2025-01-07 00:00:02', 25, 2),
	('rghththrthrththt', '2025-01-07 00:07:03', 25, 2),
	('thrthrhrthtrht', '2025-01-08 19:36:01', 23, 7);

-- Listage des données de la table forum_erwin.user : ~9 rows (environ)
INSERT INTO `user` (`id_user`, `nickName`, `password`, `dateInscription`, `avatar`, `email`) VALUES
	(1, 'josh', 'gfsgfgfsg', '2024-12-02 16:52:01', 'default-avatar.webp', 'gfgdfgdg@ffsf.com'),
	(2, 'manon', 'shthsrhrt', '2024-12-02 16:52:31', '', 'gdgbcgxdg@fds.com'),
	(13, 'ema', '$2y$10$8QTKlC.7aivwithn5M/1ie14f4BiBocm0wMpJ0F7DvJXDCA8y173a', '2024-12-13 15:41:51', '', 'ema@exemple.com'),
	(14, 'test', '$2y$10$IPH2M8qTJxHwnDgdK2WfFuZ4nPnBF2GrEOmxagwP7314uXMox9cJy', '2024-12-13 16:25:55', '', 'test@test.fr'),
	(15, 'test1', '$2y$10$oi/3kkR/JYba50FXrggbnOXoe/jpObVi3wOLuydRCGGjkGnTtMZx2', '2024-12-13 16:26:55', '', 'test1@test.fr'),
	(19, 'marv', '$2y$10$aACh.wU8pZODNs28Q/g63eZcb4RzzxtMbawcN0CZzH.awEz2jTHmC', '2024-12-22 22:47:45', '', 'marv@exemple.com'),
	(23, 'david', '$2y$10$emY6HeqMkiuRZ0CdrQ64A.JgLD18IQb3GBn/4zISC0Mec0lW3kWR.', '2024-12-24 16:11:42', 'R (1).jpg', 'david@exemple.com'),
	(25, 'erwin', '$2y$10$vg5Sx47lHmoP8xERCdsWPey50hkWci41sqRv63bf45ycEre64ScNC', '2025-01-01 20:15:20', 'default-avatar.webp', 'erwin@exemple.com'),
	(26, 'sku', '$2y$10$lTJk3zij1Cy26cDjkDLUTO8U8awQ1bSCvOPgCRj7mmqbrAPWHOosi', '2025-01-04 14:25:07', 'default-avatar.webp', 'erwin.philip68@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
