$('#btn-send').hide();
$('#preisanzeige').hide();
$('#abschluss').hide();

// Validation
// - produkt_id
// - favcolor
// - deckblatt_text
// - ein_zwei_seitig
// - seitenzahl
// - grammatur_id
// - randlos
// - fileupload
// - liefertermin

var json_produkt_id = "";
var json_ein_zwei_seitig = "";
var json_seitenzahl = "";
var json_grammatur_id = "";
var json_zustelloption_id = "";
var json_randlos = "";
var json_lieferdatum = "";
var json_einheiten = "";
var $deckblatttexteingabe_hidden = false;
var $deckblattfarbauswahl_hidden = false;

$('#btn-send').click(function() {
  if (check_all_sub() && check_part2_sub()) {
    var sendinfo = {
          session_id: $('#session_id').val(),
          produkt_id: json_produkt_id,
          ein_zwei_seitig: json_ein_zwei_seitig,
          grammatur_id: json_grammatur_id,
          randlos: json_randlos,
          seitenzahl: json_seitenzahl,
          einheiten: json_einheiten,
          zustelloption_id: json_zustelloption_id,
          lieferdatum: json_lieferdatum,
          akzeptiert: $('#akzeptiert').val(),
          nachname: $('#nachname').val(),
          vorname: $('#vorname').val(),
          strasse: $('#strasse').val(),
          plz: $('#plz').val(),
          ort: $('#ort').val(),
          email: $('#email').val(),
          farbe: $('#farbe').val(),
          deckblatt_text: $('#deckblatt_text').val(),
          deckblatt_datei: $('#deckblatt_datei')[0].files[0]["name"],
          inhalt_datei: $('#inhalt_datei')[0].files[0]["name"],
          price_per_page: $('#price_per_page_form').val(),
          price_add_randlos_add: $('#price_add_randlos_add_form').val(),
          price_add_cover_add: $('#price_add_cover_add_form').val(),
          price_delivery_add: $('#price_delivery_add_form').val(),
          produktionszeit: $('#produktionszeit_form').val()
    };

    $.ajax({
        type: "POST",
        url: "lib/auftragspeichern.php",
        dataType: "json",
        data: sendinfo,
        context: this,
        success: function (msg) {
            if (msg)
            {
              $('#printshop_form').submit();
            } else
            {
              alert("msg empty");
            }
        },
        error: function(msg) {
          $('#btn-send').html(msg.responseText);
        }
    });
  }

});

function check_all_sub()
{
  var ok = true;
  ok &= check_produkt_id();
  ok &= check_ein_zwei_seitig();
  ok &= check_grammatur_id();
  ok &= check_randlos();
  ok &= check_seitenzahl();
  ok &= check_einheiten();
  ok &= check_zustelloption_id();
  ok &= check_lieferdatum();
  return ok;
}
function check_all()
{
  $('#abschluss').hide();
  $('#akzeptiert').prop('checked',false);
  $('#akzeptiertLabel').removeClass("blinking");

  if (!check_all_sub())
  {
    $('#preisanzeige').hide();
  }
  else
  {
      $('#preisanzeige_fehler').html("");

       var sendInfo = {
               produkt_id: json_produkt_id,
               ein_zwei_seitig: json_ein_zwei_seitig,
               seitenzahl: json_seitenzahl,
               grammatur_id: json_grammatur_id,
               randlos: json_randlos,
               zustelloption_id: json_zustelloption_id,
               lieferdatum: json_lieferdatum,
               einheiten: json_einheiten
           };

           $.ajax({
               type: "POST",
               url: "lib/calculation.php",
               dataType: "json",
               data: sendInfo,
               context: this,
               success: function (msg) {
                   if (msg)
                   {
                     msg = msg["data"];
                     // preis1 --> Seitenpreis
                     // preis2 --> Aufpreis "randlos"
                     // preis3 --> Preis pro Einheit
                     // preis4 --> Preis für alle Einheiten
                     // einheiten --> Anzahl Einheiten
                     var p1 = parseFloat(msg["preis1"]);
                     var p2 = parseFloat(msg["preis2"]);
                     var p2add = parseFloat(msg["preis2add"]);
                     var p3 = parseFloat(msg["preis3"]);
                     var p3add = parseFloat(msg["preis3add"]);
                     var p4 = parseFloat(msg["preis4"]);
                     var p5 = parseFloat(msg["preis5"]);
                     var p5add = parseFloat(msg["preis5add"]);

                     $('#price_per_page_form').val(p1);
                     $('#price_add_randlos_add_form').val(p2add);
                     $('#price_add_cover_add_form').val(p3add);
                     $('#price_delivery_add_form').val(p5add);
                     $('#produktionszeit_form').val(parseFloat(msg["produktionszeit"]));

                     var disp_price_pages = "Druckkosten für " + json_seitenzahl + " Seiten";
                     if (json_ein_zwei_seitig == 2) {
                       disp_price_pages += " auf " + json_seitenzahl / 2 + " Blättern";
                     }
                     $('#price_per_page_display').html(disp_price_pages);
                     $('#price_per_page').html(p1.toFixed(2) + " &euro;");
                     if (isNaN(p2)) {
                       $('#price_add_randlos_group').hide();
                     } else {
                       $('#price_add_randlos_group').show();
                       $('#price_add_randlos_add').html(p2add.toFixed(2) + " &euro;");
                       $('#price_add_randlos').html(p2.toFixed(2) + " &euro;");
                     }
                     $('#price_add_cover_add').html(p3add.toFixed(2) + " &euro;");
                     $('#price_add_cover').html(p3.toFixed(2) + " &euro;");

                     $('#price_result').html(p4.toFixed(2) + " &euro;");
                     $('#price_result_label').html("Gesamtpreis für " + msg["einheiten"] + " Einheiten:");

                     if (p5 > 0) {
                       $('#price_delivery_label').html("+ " + msg["price_delivery_label"]);
                       $('#price_delivery_add').html(p5add.toFixed(2) + " &euro;");
                       $('#price_delivery').html(p5.toFixed(2) + " &euro;");
                       $('#price_delivery_group').show();
                     }
                     else {
                       $('#price_delivery_group').hide();
                     }

                     $('#preisanzeige').show();
                     window.scrollTo(0,document.body.scrollHeight);
                     $('#akzeptiertLabel').addClass("blinking");
                     // alert-info  blinking

                     if (msg["deckblattfarbauswahl"] == 1) {
                       $('#deckblattfarbauswahl').show();
                       $deckblattfarbauswahl_hidden = false;
                     } else {
                       $('#deckblattfarbauswahl').hide();
                       $deckblattfarbauswahl_hidden = true;
                     }

                     if (msg["deckblatttexteingabe"] == 1) {
                       $deckblatttexteingabe_hidden = false;
                       $('#deckblatttexteingabe').show();
                     } else {
                       $deckblatttexteingabe_hidden = true;
                       $('#deckblatttexteingabe').hide();
                     }

                     $('#produktionszeit').html(msg["produktionszeit"] + " Stunden");

                   } else
                   {
                     alert("msg empty");
                   }
               },
               error: function(msg) {
                 $('#preisanzeige_fehler').html(msg.responseText);
                 $('#preisanzeige').show();
               }
           });
  }
}

// check for produkt_id
$('#produkt_id').change(function() {
  check_all();
});
function check_produkt_id() {

  json_produkt_id = $('#produkt_id').val();

  var answer = $('#produkt_id').val() != "";
  if (answer) {
    $('#produkt_id_error')[0].textContent="";
  } else {
    $('#produkt_id_error')[0].textContent="Produkt fehlt";
  }
  return answer;
};

// check for ein_zwei_seitig
$('[name="ein_zwei_seitig"]').change(function() {
  check_all();
});
function check_ein_zwei_seitig() {

  var answer = 0;

  $.each($('[name="ein_zwei_seitig"]'), function(key, value) {
    if ($('[name="ein_zwei_seitig"]')[key].checked) {
      answer =$('[name="ein_zwei_seitig"]')[key].value;
    }
  });

    json_ein_zwei_seitig = answer;

  answer = answer > 0;

  if (answer > 0) {
    $('#ein_zwei_seitig_error')[0].textContent="";
  } else {
    $('#ein_zwei_seitig_error')[0].textContent="Option fehlt";
  }

  return answer;
};

// check for seitenzahl
$('[name="seitenzahl"]').change(function() {
  check_all();
});
function check_seitenzahl()
{
    var maxseiten = parseInt($('#seitenzahl').attr("max"));

    json_seitenzahl = parseInt($('#seitenzahl').val());

    var answer = json_seitenzahl >= 10 && json_seitenzahl <= maxseiten;
    if (answer) {
      $('#seitenzahl_error')[0].textContent="";
    } else {
      $('#seitenzahl_error')[0].textContent="Seitenzahl muss zwischen 10 und " + maxseiten + " betragen";
    }
    return answer;

};

// check for einheiten
$('[name="einheiten"]').change(function() {
  check_all();
});
function check_einheiten()
{

    json_einheiten = parseInt($('#einheiten').val());

    var answer = json_einheiten >= 1;
    if (answer) {
      $('#einheiten_error')[0].textContent="";
    } else {
      $('#einheiten_error')[0].textContent="Anzahl Einheiten muss mindestens 1 betragen";
    }
    return answer;

};

// check for grammatur_id
$('[name="grammatur_id"]').change(function() {
  check_all();
});
function check_grammatur_id() {

  var answer = 0;
  var maxseiten = 1000;

  $.each($('[name="grammatur_id"]'), function(key, value) {
    if ($('[name="grammatur_id"]')[key].checked) {
      ob = $('[name="grammatur_id"]')[key];
      answer = ob.value;
      maxseiten = parseInt(ob.attributes["data-maxseiten"].value);
    }
  });

  $('#seitenzahl_label').html("Seitenanzahl (min. 10 - max. " + maxseiten + ")");
  $('#seitenzahl').attr("max",maxseiten);
  json_grammatur_id = answer;
  answer = answer > 0;

  if (answer > 0) {
    $('#grammatur_id_error')[0].textContent="";
  } else {
    $('#grammatur_id_error')[0].textContent="Option fehlt";
  }

  return answer;
};

// check for zustelloption_id
$('[name="zustelloption_id"]').change(function() {
  check_all();
});
function check_zustelloption_id() {

  var answer = 0;

  $.each($('[name="zustelloption_id"]'), function(key, value) {
    if ($('[name="zustelloption_id"]')[key].checked) {
      ob = $('[name="zustelloption_id"]')[key];
      answer = ob.value;
    }
  });

  json_zustelloption_id = answer;
  answer = answer > 0;

  if (answer > 0) {
    $('#zustelloption_id_error')[0].textContent="";
  } else {
    $('#zustelloption_id_error')[0].textContent="Option fehlt";
  }

  return answer;
};

// check for randlos
$('[name="randlos"]').change(function() {
  check_all();
});
function check_randlos()
{

    json_randlos = $('#randlos').prop('checked');

    return true;

};
// check for lieferdatum
$('#lieferdatum').change(function() {
  check_all();
});
function check_lieferdatum() {
    var error_message = "";

    json_lieferdatum = $('#lieferdatum').val();

    var answer = $('#lieferdatum').val() != "";
    if (answer) {
      var minDate = new Date();
      minDate.setDate(minDate.getDate() + 10);

      var maxDate = new Date();
      maxDate.setDate(maxDate.getDate() + 10);
      maxDate.setMonth(maxDate.getMonth() + 6);

      var inputDate = new Date(json_lieferdatum);
      if (inputDate < minDate || inputDate > maxDate) {
        $('#lieferdatum_error')[0].textContent="Das gewünschte Lieferdatum liegt ausserhalb der erlauben Bereichs.";
        answer = false;
      } else {
        $('#lieferdatum_error')[0].textContent="";
      }
    } else {
      $('#lieferdatum_error')[0].textContent="gewünschtes Lieferdatum fehlt";
    }

  return answer;
};

$('#akzeptiert').change(function() {
  if ($(this).prop('checked')) {
    $('#abschluss').show();
    window.scrollTo(0,document.body.scrollHeight);
  } else {
    $('#abschluss').hide();
  }
});

// **********************************************
// ** Adresse und Druckdaten prüfen**************
// **********************************************
function check_part2_sub()
{
  var ok = true;
  ok &= check_favcolor();
  ok &= check_deckblatt_text();
  ok &= check_nachname();
  ok &= check_vorname();
  ok &= check_strasse();
  ok &= check_plz_ort();
  ok &= check_email();
  ok &= check_deckblatt_datei();
  ok &= check_inhalt_datei();

  if (ok) {
    $('#btn-send').show();
  } else {
    $('#btn-send').hide();
  }


  return ok;
}

// check for nachname
$('#nachname').change(function() {
  check_part2_sub();
});
function check_nachname() {
  var answer = $('#nachname').val() != "";
  if (answer) {
    $('#nachname_error')[0].textContent="";
  } else {
    $('#nachname_error')[0].textContent="Nachname darf nicht leer sein";
  }
  return answer;
};

// check for vorname
$('#vorname').change(function() {
  check_part2_sub();
});
function check_vorname() {
  var answer = $('#vorname').val() != "";
  if (answer) {
    $('#vorname_error')[0].textContent="";
  } else {
    $('#vorname_error')[0].textContent="Vorname darf nicht leer sein";
  }
  return answer;
};

// check for strasse
$('#strasse').change(function() {
  check_part2_sub();
});
function check_strasse() {
  var answer = $('#strasse').val() != "";
  if (answer) {
    $('#strasse_error')[0].textContent="";
  } else {
    $('#strasse_error')[0].textContent="Strasse darf nicht leer sein";
  }
  return answer;
};

// check for PLZ
$('#plz').change(function() {
  check_part2_sub();
});
// check for Ort
$('#ort').change(function() {
  check_part2_sub();
});
function check_plz_ort() {
  var answer_plz = $('#plz').val() != "";
  var answer_ort = $('#ort').val() != "";
  if (answer_plz && answer_ort) {
    $('#plzort_error')[0].textContent="";
  } else {
    $('#plzort_error')[0].textContent="PLZ und Ort dürfen nicht leer sein";
  }
  return (answer_plz && answer_ort);
};

// check for email
$('#email').change(function() {
  check_part2_sub();
});
function check_email() {
  var answer = $('#email').val() != "";
  if (answer) {
    $('#email_error')[0].textContent="";
  } else {
    $('#email_error')[0].textContent="E-Mail-Adresse darf nicht leer sein";
  }
  return answer;
};


// check for colorpicker
$('#farbe').change(function() {
  check_part2_sub();
});
function check_favcolor() {
  if ($deckblatttexteingabe_hidden) {
    var answer = true;
  } else {
    var answer = $('#farbe').val() != "";
    if (answer) {
      $('#farbe_error')[0].textContent="";
    } else {
      $('#farbe_error')[0].textContent="Farbe fehlt";
    }
  }
  return answer;
};

// check for deckblatt_text
$('#deckblatt_text').change(function() {
  check_part2_sub();
});
function check_deckblatt_text() {
  if ($deckblatttexteingabe_hidden) {
    var answer = true;
  } else {
    var answer = $('#deckblatt_text').val() != "";
    if (answer) {
      $('#deckblatt_text_error')[0].textContent="";
    } else {
      $('#deckblatt_text_error')[0].textContent="Text für das Deckblatt fehlt";
    }
  }
  return answer;
};

// check for deckblatt_datei
$('#deckblatt_datei').change(function() {
  check_part2_sub();
});
function check_deckblatt_datei() {
  var answer = $('#deckblatt_datei').val() != "";
  if (answer) {
    $('#deckblatt_datei_error')[0].textContent="";
    $('#deckblatt_datei_error').hide();
  } else {
    $('#deckblatt_datei_error')[0].textContent="Datei für das Deckblatt fehlt";
    $('#deckblatt_datei_error').show();
  }
  return answer;
};

// check for deckblatt_datei
$('#inhalt_datei').change(function() {
  check_part2_sub();
});
function check_inhalt_datei() {
  var answer = $('#inhalt_datei').val() != "";
  if (answer) {
    $('#inhalt_datei_error')[0].textContent="";
    $('#inhalt_datei_error').hide();
  } else {
    $('#inhalt_datei_error')[0].textContent="Datei für den Inhalt fehlt";
    $('#inhalt_datei_error').show();
  }
  return answer;
};
