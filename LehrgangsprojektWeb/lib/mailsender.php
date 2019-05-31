<?php

class lib_mailsender {

  protected $_daten;

  public function __construct($daten)
  {
    $this->_daten = $daten;
  }

  public function send ($auch_an_kunde_senden = 0) {


    // mehrere Empfänger
    if ($auch_an_kunde_senden == 1) {
      $empfaenger  = $this->_daten["vorname"] . " " . $this->_daten["nachname"] . " <" . $this->_daten["email"] . ">"; // beachte das Komma zum trennen von Empfängern
    } else {
      $empfaenger  = (new db_admins())->get();// 'Christian Wejwoda <christian@wejwoda.at>'; // beachte das Komma zum trennen von Empfängern
    }

    // Betreff
    $betreff = 'Anfrage Druckhaus';

    // Nachricht
    $nachricht = '
    <html>
      <head>
        <title>Anfrage Druckhaus</title>
      </head>
      <body>
        <p>Anfrage Druckhaus</p>
        <table>
          <tr>
            <th>Feld</th> <th>Wert</th>
          </tr>
          ';
          foreach ($this->_daten as $key => $value) {
            $local_key = $key;
            $local_value = htmlspecialchars($value);

            switch ($key) {
              case 'session_id':
              case 'deckblatt_datei':
              case 'inhalt_datei':
                continue 2;
                break;

              case 'produkt_id':
                $cur = new db_produkt((int)$local_value);
                $local_value = $cur->titel;
                $local_key = "Produkt";
                break;

              case 'ein_zwei_seitig':
                if ((int)$local_value == 1) {
                  $local_value = "einseitig";
                } else {
                  $local_value = "beidseitig";
                }
                $local_key = "Seitenoption";
                break;

              case 'grammatur_id':
                $cur = new db_gramatur((int)$local_value);
                $local_value = $cur->gramm_m2 ;
                $local_key = htmlspecialchars("Grammatur g/m²");
                break;

              case 'zustelloption_id':
                $cur = new db_zustelloption((int)$local_value);
                $local_value = $cur->titel ;
                $local_key = "Zustelloption";
                break;

            }

            $nachricht .= '
              <tr>
                <td>'.$local_key.'</td> <td>'.$local_value.'</td>
              </tr>';
          }
          $nachricht .= '
        </table>
      </body>
    </html>
    ';
    // echo $nachricht;

    // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
    $header[] = 'MIME-Version: 1.0';
    $header[] = 'Content-type: text/html; charset=utf-8';//=iso-8859-1';

    // zusätzliche Header
    if ($auch_an_kunde_senden == 1) {
      $header[] = 'Cc: ' . (new db_admins())->get();//Christian Wejwoda <christian@wejwoda.at>';
    }
    $header[] = 'From: ' . (new db_admins())->get();//Christian Wejwoda <christian@wejwoda.at>';
    // $header[] = 'Cc: geburtstagsarchiv@example.com';
    // $header[] = 'Bcc: geburtstagscheck@example.com';

    // verschicke die E-Mail
    mail($empfaenger, $betreff, $nachricht, implode("\r\n", $header));
  }
}
