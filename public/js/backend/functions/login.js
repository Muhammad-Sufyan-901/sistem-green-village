//* Login Functions
    // Login Store
    function login_store()
    {
        $('form[id="loginForm"]').each(function(){
            $(this).validate({
                ignore: ".ignore",
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 150
                    },
                    password: 'required'
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
                            $('#loginForm .btn-submit').html('Please wait...');
                            $('#loginForm .btn-submit').prop('disabled', true);
                        },
                        success: function(data) {
                            if(data.status == 'success'){                                
                                window.location.href = data.next;
                            }else{
                                $('#loginForm .btn-submit').html('Sign in');
                                $('#loginForm .btn-submit').prop('disabled', false);
                                $('.alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loginForm .btn-submit').html('Sign in');
                            $('#loginForm .btn-submit').prop('disabled', false);
                            $('.alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
                        }
                    });
                    return false;
                },
            });
        });
    }