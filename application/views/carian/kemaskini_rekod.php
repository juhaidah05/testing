<?php 

/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang snippet yang tidak diperlukan
 *                      4. Buang window.listUser = function(){};
 *                      5. Ringkaskan snippet code
 *	(23 Dis 2015)	:	1. Ubahsuai buttun Kembali daripada
 *						   <a class="btn btn-orange" href="<?php echo base_url('/index.php/carian/pengguna')?>"><i class="icon icon-chevron-left  icon-white"></i> Kembali</a>
 *						   kepada <a id='btn_kembali' class="btn btn-orange"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>
 *						2. Tambah function trigger $('#btn_kembali').live('click', function() { history.go(-3); });  
 */
?>
<div class="">
    <div class="span10 offset1">
        <div class="widget-box" >
            <div class="widget-title">
                <span class="icon"><i class="icon-th-large"></i></span>
                <h5>Kemaskini Maklumat</h5>
            </div>
            <div class="widget-content" >
                <?php echo tbs_horizontal_form_open('', array('id'=>'kemaskini_rekod'));?>
                    <input type="hidden" id="idPerkhidmatan" name="idPerkhidmatan" value="<?php echo($idPerkhidmatan); ?>" />
                    <div style="margin-left: 10px;  ">
                        <?php echo tbs_horizontal_input(array('name'=>'mykad', 'id'=>'mykad','value'=>set_value('mykad', $mykad),'class'=>'input-large','maxlength'=>'12','readonly' => 'readonly'), array('label'=>'No. MyKad'), true);  ?>
                        <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>  set_value('nama',  $nama),'class'=>'input-xxlarge'), array('label'=>'Nama'), true); ?>
                        <?php echo tbs_horizontal_dropdown('jantina',$jantina_u,$jantina, array('id'=>'jantina','class'=>'input-medium'), array('label'=>'Jantina'), true); ?>   
                        <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $emel),'class'=>'input-xlarge'), array('label'=>'Emel'), true); ?>
                        <?php echo tbs_horizontal_dropdown('skim', $skim_u,$skim, array('id'=>'skim','class'=>'input-xlarge',), array('label'=>'Jawatan'), true)?>         
                        <?php echo tbs_horizontal_input(array('name'=>'gred','id'=>'gred','value'=>  set_value('gred',  $gred),'class'=>'input-small','maxlength'=>'10'), array('label'=>'Gred', 'desc'=>'Contoh: 17 / 41 / JUSA A / TURUS 3'), true); ?>
                        <?php echo tbs_horizontal_dropdown('jenisFasiliti', $jenisFasiliti_u,$jenisFasiliti, array('id'=>'jenisFasiliti','class'=>'input-xlarge'), array('label'=>'Jenis Fasiliti'), true)?>  
                        <div id="ajaxjenisFasiliti">
                            <?php echo tbs_horizontal_dropdown('lokasiBertugas', $lokasiBertugas_u,$lokasiBertugas, array('id'=>'lokasiBertugas','class'=>'input-xlarge'), array('label'=>'Lokasi Bertugas'), true)?>  
                        </div>          
                        <div id="ajaxpenempatan"> 
                            <?php echo tbs_horizontal_dropdown('penempatan', $penempatan_u,$penempatan, array('id'=>'penempatan','class'=>'input-xlarge'), array('label'=>'Penempatan'), true)?>
                        </div>            
                        <!-- Dropdown Untuk STATUS AKTIF -->        
                        <?php echo tbs_horizontal_dropdown('status',$status_u,$status,array('id'=>'status','class'=>''),array('label'=>'Status Aktif','class'=>''),true); ?>          
                        <!-- Dropdown Untuk Peranan -->
                        <?php echo tbs_horizontal_dropdown('levelAdmin',$levelAdmin_u,$levelAdmin,array('id'=>'levelAdmin','class'=>'',),array('label'=>'Peranan','class'=>''),true); ?>
                    </div>
                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" ><i class="icon icon-refresh icon-white"></i> Kemaskini</button>
                        <button type="reset" id="semula" class="btn btn-grey"><i class="icon icon-repeat"></i> Reset</button>
                        <!--a class="btn btn-orange" href="<?php echo base_url('/index.php/carian/pengguna')?>"><i class="icon icon-chevron-left  icon-white"></i> Kembali</a-->
						<!--a id='btn_kembali' class="btn btn-orange" href="<?php echo site_url('/carian/pengguna')?>"><i class="icon icon-chevron-left icon-white"></i> Kembali</a-->
						<a id='btn_kembali' class="btn btn-orange"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>
                    </div>                  
                <?php echo form_close();?>        
            </div>        
        </div>                
        <script src='<?php echo base_url('assets/validation/pengguna.js')?>'></script>
        <script>
            //window.listUser = function(){ // AjaxCall(base_url+'index.php/admin/listJson', '', 'listUser', 'id', '', '');//};        
            $(document).ready(function(){
                //listUser();  
                $('#jenisFasiliti').live('change', function(e){
                    e.preventDefault();
                    $.post(base_url+'index.php/carian/getFasiliti', 'id='+$(this).val(), function(data) {
                        (data == '') ? $("#ajaxjenisFasiliti").slideUp('fast').html(data):$("#ajaxjenisFasiliti").html(data).slideDown('fast');
                    });
                });
                $('#lokasiBertugas').live('change', function(e){
                    e.preventDefault();
                    $.post(base_url+'index.php/carian/getPenempatan', 'id='+$(this).val(), function(data) {
                        (data == '') ? $("#ajaxpenempatan").slideUp('fast').html(data):$("#ajaxpenempatan").html(data).slideDown('fast');
                    });
                });
                $('#simpan').live('click', function() {
                   var check_validate = $('#kemaskini_rekod').valid();           
                   if(check_validate == true){               
                       var $var = "";
                       $('#kemaskini_rekod').find(':input').each(function(key, val){  $var += val.name+"="+val.value+"&";});               
                       //AjaxCall(base_url+'index.php/carian/kemaskini_rekod', $var, '', '', 'listUser()', 'jAlert');
					   //alert('ok, update!');
					   //history.go(-3);
                    }
					//alert('ok, update!');
					//history.go(-3);
                }); 
				$('#btn_kembali').live('click', function() { 
					//alert();
					history.go(3);
					history.go(-2); 
					});	
            }); 
        </script>        