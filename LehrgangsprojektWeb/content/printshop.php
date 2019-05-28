<?php
require_once "lib/setup.php";
?>

<div class="container maxWidth">
  <form class="masterForm wrapper" id="printshop_form" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
    <input type="text" name="session_id" id="session_id" value="<?php echo session_id(); ?>" hidden>

    <!-- Produkte: zB: Budget Softcover, Standard, Premium -->
    <div class="form-group row">
      <label class="col-12 col-lg-4 col-form-label" for="produkt_id">Produkt</label>
      <select class="col-12 col-lg-8 form-control" name="produkt_id" id="produkt_id">
        <option value="">bitte eine Produktoption auswählen</option>
        <?php
        $produkte = new db_produkte();
        foreach ($produkte->get() as $produkt) {
          echo '<option value="' . $produkt->id . '" ';
          if (!empty($posted) && $posted["produkt_id"] == $produkt->id) {
            echo " selected ";
          }
          echo '>' . htmlspecialchars($produkt->titel) . '</option>';
        }
        ?>
      </select>

      <div class="w-100"></div>
      <span class="col-12 col-lg-4"></span>
      <span class="col-12 col-lg-8 error_message" id="produkt_id_error"></span>
    </div>

    <!-- Ein‐/Beidseitiger Druck -->
    <div class="form-group row">
      <div class="col-12 col-lg-4 col-form-label">Seitenoption</div>
      <label class="col-3 col-lg-2 radio_format col-form-label" for="ein_zwei_seitig1">
        <input id="ein_zwei_seitig1" type="radio" name="ein_zwei_seitig" value="1" <?php if (!empty($posted) && $posted["ein_zwei_seitig"] == 1) {
          echo " selected ";
        } ?> /> einseitig
      </label>
      <label class="col-3 col-lg-2 radio_format col-form-label" for="ein_zwei_seitig2">
        <input id="ein_zwei_seitig2" type="radio" name="ein_zwei_seitig" value="2" <?php if (!empty($posted) && $posted["ein_zwei_seitig"] == 2) {
          echo " selected ";
        } ?>/> beiseitig
      </label>

      <!-- <span class="col-lg-4"></span> -->
      <div class="w-100"></div>
      <span class="col-12 col-lg-4"></span>
      <span class="col-12 col-lg-8 error_message" id="ein_zwei_seitig_error"></span>
    </div>

    <!-- Papier‐Grammatur (Gewicht: 100 ‐ 160g/m²) -->
    <div class="form-group row">
      <div class="col-12 col-lg-4 col-form-label">Papier‐Grammatur (g/m²)</div>
      <?php
      $gramaturen = new db_gramaturen();
      foreach ($gramaturen->get() as $gramatur) {
          echo '<label class="col-2 col-lg-1 radio_format col-form-label" for="pg' . $gramatur->id . '">';
          echo '<input id="pg' . $gramatur->id . '" type="radio" name="grammatur_id" value="' . $gramatur->id . '" maxseiten="' . $gramatur->maxseiten . '"';
          if (!empty($posted) && $posted["grammatur_id"] == $gramatur->id) {
            echo " selected ";
          }
          echo '/> ' . $gramatur->gramm_m2 . '</label>';
        }
       ?>
       <div class="w-100"></div>
       <span class="col-12 col-lg-4"></span>
       <span class="col-12 col-lg-8 error_message" id="grammatur_id_error"></span>
    </div>

    <!-- Randloser Druck -->
    <div class="form-group row flex-lg-row flex-row-reverse">
      <label class="col-11 col-lg-4 form-check-label" for="randlos">Randloser Druck</label>
      <!-- <div class="radio_format"> -->
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="randlos" id="randlos" autocomplete="off">
        </div>
      <!-- </div> -->
    </div>

    <!-- Seitenanzahl -->
    <div class="form-group row">
      <label class="col-12 col-lg-4 col-form-label" for="seitenzahl" id="seitenzahl_label">Seitenanzahl (min. 10 Seiten)</label>
      <input class="form-control col-12 col-sm-5 col-lg-2 " type="number" name="seitenzahl" id="seitenzahl" min="10">

      <!-- <span class="col-lg-6"></span> -->

      <div class="w-100"></div>
      <span class="col-12 col-lg-4"></span>
      <span class="col-12 col-lg-8 error_message" id="seitenzahl_error"></span>
    </div>

    <!-- Anzahl Einheiten -->
    <div class="form-group row">
      <label class="col-12 col-lg-4  col-form-label" for="einheiten">Anzahl Einheiten (Druckwerke)</label>
      <input class="form-control col-12 col-sm-5 col-lg-2" type="number" name="einheiten" id="einheiten" min="1">

      <div class="w-100"></div>
      <span class="col-12 col-lg-4"></span>
      <span class="col-12 col-lg-8 error_message" id="einheiten_error"></span>
    </div>

    <!-- Zustelltyp -->
    <div class="form-group row">
      <div class="col-12 col-lg-4  col-form-label">Zustelltyp</div>
      <?php
      $zustelloptionen = new db_zustelloptionen();
      foreach ($zustelloptionen->get() as $zustelloption) {
          echo "<span class='col-12 col-lg-2 '>";
          echo '<label class="radio_format col-form-label" for="pg' . $zustelloption->id . '">';
          echo '<input id="pg' . $zustelloption->id . '" type="radio" name="zustelloption_id" value="' . $zustelloption->id . '" ';
          echo '/> ' . $zustelloption->titel . '</label>';
          echo"</span>";
        }
       ?>

       <div class="w-100"></div>
       <span class="col-12 col-lg-4"></span>
       <span class="col-12 col-lg-8 error_message" id="zustelloption_id_error"></span>
    </div>

    <!-- Produktionszeit -->
    <div class="form-group row">
      <label class="col-12 col-lg-4 col-form-label" for="lieferdatum">gewünschter Liefertermin</label>
      <input type="date" min="<?php
            $date = new DateTime(date("Y-m-d"));
            $date->add(new DateInterval('P10D'));
            echo $date->format('Y-m-d');
             ?>" max="<?php
                   $date = new DateTime(date("Y-m-d"));
                   $date->add(new DateInterval('P10D'));
                   $date->add(new DateInterval('P6M'));
                   echo $date->format('Y-m-d');
                    ?>"  class="form-control col-12 col-sm-5 col-lg-3" id="lieferdatum", name="lieferdatum">

      <div class="w-100"></div>
      <span class="col-12 col-lg-4"></span>
      <span class="col-12 col-lg-8 error_message" id="lieferdatum_error"></span>
    </div>

    <div class="preisanzeige" id="preisanzeige">
      <input type="text" name="price_per_page_form" id="price_per_page_form" value="" hidden>
      <input type="text" name="price_add_randlos_add_form" id="price_add_randlos_add_form" value="" hidden>
      <input type="text" name="price_add_cover_add_form" id="price_add_cover_add_form" value="" hidden>
      <input type="text" name="price_delivery_add_form" id="price_delivery_add_form" value="" hidden>
      <input type="text" name="produktionszeit_form" id="produktionszeit_form" value="" hidden>

      <p id="preisanzeige_fehler"></p>
      <p class='h3'>Angebot</p>
      <div class='form-group row'>
        <span class='col-12 col-sm-5 col-lg-4 col-form-label' id='price_per_page_display'>Preis für  Seite:</span>
        <span class='col-sm-3 col-lg-2'></span>
        <span class='col-sm-1 col-lg-1'></span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_per_page"></span>
      </div>
      <div class='form-group row' id="price_add_randlos_group">
        <span class='col-12 col-sm-5 col-lg-4 col-form-label'>+ Aufschlag für randlosen Druck:</span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_add_randlos_add"></span>
        <span class='col-12 col-sm-1 col-lg-1 col-form-label'><i class="arrow direction"></i></span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_add_randlos"></span>
      </div>
      <div class='form-group row'>
        <span class='col-12 col-sm-5 col-lg-4 col-form-label'>+ Basispreis für Cover:</span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_add_cover_add"></span>
        <span class='col-12 col-sm-1 col-lg-1 col-form-label'><i class="arrow direction"></i></span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_add_cover"></span>
      </div>
      <div class='form-group row'>
        <span class='col-12 col-sm-5 col-lg-4 col-form-label' id="price_result_label"></span>
        <span class='col-sm-3 col-lg-2'></span>
        <span class='col-sm-1 col-lg-1'></span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_result"></span>
      </div>
      <div class='form-group row' id="price_delivery_group">
        <span class='col-12 col-sm-5 col-lg-4 col-form-label' id="price_delivery_label"></span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_delivery_add"></span>
        <span class='col-12 col-sm-1 col-lg-1 col-form-label'><i class="arrow direction"></i></span>
        <span class='col-12 col-sm-3 col-lg-2 form-control text-right' id="price_delivery"></span>
      </div>
      <div class='form-group row'>
        <span class='col-12 col-sm-5 col-lg-4 col-form-label'>voraussichtliche Produktionszeit</span>
        <span class='col-12 col-sm-7 col-lg-2 form-control text-right' id="produktionszeit"></span>
      </div>

      <!-- alles akzeptiert -->
      <div class='form-group row flex-lg-row flex-row-reverse'>
        <label class='col-11 col-lg-4 form-check-label' for='akzeptiert'>Ich akzeptiere das hier erstellte Angebot.</label>
        <div class='radio_format'>
          <div class='form-check'>
            <input class='form-check-input' type='checkbox' name='akzeptiert' id='akzeptiert' autocomplete='off' />
          </div>
        </div>
      </div>

      <div class='abschluss' id='abschluss'>

        <div class="form-group row">
          <label class="col-12 col-lg-4  col-form-label" for="nachname">Nachname:</label>
          <input class="form-control col-12 col-lg-8" type="text" name="nachname" id="nachname" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="nachname_error"></span>
        </div>

        <div class="form-group row">
          <label class="col-12 col-lg-4  col-form-label" for="vorname">Vorname:</label>
          <input class="form-control col-12 col-lg-8" type="text" name="vorname" id="vorname" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="vorname_error"></span>
        </div>

        <div class="form-group row">
          <label class="col-12 col-lg-4  col-form-label" for="strasse">Straße:</label>
          <input class="form-control col-12 col-lg-8" type="text" name="strasse" id="strasse" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="strasse_error"></span>
        </div>

        <div class="form-group row">
          <label class="col-12 col-lg-4 col-form-label" for="plz">PLZ / Ort:</label>
          <input class="form-control col-2 col-lg-1" type="text" name="plz" id="plz" />
          <input class="form-control col-10 col-lg-7" type="text" name="ort" id="ort" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="plzort_error"></span>
        </div>

        <div class="form-group row">
          <label class="col-12 col-lg-4  col-form-label" for="email">E-Mail:</label>
          <input class="form-control col-12 col-lg-8" type="text" name="email" id="email" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="email_error"></span>
        </div>

        <!-- Farbe -->
        <div class="form-group row" id="deckblattfarbauswahl">
          <label class="col-12 col-lg-4  col-form-label" for="farbe">Farbe:</label>
          <input class="form-control col-12 col-lg-8" type="color" name="farbe" id="farbe" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="farbe_error"></span>
        </div>

        <!-- Text -->
        <div class="form-group row" id="deckblatttexteingabe">
          <label class="col-12 col-lg-4  col-form-label" for="deckblatt_text">Text für Deckblatt:</label>
          <input class="form-control col-12 col-lg-8" type="textarea" name="deckblatt_text" id="deckblatt_text" />
          <span class="col-12 col-lg-4"></span>
          <span class="col-12 col-lg-8 error_message" id="deckblatt_text_error"></span>
        </div>

        <!-- Deckblatt Upload -->
        <div class="form-group row">
          <label class="col-12 col-lg-4 col-form-label" for="deckblatt_datei">Deckblatt-Datei (PDF):</label>
          <input class="col-12 col-lg-4 form-control-file" type="file" accept=".pdf" name="deckblatt_datei[]" id="deckblatt_datei"/>
          <div class="progressBar col-12 col-lg-4" id="progressBar_deckblatt_datei">
            <div class="bar" id="bar_deckblatt_datei"></div>
            <div class="percent" id="percent_deckblatt_datei">0%</div>
          </div>
          <span class="col-12 col-lg-4 error_message" id="deckblatt_datei_error" hidden></span>
        </div>

        <!-- Content Upload -->
        <div class="form-group row">
          <label class="col-12 col-lg-4 col-form-label" for="inhalt_datei">Inhalt-Datei (PDF):</label>
          <input class="col-12 col-lg-4 form-control-file fileinput-button" type="file" accept=".pdf" name="inhalt_datei[]" id="inhalt_datei"/>
          <div class="progressBar col-12 col-lg-4" id="progressBar_inhalt_datei">
            <div class="bar" id="bar_inhalt_datei"></div>
            <div class="percent" id="percent_inhalt_datei">0%</div>
          </div>
          <span class="col-12 col-lg-4 error_message" id="inhalt_datei_error" hidden></span>
        </div>
      </div>
    </div>

    <div>
      <button id="btn-send" type="button">abschicken</button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="js/printshop.js"></script>
<script src="js/upload.js"></script>
