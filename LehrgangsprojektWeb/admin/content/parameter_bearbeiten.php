<?php

$validieren = new db_validieren();
$neu_ok = false;

if (!empty($_POST)) {
  // echo "<pre>";print_r($_POST);echo "</pre>";echo "<br>";die();

  $input_data = array();
  foreach ($_POST as $key => $value) {
    $key_parts = explode("_",$key);
    if ($key_parts[0] == "parameter") {

      $id = $key_parts[1];
      $fieldname = $key_parts[2];

      if ($id == "neu") {
        $id = 0;
      } else {
        $input_data[$id]["id"] = $id;
      }
      $input_data[$id][$fieldname] = $value;
    }
  }
  // echo "<pre>";print_r($input_data);echo "</pre>";echo "<br>";die();

  if (implode("",$input_data[0]) == "") {
    unset($input_data[0]);
  }
  // echo "<pre>";print_r($input_data);echo "</pre>";echo "<br>";die();

  foreach ($input_data as $value) {
    // Validierung
    $p_name = "Parameter " . (array_key_exists("id",$value) ? $value["id"] : "NEU");
    $validieren->ist_ausgefuellt($value["typ"],$p_name . " - Typ");
    $validieren->ist_ausgefuellt($value["wert"],$p_name . " - Wert");
    $validieren->ist_ausgefuellt($value["beschreibung"],$p_name . " - Beschreibung");

    if ($validieren->alles_ok()) {
      $parameter = new db_parameter($value);
      if (!array_key_exists("id", $value) && $parameter->check_double_entry($value["typ"])) {
        $validieren->fehler_eintragen("Typ {$value["typ"]} darf nicht doppelt sein!");
      } else {
        if (empty($value["id"])) {
          $neu_ok = true;
        }
        $parameter->save();
      }
    }
  }

}
?>
        <form class="container paper rounded p-4 mt-4" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Parameter:</h2>
          <?php
            echo '<div class="form-group row d-none d-md-flex">';
            echo '<div class=" col-md-4 col-lg-3"></div>';
            echo '<label class="form-label col-3">Typ</label>';
            echo '<label class="form-label col-1">Wert</label>';
            echo '</div>';

            $parameteren = new db_parameteren();
            foreach ($parameteren->get() as $parameter)
            {
              echo '<div class="form-group row">';

              echo '<label class="form-label col-12 col-md-4 col-lg-3 h5" for="parameter_' . $parameter->id . '_typ">Parameter ' . $parameter->id . ':</label>';

              echo '<label class="form-label col-6 d-block d-md-none">Typ</label>';
              echo '<input class="form-control col-5 col-md-3 col-lg-3" type="text" name="parameter_' . $parameter->id . '_typ" id="parameter_' . $parameter->id . '_typ" value="' . htmlspecialchars($parameter->typ) . '" readonly>';

              echo '<label class="form-label col-6 d-block d-md-none">Wert</label>';
              echo '<input class="form-control col-5 col-md-2 col-lg-2 text-right" type="text" name="parameter_' . $parameter->id . '_wert" id="parameter_' . $parameter->id . '_wert" value="' . str_replace('.',',',htmlspecialchars($parameter->wert)) . '">';

              echo '<label class="form-label col-6 d-block d-md-none">Beschreibung</label>';
              echo '<textarea class="form-control col-5 col-md-3 col-lg-4 text-left" type="text" name="parameter_' . $parameter->id . '_beschreibung" id="parameter_' . $parameter->id . '_beschreibung" >' . str_replace('.',',',htmlspecialchars($parameter->beschreibung)) . '</textarea>';

              echo '</div>';
            }
            echo '<div class="form-group row">';
            echo '<label class="form-label col-12 col-md-4 col-lg-3 h5" for="parameter_neu_typ">Parameter NEU:</label>';

            echo '<label class="form-label col-6 d-block d-md-none">Typ</label>';
            echo '<input class="form-control col-5 col-md-3 col-lg-3" type="text" name="parameter_neu_typ" id="parameter_neu_typ" value="';
            if (!$neu_ok && array_key_exists("parameter_neu_typ",$_POST)) {
              echo htmlspecialchars($_POST["parameter_neu_typ"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">Wert</label>';
            echo '<input class="form-control col-5 col-md-2 col-lg-2" type="text" name="parameter_neu_wert" id="parameter_neu_wert" value="';
            if (!$neu_ok && array_key_exists("parameter_neu_wert",$_POST)) {
              echo htmlspecialchars($_POST["parameter_neu_wert"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">Beschreibung</label>';
            echo '<textarea class="form-control col-5 col-md-3 col-lg-4 " type="text" name="parameter_neu_beschreibung" id="parameter_neu_beschreibung">';
            if (!$neu_ok && array_key_exists("parameter_neu_beschreibung",$_POST)) {
              echo htmlspecialchars($_POST["parameter_neu_beschreibung"]);
            }
            echo '</textarea>';

            echo '</div>';

            if (!$validieren->alles_ok()) {
              echo $validieren->fehler_html();
            }
           ?>
          <div>
            <button class="btn-send btn-primary" type="submit" >speichern</button>
          </div>
        </form>
