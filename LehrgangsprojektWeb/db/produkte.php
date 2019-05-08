<?php
class db_produkte extends db_model_rows
{
  protected $_table = "produkte";
  protected $_datasave = array();
  protected $_daten;

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
