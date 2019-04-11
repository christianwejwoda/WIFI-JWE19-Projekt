<?php
  // wurde das Formular abgeschickt
  if (!empty($_POST)) {
    // Validierung
    if (empty($_POST["benutzername"]) || empty($_POST["passwort"])) {
      $error = "Benutzername oder Passwort war leer!";
    } else {
      // Benutzer und Passwort wurden übergeben
      // -> in der Datenbank nachsehen, ob der Benutzer existiert

      // verbindung zur Datenbank herstellen
      $db = mysqli_connect("localhost", "root", "", "printshop");
      // MySQL mitteilen, dass unsere Befehle als utf8 kommen
      mysqli_set_charset($db, "utf8");

      // Daten von Formularen/Benutzer ($_GET oder $_POST)
      // IMMER !!! mit mysqli_real_escape_string behandeln,
      // bevor sie in Datenbank-Befehlen verwendet werden.
      // --> böse Zeichen escapen
      $sql_benutzername = mysqli_real_escape_string($db, $_POST["benutzername"]);

      // Datenbank fragen ob der angegebene Benutzer existiert
      $result = mysqli_query($db, "SELECT * FROM benutzer WHERE benutzername='{$sql_benutzername}';") or die(mysqli_error($db));

      // Einen Datensatz aus MySQL in ein PHP-Array umwandeln
      $row = mysqli_fetch_assoc($result);
      if ($row) {
        // Benutzer existiert -> Passwort prüfen
        if (password_verify($_POST["passwort"],$row["passwort"])) {
          // letztes Login und Anzahl Logins in DB speichern

          mysqli_query($db, "UPDATE benutzer SET letzter_login = NOW(), anzahl_logins = anzahl_logins + 1 WHERE id = '{$row["id"]}';") or die(mysqli_error($db));

          // alles Super --> login merken
          session_start();
          $_SESSION["benutzer_id"] = $row["id"];
          $_SESSION["benutzer_name"] = $row["benutzername"];
          $_SESSION["benutzer_anzeigename"] = $row["anzeigename"];
          // umleitung ins Admin-System
          header("Location: index.php");
          exit;

        } else {
          // Passwort ist falsch
          $error = "Benutzername oder Passwort falsch.";
        }
      } else {
        // Benutzer nicht in DB --> Fehlermeldung
        $error = "Benutzername oder Passwort falsch.";
      }
    }
  }

 ?><!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Loginbereich - <?php echo $companyname; ?></title>
  </head>
  <body>
    <h1>Loginbereich zum Administrations-Bereich</h1>

    <?php
      // Fehlermeldung ausgeben, wenn eine aufgetreten ist
      if (!empty($error)) {
        echo "<p>{$error}</p>";
      }
     ?>
    <form class="" action="login.php" method="post">

      <div class="">
        <label for="benutzername">Benutzername:</label>
        <input type="text" name="benutzername" id="benutzername" value="" />
      </div>

      <div class="">
        <label for="passwort">Passwort:</label>
        <input type="password" name="passwort" id="passwort" />
      </div>

      <div class="">
        <button type="submit">einloggen</button>
      </div>

    </form>
  </body>
</html>
