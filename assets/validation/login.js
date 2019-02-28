/*
Tujuan Aturcara	:
Pengaturcara		:
Tarikh Dibangunkan	:
Pengubahsuai		: 1. Mohd. Hafidz BIN Abdul Kadir
Tarikh	Ubahsuai	: 11 Ogos 2015
*/

$(document).ready(function(){
    $('#form_login').validate({
        rules: {
            username: { required: true },
            password: { required: true, password_input: true }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        }
    });
    $('#lost_password').validate({
        rules: {
            mykad: { maxlength: 12, required: true },
            email: { required: true },
            new_cpassword: { required: true, equalTo: "#new_password", password_input: true },
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        }
    });
    $('#change_password').validate({
        rules: { 
	    old_password: { required: true, password_input: true },
            new_password: { required: true, password_input: true },
            new_cpassword: { required: true,equalTo: "#new_password", password_input: true }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        }
    });
    $('#lupa_password').validate({
        rules: {
            mykad: { maxlength: 12, required: true },
            emel: { required: true, email: true },
            //new_cpassword: { required: true, equalTo: "#new_password", password_input: true },
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        }
    });
});