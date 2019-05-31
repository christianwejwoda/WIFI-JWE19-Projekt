<?php

$validieren = new db_validieren();
$neu_ok = false;

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
          } else {
            $input_data[$id][$fieldname] = "";
          }
          break;

        case 'istadmin':
          if ($value == 0) {
            $input_data[$id][$fieldname] = "";
          } else {
            $input_data[$id][$fieldname] = $value;
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
    // echo "<pre>";print_r($value);echo"</pre>";
    // echo $p_name . " - " . empty($value) ? "X":"y";
    $validieren->ist_ausgefuellt($value["anzeigename"],$p_name . " - Anzeigename");
    $validieren->ist_ausgefuellt($value["benutzername"],$p_name . " - Benutzername");
    $validieren->ist_ausgefuellt($value["email"],$p_name . " - E-Mail");
    if (!array_key_exists("id",$value)) {
      $validieren->ist_ausgefuellt($value["passwort"],$p_name . " - Passwort");
    }

    if ($validieren->alles_ok()) {
      $benutzer = new db_benutzer($value);
      if (!array_key_exists("id", $value) && $benutzer->check_double_entry($value["anzeigename"])) {
        $validieren->fehler_eintragen("anzeigename {$value["anzeigename"]} darf nicht doppelt sein!");
      } else {
        if (empty($value["id"])) {
          $neu_ok = true;
        }
        $benutzer->save();
      }
    }
  }

}
?>
        <form class="container paper rounded p-4" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Benutzer:</h2>
          <div class="form-group row d-none d-md-flex">
            <div class="col-2"></div>
            <label class="form-label col-2">Anzeigename</label>
            <label class="form-label col-1">Benutzer-name</label>
            <label class="form-label col-2">E-Mail</label>
            <label class="form-label col-1">neues Passwort</label>
            <label class="form-label col-2">letzer Login</label>
            <label class="form-label col-1">Anzahl Logins</label>
            <label class="form-label col-1">ist Admin</label>
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
              echo '<input class="form-control col-7 col-md-2" type="text" value="' . htmlspecialchars($benutzer->letzter_login) . '">';

              echo '<label class="form-label col-4 d-block d-md-none">Anzahl Logins</label>';
              echo '<input class="form-control col-7 col-md-1" type="text" value="' . htmlspecialchars($benutzer->anzahl_logins) . '">';

              echo '<label class="form-label col-4 d-block d-md-none">ist Admin</label>';
              echo '<input type="hidden" name="benutzer_' . $benutzer->id . '_istadmin" id="benutzer_' . $benutzer->id . '_istadmin" value="0"  />';
              echo '<input class="form-control col-1" type="checkbox" name="benutzer_' . $benutzer->id . '_istadmin" id="benutzer_' . $benutzer->id . '_istadmin" value="1" ';
              if ($benutzer->istadmin == 1) {
                echo " checked ";
              }
              echo '"/>';

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
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_anzeigename" id="benutzer_neu_anzeigename" value="<?php
                if (!$neu_ok && array_key_exists("benutzer_neu_anzeigename",$_POST)) {
                  echo htmlspecialchars($_POST["benutzer_neu_anzeigename"]);
                }
              ?>"/>

              <label class="form-label col-4 d-block d-md-none">Benutzername</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_benutzername" id="benutzer_neu_benutzername" value="<?php
              if (!$neu_ok && array_key_exists("benutzer_neu_benutzername",$_POST)) {
                echo htmlspecialchars($_POST["benutzer_neu_benutzername"]);
              } ?>"/>

              <label class="form-label col-4 d-block d-md-none">E-Mail</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_email" id="benutzer_neu_email" value="<?php
              if (!$neu_ok && array_key_exists("benutzer_neu_email",$_POST)) {
                echo htmlspecialchars($_POST["benutzer_neu_email"]);
              } ?>"/>

              <label class="form-label col-4 d-block d-md-none">neues Passwort</label>
              <input class="form-control col-7 col-md-2" type="text" name="benutzer_neu_passwort" id="benutzer_neu_passwort" value="<?php
              if (!$neu_ok && array_key_exists("benutzer_neu_passwort",$_POST)) {
                echo htmlspecialchars($_POST["benutzer_neu_passwort"]);
              } ?>"/>

              <label class="form-label col-4 d-block d-md-none">ist Admin</label>
              <input type="hidden" name="benutzer_neu_istadmin" id="benutzer_neu_istadmin" value="0"  />
              <input class="form-control col-1" type="checkbox" name="benutzer_neu_istadmin" id="benutzer_neu_istadmin" value="1"<?php
              if (!$neu_ok) {
                if(array_key_exists("benutzer_neu_istadmin",$_POST) && $_POST["benutzer_neu_istadmin"] == 1) {
                  echo " checked ";
                }
              } ?>/>

            </div>
            <?php
            if (!$validieren->alles_ok()) {
              echo $validieren->fehler_html();
            }
           ?>
          <div>
            <button class="btn-send btn-primary" type="submit" >speichern</button>
          </div>
        </form>
