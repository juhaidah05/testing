<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   Mohd. Aidil Mohd. Nayan
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (12 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<div class="">
    <div class="span10 offset1">    
        <div class="widget-box" >
            <div class="widget-title"><span class="icon"><i class="icon-th-large"></i></span><h5>Ujian Yang Aktif</h5></div>
            <div class="widget-content">
                <div style="margin-left: 10px;  ">
                <?php 
                    echo tbs_horizontal_form_open('', array('id'=>'lihat_keputusan'));
                    if($exist>0){                        
                        echo tbs_horizontal_input(array('name'=>'kodUjian', 'id'=>'kodUjian','value'=>set_value('kodUjian', $kodUjian),'class'=>'input-large','maxlength'=>'50','readonly' => 'readonly'), array('label'=>'Jenis Ujian'), false);
                        echo tbs_horizontal_input(array('name'=>'siri','id'=>'siri','value'=>set_value('siri', $siri),'class'=>'input-large','maxlength'=>'50','readonly' => 'readonly'), array('label'=>'Siri'), false);
                        echo tbs_horizontal_input(array('name'=>'kategoriUjian','id'=>'kategoriUjian','value'=>set_value('kategoriUjian', $kategoriUjian),'class'=>'input-large','maxlength'=>'50','readonly' => 'readonly'), array('label'=>'Kategori Ujian'), false);
                        echo tbs_horizontal_input(array('name'=>'mula','id'=>'mula','value'=>set_value('mula', $mula),'class'=>'input-large','maxlength'=>'50','readonly' => 'readonly'), array('label'=>'Tarikh Mula'), false);
                        echo tbs_horizontal_input(array('name'=>'akhir','id'=>'akhir','value'=>set_value('akhir', $akhir),'class'=>'input-large','maxlength'=>'50','readonly' => 'readonly'), array('label'=>'Tarikh Akhir'), false);
                    } else {
                        echo '<i><b>'.$msg.'</b></i>';
                    }//end if
                    echo form_close();
                ?>
                </div>
            </div>
        </div>
        <i><b><font style=" color:  #CC0000">Sila klik pada menu Ambil Ujian untuk mengambil ujian.</font></b></i>
    </div>
</div>
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>