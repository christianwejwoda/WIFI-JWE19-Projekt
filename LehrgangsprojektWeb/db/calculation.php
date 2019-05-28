<?php
class db_calculation
{
  private $_values;
  private $_produkt;
  private $_gramatur;
  private $_errors = array();
  private $_answers = array();

  public function __construct(array $values)
  {
    $this->_values = db_mysql::get_instanz()->escape($values);
  }

  public function validieren()
  {
    try {

    $this->_answers["errors"] = array();

    // echo "<pre>";print_r($this->_values);echo "</pre><br />";die();
    $this->_produkt = new db_produkt((int)$this->_values["produkt_id"]);
    $this->_gramatur = new db_gramatur((int)$this->_values["grammatur_id"]);

    if (empty($this->_produkt)) {
      $this->_answers["errors"][] = "Das Produkt existiert nicht in der Datenbank.";
    }
    if (empty($this->_gramatur)) {
      $this->_answers["errors"][] = "Die Grammatur existiert nicht in der Datenbank.";
    }
    if ((int)$this->_values["ein_zwei_seitig"] != 1 && (int)$this->_values["ein_zwei_seitig"] != 2) {
      $this->_answers["errors"][] = "Die Seitenoption hat einen ungültigen Wert. Nur 1 oder 2 sind erlaubt.";
    }

    return empty($this->_answers["errors"]);
  } catch (Exception $e) {
      $this->_answers["errors"][] = $e->getMessage();
  }


  }

  public function get_answer()
  {

    $preis = 0;
    $ein_zwei_seitig = (int)$this->_values["ein_zwei_seitig"];
    $seitenzahl = (int)$this->_values["seitenzahl"];

    $preis += $this->_gramatur->preis_blatt * $seitenzahl / $ein_zwei_seitig;
    $preis += $this->_gramatur->preis_druckseite * $seitenzahl;
    $this->_answers["preis1"] = $preis;

    // randlos ==> druckpreis + 5%
    if ($this->_values["randlos"] === "true") {
      $preis = $preis * 1.05;
      $this->_answers["preis2add"] = $preis - $this->_answers["preis1"];
      $this->_answers["preis2"] = $preis;
    }

    //produkt : $produkt_id->preis
    $preis += $this->_produkt->preis;
    $this->_answers["preis3add"] = $this->_produkt->preis;
    $this->_answers["preis3"] = $preis;

    // mit der Anzahl Einheiten multiplizieren
    $preis = $preis * (int)$this->_values["einheiten"];
    $this->_answers["preis4"] = $preis;
    $zt = new db_zustelloption((int)$this->_values["zustelloption_id"]);
    if (!empty($zt)) {
      $preis += $zt->preis;
      $this->_answers["price_delivery_label"] = $zt->titel;
      $this->_answers["preis5"] = $preis;
      $this->_answers["preis5add"] = $zt->preis;
    }
    $this->_answers["einheiten"] = (int)$this->_values["einheiten"];

    $this->_answers["deckblattfarbauswahl"] = $this->_produkt->deckblattfarbauswahl;
    $this->_answers["deckblatttexteingabe"] = $this->_produkt->deckblatttexteingabe;
    $this->_answers["maxseiten"] = $this->_gramatur->maxseiten;

    $this->_answers["produktionszeit"] = ceil($this->_produkt->zeitsetup + $this->_produkt->zeitverpackung + ($this->_gramatur->zeitproduktion / 3600 * $seitenzahl * $ein_zwei_seitig * $this->_answers["einheiten"]));

    return $this->_answers;
  }

  public function errors()
  {
    return $this->_errors;
  }
}
