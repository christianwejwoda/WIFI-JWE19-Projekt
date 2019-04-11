<?php
require_once "setup.php";
// is_logged_in();

$cur_product=0;
$cur_frontpageoption=0;
$cur_pageoption=0;
$cur_paperweight=0;
$cur_borderless=false;
$cur_units=0;

if (!empty($_POST)) {
  $cur_product = $_POST["product"];
  $cur_frontpageoption = $_POST["frontpageoption"];
  $cur_favcolor = $_POST["favcolor"];
  $cur_frontpagetext = $_POST["frontpagetext"];
  $cur_pageoption = $_POST["pageoption"];
  $cur_paperweight = $_POST["paper-weight"];
  $cur_borderless = $_POST["borderless"];
  $cur_pagecount = $_POST["pagecount"];
  $cur_units = $_POST["units"];

}

?>

<div class="container-fluid">

    <div class="row justify-content-md-center">
      <div class="">
        <!-- savedata_printshop_form -->
        <form class="masterForm wrapper" id="printshop_form" action="anfrage_form" method="post">

          <!-- Produkte: zB: Budget Softcover, Standard, Premium -->
          <div class="form-group row">
            <label class="col-3" for="product">Produkt</label>
            <select class="form-control col-9" name="product" id="product">
              <option value="">bitte eine Produktoption auswählen</option>
              <?php
              $produkte = new db_produkte();
              foreach ($produkte->get() as $produkt) {
                echo '<option value="' . $produkt->id . '" ';
                if ($cur_product == $produkt->id) {
                  echo " selected ";
                }
                echo '>' . htmlspecialchars($produkt->titel) . '</option>';
              }
               ?>
            </select>

            <span class="col-3"></span>
            <span class="col-9 error_message" id="product_error"></span>
          </div>

          <!-- Deckseitenoption -->
          <!-- 1 = manuelle Eingabe -->
          <!-- 2 = PDF Upload -->
          <div class="form-group row">
            <div class="col-3">Deckblatt Option</div>
            <label class="col-2 radio_format" for="frontpageoption2">
              <input id="frontpageoption2" type="radio" name="frontpageoption" value="2" <?php if ($cur_frontpageoption == 2) {
                echo " selected ";
              } ?>/> PDF-Upload</label>
            <label class="col-7 radio_format" for="frontpageoption1">
              <input id="frontpageoption1" type="radio" name="frontpageoption" value="1" <?php if ($cur_frontpageoption == 1) {
                echo " selected ";
              } ?> /> manuelle Eingabe (Text + Hintergrundfarbe)</label>

            <span class="col-3"></span>
            <span class="col-9 error_message" id="frontpageoption_error"></span>
          </div>

          <!-- Ein‐/Beidseitiger Druck -->
          <div class="form-group row">
            <div class="col-3">Seitenoption</div>
            <label class="col-2 radio_format" for="pageoption1">
              <input id="pageoption1" type="radio" name="pageoption" value="1" <?php if ($cur_pageoption == 1) {
                echo " selected ";
              } ?> /> einseitig</label>
            <label class="col-2 radio_format" for="pageoption2">
              <input id="pageoption2" type="radio" name="pageoption" value="2" <?php if ($cur_pageoption == 2) {
                echo " selected ";
              } ?>/> beiseitig</label>
            <span class="col-5"></span>

            <span class="col-3"></span>
            <span class="col-9 error_message" id="pageoption_error"></span>
          </div>

          <!-- Papier‐Grammatur (Gewicht: 100 ‐ 160g/m²) -->
          <div class="form-group row">
            <div class="col-3">Papier‐Grammatur (g/m²)</div>
            <div class="col-9">
            <?php
            $gramaturen = new db_gramaturen();
            foreach ($gramaturen->get() as $gramatur) {
                echo '<label class="col-2 radio_format" for="pg' . $gramatur->id . '">';
                echo '<input id="pg' . $gramatur->id . '" type="radio" name="paper-weight" value="' . $gramatur->id . '"';
                if ($cur_paperweight == $gramatur->id) {
                  echo " selected ";
                }
                echo '/> ' . $gramatur->gramm_m2 . '</label>';
              }
             ?>
             </div>

             <span class="col-3"></span>
             <span class="col-9 error_message" id="paper-weight_error"></span>
          </div>

          <!-- Randloser Druck -->
          <div class="form-group row">
            <label class="form-label col-3" for="borderless">Randloser Druck</label>
            <input type="checkbox" name="borderless" id="borderless" autocomplete="off" <?php if ($cur_borderless) {
              echo " checked ";
            } ?>>
          </div>

          <!-- Seitenanzahl -->
          <div class="form-group row">
            <label class="col-3" for="pagecount">Seitenanzahl (min. 10 Seiten)</label>
            <input class="form-control col-1" type="number" name="pagecount" id="pagecount" min="10" value="<?php if (!empty($cur_pagecount)) {
              echo $cur_pagecount;
            } else { echo "10";} ?>">

            <span class="col-8"></span>

            <span class="col-3"></span>
            <span class="col-9 error_message" id="pagecount_error"></span>
          </div>

          <!-- Anzahl Einheiten -->
          <div class="form-group row">
            <label class="col-3" for="units">Anzahl Einheiten (Druckwerke)</label>
            <input class="form-control col-1" type="number" name="units" id="units" min="1" value="<?php if (!empty($cur_units)) {
              echo $cur_units;
            } else { echo "1";} ?>">

            <span class="col-8"></span>

            <span class="col-3"></span>
            <span class="col-9 error_message" id="units_error"></span>
          </div>

          <!-- Produktionszeit -->
          <div class="form-group row">
            <label class="form-label col-3" for="deliverydate">gewünschter Liefertermin</label>
            <input type="text" class="form-control col-2" id="deliverydate", name="deliverydate">
            <span class="col-7"></span>

            <span class="col-3"></span>
            <span class="col-9 error_message" id="deliverydate_error"></span>
          </div>

          <div class="preisanzeige" id="preisanzeige">

          </div>

          <div>
            <button id="btn-send" type="button" >abschicken</button>
            <!-- name="submit" -->
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
  <script src="js/vendor/jquery.ui.widget.js"></script>
  <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
  <script src="js/jquery.iframe-transport.js"></script>
  <!-- The basic File Upload plugin -->
  <script src="js/jquery.fileupload.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

  <script src="js/printshop.js"></script>

  <!-- Produkte: zB: Budget Softcover, Standard, Premium -->
  <!-- Auswahl der Farbe -->
  <!-- Vorderseite inkl. Texteingabe -->
  <!-- Ein‐/Beidseitiger Druck -->
  <!-- Seitenanzahl -->
  <!-- Papier‐Grammatur (Gewicht: 100 ‐ 160g/m²) -->
  <!-- Randloser Druck -->
  <!-- Upload (Coverseite‐PDF, Inhaltsseiten‐PDF) -->
  <!-- Produktionszeit -->
  <!-- Auftragspauschale & Zusatzoptionen -->
  <!-- Automatische Berechnung des Preises: Stückpreis + Auftragspauschale und -->
  <!-- Zusatzoptionen (Express, Sonderformate etc.), = Gesamtpreis zzgl. Versand -->
  <!-- Informationen zu Versandkosten und Auftragspauschale -->
  <!-- Erstellung und automatisierter Versand eines Angebots auf Basis vordefinierter Werte an den Admin -->
