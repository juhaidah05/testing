$(document).ready(function(){
    $('#info').validate(
    {
        rules: {
            stspatient: {
            required: true
            },
            patient_icno: {
            maxlength: 14,
            required: true
            },
            patient_name: {
            nameMY: true,
            required: true
            },
            age_years: {
            digits: true,
            maxlength: 2,
            required: true
            },            
            age_month: {
            digits: true,
            maxlength: 2,
            required: true
            },            
            gender: {
            required: true
            },
            race: {
            required: true
            },
            patient_add1: {
            required: true
//            minlength: 6
            },
//            patient_poscode: {
//            required: true,
//            digits: true,
//            maxlength: 5
//            },
            patient_addstate: {
            required: true
            },
            patient_district: {
            required: true
            },
//            occupation: {
//            required: true
//            },
//            maritalstatus: {
//            required: true
//            },
            redisable_hltcondition: {
            required: true
            },
            dt_incidentreported: {
            dateMY: true,
            required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus(); //Set Focus
            }
        }
    });
    
    $('#incident').validate(
    {
//        ignore: ".ignore, :hidden",
        rules: {
            dt_loc_incident: {
            required: true
            },
            'cd_loc_incidence[]': {
            required: true
            },
            oth_loc_incidence: {
            required: true
            },
            specify_othincident_info: {
            required: true
            },
            'cd_maltreatlvl1[]': {
            required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus(); //Set Focus
            }
        }                
    });
    
        $('#incident').find("select[name*='ans_oth_inciden_quest']").each(function() {
            $(this).rules('add', {
                required: true
            });
        });
        $('#incident').find("input[name*='cd_maltreatlvl2']").each(function() {
            $(this).rules('add', {
                required: true
            });
        });
        $('#incident').find("input[name*='cd_maltreatlvl3']").each(function() {
            $(this).rules('add', {
                required: true
            });
        });
        $('#incident').find("select[name*='ans_oth_maltreat_quest']").each(function() {
            $(this).rules('add', {
                required: true
            });
        });
        
//    $('#modalLocationUpdate').validate(
//    {
//        rules: {
//            dt_loc_incident: {
//            required: true
//            },
//            oth_loc_incidence: {
//            required: true
//            },
//            'cd_loc_incidence[]': {
//            required: true
//            }
//        },
//        highlight: function(element) {
//            $(element).closest('.control-group').removeClass('success').addClass('error');
//        },
//        success: function(element) {
//            element
//            .text('OK!').addClass('valid')
//            .closest('.control-group').removeClass('error');//.addClass('success');
//        }
//    });        

//    $('#suspect').validate(
//    {
//        ignore: ".ignore, :hidden"
//    });
    $('#suspect').validate(
    {
        ignore: ".ignore, :hidden",
        rules: {
//            gender: {
//            maxlength: 12,
//            required: true
//            },
//            race: {
//            required: true
//            },
//            maritalstatus: {
//            digits: true,
//            maxlength: 2,
//            required: true
//            },            
//            occupation: {
//            required: true
//            },
            cd_relation_viclvl1: {
            required: true
            },
            oth_relation_civlvl3: {
            required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus(); //Set Focus
            }
        }   
    });
//        $('#suspect').find("select[name*='ans_oth_suspect_quest']").each(function() {
//            $(this).rules('add', {
//                required: true
//            });
//        });
        $('#suspect').find(":checkbox[name*='cd_relation_viclvl2-']").each(function() {
            $(this).rules('add', {
                required: true
            });
        });
        $('#suspect').find(":checkbox[name*='cd_relation_viclvl3-']").each(function() {
            $(this).rules('add', {
                required: true
            });
        });
    
    $('#outcome').validate(
    {
        rules: {
            discharge: {
            required: true
            },
            'subdischarge[]': {
            required: true
            },
            specify_subdischarge: {
            required: true
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
    
    $('#status').validate(
    {
        rules: {
            medofficer_name: {
            required: true
            },
//            dtcreated: {
//            required: true
//            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus(); //Set Focus
            }
        }   
    });
    
    $('#case_search').validate(
    {
        rules: {
//            mrn_no: {
//            required: true
//            },
            patient_icno: {
                required: false,
                minlength: 9
            }
//            patient_name: {
//            nameMY: true,
//            required: true
//            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error');//.addClass('success');
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus(); //Set Focus
            }
        }   
    });    
}); // end document.ready  