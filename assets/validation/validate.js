$(document).ready(function(){
    $('#casestatus_add').validate(
    {
        rules: {
            cd_casestatus: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_casestatus: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#casestatus_update').validate(
    {
        rules: {
            cd_casestatus: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_casestatus: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#discharge_add').validate(
    {
        rules: {
            cd_discharge: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_discharge: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#discharge_update').validate(
    {
        rules: {
            cd_discharge: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_discharge: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#loc_incidence_add').validate(
    {
        rules: {
            cd_loc_incidence: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_loc_incidence: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#loc_incidence_update').validate(
    {
        rules: {
            desc_loc_incidence: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#lt_maltreatlvl1_add').validate(
    {
        rules: {
            cd_maltreatlvl1: {
            minlength: 2,
            number: true,
            required: true
            },
            desc_maltreatlvl1: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
 $('#lt_maltreatlvl1_update').validate(
    {
        rules: {
            cd_maltreatlvl1: {
            minlength: 2,
            number: true,
            required: true
            },
            
            desc_maltreatlvl1: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#role_add').validate(
    {
        rules: {
            cd_role: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_role: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#role_update').validate(
    {
        rules: {
            cd_role: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_role: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#secquestion_add').validate(
    {
        rules: {
            cd_securityquestion: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_securityquestion: {
            maxlength: 80,
            required: true
            }
          
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
    $('#secquestion_update').validate(
    {
        rules: {
            cd_securityquestion: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_securityquestion: {
            maxlength: 80,
            required: true
            }

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
    $('#lt_agencytype_add').validate(
    {
        rules: {
            cd_agencytype: {
            minlength: 1,
            number: true,
            required: true
            },
            decs_agenctype: {
            maxlength: 80,
            required: true
            }
          
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
    $('#lt_agencytype_update').validate(
    {
        rules: {
            cd_agencytype: {
            minlength: 1,
            number: true,
            required: true
            },
            decs_agenctype: {
            maxlength: 80,
            required: true
            }

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
    $('#lt_district_add').validate(
    {
        rules: {
            cd_district: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_district: {
            maxlength: 80,
            required: true
            }
          
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
    $('#lt_district_update').validate(
    {
        rules: {
            cd_district: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_district: {
            maxlength: 80,
            required: true
            }

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
    $('#gender_add').validate(
    {
        rules: {
            cd_gender: {
            minlength: 1,
            lettersonly: true,
            required: true
            },
            desc_gender: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#gender_update').validate(
    {
        rules: {
            cd_gender: {
            minlength: 1,
            lettersonly: true,
            required: true
            },
            desc_gender: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#jknreferral_add').validate(
    {
        rules: {
            cd_jkmreferral: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_jkmreferral: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#jknreferral_update').validate(
    {
        rules: {
            cd_jkmreferral: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_jkmreferral: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#state_add').validate(
    {
        rules: {
            cd_state: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_state: {
            maxlength: 80,
            required: true
            }
     
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
            cd_state: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_state: {
            maxlength: 80,
            required: true
            }
          
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
    $('#riskfactorlvl1_add').validate(
    {
        rules: {
            cd_riskfactorlvl1: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_riskfactorlvl1: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#riskfactorlvl1_update').validate(
    {
        rules: {
            cd_riskfactorlvl1: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_riskfactorlvl1: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#relation_viclvl1_add').validate(
    {
        rules: {
            cd_relation_viclvl1: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_relation_viclvl1: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#relation_viclvl1_update').validate(
    {
        rules: {
            cd_relation_viclvl1: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_relation_viclvl1: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#race_add').validate(
    {
        rules: {
            cd_race: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_race: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#race_update').validate(
    {
        rules: {
            cd_race: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_race: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#profession_add').validate(
    {
        rules: {
            cd_profession: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_profession: {
            maxlength: 80,
            required: true
            }
            
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
    $('#profession_update').validate(
    {
        rules: {
            cd_profession: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_profession: {
            maxlength: 80,
            required: true
            }
            
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
    $('#oth_suspect_quest_add').validate(
    {
        rules: {
            cd_oth_suspect_quest: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_oth_suspect_quest: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#oth_suspect_quest_update').validate(
    {
        rules: {
            cd_oth_suspect_quest: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_oth_suspect_quest: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#oth_incident_quest_add').validate(
    {
        rules: {
            cd_oth_incident_quest: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_incident_quest: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#oth_incident_quest_update').validate(
    {
        rules: {
            cd_oth_incident_quest: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_incident_quest: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#occupation_add').validate(
    {
        rules: {
            cd_occupation: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_occupation: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#occupation_update').validate(
    {
        rules: {
            cd_occupation: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_occupation: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#maritalstatus_add').validate(
    {
        rules: {
            cd_maritalstatus: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_maritalstatus: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#maritalstatus_update').validate(
    {
        rules: {
            cd_maritalstatus: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_maritalstatus: {
            maxlength: 80,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#relation_viclvl2_add').validate(
    {
        rules: {
            cd_relation_viclvl2: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_relation_viclvl2: {
            maxlength: 80,
            required: true
            },
            cd_relation_viclvl1: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#relation_viclvl2_update').validate(
    {
        rules: {
            cd_relation_viclvl2: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_relation_viclvl2: {
            maxlength: 80,
            required: true
            },
            cd_relation_viclvl1: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#module_add').validate(
    {
        rules: {
            cd_module: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_module: {
            maxlength: 80,
            required: true
            },
            url_module: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#module_update').validate(
    {
        rules: {
            cd_module: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_module: {
            maxlength: 80,
            required: true
            },
            url_module: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#submodule1_add').validate(
    {
        rules: {
            cd_submodule1: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_submodule1: {
            maxlength: 80,
            required: true
            },
            url_submodule1: {
            required: true
            },
            cd_module: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#submodule1_update').validate(
    {
        rules: {
            cd_submodule1: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_submodule1: {
            maxlength: 80,
            required: true
            },
            url_submodule1: {
            required: true
            },
            cd_module: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#maltreatlvl2_add').validate(
    {
        rules: {
            cd_maltreatlvl2: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_maltreatlvl2: {
            maxlength: 80,
            required: true
            },
            cd_maltreatlvl1: {
            required: true
            },
            cd_oth_maltreat_quest: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#maltreatlvl2_update').validate(
    {
        rules: {
            cd_maltreatlvl2: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_maltreatlvl2: {
            maxlength: 80,
            required: true
            },
            cd_maltreatlvl1: {
            required: true
            },
            cd_oth_maltreat_quest: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#facilitytype_add').validate(
    {
        rules: {
            cd_facilitytype: {
            minlength: 2,
            number: true,
            required: true
            },
            decs_facilitytype: {
            maxlength: 80,
            required: true
            },
            cd_agencytype: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#facilitytype_update').validate(
    {
        rules: {
            cd_facilitytype: {
            minlength: 2,
            number: true,
            required: true
            },
            decs_facilitytype: {
            maxlength: 80,
            required: true
            },
            cd_agencytype: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#lt_oth_maltreat_quest_add').validate(
    {
        rules: {
            cd_oth_maltreat_quest: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_oth_maltreat_quest: {
            maxlength: 150,
            required: true
            },
            cd_maltreatlvl1: {
            maxlength: 2,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#lt_oth_maltreat_quest_add').validate(
    {
        rules: {
            cd_oth_maltreat_quest: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_oth_maltreat_quest: {
            maxlength: 150,
            required: true
            },
            cd_maltreatlvl1: {
            maxlength: 2,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#lt_oth_maltreat_quest_update').validate(
    {
        rules: {
            cd_oth_maltreat_quest: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_oth_maltreat_quest: {
            maxlength: 150,
            required: true
            },
            cd_maltreatlvl1: {
            maxlength: 2,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#maltreatlvl3_add').validate(
    {
        rules: {
            cd_maltreatlvl3: {
            minlength: 6,
            number: true,
            required: true
            },
            desc_maltreatlvl3: {
            maxlength: 150,
            required: true
            },
            cd_maltreatlvl2: {
            maxlength: 4,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#maltreatlvl3_update').validate(
    {
        rules: {
            cd_maltreatlvl3: {
            minlength: 6,
            number: true,
            required: true
            },
            desc_maltreatlvl3: {
            maxlength: 150,
            required: true
            },
            cd_maltreatlvl2: {
            maxlength: 4,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#subdischarge_add').validate(
    {
        rules: {
            cd_subdischarge: {
            minlength: 2,
            number: true,
            required: true
            },
            desc_subdischarge: {
            maxlength: 80,
            required: true
            },
            cd_discharge: {
            maxlength: 4,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#subdischarge_update').validate(
    {
        rules: {
            cd_subdischarge: {
            minlength: 2,
            number: true,
            required: true
            },
            desc_subdischarge: {
            maxlength: 80,
            required: true
            },
            cd_discharge: {
            maxlength: 4,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#report_maltreat_add').validate(
    {
        rules: {
            id: {
            maxlength: 11,
            number: true,
            required: true
            },
            id_rpt_maltreat: {
            maxlength: 12,
            required: true
            },
           desc_rpt_maltreat: {
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



$(document).ready(function(){
    $('#report_maltreat_update').validate(
    {
        rules: {
            id: {
            maxlength: 11,
            number: true,
            required: true
            },
            id_rpt_maltreat: {
            maxlength: 12,
            required: true
            },
            desc_rpt_maltreat: {
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


$(document).ready(function(){
    $('#submodule2_add').validate(
    {
        rules: {
            cd_submodule2: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_submodule2: {
            maxlength: 80,
            required: true
            },
            url_submodule2: {
            maxlength: 100,
            required: true
            },
            cd_module: {
            required: true
            },
            cd_submodule1: {
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
}); // end document.read


$(document).ready(function(){
    $('#submodule2_update').validate(
    {
        rules: {
            cd_submodule2: {
            minlength: 1,
            number: true,
            required: true
            },
            desc_submodule2: {
            maxlength: 80,
            required: true
            },
            url_submodule2: {
            maxlength: 100,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#riskfactorlvl2_add').validate(
    {
        rules: {
            cd_riskfactorlvl2: {
            minlength: 4,
            number: true,
            required: true
            },
            desc_riskfactorlvl2: {
            maxlength: 80,
            required: true
            },
            cd_riskfactorlvl1: {
            maxlength: 2,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
           $('#riskfactorlvl2_update').validate(
        {
        rules: {
            cd_riskfactorlvl2: {
            minlength: 4,
            number: true,
            required: true 
            },
            desc_riskfactorlvl2: {
            maxlength: 80,
            required: true
            },
            cd_riskfactorlvl1: {
            maxlength: 2,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#relation_viclvl3_add').validate(
    {
        rules: {
            cd_relation_viclvl3: {
            minlength: 6,
            number: true,
            required: true
            },
            desc_relation_viclvl3: {
            maxlength: 80,
            required: true
            },
            cd_relation_viclvl2: {
            maxlength: 4,
            number: true,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#relation_viclvl3_update').validate(
    {
        rules: {
           cd_relation_viclvl3: {
            minlength: 6,
            number: true,
            required: true
            },
            desc_relation_viclvl3: {
            maxlength: 80,
            required: true
            },
            cd_relation_viclvl2: {
            maxlength: 4,
            number: true,
            required: true
            },
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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


//////////////////////////////////////////////////FACILITIES//////////////////////////////////////////////////
$(document).ready(function(){
    $('#facilities_add').validate(
    {
        rules: {
            facilitycode: {
            //minlength: 11,
            required: true
            },
            facilitycodenew: {
            minlength: 4,
            required: true
            },
            section: {
            maxlength: 4,
            required: true
            },
            district: {
            required: true
            },
            PFacilityCode: {
            required: true
            },
            cd_agencytype: { 
            required: true
            },
            FullName: {
            maxlength: 180,
            required: true
            },
            Address1: {
            maxlength: 225,
            required: true
            },
//            Address2: {
//            maxlength: 30
//            },
            PostCode: {
            maxlength: 5,
            required: true
            },
            State: {
            maxlength: 3,
            required: true
            },
            TelNo1: {
            minlength: 8,
            number: true,
            required: true
            },
            FaxNo: {
            minlength: 8,
            number: true,
            required: true
            },  
            active_status: {
            maxlength: 1,
            required:  true
            }
          
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
    $('#facilities_update').validate(
    {
        rules: {
            facilitycode: {
            minlength: 11,
            required: true
            },
            section: {
            maxlength: 4,
            required: true
            },
            district: {
            required: true
            },
            PFacilityCode: {
            required: true
            },
            cd_agencytype: { 
            required: true
            },
            FullName: {
            maxlength: 180,
            required: true
            },
            Address1: {
            maxlength: 225,
            required: true
            },
            Address2: {
            maxlength: 30
            },
            PostCode: {
            maxlength: 5,
            required: true
            },
            State: {
            maxlength: 3,
            required: true
            },
            TelNo1: {
            minlength: 8,
            number: true,
            required: true
            },
            FaxNo: {
            minlength: 8,
            number: true,
            required: true
            },  
            active_status: {
            maxlength: 1,
            required:  true
            }
          
          
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
