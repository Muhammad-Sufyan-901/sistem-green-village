//* Edit Profile Functions
    // Update
    function update_profile()
    {
      $('form[id="editForm"]').each(function(){
        $(this).validate({
          ignore: ".ignore",
          rules: {
            fullname: 'required',
            phone_number: 'required'
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
                }else{
                  $('#editForm .btn-submit').html('Submit');
                  $('#editForm .btn-submit').prop('disabled', false);
                  $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                $('#editForm .btn-submit').html('Submit');
                $('#editForm .btn-submit').prop('disabled', false);
                $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
              }
            });
            return false;                  
          },
        });
      });
    }