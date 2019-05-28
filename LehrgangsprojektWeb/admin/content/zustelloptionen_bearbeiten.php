<?php

$validieren = new db_validieren();

if (!empty($_POST)) {
  // echo "<pre>";print_r($_POST);echo "</pre>";echo "<br>";die();

  $input_data = array();
  foreach ($_POST as $key => $preis) {
    $key_parts = explode("_",$key);
    if ($key_parts[0] == "zustelloption") {

      $id = $key_parts[1];
      $fieldname = $key_parts[2];

      if ($id == "neu") {
        $id = 0;
      } else {
        $input_data[$id]["id"] = $id;
      }
      $input_data[$id][$fieldname] = $preis;
    }
  }
  if (implode("",$input_data[0]) == "") {
    unset($input_data[0]);
  }
  // echo "<pre>";print_r($input_data);echo "</pre>";echo "<br>";die();

  foreach ($input_data as $preis) {
    // Validierung
    $p_name = "Zustelloptionen " . (array_key_exists("id",$preis) ? $preis["id"] : "NEU");
    $validieren->ist_ausgefuellt($preis["titel"],$p_name . " - Titel");
    if ($preis["preis"] != "0") {
      $validieren->ist_ausgefuellt($preis["preis"],$p_name . " - Preis");
    }

    if ($validieren->alles_ok()) {
      $zustelloption = new db_zustelloption($preis);
      if (!array_key_exists("id", $preis) && $zustelloption->check_double_entry($preis["titel"])) {
        $validieren->fehler_eintragen("titel {$preis["titel"]} darf nicht doppelt sein!");
      } else {
        $zustelloption->save();
      }
    }
  }

}
?>
        <form class="container" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Zustelloptionen:</h2>
          <?php
            echo '<div class="form-group row d-none d-md-flex">';
            echo '<div class=" col-md-4 col-lg-3"></div>';
            echo '<label class="form-label col-3">Titel</label>';
            echo '<label class="form-label col-1">Preis</label>';
            echo '</div>';

            $zustelloptionen = new db_zustelloptionen();
            foreach ($zustelloptionen->get() as $zustelloption)
            {
              echo '<div class="form-group row">';
              echo '<label class="form-label col-12 col-md-4 col-lg-3 h5" for="zustelloption_' . $zustelloption->id . '_titel">Zustelloptionen ' . $zustelloption->id . ':</label>';

              echo '<label class="form-label col-6 d-block d-md-none">Titel</label>';
              echo '<input class="form-control col-5 col-md-3" type="text" name="zustelloption_' . $zustelloption->id . '_titel" id="zustelloption_' . $zustelloption->id . '_titel" value="' . htmlspecialchars($zustelloption->titel) . '" readonly>';

              echo '<label class="form-label col-6 d-block d-md-none">Preis</label>';
              echo '<input class="form-control col-5 col-md-1 text-right" type="text" name="zustelloption_' . $zustelloption->id . '_preis" id="zustelloption_' . $zustelloption->id . '_preis" value="' . str_replace('.',',',htmlspecialchars($zustelloption->preis)) . '">';
              echo '</div>';
            }
            echo '<div class="form-group row">';
            echo '<label class="form-label col-12 col-md-4 col-lg-3 h5" for="zustelloption_neu_titel">Zustelloptionen NEU:</label>';

            echo '<label class="form-label col-6 d-block d-md-none">Titel</label>';
            echo '<input class="form-control col-5 col-md-3" type="text" name="zustelloption_neu_titel" id="zustelloption_neu_titel" value="';
            if (array_key_exists("zustelloption_neu_titel",$_POST)) {
              echo htmlspecialchars($_POST["zustelloption_neu_titel"]);
            }
            echo '"/>';

            echo '<label class="form-label col-6 d-block d-md-none">Preis</label>';
            echo '<input class="form-control col-5 col-md-1" type="text" name="zustelloption_neu_preis" id="zustelloption_neu_preis" value="';
            if (array_key_exists("zustelloption_neu_preis",$_POST)) {
              echo htmlspecialchars($_POST["zustelloption_neu_preis"]);
            }
            echo '"/>';

            echo '</div>';

            if (!$validieren->alles_ok()) {
              echo $validieren->fehler_html();
            }
           ?>
          <div>
            <button class="btn-send btn-primary" type="submit" >speichern</button>
          </div>
        </form>
