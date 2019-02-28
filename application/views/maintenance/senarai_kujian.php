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
<!-- ADD - kod ujian-->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Tambah Kod Ujian</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kujian_tambah'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodUjian', 'id'=>'kodUjian','value'=>set_value('kodUjian', $_kodUjian['kodUjian']),'class'=>'input-large','maxlength'=>'5'), array('label'=>'Kod'), true);?>
            <?php echo tbs_horizontal_input(array('name'=>'perihalUjian','id'=>'perihalUjian','value'=>  set_value('perihalUjian', $_kodUjian['perihalUjian']),'class'=>'','maxlength'=>'100'), array('label'=>'Perihal Ujian'), true); ?>
            <div class="control-group">
                <label class="control-label" for="keterangan1">Keterangan 1<span style='color:red'>*</span></label>
                <div class="controls"> 
                    <textarea rows="10" maxlength="100" cols="50" id="keterangan1" name="keterangan1" class="input-xlarge"></textarea>
                    <label class="error"><em><i>(Maksimum Aksara 100 Sahaja)</i></em></label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="keterangan2">Keterangan 2<span style='color:red'>*</span></label>
                <div class="controls"> 
                    <textarea rows="10" maxlength="100" cols="50" id="keterangan2" name="keterangan2" class="input-xlarge"></textarea>
                    <label class="error"><em><i>(Maksimum Aksara 100 Sahaja)</i></em></label>
                </div>
            </div>
        <?php echo form_close();?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="simpan"><i class="icon icon-ok icon-white"></i> Simpan</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<!-- VIEW -kod ujian -->
<div id="myModalView" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Papar Kod Ujian</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kujian_papar'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodUjian','id'=>'kodUjian','value'=>set_value('kodUjian', $_kodUjian['kodUjian']),'class'=>'input-large','maxlength'=>'5'), array('label'=>'Kod'), true);?>
            <?php echo tbs_horizontal_input(array('name'=>'perihalUjian','id'=>'perihalUjian','value'=>  set_value('perihalUjian', $_kodUjian['perihalUjian']),'class'=>'','maxlength'=>'100'), array('label'=>'Perihal Ujian'), true); ?>
            <div class="control-group">
                <label class="control-label" for="keterangan1">Keterangan 1<span style='color:red'>*</span></label>
                <div class="controls"> 
                    <textarea rows="10" maxlength="100" cols="50" id="keterangan1" name="keterangan1" class="input-xlarge" readonly="readonly"><?php echo $_kodUjian['keterangan1'];?></textarea>
                    <label class="error"><em><i>(Maksimum Aksara 100 Sahaja)</i></em></label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="keterangan2">Keterangan 2 <span style='color:red'>*</span></label>
                <div class="controls"> 
                    <textarea rows="10" maxlength="100" cols="50" id="keterangan1" name="keterangan2" class="input-xlarge" readonly="readonly"><?php echo $_kodUjian['keterangan2'];?></textarea>
                    <label class="error"><em><i>(Maksimum Aksara 100 Sahaja)</i></em></label>
                </div>
            </div>
        <?php echo form_close();?>    
    </div>
    <div class="modal-footer">
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>             
</div>
<!-- UPDATE - kod ujian -->
<div id="myModalUpdate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <!--button class="close" data-dismiss="modal" aria-hidden="true">x</button-->
        <h3 id="myModalLabel">Kemaskini Kod Ujian</h3>
    </div>
    <div class="modal-body">
        <?php echo tbs_horizontal_form_open('', array('id'=>'kujian_kemaskini'));?>
            <?php echo tbs_horizontal_input(array('name'=>'kodUjian','id'=>'kodUjian','value'=>set_value('kodUjian', $_kodUjian['kodUjian']),'class'=>'input-large','maxlength'=>'5','readonly' => 'readonly'), array('label'=>'Kod'), true);?>
            <?php echo tbs_horizontal_input(array('name'=>'perihalUjian','id'=>'perihalUjian','value'=>  set_value('perihalUjian', $_kodUjian['perihalUjian']),'class'=>'','maxlength'=>'1000'), array('label'=>'Perihal Ujian'), true); ?>
            <div class="control-group">
                <label class="control-label" for="keterangan1">Keterangan 1<span style='color:red'>*</span></label>
                    <div class="controls"> 
                    <textarea rows="10" maxlength="1000" cols="50" id="keterangan1" name="keterangan1" class="input-xlarge" ><?php echo $_kodUjian['keterangan1'];?></textarea>
                    <label class="error"><em><i>(Maksimum Aksara 1000 Sahaja)</i></em></label>
                </div>
            </div> 
            <div class="control-group">
                <label class="control-label" for="keterangan2">Keterangan 2<span style='color:red'>*</span></label>
                <div class="controls"> 
                    <textarea rows="10" maxlength="1000" cols="50" id="keterangan2" name="keterangan2" class="input-xlarge" ><?php echo $_kodUjian['keterangan2'];?></textarea>
                    <label class="error"><em><i>(Maksimum Aksara 1000 Sahaja)</i></em></label>
                </div>
            </div> 
       
        <?php echo form_close();?> 
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
</div>
<script src='<?php echo base_url('assets/validation/maintenance.js')?>'></script>
<script>
    window.listUser = function(){ AjaxCall(base_url+'index.php/maintenance/listJson_kujian', '', 'listUser', 'id', '', ''); };    
    $(document).ready(function(){
        listUser();
       $('#view').live('click', function () {
            var id = $(this).attr('attr');
            var options = { 'id' : id }; 
            $.post(base_url+'index.php/maintenance/kujian_papar', options, function(data) {
                $.each(data, function(key, value){  $("#myModalView .modal-body #"+key).val( value );   });         
            }, "json");
        });
        $('#edit').live('click', function () {
            var id = $(this).attr('attr');
            var options = {  'id' : id };
            $.post(base_url+'index.php/maintenance/kujian_papar', options, function(data) {
                $.each(data, function(key, value){ $("#myModalUpdate .modal-body #"+key).val( value );  });         
            }, "json");
        });
        $('#simpan').live('click', function() {
            var check_validate = $('#kujian_tambah').valid();           
            if(check_validate == true){               
                var $var = "";       //php variable
                $('#kujian_tambah').find(':input').each(function(key, val){ $var += val.name+"="+val.value+"&"; });               
                AjaxCall(base_url+'index.php/maintenance/kujian_tambah', $var, '', '', 'listUser()', 'jAlert');                             
                $('#myModal').modal('hide');
            }//end if           
        });
        $('#update').live('click', function() {
            var check_validate = $('#kujian_kemaskini').valid();           
            if(check_validate == true){               
                var $var = "";       //php variable
                $('#kujian_kemaskini').find(':input').each(function(key, val){  $var += val.name+"="+val.value+"&"; });               
                AjaxCall(base_url+'index.php/maintenance/kujian_kemaskini', $var, '', '', 'listUser()', 'jAlert');                             
                $('#myModalUpdate').modal('hide');
            }//end if           
        });
          $('#delete').live('click', function() {
            var con = confirm('Adakah Anda Pasti Untuk Hapuskan Rekod?');
            if(con == true){ AjaxCall(base_url+'index.php/maintenance/kujian_hapus', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert'); }
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