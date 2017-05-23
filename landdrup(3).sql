-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 23. 05 2017 kl. 14:42:01
-- Serverversion: 5.6.24
-- PHP-version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `landdrup`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `aldersgrupper`
--

CREATE TABLE IF NOT EXISTS `aldersgrupper` (
  `id` int(11) NOT NULL,
  `navn` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `brugere`
--

CREATE TABLE IF NOT EXISTS `brugere` (
  `id` int(11) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `fk_profil` int(11) DEFAULT NULL,
  `fk_brugerrolle` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `brugere`
--

INSERT INTO `brugere` (`id`, `email`, `password`, `fk_profil`, `fk_brugerrolle`) VALUES
(1, 'Admin@admin.com', '$2y$12$vWVDUaQKPc5NkpVs7PJDSul2uxuq0uXT/tJa6k3YT5E/axKhMo9b6', 3, 4),
(2, 'mig@test.fuck', '$2y$12$rG/3GdzakCH3BjUYfa63w.hwwQ1GznacwY1N8WFhOZ9xh9S7iezVq', 4, 4),
(3, 'test@test.dk', '$2y$12$6v1nVzMzLLSHQt18ivEQ.uVvWG3e.GDC3bGUJac8AQMG.pgBiaRh6', 5, 4),
(4, 'feck@test.dk', '$2y$12$KujJeAK6ru2xYc06BOJplOxpBA1VCuTc7vzzfQwVXgbi2HB5fFiym', 6, 4),
(5, 'test@admin.com', '$2y$12$BEFWR1s/KK4rlMWJ0Cy4wu8Le3krz/XHb4xXIKNzvc8rGDOX.its2', 7, 4),
(6, 'mig@fuck.nu', '$2y$12$Dj4gTqIVNejFL6uIYStbTedQukc9Vm91EI0ZRn3XL/GTf.KWKfGTO', 9, 4),
(7, 'test@dk.dk', '$2y$12$cqmigEiANjArudlL7Eru.eVl.iCaUXMFu5C.nV8qYZIiCQTmlFWnu', 10, 4),
(8, 'fuck@mig.test', '$2y$12$HY2hAdSUKKs9DuvydkO3De1bLcsExyFPltahUy7bIUApSgpN9uwIa', 11, 4),
(9, '1234@1234.dk', '$2y$12$Hdshe1Pqat0QKjPlZErzWudzfa5ubzAQnyv5b5PVDAu5OObW1y6oG', 12, 4),
(10, 'fucking@fuck.nu', '$2y$12$Y77vJB9SN/nNDhe0QDBOxeACUryca8i.bM/WISaVoBGF69rKQnx7q', 13, 4),
(11, 'Admin@lort.nu', '$2y$12$3bjbcENsjsA7FJpUOaqJ6uj5WMFJAODkdF.0J7/Htd/aRLauvp6sq', 14, 4),
(12, 'godt@det.virker', '$2y$12$KUjuOqtP6/I4PI8LwUke..NQiFYRWGOHakgGcq8N4eUXn9U3PM4EK', 15, 4),
(13, 'hell@comes.soon', '$2y$12$MHBFHOQs/6uahEBpvHTJOu6sW/S7XqHvOtdXEztSA.XpH8x0yqVv.', 16, 4),
(14, 'hidden@ninja.com', '$2y$12$dMwGpaazec/4PViojxAMuOKHkH4KQUox182vG4L/lCju0DOmf7RKu', 17, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `brugerroller`
--

CREATE TABLE IF NOT EXISTS `brugerroller` (
  `id` int(11) NOT NULL,
  `navn` varchar(10) DEFAULT NULL,
  `niveau` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `brugerroller`
--

INSERT INTO `brugerroller` (`id`, `navn`, `niveau`) VALUES
(1, 'SuperUser', 99),
(2, 'Admin', 90),
(3, 'Medarb', 50),
(4, 'Kunde', 30);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `deltagere`
--

CREATE TABLE IF NOT EXISTS `deltagere` (
  `id` int(11) NOT NULL,
  `fk_hold` int(11) DEFAULT NULL,
  `fk_kunde` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `hold`
--

CREATE TABLE IF NOT EXISTS `hold` (
  `id` int(11) NOT NULL,
  `holdnummer` varchar(8) DEFAULT NULL,
  `fk_stilart` int(11) DEFAULT NULL,
  `fk_instruktor` int(11) DEFAULT NULL,
  `fk_aldersgruppe` int(11) DEFAULT NULL,
  `fk_niveau` int(11) DEFAULT NULL,
  `pris` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `instruktor`
--

CREATE TABLE IF NOT EXISTS `instruktor` (
  `id` int(11) NOT NULL,
  `fk_media` int(11) DEFAULT NULL,
  `beskrivelse` text,
  `fk_profil` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `instruktor`
--

INSERT INTO `instruktor` (`id`, `fk_media`, `beskrivelse`, `fk_profil`) VALUES
(1, 1, 'Test', 14);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL,
  `sti` varchar(255) DEFAULT NULL,
  `type` varchar(90) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `media`
--

INSERT INTO `media` (`id`, `sti`, `type`) VALUES
(1, '1495542760_17273512_1734206469926755_447980765_o.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `niveau`
--

CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int(11) NOT NULL,
  `navn` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `profil`
--

CREATE TABLE IF NOT EXISTS `profil` (
  `id` int(11) NOT NULL,
  `fornavn` varchar(30) DEFAULT NULL,
  `efternavn` varchar(30) DEFAULT NULL,
  `fodselsdato` date DEFAULT NULL,
  `adresse` varchar(65) DEFAULT NULL,
  `postnr` int(5) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `tlf` int(8) DEFAULT NULL,
  `oprettet` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `profil`
--

INSERT INTO `profil` (`id`, `fornavn`, `efternavn`, `fodselsdato`, `adresse`, `postnr`, `city`, `tlf`, `oprettet`) VALUES
(1, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-19 12:28:48'),
(2, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-19 12:32:02'),
(3, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-19 12:32:57'),
(4, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-19 12:46:20'),
(5, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 10:52:20'),
(6, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:21:50'),
(7, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:25:33'),
(8, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:30:36'),
(9, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:32:40'),
(10, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:34:28'),
(11, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:45:03'),
(12, 'Benjamin', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:46:27'),
(13, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:50:57'),
(14, 'Michael', 'Olsen', '2017-05-16', 'Landevejen 50', 5778, 'klsdjf', 50876254, '2017-05-22 14:52:23'),
(15, 'Robot', 'Ninja', '0666-06-06', 'Landevejen 666', 1337, 'Hell', 66666666, '2017-05-22 14:55:32'),
(16, 'Robot', 'Ninja', '0666-06-06', 'Hellhole 666', 666, 'Hell', 66666666, '2017-05-23 09:40:10'),
(17, 'Mr', 'Ninja', '0000-00-00', 'Hidden', 101, 'Leaf Town', 550022, '2017-05-23 10:37:05');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `sider`
--

CREATE TABLE IF NOT EXISTS `sider` (
  `id` int(11) NOT NULL,
  `tekst` text,
  `billede` varchar(64) DEFAULT NULL,
  `overskrift` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `stilarter`
--

CREATE TABLE IF NOT EXISTS `stilarter` (
  `id` int(11) NOT NULL,
  `navn` varchar(20) DEFAULT NULL,
  `beskrivelse` text,
  `billede` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `aldersgrupper`
--
ALTER TABLE `aldersgrupper`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `brugere`
--
ALTER TABLE `brugere`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_profil_idx` (`fk_profil`), ADD KEY `fk_brugerrolle_idx` (`fk_brugerrolle`);

--
-- Indeks for tabel `brugerroller`
--
ALTER TABLE `brugerroller`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `deltagere`
--
ALTER TABLE `deltagere`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_hold_idx` (`fk_hold`), ADD KEY `fk_kunde_idx` (`fk_kunde`);

--
-- Indeks for tabel `hold`
--
ALTER TABLE `hold`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `holdnummer_UNIQUE` (`holdnummer`), ADD KEY `fk_stilart_idx` (`fk_stilart`), ADD KEY `fk_instruktor_idx` (`fk_instruktor`), ADD KEY `fk_aldersgruppe_idx` (`fk_aldersgruppe`), ADD KEY `fk_niveau_idx` (`fk_niveau`);

--
-- Indeks for tabel `instruktor`
--
ALTER TABLE `instruktor`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_profil_idx` (`fk_profil`), ADD KEY `fk_media_idx` (`fk_media`);

--
-- Indeks for tabel `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `sider`
--
ALTER TABLE `sider`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `stilarter`
--
ALTER TABLE `stilarter`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `aldersgrupper`
--
ALTER TABLE `aldersgrupper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `brugere`
--
ALTER TABLE `brugere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Tilføj AUTO_INCREMENT i tabel `brugerroller`
--
ALTER TABLE `brugerroller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `deltagere`
--
ALTER TABLE `deltagere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `hold`
--
ALTER TABLE `hold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `instruktor`
--
ALTER TABLE `instruktor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tilføj AUTO_INCREMENT i tabel `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tilføj AUTO_INCREMENT i tabel `niveau`
--
ALTER TABLE `niveau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- Tilføj AUTO_INCREMENT i tabel `sider`
--
ALTER TABLE `sider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `stilarter`
--
ALTER TABLE `stilarter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `brugere`
--
ALTER TABLE `brugere`
ADD CONSTRAINT `fk_brugerProfil` FOREIGN KEY (`fk_profil`) REFERENCES `profil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_brugerrolle` FOREIGN KEY (`fk_brugerrolle`) REFERENCES `brugerroller` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `deltagere`
--
ALTER TABLE `deltagere`
ADD CONSTRAINT `fk_hold` FOREIGN KEY (`fk_hold`) REFERENCES `hold` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_kunde` FOREIGN KEY (`fk_kunde`) REFERENCES `profil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `hold`
--
ALTER TABLE `hold`
ADD CONSTRAINT `fk_aldersgruppe` FOREIGN KEY (`fk_aldersgruppe`) REFERENCES `aldersgrupper` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_instruktor` FOREIGN KEY (`fk_instruktor`) REFERENCES `instruktor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_niveau` FOREIGN KEY (`fk_niveau`) REFERENCES `niveau` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_stilart` FOREIGN KEY (`fk_stilart`) REFERENCES `stilarter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `instruktor`
--
ALTER TABLE `instruktor`
ADD CONSTRAINT `fk_media` FOREIGN KEY (`fk_media`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_profil` FOREIGN KEY (`fk_profil`) REFERENCES `profil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
