<?php
// Konfigurtion für das Projekt
define("MYSQL_HOST", "localhost");
if ($_SERVER["HTTP_HOST"] == "localhost") {
  define("MYSQL_USER", "root");
  define("MYSQL_PASSWORD", "");
  define("MYSQL_DATABASE", "printshop");
} else {
  define("MYSQL_USER", "cwejwoda");
  define("MYSQL_PASSWORD", "19Bu2v?c");
  define("MYSQL_DATABASE", "cwejwoda_printshop");
}

$companyname = "das Druckhaus";
$menu_items = array(
  array ("url_part" => "home", "include_file" => "home.php", "display" => "", "pagetitle" => "", "meta_discription" => "Übersicht über unsere Produkte und Leistungen."),
  array ("url_part" => "unternehmen", "include_file" => "unternehmen.php", "display" => "Unternehmen", "pagetitle" => "Unternehmen", "meta_discription" => "Wir über uns. Philosophie usw...."),
  array ("url_part" => "printshop", "include_file" => "printshop.php", "display" => "Printshop", "pagetitle" => "Online-Printshop", "meta_discription" => "Stellen Sie ihre Wünsche zusammen und fordern Sie ein Angebot an."),
  array ("url_part" => "contact", "include_file" => "contact.php", "display" => "Kontakt", "pagetitle" => "Kontakt", "meta_discription" => "Hier können Sie uns kontaktieren."),
  array ("url_part" => "admin", "include_file" => "", "display" => "Adminbereich", "pagetitle" => "Adminbereich", "meta_discription" => "Hier können Sie als Admin diverse Konfigurationen durchführen."),
  );

require_once "functions.php";
