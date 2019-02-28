<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang type="button"
 *                      4. Buang butang 'x'
 *  (13 Okt 2015)   :   1. Tambah data-backdrop="static" dan data-keyboard="false" pada modalbox
 *  (25 Okt 2015)   :   1. Tambah icon-ok pada button Simpan
 *                      2. Tambah icon-remove pada button Tutup
 *                      3. Tambah icon-refresh pada button Kemaskini
 */
?>
<div class="row-fluid">
    <a href="#myModal" role="button" class="btn btn-orange pull-right" data-toggle="modal"><i class="icon icon-plus icon-white"></i> Tambah Rekod</a>
</div>
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>
<!-- TAMBAH - MODUL-->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Tambah Jawapan</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'jawapan_tambah'));?>
            <?php echo tbs_horizontal_input(array('name'=>'pilihanJawapan','id'=>'pilihanJawapan','value'=>  set_value('pilihanJawapan', $jawapan['pilihanJawapan']),'class'=>'input-large','maxlength'=>'100'), array('label'=>'Pilihan Jawapan'), true); ?>    
            <?php echo tbs_horizontal_input(array('name'=>'skor','id'=>'skor','value'=>  set_value('skor', $jawapan['skor']),'class'=>'input-large','maxlength'=>'2'), array('label'=>'Skor'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'inputType','id'=>'inputType','value'=>  set_value('inputType', $jawapan['inputType']),'class'=>'input-large','maxlength'=>'20'), array('label'=>'Jenis Input'), true); ?>        
        <?php echo form_close();?>        
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="simpan"><i class="icon icon-ok icon-white"></i> Simpan</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<!-- PAPAR - MODUL -->
<div id="myModalView" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Papar Jawapan</h3>
    </div>
    <div class="modal-body">        
        <?php echo tbs_horizontal_form_open('', array('id'=>'jawapan_papar'));?>     
            <?php echo tbs_horizontal_input(array('name'=>'idJawapan','id'=>'idJawapan','value'=>set_value('idJawapan', $jawapan['idJawapan']),'class'=>'input-small','maxlength'=>'2','readonly' => 'readonly'), array('label'=>'ID Jawapan'), true);?>        
            <?php echo tbs_horizontal_input(array('name'=>'pilihanJawapan','id'=>'pilihanJawapan','value'=>  set_value('pilihanJawapan', $jawapan['pilihanJawapan']),'class'=>'input-large','maxlength'=>'100','readonly' => 'readonly'), array('label'=>'Pilihan Jawapan'), true); ?>    
            <?php echo tbs_horizontal_input(array('name'=>'skor','id'=>'skor','value'=>  set_value('skor', $jawapan['skor']),'class'=>'input-large','maxlength'=>'2','readonly' => 'readonly'), array('label'=>'Skor'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'inputType','id'=>'inputType','value'=>  set_value('inputType', $jawapan['inputType']),'class'=>'input-large','maxlength'=>'20','readonly' => 'readonly'), array('label'=>'Jenis Input'), true); ?>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>             
</div>
<!-- KEMASKINI - MODUL -->
<div id="myModalUpdate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Kemaskini Jawapan</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'jawapan_kemaskini'));?>        
            <?php echo tbs_horizontal_input(array('name'=>'idJawapan','id'=>'idJawapan','value'=>set_value('idJawapan', $jawapan['idJawapan']),'class'=>'input-small','maxlength'=>'2','readonly' => 'readonly'), array('label'=>'ID Jawapan'), true);?> 
            <?php echo tbs_horizontal_input(array('name'=>'pilihanJawapan','id'=>'pilihanJawapan','value'=>  set_value('pilihanJawapan', $jawapan['pilihanJawapan']),'class'=>'input-large','maxlength'=>'100'), array('label'=>'Pilihan Jawapan'), true); ?> 
            <?php echo tbs_horizontal_input(array('name'=>'skor','id'=>'skor','value'=>  set_value('skor', $jawapan['skor']),'class'=>'input-large','maxlength'=>'2'), array('label'=>'Skor'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'inputType','id'=>'inputType','value'=>  set_value('inputType', $jawapan['inputType']),'class'=>'input-large','maxlength'=>'20'), array('label'=>'Jenis Input'), true); ?>        
        <?php echo form_close();?> 
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<script src='<?php echo base_url('assets/validation/maintenance.js')?>'></script>
<script>
    window.listUser = function(){ AjaxCall(base_url+'index.php/maintenance/listJson_jawapan', '', 'listUser', 'id', '', ''); };    
    $(document).ready(function(){
        listUser();
        $('#view').live('click', function () {
            var id = $(this).attr('attr');
            var options = {'id' : id};
            $.post(base_url+'index.php/maintenance/jawapan_papar', options, function(data) {
                $.each(data, function(key, value){ $("#myModalView .modal-body #"+key).val( value ); });         
            }, "json");
        });
        $('#edit').live('click', function () {
            var id = $(this).attr('attr');
            var options = { 'id' : id};
            $.post(base_url+'index.php/maintenance/jawapan_papar', options, function(data) {
                $.each(data, function(key, value){ $("#myModalUpdate .modal-body #"+key).val( value );  });         
            }, "json");
        });
        $('#simpan').live('click', function() {
            var check_validate = $('#jawapan_tambah').valid();           
            if(check_validate == true){               
               var $var = "";       //php variable
               $('#jawapan_tambah').find(':input').each(function(key, val){$var += val.name+"="+val.value+"&";});               
               AjaxCall(base_url+'index.php/maintenance/jawapan_tambah', $var, '', '', 'listUser()', 'jAlert');                             
               $('#myModal').modal('hide');
            }           
        });
        $('#update').live('click', function() {
           var check_validate = $('#jawapan_kemaskini').valid();           
           if(check_validate == true){               
               var $var = "";       //php variable
               $('#jawapan_kemaskini').find(':input').each(function(key, val){$var += val.name+"="+val.value+"&";});               
               AjaxCall(base_url+'index.php/maintenance/jawapan_kemaskini', $var, '', '', 'listUser()', 'jAlert');                             
               $('#myModalUpdate').modal('hide');
           }           
        });
        $('#delete').live('click', function() {
            var con = confirm('Adakah Anda Pasti Untuk Hapuskan Rekod?');
            if(con == true){ AjaxCall(base_url+'index.php/maintenance/jawapan_hapus', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert'); }
            else{ return false; }
        });
        $('#myModal').on('hide', function(){
              $("#myModal .modal-body input[type='text'], #myModal .modal-body select").val('');
              $("#myModal .modal-body input[type='checkbox']").each(function(){
                  $(this).attr('checked',false);
                  $(this).closest('div').children('div').slideUp('fast').find('input').attr('disabled',true);
              });
          }); 
    });        
</script>