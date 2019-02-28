<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (29 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Tambah pernyataan defined('BASEPATH') OR exit('No direct script access allowed');
 *                      5. Buang $this->load->helper('html');
 *                      6. Buang $this->load->helper(array('form', 'url'));
 *                      7. Buang variable2 yang tidak perlu
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class PengaktifanUlangan extends MY_Controller {

    public function __construct() {
        parent::__construct();       
        $this->_ci =& get_instance();
        $this->authentication->check();
        $this->load->model("Eminda_model");
        $this->load->model("Ujianulangan_model");
        $this->load->model("Senaraicalon_model");
    }//end method
    
    //SENARAI - MODUL
    function semakTarikh() {        
        $tarikhMulaUlang  = $this->input->post('tarikhMulaUlang');
        $tarikhAkhirUlang  = $this->input->post('tarikhAkhirUlang');
        echo (date('Y-m-d',strtotime($tarikhAkhirUlang)) >= date('Y-m-d',strtotime($tarikhMulaUlang))) ? "no":"yes";
    }//end method
    
    function ujian_ulangan(){            
        $data['title'] = "Pengaktifan Ujian Ulangan";
        $data['kodUjian_list'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'kodUjian', 'orderby'=>'kodUjian'),1);
        $data['statusUjian'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif');
        $this->_render_page($data);
    }//end method
    
    //KEMASKINI - MODUL
    function ulangan_kemaskini(){    
        $id = $this->input->post('idAmbilan');
        $kodUjian = $this->input->post('kodUjian');
        $siri = $this->input->post('siri'); 
        $tarikhTutup = $this->input->post('tarikhTutup'); 
        
        date_default_timezone_set('Asia/Kuala_Lumpur');        
        $tarikhMulaUlangTemp = $this->input->post('tarikhMulaUlang'); 
        $datecurrent = date('Y-m-d');
       
              
        if($tarikhMulaUlangTemp!='')
              { $data['ulangan']['tarikhMulaUlang'] =  date('Y-m-d',strtotime($tarikhMulaUlangTemp)); }        
                $tarikhAkhirUlangTemp = $this->input->post('tarikhAkhirUlang');     
                
        if($tarikhAkhirUlangTemp!='')
              { $data['ulangan']['tarikhAkhirUlang'] =  date('Y-m-d',strtotime($tarikhAkhirUlangTemp)); }        
      //}    // tutup 1    
        $statusUjian = $this->input->post('statusUjian');
      
        $data['ulangan']['statusUjian'] = $statusUjian;// Dropdown List        
        //form validation        
        $this->form_validation->set_rules('tarikhMulaUlang','Dari','required');     
        $this->form_validation->set_rules('tarikhAkhirUlang','Hingga','required');
        $this->form_validation->set_rules('statusUjian','Status Ujian','required');
        if($this->form_validation->run() == true) {            
            if(date('Y-m-d',strtotime($tarikhAkhirUlangTemp))>=date('Y-m-d',strtotime($tarikhMulaUlangTemp))) {                
                if($statusUjian>0) {                
                    $statusActive = $this->Ujianulangan_model->checkActive($id,$data['ulangan']);
                    if($statusActive) {
                        echo "Ujian AKTIF Sudah Wujud!";
                    } else {
                        $msg = "Ujian Ulangan ".$kodUjian." Siri ".$siri." Dari ".$tarikhMulaUlangTemp." Hingga ".$tarikhAkhirUlangTemp." Berjaya Diaktifkan!";
                        $this->Ujianulangan_model->update($id,$data['ulangan']);
                        if($this->input->is_ajax_request()) {
                            echo $msg;
                        } else {
                            flashMsg($msg,'success');
                            redirect('pengaktifanUlangan/ujian_ulangan');
                        }//end if
                    }//end if
                } else {
                    $msg = "Ujian Ulangan Berjaya Dikemaskini!";
                    $this->Ujianulangan_model->update($id,$data['ulangan']);
                    if($this->input->is_ajax_request()) {
                        echo $msg;
                    } else {
                        flashMsg($msg,'success');
                        redirect('pengaktifanUlangan/ujian_ulangan');
                    }//end if
                }//end if
            } else {                
                echo "Tarikh Ujian Ulangan Tidak Sah!";                
            }//end if
        } else {            
            echo "Ujian Ulangan Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method
    
    function ulangan_papar(){           
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id'); 
            $ulangan = $this->Eminda_model->get_info('ambilan', array('idAmbilan'=>$id));            
            $ulangan['tarikhMulaUlang'] = ($ulangan['tarikhMulaUlang']!=null) ? date('d-m-Y',strtotime($ulangan['tarikhMulaUlang'])):null;
            $ulangan['tarikhAkhirUlang'] = ($ulangan['tarikhAkhirUlang']!=null) ? date('d-m-Y',strtotime($ulangan['tarikhAkhirUlang'])):null;
            echo json_encode($ulangan);
        }    
    }//end method
    
    // SENARAI - HASIL CARIAN
    function listJson_ulangan(){
        
        $modul = $this->Ujianulangan_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Jenis Ujian', 'class'=>'text-center'),array('data'=>'Siri UJian', 'class'=>'text-center'),array('data'=>'Bilangan Calon', 'class'=>'text-center'),array('data'=>'Tarikh Mula', 'class'=>'text-center'),array('data'=>'Tarikh Akhir', 'class'=>'text-center'),array('data'=>'Tarikh Tutup Ujian', 'class'=>'text-center'),array('data'=>'Status Ujian', 'class'=>'text-center'),array('data'=>'Rekod Ujian', 'width'=>'150px', 'class'=>'text-center')));
        //set table data

        // $id = $this->input->post('id'); 
        // $ulangan = $this->Eminda_model->get_info('ambilan', array('idAmbilan'=>$id));

        $bil = 1;
        $Curr_date = date('Y-m-d');
       echo 'Tarikh semasa : '. $Curr_date;  
        
        //print_r($modul);
        
         foreach ($modul as $key => $val) {
             
               $tarikhtutup1 = date('Y-m-d',strtotime($val['tarikhTutup']));
               $statusUjian1 = ($val['statusUjian']>0) ? 'Aktif':'Tidak Aktif';
               //$statusUjian1;
               $link = "<a href='senarai_calon/".$val['idAmbilan']."' title='Senarai Calon' attr='".$val['idAmbilan']."' class='hover'><b>".$val['bilCalon']."</b></a>";
            // here
            if (( $Curr_date < $tarikhtutup1  )  && ( $statusUjian1 == 'Aktif'))
            {
                  $button = "<a href='' class='' id='' data-toggle='modal' title='Kemaskini Ujian Ulangan' attr='".$val['idAmbilan']."'><i class=''></i> </a>";           
            }
            else 
            {
                  $button = "<a href='#myModalUpdate' class='btn btn-orange' id='edit' data-toggle='modal' title='Kemaskini Ujian Ulangan' attr='".$val['idAmbilan']."'><i class='icon icon-edit icon-white'></i> KEMASKINI</a>";       
            }//tutup else 
     date_default_timezone_set('Asia/Kuala_Lumpur');
            
            $tarikhMulaUlang =  ($val['tarikhMulaUlang']!=null) ? date('d-m-Y',strtotime($val['tarikhMulaUlang'])):"-";
            $tarikhAkhirUlang = ($val['tarikhAkhirUlang']!=null) ? date('d-m-Y',strtotime($val['tarikhAkhirUlang'])):"-";
            $tarikhtutup = ($val['tarikhTutup']!=null) ? date('d-m-Y',strtotime($val['tarikhTutup'])):"-";
            $statusUjian = ($val['statusUjian']>0) ? 'Aktif':'Tidak Aktif';
            
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodUjian'], 'class'=>'text-center'),array('data'=>$val['siri']."/".$val['tahun'], 'class'=>'text-center'), array('data'=>$link, 'class'=>'text-center'),array('data'=>$tarikhMulaUlang, 'class'=>'text-center'),array('data'=>$tarikhAkhirUlang, 'class'=>'text-center'),array('data'=>$tarikhtutup, 'class'=>'text-center'),array('data'=>$statusUjian, 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
    
    function getGred() {
        $idSkim = $this->input->post('id');
        if ($idSkim != '') {
            $gred = $this->Eminda_model->get_select_list('perkhidmatan', array('key'=>'gred', 'val'=>'gred'),'Semua fasiliti','skim = "'.$idSkim.'"');       
            echo '<div class="control-group">';
            echo '<label for="gred" class="control-label">Gred</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('gred', $gred,'', 'id = "gred"');
            echo '<span class="help-inline"></span></div></div>';
        }
    }//end method
    
    function getFasiliti() {
        $kodJenisFasiliti = $this->input->post('id');
        if($kodJenisFasiliti != '') {
            $kodFasiliti = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti'),'Semua fasiliti','kodJenisFasiliti = "'.$kodJenisFasiliti.'"');       
            echo '<div class="control-group">';
            echo '<label for="kodFasiliti" class="control-label">Lokasi Bertugas</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('kodFasiliti', $kodFasiliti,'', 'id = "kodFasiliti"');
            echo '<span class="help-inline"></span></div></div>';
        }
    }//end method

    function getPenempatan() {
        $kodFasiliti = $this->input->post('id');
        if($kodFasiliti != '') {
            $kodPenempatan = $this->Eminda_model->get_select_list3('_padananFP', array('key'=>'penempatan', 'val'=>'perihalPenempatan'),'Semua fasiliti','fasiliti = "'.$kodFasiliti.'"');       
            echo '<div class="control-group">';
            echo '<label for="lokasiBertugas" class="control-label">Penempatan</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('kodPenempatan', $kodPenempatan,'', 'id = "kodPenempatan"');
            echo '<span class="help-inline"></span></div></div>';
        }//end foreach
    }//end method
        
    function senarai_calon($idAmbilan){
        $data['title'] = "Senarai Calon";        
        $data['idAmbilan'] = $idAmbilan;        
        $data['list_jantina'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'perihalJantina'),1);
        $data['list_jawatan'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'perihalSkim'),1);
        $data['list_gred'] = array(''=>'-- Sila Pilih --');
        $data['list_kodJenisFasiliti'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'perihalJenisFasiliti'),1);
        $data['list_kodFasiliti'] = array(''=>'-- Sila Pilih --');
        $data['list_penempatan'] = array(''=>'-- Sila Pilih --');
        $this->_render_page($data);
    }//end method
    
    function listJson_calon(){        
        $idAmbilan = $this->input->post('idAmbilan');
        $kodJantina = $this->input->post('kodJantina');
        $idSkim = $this->input->post('idSkim');
        $gred = $this->input->post('gred');
        $kodJenisFasiliti = $this->input->post('kodJenisFasiliti');
        $kodFasiliti = $this->input->post('kodFasiliti');
        $kodPenempatan = $this->input->post('kodPenempatan');
        $calon = $this->Senaraicalon_model->findAll($idAmbilan, $kodJantina, $idSkim, $gred, $kodJenisFasiliti, $kodFasiliti, $kodPenempatan);
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Nama Pegawai', 'class'=>'text-center'),array('data'=>'No. MyKad', 'class'=>'text-center'),array('data'=>'ID Ujian', 'class'=>'text-center'),array('data'=>'Jantina', 'class'=>'text-center'),array('data'=>'Lokasi Bertugas', 'class'=>'text-center'),array('data'=>'Penempatan', 'class'=>'text-center')));             
        //set table data 
        $bil = 1;
        foreach ($calon as $key => $val) {        
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['nama']),array('data'=>$val['mykad'], 'class'=>'text-center'),array('data'=>$val['maxID'], 'class'=>'text-center'),array('data'=>$val['jantina'], 'class'=>'text-center'),array('data'=>$val['perihalFasiliti']),array('data'=>$val['perihalPenempatan'])));     
            $bil++;
        }
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ records per page"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
}//end class