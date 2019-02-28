
window.AjaxCall=function(url,postdata,returnid,type,callback,returnType){
    //alert(url+postdata+returnid+type+callback+returnType);  
  
    $.ajax
    ({
        type: "POST",
        url: url,
        beforeSend: function()
        {    
            if((type=="class")&&(!empty(returnid))){                    
                 $("."+returnid).html("<img  height='25%' src='"+base_url+"assets/img/loading.gif'>");
            }else if(!empty(returnid)){
               $("#"+returnid).html("<img height='25%' src='"+base_url+"assets/img/loading.gif'>");      
            }
        },
        data:postdata, //+"&LN="+ln,
        cache: false,
        success: function(html)
        {
            if(empty(returnType)){
                if((type=="class")&&(!empty(returnid))){
                    $("."+returnid).html("");
                    $("."+returnid).html(html);
                }else if(!empty(returnid)){
                    $("#"+returnid).html("");
                    $("#"+returnid).html(html);
                }
                $(document).ready(function(){                      
                    if(!empty(callback)){
                        $("#callback").html("<script>"+callback+"</script>");
                    }
                });
            }else{
                 
                //alert(html);
                if(returnType=="alert"){
                   $.jGrowl(html, { header: 'Info' });  
                }else if(returnType=="jAlert"){
                    jAlert(html);
                }else if(html.search("<script>")>=0){
                    $("#callback").html(html);
                }else if(returnType=="returnType"){
                     $("#returnType").html(html);
                }else{
                    $("#"+returnType).html(html);
                }
                $(document).ready(function(){                      
                    if(!empty(callback)){
                        $("#callback").html("<script>"+callback+"</script>");
                    }
                });
            }
        },
        error:function (e, XHR, options){
            if(e.status==0){
                jAlert('You are offline!!\n Please Check Your Network.');
            }else if(e.status==404){
                jAlert('Requested URL not found.');
            }else if(e.status==500){
                jAlert('Internel Server Error.');
            }else if(e.status=='parsererror'){
                jAlert('Error.\nParsing JSON Request failed.');
            }else if(e.status=='timeout'){
                jAlert('Request Time out.');
            }else if(e.status==789){
                jAlert('Authentication failed or Permission denied.');
            }else {
                jAlert("Server is not responding. Data is not saved.Please re-login.");
            }
        }
    });
};