<?php
require_once "setup.php";


// echo "<h3>Rohdaten</h3>";
// echo "<pre>";print_r($_POST);echo "</pre><br />";
// Array
// (
//     [product] => 3
//     [frontpageoption] => 1
//     [pageoption] => 2
//     [pagecount] => 19
//     [paper_weight] => 2
//     [borderless] => true
//     [deliverydate] => 27.03.2019
// )

if (!empty($_POST)) {

  $calc = new db_calculation($_POST);
  if ($calc->validieren())
  {
    $answer = $calc->get_answer();

    //  preis1 --> Seitenpreis
    //  preis2 --> Aufpreis "randlos"
    //  preis3 --> Preis pro Einheit
    //  preis4 --> Preis für alle Einheiten

    echo "<h3>Ergebnis</h3>";
    echo "<p>Preis pro Seite: &euro; " .  number_format($answer["preis1"],2) . "</p>";
    echo "<p>+ Aufschlag für randlosen Druck: &euro; " .  number_format($answer["preis2"],2) . "</p>";
    echo "<p>+ Basispreis für Cover: &euro; " .  number_format($answer["preis3"],2) . "</p>";
    echo "<p>Gesamt Preis für {$answer["units"]} Einheiten der ausgewählten Optionen beträgt: &euro; "  . number_format($answer["preis4"],2)."</p>" ;

  } else
  {
    $answers = $calc->errors();
    if (!empty($answers)) {
      echo "<ul>";
      foreach ($answers as $error) {
        echo "<li>{$error}</li>";
      }
      echo "</ul>";
    }
  }

}
