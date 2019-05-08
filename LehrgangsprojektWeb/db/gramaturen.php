<?php
class db_gramaturen extends db_model_rows
{
  protected $_table = "gramaturen";

  public function get()
  {
    if (empty($this->_datasave)) {
      $platzhalter = array();
      $sql = "SELECT * FROM {$this->_table} " ;

      $result = db_mysql::get_instanz()->query($sql, $platzhalter);
      while ($row = $result->fetch_assoc()) {
        $this->_datasave[] = new db_gramatur($row);
      }
    }
    return $this->_datasave;
  }
}
