//***************************************************************************************************//

//UNTUK SUBSISTEM

$(document).ready(function(){
    $('#subsistem_tambah').validate(
    {
        rules: {
            id_subsistem: {
            minlength: 1,
            number: true,
            required: true
            },
            keterangan_subsistem: {
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
    $('#subsistem_kemaskini').validate(
    {
        rules: {
            id_subsistem: {
            minlength: 1,
            number: true,
            required: true
            },
            keterangan_subsistem: {
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

//UNTUK MODUL

$(document).ready(function(){
    $('#modul_tambah').validate(
    {
        rules: {
            cdModul: {
            minlength: 1,
            number: true,
            required: true
            },
            ketModul: {
            maxlength: 100,
            required: true
            },
            urlModul: {
            maxlength: 100,
            required: true
            },
            statusAktif: {
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
    $('#modul_kemaskini').validate(
    {
        rules: {
            cdModul: {
            minlength: 1,
            number: true,
            required: true
            },
            ketModul: {
            maxlength: 100,
            required: true
            },
            urlModul: {
            maxlength: 100,
            required: true
            },
            statusAktif: {
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

//***************************************************************************************************//

//UNTUK SUB MODUL

$(document).ready(function(){
    $('#submodul_tambah').validate(
    {
        rules: {
            cdSubModul1: {
            minlength: 1,
            number: true,
            required: true
            },
            ketSubModul1: {
            maxlength: 100,
            required: true
            },
            urlSubModul1: {
            maxlength: 100,
            required: true
            },
            cdModul: {
            minlength: 1,
            required: true
            },
            statusAktif: {
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
    $('#submodul_kemaskini').validate(
    {
        rules: {
            cdSubModul1: {
            minlength: 1,
            number: true,
            required: true
            },
            ketSubModul1: {
            maxlength: 100,
            required: true
            },
            urlSubModul1: {
            maxlength: 100,
            required: true
            },
            cdModul: {
            minlength: 1,
            required: true
            },
            statusAktif: {
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

//***************************************************************************************************//

//UNTUK JAWAPAN

$(document).ready(function(){
    $('#jawapan_tambah').validate(
    {
        rules: {
            idJawapan: {
            minlength: 1,
            number: true,
            required: true
            },
            pilihanJawapan: {
            maxlength: 100,
            required: true
            },
            skor: {
            minlength: 1,
            number: true,
            required: true
            },
            inputType: {
            maxlength: 20,
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
    $('#jawapan_kemaskini').validate(
    {
        rules: {
            idJawapan: {
            minlength: 1,
            number: true,
            required: true
            },
            pilihanJawapan: {
            maxlength: 100,
            required: true
            },
            skor: {
            minlength: 1,
            number: true,
            required: true
            },
            inputType: {
            maxlength: 20,
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

//UNTUK KATEGORI JAWAPAN

$(document).ready(function(){
    $('#kategorisoalan_tambah').validate(
    {
        rules: {
            idKategoriSoalan: {
            minlength: 1,
            number: true,
            required: true
            },
            kategoriSoalan: {
            maxlength: 50,
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
    $('#kategorisoalan_kemaskini').validate(
    {
        rules: {
            idKategoriSoalan: {
            minlength: 1,
            number: true,
            required: true
            },
            kategoriSoalan: {
            maxlength: 50,
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

//***************************************************************************************************//

//UNTUK KOD FASILITI

$(document).ready(function(){
    $('#kodfasiliti_tambah').validate(
    {
        rules: {
            kodFasiliti: {
            maxlength: 15,
            required: true
            },
            perihalFasiliti: {
            maxlength: 100,
            required: true
            },
            kodJenisFasiliti: {
            minlength: 1,
            required: true
            },
            lokalitiPentadbir: {
            maxlength: 15,
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
    $('#kodfasiliti_kemaskini').validate(
    {
        rules: {
            kodFasiliti: {
            maxlength: 15,
            required: true
            },
            perihalFasiliti: {
            maxlength: 100,
            required: true
            },
            kodJenisFasiliti: {
            minlength: 1,
            required: true
            },
            lokalitiPentadbir: {
            maxlength: 15,
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

//UNTUK KOD JANTINA

$(document).ready(function(){
    $('#kodjantina_tambah').validate(
    {
        rules: {
            kodJantina: {
            maxlength: 1,
            required: true
            },
            perihalJantina: {
            maxlength: 10,
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
    $('#kodjantina_kemaskini').validate(
    {
        rules: {
            kodJantina: {
            maxlength: 1,
            required: true
            },
            perihalJantina: {
            maxlength: 10,
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

//UNTUK KOD JENIS FASILITI

$(document).ready(function(){
    $('#kodjenisfasiliti_tambah').validate(
    {
        rules: {
            kodJenisFasiliti: {
            minlength: 1,
            number: true,
            required: true
            },
            perihalJenisFasiliti: {
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
    $('#kodjenisfasiliti_kemaskini').validate(
    {
        rules: {
            kodJenisFasiliti: {
            minlength: 1,
            number: true,
            required: true
            },
            perihalJenisFasiliti: {
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

//UNTUK PADANAN SJ

$(document).ready(function(){
    $('#padanansj_tambah').validate(
    {
        rules: {
            idSJ: {
            minlength: 1,
            number: true,
            required: true
            },
            idSoalan: {
            minlength: 1,
            required: true
            },
            idJawapan: {
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
    $('#padanansj_kemaskini').validate(
    {
        rules: {
            idSJ: {
            minlength: 1,
            number: true,
            required: true
            },
            idSoalan: {
            minlength: 1,
            required: true
            },
            idJawapan: {
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

//***************************************************************************************************//

//UNTUK PADANAN FP

$(document).ready(function(){
    $('#padananfp_tambah').validate(
    {
        rules: {
            idFP: {
            minlength: 1,
            number: true,
            required: true
            },
            fasiliti: {
            minlength: 1,
            required: true
            },
            penempatan: {
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
    $('#padananfp_kemaskini').validate(
    {
        rules: {
            idFP: {
            minlength: 1,
            number: true,
            required: true
            },
            fasiliti: {
            minlength: 1,
            required: true
            },
            penempatan: {
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