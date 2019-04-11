<?php
/**
 *
 */
class db_mysql
{
  // Singleton Implementierung
  // Vermeidetr mehrfache erstellung des selben Objekts.
  // Hier gewünscht, um nicht mehrere Datenbankverbindungen zu öffnen
  private static $_instanz;

  public static function get_instanz()
  {
    if (!self::$_instanz) {
      self::$_instanz = new self();
    }
    return self::$_instanz;
  }
  // ENDE: Singleton Implementierung

  // enthält die Datenbankverbindung
  private $_db;

  // private damit nicht extern neue Objekte erstellt werden können
  private function __construct()
  {
    $this->verbinden();
  }

  public function verbinden()
  {
    // keine neue Verbindung machen wenn schon eine existiert
    if ($this->_db) return;

    // Verbindung zur mysql Datenbank aufbauen
    $this->_db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    // MySQL mitteilen, dass unsere Befehle als utf8 kommen
    $this->_db->set_charset("utf8");

  }

  // Befehl zur Datenbank senden  - Kurzform für mysqli_query
  function query($sql_befehl, array $values = array())
  {

    // SQL-Befehl in Statement-Objekt vorbereiten
    $stmt = $this->_db->prepare($sql_befehl);
    // wenn Statement = false, dann Fehelr ausgeben
    if(!$stmt) {
      echo $sql_befehl . "<br/>";
      die($this->_db->error);
    }

    // Werte aus dem Array einbinden wenn gegeben
    if ($values) {
      $stmt->bind_param(str_repeat("s", count($values)), ...$values);
    }

    // Query ausführen, Ergebnis holen und Statement schließen
    if(!$stmt->execute())
    {
      echo $sql_befehl . "<br/>";
      die($this->_db->error);
    }
    $answer = $stmt->get_result();
    $stmt->close();

    return $answer;

  }


  // Escape-Funktion um SQL-Injektions zu vermeiden
  // Daten von Formularen/Benutzer ($_GET oder $_POST)
  // IMMER !!! mit mysqli_real_escape_string behandeln,
  // bevor sie in Datenbank-Befehlen verwendet werden.
  function escape($input) {
    if (is_array($input)) {
      // nur für Arrays
      $answer = array();
      foreach ($input as $key => $value) {
        $answer[$key] = $this->escape($value);
      }
      return $answer;
    } else {
      // string, int, float, .....
      return $this->_db->real_escape_string($input);
    }
  }
}
