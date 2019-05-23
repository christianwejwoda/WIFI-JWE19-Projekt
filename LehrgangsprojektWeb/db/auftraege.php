<?php
class db_auftraege extends db_model_rows
{
  protected $_table = "auftraege";

  public function get($geprueft_modus = 0)
  {
    // $geprueft_modus
    // 0 : alle
    // 1 : nur geprüfte
    // 2 : nur ungeprüfte

    if (empty($this->_datasave)) {
      $platzhalter = array();
      $sql = "SELECT * FROM {$this->_table} " ;
      switch ($geprueft_modus) {
        case 1:
          $sql .= " WHERE geprueft = 1";
          break;

        case 2:
          $sql .= " WHERE geprueft = 0";
          break;

      }
      $result = db_mysql::get_instanz()->query($sql, $platzhalter);
      while ($row = $result->fetch_assoc()) {
        $this->_datasave[] = new db_gramatur($row);
      }
    }
    return $this->_datasave;
  }
}
