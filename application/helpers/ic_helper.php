<?php

function tarikh_lahir($ic) {
    
    $tahun = substr($ic, 0, 2);
    $bulan = substr($ic, 2, 2);
    $hari = substr($ic, 4, 2);
    
    (($tahun > 15) ? $tahun='19'.$tahun : $tahun = '20'.$tahun);
    
    if(!checkdate($bulan, $hari, $tahun)){
        return false;
    }
    else{
        return $hari.'-'.$bulan.'-'.$tahun;
    }
    
    
}

function umur($ic){
    
    $tahun = substr($ic, 0, 2);
    (($tahun > 15) ? $tahun='19'.$tahun : $tahun = '20'.$tahun);
    
    $umur = date('Y')-$tahun;
    
    return $umur;
}

function jantina($ic){
    
    $kod = substr($ic,-1);

    if($kod % 2 == 0){          // % -> modulus
        return "P";
    }
    else{
        return "L";
    }
}

?>
