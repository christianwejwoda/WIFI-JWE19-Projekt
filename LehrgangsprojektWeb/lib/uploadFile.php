<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
require_once "setup.php";

if (!empty($_FILES)) {
  // Validierung
  // echo json_encode($_GET);
  // echo json_encode($_FILES);
  // die();

  if (empty($error)) {
    if (!empty($_FILES["file"]["tmp_name"]) && is_uploaded_file($_FILES["file"]["tmp_name"])) {
      $extension = "";
      if (strpos($_FILES["file"]["name"],".")>0) {
        $teile = explode(".",$_FILES["file"]["name"]);
        $extension = "." . mb_strtolower(array_pop($teile));
      }
      $dateiname = md5(microtime().mt_rand(0,1000000).$_FILES["file"]["name"]) .  $extension;

      move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/" . $dateiname );

      $d = array("session_id" => (empty($_GET["session_id"]) ? session_id() : $_GET["session_id"]),
      "upload_dateiname" => $dateiname,
      "org_dateiname" => $_FILES["file"]["name"]);
      $f = new db_uploaddatei($d);
      $f->save();
    }
  }
}
