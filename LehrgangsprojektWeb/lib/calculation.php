<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

require_once "../setup.php";

if (!empty($_POST)) {
  $calc = new db_calculation($_POST);
  $calc->validieren();
  $answer = array();
  $answer["session_id"] = session_id();
  $answer["data"] = $calc->get_answer();
  echo json_encode($answer);
} else {
  echo null;
}
