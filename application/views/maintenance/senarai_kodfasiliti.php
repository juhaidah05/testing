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
        <h3 id="myModalLabel">Tambah Kod Fasiliti</h3>
    </div>
    <div class="modal-body">    
        <?php echo tbs_horizontal_form_open('', array('id'=>'kodfasiliti_tambah'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodFasiliti','id'=>'kodFasiliti','value'=>set_value('kodFasiliti', $kodfasiliti['kodFasiliti']),'class'=>'input-small','maxlength'=>'15'), array('label'=>'Kod Fasiliti'), true);?>    
            <?php echo tbs_horizontal_input(array('name'=>'perihalFasiliti','id'=>'perihalFasiliti','value'=>  set_value('perihalFasiliti', $kodfasiliti['perihalFasiliti']),'class'=>'input-large','maxlength'=>'100'), array('label'=>'Perihal Fasiliti'), true); ?> 
            <?php echo tbs_horizontal_dropdown('kodJenisFasiliti', $kodJenisFasiliti_list, $data['kodJenisFasiliti'],array('id'=>'kodJenisFasiliti','class'=>''),array('label'=>'Jenis Fasiliti','class'=>''),true);?>
            <?php echo tbs_horizontal_input(array('name'=>'lokalitiPentadbir','id'=>'lokalitiPentadbir','value'=>  set_value('lokalitiPentadbir', $kodfasiliti['lokalitiPentadbir']),'class'=>'input-large','maxlength'=>'15'), array('label'=>'Lokaliti Pentadbir'), true); ?>
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
        <h3 id="myModalLabel">Papar Kod Fasiliti</h3>
    </div>
    <div class="modal-body">        
        <?php echo tbs_horizontal_form_open('', array('id'=>'kodfasiliti_papar'));?>     
            <?php echo tbs_horizontal_input(array('name'=>'kodFasiliti','id'=>'kodFasiliti','value'=>set_value('kodFasiliti', $kodfasiliti['kodFasiliti']),'class'=>'input-small','maxlength'=>'15','readonly' => 'readonly'), array('label'=>'Kod Fasiliti'), true);?>  
            <?php echo tbs_horizontal_input(array('name'=>'perihalFasiliti','id'=>'perihalFasiliti','value'=>  set_value('perihalFasiliti', $kodfasiliti['perihalFasiliti']),'class'=>'input-large','maxlength'=>'100','readonly' => 'readonly'), array('label'=>'Perihal Fasiliti'), true); ?>  
            <?php echo tbs_horizontal_dropdown('kodJenisFasiliti', $kodJenisFasiliti_list, $data['kodJenisFasiliti'],array('id'=>'kodJenisFasiliti','class'=>'','disabled'=>'disabled'),array('label'=>'Jenis Fasiliti','class'=>''),true);?>
            <?php echo tbs_horizontal_input(array('name'=>'lokalitiPentadbir','id'=>'lokalitiPentadbir','value'=>  set_value('lokalitiPentadbir', $kodfasiliti['lokalitiPentadbir']),'class'=>'input-large','maxlength'=>'15','readonly' => 'readonly'), array('label'=>'Lokaliti Pentadbir'), true); ?>
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
        <h3 id="myModalLabel">Kemaskini Kod Fasiliti</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kodfasiliti_kemaskini'));?>        
            <?php echo tbs_horizontal_input(array('name'=>'kodFasiliti','id'=>'kodFasiliti','value'=>set_value('kodFasiliti', $kodfasiliti['kodFasiliti']),'class'=>'input-small','maxlength'=>'15','readonly' => 'readonly'), array('label'=>'Kod Fasiliti'), true);?>     
            <?php echo tbs_horizontal_input(array('name'=>'perihalFasiliti','id'=>'perihalFasiliti','value'=>  set_value('perihalFasiliti', $kodfasiliti['perihalFasiliti']),'class'=>'input-large','maxlength'=>'100'), array('label'=>'Perihal Fasiliti'), true); ?> 
            <?php echo tbs_horizontal_dropdown('kodJenisFasiliti', $kodJenisFasiliti_list, $data['kodJenisFasiliti'],array('id'=>'kodJenisFasiliti','class'=>''),array('label'=>'Jenis Fasiliti','class'=>''),true);?>
            <?php echo tbs_horizontal_input(array('name'=>'lokalitiPentadbir','id'=>'lokalitiPentadbir','value'=>  set_value('lokalitiPentadbir', $kodfasiliti['lokalitiPentadbir']),'class'=>'input-large','maxlength'=>'15'), array('label'=>'Lokaliti Pentadbir'), true); ?>
        <?php echo form_close();?>   
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<script src='<?php echo base_url('assets/validation/maintenance.js')?>'></script>
<script>
    window.listUser = function(){ AjaxCall(base_url+'index.php/maintenance/listJson_kodfasiliti', '', 'listUser', 'id', '', ''); };    
    $(document).ready(function(){
        listUser();
       $('#view').live('click', function () {
            var id = $(this).attr('attr');
            var options = { 'id' : id }; 
            $.post(base_url+'index.php/maintenance/kodfasiliti_papar', options, function(data) {
                $.each(data, function(key, value){  $("#myModalView .modal-body #"+key).val( value );   });         
            }, "json");
        });
        $('#edit').live('click', function () {
            var id = $(this).attr('attr');
            var options = {  'id' : id };
            $.post(base_url+'index.php/maintenance/kodfasiliti_papar', options, function(data) {
                $.each(data, function(key, value){ $("#myModalUpdate .modal-body #"+key).val( value );  });         
            }, "json");
        });
        $('#simpan').live('click', function() {
            var check_validate = $('#kodfasiliti_tambah').valid();           
            if(check_validate == true){               
                var $var = "";       //php variable
                $('#kodfasiliti_tambah').find(':input').each(function(key, val){ $var += val.name+"="+val.value+"&"; });               
                AjaxCall(base_url+'index.php/maintenance/kodfasiliti_tambah', $var, '', '', 'listUser()', 'jAlert');                             
                $('#myModal').modal('hide');
            }//end if           
        });
        $('#update').live('click', function() {
            var check_validate = $('#kodfasiliti_kemaskini').valid();           
            if(check_validate == true){               
                var $var = "";       //php variable
                $('#kodfasiliti_kemaskini').find(':input').each(function(key, val){  $var += val.name+"="+val.value+"&"; });               
                AjaxCall(base_url+'index.php/maintenance/kodfasiliti_kemaskini', $var, '', '', 'listUser()', 'jAlert');                             
                $('#myModalUpdate').modal('hide');
            }//end if           
        });
          $('#delete').live('click', function() {
            var con = confirm('Adakah Anda Pasti Untuk Hapuskan Rekod?');
            if(con == true){ AjaxCall(base_url+'index.php/maintenance/kodfasiliti_hapus', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert'); }
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