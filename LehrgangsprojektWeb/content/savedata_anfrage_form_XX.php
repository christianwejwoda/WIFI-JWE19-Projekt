<?php

session_start();
$_SESSION["anfrage_form_data"] = $_POST;
header("Location: anfrage_form_saved");

 ?>
