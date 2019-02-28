/*
Tujuan Aturcara	:
Pengaturcara		:
Tarikh Dibangunkan	:
Pengubahsuai		: 1. Mohd. Hafidz BIN Abdul Kadir
Tarikh	Ubahsuai	: 28 Oktober 2015
*/
$(document).ready(function(){
    $('#genReport').click(function(){
        $('#laporan_status').validate({
            rules: {
                ujian: { required: true },
                siri: {  required: true }
            },
            highlight: function(element) { 
                $(element).closest('.control-group').removeClass('success').addClass('error'); 
            },
            success: function(element) {
                element
                .text('OK!').addClass('valid')
                .closest('.control-group').removeClass('error');
            }
        });
    });
    
    $('#laporan_ulang').validate({
        rules: {
            ujian: { required: true },
            siri: {  required: true }
        },
        highlight: function(element) { 
            $(element).closest('.control-group').removeClass('success').addClass('error'); 
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');
        }
    });
    $('#laporan_analitik').validate({
        rules: {
            ujian: { required: true },
            siri: {  required: true }
        },
        highlight: function(element) { 
            $(element).closest('.control-group').removeClass('success').addClass('error'); 
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');
        }
    });
});  