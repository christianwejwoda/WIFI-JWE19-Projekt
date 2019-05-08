<?php
class db_auftragspeichern
{
  private $_values;
  private $_errors = array();

  public function __construct(array $values)
  {
    $this->_values = db_mysql::get_instanz()->escape($values);
  }

  public function validieren()
  {
    try {
      $x1 = explode("\\", $this->_values['deckblatt_datei']);
      $f1 = end($x1);
      $file = new db_uploaddatei("session_id = ? AND org_dateiname = ?,{$this->_values['session_id']},{$f1}");
      $this->_values['deckblatt_datei'] = $file->id;

      $x1 = explode("\\", $this->_values['inhalt_datei']);
      $f1 = end($x1);
      $file = new db_uploaddatei("session_id = ? AND org_dateiname = ?,{$this->_values['session_id']},{$f1}");
      $this->_values['inhalt_datei'] = $file->id;

    } catch (Exception $e) {

    }

  }

  public function save()
  {
    $a = new db_auftrag($this->_values);
    $a->save();
    return array("fertig" => "fertig");
  }

}


// Array
// (
//     [session_id] => hkabtqjh2foifihk4tm1vvnsuc
//     [produkt_id] => 2
//     [ein_zwei_seitig] => 1
//     [grammatur_id] => 2
//     [seitenzahl] => 10
//     [einheiten] => 1
//     [zustelloption_id] => 1
//     [lieferdatum] => 2019-04-11
//     [akzeptiert] => on
//     [nachname] => Wejwoda
//     [vorname] => Christian
//     [strasse] => Marx-Reichlich-Straße 3/2
//     [plz] => 5020
//     [ort] => Salzburg
//     [email] => christian@wejwoda.at
//     [farbe] => #000000
//     [deckblatt_text] => sdf asdgf g asd
//     [deckblatt_datei] => Array
//         (
//             [0] => 20180911_Überweisungbestätigung.pdf
//         )
//
//     [inhalt_datei] => Array
//         (
//             [0] => 90-18_Zahlungsbestätigung.pdf
//         )
//
// )
