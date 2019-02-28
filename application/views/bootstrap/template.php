<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Buang snippet yang tidak diperlukan
 */
?>
    <?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>
    <?php echo $this->load->view($this->config->item('template_folder').'/header');?>

    <body onload="" id="dt_example" data-spy="scroll" data-target=".subnav" data-offset="50">
    	<div id="wrapper">
            <header id="header" class="container">
		<?php 
                    $logo_link = "<a href= '".site_url()."' ><img src='".base_url('assets/img/logo.png')."'></a>"; 
                    $title_link = "<a href= '".site_url()."' ><img src='".base_url('assets/img/designbanner.png')."'></a>"; 
                    $bg_link = "<a href= '".site_url()."' ><img src='".base_url('assets/img/kkm_old.png')."'></a>"; 
                ?>
               	<div id="top" class="row-fluid">
                    <div id="logo" class="span12"><?php echo "<img src='".base_url('assets/img/designbanner_apps.png')."' width='100%'>"; ?></div>
            	</div>
                <?php $this->load->view($this->config->item('template_folder').'/top_menu') ?>
            </header>        
            <div class="container" id="content" style="<?php echo $style; ?>">
            	<div class="row-fluid">
                    <div class="span12">
                    <?php $this->load->view('flashNotification'); ?>
                    <?php if($title): ?>
                    <div class="page-header"><h4><?php echo $title; ?></h4></div>
                    <?php endif; ?>
                    <?php $this->load->view($this->content_view);?>
                    </div>
                </div>
            </div>                
            <div id="push"></div>
        </div> 
    	<!--div id="bottom"><?php //echo $this->load->view($this->config->item('template_folder').'/footer');?></div-->
        <br/>
        <br/>
        <footer id="footer" class="container">
            <div>
                <div class="span9 offset1" align="center">
                    <strong><?php /*?>Copyright  2013<?php //echo (date('Y') > '2013')? '-'.date('Y') : ''; ?><?php */?>
					Hakcipta Terpelihara © 2016 - Kementerian Kesihatan Malaysia<br>
					PENAFIAN: Kementerian Kesihatan Malaysia tidak akan bertanggungjawab ke atas sebarang kehilangan atau kerosakan yang diakibatkan oleh penggunaan maklumat yang dicapai daripada portal ini.
					Paparan terbaik menggunakan Mozilla Firefox dengan resolusi 1024 x 768. 
					
                    <br /><br />
                    Sekiranya Mempunyai Masalah Teknikal, Sila Hubungi Kami :
                    <address>Email : helpdesk@moh.gov.my <br>Tel : 03-88833883</address>              
                </strong>           
                </div>
            </div> 		   
        </footer>
        <script src="<?php echo base_url()?>assets/js/bootstrap.js" type="text/javascript"></script>
        <?php if($this->config->item('debug')){ ?><?php $this->load->view('debug');?><?php } ?>
    
    </body>
</html>    