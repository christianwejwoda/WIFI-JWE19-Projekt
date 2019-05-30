<?php

$errors = array();
$allGood = false;

if (!empty($_POST)) {

  if (empty($_POST["name"])) {
    $errors[] = "bitte den Namen ausfüllen";
  }
  if (empty($_POST["email"])) {
    $errors[] = "bitte die E-Mail-Adresse ausfüllen";
  }
  if (empty($_POST["message"])) {
    $errors[] = "bitte die Nachricht ausfüllen";
  }
  if (empty($errors)) {
    $allGood = true;

    $empfaenger  = 'Christian Wejwoda <christian@wejwoda.at>';
    $header[] = 'From: Christian Wejwoda <christian@wejwoda.at>';
    $header[] = 'Cc: '. $_POST["name"] . '<' . $_POST["email"] . '>';
    $nachricht = $_POST["message"];
    $betreff = 'das Druckhaus - Kontaktformular';

    mail($empfaenger, $betreff, $nachricht, implode("\r\n", $header));
  ?>

    <div class="container paper rounded p-4 mt-4">
      <div class="row justify-content-md-center">
        <h2>Kontakt</h2>
      </div>
      <div class="row justify-content-md-center">
        <p>Ihre Nachricht wurde abgeschickt.</p>
      </div>
    </div>

    <?php
  }
}

if (!$allGood) {
?>
<form class="form-horizontal container paper rounded p-4 mt-4" action="<?php echo basename(__FILE__, '.php'); ?>" method="post">
  <fieldset>
    <legend class="text-center">Kontakt</legend>

<?php
if (!empty($errors)) {
  echo "<ul>";
  foreach ($errors as $value) {
    echo "<li>" . $value . "</li>";
  }
  echo "</ul>";
}
 ?>

    <!-- Name input-->
    <div class="form-group row">
      <label class="col-12 col-md-2 control-label" for="name">Name</label>
      <div class="col-12 col-md-9">
        <input id="name" name="name" type="text" placeholder="Name" class="form-control" value="<?php
        if (!empty($_POST["name"])) {
           echo htmlspecialchars($_POST["name"]);
        } ?>">
      </div>
    </div>

    <!-- Email input-->
    <div class="form-group row">
      <label class="col-12 col-md-2 control-label" for="email">E-Mail Adresse</label>
      <div class="col-12 col-md-9">
        <input id="email" name="email" type="text" placeholder="E-Mail Adresse" class="form-control" value="<?php
        if (!empty($_POST["email"])) {
           echo htmlspecialchars($_POST["email"]);
        }
         ?>">
      </div>
    </div>

    <!-- Message body -->
    <div class="form-group row">
      <label class="col-12 col-md-2 control-label" for="message">Ihre Nachricht</label>
      <div class="col-12 col-md-9">
        <textarea class="form-control" id="message" name="message" placeholder="Bitte geben Sie Ihre Nachricht hier ein..." rows="5"><?php
        if (!empty($_POST["message"])) {
          echo htmlspecialchars($_POST["message"]);
        }
        ?></textarea>
      </div>
    </div>

    <!-- Form actions -->
    <div class="form-group row">
      <div class="col-12 col-md-11 text-right">
        <button type="submit" class="btn btn-primary btn-lg">senden</button>
      </div>
    </div>
  </fieldset>
</form>

<?php
}
?>
