<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (8 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang type="button"
 *                      4. Buang butang 'x'
 *  (25 Okt 2015)   :   1. Tambah icon refresh pada button Kemaskini
 *                      2. Tambah icon remove pada button Tutup
 */
?>
<div class="row-fluid">
    <i><b>Sila klik pada rekod ujian untuk mengaktifkan ujian ulangan atau klik pada bilangan calon untuk melihat senarai calon :</b></i><br>
    <i><b><font style=" color:  #CC0000">Makluman : Pengemaskinian tarikh ulangan hanya boleh dilakukan pada siri ujian yang tarikh tutupnya sudah tamat.</font></b></i>
</div>
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>
<div id="myModalUpdate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Kemaskini Ujian Ulangan</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'ulangan_kemaskini'));?>        
            <?php echo tbs_horizontal_input(array('name'=>'idAmbilan', 'id'=>'idAmbilan','value'=>set_value('idAmbilan', $ulangan['idAmbilan']),'class'=>'input-small','maxlength'=>'2','readonly' => 'readonly'), array('label'=>'ID Ambilan'), true);?>
            <?php echo tbs_horizontal_dropdown('kodUjian', $kodUjian_list, $ulangan['kodUjian'],array('id'=>'kodUjian','class'=>'','disabled'=>'disabled'),array('label'=>'Jenis Ujian','class'=>''),true);?>
            <?php echo tbs_horizontal_input(array('name'=>'siri', 'id'=>'siri','value'=>set_value('siri', $ulangan['siri']),'class'=>'input-small','maxlength'=>'2','readonly' => 'readonly'), array('label'=>'Siri'), true);?>        
            <?php echo tbs_horizontal_input(array('name'=>'tarikhMulaUlang','id'=>'tarikhMulaUlang','data-date-format'=>'dd-mm-yyyy','value'=>  set_value('tarikhMulaUlang', $ulangan['tarikhMulaUlang']),'class'=>'input-large','maxlength'=>'50'), array('label'=>'Dari'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'tarikhAkhirUlang','id'=>'tarikhAkhirUlang','data-date-format'=>'dd-mm-yyyy','value'=>  set_value('tarikhAkhirUlang', $ulangan['tarikhAkhirUlang']),'class'=>'input-large','maxlength'=>'50'), array('label'=>'Hingga'), true); ?>
            <?php echo tbs_horizontal_dropdown('statusUjian',$statusUjian, $ulangan['status'],array('id'=>'statusUjian','class'=>''),array('label'=>'Status Ujian','class'=>''),true);?>
        <?php echo form_close();?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<script src='<?php echo base_url('assets/validation/pengaktifan.js')?>'></script>
<script>
    window.listUser = function(){ AjaxCall(base_url+'index.php/pengaktifanUlangan/listJson_ulangan', '', 'listUser', 'id', '', ''); };    
    $(document).ready(function(){
        listUser();        
        $('#edit').live('click', function () {
            var id = $(this).attr('attr');
            var options = { 'id' : id};
            $.post(base_url+'index.php/pengaktifanUlangan/ulangan_papar', options, function(data) {
                $.each(data, function(key, value){ $("#myModalUpdate .modal-body #"+key).val( value );  });         
            }, "json");
        });        
        $('#update').live('click', function() {
            var check_validate = $('#ulangan_kemaskini').valid();
            if(check_validate == true){
               var $var = "";       //php variable
               $('#ulangan_kemaskini').find(':input').each(function(key, val){ $var += val.name+"="+val.value+"&"; });               
               AjaxCall(base_url+'index.php/pengaktifanUlangan/ulangan_kemaskini', $var, '', '', 'listUser()', 'jAlert');                             
               $('#myModalUpdate').modal('hide');
            }//end if           
        });        
        $('#myModal').on('hide', function(){
            $("#myModal .modal-body input[type='text'], #myModal .modal-body select").val('');
            $("#myModal .modal-body input[type='checkbox']").each(function(){
                $(this).attr('checked',false);
                $(this).closest('div').children('div').slideUp('fast').find('input').attr('disabled',true);
            });
        });          
        $('#tarikhMulaUlang').datepicker({
              autoclose: true,
              startDate: '<?php echo date('d-m-Y') ?>'
        }).on('hide', function(e){ $(this).valid(); });
        $('#tarikhAkhirUlang').datepicker({
              autoclose: true,
              startDate: '<?php echo date('d-m-Y') ?>'
        }).on('hide', function(e){ $(this).valid(); });
    });
</script>