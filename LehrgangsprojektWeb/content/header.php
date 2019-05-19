<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href ="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="css/jquery.fileupload.css">

    <title><?php echo htmlspecialchars($pagetitle) ?></title>
    <meta name"description" content="<?php echo htmlspecialchars($meta_discription); ?>" />

  </head>
  <body>

    <div class="header">
      <div class="container-fluid ">
        <div class="row bannerrow">
          <div class="col-12 header_companyname">
            <a href="home"><img src="img/logo.svg" alt="Logo <?php echo $companyname; ?>"></a>
            &nbsp;
            &nbsp;
            <a href="home" class="header_companyname_text1">
              <div class="header_companyname_text2">
                <?php echo $companyname; ?>
              </div>
            </a>
          </div>
        </div>

        <div class="row menurow">
          <div class="col-12 ">
            <?php
            // Navigation an dieser Stelle einbinden
            include "content/nav.php"
            ?>
          </div>
        </div>
      </div>
    </div>
