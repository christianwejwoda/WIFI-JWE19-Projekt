<?php

$validieren = new db_validieren();

if (!empty($_POST)) {

  $input_data = array();
  foreach ($_POST as $key => $value) {
    $key_parts = explode("_",$key);
    if ($key_parts[0] == "benutzer") {

      $id = $key_parts[1];
      $fieldname = $key_parts[2];

      if ($id == "neu") {
        $id = 0;
      } else {
        $input_data[$id]["id"] = $id;
      }
      switch ($fieldname) {
        case 'passwort':
          if (!empty($value)) {
            $input_data[$id][$fieldname] = password_hash($value, PASSWORD_DEFAULT);
          }
          break;

        default:
          $input_data[$id][$fieldname] = $value;
          break;
      }
    }
  }
  if (implode("",$input_data[0]) == "") {
    unset($input_data[0]);
  }

  foreach ($input_data as $value) {
    // Validierung
    $p_name = "Benutzer " . (array_key_exists("id",$value) ? $value["id"] : "NEU");
    $validieren->ist_ausgefuellt($value["anzeigename"],$p_name . " - Anzeigename");
    if ($value["benutzername"] != "0") {
      $validieren->ist_ausgefuellt($value["benutzername"],$p_name . " - Benutzername");
    }

    if ($validieren->alles_ok()) {
      $benutzer = new db_benutzer($value);
      if (!array_key_exists("id", $value) && $benutzer->check_double_entry($value["anzeigename"])) {
        $validieren->fehler_eintragen("anzeigename {$value["anzeigename"]} darf nicht doppelt sein!");
      } else {
        $benutzer->save();
      }
    }
  }

}
?>
        <form class="container-fluid" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Benutzer:</h2>
          <div class="form-group row d-none d-md-flex">
            <div class="col-2"></div>
            <label class="form-label col-2">Anzeigename</label>
            <label class="form-label col-1">Benutzer-name</label>
            <label class="form-label col-2">E-Mail</label>
            <label class="form-label col-1">neues Passwort</label>
            <label class="form-label col-2">letzer Login</label>
            <label class="form-label col-1">Anzahl Logins</label>
          </div>

            <?php
            $benutzerer = new db_benutzerer();
            foreach ($benutzerer->get() as $benutzer)
            {
              echo '<div class="form-group row">';
              echo '<label class="form-label col-12 col-md-2 h5" for="benutzer_' . $benutzer->id . '_anzeigename">Benutzer ' . $benutzer->id . ': </label>';

              echo '<label class="form-label col-4 d-block d-md-none">Anzeigename</label>';
              echo '<input class="form-control col-7 col-md-2" type="text" name="benutzer_' . $benutzer->id . '_anzeigename" id="benutzer_' . $benutzer->id . '_anzeigename" value="' . htmlspecialchars($benutzer->anzeigename) . '" readonly>';

              echo '<label class="form-label col-4 d-block d-md-none">Benutzername</label>';
              echo '<input class="form-control col-7 col-md-1" type="text" name="benutzer_' . $benutzer->id . '_benutzername" id="benutzer_' . $benutzer->id . '_benutzername" value="' . htmlspecialchars($benutzer->benutzername) . '">';

              echo '<label class="form-label col-4 d-block d-md-none">E-Mail</label>';
              echo '<input class="form-control col-7 col-md-2" type="text" name="benutzer_' . $benutzer->id . '_email" id="benutzer_' . $benutzer->id . '_email" value="' . htmlspecialchars($benutzer->email) . '">';

              echo '<label class="form-label col-4 d-block d-md-none">neues Passwort</label>';
              echo '<input class="form-control col-7 col-md-1" type="text" name="benutzer_' . $benutzer->id . '_passwort" id="benutzer_' . $benutzer->id . '_passwort" value="">';

              echo '<label class="form-label col-4 d-block d-md-none">letzer Login</label>';
              echo '<input class="form-control col-7 col-md-2" type="text" name="benutzer_' . $benutzer->id . '_letzterlogin" id="benutzer_' . $benutzer->id . '_letzterlogin" value="' . htmlspecialchars($benutzer->letzter_login) . '">';

              echo '<label class="form-label col-4 d-block d-md-none">Anzahl Logins</label>';
              echo '<input class="form-control col-7 col-md-1" type="text" name="benutzer_' . $benutzer->id . '_anzahllogins" id="benutzer_' . $benutzer->id . '_passwort" value="' . htmlspecialchars($benutzer->anzahl_logins) . '">';

              echo '</div>';
            }?>

            <div class="form-group row d-none d-md-flex">
              <div class="col-2"></div>
              <label class="form-label col-2">Anzeigename</label>
              <label class="form-label col-2">Benutzername</label>
              <label class="form-label col-2">E-Mail</label>
              <label class="form-label col-2">neues Passwort</label>
            </div>

            <div class="form-group row">
              <label class="form-label col-12 col-md-2 h5" for="benutzer_neu_anzeigename">Benutzer NEU: </label>

              <label class="form-label col-4 d-block d-md-none">Anzeigename</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_anzeigename" id="benutzer_neu_anzeigename" value="
              <?php
                if (array_key_exists("benutzer_neu_anzeigename",$_POST)) {
                  echo htmlspecialchars($_POST["benutzer_neu_anzeigename"]);
                }
              ?>
              "/>

              <label class="form-label col-4 d-block d-md-none">Benutzername</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_benutzername" id="benutzer_neu_benutzername" value="
              <?php
              if (array_key_exists("benutzer_neu_benutzername",$_POST)) {
                echo htmlspecialchars($_POST["benutzer_neu_benutzername"]);
              } ?>
              "/>

              <label class="form-label col-4 d-block d-md-none">E-Mail</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_email" id="benutzer_neu_email" value="
              <?php
              if (array_key_exists("benutzer_neu_email",$_POST)) {
                echo htmlspecialchars($_POST["benutzer_neu_email"]);
              } ?>
              "/>

              <label class="form-label col-4 d-block d-md-none">neues Passwort</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_passwort" id="benutzer_neu_passwort" value="
              <?php
              if (array_key_exists("benutzer_neu_passwort",$_POST)) {
                echo htmlspecialchars($_POST["benutzer_neu_passwort"]);
              } ?>
              "/>
            </div>
            <?php
            if (!$validieren->alles_ok()) {
              echo $validieren->fehler_html();
            }
           ?>
          <div>
            <button class="btn-send" type="submit" >speichern</button>
          </div>
        </form>
