<?php
require_once "setup.php";

// is_logged_in();

// require "content/config.php";

if ( empty($_GET["page"]) ) {
  $page = "home";
} else {
  $page = $_GET["page"];
}

switch ($page) {

  case 'anfrage_form_saved':
  case 'anfrage_form':
    $pagetitle = "Anfrage - " . $companyname;
    $meta_discription ="Anfrage ausfüllen.";
    $include_file = "{$page}.php";
    break;

  default:
    $pagetitle = "";
    foreach ($menu_items as $menu_item) {
      if ($menu_item["url_part"] == $page) {
        $pagetitle = $menu_item["pagetitle"] . " - " .$companyname;
        $meta_discription = $menu_item["meta_discription"];
        $include_file = $menu_item["include_file"];
      }
    }
    if ($pagetitle == "") {
      // Seite gibt es bei uns nicht -> error 404 ausgeben
      header("HTTP/1.1 404 Not Found"); // für Suchmaschine
      $pagetitle = "Error 404 - " . $companyname;
      $meta_discription ="Leider ist da was schief gegangen.";
      $include_file = "error404.php";
    }
    break;
}

require "header.php";
require "content/" . $include_file;
require "footer.php";

// https://www.druckerei-salzburg.at/produkte2/spiralbindung-digital.html
// https://www.w3schools.com/php/php_file_upload.asp
