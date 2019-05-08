-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Mai 2019 um 21:13
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
(1, '2cspsd0bjt0c6nujt71tqddtbs', 2, 1, 3, 0, 10, 1, 1, '2019-05-17', NULL, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#e2d74d', 'dddddd', 1, 2),
(2, '8b1m621qfh2la9c0qr6mjfik2v', 3, 1, 2, 0, 10, 1, 1, '2019-05-10', NULL, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#9c928a', 'jfjfjjf', 3, 4),
(7, 'n8lk3q7j3jumtmngje0c19m55o', 2, 1, 2, 0, 10, 1, 1, '2019-05-10', 0, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#443d38', 'ffff', 7, 8),
(8, '3o03fbiihn3h5mhehpu16rk1f0', 2, 1, 2, 0, 10, 1, 1, '2019-05-09', 1, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#faed59', 'dddd', 9, 10),
(9, '3o03fbiihn3h5mhehpu16rk1f0', 2, 1, 2, 0, 10, 1, 1, '2019-05-09', 1, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#faed59', 'dddd', 9, 10),
(10, '3o03fbiihn3h5mhehpu16rk1f0', 2, 1, 2, 0, 10, 1, 1, '2019-05-09', 1, 'Wejwoda', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#faed59', 'dddd', 9, 10),
(11, 'h87bnggqnivf690ti8hq1hvbgi', 2, 2, 2, 0, 100, 13, 1, '2019-05-31', 1, 'Wejwoda', 'Fritz', 'Hierunddortgasse 5', '4820', 'Bad Ischl', 'Christian@wej.at', '#db9065', 'Hhhjhjjjjj', NULL, NULL);

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
(1, 'Wejwoda Christian', 'wechri', 'christian@wejwoda.at', '$2y$10$.vnSlrxiRPNHu.g7nap6i.MbgCJ76029LB7pFvT8pkhsJ0iFckjHm', '2019-04-27 14:35:25', 17);

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
(1, '2cspsd0bjt0c6nujt71tqddtbs', '7a48de329bc9ea114a6f7d5eae1b0681.pdf', 'Scan0011.pdf'),
(2, '2cspsd0bjt0c6nujt71tqddtbs', 'db1de7bed4e76e6004a3a1446dbab5bd.pdf', '90-18_a.pdf'),
(3, '8b1m621qfh2la9c0qr6mjfik2v', '751700f128e599a542db74194da450b7.pdf', 'Scan0008.pdf'),
(4, '8b1m621qfh2la9c0qr6mjfik2v', 'd6530954f5488013aeecceb4f91d775b.pdf', '89-18_a.pdf'),
(5, 'dned7gbtk9rii048gvmf5rrimf', '8564adb0497a06e151639da4549d8960.pdf', 'Scan0009.pdf'),
(6, 'dned7gbtk9rii048gvmf5rrimf', 'ff667c406cddd8115cb7b3f1bcf2c770.pdf', 'Scan0008.pdf'),
(7, 'n8lk3q7j3jumtmngje0c19m55o', 'c42eaf4a5a13956a0805256f67af2a49.pdf', 'Scan0009.pdf'),
(8, 'n8lk3q7j3jumtmngje0c19m55o', '02e3307c92275b6603d9760f69ce826c.pdf', 'Scan0008.pdf'),
(9, '3o03fbiihn3h5mhehpu16rk1f0', '156279c09292b5684ed8acf40bc7fe25.pdf', 'Scan0010.pdf'),
(10, '3o03fbiihn3h5mhehpu16rk1f0', '0ec8d02fe5daa6f325b279cf4049c9c7.pdf', 'Scan0009.pdf'),
(11, '67npaes4j28m2j9rj78c5kajm6', '3deabc626b4ad7ce29f671858b57a5c9.pdf', 'Scan0009.pdf'),
(12, '67npaes4j28m2j9rj78c5kajm6', '4d904d09474b8ebbd43aedb136f83cc7.pdf', '89-18_Zahlungsbestätigung.pdf');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `gramaturen`
--
ALTER TABLE `gramaturen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `produkte`
--
ALTER TABLE `produkte`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `uploaddateien`
--
ALTER TABLE `uploaddateien`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
