-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 27. Mai 2019 um 22:49
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
  `inhalt_datei` int(255) UNSIGNED DEFAULT NULL,
  `preis_fix` decimal(10,2) DEFAULT NULL,
  `geprueft` tinyint(1) NOT NULL DEFAULT '0',
  `price_per_page` decimal(10,2) DEFAULT NULL,
  `price_add_randlos_add` decimal(10,2) DEFAULT NULL,
  `price_add_cover_add` decimal(10,2) DEFAULT NULL,
  `price_delivery_add` decimal(10,2) DEFAULT NULL,
  `produktionszeit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `auftraege`
--

INSERT INTO `auftraege` (`id`, `session_id`, `produkt_id`, `ein_zwei_seitig`, `grammatur_id`, `randlos`, `seitenzahl`, `einheiten`, `zustelloption_id`, `lieferdatum`, `akzeptiert`, `nachname`, `vorname`, `strasse`, `plz`, `ort`, `email`, `farbe`, `deckblatt_text`, `deckblatt_datei`, `inhalt_datei`, `preis_fix`, `geprueft`, `price_per_page`, `price_add_randlos_add`, `price_add_cover_add`, `price_delivery_add`, `produktionszeit`) VALUES
(1, '71i47j52jmpe5lvnntta5ofghf', 2, 1, 2, 0, 22, 224, 1, '2019-01-11', 0, 'Wejwoda 1', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 47, 48, NULL, 0, '17.60', NULL, NULL, NULL, NULL),
(2, 'ka9gsabm7utmhtibhvqk69ccbt', 2, 2, 2, 0, 10, 1, 1, '2019-06-22', 0, 'Wejwoda 2', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'christian@wejwoda.at', '#000000', 'sdf asdgf g asd', 49, 50, '90.00', 1, '7.00', '0.00', '15.00', '14.00', '8.00'),
(3, 's9m5spado8bj1hs60fu0eri3nm', 4, 2, 3, 0, 50, 30, 1, '2019-06-30', 0, 'Wejwoda 3', 'Christian', 'Marx-Reichlich-Straße 3/2', '5020', 'Salzburg', 'cherry30@gmx.at', '#000000', '', NULL, 51, '200.50', 1, '125.00', '6.25', '8.00', '14.00', '9.00');

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
(1, 'Wejwoda Christian', 'wechri', 'christian@wejwoda.at', '$2y$10$dmMsGuQain/LHW8pWqEeleU2sD76xD0tLeuYtigY84f6z6WTCjMa2', '2019-05-20 23:51:51', 34),
(2, 'Trainer', 'jwe', 'jwe@wifi.at', '$2y$10$bq0w1eoJlwBS6S6OhA4.c.phjPzxQ/RGUMSOqPjoFwPt8w4SYP39W', NULL, 2);

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
(12, '67npaes4j28m2j9rj78c5kajm6', '4d904d09474b8ebbd43aedb136f83cc7.pdf', '89-18_Zahlungsbestätigung.pdf'),
(13, 'knmqiflnc86i2upehovkmms9ma', '03b8ba6b69f47b795aabba835e501cfe.pdf', '20180911_Überweisungbestätigung.pdf'),
(14, 'knmqiflnc86i2upehovkmms9ma', 'd63948c0afbbfcbfd700222bbe9ce869.pdf', 'Daten_Unfall_Autobahn_Wohnwagendeckel.pdf'),
(15, '65c1fs1s690niu3vh7r4ntioab', '768b9b172decc31103a93c8d000f2844.pdf', 'Scan0003.pdf'),
(16, '8aral8bhiq96n023ie97rjofeg', '37149c3a825b9f6969f644846f9b354e.pdf', 'Scan0004.pdf'),
(17, '8aral8bhiq96n023ie97rjofeg', 'ac202ab55cddbcf83056d113dbcf8427.pdf', 'Scan0006.pdf'),
(18, 'i983r5pvdh86qv9lnvgcmf5vu0', 'a58443c7a6ec2557c3b779f02b10f346.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(19, 'i983r5pvdh86qv9lnvgcmf5vu0', '62ff4632fd5781dca481061d61ab8e90.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(20, 'i983r5pvdh86qv9lnvgcmf5vu0', '00b01c1f79d788eaf0815a85562293d4.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(21, 'i983r5pvdh86qv9lnvgcmf5vu0', 'c6cc87b94b3fdbdd3551f171b1dbea6a.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(22, 'i983r5pvdh86qv9lnvgcmf5vu0', '6e86da1b563eb704abda314dcfe768d1.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(23, '90en2mn1h0lr93qb06vho878vt', 'd971d09ad7f1c1591cd03316c218eefe.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(24, '90en2mn1h0lr93qb06vho878vt', 'a7c382b174183d5e5fb432ea75a109d7.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(25, 'hom8ore60spu46ual9ui85kab4', '21392291ba920c9c81ba7c09a1a75914.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(26, 'hom8ore60spu46ual9ui85kab4', '9f90d5af3aaf026091864e0732a12540.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(27, 'hom8ore60spu46ual9ui85kab4', '6da39a34c411044c9c48190e278eb734.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(28, 'hom8ore60spu46ual9ui85kab4', 'c50c2d7702d55bc2bd0126cc5b78f75c.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(29, 'hom8ore60spu46ual9ui85kab4', '4f1c7e3d5c4e9a40624bcd48c4924c33.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(30, 'hom8ore60spu46ual9ui85kab4', '72ccfeb9b454647a96881af41af8246b.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(31, 'hom8ore60spu46ual9ui85kab4', '34e15178481e525aaa9c4198ca317f5f.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(32, 'hom8ore60spu46ual9ui85kab4', '243c94c9fd459f1ff8261020678cf248.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(33, 'qb7jp7hr5ujhc2hbvic2jpp784', '4a1188a17a32c7b6e4a66b87c9fa2e36.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(34, 'qb7jp7hr5ujhc2hbvic2jpp784', '7e29e7a25e2378e5c62d57d77c536769.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(35, 'p79pn6mq6bdd4m6afpsg93lcp9', '6b315105545845976d05faefef539619.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(36, 'p79pn6mq6bdd4m6afpsg93lcp9', '879d546c75706293970c57569de96301.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(37, 'p79pn6mq6bdd4m6afpsg93lcp9', '1db71e4e7a1ca9628169632168ce3ab5.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(38, 'p79pn6mq6bdd4m6afpsg93lcp9', 'b1c45220d0ef1c4413127ef62c1933c4.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(39, 'p79pn6mq6bdd4m6afpsg93lcp9', '22498ca73e8fd4b7b45b07f4108bbe25.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(40, 'p79pn6mq6bdd4m6afpsg93lcp9', '5fcc2f0f137040d94c96fb964d5bfd48.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(41, 'p79pn6mq6bdd4m6afpsg93lcp9', 'e6ca63f68227827f0b5d26f9c8196996.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(42, 'p79pn6mq6bdd4m6afpsg93lcp9', 'bbdcdfab2b13689d7db8abab96fc1013.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(43, 'p79pn6mq6bdd4m6afpsg93lcp9', '492cc7eff7377598a823f05b525eb5d8.pdf', 'Projekt-JWE-2018-2019-WIFI-Salzburg.pdf'),
(44, '6qc0r49h4ct5qj439iunqlue06', 'd1e07b3ed96d391987389d049ef87067.pdf', '90-18_a.pdf'),
(45, '6qc0r49h4ct5qj439iunqlue06', '2cd9c4419abbe2a5d97108da0a953015.pdf', 'Scan0007.pdf'),
(46, '6qc0r49h4ct5qj439iunqlue06', 'f83b3f5a420289dac6895141e2d28073.pdf', '20180911_Überweisungbestätigung.pdf'),
(47, '71i47j52jmpe5lvnntta5ofghf', 'b1a4420dc3631fa1276e53a620ec9042.pdf', 'Scan0005.pdf'),
(48, '71i47j52jmpe5lvnntta5ofghf', '66ccb316e420d63af1ad43ec073feb8e.pdf', 'Scan0004.pdf'),
(49, 'ka9gsabm7utmhtibhvqk69ccbt', '758fde4f1d9e3e3258022e94514e8a66.pdf', 'Scan0003.pdf'),
(50, 'ka9gsabm7utmhtibhvqk69ccbt', 'dcf9157764ec8ab65b50e2f162444b26.pdf', '20180911_Verordnung.pdf'),
(51, 's9m5spado8bj1hs60fu0eri3nm', '70c45c533fb373b91c290801f02d8915.pdf', 'Scan0004.pdf');

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
(1, 'Versand', '14'),
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
