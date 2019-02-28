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
        <br/>
        <br/>
        <footer id="footer" class="container">
            <div>
                <div class="span9 offset1" align="center">
                    <strong><?php /*?>Copyright  2013<?php //echo (date('Y') > '2013')? '-'.date('Y') : ''; ?><?php */?>
                    Hakcipta Terpelihara © 2016 - Kementerian Kesihatan Malaysia<br>
					PENAFIAN: Kementerian Kesihatan Malaysia tidak akan bertanggungjawab ke atas sebarang kehilangan atau kerosakan yang diakibatkan oleh penggunaan maklumat yang dicapai daripada portal ini.
					Paparan terbaik menggunakan Mozilla Firefox dengan resolusi 1024 x 768. 
					
                    <br />
                    <h7><b>Sekiranya Mempunyai Masalah Teknikal, Sila Hubungi Kami : </b></h7>
                    <address>Email : helpdesk@moh.gov.my <br>Tel : 03-88833883</address>             
                </strong>           
                </div>
            </div> 		   
        </footer>
        <script src="<?php echo base_url()?>assets/js/bootstrap.js" type="text/javascript"></script>
        <?php if($this->config->item('debug')){ ?><?php $this->load->view('debug');?><?php } ?>    
    
