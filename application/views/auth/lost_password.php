<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Buang snippet yang tidak diperlukan
 *                      3. Buang window.listUser = function(){)
 */
?>
<div class="row-fluid">
    <div class="span6 offset3">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="icon-refresh"></i></span>
                <h5>Lupa Kata Laluan</h5>
                <h5>Sila masukkan nombor MyKad dan alamat email yang didaftarkan dalam eMINDA.</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo tbs_horizontal_form_open('', array('id'=>'reset_password'));?>
                <?php echo tbs_horizontal_input(array('name'=>'mykad','id'=>'mykad','class'=>'input-large','maxlength'=>'12'), array('label'=>'No. MyKad'), true); ?>                
                <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','class'=>'input-large'), array('label'=>'Emel'), true); ?>                
                <div class="form-actions">
                    <button type="submit" class="btn btn-orange" id="hantar">Hantar</button>
                    <button type="reset" class="btn btn-orange" id="semula">Semula</button>
                    <button type="button" class="btn btn-orange" onclick="window.location.href='<?php echo base_url()?>'">Batal</button>
                </div>                
                <?php echo form_close();?>                
            </div>
        </div>
    </div>
</div>
<script src='<?php echo base_url('assets/validation/login.js')?>'></script>
<script>
    //window.listUser = function(){
       // AjaxCall(base_url+'index.php/admin/listJson', '', 'listUser', 'id', '', '');
    //};    
    $(document).ready(function(){
        listUser();        
        $('#hantar').live('click', function() {
            var check_validate = $('#reset_password').valid();
            if(check_validate == true){
                var $var = "";       //php variable
                $('#reset_password').find(':input').each(function(key, val){   //find all input in form and put in array
                    $var += val.name+"="+val.value+"&";
                });
                AjaxCall(base_url+'index.php/auth/reset_password', $var, '', '', 'listUser()', 'jAlert');
            }//end if
        });        
    });
</script>