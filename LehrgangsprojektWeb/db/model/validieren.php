<?php
class fdb_validieren
{
    private $_errors = array();

    // https://www.phpdoc.org/

    /**
     * Prüft ob ein Wert (aus Formular) ausgefüllt ist.
     * (Mehzeilige Detailsbeschreibung hier wenn erwünscht)
     * @param string $wert Der Wert der auf "ausgefüllt" geprüft werden soll.
     * @param string $feldname Name des Formularfeldes für die Fehlermeldung.
     * @return bool False wenn der Wert leer ist, ansonsten true.
     */
    public function ist_ausgefuellt($wert, $feldname)
    {
        if (empty($wert)) {
          $this->_errors[] = "Bitte füllen Sie das Feld '{$feldname}' aus.";
          return false;
        }
        return true;
    }
    // 1234567890 ABCDEFGH JKLMN P RSTUVWXYZ
    public function fin($wert, $feldname)
    {
      if (strlen($wert) != 17 || preg_match("/[^0-9a-hj-npr-z]/i", $wert)) {
        $this->_errors[] = "Das Feld {$feldname} muss genau 17 Zeichen lang sein. Erlaubte Zeichen sind: 0-9 dun A-Z außer IOQ.";
        return false;
      }
      return true;

    }

    public function fehler_eintragen($fehlertext)
    {
      $this->_errors[] = $fehlertext;
    }

    public function alles_ok()
    {
      return empty($this->_errors);
    }

    public function fehler_html()
    {
      if ($this->alles_ok()) return "";

      $answer = "<ul>";
      foreach ($this->_errors as $value) {
        $answer .= "<li>{$value}</li>";
      }
      $answer .= "</ul>";
      return $answer;
    }


}
