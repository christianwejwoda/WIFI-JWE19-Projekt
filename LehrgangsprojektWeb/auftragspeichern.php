<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

require_once "setup.php";

if (!empty($_POST)) {
  $calc = new db_auftragspeichern($_POST);
  $calc->validieren();
  echo json_encode($calc->save());
  session_regenerate_id(true);
} else
{
  echo null;
}
