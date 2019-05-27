 <?php

 require_once "../lib/setup.php";
 require_once "content/config.php";

 if (empty($_SESSION["benutzer_id"])) {
   // Loginbereich aufrufen
   header("Location: login.php");
   exit;
 }

 if ( empty($_GET["page"]) ) {
   $page = "home";
 } else {
   $page = $_GET["page"];
 }

 $pagetitle = "";
 foreach ($menu_items as $admin_menu_item) {
   if ($admin_menu_item["url_part"] == $page) {
     $pagetitle = $admin_menu_item["pagetitle"] . " - " .$companyname;
     $meta_discription = $admin_menu_item["meta_discription"];
     $include_file = $admin_menu_item["include_file"];
     if ($admin_menu_item["redirect"] == true) {
       header("Location: " . $include_file);
       exit;
     }
   }
 }
 if ($pagetitle == "") {
   // Seite gibt es bei uns nicht -> error 404 ausgeben
   header("HTTP/1.1 404 Not Found"); // für Suchmaschine
   $pagetitle = "Error 404 - " . $companyname;
   $meta_discription ="Leider ist da was schief gegangen.";
   $include_file = "error404.php";
 }

 require "header.php";
 require "content/". $include_file;
 require "footer.php";

  ?>
