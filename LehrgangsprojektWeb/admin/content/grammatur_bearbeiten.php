<?php

$validieren = new db_validieren();

if (!empty($_POST)) {

  $input_data = array();
  foreach ($_POST as $key => $value) {
    $key_parts = explode("-",$key);
    if ($key_parts[0] == "grammatur") {

      $id = $key_parts[1];
      $fieldname = $key_parts[2];

      if ($id == "neu") {
        $id = 0;
      } else {
        $input_data[$id]["id"] = $id;
      }
      $input_data[$id][$fieldname] = str_replace(',','.',str_replace('.','',$value));
    }
  }
  if (implode("",$input_data[0]) == "") {
    unset($input_data[0]);
  }
  foreach ($input_data as $value) {
    // Validierung
    $p_name = "Grammtur " . (array_key_exists("id",$value) ? $value["id"] : "NEU");
    $validieren->ist_ausgefuellt($value["gramm_m2"],$p_name . " - Gramm m²");
    $validieren->ist_ausgefuellt($value["preis_blatt"],$p_name . " - Preis");
    $validieren->ist_ausgefuellt($value["preis_druckseite"],$p_name . " - Preis");
    $validieren->ist_ausgefuellt($value["maxseiten"],$p_name . " - max. Seiten");
    $validieren->ist_ausgefuellt($value["zeitproduktion"],$p_name . " - Produktionszeit");

    if ($validieren->alles_ok()) {
      $grammatur = new db_gramatur($value);
      if (!array_key_exists("id", $value) && $grammatur->check_double_entry($value["gramm_m2"])) {
        $validieren->fehler_eintragen("Grammatur {$value["gramm_m2"]} darf nicht doppelt sein!");
      } else {
        $grammatur->save();
      }
    }
  }

}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-1">
    </div>

    <div class="col-11">
      <div class="row">
        <form class="" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Grammaturen:</h2>
          <?php
            echo '<div class="form-group row d-none d-md-flex">';
            echo '<div class="col-3"> </div>';
            echo '<label class="form-label col-1">g/m²</label>';
            echo '<label class="form-label col-1">Preis pro Blatt &euro;</label>';
            echo '<label class="form-label col-1">Preis pro Druckseite &euro;</label>';
            echo '<label class="form-label col-1">max. Seiten</label>';
            echo '<label class="form-label col-1">Produktionszeit (Sekunden)</label>';
            echo '</div>';

            $gramaturen = new db_gramaturen();
            foreach ($gramaturen->get() as $gramatur)
            {
              echo '<div class="form-group row">';
              echo '<label class="form-label col-12 col-md-3 h5" for="gramm_m2' . $gramatur->id . '">Grammtur ' . $gramatur->id . ': </label>';

              echo '<label class="form-label col-6 d-block d-md-none">g/m²</label>';
              echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-' . $gramatur->id . '-gramm_m2" id="grammatur-' . $gramatur->id . '-gramm_m2" value="' . str_replace('.',',',htmlspecialchars($gramatur->gramm_m2)) . '" readonly>';

              echo '<label class="form-label col-6 d-block d-md-none">Preis pro Blatt &euro;</label>';
              echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-' . $gramatur->id . '-preis_blatt" id="grammatur-' . $gramatur->id . '-preis_blatt" value="' . str_replace('.',',',htmlspecialchars($gramatur->preis_blatt)) . '">';

              echo '<label class="form-label col-6 d-block d-md-none">Preis pro Druckseite &euro;</label>';
              echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-' . $gramatur->id . '-preis_druckseite" id="grammatur-' . $gramatur->id . '-preis_druckseite' . $gramatur->id . '" value="' . str_replace('.',',',htmlspecialchars($gramatur->preis_druckseite)) . '">';

              echo '<label class="form-label col-6 d-block d-md-none">max. Seiten</label>';
              echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-' . $gramatur->id . '-maxseiten" id="grammatur-' . $gramatur->id . '-maxseiten' . $gramatur->id . '" value="' . str_replace('.',',',htmlspecialchars($gramatur->maxseiten)) . '">';

              echo '<label class="form-label col-6 d-block d-md-none">Produktionszeit (Sekunden)</label>';
              echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-' . $gramatur->id . '-zeitproduktion" id="grammatur-' . $gramatur->id . '-zeitproduktion' . $gramatur->id . '" value="' . str_replace('.',',',htmlspecialchars($gramatur->zeitproduktion)) . '">';
              echo '</div>';
            }
            echo '<div class="form-group row">';
            echo '<label class="form-label col-12 col-md-3 h5" for="produktNeu">Grammtur NEU: </label>';

            echo '<label class="form-label col-6 d-block d-md-none">g/m²</label>';
            echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-neu-gramm_m2" id="grammatur-neu-gramm_m2" value="';
            if (array_key_exists("grammatur-neu-gramm_m2",$_POST)) {
              echo htmlspecialchars($_POST["grammatur-neu-gramm_m2"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">Preis pro Blatt &euro;</label>';
            echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-neu-preis_blatt" id="grammatur-neu-preis_blatt" value="';
            if (array_key_exists("grammatur-neu-preis_blatt",$_POST)) {
              echo htmlspecialchars($_POST["grammatur-neu-preis_blatt"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">Preis pro Druckseite &euro;</label>';
            echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-neu-preis_druckseite" id="grammatur-neu-preis_druckseite" value="';
            if (array_key_exists("grammatur-neu-preis_druckseite",$_POST)) {
              echo htmlspecialchars($_POST["grammatur-neu-preis_druckseite"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">max. Seiten</label>';
            echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-neu-maxseiten" id="grammatur-neu-maxseiten" value="';
            if (array_key_exists("grammatur-neu-maxseiten",$_POST)) {
              echo htmlspecialchars($_POST["grammatur-neu-maxseiten"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">Produktionszeit (Sekunden)</label>';
            echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="grammatur-neu-zeitproduktion" id="grammatur-neu-zeitproduktion" value="';
            if (array_key_exists("grammatur-neu-zeitproduktion",$_POST)) {
              echo htmlspecialchars($_POST["grammatur-neu-zeitproduktion"]);
            }
            echo '"/>';

            echo '</div>';

            if (!$validieren->alles_ok()) {
              echo $validieren->fehler_html();
            }
           ?>
          <div>
            <button class="btn-send btn-primary" type="submit" >abschicken</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
