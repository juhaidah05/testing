 <?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (12 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
 
 echo '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
    <tr>
        <td width="33%"><img src="assets/img/logo.png" /></td>
        <td width="33%" align="center"><img src="assets/img/designbanner.png" /></td>
        <td width="33%" style="text-align: right;"><img src="assets/img/kkm_old.png" /></td>
    </tr>
</table>
<br/><br/>    
<table align="center" class="table table-bordered" style="  border-bottom-width:  thick;  border-color:  #cc0000"   >
    <tr><td><strong><h3><u>KEPUTUSAN UJIAN eMINDA</u></h3></strong></td></tr>
    <tr ><td align="center"><strong><h4><u>SIRI '.$siri.'/'.$tahun.' </u></h4></strong></td></tr>
</table>
<br/><br/><br/>
<table align="center" class="table table-bordered" style="  border-bottom-width:  thick;  border-color:  #cc0000"   >
    <tr><td><strong>Nama</strong></td><td><strong>: </strong></td><td><strong>'.strtoupper($nama).'</strong></td></tr>
    <tr><td><strong>No. Mykad </strong></td><td><strong>: </strong></td><td><strong>'.$mykad.'</strong></td></tr>
    <tr><td><strong>Jawatan </strong></td><td><strong>: </strong></td><td><strong>'.strtoupper($perihalSkim).'</strong></td></tr> 
    <tr><td><strong>Gred </strong></td><td><strong>: </strong></td><td><strong> '.strtoupper($gred).'</strong></td></tr>  
    <tr><td><strong>Lokasi Bertugas  </strong></td><td><strong>: </strong></td><td><strong>'.strtoupper($perihalFasiliti).'</strong></td></tr>   
    <tr><td><strong>Penempatan </strong></td><td><strong>: </strong></td><td><strong> '.strtoupper($perihalPenempatan).'</strong></td></tr>
    <tr><td><strong>Tarikh Ujian </strong></td><td><strong>: </strong></td><td><strong> '.$tarikhUjian.'</strong></td></tr>
</table>
<br/><br/><br/>
<table align="center" width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr bgcolor="#F5A9A9"><td align="center" width="40%" ><strong>KRITERIA</strong></td><td align="center" width="60%"><strong>TAHAP</strong></td></tr>
    <tr bgcolor="#E6E6E6" ><td align="center"><strong>TEKANAN</strong></td><td align="center"><strong>'.$skor3.'</strong></td></tr>
    <tr bgcolor="#E6E6E6" ><td align="center"><strong>KEBIMBANGAN</strong></td><td align="center"><strong>'.$skor2.'</strong></td></tr>
    <tr bgcolor="#E6E6E6" ><td align="center"><strong>KEMURUNGAN</strong></td><td align="center"><strong>'.$skor1.'</strong></td></tr>
</table>';
 ?>