$(document).ready(function(){
    $('#create_user').validate(
    {
        rules: {
            pro_nama: {
            maxlength: 255,
            required: true
            },
            user_username: {
            maxlength: 255,
            required: true
            },
            user_password: {
            maxlength: 20,
            minlength: 6,
            required: true
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