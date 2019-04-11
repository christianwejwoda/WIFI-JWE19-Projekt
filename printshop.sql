-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Apr 2019 um 00:05
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
(1, 'Wejwoda Christian', 'wechri', 'christian@wejwoda.at', '$2y$10$.vnSlrxiRPNHu.g7nap6i.MbgCJ76029LB7pFvT8pkhsJ0iFckjHm', '2019-04-11 21:30:17', 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gramaturen`
--

CREATE TABLE `gramaturen` (
  `id` int(10) UNSIGNED NOT NULL,
  `gramm_m2` int(10) UNSIGNED NOT NULL,
  `preis_blatt` decimal(6,4) DEFAULT NULL,
  `preis_druckseite` decimal(6,4) DEFAULT NULL,
  `inaktiv` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `gramaturen`
--

INSERT INTO `gramaturen` (`id`, `gramm_m2`, `preis_blatt`, `preis_druckseite`, `inaktiv`) VALUES
(1, 80, '0.0000', '0.0000', 0),
(2, 100, '0.0000', '0.8000', 0),
(3, 120, '1.5000', '0.0000', 0),
(4, 190, '0.0000', '0.0000', 0),
(5, 140, '0.0000', '0.0000', 0),
(6, 150, '0.0000', '0.0000', 0),
(7, 180, '0.0000', '0.0000', 0),
(8, 200, '0.0000', '0.0000', 0),
(9, 170, '9.0000', '0.0000', 0),
(10, 60, '0.0000', '0.0000', 0),
(11, 500, '0.0000', '0.0000', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkte`
--

CREATE TABLE `produkte` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preis` decimal(8,2) DEFAULT NULL,
  `inaktiv` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `produkte`
--

INSERT INTO `produkte` (`id`, `titel`, `preis`, `inaktiv`) VALUES
(1, 'Standard', '80.00', 0),
(2, 'Hardcover', '5.00', 0),
(3, 'Spiralbindung', '6.00', 0),
(4, 'Softcover', '8.00', 0),
(5, 'Holzcover', '102.60', 0),
(6, 'Ordner', '60.00', 0),
(7, 'Blech', '30.00', 0),
(9, 'Folienbindung', '30.00', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED DEFAULT NULL,
  `farbe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seitenoption` tinyint(3) UNSIGNED DEFAULT NULL,
  `seitenzahl` int(10) UNSIGNED DEFAULT NULL,
  `grammtur_id` int(10) UNSIGNED DEFAULT NULL,
  `randlos` tinyint(4) NOT NULL,
  `liefertermin_wunsch` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gramaturen`
--
ALTER TABLE `gramaturen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `produkte`
--
ALTER TABLE `produkte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ixTitel` (`titel`);

--
-- Indizes für die Tabelle `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grammtur_id` (`grammtur_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `gramaturen`
--
ALTER TABLE `gramaturen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `produkte`
--
ALTER TABLE `produkte`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`grammtur_id`) REFERENCES `gramaturen` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkte` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
