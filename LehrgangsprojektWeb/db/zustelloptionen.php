<?php
class db_zustelloptionen extends db_model_rows
{
  protected $_table = "zustelloptionen";

  public function get()
  {
    if (empty($this->_datasave)) {
      $platzhalter = array();
      $sql = "SELECT * FROM {$this->_table} " ;

      $result = db_mysql::get_instanz()->query($sql, $platzhalter);
      while ($row = $result->fetch_assoc()) {
        $this->_datasave[] = new db_zustelloption($row);
      }
    }
    return $this->_datasave;
  }
}
