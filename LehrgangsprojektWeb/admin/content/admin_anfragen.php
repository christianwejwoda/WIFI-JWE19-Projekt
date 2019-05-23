<?php
  require_once "../lib/setup.php";

$curAuftragID = 0;
$modus = 0;

  if (array_key_exists("id",$_GET)) {
    $curAuftragID = (int)$_GET["id"];
  }
  if (array_key_exists("modus",$_GET)) {
    $modus = (int)$_GET["modus"];
    if ($modus < 0 || $modus > 2) {
      $modus = 0;
    }
  }

  if (!empty($_POST)) {
    // echo "<pre>";print_r($_POST);echo "</pre>";
    $curAuftragID = (int)$_POST["id"];
    if ($curAuftragID > 0) {
      $curAuftrag = new db_auftrag($curAuftragID);
      $curAuftrag->preis_fix = (double)$_POST["preis_fix"] ;
      $curAuftrag->geprueft = ($_POST["geprueft"] == "on" ? 1 : 0) ;
      $curAuftrag->save();
      if ($curAuftrag->geprueft == 1) {
        $m = new lib_mailsender($curAuftrag->getRow());
        $m->send(1); // auch an Kunde senden
      }
    }
  }
?>

<div class="container maxWidth">
  <div class="row">&nbsp</div>
  <div class="row">
    <div class="col-12 menurow">
      <ul>

      <?php
        echo '<li><a href="'.basename(__FILE__, '.php').'?modus=0">alle Anfragen</a></li>';
        echo '<li><a href="'.basename(__FILE__, '.php').'?modus=1">nur geprüfte Anfragen</a></li>';
        echo '<li><a href="'.basename(__FILE__, '.php').'?modus=2">nur ungeprüfte Anfragen</a></li>';
       ?>
     </ul>
    </div>
  </div>
  <br />
  <div class="row">

      <?php
      echo "<div class='col-4' >";
      $auftraege = new db_auftraege();
      echo "<ul>";
      foreach ($auftraege->get($modus) as $auftraeg) {
        echo '<li>
          <a href="'.basename(__FILE__, '.php').'?id='.$auftraeg->id.'">'.$auftraeg->nachname.' '.$auftraeg->vorname.'(' . $auftraeg->id . ')';
          if ($auftraeg->geprueft == 1) {
            echo ' - geprüft';
          }
          echo '</a>
        </li>';
      }
      echo "</ul>";
      echo "</div>";
      echo "<div class='col-8' >";
      if ($curAuftragID > 0) {
        $curAuftrag = new db_auftrag($curAuftragID);
        // echo "<pre>";print_r($curAuftrag->getRow());echo "</pre>";
        ?>

        <div class="container-fluid">

          <div class="row">
            <div class="col-12 col-lg-3 border">Nachname:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->nachname;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Vorname:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->vorname;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Strasse:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->strasse;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">PLZ Ort:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->plz . " " . $curAuftrag->ort;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">E-Mail:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->email;
             ?></div>
          </div>

          <br />

          <div class="row">
            <div class="col-12 col-lg-3 border">Produkt:</div>
            <div class="col-12 col-lg-9 border"><?php
              $cP = new db_produkt($curAuftrag->produkt_id);
              echo $cP->titel;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Produkt:</div>
            <div class="col-12 col-lg-9 border"><?php
              if($curAuftrag->ein_zwei_seitig == 1) {
                echo "einseitig";
              } else {
                echo "zweiseitig";
              }
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Papier‐Grammatur:</div>
            <div class="col-12 col-lg-9 border"><?php
              $cP = new db_gramatur($curAuftrag->grammatur_id);
              echo $cP->gramm_m2 . " g/m²";
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Randlos:</div>
            <div class="col-12 col-lg-9 border"><?php
              if($curAuftrag->randlos == 1) {
                echo "Ja";
              } else {
                echo "Nein";
              }
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Seitenzahl:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->seitenzahl;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Einheiten:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->einheiten;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Zustelloption:</div>
            <div class="col-12 col-lg-9 border"><?php
              $cP = new db_zustelloption($curAuftrag->zustelloption_id);
              $zp_titel = $cP->titel;
              echo $cP->titel;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">gewünschtes Lieferdatum:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->lieferdatum;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Farbe:</div>
            <div class="col-3 col-lg-2 border"><?php
              echo $curAuftrag->farbe;
             ?></div>
             <div class="col-9 col-lg-7 border" <?php
               echo "style='background: " . $curAuftrag->farbe . "'";
              ?>></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Deckblatt Text:</div>
            <div class="col-12 col-lg-9 border"><?php
              echo $curAuftrag->deckblatt_text;
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Deckblatt-Datei:</div>
            <div class="col-12 col-lg-9 border"><?php
              $cP = new db_uploaddatei($curAuftrag->deckblatt_datei);
              echo "<a href='../upload/" . $cP->upload_dateiname . "' download='" . $cP->org_dateiname . "'>" . $cP->org_dateiname . "</a>";
             ?></div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-3 border">Inhalt-Datei:</div>
            <div class="col-12 col-lg-9 border"><?php
              $cP = new db_uploaddatei($curAuftrag->inhalt_datei);
              echo "<a href='../upload/" . $cP->upload_dateiname . "' download='" . $cP->org_dateiname . "'>" . $cP->org_dateiname . "</a>";
             ?></div>
          </div>

          <br />
          <p class='h3'>Angebot</p>
          <p>alle Preise in €</p>
          <div class='row'>
            <span class='col-12 col-sm-5 col-lg-5 border'>Preis pro Seite:</span>
            <span class='col-sm-3 col-lg-2'></span>
            <span class='col-sm-1 col-lg-1'></span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php $preisSum = $curAuftrag->price_per_page; echo number_format($curAuftrag->price_per_page,2,',',''); ?></span>
          </div>
          <div class='row' id="price_add_randlos_group">
            <span class='col-12 col-sm-5 col-lg-5  border'>+ Aufschlag für randlosen Druck:</span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_add_randlos_add"><?php $preisSum += $curAuftrag->price_add_randlos_add; echo number_format($curAuftrag->price_add_randlos_add,2,',',''); ?></span>
            <span class='col-12 col-sm-1 col-lg-1  '><i class="arrow direction"></i></span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_add_randlos"><?php echo number_format($preisSum,2,',',''); ?></span>
          </div>
          <div class='row'>
            <span class='col-12 col-sm-5 col-lg-5  border'>+ Basispreis für Cover:</span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_add_cover_add"><?php $preisSum += $curAuftrag->price_add_cover_add; echo number_format($curAuftrag->price_add_cover_add,2,',',''); ?></span>
            <span class='col-12 col-sm-1 col-lg-1 '><i class="arrow direction"></i></span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_add_cover"><?php echo number_format($preisSum,2,',',''); ?></span>
          </div>
          <div class='row'>
            <span class='col-12 col-sm-5 col-lg-5  border' id="price_result_label">Gesamtpreis für <?php echo $curAuftrag->einheiten; ?> Einheiten:</span>
            <span class='col-sm-3 col-lg-2'></span>
            <span class='col-sm-1 col-lg-1'></span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_result"><?php $preisSum *= $curAuftrag->einheiten; echo number_format($preisSum,2,',',''); ?></span>
          </div>
          <div class='row' id="price_delivery_group">
            <span class='col-12 col-sm-5 col-lg-5  border' id="price_delivery_label">+ <?php echo $zp_titel; ?></span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_delivery_add"><?php $preisSum += $curAuftrag->price_delivery_add; echo number_format($curAuftrag->price_delivery_add,2,',',''); ?></span>
            <span class='col-12 col-sm-1 col-lg-1 '><i class="arrow direction"></i></span>
            <span class='col-12 col-sm-3 col-lg-2 text-right border' id="price_delivery"><?php echo number_format($preisSum,2,',',''); ?></span>
          </div>
          <div class='row'>
            <span class='col-12 col-sm-5 col-lg-5  border'>voraussichtliche Produktionszeit</span>
            <span class='col-12 col-sm-7 col-lg-5 text-left border' id="produktionszeit"><?php echo $curAuftrag->produktionszeit; ?> Stunden</span>
          </div>

          <br />

          <form class="" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">

            <!-- preis_fix -->
            <div class="form-group row">
              <label class="col-12 col-lg-4 col-form-label" for="preis_fix" id="seitenzahl_label">endgültiger Preis</label>
              <input class="form-control col-12 col-sm-5 col-lg-2 text-right" type="number" name="preis_fix" id="preis_fix" value="<?php
                if (!is_numeric($curAuftrag->preis_fix)) {
                  echo number_format($preisSum,2,'.','');
                } else {
                  echo number_format($curAuftrag->preis_fix,2,'.','');
                }
               ?>">
            </div>

            <!-- geprueft -->
            <div class="form-group row flex-lg-row flex-row-reverse">
              <label class="col-11 col-lg-4 form-check-label" for="geprueft">Angebot geprüft</label>
              <div class="radio_format">
                <div class="form-check">
                  <!-- col-lg-1 col-sm-1  -->
                  <input class="form-check-input" type="checkbox" name="geprueft" id="geprueft" autocomplete="off" <?php
                    if ($curAuftrag->geprueft == 1) {
                      echo " checked ";
                    }
                   ?>>
                </div>
              </div>
            </div>
            <input type="text" name="id" id="id" value="<?php echo $curAuftragID ?>" hidden>

            <?php
            if ($curAuftrag->geprueft == 0) {
              ?>
              <div>
                <button type="submit" >speichern</button>
              </div>
              <?php
            }
            ?>

          </form>



        </div>

        <?php
      }
      echo "</div>";
      ?>


  </div>
</div>
