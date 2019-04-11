<?php
class db_gramaturen
{
  private $_suche;
  private $_suche_marken_id;
  private $_offset;
  private $_limit;

  // public function set_suche($suche, $suche_marken_id)
  // {
  //   $this->_suche = $suche;
  //   $this->_suche_marken_id = $suche_marken_id;
  // }

  public function limitieren($seite, $limit)
  {
    $this->_offset = (int)$seite * $limit - $limit;
    $this->_limit = (int)$limit;
  }

  public function get_count()
  {
    $platzhalter = array();
    $sql = "SELECT COUNT(1) FROM gramaturen " ;
    $this->build_where($sql,$platzhalter);

    $result = db_mysql::get_instanz()->query($sql, $platzhalter);
    $row = $result->fetch_row();
    return $row[0];

  }

  public function get()
  {
    $ret = array();
    $platzhalter = array();
    $sql = "SELECT * FROM gramaturen " ;
    $this->build_where($sql,$platzhalter);

    if ($this->_offset || $this->_limit) {
      $sql .= " LIMIT {$this->_offset},{$this->_limit} ";
    }

    $result = db_mysql::get_instanz()->query($sql, $platzhalter);
    while ($row = $result->fetch_assoc()) {
      $ret[] = new db_gramatur($row);
    }
    return $ret;
  }

  // das & bedeutet das Variablen als Referenz übergeben werden .
  // wenn diese verwendet werden, wird auch die Variablen
  // die beim aufruf verwendet weurde, verändert
  private function build_where(&$sql, &$platzhalter)
  {

    // if (!empty($this->_suche) || !empty($this->_suche_marken_id)) {
    //   $sql .= " WHERE (modell LIKE ? OR farbe LIKE ? OR fahrgestellnummer LIKE ?) ";
    //   $platzhalter[] = "%".$this->_suche."%";
    //   $platzhalter[] = "%".$this->_suche."%";
    //   $platzhalter[] = "%".$this->_suche."%";
    //
    //   if (!empty($this->_suche_marken_id)) {
    //     $sql .= " AND marken_id = ? ";
    //     $platzhalter[] = $this->_suche_marken_id;
    //   } else {
    //     //  $sql_in_marken = fdb_marken::get_idList_by_namepart($this->_suche);
    //     // if (!empty($sql_in_marken)) {
    //     //   $sql .= " OR marken_id IN ({$sql_in_marken})";
    //     // }
    //   }
    // }

  }

}
