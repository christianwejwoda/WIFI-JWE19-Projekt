<?php
  require_once "../lib/setup.php";

$auftraegID = 0;
$modus = 0;

  if (array_key_exists("id",$_GET)) {
    $auftraegID = (int)$_GET["id"];
  }
  if (array_key_exists("modus",$_GET)) {
    $modus = (int)$_GET["modus"];
    if ($modus < 0 || $modus > 2) {
      $modus = 0;
    }
  }

  if (!empty($_POST)) {
    // echo "<pre>";print_r($_POST); echo "</pre>";
    $auftraegID = (int)$_POST["id"];
    if ($auftraegID > 0) {
      $auftraeg = new db_auftrag($auftraegID);

      $auftraeg->preis_fix = (double)str_replace(",",".",$_POST["preis_fix"]) ;
      if (array_key_exists("geprueft",$_POST)) {
        $auftraeg->geprueft = ($_POST["geprueft"] == "on" ? 1 : 0) ;
      }
      $auftraeg->save();
      if ($auftraeg->geprueft == 1) {
        $m = new lib_mailsender($auftraeg->getRow());
        $m->send(1); // auch an Kunde senden
      }
    }
  }
?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContentDetail" aria-controls="navbarSupportedContentDetail" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      geprüfte ?
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContentDetail">
      <ul class="navbar-nav mr-auto">
        <?php
          echo '<li class="nav-item">';
          echo '<a class="nav-link ';
          if ($modus == 0) {
             echo " nav-item-active";
          } else {
            echo " text-white";
          }
          echo '" href="'.basename(__FILE__, '.php').'?modus=0">alle Anfragen</a>';
          echo '</li>';

          echo '<li class="nav-item">';
          echo '<a class="nav-link ';
          if ($modus == 1) {
             echo " nav-item-active";
          } else {
            echo " text-white";
          }
          echo '" href="'.basename(__FILE__, '.php').'?modus=1">nur geprüfte Anfragen</a>';
          echo '</li>';

          echo '<li class="nav-item">';
          echo '<a class="nav-link ';
          if ($modus == 2) {
             echo " nav-item-active";
          } else {
            echo " text-white";
          }
          echo '" href="'.basename(__FILE__, '.php').'?modus=2">nur ungeprüfte Anfragen</a>';
          echo '</li>';
        ?>
      </ul>
    </div>
    </div>
  </nav>

  <div class="container rounded mt-4">
    <div class="accordion" id="accordionExample">
      <?php
      $auftraege = new db_auftraege();
      foreach ($auftraege->get($modus) as $auftraeg) {
        ?>
          <div class="card">
            <div class="card-header" id="heading<?php echo $auftraeg->id; ?>">
              <h5 class="mb-0">
                <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $auftraeg->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $auftraeg->id; ?>">
                  <?php echo $auftraeg->nachname.' '.$auftraeg->vorname.'(' . $auftraeg->id . ')'; ?>
                </button>
              </h5>
            </div>

            <div id="collapse<?php echo $auftraeg->id; ?>" class="collapse" aria-labelledby="heading<?php echo $auftraeg->id; ?>" data-parent="#accordionExample">
              <div class="card-body">

                <div class="container-fluid">

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Nachname:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->nachname;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Vorname:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->vorname;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Strasse:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->strasse;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">PLZ Ort:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->plz . " " . $auftraeg->ort;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">E-Mail:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->email;
                     ?></div>
                  </div>

                  <br />

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Produkt:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      $cP = new db_produkt($auftraeg->produkt_id);
                      echo $cP->titel;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Seitenoption:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      if($auftraeg->ein_zwei_seitig == 1) {
                        echo "einseitig";
                      } else {
                        echo "zweiseitig";
                      }
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Papier‐Grammatur:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      $cP = new db_gramatur($auftraeg->grammatur_id);
                      echo $cP->gramm_m2 . " g/m²";
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Randlos:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      if($auftraeg->randlos == 1) {
                        echo "Ja";
                      } else {
                        echo "Nein";
                      }
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Seitenzahl:</div>
                    <div class="col-12 col-lg-9 border"><?php echo $auftraeg->seitenzahl; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Einheiten:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->einheiten;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Zustelloption:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      $cP = new db_zustelloption($auftraeg->zustelloption_id);
                      $zp_titel = $cP->titel;
                      echo $cP->titel;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">gewünschtes Lieferdatum:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->lieferdatum;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Farbe:</div>
                    <div class="col-3 col-lg-2 border"><?php
                      echo $auftraeg->farbe;
                     ?></div>
                     <div class="col-9 col-lg-7 border" <?php
                       echo "style='background: " . $auftraeg->farbe . "'";
                      ?>></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Deckblatt Text:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      echo $auftraeg->deckblatt_text;
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Deckblatt-Datei:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      $cP = new db_uploaddatei($auftraeg->deckblatt_datei);
                      echo "<a href='../uploads/" . $cP->upload_dateiname . "' download='" . $cP->org_dateiname . "'>" . $cP->org_dateiname . "</a>";
                     ?></div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-lg-3 border">Inhalt-Datei:</div>
                    <div class="col-12 col-lg-9 border"><?php
                      $cP = new db_uploaddatei($auftraeg->inhalt_datei);
                      echo "<a href='../uploads/" . $cP->upload_dateiname . "' download='" . $cP->org_dateiname . "'>" . $cP->org_dateiname . "</a>";
                     ?></div>
                  </div>

                  <br />
                  <p class='h3'>Angebot</p>
                  <p>alle Preise in €</p>
                  <div class='row'>
                    <span class='col-12 col-sm-5 col-lg-5 border'>Druckkosten für <?php echo $auftraeg->seitenzahl; ?> Seiten<?php
                    if($auftraeg->ein_zwei_seitig == 2) {
                      echo " auf " . $auftraeg->seitenzahl / 2 . " Blättern";
                    }
                     ?>:</span>
                    <span class='col-sm-3 col-lg-2'></span>
                    <span class='col-sm-1 col-lg-1'></span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php $preisSum = $auftraeg->price_per_page; echo number_format($auftraeg->price_per_page,2,',',''); ?></span>
                  </div>
                  <div class='row'>
                    <span class='col-12 col-sm-5 col-lg-5  border'>+ Aufschlag für randlosen Druck:</span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php $preisSum += $auftraeg->price_add_randlos_add; echo number_format($auftraeg->price_add_randlos_add,2,',',''); ?></span>
                    <span class='col-12 col-sm-1 col-lg-1  '><i class="arrow direction"></i></span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php echo number_format($preisSum,2,',',''); ?></span>
                  </div>
                  <div class='row'>
                    <span class='col-12 col-sm-5 col-lg-5  border'>+ Basispreis für Cover:</span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php $preisSum += $auftraeg->price_add_cover_add; echo number_format($auftraeg->price_add_cover_add,2,',',''); ?></span>
                    <span class='col-12 col-sm-1 col-lg-1 '><i class="arrow direction"></i></span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php echo number_format($preisSum,2,',',''); ?></span>
                  </div>
                  <div class='row'>
                    <span class='col-12 col-sm-5 col-lg-5  border'>Gesamtpreis für <?php echo $auftraeg->einheiten; ?> Einheiten:</span>
                    <span class='col-sm-3 col-lg-2'></span>
                    <span class='col-sm-1 col-lg-1'></span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php $preisSum *= $auftraeg->einheiten; echo number_format($preisSum,2,',',''); ?></span>
                  </div>
                  <div class='row'>
                    <span class='col-12 col-sm-5 col-lg-5  border'>+ <?php echo $zp_titel; ?></span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php $preisSum += $auftraeg->price_delivery_add; echo number_format($auftraeg->price_delivery_add,2,',',''); ?></span>
                    <span class='col-12 col-sm-1 col-lg-1 '><i class="arrow direction"></i></span>
                    <span class='col-12 col-sm-3 col-lg-2 text-right border'><?php echo number_format($preisSum,2,',',''); ?></span>
                  </div>
                  <div class='row'>
                    <span class='col-12 col-sm-5 col-lg-5  border'>voraussichtliche Produktionszeit</span>
                    <span class='col-12 col-sm-7 col-lg-5 text-left border'><?php echo $auftraeg->produktionszeit; ?> Stunden</span>
                  </div>

                  <br />

                  <form class="" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">

                    <!-- preis_fix -->
                    <div class="form-group row">
                      <label class="col-12 col-lg-4 col-form-label" for="preis_fix">endgültiger Preis</label>
                      <input class="form-control col-12 col-sm-5 col-lg-2 text-right" type="text" name="preis_fix" id="preis_fix<?php echo $auftraeg->id; ?>" value="<?php
                        if (!is_numeric($auftraeg->preis_fix)) {
                          echo number_format($preisSum,2,',','');
                        } else {
                          echo number_format($auftraeg->preis_fix,2,',','');
                        }
                        // str_replace($_POST["preis_fix"],",",".")
                       ?>">
                    </div>

                    <!-- geprueft -->
                    <div class="form-group row flex-lg-row flex-row-reverse">
                      <label class="col-11 col-lg-4 form-check-label" for="geprueft">Angebot geprüft</label>
                      <div class="radio_format">
                        <div class="form-check">
                          <!-- col-lg-1 col-sm-1  -->
                          <input class="form-check-input" type="checkbox" name="geprueft" <?php
                            if ($auftraeg->geprueft == 1) {
                              echo " checked ";
                            }
                           ?>>
                        </div>
                      </div>
                    </div>
                    <input type="text" name="id" value="<?php echo $auftraeg->id ?>" hidden>

                    <?php
                    if ($auftraeg->geprueft == 0) {
                      ?>
                      <div>
                        <button class="btn-primary" type="submit" >speichern</button>
                      </div>
                      <?php
                    }
                    ?>

                  </form>



                </div>

              </div>
            </div>
          </div>
        <?php
      }

      // echo "<div class='col-8' >";
      // if ($auftraegID > 0) {
      //   $auftraeg = new db_auftrag($auftraegID);
         ?>


        <?php
      // }
      echo "</div>";
      ?>
    </div>


<!-- </div> -->
