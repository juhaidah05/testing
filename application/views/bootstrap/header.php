<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Buang snippet yang tidak diperlukan
 *                      3. Semak html5 element for standard code
 *	(4 Apr 2016)	:	1. Tambah trigger utk #btn_batal_change_password supaya form reset apabila user menekan butang BATAL
 */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <META http-equiv="PRAGMA" CONTENT="NO-CACHE"/>
        <META http-equiv="CACHE-CONTROL" CONTENT="NO-CACHE" max-age="0"/>
        <META http-equiv="EXPIRES" CONTENT="0"/>
        <title><?php echo $this->config->item('site_name')?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
    	<?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>
    	
        <script>var base_url="<?php echo base_url(); ?>";</script>
        <!-- Le styles -->
        <link href="<?php echo base_url()?>assets/css/bootstrap.css" rel="stylesheet"/>
        <link href="<?php echo base_url()?>assets/css/bootstrap_isis.css" rel="stylesheet"/>
        <link href="<?php echo base_url()?>assets/css/DT_bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url()?>assets/css/my_style.css" rel="stylesheet"/>
        <link href="<?php echo base_url()?>assets/css/kotak.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jAlert/jAlert.css"/>        
        <link href="<?php echo base_url()?>assets/css/bootstrap-responsive.css" rel="stylesheet"/>
    	
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chimss.css"/>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url()?>assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url()?>assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url()?>assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>assets/ico/apple-touch-icon-57-precomposed.png">
	 
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/php.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.js"></script>
        <link href="<?php echo base_url()?>assets/datepicker/css/datepicker.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/fscharts/FusionCharts.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url()?>assets/js/jquery.dataTable.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jAlert/jAlert.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/datatable.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ajax_call.js"></script>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript">			
            window.history.forward(1);
            (function(window, location) {
                    history.replaceState(null, document.title, location.pathname+"");
                    history.pushState(null, document.title, location.pathname);
                    window.addEventListener("popstate", function() {
                      if(location.hash === "") {
                            history.replaceState(null, document.title, location.pathname);
                            setTimeout(function(){
                              location.replace('<?php echo base_url()?>');
                            },0);
                      }
                    }, false);
            }(window, location));
            $(function(){
                $('#btn_logout_sah').click(function(){
                    var path = '<?php echo base_url('index.php/auth/logout')?>';
                    $.ajax({
                        url: path,
                        success : function(data){
                            if(data=true){
                                window.location.replace ( '<?php echo base_url('index.php/auth/login')?>' ); 
                                window.history.forward();
                            } 
                        }
                    });
                });
				
				$('#btn_batal_change_password').click(function(){
					$('#new_password').val('');
					$('#new_cpassword').val('');
                    location.reload();
                });	
            });	
        </script>
    </head>
    