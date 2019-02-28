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
<!-- ADD - KOD KUMPULAN PERKHIDMATAN -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Tambah Kod Kumpulan Perkhidmatan</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kodkumpulan_add'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodKumpulan', 'id'=>'kodKumpulan','value'=>set_value('kodKumpulan', $_kodKumpulanPerkhidmatan['kodKumpulan']),'class'=>'input-large','maxlength'=>'4'), array('label'=>'Kod'), true);?>
            <?php echo tbs_horizontal_input(array('name'=>'perihalKumpulan','id'=>'perihalKumpulan','value'=>  set_value('perihalKumpulan', $_kodKumpulanPerkhidmatan['perihalKumpulan']),'class'=>'','maxlength'=>'100'), array('label'=>'Keterangan'), true); ?>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="simpan"><i class="icon icon-ok icon-white"></i> Simpan</button>   
        <button type="button" class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<!-- VIEW - KOD KUMPULAN PERKHIDMATAN-->
<div id="myModalView" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Papar Penempatan</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kodkumpulan_view'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodKumpulan','id'=>'kodKumpulan','value'=>set_value('kodKumpulan', $_kodKumpulanPerkhidmatan['kodKumpulan']),'class'=>'input-large','maxlength'=>'4','readonly' => 'readonly'), array('label'=>'Kod'), true);?>
            <?php echo tbs_horizontal_input(array('name'=>'perihalKumpulan','id'=>'perihalKumpulan','value'=>  set_value('perihalKumpulan', $_kodKumpulanPerkhidmatan['perihalKumpulan']),'class'=>'','maxlength'=>'100','readonly' => 'readonly'), array('label'=>'Keterangan'), true); ?>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>             
</div>
<!-- UPDATE - KOD KUMPULAN PERKHIDMATAN -->
<div id="myModalUpdate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Kemaskini Penempatan</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kodkumpulan_update'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodKumpulan', 'id'=>'kodKumpulan','value'=>set_value('kodKumpulan', $_kodKumpulanPerkhidmatan['kodKumpulan']),'class'=>'input-large','maxlength'=>'4','readonly' => 'readonly'), array('label'=>'Kod'), true);?>
            <?php echo tbs_horizontal_input(array('name'=>'perihalKumpulan','id'=>'perihalKumpulan','value'=>  set_value('perihalKumpulan', $_kodKumpulanPerkhidmatan['perihalKumpulan']),'class'=>'','maxlength'=>'100'), array('label'=>'Keterangan'), true); ?>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
        <button type="button" class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<script src='<?php echo base_url('assets/validation/maintenance2.js')?>'></script>
<script>
    window.listUser = function(){ AjaxCall(base_url+'index.php/maintenance/listJson_kodkumpulan', '', 'listUser', 'id', '', ''); };
    $(document).ready(function(){
        listUser();
        $('#view').live('click', function () {
            var id = $(this).attr('attr');
            var options = {'id' : id};
            $.post(base_url+'index.php/maintenance/kodkumpulan_view', options, function(data) {
                $.each(data, function(key, value){$("#myModalView .modal-body #"+key).val( value );});         
            }, "json");
        });
        $('#edit').live('click', function () {
            var id = $(this).attr('attr');
            var options = {'id' : id};
            $.post(base_url+'index.php/maintenance/kodkumpulan_view', options, function(data) {
                $.each(data, function(key, value){$("#myModalUpdate .modal-body #"+key).val( value );});         
            }, "json");
        });       
        $('#simpan').live('click', function() {
            var check_validate = $('#kodkumpulan_add').valid();
            if(check_validate == true){
                var $var = "";       //php variable
                $('#kodkumpulan_add').find(':input').each(function(key, val){ $var += val.name+"="+val.value+"&"; });
                AjaxCall(base_url+'index.php/maintenance/kodkumpulan_add', $var, '', '', 'listUser()', 'jAlert');
                $('#myModal').modal('hide');
           }//end if           
        });     
        $('#update').live('click', function() {
            var check_validate = $('#kodkumpulan_update').valid();           
            if(check_validate == true){               
               var $var = "";
               $('#kodkumpulan_update').find(':input').each(function(key, val){   //find all input in form and put in array
                   $var += val.name+"="+val.value+"&";
               });
               AjaxCall(base_url+'index.php/maintenance/kodkumpulan_update', $var, '', '', 'listUser()', 'jAlert');                             
               $('#myModalUpdate').modal('hide');
           }           
        });
        $('#delete').live('click', function() {
            var con = confirm('Adakah Anda Pasti Untuk Hapuskan Rekod?');
            if(con == true){ AjaxCall(base_url+'index.php/maintenance/kodkumpulan_delete', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert');}
            else{ return false;}
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