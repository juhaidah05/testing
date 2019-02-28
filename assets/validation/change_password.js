$(document).ready(function(){
    $('#change_password').validate(
    {
        rules: {
            old_password: {
            minlength: 2,
            required: true
            },
            new_password: {
            minlength: 6,
            required: true,
            },
            new_cpassword: {
            minlength: 6,
            required: true,
            equalTo:"#new_password",
            },
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error').addClass('success');
        }
    });
}); // end document.ready  