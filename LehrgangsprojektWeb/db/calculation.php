<?php #

// get_answer -->
// array (
//  preis1 --> Seitenpreis
//  preis2 --> Aufpreis "randlos"
//  preis3 --> Preis pro Einheit
//  preis4 --> Preis für alle Einheiten
// )

class db_calculation
{
  private $_values;
  private $_product;
  private $_gramatur;
  private $_errors = array();
  private $_answers = array();

  public function __construct(array $values)
  {
    $this->_values = db_mysql::get_instanz()->escape($values);
  }

  public function validieren()
  {
    // echo "<pre>";print_r($this->_values);echo "</pre><br />";die();
    $this->_product = new db_produkt((int)$this->_values["product"]);
    $this->_gramatur = new db_gramatur((int)$this->_values["paper_weight"]);

    if (empty($this->_product)) {
      $this->_errors[] = "Das Produkt existiert nicht in der Datenbank.";
    }
    if (empty($this->_gramatur)) {
      $this->_errors[] = "Die Grammatur existiert nicht in der Datenbank.";
    }
    if ((int)$this->_values["pageoption"] != 1 && (int)$this->_values["pageoption"] != 2) {
      $this->_errors[] = "Die Seitenoption hat einen ungültigen Wert. Nur 1 oder 2 sind erlaubt.";
    }
    if (empty($this->_errors)) {
      return true;
    }
    return false;
  }

  public function get_answer()
  {

    $preis = 0;
    if ((int)$this->_values["pageoption"] == 1) // ==> einseitiig
    {
      $preis += ($this->_gramatur->preis_blatt * (int)$this->_values["pagecount"] + $this->_gramatur->preis_druckseite * (int)$this->_values["pagecount"]);
    }
    else if ((int)$this->_values["pageoption"] == 2) // ==> zweiseitiig
    {
      $preis += ($this->_gramatur->preis_blatt * (int)$this->_values["pagecount"] / 2 + $this->_gramatur->preis_druckseite * (int)$this->_values["pagecount"]);
    }
    $this->_answers["preis1"] = $preis;

    // randlos ==> druckpreis + 5%
    if ((bool)$this->_values["borderless"] == true) {
      $preis = $preis * 1.05;
      $this->_answers["preis2"] = $preis;
    }

    //produkt : $product->preis
    $preis += $this->_product->preis;
    $this->_answers["preis3"] = $preis;

    // mit der Anzahl Einheiten multiplizieren
    $preis = $preis * (int)$this->_values["units"];
    $this->_answers["preis4"] = $preis;

    $this->_answers["units"] = (int)$this->_values["units"];

    return $this->_answers;
  }

  public function errors()
  {
    return $this->_errors;
  }
}
