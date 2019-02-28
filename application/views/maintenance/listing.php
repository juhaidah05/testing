<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<br />
<div class="bs-docs-example">
    <table class="table table-bordered">        
        <tr>  
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_modul')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Modul</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_submodul')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Sub Modul</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_jawapan')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Jawapan</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_kodjantina')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Jantina</b></a></td>
        </tr>
        <tr>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_kodfasiliti')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Fasiliti</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_kodjenisfasiliti')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Jenis Fasiliti</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_kategorisoalan')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kategori Soalan</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_soalan')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Soalan</b></a></td>
        </tr>
        <tr>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_padanansj')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Padanan Soalan Jawapan</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_kujian')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Ujian</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/kodkskim_listing')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Klasifikasi Skim</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/kodkumpulan_listing')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Kumpulan Perkhidmatan</b></a></td>
        </tr>
        <tr>
            <td width="25%"><a href="<?php echo site_url('maintenance/negeri_listing')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Negeri</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/penempatan_listing')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Penempatan</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_kodsp')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Kod Skim Perkhidmatan</b></a></td>
            <td width="25%"><a href="<?php echo site_url('maintenance/senarai_padananfp')?>"  title="Click Hyperlink" style="color: #FF3100;" ><i class="icon-hand-right"></i>&nbsp;&nbsp;<b>Padanan Fasiliti Penempatan</b></a></td> 
        </tr>                                  
    </table>
</div>
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>