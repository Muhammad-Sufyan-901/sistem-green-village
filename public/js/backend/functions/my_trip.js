//* My Trip Functions
  // Init
  function my_trip_init()
  {
    // Select status change function
    $(document).on('change', 'select[name=status]', function(){
      var val = $(this).val();

      if(val == 'done')
      {
        // Show additional form
        $('.status-done-additional-form').show();
        // Add validation
        $("input[name=return_time]").rules("add", {
          required: true
        });
      }
      else
      {
        // Hide additional form
        $('.status-done-additional-form').hide();
        // Remove validation
        $("input[name=return_time]").rules("remove", "required");
      }
    });
  }
  // Update
  function my_trip_update()
  {
    $('form[id="editForm"]').each(function(){
      $(this).validate({
        ignore: ".ignore",
        rules: {
          name: 'required',
          select_driver: 'required',
          itinerary: 'required',
          from_date: 'required',
          until_date: 'required',
          departure_time: 'required'
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