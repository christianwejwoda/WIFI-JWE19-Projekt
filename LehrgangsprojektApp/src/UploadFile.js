import $ from "jquery";
// var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

class UploadFile {
  static upload(session_id, file) {
  // var progressBar = $('#progressBar_' + $(this)[0].id);
  // var bar = $('#bar_' + $(this)[0].id)
  // var percent = $('#percent_' + $(this)[0].id);

  var prop = file;
  var file_name = prop.name;
  var file_ext = file_name.split('.').pop().toLowerCase();
  if (file_ext === 'pdf') {
    // var file_size = prop.size;
    // if (file_size > 2000000) {
        // file too big
    // } else
     // {
      var form_data = new FormData();
      // prop.session_id=session_id;
      // form_data.append("session_id", session_id);
      form_data.append("file", prop);
      $.ajax({
        url:"https://192.168.72.107/LehrgangsprojektWeb/uploadFile.php?session_id=" + session_id,
        data:form_data,
        method:"POST",
        contentType:false,
        processData:false,
        cache:false,
        beforeSend:function(){
          // progressBar.fadeIn();
          //         var percentVal = '0%';
          //         bar.width(percentVal)
          //         percent.html(percentVal);
        },
        xhr: function(){
          var xhr = new window.XMLHttpRequest();
          // Handle progress
          //Upload progress
          xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
              // var percentComplete =  Math.ceil(evt.loaded / evt.total * 100);
              //Do something with upload progress
              // console.log(percentComplete);
              // var percentVal = percentComplete + '%';
              // bar.width(percentVal)
              // percent.html(percentVal);
            }
          }, false);

          return xhr;
        },
        success:function(data){
          // console.log(data);
          // $('#inhalt_datei_error').html(data);
        }
        // ,
        // fail:function(data){
        //   $('#inhalt_datei_error').html(data);
        // },
        // error:function(data){
        //   $('#inhalt_datei_error').html(data);
        // }
      })
    }

  }
}

export default (UploadFile);
