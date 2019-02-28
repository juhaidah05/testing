<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. 
 */
?>
<div class="row-fluid">
    <div class="span6 offset3">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="icon-ok"></i></span>
                <h5>Anda telah berjaya Login. Sila Tukar Kata Laluan.</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo tbs_horizontal_form_open('', array('id'=>'change_password'));?>
                    <?php echo tbs_horizontal_password(array('name'=>'old_password','id'=>'old_password','value'=>set_value('old_password', $user['old_password']),'class'=>''), array('label'=>'Kata Laluan Sedia Ada'), true);?>
                    <?php echo tbs_horizontal_password(array('name'=>'new_password','id'=>'new_password','value'=>set_value('new_password', $user['new_password']),'class'=>''), array('label'=>'Kata Laluan Baru'), true);?>
                    <?php echo tbs_horizontal_password(array('name'=>'new_cpassword','id'=>'new_cpassword','value'=>set_value('new_cpassword', $user['new_cpassword']),'class'=>''), array('label'=>'Pengesahan Kata Laluan Baru'), true);?>        
                    <div class="form-actions">
                        <button type="submit" class="btn btn-orange"><i class="icon icon-play icon-white"></i> Simpan</button>
                        <?php echo nbs(3); ?>
                        <a class="btn" href="<?php echo base_url()?>"><i class="icon icon-remove"></i> Batal</a>
                    </div>        
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<script src='<?php echo base_url('assets/validation/login.js')?>'></script>