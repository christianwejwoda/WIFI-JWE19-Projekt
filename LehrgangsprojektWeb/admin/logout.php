<?php
// session_start();

// Alle sessionvariablen entfernen
session_unset();

 // Vernichtet die ganze Session samt Cookie.
 // beim nächsten Sessionstart() wird wieder ganz von vorne begonnen.
 session_destroy();

 ?><!DOCTYPE html>
<!-- <html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Rezepte-Administraton</title>
  </head> -->
  <!-- <body> -->
  <div class="container">
    <div class="row">
      <h2 class="col-12">Logout</h2>
    </div>
    <div class="row">
      <div class="col-12">
        Sie wurden erfolgreich ausgeloggt.
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a href="login.php">hier geht es zurück zum Login</a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a href="../home">hier geht es zur Hauptseite</a>
      </div>
    </div>
  </div>
  <!-- </body>
</html> -->
