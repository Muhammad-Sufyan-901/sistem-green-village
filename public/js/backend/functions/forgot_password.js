//* Forgot Password Functions
    // Forgot Password Store
    function forgot_password_store()
    {
        $('form[id="forgotPasswordForm"]').each(function(){
            $(this).validate({
                ignore: ".ignore",
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 150
                    }
                },
                errorPlacement: function(error, element) {
                    var elementName = element.attr("base_error");
                    error.appendTo("#"+elementName);
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#forgotPasswordForm .btn-submit').html('Please wait...');
                            $('#forgotPasswordForm .btn-submit').prop('disabled', true);
                        },
                        success: function(data) {
                            if(data.status == 'success'){                         
                                $('#registerForm input[type="text"]').val('');       
                                $('.alert-message-box').html('<div class="alert alert-success">'+data.message+'</div>');
                            }else{
                                $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                            }

                            $('#forgotPasswordForm .btn-submit').html('Send Request');
                            $('#forgotPasswordForm .btn-submit').prop('disabled', false);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#forgotPasswordForm .btn-submit').html('Send Request');
                            $('#forgotPasswordForm .btn-submit').prop('disabled', false);
                            $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
                        }
                    });
                    return false;
                },
            });
        });
    }
