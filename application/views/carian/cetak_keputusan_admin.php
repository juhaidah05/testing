<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
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
<table align="center" class="table table-bordered" style="  border-bottom-width:  thick;  border-color:  #cc0000"   cellpadding="1"  cellspacing="1" >
    <tr><td><strong><h3><u>KEPUTUSAN UJIAN eMINDA</u></h3></strong></td></tr>
    <tr ><td align="center"><strong><h4><u>SIRI '.$siri.'/'.$tahun.' </u></h4></strong></td></tr>
</table>
<br/><br/><br/>
<table align="center" class="table table-bordered" style="  border-bottom-width:  thick;  border-color:  #cc0000"  cellpadding="0"  cellspacing="0"  width="1000">
    <tr>
        <td width="33%"><strong>Nama</strong></td>
        <td width="3%"><strong>: </strong></td>
        <td width="65%"><strong>&nbsp;'.strtoupper($nama).'</strong></td>
    </tr>
    <tr >
        <td width="33%"><strong>No. Mykad</strong></td>
        <td width="3%"><strong>: </strong></td>
        <td width="65%"><strong>&nbsp;'.$mykad.'</strong></td>
    </tr>
    <tr >
        <td width="33%"><strong>Jawatan</strong></td>
        <td width="3%"><strong>: </strong></td>
        <td width="65%"><strong>&nbsp;'.strtoupper($perihalSkim).'</strong></td>
    </tr> 
    <tr >
        <td width="33%"><strong>Gred </strong></td>
        <td width="3%"><strong>: </strong></td>
        <td width="65%"><strong>&nbsp;'.strtoupper($gred).'</strong></td>
    </tr>  
    <tr>
        <td width="33%"><strong>Lokasi Bertugas</strong></td>
        <td width="3%"><strong>: </strong></td>
        <td width="65%"><strong>&nbsp;'.strtoupper($perihalFasiliti).'</strong></td>
    </tr>   
    <tr >
        <td width="33%"><strong>Penempatan</strong></td>
        <td width="3%"><strong>: </strong></td>
        <td><strong>&nbsp;'.strtoupper($perihalPenempatan).'</strong></td>
    </tr>
    <tr >
        <td width="33%"><strong>Tarikh Ujian</strong></td>
        <td width="3%"><strong>: </strong></td>
        <td width="65%"><strong>&nbsp;'.$tarikhUjian.'</strong></td>
    </tr>
</table>
<br/><br/>
<table width="80%" border="0" cellspacing="0" cellpadding="5" class="offset2" align="center">
    <tr >
        <td align="left">
            <table width="80%" border="0" cellpadding="1"  cellspacing="1" align="left" >
                <tr><td><strong>TEKANAN</strong></td></tr>
                <tr><td>
                        <table align="center" width="1000" border="0" cellspacing="5" cellpadding="5">
                            <tr bgcolor="#F5A9A9" align="center">
                                <td align="center"><strong>SOALAN</strong></td>
                                '.$td5.'
                                <td><div align="center"><strong>JUMLAH</strong></div></td>
                            </tr>
                            <tr bgcolor="#E6E6E6">
                                <td align="center"><strong>MARKAH</strong></td>
                                '.$td6.'
                                <td align="center">'.$s.'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr ><td align="left">&nbsp;</td></tr>
    <tr align="left">
        <td align="left">
            <table width="80%" border="0" cellpadding="1"  cellspacing="1" align="left" >
                <tr><td><strong>KEBIMBANGAN</strong></td></tr>
                <tr><td>
                        <table align="center" width="1000" border="0" cellspacing="5" cellpadding="5">
                            <tr bgcolor="#F5A9A9">
                                <td align="center"><strong>SOALAN</strong></td>
                                '.$td3.'
                                <td align="center"><strong>JUMLAH</strong></td>
                            </tr>
                            <tr bgcolor="#E6E6E6">
                                <td align="center"><strong>MARKAH</strong></td>
                                '.$td4.'
                                <td align="center">'.$a.'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr align="left"><td align="left">&nbsp;</td></tr>
    <tr align="left">
        <td align="left">
            <table width="80%" border="0" cellpadding="1"  cellspacing="1" align="left" >
                <tr><td><strong>KEMURUNGAN</strong></td></tr>
                <tr><td>
                        <table align="center" width="1000" border="0" cellspacing="5" cellpadding="5">
                            <tr bgcolor="#F5A9A9">
                                <td align="center"><strong>SOALAN</strong></td>
                                '.$td1.'
                                <td><div align="center"><strong>JUMLAH</strong></div></td>
                            </tr>
                            <tr bgcolor="#E6E6E6">
                                <td align="center"><strong>MARKAH</strong></td>
                                '.$td2.'
                                <td align="center">'.$m.'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr align="left"><td align="left">&nbsp;</td></tr>
    <tr align="left">
        <td align="left">
            <table width="1000" border="0" cellspacing="5" cellpadding="5">
                <tr bgcolor="#F5A9A9">
                    <td align="center" width="50%" ><strong>KRITERIA</strong></td>
                    <td align="center" width="50%"><strong>TAHAP</strong></td>
                </tr>
                <tr bgcolor="#E6E6E6" >
                    <td align="center"><strong>TEKANAN</strong></td>
                    <td align="center"><strong>'.strtoupper($skor3).'</strong></td>
                </tr>
                <tr bgcolor="#E6E6E6" >
                    <td align="center"><strong>KEBIMBANGAN</strong></td>
                    <td align="center"><strong>'.strtoupper($skor2).'</strong></td>
                </tr>
                <tr bgcolor="#E6E6E6" >
                    <td align="center"><strong>KEMURUNGAN</strong></td>
                    <td align="center"><strong>'.strtoupper($skor1).'</strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>';      
 ?>