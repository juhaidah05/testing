<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (12 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<div class="container-fluid">	
    <div class="row-fluid">
        <?php echo tbs_horizontal_form_open('', array('class'=>'form-horizontal', 'name' => 'form1', 'id' => 'form1')) ?> 
            <div class="row-fluid">
                <div class="span12"><span class="lblText" ><h5><b><u><center>KEPUTUSAN UJIAN eMINDA</center></u></b></h5></span></div>
                <h5><b><u><center>SIRI <?php echo $siri;?>/<?php echo $tahun;?> </center></u></b></h5>   
                <br/>
        	<div class="span12">
                    <table  class="table table-bordered" style="  border-bottom-width:  thick;  border-color:  #cc0000"   >
                        <div class="row-fluid">    
                            <div class="span4"><span class=""><b>Nama <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo strtoupper($nama);?></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4"><span class=""><b>No. Mykad <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo $mykad;?></div>
                        </div>
                        <div class="row-fluid">    
                            <div class="span4"><span class=""><b>Jawatan <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo strtoupper($perihalSkim);?></div>
                        </div>      
                        <div class="row-fluid">    
                            <div class="span4"><span class=""><b>Gred <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo strtoupper($gred);?></div>
                        </div> 
                        <div class="row-fluid">    
                            <div class="span4"><span class=""><b>Lokasi Bertugas <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo strtoupper($perihalFasiliti);?></div>
                        </div> 
                        <div class="row-fluid">    
                            <div class="span4"><span class=""><b>Penempatan <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo strtoupper($perihalPenempatan);?></div>
                        </div>  
                        <div class="row-fluid">    
                            <div class="span4"><span class=""><b>Tarikh Ujian <div class="pull-right"> : </div></span></b></div>
                            <div class="span7"><?php echo $tarikhUjian;?></div>
                        </div>                                            
                    </table>
                    <table width="70%" border="1" cellspacing="0" cellpadding="5">
                        <tr bgcolor="#F6CECE">
                            <td align="center" width="30%" ><strong>KRITERIA</strong></td>
                            <td align="center" width="40%"><strong>TAHAP</strong></td>
                        </tr>
                        <tr >
                            <td  align="center"><strong>TEKANAN</strong></td>
                            <td align="center"><strong><?php echo $skor3;?></strong></td>
                        </tr>
                        <tr >
                            <td  align="center"><strong>KEBIMBANGAN</strong></td>
                            <td align="center"><strong><?php echo $skor2;?></strong></td>
                        </tr>
                        <tr>
                            <td align="center"><strong>KEMURUNGAN</strong></td>
                            <td align="center"><strong><?php echo $skor1;?></strong></td>
                        </tr>
                    </table>
                </div>   
            </div>   
            <br/>
            <div class="container-fluid" align="right">
                <input type="hidden" id="idPerkhidmatan" value="<?=$idPerkhidmatan;?>" />
                <a href="<?php echo site_url('question/cetak/'.$mykad.'/'.$idPerkhidmatan)?>" target="_blank">
                    <button class="btn btn-orange" id="btn_Print" name="btn_Print">Cetak <i class="icon icon-chevron-right icon-white"></i></button></a>
            </div>
     <?php echo form_close();?>  
    </div>     
</div>