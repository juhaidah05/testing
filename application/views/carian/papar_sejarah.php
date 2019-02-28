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
<?php if(($history['levelAdmin']=='1')||($history['levelAdmin']=='2')){ ?>
<div class="">
    <div class="span10 offset1">
        <div class="widget-box" >
            <div class="widget-title">
                <span class="icon"><i class="icon-th-large"></i></span>
                <h5>Papar Sejarah</h5>
            </div>
            <div class="widget-content" >
                <?php echo tbs_horizontal_form_open('', array('id'=>'papar_sejarah'));?>
                    <br />
                    <table width="1000" border="0" cellspacing="5" cellpadding="5" class="offset1">
                        <tr >
                            <td width="11%" align="left"><strong>NAMA</strong></td>
                            <td width="2%"  align="left"><strong>:</strong></td>
                            <td width="25%" align="left">&nbsp;<?php echo strtoupper($nama); ?></td>
                            <td width="17%" align="left"><strong>GRED</strong></td>
                            <td width="2%"  align="left"><strong>:</strong></td> 
                            <td width="43%" align="left">&nbsp;<?php echo strtoupper($gred); ?></td>
                        </tr>
                        <tr>
                            <td align="left"><strong>NO. MYKAD</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo $mykad; ?></td>
                            <td align="left"><strong>JENIS FASILITI</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo strtoupper($perihalJenisFasiliti); ?></td>
                        </tr>
                        <tr>
                            <td align="left"><strong>JANTINA</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo strtoupper($jantina); ?></td>
                            <td align="left"><strong>LOKASI BERTUGAS</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo strtoupper($perihalFasiliti); ?></td>
                        </tr>
                        <tr>
                            <td align="left"><strong>EMEL</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo $emel; ?></td>
                            <td align="left"><strong>PENEMPATAN</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo strtoupper($perihalPenempatan); ?></td>
                        </tr> 
                        <tr>
                            <td align="left"><strong>JAWATAN</strong></td>
                            <td align="left"><strong>:</strong></td>
                            <td align="left">&nbsp;<?php echo strtoupper($perihalSkim); ?></td>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    </table>
                    <table width="1000" border="0" cellspacing="0" cellpadding="5" class="offset1">
                        <tr >
                            <td align="left">
                                <table width="70%" border="0">
                                    <tr><td><strong>TEKANAN</strong></td></tr>
                                    <tr><td>
                                            <table width="100%" border="2" cellpadding="1" cellspacing="1">
                                                <tr bgcolor="#F8E0E6"  align="center">
                                                    <td><strong>SOALAN</strong></td>
                                                    <?php echo $td5;?>
                                                    <td><strong>JUMLAH</strong></td>
                                                </tr>
                                                <tr align="center">
                                                    <td><strong>MARKAH</strong></td>
                                                    <?php echo $td6;?>
                                                    <td><?php echo $s;?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr >
                            <td align="left">
                                <table width="70%" border="0">
                                    <tr><td><strong>KEBIMBANGAN</strong></td></tr>
                                    <tr><td>
                                            <table width="100%" border="2" cellpadding="1" cellspacing="1">
                                                <tr bgcolor="#F8E0E6"  align="center">
                                                    <td><strong>SOALAN</strong></td>
                                                    <?php echo $td3;?>
                                                    <td><strong>JUMLAH</strong></td>
                                                </tr>
                                                <tr align="center">
                                                    <td><strong>MARKAH</strong></td>
                                                    <?php echo $td4;?>
                                                    <td><?php echo $a;?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr >
                            <td align="left">
                                <table width="70%" border="0">
                                    <tr><td><strong>KEMURUNGAN</strong></td></tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="2" cellpadding="1" cellspacing="1">
                                                <tr bgcolor="#F8E0E6" align="center">
                                                    <td><strong>SOALAN</strong></td>
                                                    <?php echo $td1;?>
                                                    <td><strong>JUMLAH</strong></td>
                                                </tr>
                                                <tr align="center">
                                                    <td><strong>MARKAH</strong></td>
                                                    <?php echo $td2;?>
                                                    <td align="center"><?php echo $m;?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr >
                            <td align="left">
                                <table width="70%" border="2" cellpadding="3" cellspacing="3">
                                    <tr bgcolor="#F8E0E6" align="center">
                                        <td align="center" width="35%" ><strong>KRITERIA</strong></td>
                                        <td align="center" width="35%"><strong>TAHAP</strong></td>
                                    </tr>
                                    <tr align="center">
                                        <td><strong>TEKANAN</strong></td>
                                        <td><strong>&nbsp;<?php echo strtoupper($skor3); ?></strong></td>
                                    </tr>
                                    <tr align="center">
                                        <td><strong>KEBIMBANGAN</strong></td>
                                        <td><strong>&nbsp;<?php echo strtoupper($skor2); ?></strong></td>
                                    </tr>
                                    <tr align="center">
                                        <td><strong>KEMURUNGAN</strong></td>
                                        <td><strong>&nbsp;<?php echo strtoupper($skor1);?></strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <div class="offset4">
                        <a class="btn btn-primary" href="<?php echo site_url('/carian/cetak_keputusan_admin/'.$mykad.'/'.$idPerkhidmatan.'/'.$idUjian)?>" ><i class="icon icon-print icon-white"></i> Cetak Keputusan</a>
                        <a class="btn btn-orange" href="<?php echo site_url('/carian/papar_rekod/'.$mykad)?>"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>
                    </div>
                    <br/>
                <?php echo form_close();?>  
            </div>
        </div>
<?php } else if($history['levelAdmin']=='0') { ?>
<div class="container-fluid">
    <div class="row-fluid">
        <?php echo tbs_horizontal_form_open('', array('class'=>'form-horizontal', 'name' => 'form1', 'id' => 'papar_sejarah')) ?> 
            <div class="row-fluid">
                <div class="span12"><span class="lblText" ><h5><b><u><center>KEPUTUSAN UJIAN eMINDA</center></u></b></h5></span></div>
                <h5><b><u><center>SIRI <?php echo $siri;?>/<?php echo $tahun;?> </center></u></b></h5>   
                <br />
                <div class="span12">
                    <div class="span12 offset1"> 
                        <table  class="table table-bordered" style="  border-bottom-width:  thick;  border-color:  #cc0000"   >
                            <div class="row-fluid">    
                                <div class="span4"><span class=""><strong>Nama <div class="pull-right"> : </div></span></strong></div>
                                <div class="span7"><?php echo strtoupper($nama); ?></div>
                            </div>
                            <div class="row-fluid">
                                <div class="span4"><span class=""><strong>No. Mykad <div class="pull-right"> : </div></span></strong></div>
                                <div class="span7"><?php echo $mykad; ?></div>
                            </div>
                            <div class="row-fluid">    
                                <div class="span4"><span class=""><strong>Jawatan <div class="pull-right"> : </div></span></strong></div>
                                <div class="span7"><?php echo strtoupper($perihalSkim); ?></div>
                            </div>      
                            <div class="row-fluid">    
                                <div class="span4"><span class=""><strong>Gred <div class="pull-right"> : </div></span></strong></div>
                                <div class="span7"><?php echo $gred; ?></div>
                            </div> 
                            <div class="row-fluid">    
                                <div class="span4"><span class=""><strong>Lokasi Bertugas <div class="pull-right"> : </div></span></strong></div>
                                <div class="span7"><?php echo strtoupper($perihalFasiliti); ?></div>
                            </div> 
                            <div class="row-fluid">    
                                <div class="span4"><span class=""><strong>Penempatan <div class="pull-right"> : </div></span></strong></div>
                                <div class="span7"><?php echo strtoupper($perihalPenempatan); ?></div>
                            </div>  
                            <div class="row-fluid">    
                                <div class="span4"><span class=""><strong>Tarikh Ujian <div class="pull-right"> : </div></span></strong></div>  
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
                                <td align="center"><strong><?php echo strtoupper($skor3); ?></strong></td>
                            </tr>
                            <tr >
                                <td  align="center"><strong>KEBIMBANGAN</strong></td>
                                <td align="center"><strong><?php echo strtoupper($skor2); ?></strong></td>
                            </tr>
                            <tr>
                                <td align="center"><strong>KEMURUNGAN</strong></td>
                                <td align="center"><strong><?php echo strtoupper($skor1);?></strong></td>
                            </tr>
                        </table>
                    </div>            
                </div>   
            </div>   
            <br/>
            <br/>
            <div class="offset4">
                <a class="btn btn-primary" href="<?php echo site_url('/carian/cetak_keputusan/'.$mykad.'/'.$idPerkhidmatan.'/'.$idUjian)?>" ><i class="icon icon-print icon-white"></i> Cetak Keputusan</a>
                                 <?php if(($history['levelAdmin']=='1')||($history['levelAdmin']=='2')){?>
                
                <a class="btn btn-orange" href="<?php echo site_url('/carian/papar_rekod/'.$mykad)?>"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>
               
               
                <?php } else if($history['levelAdmin']=='0') {?>
                <a class="btn btn-orange" href="<?php echo site_url('/carian/lihat_keputusan/'.$mykad)?>"><i class="icon icon-chevron-left icon-white"></i> Kembali</a>
                <?php }?>
            </div>
            <br/>
        <?php echo form_close();?>  
    </div>     
</div>
<?php }?>