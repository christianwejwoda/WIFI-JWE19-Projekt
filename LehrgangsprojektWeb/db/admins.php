<?php
class db_admins extends db_model_rows
{
  protected $_table = "benutzer";

  public function get()
  {
    $answer = "";
    $platzhalter = array();
    $sql = "SELECT * FROM {$this->_table} WHERE istadmin = 1" ;
    $result = db_mysql::get_instanz()->query($sql, $platzhalter);
    $row = $result->fetch_assoc(); // es wird bewusst nur der erste Eintrag verwendet!!
    //Formatbeispiel: Christian Wejwoda <christian@wejwoda.at>
    $answer .=  $row["anzeigename"] . " <" . $row["email"] . ">";
    return $answer;
  }
}
