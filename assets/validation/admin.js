$(document).ready(function(){
    $('#add').validate(
    {
        rules: {
            usr_active: {
            required: true
            },
            
            usr_icno: {
            minlength: 12,
            required: true,
            number: true
            },
            
            usr_fullname: {
            maxlength: 80,
            required: true
            },
            
            usr_profesion: {
            required: true
            },
            
            cd_agencytype: {
            required:  true
            },
          
            cd_facilitytype: {
            required:  true
            },
            
            usr_facilitycode: {
            required:  true
            },
            
            usr_cdstate: {
            required:  true
            },
            
            usr_facilityaddr1:{
            required:  true         
            },
            
            usr_facilityposcode:{
            required:  true,
            number: true
            },
            
            usr_phonenumber:{
            required:  true,
            number: true
            },
            
            usr_hponenumber:{
            number: true
            },
            
            usr_faxnumber:{
            number: true
            },
            
            usr_email:{
            email: true,
            required:  true
            },
            
            
            usr_id: {
            required:  true
            },
            
            cd_role: {
            required:  true
            },
            
            usr_password: {
            minlength: 8,
            required: true,
            },
            
            usr_repassword: {
            minlength: 8,
            required: true,
            equalTo : "#usr_password"
            },
            
            cd_securityquestion: {
            required:  true
            },
            
            securityanswer: {
            required:  true
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
    $('#form1').validate(
    {
        rules: {
            
            'answer-1': {
            required:  true
            }, 
            
            'answer-2': {
            required:  true
            },
            
            'answer-3': {
            required:  true
            },
            
            'answer-4': {
            required:  true
            },
            
            'answer-5': {
            required:  true
            },
            
            'answer-6': {
            required:  true
            },
            
            'answer-7': {
            required:  true
            },
            
            'answer-8': {
            required:  true
            },
            
            'answer-9': {
            required:  true
            },
            
            'answer-10': {
            required:  true
            },
            
            'answer-11': {
            required:  true
            },
            
            'answer-12': {
            required:  true
            },
            
            'answer-13': {
            required:  true
            },
            
            'answer-14': {
            required:  true
            },
            
            'answer-15': {
            required:  true
            },
            
            'answer-16': {
            required:  true
            },
            
            'answer-17': {
            required:  true
            },
            
            'answer-18': {
            required:  true
            },
            
            'answer-19': {
            required:  true
            },
            
            'answer-20': {
            required:  true
            },
            
            'answer-21': {
            required:  true
            },
           
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error').addClass('success');
        },
        errorPlacement: function(error, element) {
//          error.html('your error message here');
          if(element.closest('.lblText').find('label.error').length == 0){
            error.insertAfter( element.closest('.lblText').find('.error_message_holder') );
          }
        }                 
    });
}); // end document.ready  

$(document).ready(function(){
    $('#kemaskini_pengguna').validate(
    {
         rules: {
                        
            mykad: {
            minlength: 12,
            required: true,
            number: true
            },
            
            nama: {
            maxlength: 100,
            required: true
            },
            
            jantina: {
            required:  true
            },
            
            emel:{           
            email: true,  
            required:  true
            },
            
            skim: {
            required:  true
            },
            
            gred: {
            required:  true
            },
            
            jenisFasiliti: {
            required:  true
            },
            
            lokasiBertugas: {
            required:  true
            },
            
            penempatan: {
            required:  true
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









