<?php

$validieren = new db_validieren();

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
  if (implode("",$input_data[0]) == "") {
    unset($input_data[0]);
  }
  // echo "<pre>";print_r($input_data);echo "</pre>";echo "<br>";die();

  foreach ($input_data as $value) {
    // Validierung
    $p_name = "Parameter " . (array_key_exists("id",$value) ? $value["id"] : "NEU");
    $validieren->ist_ausgefuellt($value["propgroup"],$p_name . " - propgroup");
    $validieren->ist_ausgefuellt($value["property"],$p_name . " - property");
    if ($value["value"] != "0") {
      $validieren->ist_ausgefuellt($value["value"],$p_name . " - value");
    }

    if ($validieren->alles_ok()) {
      $parameter = new db_parameter($value);
      if (!array_key_exists("id", $value) && $parameter->check_double_entry($value["property"])) {
        $validieren->fehler_eintragen("property {$value["property"]} darf nicht doppelt sein!");
      } else {
        $parameter->save();
      }
    }
  }

}
?>
        <form class="container-fluid" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Parametere:</h2>
          <?php
            echo '<div class="form-group row">';
            echo '<div class="col-2"></div>';
            echo '<label class="form-label col-2">Property Group</label>';
            echo '<label class="form-label col-2">Property</label>';
            echo '<label class="form-label col-1">Value</label>';
            echo '</div>';

            $parametere = new db_parametere();
            foreach ($parametere->get() as $parameter)
            {
              echo '<div class="form-group row">';
              echo '<label class="form-label col-2" for="parameter_' . $parameter->id . '_property">Parameter ' . $parameter->id . ': </label>';
              echo '<input class="form-control col-2" type="text" name="parameter_' . $parameter->id . '_propgroup" id="parameter_' . $parameter->id . '_propgroup" value="' . htmlspecialchars($parameter->propgroup) . '" readonly>';
              echo '<input class="form-control col-2" type="text" name="parameter_' . $parameter->id . '_property" id="parameter_' . $parameter->id . '_property" value="' . htmlspecialchars($parameter->property) . '" readonly>';
              echo '<input class="form-control col-1 text-right" type="text" name="parameter_' . $parameter->id . '_value" id="parameter_' . $parameter->id . '_value" value="' . str_replace('.',',',htmlspecialchars($parameter->value)) . '">';
              echo '</div>';
            }
            echo '<div class="form-group row">';
            echo '<label class="form-label col-2" for="parameter_neu_property">Parameter NEU: </label>';

            echo '<input class="form-control col-2" type="text" name="parameter_neu_propgroup" id="parameter_neu_propgroup" value="';
            if (array_key_exists("parameter_neu_propgroup",$_POST)) {
              echo htmlspecialchars($_POST["parameter_neu_propgroup"]);
            }
            echo '"/>';

            echo '<input class="form-control col-2" type="text" name="parameter_neu_property" id="parameter_neu_property" value="';
            if (array_key_exists("parameter_neu_property",$_POST)) {
              echo htmlspecialchars($_POST["parameter_neu_property"]);
            }
            echo '"/>';

            echo '<input class="form-control col-1" type="text" name="parameter_neu_value" id="parameter_neu_value" value="';
            if (array_key_exists("parameter_neu_value",$_POST)) {
              echo htmlspecialchars($_POST["parameter_neu_value"]);
            }
            echo '"/>';

            echo '</div>';

            if (!$validieren->alles_ok()) {
              echo $validieren->fehler_html();
            }
           ?>
          <div>
            <button class="btn-send" type="submit" >speichern</button>
          </div>
        </form>
