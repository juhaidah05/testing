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
 *                      6. Buang variable2 yang tidak perlu
 * 	(21 Dis 2015)	:	1. tambah $id = $this->input->post('id'); pada method delete
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaktifan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_ci =& get_instance();
        $this->authentication->check();
        $this->load->model("Eminda_model");
        $this->load->model('Pengaktifanujian_model');  
    }//end method
    
    //UNTUK CARIAN SENGGARAAN UJIAN
    //LISTING STAFF 
    function senggara_ujian(){
        $data['title'] = "Pengaktifan Ujian";
        $data['list_kodUjian'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'perihalUjian', 'orderby'=>'kodUjian'),1);
        $data['list_status_searching'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif'); 
        $countActive = $this->Pengaktifanujian_model->checkActive(); // refer functiom dlm model
        $data['list_status'] = ($countActive) ? array(''=>'-- Sila Pilih --','0'=>'Tidak Aktif') : array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif'); 
        $data['list_siri'] = array(''=>'-- Sila Pilih --', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4','5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9','10'=>'10'); 
        $data['tahun'] = date('Y');
        $this->_render_page($data);
    }//end method

    //SENARAI SENARAI SIRI DR TABLE AMBILAN
    function listJson(){
        $kodUjian= $this->input->post('kodUjian');
        $siri= $this->input->post('siri');
        $tahun=$this->input->post('tahun');
        $tarikhBuka=$this->input->post('tarikhBuka');
        $tarikhTutup=$this->input->post('tarikhTutup');
        $statusUjian=$this->input->post('statusUjian');
        $users = $this->Pengaktifanujian_model->findAll($kodUjian, $siri, $tahun, $tarikhBuka, $tarikhTutup, $statusUjian);
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'120px', 'class'=>'text-center'),array('data'=>'Jenis Ujian', 'width'=>'300px', 'class'=>'text-center'),array('data'=>'Siri', 'width'=>'300px', 'class'=>'text-center'),array('data'=>'Tarikh Mula','width'=>'300px', 'class'=>'text-center'),array('data'=>'Tarikh Tamat','width'=>'300px', 'class'=>'text-center'),array('data'=>'Status','width'=>'150px', 'class'=>'text-center'),array('data'=>'Tindakan', 'class'=>'text-center', 'width'=>'230')));
        //set table data
        $bil = 1;
        foreach ($users as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar' attr='".$val['idAmbilan']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini' attr='".$val['idAmbilan']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Tukar Status' id='tkr_status' attr='".$val['idAmbilan']."'><i class='icon icon-refresh'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Rekod' id='delete' attr='".$val['idAmbilan']."'><i class='icon-trash'></i></a>";
            $status = ($val['statusUjian']=='1')? "Aktif":"Tidak Aktif";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'), array('data'=>$val['kodUjian'], 'class'=>'text-center'),  array('data'=>$val['siri']."/".$val['tahun'], 'class'=>'text-center'),array('data'=>date('d-m-Y',strtotime($val['tarikhBuka'])), 'class'=>'text-center'), array('data'=>date('d-m-Y',strtotime($val['tarikhTutup'])), 'class'=>'text-center'), array('data'=>$status, 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>"; 
    }//end method
    
    //PAPAR - pengaktifan ujian
    function senggara_ujianPapar(){  
        if($this->input->is_ajax_request()) {
            //$id = $this->input->post('id'); 
            $ambilan = $this->Eminda_model->get_info('ambilan', array('idAmbilan'=>$this->input->post('id')));            
            $ambilan['tarikhBuka'] = date('d-m-Y',strtotime($ambilan['tarikhBuka']));
            $ambilan['tarikhTutup'] = date('d-m-Y',strtotime($ambilan['tarikhTutup']));
            $ambilan['tarikhBuka_papar'] = date('d-m-Y',strtotime($ambilan['tarikhBuka']));
            $ambilan['tarikhTutup_papar'] = date('d-m-Y',strtotime($ambilan['tarikhTutup']));
            if($ambilan['statusUjian']>0) { $ambilan['list_status'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif');}            
            echo json_encode($ambilan);
        }    
    }//end method
    
    //tujuan kemaskini   
    function senggara_ujianKemaskini(){    
        $id = $this->input->post('idAmbilan');
        $kodUjian = $this->input->post('kodUjian');
        $tahun = $this->input->post('tahun');
        //$statusUjian = $this->input->post('statusUjian');
        $siri = $this->input->post('siri');
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $tarikhKemaskini = date('Y-m-d H:i:s');
        $idKemaskini = $this->session->userdata('username');
        $tarikhBukaTemp = $this->input->post('tarikhBuka');        
        if($tarikhBukaTemp!=''){ $data['update']['tarikhBuka'] =  date('Y-m-d',strtotime($tarikhBukaTemp)); }        
        $tarikhTutupTemp = $this->input->post('tarikhTutup');        
        if($tarikhTutupTemp!=''){ $data['update']['tarikhTutup'] =  date('Y-m-d',strtotime($tarikhTutupTemp));} 
        $data['update']['statusUjian'] = $this->input->post('statusUjian');
        $data['update']['tarikhKemaskini'] = $tarikhKemaskini; 
        $data['update']['idKemaskini'] = $idKemaskini;      
        $this->form_validation->set_rules('tarikhBuka','Dari','required');     
        $this->form_validation->set_rules('tarikhTutup','Hingga','required');
        $this->form_validation->set_rules('statusUjian','Status Ujian','required');
        $this->form_validation->set_rules('tarikhKemaskini','Tarikh Kemaskini');
        $this->form_validation->set_rules('idKemaskini','ID Kemaskini');
        if($this->form_validation->run() == true){ 
            if(date('Y-m-d',strtotime($tarikhTutupTemp))>=date('Y-m-d',strtotime($tarikhBukaTemp))) { 
                $msg = "Ujian ".$kodUjian." Siri ".$siri."/".$tahun." Dari ".$tarikhBukaTemp." Hingga ".$tarikhTutupTemp." Berjaya Dikemaskini!";
                $this->Pengaktifanujian_model->update($id,$data['update']);
                if($this->input->is_ajax_request()){
                    echo $msg;            
                } else {
                    flashMsg('Rekod Berjaya Dikemaskini!','success');
                    redirect('pengaktifan/senggara_ujian');
                }//end if
            } else {
                echo "Tarikh Siri Ujian Tidak Sah!";  
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method
   
    //TAMBAH rekod siri pengaktifan ujian
    function tambah_rekodUjian(){
        $tarikhWujud = date('Y-m-d H:i:s');
        $data['tahun'] = date('Y');        
        $idWujud = $this->session->userdata('username');
        $msg = "Ujian ".$this->input->post('kodUjian')." Untuk Siri ".$this->input->post('siri')."/".$this->input->post('tahun')." telah Wujud!";        
        $data['pengaktifan']['kodUjian'] = $this->input->post('kodUjian');  
        $data['pengaktifan']['siri'] = $this->input->post('siri'); 
        $data['pengaktifan']['tahun'] = $this->input->post('tahun'); 
        $data['pengaktifan']['tarikhBuka'] = date('Y-m-d',strtotime($this->input->post('tarikhBuka_tambah')));
        $data['pengaktifan']['tarikhTutup'] = date('Y-m-d',strtotime($this->input->post('tarikhTutup_tambah')));
        $data['pengaktifan']['statusUjian'] = $this->input->post('statusUjian');
        $data['pengaktifan']['tarikhWujud'] = $tarikhWujud; 
        $data['pengaktifan']['idWujud'] = $idWujud;
        //form validation            
        $this->form_validation->set_rules('kodUjian','Perihal Skim','required');
        $this->form_validation->set_rules('siri','Jenis Klasifikasi Skim','required');
        $this->form_validation->set_rules('tahun','Tahun','required');
        $this->form_validation->set_rules('tarikhBuka_tambah','Tarikh Buka','required');
        $this->form_validation->set_rules('tarikhTutup_tambah','Tarikh Tutup','required');
        $this->form_validation->set_rules('statusUjian','Status Ujian','required');
        $this->form_validation->set_rules('tarikhWujud','Tarikh Tutup');
        $this->form_validation->set_rules('idWujud','ID Wujud');           
        if($this->form_validation->run() == true){ // 1
            if(date('Y-m-d',strtotime($this->input->post('tarikhTutup_tambah'))) >= date('Y-m-d',strtotime($this->input->post('tarikhBuka_tambah')))) {          
                $insert_id = $this->Pengaktifanujian_model->save($data['pengaktifan']);
                if($insert_id =='true') {
                    if($this->input->is_ajax_request()){
                        echo "Rekod Berjaya Disimpan!";
                    } else {
                        flashMsg('Rekod Berjaya Disimpan!','success');
                        redirect('pengaktifan/senggara_ujian');
                    }//end if
                } else {
                    echo $msg;
                }//end if
            } else {
                echo "Tarikh yang dimasukkan tidak sah!";  
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data); }        
    }//end method    
    
    // function delete rekod siri pengaktifan
    function senggara_ujianHapus(){
        $id = $this->input->post('id');
        // CHECK TIADA idambilan dalam table ujian    
        // pastikan didalam table ujian tiada idAmbilan yang ingin di delete
        $countidAmbilan = $this->Eminda_model->get_count('ujian',array('idAmbilan'=>$id)); 
        if($countidAmbilan == 0) {
            $this->Pengaktifanujian_model->delete($id);
            echo "Rekod Berjaya Dihapuskan!";
        } else {			   
            echo "Rekod tidak dibenarkan HAPUS !";    
        }//end if
    }//end method
  
    //KEMASKINI Status shj
    function senggara_status(){    
        $id = $this->input->post('id');
        date_default_timezone_set('Asia/Kuala_Lumpur');
        //$tarikhKemaskini = date('Y-m-d H:i:s');
        //$idKemaskini = $this->session->userdata('username');
        $ambilan = $this->Eminda_model->get_info('ambilan', array('idAmbilan'=>$id));
        $currStatusUjian = $ambilan['statusUjian'];
        if($currStatusUjian > 0) {
            $data['update']['statusUjian'] = 0;
            $data['update']['tarikhWujud'] = $tarikhWujud; 
            $data['update']['idWujud'] = $idWujud;
            $this->Pengaktifanujian_model->update($id,$data['update']);
            if($this->input->is_ajax_request()){
                echo "Tukar Status Berjaya!";   
            } else {
                redirect('/pengaktifan/senggara_ujian/', 'refresh');
            }//end if
        } else {
            $countidAmbilan = $this->Eminda_model->get_count('ambilan',array('statusUjian'=>'1')); 
            if($countidAmbilan == 0) {
                $data['update']['statusUjian'] = 1;
                $data['update']['tarikhWujud'] = $tarikhWujud; 
                $data['update']['idWujud'] = $idWujud;
                $this->Pengaktifanujian_model->update($id,$data['update']);
                if($this->input->is_ajax_request()){
                    echo "Tukar Status Berjaya!";  
                    redirect('pengaktifan/senggara_ujian/'.$idAmbilan, 'refresh');
                } else {
                      redirect('pengaktifan/senggara_ujian');
                }//end if
            } else {
                echo "Tukar Status Tidak dibenarkan!";
            }//end if
        }//end if
    }//end method
}//end class