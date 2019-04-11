<?php
abstract class db_model_row
{
  protected $_tabelle; // Muss in Kind-Klassen überschrieben werden
  private $_daten;

  public function __construct($daten)
  {
    // Prüfung ob vererbte Klassen die $this->_tabelle Eigenschaft überschrieben haben
    if (empty($this->_tabelle)) {
      throw new Exception("Eigenschaft _tabelle muss überschrieben werden, wenn von db_model_row geerbt wird.");
    }

    if (is_numeric($daten)) {
      $result = db_mysql::get_instanz()->query("SELECT * FROM {$this->_tabelle} WHERE id = ?;", array($daten));
      $daten = $result->fetch_assoc();
    }
    $this->_daten = $daten;
  }

  public function __get($variable)
  {
    return $this->_daten[$variable];
  }

  public function entfernen()
  {
    db_mysql::get_instanz()->query("DELETE FROM {$this->_tabelle} WHERE id = ?;", array($this->_daten["id"]));
  }

  public function speichern()
  {
    $db = db_mysql::get_instanz();

    // Feldnamen und Werte für SQL-Befehl aufbereiten
    $fields = "";
    $values = array();
    foreach ($this->_daten as $key => $value) {
      if ($key == "id") continue;
      $fields .= $key . " = ?, ";
      $values[] = $value;
    }
    $fields = trim($fields,", ");

    if (empty($this->_daten["id"])) {
      $db->query("INSERT INTO {$this->_tabelle} SET {$fields} ;", $values);
    } else {
      $values[] = $this->_daten["id"];
      $db->query("UPDATE {$this->_tabelle} SET {$fields} WHERE id = ? ;", $values);
    }
  }

}
