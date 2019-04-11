
<div class="container-fluid">
    <div class="row justify-content-md-center">
      <div class="">
        <form class="masterForm wrapper" id="anfrage_form" action="savedata_anfrage_form.php" method="post">

          <div class="row">
            <div class="col-12">
              <p>Wir danken für Ihre Anfrage.
              <!-- </p><p> -->
                Die von Ihnen gewählten Werte lauten:</p>
            </div>
          </div>
<?php
session_start();
// Array
// (
//     [product] => 5
//     [favcolor] => #0000ff
//     [frontpagetext] => sdfasdf
//     [pageoption] => 2
//     [pagecount] => 11
//     [paper-weight] => 2
//     [files] => Array
//         (
//             [0] =>
//         )
//
// )
      $printshop_data = $_POST;
      $printshop_data_produkt = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM produkte WHERE id = {$printshop_data["product"]};"));
      $printshop_data_paperweight = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM gramaturen WHERE id = {$printshop_data["paper-weight"]};"));

      // echo "<pre>";
      // print_r($_SESSION["printshop_form_data"]);
      // // print_r($_POST["files"]);
      // echo "</pre>";

      echo "<ul> ";

      echo "<li class='row'>";
      echo "<span class='col-3'>Produkt:</span>";
      echo "<span class='col-9'>{$printshop_data_produkt["titel"]}</span>";
      echo "</li>";

      echo "<li class='row'>";
      echo "<span class='col-3'>ein/zwei-seitig:</span>";
      echo "<span class='col-9'>{$printshop_data["pageoption"]}</span>";
      echo "</li>";

      echo "<li class='row'>";
      echo "<span class='col-3'>Anzahl Seiten:</span>";
      echo "<span class='col-9'>{$printshop_data["pagecount"]}</span>";
      echo "</li>";

      echo "<li class='row'>";
      echo "<span class='col-3'>Grammatur (g/m²):</span>";
      echo "<span class='col-9'>{$printshop_data_paperweight["gramm_m2"]}</span>";
      echo "</li>";

      echo "<li class='row'>";
      echo "<span class='col-3'>randloser Druck:</span>";
      echo "<span class='col-9'>";
      if (!empty($printshop_data["randloserdruck"])) {
        echo "ja";
      } else {
        echo "nein";
      }
      echo "</span>";
      echo "</li>";

      echo "<li class='row'>";
      echo "<span class='col-3'>Lieferdatum:</span>";
      echo "<span class='col-9'>{$printshop_data["deliverydate"]}</span>";
      echo "</li>";

      echo "</ul>";

 ?>

          <div class="form-group row">
            <label class="col-3" for="name">Name</label>
            <input class="col-9" type="text" name="name" id="name" value="">
            <span class="col-3"></span>
            <span class="col-9 error_message" id="name_error"></span>
          </div>

          <div class="form-group row">
            <label class="col-3" for="email">E-Mail Adresse</label>
            <input class="col-9" type="text" name="email" id="email" value="">
            <span class="col-3"></span>
            <span class="col-9 error_message" id="email_error"></span>
          </div>

          <div class="form-group row">
            <label class="col-3" for="messagetext">Nachricht / Anmerkungen</label>
            <textarea class="form-control col-9" name="messagetext" id="messagetext" rows="4" cols="80"></textarea>
            <span class="col-3"></span>
            <span class="col-9 error_message" id="messagetext_error"></span>
          </div>
<?php
// echo "x-> " . $printshop_data["frontpageoption"];
// <!-- 1 = manuelle Eingabe -->
// <!-- 2 = PDF Upload -->
if ($printshop_data["frontpageoption"] == 1) {
 ?>
          <!-- Auswahl der Farbe -->
          <div class="form-group row for_frontpageoption1">
            <label class="col-3" for="favcolor">Farbe</label>
            <input type="color" class="form-control col-9" name="favcolor" id="favcolor" value="<?php if ($cur_favcolor != "#ffffff") {
              echo $cur_favcolor;
            } else { echo "#ffffff";} ?>">
            <span class="col-3"></span>
            <span class="col-9 error_message" id="favcolor_error"></span>
          </div>

          <!-- Vorderseite inkl. Texteingabe -->
          <div class="form-group row for_frontpageoption1">
            <label class="col-3" for="frontpagetext">Text für die Vorderseite</label>
            <textarea class="form-control col-9" name="frontpagetext" id="frontpagetext" rows="4" cols="80"><?php if (!empty($cur_frontpagetext)) {
              echo htmlspecialchars($cur_frontpagetext);
            }  ?></textarea>
            <span class="col-3"></span>
            <span class="col-9 error_message" id="frontpagetext_error"></span>
          </div>
<?php
// code...
} else {
 ?>
          <!-- Upload (Coverseite‐PDF, Inhaltsseiten‐PDF) -->
          <!-- The fileinput-button span is used to style the file input field as button -->
          <div class="form-group row">
            <div class="col-3">Deckblatt (PDF)</div>
            <span class="col-3 btn btn-success fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>
              <span>Dateien wählen...</span>
              <!-- The file input field used as target for the file upload widget -->
              <input id="fileupload" type="file" name="files[]">
              <!-- multiple -->
            </span>
          <!-- </div> -->
          <!-- <div class="form-group row"> -->
            <div class="col-1"></div>
            <!-- The global progress bar -->
            <div id="progress" class="col-5 progress my-auto">
                <div class="progress-bar progress-bar-success"></div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-3"></div>
            <!-- The container for the uploaded files -->
            <div id="files" name="file" class="col-9 files">
            </div>
          </div>
<?php
}
 ?>
          <div>
            <button id="btn-send-anfrage" type="submit" >abschicken</button>
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

  <script src="js/anfrage.js"></script>
