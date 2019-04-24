<?php
require_once "setup.php";

if (!empty($_POST)) {
  $calc = new db_calculation($_POST);
  $calc->validieren();
  echo json_encode($calc->get_answer());
} else
{
  echo null;
}
