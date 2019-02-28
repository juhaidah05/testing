<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (8 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<div class="row-fluid">
    <div class="span10 offset1">
        <div class="widget-box">
            <div class="widget-content nopadding">
                <?php

				
				 echo tbs_horizontal_form_open('notis/selenggara_notis', array('id'=>'selenggara_notis'));?>
                    <?php echo tbs_horizontal_input(array('name'=>'tajuknotis','id'=>'tajuknotis','value'=>set_value('tajukNotis', $papar['tajukNotis']),'class'=>'input-xxlarge','placeholder'=>'-- Sila taip tajuk emel di sini -- '), array('label'=>'Tajuk Notis:'), true);  ?>
<?php 
		
echo htmlspecialchars_decode(tbs_horizontal_textarea(array('name'=>'templatenotis','id'=>'templatenotis',
'value'=>set_value('notis', $papar['notis']),
'class'=>'input-xxlarge',
'placeholder'=>' -- Sila taip notis peringatan di sini -- '),
 array('label'=>'Template Notis:'), true)); ?>
                    <div style="margin:10px auto">    
                        <div class="text-center">  
                            <button type= "submit" class="btn btn-primary" id="simpan"><i class="icon icon-refresh icon-white"></i> Kemaskini </button>
                            <a class="btn btn-orange" href="<?php echo site_url('notis/selenggara_emel/'.$id)?>"><i class="icon-envelope icon-white"></i> Selenggara Emel</a>
                        </div>    
                    </div>                       
                <?php echo form_close();?>
            </div> 
        </div>    
        <script src='<?php echo base_url('assets/validation/notis.js')?>'></script> 
    </div>       
</div>