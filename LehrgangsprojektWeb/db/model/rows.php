<?php
abstract class db_model_rows
{
  protected $_table = "";
  private $_datasave = array();

  public function __construct()
  {
    // Prüfung ob vererbte Klassen die $this->_table Eigenschaft überschrieben haben
    if (empty($this->_table)) {
      throw new Exception("Eigenschaft _table muss überschrieben werden, wenn von db_model_row geerbt wird.");
    }
  }

  public function get_count()
  {
    $platzhalter = array();
    $sql = "SELECT COUNT(1) FROM {$this->_table} " ;

    $result = db_mysql::get_instanz()->query($sql, $platzhalter);
    $row = $result->fetch_row();
    return $row[0];

  }

  public function get()
  {
    if (empty($this->_datasave)) {
      $platzhalter = array();
      $sql = "SELECT * FROM {$this->_table} " ;

      $result = db_mysql::get_instanz()->query($sql, $platzhalter);
      while ($row = $result->fetch_assoc()) {
        $this->_datasave[] = new db_produkt($row);
      }
    }
    return $this->_datasave;
  }

}
