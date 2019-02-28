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
 *                      5. Buang window.listUser = function(){});
 */
?>
<div class="container-fluid">
    <div class="row-fluid">
	<div class="span10 offset1">
            <?php echo tbs_horizontal_form_open('', array('id'=>'kemaskini_pengguna'));?>
                <div class="span12"><span class="lblText" ><h5><b><u><center>KEMASKINI MAKLUMAT PERIBADI</center></u></b></h5></span></div>
                <br/><br/><br/>      
                <?php echo tbs_horizontal_input(array('name'=>'mykad','id'=>'mykad','value'=>set_value('mykad', $mykad),'class'=>'input-large','maxlength'=>'12','readonly' => 'readonly'), array('label'=>'No. MyKad'), true);  ?>
                <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>  set_value('nama',  $nama),'class'=>'input-xxlarge'), array('label'=>'Nama'), true); ?>
                <?php echo tbs_horizontal_dropdown('jantina',$jantina_u,$jantina, array('id'=>'jantina','class'=>'input-medium'), array('label'=>'Jantina'), true); ?>   
                <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $emel),'class'=>'input-xlarge'), array('label'=>'Emel'), true); ?>
                <?php echo tbs_horizontal_dropdown('skim', $skim_u,$skim, array('id'=>'skim','class'=>'input-xlarge'), array('label'=>'Jawatan'), true)?>         
                <?php echo tbs_horizontal_input(array('name'=>'gred','id'=>'gred','value'=>  set_value('gred',  $gred),'class'=>'input-small','maxlength'=>'4'), array('label'=>'Gred'), true); ?>   
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style=" color:  #CC0000"> (Contoh: 17 / 41 / JUSA A / TURUS 3) </font>
                <br/>      
                <?php echo tbs_horizontal_dropdown('jenisFasiliti', $jenisFasiliti_u,$jenisFasiliti, array('id'=>'jenisFasiliti','class'=>'input-xlarge'), array('label'=>'Jenis Fasiliti'), true)?>  
                <div id="ajaxjenisFasiliti">
                    <?php echo tbs_horizontal_dropdown('lokasiBertugas', $lokasiBertugas_u,$lokasiBertugas, array('id'=>'lokasiBertugas','class'=>'input-xlarge'), array('label'=>'Lokasi Bertugas'), true)?>  
                </div>
                <div id="ajaxpenempatan">                  
                    <?php echo tbs_horizontal_dropdown('penempatan', $penempatan_u,$penempatan, array('id'=>'penempatan','class'=>'input-xlarge'), array('label'=>'Penempatan'), true)?>
                </div>                             
                <div  align="right">
                    <button type="submit" class="btn btn-orange"><i class="icon icon-play icon-white"></i>Seterusnya</button>
                </div>
            <?php echo form_close();?>
        </div>        
    </div>
</div>   
<script src='<?php echo base_url('assets/validation/admin.js')?>'></script>
<script>
    //window.listUser = function(){// AjaxCall(base_url+'index.php/admin/listJson', '', 'listUser', 'id', '', '');};    
    $(document).ready(function(){
        listUser();        
        $('#jenisFasiliti').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/question/getFasiliti', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxjenisFasiliti").slideUp('fast').html(data):$("#ajaxjenisFasiliti").html(data).slideDown('fast');
            });
        });        
        $('#lokasiBertugas').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/question/getPenempatan', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxpenempatan").slideUp('fast').html(data):$("#ajaxpenempatan").html(data).slideDown('fast');
            });
        });
        $('#simpan').live('click', function() {
            var check_validate = $('#kemaskini_pengguna').valid();           
            if(check_validate == true){               
               var $var = "";       //php variable
               $('#kemaskini_pengguna').find(':input').each(function(key, val){ $var += val.name+"="+val.value+"&"; });               
               AjaxCall(base_url+'index.php/question/kemaskini_pengguna', $var, '', '', 'listUser()', 'jAlert');
            }           
        });
    }); 
</script>