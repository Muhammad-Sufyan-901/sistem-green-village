//* Reset Password Functions
    // Reset Password Store
    function reset_password_store()
    {
        $('form[id="resetPasswordForm"]').each(function(){
            $(this).validate({
                ignore: ".ignore",
                rules: {
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
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
                            $('#resetPasswordForm .btn-submit').html('Please wait...');
                            $('#resetPasswordForm .btn-submit').prop('disabled', true);
                        },
                        success: function(data) {
                            if(data.status == 'success'){                         
                                window.location.href = data.next;
                            }else{
                                $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                            }

                            $('#resetPasswordForm .btn-submit').html('Send Request');
                            $('#resetPasswordForm .btn-submit').prop('disabled', false);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#resetPasswordForm .btn-submit').html('Send Request');
                            $('#resetPasswordForm .btn-submit').prop('disabled', false);
                            $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
                        }
                    });
                    return false;
                },
            });
        });
    }
