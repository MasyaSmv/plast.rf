$(document).ready(function(){
    $("#form-file-ajax").on('submit', function(e){
      e.preventDefault();
      var formData = new FormData();
      var form = $(this);
      formData.append('file', $('#file').prop("files")[0]);
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        processData: false,
        contentType: false,
        cache:false,
        dataType : 'text',
        data: formData,
        // Будет вызвана перед осуществлением AJAX запроса
        beforeSend: function(){
          $('#process').fadeIn();
        },
        // будет вызвана после завершения ajax-запроса
        // (вызывается позднее функций-обработчиков успешного (success) или аварийного (error)
        complete: function () {
          $('#process').fadeOut();
        },
        success: function(data){
          //form[0].reset();
          data = JSON.parse(data);
          var image = '<div class="img-item"><img src="http://site.com/upload/'+data.file+'" width="400"></div>';
          var photoContent = $("#photo-content");
          photoContent.html('');
          photoContent.append(image);
        },
        error: function(data){
          console.log(data);
        }
      });
    });
  });
