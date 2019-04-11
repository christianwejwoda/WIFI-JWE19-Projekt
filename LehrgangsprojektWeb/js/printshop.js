$('#btn-send').hide();


// Validation
// - product
// - favcolor
// - frontpagetext
// - pageoption
// - pagecount
// - paper-weight
// - borderless
// - fileupload
// - liefertermin

var json_product = "";
var json_frontpageoption = "";
var json_pageoption = "";
var json_pagecount = "";
var json_paper_weight = "";
var json_borderless = "";
var json_deliverydate = "";
var json_units = "";

$('#btn-send').click(function() {
  var ok = true;
  ok &= check_product();
  ok &= check_frontpageoption();
  ok &= check_pageoption();
  ok &= check_pagecount();
  ok &= check_paperweight();
  ok &= check_borderless();
  ok &= check_deliverydate();
  ok &= check_units();

  if (ok) {
    $('#printshop_form').submit();
  }

});

function check_all()
{
  var ok = true;
  ok &= check_product();
  ok &= check_frontpageoption();
  ok &= check_pageoption();
  ok &= check_pagecount();
  ok &= check_paperweight();
  ok &= check_borderless();
  ok &= check_deliverydate();
  ok &= check_units();

  if (ok) {
    $('#btn-send').show();
    // $.post( "calculation.php", { name: "John", time: "2pm" } ).done(function(e){
    //   $("#preisanzeige").load(e);
    // })
    // ;

       var sendInfo = {
               product: json_product,
               frontpageoption: json_frontpageoption,
               pageoption: json_pageoption,
               pagecount: json_pagecount,
               paper_weight: json_paper_weight,
               borderless: json_borderless,
               deliverydate: json_deliverydate,
               units: json_units
           };

           $.ajax({
               type: "POST",
               url: "calculation.php",
               dataType: "html",
               data: sendInfo,
               success: function (msg) {
                   if (msg)
                   {
                     $('#preisanzeige').html( msg );
                   } else
                   {
                     alert("msg empty");
                   }
               }
           });


  }

}

// check for product
$('#product').change(function() {
  // check_product();
  check_all();
});
function check_product() {

  json_product = $('#product').val();

  var answer = $('#product').val() != "";
  if (answer) {
    $('#product_error')[0].textContent="";
  } else {
    $('#product_error')[0].textContent="Produkt fehlt";
  }
  return answer;
};

// check for frontpageoption
$('[name="frontpageoption"]').change(function() {
  // check_frontpageoption();
  check_all();
});
function check_frontpageoption() {

  var answer = 0;

  $.each($('[name="frontpageoption"]'), function(key, value) {
    if ($('[name="frontpageoption"]')[key].checked) {
      answer =$('[name="frontpageoption"]')[key].value;
    }
  });

    json_frontpageoption = answer;

  answer = answer > 0;

  if (answer > 0) {
    $('#frontpageoption_error')[0].textContent="";
  } else {
    $('#frontpageoption_error')[0].textContent="Option für Deckblatt fehlt";
  }

  return answer;
};

// check for pageoption
$('[name="pageoption"]').change(function() {
  // check_pageoption();
  check_all();
});
function check_pageoption() {

  var answer = 0;

  $.each($('[name="pageoption"]'), function(key, value) {
    if ($('[name="pageoption"]')[key].checked) {
      answer =$('[name="pageoption"]')[key].value;
    }
  });

    json_pageoption = answer;

  answer = answer > 0;

  if (answer > 0) {
    $('#pageoption_error')[0].textContent="";
  } else {
    $('#pageoption_error')[0].textContent="Option fehlt";
  }

  return answer;
};

// check for pagecount
$('[name="pagecount"]').change(function() {
  check_all();
});
function check_pagecount()
{

    json_pagecount = parseInt($('#pagecount').val());

    var answer = json_pagecount >= 10;
    if (answer) {
      $('#pagecount_error')[0].textContent="";
    } else {
      $('#pagecount_error')[0].textContent="Seitenzahl muss mindestens 10 betragen";
    }
    return answer;

};

// check for units
$('[name="units"]').change(function() {
  check_all();
});
function check_units()
{

    json_units = parseInt($('#units').val());

    var answer = json_units >= 1;
    if (answer) {
      $('#units_error')[0].textContent="";
    } else {
      $('#units_error')[0].textContent="Anzahl Einheiten muss mindestens 1 betragen";
    }
    return answer;

};

// check for paper-weight
$('[name="paper-weight"]').change(function() {
  check_all();
});
function check_paperweight() {

  var answer = 0;

  $.each($('[name="paper-weight"]'), function(key, value) {
    if ($('[name="paper-weight"]')[key].checked) {
      answer =$('[name="paper-weight"]')[key].value;
    }
  });

    json_paper_weight=answer;

  answer = answer > 0;

  if (answer > 0) {
    $('#paper-weight_error')[0].textContent="";
  } else {
    $('#paper-weight_error')[0].textContent="Option fehlt";
  }

  return answer;
};

// check for borderless
$('[name="borderless"]').change(function() {
  check_all();
});
function check_borderless()
{

    json_borderless = $('#borderless').prop('checked');

    return true;

};
// check for deliverydate
$('#deliverydate').change(function() {
  // check_deliverydate();
  check_all();
});
function check_deliverydate() {

    json_deliverydate = $('#deliverydate').val();

  var answer = $('#deliverydate').val() != "";
  if (answer) {
    $('#deliverydate_error')[0].textContent="";
  } else {
    $('#deliverydate_error')[0].textContent="gewünschtes Lieferdatum fehlt";
  }
  return answer;
};
