//***************************************************************************************************//

//UNTUK SUBSISTEM

$(document).ready(function(){
    $('#ulangan_kemaskini').validate(
    {
        rules: {
            idAmbilan: {
            minlength: 1,
            number: true,
            required: true
            },
            kodUjian: {
            minlength: 1,
            required: true
            },
            siri: {
            minlength: 1,
            number: true,
            required: true
            },
            tarikhMulaUlang: {
            maxlength: 100,
            required: true
            },
            tarikhAkhirUlang: {
            maxlength: 100,
            required: true,
            greaterStart: '#tarikhMulaUlang'
            },
            statusUjian: {
            minlength: 1,
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

// untuk pengaktifan ujian

// kemaskini pengaktifan ujian
$(document).ready(function(){
    $('#senggara_ujianKemaskini').validate(
    {
        rules: {
            tarikhBuka: {
            //maxlength: 100,
            required: true
            },
            tarikhTutup: {
            //maxlength: 20,
            required: true,
            greaterStart: '#tarikhBuka'
            },
             statusUjian: {
            //maxlength: 20,
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

// tambah pengaktifan ujian
$(document).ready(function(){
    $('#senggara_ujianTambah').validate(
    {
        rules: {
            idAmbilan: {
            minlength: 1,
            number: true,
            required: true
            },
            kodUjian: {
            minlength: 1,
            required: true
            },
            siri: {
             minlength: 1,
            number: true,
            required: true
            },
            tahun: {
            minlength: 4,
            maxlength: 4,
            number: true,
            required: true
            },
            tarikhBuka_tambah: {
            maxlength: 100,
            required: true 
            },
            tarikhTutup_tambah: {
            maxlength: 100,
            required: true,
            greaterStart: '#tarikhBuka_tambah'
            },
            statusUjian: {
            minlength: 1,
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
