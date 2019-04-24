<?php

$validieren = new db_validieren();

if (!empty($_POST)) {
  // echo "<pre>";print_r($_POST);echo "</pre>";echo "<br>";die();

  $input_data = array();
  foreach ($_POST as $key => $value) {
    $key_parts = explode("_",$key);
    if ($key_parts[0] == "produkt") {

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
    $p_name = "Produkt " . (array_key_exists("id",$value) ? $value["id"] : "NEU");
    $validieren->ist_ausgefuellt($value["titel"],$p_name . " - Titel");
    $validieren->ist_ausgefuellt($value["preis"],$p_name . " - Preis");

    if ($validieren->alles_ok()) {
      $produkt = new db_produkt($value);
      if (!array_key_exists("id", $value) && $produkt->check_double_entry($value["titel"])) {
        $validieren->fehler_eintragen("Produkt-Titel {$value["titel"]} darf nicht doppelt sein!");
      } else {
        $produkt->save();
      }
    }
  }

}
?>
        <form class="container-fluid" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
          <h2>Produkte:</h2>
          <?php
            echo '<div class="form-group row">';
            echo '<div class="col-2"></div>';
            echo '<label class="form-label col-3">Titel</label>';
            echo '<label class="form-label col-1">Preis</label>';
            echo '<label class="form-label col-1">Zeit für Setup (Stunden)</label>';
            echo '<label class="form-label col-1">Zeit für Verpackung (Stunden)</label>';
            echo '<label class="form-label col-1">Deckblatt Farbauswahl möglich</label>';
            echo '<label class="form-label col-1">Deckblatt Texteingabe möglich</label>';
            echo '</div>';

            $produkte = new db_produkte();
            foreach ($produkte->get() as $produkt)
            {
              echo '<div class="form-group row">';
              echo '<label class="form-label col-2" for="produkt_' . $produkt->id . '_titel">Produkt ' . $produkt->id . ': </label>';
              echo '<input class="form-control col-3" type="text" name="produkt_' . $produkt->id . '_titel" id="produkt_' . $produkt->id . '_titel" value="' . htmlspecialchars($produkt->titel) . '">';
              echo '<input class="form-control col-1 text-right" type="text" name="produkt_' . $produkt->id . '_preis" id="produkt_' . $produkt->id . '_preis" value="' . str_replace('.',',',htmlspecialchars($produkt->preis)) . '">';
              echo '<input class="form-control col-1 text-right" type="text" name="produkt_' . $produkt->id . '_zeitsetup" id="produkt_' . $produkt->id . '_zeitsetup" value="' . str_replace('.',',',htmlspecialchars($produkt->zeitsetup)) . '">';
              echo '<input class="form-control col-1 text-right" type="text" name="produkt_' . $produkt->id . '_zeitverpackung" id="produkt_' . $produkt->id . '_zeitverpackung" value="' . str_replace('.',',',htmlspecialchars($produkt->zeitverpackung)) . '">';

              echo '<input class="form-control col-1" type="hidden" name="produkt_' . $produkt->id . '_deckblattfarbauswahl" id="produkt_' . $produkt->id . '_deckblattfarbauswahl" value="0"  />';
              echo '<input class="form-control col-1" type="checkbox" name="produkt_' . $produkt->id . '_deckblattfarbauswahl" id="produkt_' . $produkt->id . '_deckblattfarbauswahl" value="1" ';
              if ($produkt->deckblattfarbauswahl == 1) {
                echo " checked ";
              }
              echo '"/>';

              echo '<input class="form-control col-1" type="hidden" name="produkt_' . $produkt->id . '_deckblatttexteingabe" id="produkt_' . $produkt->id . '_deckblatttexteingabe" value="0"  />';
              echo '<input class="form-control col-1" type="checkbox" name="produkt_' . $produkt->id . '_deckblatttexteingabe" id="produkt_' . $produkt->id . '_deckblatttexteingabe" value="1" ';
              if ($produkt->deckblatttexteingabe == 1) {
                echo " checked ";
              }
              echo '"/>';

              echo '</div>';
            }
            echo '<div class="form-group row">';
            echo '<label class="form-label col-2" for="produkt_neu_titel">Produkt NEU: </label>';
            echo '<input class="form-control col-3" type="text" name="produkt_neu_titel" id="produkt_neu_titel" value="';
            if (array_key_exists("produkt_neu_titel",$_POST)) {
              echo htmlspecialchars($_POST["produkt_neu_titel"]);
            }
            echo '"/>';

            echo '<input class="form-control col-1" type="text" name="produkt_neu_preis" id="produkt_neu_preis" value="';
            if (array_key_exists("produkt_neu_preis",$_POST)) {
              echo htmlspecialchars($_POST["produkt_neu_preis"]);
            }
            echo '"/>';

            echo '<input class="form-control col-1" type="text" name="produkt_neu_zeitsetup" id="produkt_neu_zeitsetup" value="';
            if (array_key_exists("produkt_neu_zeitsetup",$_POST)) {
              echo htmlspecialchars($_POST["produkt_neu_zeitsetup"]);
            }
            echo '"/>';

            echo '<input class="form-control col-1" type="text" name="produkt_neu_zeitverpackung" id="produkt_neu_zeitverpackung" value="';
            if (array_key_exists("produkt_neu_zeitverpackung",$_POST)) {
              echo htmlspecialchars($_POST["produkt_neu_zeitverpackung"]);
            }
            echo '"/>';

            echo '<input class="form-control col-1" type="checkbox" name="produkt_neu_deckblattfarbauswahl" id="produkt_neu_deckblattfarbauswahl" value="1" ';
            if (array_key_exists("produkt_neu_deckblattfarbauswahl",$_POST)) {
              echo " checked ";
            }
            echo '"/>';

            echo '<input class="form-control col-1" type="checkbox" name="produkt_neu_deckblatttexteingabe" id="produkt_neu_deckblatttexteingabe" value="1" ';
            if (array_key_exists("produkt_neu_deckblatttexteingabe",$_POST)) {
              echo " checked ";
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
