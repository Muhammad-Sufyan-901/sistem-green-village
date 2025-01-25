//* Payment Request Functions
  // Init
  function payment_request_init()
  {
    // Select status change function
    $(document).on('change', 'select[name=status]', function(){
      var val = $(this).val();

      // Default
        // Hide additional form
        $('.status-done-additional-form').hide();
        $('.status-cancel-additional-form').hide();
        // Remove validation
        $("textarea[name=reason]").rules("remove", "required");
        $("input[name=payment_proof]").rules("remove", "required");
        $("input[name=total_payment_rates]").rules("remove", "required");

      if(val == 'done')
      {
        // Show additional form
        $('.status-done-additional-form').show();
        // Add validation
        if($('.global-variable').attr('already-payment-proof') == false)
        {
          $("input[name=payment_proof]").rules("add", {
            required: true
          });
        }
        $("input[name=total_payment_rates]").rules("add", {
          required: true
        });
      }
      else if(val == 'cancel')
      {
        // Show additional form
        $('.status-cancel-additional-form').show();
        // Add validation
        $("textarea[name=reason]").rules("add", {
          required: true
        });
      }
    });
  }
  // Store
  function payment_request_store()
  {
    $('form[id="addForm"]').each(function(){
      $(this).validate({
        ignore: ".ignore",
        rules: {
          select_trip: 'required',
          total_rates_amount: 'required'
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

    // Additional rules
    $("input[name^=proofs]").each(function(index, value){
      $(this).rules("add", {
        required: true
      });   
    });
  }
  // Update
  function payment_request_update()
  {
    $('form[id="editForm"]').each(function(){
      $(this).validate({
        ignore: ".ignore",
        rules: {
          select_trip: 'required',
          total_rates_amount: 'required'
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