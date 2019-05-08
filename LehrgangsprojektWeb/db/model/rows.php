<?php
abstract class db_model_rows
{
  protected $_table = "";
  protected $_datasave = array();

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

  public function getRows()
  {
    $platzhalter = array();
    $sql = "SELECT * FROM {$this->_table} " ;
    $result = db_mysql::get_instanz()->query($sql, $platzhalter);
    foreach ($result as $row) {
      $rows[] = $row;
    }
    return $rows;
  }

}
