$(document).ready(function(){
    $('#access_control').validate(
    {
        rules: {
            role: {
            required: true
            },
            'cd_module[]': {
            required: true
            },
            'cd_submodule1-1[]': {
            required: '#cd_module1:checked'
            },
            'cd_submodule1-2[]': {
            required: '#cd_module2:checked'
            },
            'cd_submodule1-3[]': {
            required: '#cd_module3:checked'
            },
            'cd_submodule1-4[]': {
            required: '#cd_module4:checked'
            }
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
    
        $('#access_control').find("input[name*='cd_submodule1']").each(function() {
            var id = $(this).parent().parent().parent().parent().find('input').attr('value');
            $(this).rules('add', {
                required: "#cd_module"+id+":checked"
            });
        });    
        $('#access_control').find("input[name*='cd_submodule2']").each(function() {
            var id1 = $(this).parent().parent().parent().parent().parent().find('input').attr('value');
            var id2 = $(this).parent().parent().parent().find('input').attr('value');
//            alert("cd_submodule1-"+id1+"-"+id2);
            $(this).rules('add', {
                required: "#cd_submodule1-"+id1+"-"+id2+":checked"
            });
        });    
}); // end document.ready  