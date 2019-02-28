//***************************************************************************************************//

//UNTUK NEGERI

$(document).ready(function(){
    $('#state_add').validate(
    {
        rules: {
            kodNegeri: {
            minlength: 1,
            number: true,
            required: true
            },
            perihalNegeri: {
            maxlength: 50,
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


$(document).ready(function(){
    $('#state_update').validate(
    {
        rules: {
            kodNegeri: {
            minlength: 1,
            number: true,
            required: true
            },
            perihalNegeri: {
            maxlength: 50,
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

//***************************************************************************************************//
//UNTUK KOD PENEMPATAN

$(document).ready(function(){
    $('#tempat_add').validate(
    {
        rules: {
            kodPenempatan: {
            minlength: 1,
            number: true,
            required: true
            },
            perihalPenempatan: {
            maxlength: 100,
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


$(document).ready(function(){
    $('#tempat_update').validate(
    {
        rules: {
            kodPenempatan: {
            minlength: 1,
            number: true,
            required: true
            },
            perihalPenempatan: {
            maxlength: 100,
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

//***************************************************************************************************//

//***************************************************************************************************//
//UNTUK KOD KLASIFIKASI SKIM

$(document).ready(function(){
    $('#kodkskim_add').validate(
    {
        rules: {
            kodKlasifikasiSkim: {
            minlength: 1,
            //number: true,
            required: true
            },
            perihalKlasifikasiSkim: {
            maxlength: 50,
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


$(document).ready(function(){
    $('#kodkskim_update').validate(
    {
        rules: {
            kodKlasifikasiSkim: {
            minlength: 1,
            //number: true,
            required: true
            },
            perihalKlasifikasiSkim: {
            maxlength: 50,
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

//***************************************************************************************************//
//UNTUK KOD KUMPULAN PERKHIDMATAN 

$(document).ready(function(){
    $('#kodkumpulan_add').validate(
    {
        rules: {
            kodKumpulan: {
            minlength: 1,
            //number: true,
            required: true
            },
            perihalKumpulan: {
            maxlength: 100,
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


$(document).ready(function(){
    $('#kodkumpulan_update').validate(
    {
        rules: {
            kodKumpulan: {
            minlength: 1,
            //number: true,
            required: true
            },
            perihalKlasifikasiSkim: {
            maxlength: 100,
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

//---------------------------------------------------------------------------------------------------
//UNTUK KOD UJIAN 

$(document).ready(function(){
    $('#kujian_tambah').validate(
    {
        rules: {
            kodUjian: {
            minlength: 1,
            required: true
            },
            perihalUjian: {
            maxlength: 100,
            required: true
            },
            keterangan1: {
            maxlength: 100,
            required: true
            },
            keterangan2: {
            maxlength: 100,
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


$(document).ready(function(){
    $('#kujian_kemaskini').validate(
    {
        rules: {
            kodUjian: {
            minlength: 1,
            required: true
            },
            perihalUjian: {
            maxlength: 100,
            required: true
            },
            keterangan1: {
            maxlength: 100,
            required: true
            },
            keterangan2: {
            maxlength: 100,
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

//---------------------------------------------------------------------------------------------------
//UNTUK SOALAN

$(document).ready(function(){
    $('#soalan_tambah').validate(
    {
        rules: {
            idSoalan: {
            minlength: 1,
            required: true
            },
            soalan: {
            maxlength: 100,
            required: true
            },
            idKategoriSoalan: {
            minlength: 1,
            required: true
            },
            kodUjian: {
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


$(document).ready(function(){
    $('#soalan_kemaskini').validate(
    {
        rules: {
            idSoalan: {
            minlength: 1,
            required: true
            },
            soalan: {
            maxlength: 100,
            required: true
            },
            idKategoriSoalan: {
            minlength: 1,
            required: true
            },
            kodUjian: {
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

//--------------------------------------------------------------------------------------------------------------