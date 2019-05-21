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
  <body>
    <h2>Logout</h2>
    <p>Sie wurden erfolgreich ausgeloggt.</p>
    <p>
      <a href="login.php">hier geht es zurück zum Login</a>
    </p>
  <!-- </body>
</html> -->
