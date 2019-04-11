<div class="container-fluid">
  <div class="row">
    <div class="col-1">
    </div>

    <div class="col-11">
      <div class="row">
        <form class="" action="savedata.php" method="post">
          <h2>Grammaturen:</h2>
          <?php
            $_SESSION["calling_page"] = "grammatur";
            echo '<div class="form-group row">';
            echo '<div class="col-3"> </div>';
            echo '<label class="form-label col-2">g/m²</label>';
            echo '<label class="form-label col-2">Preis pro Blatt &euro;</label>';
            echo '<label class="form-label col-2">Preis pro Druckseite &euro;</label>';
            echo '</div>';

            while($row = mysqli_fetch_assoc( $gramaturen ))
            {
              echo '<div class="form-group row">';
              echo '<label class="form-label col-3" for="gramm_m2' . $row["id"] . '">Grammtur ' . $row["id"] . ': </label>';
              echo '<input class="form-control col-2 text-right" type="text" name="grammatur_' . $row["id"] . '_gramm_m2" id="grammatur_' . $row["id"] . '_gramm_m2" value="' . str_replace('.',',',htmlspecialchars($row["gramm_m2"])) . '">';
              echo '<input class="form-control col-2 text-right" type="text" name="grammatur_' . $row["id"] . '_preis_blatt" id="grammatur_' . $row["id"] . '_preis_blatt" value="' . str_replace('.',',',htmlspecialchars($row["preis_blatt"])) . '">';
              echo '<input class="form-control col-2 text-right" type="text" name="grammatur_' . $row["id"] . '_preis_druckseite" id="grammatur_' . $row["id"] . '_preis_druckseite' . $row["id"] . '" value="' . str_replace('.',',',htmlspecialchars($row["preis_druckseite"])) . '">';
              echo '</div>';
            }
            echo '<div class="form-group row">';
            echo '<label class="form-label col-3" for="produktNeu">Grammtur NEU: </label>';
            echo '<input class="form-control col-2 text-right" type="text" name="grammatur_neu_gramm_m2" id="grammatur_neu_gramm_m2" value="">';
            echo '<input class="form-control col-2 text-right" type="text" name="grammatur_neu_preis_blatt" id="grammatur_neu_preis_blatt" value="">';
            echo '<input class="form-control col-2 text-right" type="text" name="grammatur_neu_preis_druckseite" id="grammatur_neu_preis_druckseite" value="">';
            echo '</div>';

            if (!empty($_SESSION["save_error"])) {
              echo "<p>{$_SESSION["save_error"]}</p>";
            }
           ?>
          <div>
            <button class="btn-send" type="submit" >abschicken</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
