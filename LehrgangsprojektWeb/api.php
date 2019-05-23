<?php
require_once "lib/setup.php";
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

//GET-Parameter aus REQUEST_URI entfernen
$request_uri_ohne_get = explode("?",$_SERVER["REQUEST_URI"])[0];
// aus Anfrage-URI die gewünschte Methode ermitteln
$teile = explode("/api/", $request_uri_ohne_get,2);
$parameter = explode("/", $teile[1]);

// leere Einträge aus dem Parameter-Array entfernen
foreach ($parameter as $key => $value) {
  if (empty($value)) {
    unset($parameter[$key]);
  } else {
    // alle Parameter in Kleinbuchstaben umwandeln, falls diese falsch daherkommen
    $parameter[$key] = mb_strtolower($parameter[$key]);
  }
}

// indizes neu zuordnen falls mit doppelten Schrägstrichen aufgerufen wird
$parameter = array_values($parameter);

if (empty($parameter)) {
  fehler("Es wurde keine Methode übergeben. Prüfen Sie den Aufruf.");
}

switch ($parameter[0]) {
  case 'preisspeichern':
    $ausgabe = array(
      "status" => 0,
      "result" => ""
    );
    if (empty($_POST)) {
    } else {
      $auftrag = new db_auftrag((int)$_POST["id"]);
      $auftrag->preis_fix = $_POST["preis_fix"];
      $auftrag->geprueft = $_POST["geprueft"];
      $auftrag->save();
      $ausgabe["status"] = 1;
    }
    echo json_encode($ausgabe);
    break;

  case 'auftragcalculated':
    $ausgabe = array(
      "status" => 0,
      "result" => ""
    );
    if (empty($parameter[1])) {
    } else {
      $auftrag = new db_auftrag((int)$parameter[1]);
      $auftrag = $auftrag->getRow();
      $calc = new db_calculation($auftrag);
      $calc->validieren();
      $auftrag["calc"] = $calc->get_answer();

      $ausgabe["status"] = 1;
      $ausgabe["result"] = $auftrag;
    }

    echo json_encode($ausgabe);
    break;

  case 'login':
    $ausgabe = array(
      "status" => 0,
      "result" => ""
    );
    if (!empty($_POST)) {
      $user = new db_benutzer("benutzername = ?," . $_POST["username"]);
      if (!empty($user)) {
        if (password_verify($_POST["password"],$user->passwort)) {
          $ausgabe["status"] = 1;
          $ausgabe["result"] = session_id();
        }
      }
    }
    echo json_encode($ausgabe);
    exit;
    break;

  case 'auftraege':
    // Liste alles Auftraege ausgeben
    $ausgabe = array(
      "status" => 1,
      "result" => array()
    );
    if (empty($parameter[1])) {
      $result = new db_auftraege();
      $ausgabe["result"][] =$result->getRows();
    } else {
      $result = new db_auftrag((int)$parameter[1]);
      $ausgabe["result"][] = $result->getRow();
    }
    echo json_encode($ausgabe);
    exit;
    break;

  case 'produkte':
    // Liste alles Produkte ausgeben
    $ausgabe = array(
      "status" => 1,
      "result" => array()
    );
    if (empty($parameter[1])) {
      $result = new db_produkte();
      $ausgabe["result"][] =$result->getRows();
    } else {
      $result = new db_produkt((int)$parameter[1]);
      $ausgabe["result"][] = $result->getRow();
    }
    echo json_encode($ausgabe);
    exit;
    break;

  case 'grammaturen':
    // Liste alles Grammaturen ausgeben
    $ausgabe = array(
      "status" => 1,
      "result" => array()
    );
    if (empty($parameter[1])) {
      $result = new db_gramaturen();
      $ausgabe["result"][] =$result->getRows();
    } else {
      $result = new db_gramatur((int)$parameter[1]);
      $ausgabe["result"][] = $result->getRow();
    }
    echo json_encode($ausgabe);
    exit;
    break;

  case 'zustelltypen':
    // Liste alles zustelltypen ausgeben
    $ausgabe = array(
      "status" => 1,
      "result" => array()
    );
    if (empty($parameter[1])) {
      $result = new db_zustelloptionen();
      $ausgabe["result"][] =$result->getRows();
    } else {
      $result = new db_zustelloption((int)$parameter[1]);
      $ausgabe["result"][] = $result->getRow();
    }
    echo json_encode($ausgabe);
    exit;
    break;

  default:
    // code...
    break;
}
