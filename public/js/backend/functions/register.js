//* Register Functions
    // Register Store
    function register_store()
    {
        $('form[id="registerForm"]').each(function(){
            $(this).validate({
                ignore: ".ignore",
                rules: {
                    fullname: 'required',
                    email: {
                        required: true,
                        email: true,
                        maxlength: 150
                    },
                    phone: 'required',
                    password: {
                        required: true,
                        minlength: 4
                    },
                    confirm_password: {
                        required: true,
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
                            $('#registerForm .btn-submit').html('Please wait...');
                            $('#registerForm .btn-submit').prop('disabled', true);
                        },
                        success: function(data) {
                            if(data.status == 'success'){
                                $('#registerForm .btn-submit').html('Sign up');
                                $('#registerForm .btn-submit').prop('disabled', false);
                                $('#registerForm input[type="text"]').val('');
                                $('#registerForm input[type="password"]').val('');
                                $('.alert-message-box').html('<div class="alert alert-success">'+data.message+'</div>');
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                            }else{
                                $('#registerForm .btn-submit').html('Sign up');
                                $('#registerForm .btn-submit').prop('disabled', false);
                                $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#registerForm .btn-submit').html('Sign up');
                            $('#registerForm .btn-submit').prop('disabled', false);
                            $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                    });
                    return false;
                },
            });
        });
    }