<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   Mariatulkibtiah Arshad
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (8 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang type="button"
 *                      4. Buang butang 'x'
 *                      5. Tukar <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> kepada
 *                      <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true" id="button_tutup">Tutup</button>
 *  (13 Okt 2015)   :   1. Tambah data-backdrop="static" dan data-keyboard="false" pada modalbox
 *  (25 Okt 2015)   :   1. Ubah class button Cari kepada btn-primary
 *                      2. Ubah class button Reset kepada btn-grey
 *                      3. Ubah class button Tambah Rekod kepada btn-orange
 *  (2 Nov 2015)    :   1. Tambah snippet javascript supaya mengawal input field
 *                         bagi #tahun supaya hanya menerima nilai nombor dan 
 *                         terhad kepada 4 aksara sahaja
 *						2. Baiki semula butang Cari kerana tidak berfungsi dengan betul 
 */
?>
<div class="row-fluid">
    <div class="span6 offset3">
        <div class="widget-box">
            <div class="widget-content nopadding">
                <?php echo tbs_horizontal_form_open('', array('id'=>'senggara_ujian'));?>               
                    <!-- Dropdown Untuk kod ujian -->        
                    <?php echo tbs_horizontal_dropdown('kodUjian', $list_kodUjian, $data['kodUjian'],array('id'=>'kodUjian','class'=>''),array('label'=>'Jenis Ujian','class'=>''),false);?>   
                    <!-- Dropdown Untuk list siri -->        
                    <?php echo tbs_horizontal_dropdown('siri',$list_siri, $data['siri'],array('id'=>'siri','class'=>''),array('label'=>'Siri','class'=>''),false);?>       
                    <?php echo tbs_horizontal_input(array('name'=>'tahun','id'=>'tahun','value'=>  set_value('tahun', $data['tahun']),'class'=>'input-small'), array('label'=>'Tahun','desc'=>'Contoh: 2015'), false); ?>
                    <!-- Dropdown Untuk STATUS AKTIF -->        
                    <?php echo tbs_horizontal_dropdown('statusUjian',$list_status_searching, $data['statusUjian'],array('id'=>'statusUjian','class'=>''),array('label'=>'Status','class'=>''),false);?>                    
                    <div style="margin:10px auto">    
                        <div class="text-center">
                            <button type="button" class="btn btn-primary search"><i class="icon icon-search icon-white"></i> Cari</button>
                            <button type="reset" id="batal" class="btn btn-grey"><i class="icon icon-repeat"></i> Reset</button>
                            <a href="#myModal_Tambah" role="button" class="btn btn-orange" data-toggle="modal"><i class="icon icon-plus icon-white"></i> Tambah Rekod</a>
                        </div> 
                    </div>
                <?php echo form_close();?>
            </div>  
        </div>
    </div>
</div>    
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>
<!-- papar senggara data -->
<div id="myModalView" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Papar Siri Pengaktifan Ujian</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'senggara_ujianPapar'));?>
            <?php echo tbs_horizontal_input(array('name'=>'idAmbilan','id'=>'idAmbilan','value'=>  set_value('idAmbilan', $ambilan['idAmbilan']),'class'=>'input-small','readonly' => 'readonly'), array('label'=>'ID Ambilan'), false); ?>
            <!-- Dropdown Untuk kod ujian -->        
            <?php echo tbs_horizontal_dropdown('kodUjian', $list_kodUjian, $ambilan['kodUjian'],array('id'=>'kodUjian','class'=>'','disabled'=>'disabled'),array('label'=>'Jenis Ujian','class'=>''),false);?>  
            <!-- Dropdown Untuk list siri -->        
            <?php echo tbs_horizontal_dropdown('siri',$list_siri, $ambilan['siri'],array('id'=>'siri','class'=>'','disabled'=>'disabled'),array('label'=>'Siri','class'=>''),false);?>       
            <?php echo tbs_horizontal_input(array('name'=>'tahun','id'=>'tahun','value'=>  set_value('tahun', $ambilan['tahun']),'class'=>'input-small','readonly' => 'readonly'), array('label'=>'Tahun'), false); ?>
            <?php echo tbs_horizontal_input(array('name'=>'tarikhBuka_papar','id'=>'tarikhBuka_papar','data-date-format'=>'dd-mm-yyyy','value'=>  set_value('tarikhBuka_papar', $ambilan['tarikhBuka_papar']),'class'=>'input-large','maxlength'=>'50','disabled'=>'disabled'), array('label'=>'Dari'), false); ?>
            <?php echo tbs_horizontal_input(array('name'=>'tarikhTutup_papar','id'=>'tarikhTutup_papar','data-date-format'=>'dd-mm-yyyy','value'=>  set_value('tarikhTutup_papar', $ambilan['tarikhTutup_papar']),'class'=>'input-large','maxlength'=>'50','disabled'=>'disabled'), array('label'=>'Hingga'), false); ?>
            <!-- Dropdown Untuk STATUS AKTIF -->        
            <?php echo tbs_horizontal_dropdown('statusUjian',$list_status_searching, $ambilan['statusUjian'],array('id'=>'statusUjian','class'=>'','disabled'=>'disabled'),array('label'=>'Status','class'=>''),false);?>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <!--button class="btn" data-dismiss="modal" aria-hidden="true">Close</button-->
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true" id="button_tutup"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>             
</div>
<!--kemaskini-->
<div id="myModalUpdate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Kemaskini Siri Pengaktifan Ujian</h3>
    </div>
    <div class="modal-body">          
        <?php echo tbs_horizontal_form_open('', array('id'=>'senggara_ujianKemaskini'));?>          
            <?php echo tbs_horizontal_input(array('name'=>'idAmbilan','id'=>'idAmbilan','value'=>  set_value('idAmbilan', $ambilan['idAmbilan']),'class'=>'input-small','readonly' => 'readonly'), array('label'=>'ID Ambilan'), false); ?>
            <?php echo tbs_horizontal_dropdown('kodUjian', $list_kodUjian, $ambilan['kodUjian'],array('id'=>'kodUjian','class'=>'','disabled'=>'disabled'),array('label'=>'Jenis Ujian','class'=>''),false);?>  
            <!-- Dropdown Untuk list siri -->        
            <?php echo tbs_horizontal_dropdown('siri',$list_siri, $ambilan['siri'],array('id'=>'siri','class'=>'','disabled'=>'disabled'),array('label'=>'Siri','class'=>''),false);?>       
            <?php echo tbs_horizontal_input(array('name'=>'tahun','id'=>'tahun','value'=>  set_value('tahun', $ambilan['tahun']),'class'=>'input-small','readonly' => 'readonly'), array('label'=>'Tahun'), false); ?>
            <?php echo tbs_horizontal_input(array('name'=>'tarikhBuka','id'=>'tarikhBuka','data-date-format'=>'dd-mm-yyyy','value'=>  set_value('tarikhBuka', $ambilan['tarikhBuka']),'class'=>'form-control tarikhBuka','maxlength'=>'50'), array('label'=>'Dari'), false); ?>
            <?php echo tbs_horizontal_input(array('name'=>'tarikhTutup','id'=>'tarikhTutup','data-date-format'=>'dd-mm-yyyy','value'=>  set_value('tarikhTutup', $ambilan['tarikhTutup']),'class'=>'form-control tarikhTutup','maxlength'=>'50'), array('label'=>'Hingga'), false); ?>               
            <!-- Dropdown Untuk STATUS AKTIF -->        
            <?php echo tbs_horizontal_dropdown('statusUjian',$list_status_searching, $ambilan['statusUjian'],array('id'=>'statusUjian','class'=>'','disabled'=>'disabled'),array('label'=>'Status','class'=>''),false);?>
        <?php echo form_close();?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>              
    </div>          
</div>
<!--Tambah rekod siri ujian -->
<div id="myModal_Tambah" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Tambah Siri Pengaktifan Ujian</h3>
    </div>
    <div class="modal-body">
            <?php echo tbs_horizontal_form_open('', array('id'=>'senggara_ujianTambah'));?>          
            <!-- Dropdown Untuk kod ujian -->        
            <?php echo tbs_horizontal_dropdown('kodUjian', $list_kodUjian, $data['kodUjian'],array('id'=>'kodUjian','class'=>''),array('label'=>'Jenis Ujian','class'=>''),true);?>  
            <!-- Dropdown Untuk list siri -->        
            <?php echo tbs_horizontal_dropdown('siri',$list_siri, $data['siri'],array('id'=>'siri','class'=>''),array('label'=>'Siri','class'=>''),true);?>                   
            <?php echo tbs_horizontal_input(array('name'=>'tahun','id'=>'tahun','value'=>set_value('tahun'),'class'=>'input-small','placeholder'=>'Contoh: 2015','maxlength'=>'4'), array('label'=>'Tahun'), true); ?>            
            <?php echo tbs_horizontal_input(array('name'=>'tarikhBuka_tambah','id'=>'tarikhBuka_tambah','data-date-format'=>'dd-mm-yyyy','value'=> '','class'=>'form-control tarikhBuka_tambah','maxlength'=>'50'), array('label'=>'Dari'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'tarikhTutup_tambah','id'=>'tarikhTutup_tambah','data-date-format'=>'dd-mm-yyyy','value'=> '','class'=>'form-control tarikhTutup_tambah','maxlength'=>'50'), array('label'=>'Hingga'), true); ?>            
            <!-- Dropdown Untuk STATUS AKTIF -->        
            <?php echo tbs_horizontal_dropdown('statusUjian',$list_status, $data['statusUjian'],array('id'=>'statusUjian','class'=>''),array('label'=>'Status','class'=>''),true);?>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="simpan"><i class="icon icon-ok icon-white"></i> Simpan</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true" id="button_tutup"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<script src='<?php echo base_url('assets/validation/pengaktifan.js')?>'></script>
<script>
    window.listUser = function(param){ AjaxCall(base_url+'index.php/pengaktifan/listJson',param, 'listUser', 'id', '', ''); };    
    $(document).ready(function(){
		
		$("#tahun")
			.attr('maxlength','4')
			.keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	
		
        listUser();
        $('button.search').live('click', function() {            
            var $var = "";
            $('#senggara_ujian').find(':input[type=text],select').each(function(key, val){ if(val.value != '') { $var += val.name+"="+val.value+"&"; } });
            if($var != '') { AjaxCall(base_url+'index.php/pengaktifan/listJson', $var, '', '', 'listUser("'+$var+'")', ''); }
            return false;
        });                 
        $('#view').live('click', function () {
            var id = $(this).attr('attr');
            var options = {'id' : id };
            $.post(base_url+'index.php/pengaktifan/senggara_ujianPapar', options, function(data) {
                $.each(data, function(key, value){ $("#myModalView .modal-body #"+key).val( value ); });         
            }, "json");
        });
        $('#simpan').live('click', function() {
            var check_validate = $('#senggara_ujianTambah').valid(); // nama form           
            if(check_validate == true){               
                var $var = "";       //php variable
                $('#senggara_ujianTambah').find(':input').each(function(key, val){ $var += val.name+"="+val.value+"&"; });               
                AjaxCall(base_url+'index.php/pengaktifan/tambah_rekodUjian', $var, '', '', 'listUser()', 'jAlert');                             
                $('#myModal_Tambah').modal('hide');
                $("#myModal_Tambah .modal-body input[type='text'], #myModal_Tambah .modal-body select").val('');
                $("#myModal_Tambah.modal-body input[type='checkbox']").each(function(){
                    $(this).attr('checked',false);
                    $(this).closest('div').children('div').slideUp('fast').find('input').attr('disabled',true);
                });
            }//end if           
        });
        $('#edit').live('click', function () {
            var id = $(this).attr('attr');
            var options = {'id' : id};
            $.post(base_url+'index.php/pengaktifan/senggara_ujianPapar', options, function(data) {
                $.each(data, function(key, value){$("#myModalUpdate .modal-body #"+key).val( value ); });         
            }, "json");
        });           
        $('#update').live('click', function() {
           var check_validate = $('#senggara_ujianKemaskini').valid();           
           if(check_validate == true){               
               var $var = "";       //php variable
               $('#senggara_ujianKemaskini').find(':input').each(function(key, val){  $var += val.name+"="+val.value+"&"; });               
               AjaxCall(base_url+'index.php/pengaktifan/senggara_ujianKemaskini', $var, '', '', 'listUser()', 'jAlert');                             
               $('#myModalUpdate').modal('hide');
            }//end if           
        });
        $('#delete').live('click', function() {
            var con = confirm('Adakah anda pasti untuk hapuskan rekod?');
            if(con == true){
				AjaxCall(base_url+'index.php/pengaktifan/senggara_ujianHapus', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert');				
            } else {
                return false;
            }//end if
        });
        // format date untuk tambah pada modal, disable date before current date
        $('.tarikhBuka_tambah').datepicker({
            format: "dd-mm-yyyy",
            startDate: "<?php echo date('d-m-Y') ?>",
            autoclose: true
        });                           
        $('.tarikhTutup_tambah').datepicker({
            format: "dd-mm-yyyy",
            startDate: "<?php echo date('d-m-Y') ?>",            
            autoclose: true
        });        
        $('.tarikhBuka').datepicker({
            format: "dd-mm-yyyy",
            startDate: "<?php echo date('d-m-Y') ?>",
            autoclose: true
        });
        $('.tarikhTutup').datepicker({
            format: "dd-mm-yyyy",
            startDate: "<?php echo date('d-m-Y') ?>",
            autoclose: true
        });          
        $('#tkr_status').live('click', function() {
            var con = confirm('Anda pasti untuk menukar STATUS?');
            if(con == true){
                AjaxCall(base_url+'index.php/pengaktifan/senggara_status', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert');
                $('#myModal_Tambah').modal('hide');                
            } else {
                return false;
            }//end if           
        });        
        $('#popup_ok').live('click', function() {
            location.reload();           
        });        
        $('#button_tutup').on('click', function(){
            $("#myModal_Tambah .modal-body input[type='text'], #myModal_Tambah .modal-body select").val('');
        });        
    });   
</script>