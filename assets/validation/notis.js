$(document).ready(function(){
    $('#selenggara_notis').validate(
    {
         rules: {
                        
            tajuknotis: {
            maxlength: 100,
            required: true,
            },
            
            templatenotis: {
            maxlength: 250,
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
//------------------------------------------------------------------------------------------------------------- 
$(document).ready(function(){
    $('#selenggara_emel').validate(
    {
         rules: {
                        
            jawatan: {
            maxlength: 50,
            required: true,
            },
            
            nama: {
            maxlength: 80,
            required: true
            },
			
			alamatemel: {
            email: true,
            required: true
            },
			
			status: {
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











