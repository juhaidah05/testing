$(document).ready(function(){
    $('#form').validate(
    {
        rules: {
            nama: {
            minlength: 2,
            required: true
            },
            ic: {
            minlength: 12,
            required: true
            },
            email: {
            maxlength: 100,
            required: true,
            email: true
            },            
            katanama: {
            required: true
            },
            katalaluan: {
            required: true,
            minlength: 6
            },
            pengesahan_katalaluan: {
            required: true,
            minlength: 6,
            equalTo:"#katalaluan"
            }
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