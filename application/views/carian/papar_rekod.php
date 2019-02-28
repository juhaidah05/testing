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
 *						   <!--a id='btn_kembali' class="btn btn-orange" href="<?php echo site_url('/carian/pengguna')?>"><i class="icon icon-chevron-left icon-white"></i> Kembali</a-->
 *						   kepada <a id='btn_kembali' class="btn btn-orange"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>
 *						2. Tambah function trigger $('#btn_kembali').live('click', function() { history.go(-3); });
 */
?>
<div class="">
    <div class="span10 offset1">
        <div class="widget-box" >
            <div class="widget-title">
                <span class="icon"><i class="icon-th-large"></i></span>
                <h5>Papar Maklumat</h5>
            </div>
            <div class="widget-content" >
                <?php echo tbs_horizontal_form_open('', array('id'=>'papar_rekod'));?>
                <div style="margin-left: 10px;  ">
                    <?php echo tbs_horizontal_input(array('name'=>'mykad','id'=>'mykad','value'=>set_value('mykad', $mykad),'class'=>'input-large','maxlength'=>'12','readonly' => 'readonly'), array('label'=>'No. MyKad'), true);  ?>
                    <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>  set_value('nama',  $nama),'class'=>'input-xxlarge','readonly' => 'readonly'), array('label'=>'Nama'), true); ?>
                    <?php echo tbs_horizontal_dropdown('jantina',$jantina_u,$jantina, array('id'=>'jantina','class'=>'input-medium','disabled' => 'disabled'), array('label'=>'Jantina'), true); ?> 
                    <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $emel),'class'=>'input-xlarge','readonly' => 'readonly'), array('label'=>'Emel'), true); ?>
                    <?php echo tbs_horizontal_dropdown('skim', $skim_u,$skim, array('id'=>'skim','class'=>'input-xlarge','disabled' => 'disabled'), array('label'=>'Jawatan'), true)?>         
                    <?php echo tbs_horizontal_input(array('name'=>'gred','id'=>'gred','value'=>  set_value('gred',  $gred),'class'=>'input-small','maxlength'=>'4','readonly' => 'readonly'), array('label'=>'Gred'), true); ?> 
                    <?php echo tbs_horizontal_dropdown('jenisFasiliti', $jenisFasiliti_u,$jenisFasiliti, array('id'=>'jenisFasiliti','class'=>'input-xxlarge','disabled' => 'disabled'), array('label'=>'Jenis Fasiliti'), true)?>  
                    <div id="ajaxjenisFasiliti">
                        <?php echo tbs_horizontal_dropdown('lokasiBertugas', $lokasiBertugas_u,$lokasiBertugas, array('id'=>'lokasiBertugas','class'=>'input-xxlarge','disabled' => 'disabled'), array('label'=>'Lokasi Bertugas'), true)?>  
                    </div>
                    <?php echo tbs_horizontal_dropdown('penempatan', $penempatan_u,$penempatan, array('id'=>'penempatan','class'=>'input-xxlarge','disabled' => 'disabled'), array('label'=>'Penempatan'), true)?>
                </div>
				<?php if($role==0){?>
                <br/>
                <div class="span10"><span class="lblText" ><h5><b><u><center>Sejarah Ujian</center></u></b></h5></span></div>
                <table width="70%" border="1" cellspacing="0" cellpadding="5" class="offset1">
                    <tr bgcolor="#F6CECE">
			<td align="center" width="12%" ><strong>Bil.</strong></td>
                        <td align="center" width="12%" ><strong>Siri</strong></td>
    			<td align="center" width="40%"><strong>Tarikh Ujian</strong></td>
                        <td align="center" width="40%"><strong>Jenis Ujian</strong></td>
                    </tr>
                    <?php $bil = 1; foreach ($kodUjian as $key => $val) {?>
                    <tr >
			<td align="center"><strong><?php echo $bil.'.';?></strong></td>
                        <td align="center">
                            <strong><a href="<?php echo site_url('carian/papar_sejarah/'.$val['mykad'].'/'.$val['idUjian'].'/'.$val['idPerkhidmatan'])?>">
                            <u><?php echo $val['siri'].'/'.$val['tahun'];  ?></u>
                            </a></strong>
                        </td>
			<td align="center"><strong><?php echo date('d-m-Y',strtotime($val['tarikhUjian']));?></strong></td>
			<td  align="center"><strong><?php echo $val['kodUjian']; ?></strong></td>
                    </tr>
                    <?php  $bil++;} ?>         
                </table>
				<?php }?>
                <br/>
                <div class="form-actions">
                    <div class="span4 offset2">

                      <a class="btn btn-orange" href="<?php echo site_url('/carian/pengguna/'.$val['mykad'])?>"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>   
                     
						
                    </div>
                </div> 
                <?php echo form_close();?>  
            </div>
        </div>        
        <script>
            //window.listUser = function(){ // AjaxCall(base_url+'index.php/admin/listJson', '', 'listUser', 'id', '', '');//};    
            $(document).ready(function(){
                //listUser();        
                $('#jenisFasiliti').live('change', function(e){
                   e.preventDefault();
                   $.post(base_url+'index.php/question/getFasiliti', 'id='+$(this).val(), function(data) {
                       (data == '')?$("#ajaxjenisFasiliti").slideUp('fast').html(data):$("#ajaxjenisFasiliti").html(data).slideDown('fast');
                   });
               });

                $('#simpan').live('click', function() {
                    var check_validate = $('#kemaskini_pengguna').valid();
                    if(check_validate == true){
                        var $var = "";       //php variable
                        $('#kemaskini_pengguna').find(':input').each(function(key, val){
                            $var += val.name+"="+val.value+"&";
                        });
                        AjaxCall(base_url+'index.php/question/kemaskini_pengguna', $var, '', '', 'listUser()', 'jAlert');
                    }//end if
                });
				
				$('#btn_kembali').live('click', function() { 
					//alert();
					history.go(-2);
					//history.go(-2); 
					});
            }); 
        </script>