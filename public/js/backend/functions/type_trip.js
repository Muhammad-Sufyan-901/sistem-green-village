//* Type Trip Functions
  // Store
  function type_trip_store()
  {
    $('form[id="addForm"]').each(function(){
      $(this).validate({
        ignore: ".ignore",
        rules: {
          name: 'required'
        },
        errorPlacement: function(error, element) {
          var elementName = element.attr("base_error");
          error.appendTo("#"+elementName);
        },
        submitHandler: function(form) {
          $.ajax({
            url: form.action,
            type: form.method,
            data: new FormData(form),
            contentType: false,
            processData: false,
            beforeSend: function() {
              $('#addForm .btn-submit').html('Please wait...');
              $('#addForm .btn-submit').prop('disabled', true);
            },
            success: function(data) {
              if(data.status == 'success'){
                $('.alert-message-box').html('<div class="alert alert-success">'+data.message+'</div>');
                setInterval(function() { window.location.href = data.next; }, 1500);
                $("html, body").animate({ scrollTop: 0 }, "slow");
              }else{
                $('#addForm .btn-submit').html('Submit');
                $('#addForm .btn-submit').prop('disabled', false);
                $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                $("html, body").animate({ scrollTop: 0 }, "slow");
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              $('#addForm .btn-submit').html('Submit');
              $('#addForm .btn-submit').prop('disabled', false);
              $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
              $("html, body").animate({ scrollTop: 0 }, "slow");
            }
          });
          return false;                  
        },
      });
    });
  }
  // Update
  function type_trip_update()
  {
    $('form[id="editForm"]').each(function(){
      $(this).validate({
        ignore: ".ignore",
        rules: {
          name: 'required'
        },
        errorPlacement: function(error, element) {
          var elementName = element.attr("base_error");
          error.appendTo("#"+elementName);
        },
        submitHandler: function(form) {
          $.ajax({
            url: form.action,
            type: form.method,
            data: new FormData(form),
            contentType: false,
            processData: false,
            beforeSend: function() {
              $('#editForm .btn-submit').html('Please wait...');
              $('#editForm .btn-submit').prop('disabled', true);
            },
            success: function(data) {
              if(data.status == 'success'){
                $('.alert-message-box').html('<div class="alert alert-success">'+data.message+'</div>');
                setInterval(function() { window.location.href = data.next; }, 1500);
                $("html, body").animate({ scrollTop: 0 }, "slow");
              }else{
                $('#editForm .btn-submit').html('Submit');
                $('#editForm .btn-submit').prop('disabled', false);
                $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                $("html, body").animate({ scrollTop: 0 }, "slow");
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              $('#editForm .btn-submit').html('Submit');
              $('#editForm .btn-submit').prop('disabled', false);
              $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
              $("html, body").animate({ scrollTop: 0 }, "slow");
            }
          });
          return false;                  
        },
      });
    });
  }