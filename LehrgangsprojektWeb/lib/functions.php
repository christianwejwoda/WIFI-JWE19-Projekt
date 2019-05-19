<?php
session_start();

spl_autoload_register(function($klasse)
{
  $pfad = str_replace('_','/',$klasse) . ".php";
  if (!file_exists ( $pfad )) {
    $pfad = "../" . $pfad;
  }
  require_once  $pfad;
});

function is_logged_in()
{
  if (empty($_SESSION["benutzer_id"])) {
    header("Location: login.php");
  }
}
