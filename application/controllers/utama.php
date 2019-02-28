<?php

/*  Tarikh Cipta    :   ?
 *  Programmer      :   Haezal Musa
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Tambah pernyataan defined('BASEPATH') OR exit('No direct script access allowed');
 *                      4. Buang $this->load->helper('html');
 *                      5. Pindahkan $this->authentication->check(); dari method semak_ujian() kepada __construct()
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Utama extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_ci =& get_instance();
        $this->authentication->check();
        $this->load->model("Eminda_model");
        $this->load->model("Semakpengguna_model");
    }//end method
    
    function semak_ujian() {
        $msg = null;                
        $ambilan = $this->Semakpengguna_model->ambilan_aktif();        
        if($ambilan['idAmbilan']!=null) {            
            $data['exist'] = 1;            
            $data['kodUjian'] = $ambilan['kodUjian'];
            $data['siri'] = $ambilan['siri']."/".$ambilan['tahun'];            
            $tarikhBuka = $ambilan['tarikhBuka'];
            $tarikhTutup = $ambilan['tarikhTutup'];
            $tarikhMulaUlang = $ambilan['tarikhMulaUlang'];
            $tarikhAkhirUlang = $ambilan['tarikhAkhirUlang'];            
            if(date('Y-m-d')>=$tarikhBuka && date('Y-m-d')<=$tarikhTutup) {                
                $data['mula'] = date('d-m-Y',strtotime($tarikhBuka));
                $data['akhir'] = date('d-m-Y',strtotime($tarikhTutup));                
                $data['kategoriUjian'] = "UJIAN";
            }            
            if(date('Y-m-d')>=$tarikhMulaUlang && date('Y-m-d')<=$tarikhAkhirUlang) {                
                $data['mula'] = date('d-m-Y',strtotime($tarikhMulaUlang));
                $data['akhir'] = date('d-m-Y',strtotime($tarikhAkhirUlang));                
                $data['kategoriUjian'] = "UJIAN ULANGAN";
            }
        } else {            
            $data['exist'] = 0;            
            $data['msg'] = "Tiada Ujian Yang Aktif";
        }//end if        
        $this->_render_page($data);
    }//end method    
}//end class