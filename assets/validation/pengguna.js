/*
Tujuan Aturcara	:
Pengaturcara		:
Tarikh Dibangunkan	:
Pengubahsuai		: 1. Mohd. Hafidz BIN Abdul Kadir
Tarikh	Ubahsuai	: 11 Ogos 2015
*/

$(document).ready(function(){
    $('#tambah_rekod').validate({
        rules: {
            mykad: {minlength: 12,maxlength: 12,number: true,required: true},
            nama: {maxlength: 100,required: true},
            jantina: {required: true},
            katalaluan: {password_input: true,required: true},
            re_katalaluan: {password_input: true,required: true},            
            emel: {email: true,required: true},
            skim: {required: true},
            gred: {required: true},
            jenisFasiliti: {required: true},
            lokasiBertugas: {required: true},
            penempatan: {required: true},
            status: {required: true},
            levelAdmin: {required: true}          
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

    $('#kemaskini_rekod').validate({
        rules: {
            mykad: {minlength: 12,maxlength: 12,number: true,required: true},
            nama: {maxlength: 100,required: true},
            jantina: {required: true},           
            emel: {email: true,required: true},
            skim: {required: true},
            gred: {required: true},
            jenisFasiliti: {required: true},
            lokasiBertugas: {required: true},
            penempatan: {required: true},
            status: {required: true},
            levelAdmin: {required: true}
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