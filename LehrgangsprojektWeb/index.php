<?php
require_once "lib/setup.php";

if ( empty($_GET["page"]) ) {
  $page = "home";
} else {
  $page = $_GET["page"];
}

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

require "content/header.php";
require "content/" . $include_file;
require "content/footer.php";
