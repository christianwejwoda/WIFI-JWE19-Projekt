-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Apr 2019 um 22:42
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `printshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auftraege`
--

CREATE TABLE `auftraege` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produkt_id` int(10) UNSIGNED DEFAULT NULL,
  `ein_zwei_seitig` int(11) DEFAULT NULL,
  `grammatur_id` int(10) UNSIGNED DEFAULT NULL,
  `randlos` tinyint(1) DEFAULT NULL,
  `seitenzahl` int(11) DEFAULT NULL,
  `einheiten` int(11) DEFAULT NULL,
  `zustelloption_id` int(10) UNSIGNED DEFAULT NULL,
  `lieferdatum` date DEFAULT NULL,
  `akzeptiert` tinyint(1) DEFAULT NULL,
  `nachname` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vorname` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strasse` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plz` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ort` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `farbe` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deckblatt_text` text COLLATE utf8mb4_unicode_ci,
  `deckblatt_datei` int(255) UNSIGNED DEFAULT NULL,
  `inhalt_datei` int(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `auftraege`
--

INSERT INTO `auftraege` (`id`, `session_id`, `produkt_id`, `ein_zwei_seitig`, `grammatur_id`, `randlos`, `seitenzahl`, `einheiten`, `zustelloption_id`, `lieferdatum`, `akzeptiert`, `nachname`, `vorname`, `strasse`, `plz`, `ort`, `email`, `farbe`, `deckblatt_text`, `deckblatt_datei`, `inhalt_datei`) VALUES
(1, 'hkabtqjh2foifihk4tm1vvnsuc', 2, 1, 2, 0, 10, 1, 1, '2019-04-05', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 0, 0),
(2, 'hkabtqjh2foifihk4tm1vvnsuc', 2, 1, 2, 0, 10, 1, 1, '2019-04-05', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 1, 8),
(3, 'hkabtqjh2foifihk4tm1vvnsuc', 2, 1, 2, 0, 10, 1, 1, '2019-04-05', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 1, 8),
(4, 'hkabtqjh2foifihk4tm1vvnsuc', 3, 2, 3, 0, 10, 1, 1, '2019-04-18', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', '', 9, 8),
(5, 'hkabtqjh2foifihk4tm1vvnsuc', 3, 2, 3, 0, 10, 1, 1, '2019-04-19', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', '', 5, 9),
(6, '8etmf576476kjgrg0vdui08b5c', 2, 1, 2, 0, 10, 1, 1, '2019-04-11', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 26, 27),
(7, '49rqi02qitrvnub3o56ntcjeb8', 2, 1, 2, 0, 10, 6, 1, '2019-04-11', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 28, 29),
(8, 'f90m167lra7mjfvd7e6u8a8gm4', 4, 2, 4, 0, 15, 6, 2, '2019-05-02', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', '', 30, 31);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `id` int(10) UNSIGNED NOT NULL,
  `anzeigename` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `benutzername` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passwort` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `letzter_login` datetime DEFAULT NULL,
  `anzahl_logins` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`id`, `anzeigename`, `benutzername`, `email`, `passwort`, `letzter_login`, `anzahl_logins`) VALUES
(1, 'Wejwoda Christian', 'wechri', 'christian@wejwoda.at', '$2y$10$.vnSlrxiRPNHu.g7nap6i.MbgCJ76029LB7pFvT8pkhsJ0iFckjHm', '2019-04-17 20:15:18', 16);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gramaturen`
--

CREATE TABLE `gramaturen` (
  `id` int(10) UNSIGNED NOT NULL,
  `gramm_m2` int(10) UNSIGNED NOT NULL,
  `preis_blatt` decimal(6,4) DEFAULT NULL,
  `preis_druckseite` decimal(6,4) DEFAULT NULL,
  `maxseiten` int(11) DEFAULT NULL,
  `zeitproduktion` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `gramaturen`
--

INSERT INTO `gramaturen` (`id`, `gramm_m2`, `preis_blatt`, `preis_druckseite`, `maxseiten`, `zeitproduktion`) VALUES
(2, 80, '0.2000', '0.6000', 200, 2),
(3, 100, '1.0000', '2.0000', 150, 3),
(4, 120, '0.0000', '0.0000', 100, 4),
(8, 160, '0.0000', '0.0000', 60, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkte`
--

CREATE TABLE `produkte` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preis` decimal(8,2) DEFAULT NULL,
  `deckblattfarbauswahl` tinyint(1) DEFAULT NULL,
  `deckblatttexteingabe` tinyint(1) DEFAULT NULL,
  `zeitsetup` int(11) DEFAULT NULL,
  `zeitverpackung` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `produkte`
--

INSERT INTO `produkte` (`id`, `titel`, `preis`, `deckblattfarbauswahl`, `deckblatttexteingabe`, `zeitsetup`, `zeitverpackung`) VALUES
(2, 'Hardcover', '15.00', 1, 1, 5, 2),
(3, 'Spiralbindung', '6.00', 0, 0, 4, 3),
(4, 'Softcover', '8.00', 0, 0, 4, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `uploaddateien`
--

CREATE TABLE `uploaddateien` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_dateiname` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_dateiname` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `uploaddateien`
--

INSERT INTO `uploaddateien` (`id`, `session_id`, `upload_dateiname`, `org_dateiname`) VALUES
(1, 'hkabtqjh2foifihk4tm1vvnsuc', 'addb647fd00930a5866e8f64fe2a7bb0.pdf', 'Scan0006.pdf'),
(2, 'hkabtqjh2foifihk4tm1vvnsuc', 'e855a29938218d63cd9717b7fa33e07d.pdf', '20180911_Überweisungbestätigung.pdf'),
(3, 'hkabtqjh2foifihk4tm1vvnsuc', '4a8c0cd215114d422eb7f042f54ca196.pdf', '90-18_Zahlungsbestätigung.pdf'),
(4, 'hkabtqjh2foifihk4tm1vvnsuc', '6ecee22f0cc5cf0d64119e766c2a3c26.pdf', 'Scan0008.pdf'),
(5, 'hkabtqjh2foifihk4tm1vvnsuc', 'f40cbbc9da03de0fcaa7ffe716e9099b.pdf', 'Scan0003.pdf'),
(6, 'hkabtqjh2foifihk4tm1vvnsuc', '8bed3751e7713ff58ea02018d9b5a52f.pdf', 'Scan0006.pdf'),
(7, 'hkabtqjh2foifihk4tm1vvnsuc', 'f28766b390a5bcba93a112432d4c6436.pdf', 'Scan0003.pdf'),
(8, 'hkabtqjh2foifihk4tm1vvnsuc', '449d153ddeb16fb855089b558aa54098.pdf', 'Scan0005.pdf'),
(9, 'hkabtqjh2foifihk4tm1vvnsuc', 'cb3a83fd226341c658f990d3e427cffa.pdf', 'Scan0004.pdf'),
(10, 'hkabtqjh2foifihk4tm1vvnsuc', '08f1a71774e723f6751659ff64093a0c.pdf', 'Scan0006.pdf'),
(11, 'hkabtqjh2foifihk4tm1vvnsuc', 'bb3f8beab600478585c9ec916bf2cad4.pdf', 'Scan0003.pdf'),
(12, 'hkabtqjh2foifihk4tm1vvnsuc', 'fe7e4bfa4f2c4b56072c5a304bbd464a.pdf', 'Scan0004.pdf'),
(13, 'hkabtqjh2foifihk4tm1vvnsuc', 'e3ca734d6d3f4b48e6af211914fe6663.pdf', 'Scan0003.pdf'),
(14, 'hkabtqjh2foifihk4tm1vvnsuc', '2ae32c2d65394a132cbad1b84763dc07.pdf', 'Scan0004.pdf'),
(15, 'hkabtqjh2foifihk4tm1vvnsuc', 'f68240fd54737033cb491d1d50ddf327.pdf', 'Scan0006.pdf'),
(16, 'hkabtqjh2foifihk4tm1vvnsuc', 'a3d9cf4fe3fa3b14b7da603b0d9159b9.pdf', 'Scan0006.pdf'),
(17, 'hkabtqjh2foifihk4tm1vvnsuc', '2e737093ee8cf7c8e38ee1fec55df44e.pdf', 'Scan0003.pdf'),
(18, 'hkabtqjh2foifihk4tm1vvnsuc', '0649e30bcfa1849fa2dd8a7ceb9821cd.pdf', 'Scan0006.pdf'),
(19, 'hkabtqjh2foifihk4tm1vvnsuc', '1820390986a62d186da39d6b30a5da18.pdf', 'Scan0005.pdf'),
(20, 'hkabtqjh2foifihk4tm1vvnsuc', 'bf0b45c6c563f72ddb0f10fb0a079ba5.pdf', 'Scan0006.pdf'),
(21, 'hkabtqjh2foifihk4tm1vvnsuc', '27ef1937b89f8b2c61c7f0d3fac5423e.pdf', 'Scan0005.pdf'),
(22, 'hkabtqjh2foifihk4tm1vvnsuc', '5f51230f88d35b390080d4c5df89dd2a.pdf', 'Scan0004.pdf'),
(23, 'hkabtqjh2foifihk4tm1vvnsuc', '58ab51328c015c591d826616fd828767.pdf', 'Scan0005.pdf'),
(24, 'hkabtqjh2foifihk4tm1vvnsuc', '46a5e8d0f144a0d0fe3fd6e9d1abb237.pdf', 'Scan0003.pdf'),
(25, 'hkabtqjh2foifihk4tm1vvnsuc', '0be0b95a9d8e5d80b25fd5c3b6c8226c.pdf', 'Scan0004.pdf'),
(26, '8etmf576476kjgrg0vdui08b5c', '433d57648ab602834676b3a03ef3b9f6.pdf', 'Scan0011.pdf'),
(27, '8etmf576476kjgrg0vdui08b5c', 'f412b15e207f90af4f81037e7e36b4cd.pdf', 'Scan0010.pdf'),
(28, '49rqi02qitrvnub3o56ntcjeb8', '2a5d44fca9880fbbb5dde7ff4950ecc3.pdf', 'Scan0009.pdf'),
(29, '49rqi02qitrvnub3o56ntcjeb8', 'f95c40b40055c1b2975062e6a95d3086.pdf', 'Scan0008.pdf'),
(30, 'f90m167lra7mjfvd7e6u8a8gm4', 'c6bc4e41879cb279469105cee356c5b8.pdf', 'Scan0006.pdf'),
(31, 'f90m167lra7mjfvd7e6u8a8gm4', '2314cb45b2bafb075629b6d55976c3a4.pdf', 'Scan0005.pdf');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zustelloptionen`
--

CREATE TABLE `zustelloptionen` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preis` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `zustelloptionen`
--

INSERT INTO `zustelloptionen` (`id`, `titel`, `preis`) VALUES
(1, 'Versandkostenpauschale', '14'),
(2, 'Abholung', '0');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `auftraege`
--
ALTER TABLE `auftraege`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grammtur_id` (`grammatur_id`),
  ADD KEY `produkt_id` (`produkt_id`),
  ADD KEY `zustelloption_id` (`zustelloption_id`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gramaturen`
--
ALTER TABLE `gramaturen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gramm_m2` (`gramm_m2`) USING BTREE;

--
-- Indizes für die Tabelle `produkte`
--
ALTER TABLE `produkte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ixTitel` (`titel`);

--
-- Indizes für die Tabelle `uploaddateien`
--
ALTER TABLE `uploaddateien`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `zustelloptionen`
--
ALTER TABLE `zustelloptionen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `auftraege`
--
ALTER TABLE `auftraege`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `gramaturen`
--
ALTER TABLE `gramaturen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `produkte`
--
ALTER TABLE `produkte`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `uploaddateien`
--
ALTER TABLE `uploaddateien`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT für Tabelle `zustelloptionen`
--
ALTER TABLE `zustelloptionen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `auftraege`
--
ALTER TABLE `auftraege`
  ADD CONSTRAINT `auftraege_ibfk_1` FOREIGN KEY (`grammatur_id`) REFERENCES `gramaturen` (`id`),
  ADD CONSTRAINT `auftraege_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkte` (`id`),
  ADD CONSTRAINT `auftraege_ibfk_3` FOREIGN KEY (`zustelloption_id`) REFERENCES `zustelloptionen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
