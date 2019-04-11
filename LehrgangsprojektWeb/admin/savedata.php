<?php
require_once "../setup.php";

if (!empty($_POST)) {

  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
  echo "<br>";

  $_SESSION["save_error"] = "";
  
  $ar_grammatur = array();
  foreach ($_POST as $key => $value) {
    if (mb_strpos($key,"produkt_") !== false) {
      $fieldname = mb_substr($key,mb_strlen("produkt_"));
      $id = substr($fieldname,0,mb_strpos($fieldname,"_"));
      echo $id . "<br />";
      $fieldname = mb_substr($fieldname,mb_strpos($fieldname,"_") + 1);
      $val = str_ireplace(",",".", mysqli_real_escape_string($db, $value));

      $ar_grammatur_detail = array();
      if (!empty($ar_grammatur[$id])) {
        $ar_grammatur[$id][$fieldname]=$val;
      } else {
        $ar_grammatur[$id] = array($fieldname => $val);
      }
    }
  }
  foreach ($ar_grammatur as $key => $value) {
    if ($key == "neu") {
      if ($value["titel"] > 0) {
        $test = mysqli_query($db, "SELECT * FROM produkte WHERE titel = '{$value["titel"]}';") or die(mysqli_error($db));
        $test = mysqli_fetch_array($test);
        if (empty($test)) {
          mysqli_query($db, "INSERT INTO produkte SET titel = '{$value["titel"]}', preis = replace('{$value["preis"]}',',','.');") or die(mysqli_error($db));
        } else {
          $_SESSION["save_error"] = "Der Produktitel muss eindeutig sein!";
        }
      }
    } else {
      $test = mysqli_query($db, "SELECT * FROM produkte WHERE titel = '{$value["titel"]}' AND id != {$key};") or die(mysqli_error($db));
      $test = mysqli_fetch_array($test);
      if (empty($test)) {
        mysqli_query($db, "UPDATE produkte SET titel = '{$value["titel"]}', preis = replace('{$value["preis"]}',',','.') WHERE id = {$key};") or die(mysqli_error($db));
      } else {
        $_SESSION["save_error"] = "Der Produktitel muss eindeutig sein!";
      }
    }
  }

  // Eintrag für neuens Grammatur prüfen.
  // dieser darf nicht schon Mail vorkommen!
  $ar_grammatur = array();
  foreach ($_POST as $key => $value) {
    if (mb_strpos($key,"grammatur_") !== false) {
      $fieldname = mb_substr($key,mb_strlen("grammatur_"));
      $id = substr($fieldname,0,mb_strpos($fieldname,"_"));
      echo $id . "<br />";
      $fieldname = mb_substr($fieldname,mb_strpos($fieldname,"_") + 1);
      $val = str_ireplace(",",".", mysqli_real_escape_string($db, $value));

      $ar_grammatur_detail = array();
      if (!empty($ar_grammatur[$id])) {
        $ar_grammatur[$id][$fieldname]=$val;
      } else {
        $ar_grammatur[$id] = array($fieldname => $val);
      }
    }
  }
  foreach ($ar_grammatur as $key => $value) {
    if ($key == "neu") {
      if ($value["gramm_m2"] > 0) {
        $test = mysqli_query($db, "SELECT * FROM gramaturen WHERE gramm_m2 = '{$value["gramm_m2"]}';") or die(mysqli_error($db));
        $test = mysqli_fetch_array($test);
        if (empty($test)) {
          mysqli_query($db, "INSERT INTO gramaturen SET gramm_m2 = '{$value["gramm_m2"]}', preis_blatt = replace('{$value["preis_blatt"]}',',','.'), preis_druckseite = replace('{$value["preis_druckseite"]}',',','.');") or die(mysqli_error($db));
        } else {
          $_SESSION["save_error"] = "Die Grammatur (g/m²) muss eindeutig sein!";
        }
      }
    } else {
      $test = mysqli_query($db, "SELECT * FROM gramaturen WHERE gramm_m2 = '{$value["gramm_m2"]}' AND id != {$key};") or die(mysqli_error($db));
      $test = mysqli_fetch_array($test);
      if (empty($test)) {
        mysqli_query($db, "UPDATE gramaturen SET gramm_m2 = '{$value["gramm_m2"]}', preis_blatt = replace('{$value["preis_blatt"]}',',','.'), preis_druckseite = replace('{$value["preis_druckseite"]}',',','.') WHERE id = {$key};") or die(mysqli_error($db));
      } else {
        $_SESSION["save_error"] = "Die Grammatur (g/m²) muss eindeutig sein!";
      }
    }
  }
      // echo "<pre>";
      // print_r($ar_grammatur);
      // echo "</pre>";
      // echo "<br>";
      // exit;

      // $save_ok = true;
      // if ($fieldname == "gramm_m2") {
      //   $test = mysqli_query($db, "SELECT * FROM gramaturen WHERE gramm_m2 = '{$val}';") or die(mysqli_error($db));
      //   $test = mysqli_fetch_array($test);
      //   if (!empty($test)) {
      //     $save_ok = false;
      //   }
      // }
      //
      // if ($save_ok) {
      //   if ($id == "neu") {
      //     mysqli_query($db, "INSERT INTO gramaturen SET wert = '{$grammturNeu}';") or die(mysqli_error($db));
      //   } else
      //   {
      //     mysqli_query($db, "UPDATE gramaturen SET {$fieldname} = '{$val}';") or die(mysqli_error($db));
      //   }
      // } else {
      //   $_SESSION["save_error"] = "Der Grammtur muss eindeutig sein!";
      // }

}
header("Location: " . $_SESSION["calling_page"]);
// header("Location: " . $_SESSION["calling_page"] . ".php");

 ?>
