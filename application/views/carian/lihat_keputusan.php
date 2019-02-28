<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang snippet yang tidak diperlukan
 *                      4. Ringkaskan snippet code
 */
?>
<div class="">
    <div class="span10 offset1">
        <div class="widget-box" >
            <div class="widget-title">
                <span class="icon"><i class="icon-th-large"></i></span>
                <h5>Lihat Keputusan</h5>
            </div>
            <div class="widget-content" >
                <?php echo tbs_horizontal_form_open('', array('id'=>'lihat_keputusan'));?>
                    <div style="margin-left: 10px;  ">
                        <?php echo tbs_horizontal_input(array('name'=>'mykad', 'id'=>'mykad','value'=>set_value('mykad', $mykad),'class'=>'input-large','maxlength'=>'12','readonly' => 'readonly'), array('label'=>'No. MyKad'), true);  ?>
                        <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>  set_value('nama',  $nama),'class'=>'input-xxlarge','readonly' => 'readonly'), array('label'=>'Nama'), true); ?>
                        <?php echo tbs_horizontal_dropdown('jantina',$jantina_u,$jantina, array('id'=>'jantina','class'=>'input-medium','disabled' => 'disabled'), array('label'=>'Jantina'), true); ?> 
                        <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $emel),'class'=>'input-xlarge','readonly' => 'readonly'), array('label'=>'Emel'), true); ?>
                        <?php echo tbs_horizontal_dropdown('skim', $skim_u,$skim, array('id'=>'skim','class'=>'input-xlarge','disabled' => 'disabled'), array('label'=>'Jawatan'), true)?>         
                        <?php echo tbs_horizontal_input(array('name'=>'gred','id'=>'gred','value'=>  set_value('gred',  $gred),'class'=>'input-small','maxlength'=>'4','readonly' => 'readonly'), array('label'=>'Gred'), true); ?> 
                        <?php echo tbs_horizontal_dropdown('jenisFasiliti', $jenisFasiliti_u,$jenisFasiliti, array('id'=>'jenisFasiliti','class'=>'input-xlarge','disabled' => 'disabled'), array('label'=>'Jenis Fasiliti'), true)?>  
                        <div id="ajaxjenisFasiliti">
                            <?php echo tbs_horizontal_dropdown('lokasiBertugas', $lokasiBertugas_u,$lokasiBertugas, array('id'=>'lokasiBertugas','class'=>'input-xlarge','disabled' => 'disabled'), array('label'=>'Lokasi Bertugas'), true)?>  
                        </div>
                        <?php echo tbs_horizontal_dropdown('penempatan', $penempatan_u,$penempatan, array('id'=>'penempatan','class'=>'input-xlarge','disabled' => 'disabled'), array('label'=>'Penempatan'), true)?>
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
                    <?php } ?>
                <?php echo form_close();?>  
            </div>
        </div>