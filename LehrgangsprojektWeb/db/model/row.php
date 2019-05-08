<?php
abstract class db_model_row
{
  protected $_table; // Muss in Kind-Klassen überschrieben werden
  protected $_unique_field;
  protected $_daten;

  public function __construct($daten)
  {
    // Prüfung ob vererbte Klassen die $this->_table Eigenschaft überschrieben haben
    if (empty($this->_table)) {
      throw new Exception("Eigenschaft _table muss überschrieben werden, wenn von db_model_row geerbt wird.");
    }

    if (is_numeric($daten)) {
      $result = db_mysql::get_instanz()->query("SELECT * FROM {$this->_table} WHERE id = ?;", array($daten));
      $daten = $result->fetch_assoc();
    }

    if (is_string($daten)) {
      $parts = explode(",",$daten);
      $where = array_shift($parts);
      $result = db_mysql::get_instanz()->query("SELECT * FROM {$this->_table} WHERE {$where};", $parts);
      $daten = $result->fetch_assoc();
    }
    $this->_daten = $daten;
  }

  public function __get($variable)
  {
    return $this->_daten[$variable];
  }

  public function getRow()
  {
    return $this->_daten;
  }

  public function check_double_entry($unique_field)
  {
    $result = db_mysql::get_instanz()->query("SELECT COUNT(1) FROM {$this->_table} WHERE {$this->_unique_field} = ? ", array($unique_field));
    $row = $result->fetch_row();
    return (int)$row[0] > 0;
  }

  public function entfernen()
  {
    db_mysql::get_instanz()->query("DELETE FROM {$this->_table} WHERE id = ?;", array($this->_daten["id"]));
  }

  public function __set($fieldname, $value)
  {
    if (array_key_exists($fieldname,$this->_daten)) {
      $this->_daten[$fieldname] = $value;
    }
  }

  public function save()
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
      $db->query("INSERT INTO {$this->_table} SET {$fields} ;", $values);
    } else {
      $values[] = $this->_daten["id"];
      $db->query("UPDATE {$this->_table} SET {$fields} WHERE id = ? ;", $values);
    }
  }

}
