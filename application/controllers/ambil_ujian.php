<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : Mohd. Aidil Mohd Nayan
 *  Tujuan Aturcara : Controller Class bagi proses pengambil ujian
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (21 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Buang $this->load->helper('html');
 *                      4. Ringkaskan pernyataan if
 *                      5. Tambah pernyataan defined('BASEPATH') OR exit('No direct script access allowed');
 *                      6. Comment $statusUjian = $ambilan['statusUjian'];
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Ambil_ujian extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_ci =& get_instance();
        $this->load->model("Eminda_model");
        $this->load->model("Semakpengguna_model");
    }//end method    
    
    function semak_pengguna() {        
        $this->authentication->check();
        //$data['title'] = 'Semakan Pengguna';
        $msg = null;
        $ambilan = $this->Semakpengguna_model->ambilan_aktif();
        if($ambilan['idAmbilan']!=null) {
            $idAmbilan = $ambilan['idAmbilan'];
            $kodUjian = $ambilan['kodUjian'];
            $siri = $ambilan['siri'];
            $tahun = $ambilan['tahun'];
            $siriUjian = $kodUjian." (Siri : ".$siri."/".$tahun.")";
            $tarikhBuka = $ambilan['tarikhBuka'];
            $tarikhTutup = $ambilan['tarikhTutup'];
            $tarikhMulaUlang = $ambilan['tarikhMulaUlang'];
            $tarikhAkhirUlang = $ambilan['tarikhAkhirUlang'];
            //$statusUjian = $ambilan['statusUjian'];
            $mykad = $this->_ci->session->userdata('username');
            if(date('Y-m-d')>=$tarikhBuka && date('Y-m-d')<=$tarikhTutup) {
                $semak_ujian = $this->Semakpengguna_model->semak_ujian($idAmbilan, $mykad);
                if($semak_ujian['bil_ujian']<1) {
                    redirect('question/kemaskini_pengguna/'.$mykad);                       
                } else {
                    $bil_ujian = $semak_ujian['bil_ujian'];
                    $statusUlang = $semak_ujian['statusUlang'];
                    if($bil_ujian<2) { // Bil. Ujian Adalah 1 Atau 2
                        $msg = ($statusUlang>0) ?
                            "Anda Sudah Menjawab Untuk Ujian ".$siriUjian: // Gagal
                            "Anda Telah Mengambil Ujian ".$siriUjian.". Sila Lihat Keputusan"; // Lihat Keputusan
                    } else {
                        $msg = "Anda Tidak Dibenarkan Menjawab Ujian ".$siriUjian." (Maksimum : 2 Kali Sahaja)"; // Sudah jawab 2 Kali (Jika Wujud)
                    }//end if
                }//end if
            } else {
                if($tarikhMulaUlang!=null && $tarikhAkhirUlang!=null) {
                    if(date('Y-m-d')>=$tarikhMulaUlang && date('Y-m-d')<=$tarikhAkhirUlang) {
                        $semak_ujian = $this->Semakpengguna_model->semak_ujian($idAmbilan, $mykad);
                        if($semak_ujian['bil_ujian']>0) {
                            $bil_ujian = $semak_ujian['bil_ujian'];
                            $statusUlang = $semak_ujian['statusUlang'];
                            if($bil_ujian>1) {
                                $msg = "Anda Tidak Dibenarkan Menjawab Ujian ".$siriUjian." (Maksimum : 2 Kali Sahaja)";
                            } else {
                                if($statusUlang>0) {                                
                                    redirect('question/kemaskini_pengguna/'.$mykad); // Gagal (Kena Ulang)
                                } else {
                                    $msg = "Anda Telah Mengambil Ujian ".$siriUjian.". Sila Lihat Keputusan"; // Lihat Keputusan
                                }//end if                                                                       
                            }//end if
                        } else {
                            $msg = "Anda Tidak Boleh Mengambil Ujian Ulangan ".$siriUjian; // Lihat Keputusan$
                        }//end if
                    } else {
                        $msg = "Ujian ".$siriUjian." Sudah Ditutup";
                    }//end if
                } else {
                    $msg = "Ujian Ulangan ".$siriUjian." Masih Belum Dibuka";
                }//end if
            }//end if
        } else {
            $msg = "Tiada Ujian Yang Aktif";
        }//end if        
        $data['msg'] = $msg;        
        $this->_render_page($data);
    }//end method    
}//end class