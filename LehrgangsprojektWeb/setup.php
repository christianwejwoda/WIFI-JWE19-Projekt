<?php
// Konfigurtion für das Projekt
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "root");
define("MYSQL_PASSWORD", "");
define("MYSQL_DATABASE", "printshop");

$companyname = "das Druckhaus";
$menu_items = array(
  array ("url_part" => "home", "include_file" => "home.php", "display" => "", "pagetitle" => "", "meta_discription" => "Übersicht über unsere Produkte und Leistungen."),
  array ("url_part" => "unternehmen", "include_file" => "unternehmen.php", "display" => "Unternehmen", "pagetitle" => "Unternehmen", "meta_discription" => "Wir über uns. Philosophie usw...."),
  array ("url_part" => "printshop", "include_file" => "printshop.php", "display" => "Printshop", "pagetitle" => "Online-Printshop", "meta_discription" => "Stellen Sie ihre Wünsche zusammen und fordern Sie ein Angebot an."),
  array ("url_part" => "contact", "include_file" => "contact.php", "display" => "Kontakt", "pagetitle" => "Kontakt", "meta_discription" => "Hier können Sie uns kontaktieren.")
  );

  // Datenbank lesen
  // $produkte = mysqli_query($db, "SELECT * FROM produkte WHERE inaktiv = 0 ORDER BY titel;") or die(mysqli_error($db));
  // $gramaturen = mysqli_query($db, "SELECT * FROM gramaturen WHERE inaktiv = 0 ORDER BY gramm_m2;") or die(mysqli_error($db));

// Setup-Code: Ab hier nichts mehr ändern!
session_start();

spl_autoload_register(function($klasse)
{
  $pfad = str_replace('_','/',$klasse) . ".php";
  require_once $pfad;
});

function is_logged_in()
{
  if (empty($_SESSION["benutzer_id"])) {
    header("Location: login.php");
  }
}
