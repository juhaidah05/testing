<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Buang window.listUser = function(){}
 */
?>
<div class="row-fluid">
    <div class="span5">
        <b><h5> Aplikasi Saringan Minda Sihat (eMINDA)</h5></b><br>
        <p align="justify">Aplikasi Saringan Minda Sihat (eMINDA) merupakan aplikasi alat
        ukur Psikologi yang direkabentuk khas untuk mengukur tahap
        kemurungan (Depression), tahap kebimbangan (Anxiety) dan tahap
        tekanan (Stress) anggota Kementerian Kesihatan Malaysia. Aplikasi
        ini mengguna pakai alat Ujian DASS iaitu Depression, Anxiety and
        Stress Scale.</p>
    </div>
    <div class="span6 offset1">
    	<div class="widget-box">
            <div class="widget-title">
            	<span class="icon"><i class="icon-lock"></i></span>
                <h5>LOG MASUK</h5>
            </div>
            <div class="widget-content nopadding">
                <span class="visible-phone"><br></span>
                <?php echo form_open('', array('class'=>'form-horizontal', 'id'=>'form_login')); ?>
                    <div class="control-group <?php if(form_error('username')){ echo "error"; } ?>">
                        <label class="control-label">No. MyKad</label>
                        <div class="controls">
                            <?php echo form_input('username', $username, 'class="input-large" id="username" maxlength="12"'); ?>
                            <?php echo form_error('username', '<span class="help-inline">', "</span>")?>
                        </div>
                    </div>
                    <div class="control-group <?php if(form_error('password')){ echo "error"; } ?>">
                        <label class="control-label">Kata Laluan</label>
                        <div class="controls">
                            <?php echo form_password('password', '', 'class="input-large" id="password" maxlength="32"'); ?>
                            <?php echo form_error('password', '<span class="help-inline">', "</span>")?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-orange"><i class="icon icon-lock icon-white"></i> Log Masuk</button>
                        <?php echo nbs(3); ?>
                        <a href="#myModal" role="button" class="btn" data-toggle="modal"><i class="icon icon-question-sign"></i> Lupa Kata Laluan?</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div> 
</div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h3 id="myModalLabel">Lupa Kata Laluan</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <i><b>Sila masukkan nombor MyKad dan alamat email yang didaftarkan dalam eMINDA.</b></i>
        </div><br>
        <?php echo tbs_horizontal_form_open('', array('id'=>'lupa_password'));?>        
        <?php echo tbs_horizontal_input(array('name'=>'mykad','id'=>'mykad','value'=>  set_value('mykad', $user['mykad']),'class'=>'input-large','maxlength'=>'12'), array('label'=>'No. Mykad'), true); ?>        
        <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $user['emel']),'class'=>'input-large'), array('label'=>'Emel'), true); ?>        
        <?php echo form_close();?>        
    </div>
    <div class="modal-footer">
        <button class="btn btn-orange" id="simpan">Hantar</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true">Tutup</button>
    </div>          
</div>
<script src="<?php echo base_url('assets/validation/login.js');?>"></script>
<script>
    $(document).ready(function(){
        $('#simpan').live('click', function() {
           var check_validate = $('#lupa_password').valid();           
           if(check_validate == true){               
               var $var = "";       //php variable
               $('#lupa_password').find(':input').each(function(key, val){   //find all input in form and put in array
                   $var += val.name+"="+val.value+"&";
               });               
               AjaxCall(base_url+'index.php/auth/lupa_password', $var, '', '', 'listUser()', 'jAlert');                             
               $('#myModal').modal('hide');
           }//end if           
        });        
    });
    $('#myModal').on('hide', function(){
          $("#myModal .modal-body input[type='text'], #myModal .modal-body select").val('');
          $("#myModal .modal-body input[type='checkbox']").each(function(){
              $(this).attr('checked',false);
              $(this).closest('div').children('div').slideUp('fast').find('input').attr('disabled',true);
          });
      }); 
</script>