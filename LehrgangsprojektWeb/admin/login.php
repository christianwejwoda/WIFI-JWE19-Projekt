<?php
require_once "../lib/setup.php";

  // wurde das Formular abgeschickt
  if (!empty($_POST)) {
    // Validierung
    if (empty($_POST["benutzername"]) || empty($_POST["passwort"])) {
      $error = "Benutzername oder Passwort war leer!";
    } else {
      // Benutzer und Passwort wurden übergeben
      $row = new db_benutzer("benutzername = ?,".$_POST["benutzername"]);
      // Datenbank fragen ob der angegebene Benutzer existiert
      if ($row) {
        // Benutzer existiert -> Passwort prüfen
        if (password_verify($_POST["passwort"],$row->passwort)) {
          // letztes Login und Anzahl Logins in DB speichern

          $row->anzahl_logins++;
          $row->save();
          // alles Super --> login merken
          $_SESSION["benutzer_id"] = $row->id;
          $_SESSION["benutzer_name"] = $row->benutzername;
          $_SESSION["benutzer_anzeigename"] = $row->anzeigename;
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href ="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <title>Loginbereich - <?php echo $companyname; ?></title>
  </head>

  <body>

    <?php
      // Fehlermeldung ausgeben, wenn eine aufgetreten ist
      if (!empty($error)) {
        echo "<p>{$error}</p>";
      }
     ?>
     <div class="menurow">
     </div>
    <form class="container" action="login.php" method="post">
      <h2>Loginbereich zum Administrations-Bereich</h2>
      <div class="form-group row">
        <label class="col-12 col-lg-3" for="benutzername">Benutzername:</label>
        <input class="col-12 col-lg-3" type="text" name="benutzername" id="benutzername" value="" />
      </div>

      <div class="form-group row">
        <label class="col-12 col-lg-3" for="passwort">Passwort:</label>
        <input class="col-12 col-lg-3" type="password" name="passwort" id="passwort" />
      </div>

      <div class="form-group row">
        <button class="col-12 col-lg-6 btn btn-primary" type="submit">einloggen</button>
      </div>
      <div class="row">
        <!-- <a class="col-12 col-lg-3" href="../home">zurück</a> -->
        <a class="col-12 col-lg-6 text-center" href="../home">
          <!-- <button  type="button"> -->
            zurück zur Hauptseite
          <!-- </button> -->
        </a>
      </div>

    </form>
  </body>
</html>
