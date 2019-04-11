
// ok &= check_favcolor();
// ok &= check_frontpagetext();


// check for colorpicker
$('#favcolor').change(function() {
  check_favcolor();
});
function check_favcolor() {
  var answer = $('#favcolor').val() != "";
  if (answer) {
    $('#favcolor_error')[0].textContent="";
  } else {
    $('#favcolor_error')[0].textContent="Farbe fehlt";
  }
  return answer;
};

// check for frontpagetext
$('#frontpagetext').change(function() {
  check_frontpagetext();
});
function check_frontpagetext() {
  var answer = $('#frontpagetext').val() != "";
  if (answer) {
    $('#frontpagetext_error')[0].textContent="";
  } else {
    $('#frontpagetext_error')[0].textContent="Text für das Deckblatt fehlt";
  }
  return answer;
};

$(document).ready(function() {
  var date_input = $('input[id="deliverydate"]'); //our date input has the name "date"
  var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
  var options = {
    format: 'dd.mm.yyyy',
    startDate: '+10d',
    endDate: '+3m',
    container: container,
    todayHighlight: true,
    autoclose: true,
  };
  date_input.datepicker(options);
});

/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = 'files/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
