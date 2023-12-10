
    function showRegisterForm() {
        $('.loginBox').fadeOut('fast', function () {
            $('.registerBox').fadeIn('fast');
            $('.login-footer').fadeOut('fast', function () {
                $('.register-footer').fadeIn('fast');
            });
            $('.modal-title').html('Register with');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    function showLoginForm() {
        $('#loginModal .registerBox').fadeOut('fast', function () {
            $('.loginBox').fadeIn('fast');
            $('.register-footer').fadeOut('fast', function () {
                $('.login-footer').fadeIn('fast');
            });

            $('.modal-title').html('Login with');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    function openLoginModal() {
        showLoginForm();
        setTimeout(function () {
            $('#loginModal').modal('show');
        }, 230);

    }

    function openRegisterModal() {
        showRegisterForm();
        setTimeout(function () {
            $('#loginModal').modal('show');
        }, 230);

    }

    function loginAjax() {
        /*   Remove this comments when moving to server
        $.post( "/login", function( data ) {
                if(data == 1){
                    window.location.replace("/home");
                } else {
                     shakeModal();
                }
            });
        */

        /*   Simulate error message from the server   */
        shakeModal();
    }

    function shakeModal() {
        $('#loginModal .modal-dialog').addClass('shake');
        $('.error').addClass('alert alert-danger').html("Invalid email/password combination");
        $('input[type="password"]').val('');
        setTimeout(function () {
            $('#loginModal .modal-dialog').removeClass('shake');
        }, 1000);
    }
$(document).ready(function() {
    const closeBtn = $('#close1-btn');
    closeBtn.click(function () {
        $('#loginModal').modal('hide');
    });

    if(($('#backend-login-email-invalid-feedback')!==undefined && $('#backend-login-email-invalid-feedback').length > 0) || ($('#backend-login-password-invalid-feedback')!==undefined && $('#backend-login-password-invalid-feedback').length > 0)){
        openLoginModal();
    }
    if(($('#backend-reg-name-invalid-feedback')!==undefined && $('#backend-reg-name-invalid-feedback').length > 0) || ($('#backend-reg-email-invalid-feedback')!==undefined && $('#backend-reg-email-invalid-feedback').length > 0) || ($('#backend-reg-password-invalid-feedback')!==undefined && $('#backend-reg-password-invalid-feedback').length > 0) ){
        openRegisterModal();
    }

    // Login Form Validation
    $("#login-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4,
                maxlength: 16
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at least 4 characters long",
                maxlength: "Password must be at most 16 characters long"
            }
        }
    });

    // Register Form Validation
    $("#reg-form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4,
                maxlength: 16
            },
            password_confirmation: {
                required: true,
                equalTo: "#reg-password"
            }
        },
        messages: {
            name: {
                required: "Please enter your name"
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at least 4 characters long",
                maxlength: "Password must be at most 16 characters long"
            },
            password_confirmation: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            }
        }
    });
});

