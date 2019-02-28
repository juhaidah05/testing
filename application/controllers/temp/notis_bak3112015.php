<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Controller Class bagi menetapkan notis
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (11 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Buang $this->load->helper('html');
 *                      4. Ringkaskan pernyataan if
 *  (30 Sept 2015)  :   1. Tambah pernyataan defined('BASEPATH') OR exit('No direct script access allowed');
 *                      2. Buang $this->load->library('form_validation');
 *                      3. Buang $this->load->library('pagination');
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Notis extends MY_Controller {
	
    public function __construct(){
        parent::__construct();        
        $this->_ci =& get_instance();
        $this->authentication->check();
        $this->load->model("Eminda_model");
        $this->load->model('Tbl_pengguna_model');
        $this->load->model('Tbl_notisperingatan_model');
        $this->load->model('Tbl_penerimanotis_model');
    }//end method

    //TAMBAH STAFF LIST
    function selenggara_notis(){
        $id = $this->session->userdata('username');
        $lokaliti = $this->session->userdata('lokaliti');
        // untuk post data
        $data['title'] = "Selenggara Notis";
        $data['selenggaranotis']['idpengguna'] = $id;
        $data['selenggaranotis']['tajukNotis'] = $this->input->post('tajuknotis');
        $data['selenggaranotis']['notis'] = $this->input->post('templatenotis');
        $data['selenggaranotis']['lokalitiAdmin'] = $lokaliti;
        // kemaskini data
        $data['papar'] = $this->Eminda_model->get_info('notisPeringatan', array('idPengguna'=>$id, 'lokalitiAdmin'=>$lokaliti));
        $data['selenggaranotisupd']['idpengguna'] = $id;
        $data['selenggaranotisupd']['tajukNotis'] = $this->input->post('tajuknotis');
        $data['selenggaranotisupd']['notis'] = $this->input->post('templatenotis');
        $data['selenggaranotisupd']['lokalitiAdmin'] = $lokaliti;
        $data['selenggaranotisupd']['idKemaskini'] = $this->session->userdata('username');
        $data['selenggaranotisupd']['tarikhKemaskini'] = date('Y-m-d H:i:s' );
        //form validation			
        $this->form_validation->set_rules('tajuknotis','Tajuk Notis','required');
        $this->form_validation->set_rules('templatenotis','Template Notis','required');
        if($this->form_validation->run() == true){			  
            $countnokp = $this->Eminda_model->get_count('notisPeringatan',array('idPengguna'=>$id,'lokalitiAdmin'=>$lokaliti));
            if($countnokp != 0){
                $this->Tbl_notisperingatan_model->update_data('notisPeringatan',array('lokalitiAdmin'=>$lokaliti), $data['selenggaranotisupd']);
                flashMsg('Rekod Berjaya Dikemaskini.','success');
		redirect('notis/selenggara_notis/'.$id);
            } else {
                $this->Tbl_notisperingatan_model->save($data['selenggaranotis']);
                flashMsg('Rekod Berjaya Disimpan.','success');
                redirect('notis/selenggara_notis/'.$id);
            }//end if				 
        }//end if		   
        $this->_render_page($data);			   
    }//end method
	   
    function selenggara_emel(){		 
        $id = $this->session->userdata('username');
        $lokaliti = $this->session->userdata('lokaliti');
        $this->db->select('mykad,levelAdmin,lokaliti');
        $this->db->where('mykad = "'.$id.'" AND lokaliti = "'.$lokaliti.'" ');
        $query = $this->db->get('pengguna');
        $sql_tcurr1 = $query->row_array();
        
        $checkactive = $this->Eminda_model->get_count('penerimaNotis',array('lokalitiAdmin'=>$lokaliti,'statusPN'=>1));
	$data['list_status'] = ($checkactive>=2) ? array(''=>'-- Sila Pilih --','0'=>'Tidak Aktif'):array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif');
                
        // untuk post data
        $data['title'] = "Selenggara Emel";
        $data['selenggaraemel']['idpengguna'] = $id;
        $data['selenggaraemel']['lokalitiAdmin'] = $this->input->post('fasiliti');
        $data['selenggaraemel']['jawatanPN'] = $this->input->post('jawatan');
        $data['selenggaraemel']['namaPN'] = $this->input->post('nama');
        $data['selenggaraemel']['emelPN'] = $this->input->post('alamatemel');
        $data['selenggaraemel']['statusPN'] =  $this->input->post('status');
        //form validation
        $this->form_validation->set_rules('jawatan','Jawatan Penerima Notis','required');
        $this->form_validation->set_rules('nama','Nama Penerima Notis','required');
        $this->form_validation->set_rules('alamatemel','Alamat Penerima Notis','required');
        $this->form_validation->set_rules('status','Status Aktif','required');
	if($this->form_validation->run() == true){			  			  
            $countnokp = $this->Eminda_model->get_count('penerimaNotis',array('idPengguna'=>$id, 'lokalitiAdmin'=>$lokaliti,'statusPN'=>1));
            if(($this->input->post('status')=='0')||($countnokp < 2)) {
                $this->Tbl_penerimanotis_model->save($data['selenggaraemel']);
                flashMsg('Rekod Berjaya Disimpan.','success');
                redirect('notis/selenggara_emel');
            } else {			   
                flashMsg('Rekod tidak boleh melebihi dua penerima notis yang aktif .','error');
                redirect('notis/selenggara_emel');   
            }//end if
        }//end if
        $this->_render_page($data);
    }//end method
	 
    function papar_rekod($id){
	$data['papar1'] = $this->Eminda_model->get_info('penerimaNotis',array('ID'=>$id),$sort="ASC");
	$this->_render_page($data);
    }//end method

    function kemaskini_rekod($id){		 
        //$idpengguna = $this->session->userdata('username');
	$lokaliti = $this->session->userdata('lokaliti');
        $data['kemaskini'] = $this->Eminda_model->get_info('penerimaNotis',array('ID'=>$id),$sort="asc");
	// untuk post data
	$data['update']['lokalitiAdmin'] = $lokaliti;
        $data['update']['jawatanPN'] = $this->input->post('jawatan');
        $data['update']['namaPN'] = $this->input->post('nama');
        $data['update']['emelPN'] = $this->input->post('alamatemel');
        $data['update']['statusPN'] = $this->input->post('status');
	$data['status'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'kodJantina'),1);
	//form validation
        $this->form_validation->set_rules('jawatan','Jawatan Penerima Notis','required');
        $this->form_validation->set_rules('nama','Nama Penerima Notis','required');
        $this->form_validation->set_rules('alamatemel','Alamat Penerima Notis','required');
        $this->form_validation->set_rules('status','Status Aktif','required');
        if($this->form_validation->run() == true) {			  
            $countnokp = $this->Eminda_model->get_count('penerimaNotis',array('lokalitiAdmin'=>$lokaliti,'statusPN'=>$this->input->post('status')));
            if(($this->input->post('status')=='0')||($countnokp < 2)){
                $this->Tbl_penerimanotis_model->update_data('penerimaNotis',array('ID'=>$id), $data['update']);
                flashMsg('Rekod Berjaya Disimpan.','success');
                redirect('notis/selenggara_emel');
            } else {			   
                flashMsg('Rekod tidak boleh melebihi dua penerima notis yang aktif.','error');
                redirect('notis/selenggara_emel');   
            }//end if
        }//end if
        $this->_render_page($data);
    }//end method
    
    //HAPUS STAF LIST
    function delete() {
        $id = $this->input->post('id');       
        $this->Tbl_penerimanotis_model->delete($id);
        echo "Rekod Berjaya Dihapuskan";
    }//end method
	 
    function listJson(){			
        $id = $this->session->userdata('username');
        $lokaliti = $this->session->userdata('lokaliti');
        $users = $this->Eminda_model->get_list('penerimaNotis','ID',array('lokalitiAdmin'=>$lokaliti),$sort="ASC");
	//set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic ">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'50px', 'class'=>'text-center'),array('data'=>'Jawatan', 'width'=>'100px', 'class'=>'text-center'),array('data'=>'Nama','width'=>'100px', 'class'=>'text-center'),array('data'=>'Alamat Emel','width'=>'100px', 'class'=>'text-center'),array('data'=>'Status','width'=>'100px', 'class'=>'text-center'),array('data'=>'Tindakan', 'class'=>'text-center', 'width'=>'100')));             
        //set table data 
        $bil = 1;
        foreach ($users as $key => $val) {		
            $v1 = ($val['statusPN']=='1') ? 'Aktif': 'Tidak Aktif';
            $button = "<a href='papar_rekod/".$val['ID']."' class='btn btn-info btn-mini' id='view'  title='Papar' attr='".$val['ID']."'><i class='icon icon-zoom-in icon-white'></i></a>";
            $button .= nbs(1)."<a href='kemaskini_rekod/".$val['ID']."' class='btn btn-info btn-mini' id='update' title='Kemaskini' attr='".$val['ID']."'><i class='icon icon-edit icon-white'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-info btn-mini' title='Hapus' id='delete' attr='".$val['ID']."'><i class='icon icon-trash icon-white'></i></a>";
            $this->table->add_row(array(array('data'=>$bil.'.', 'class'=>'text-center'), array('data'=>$val['jawatanPN'], 'class'=>'text-center'),array('data'=>$val['namaPN'], 'class'=>'text-center'),array('data'=>$val['emelPN'], 'class'=>'text-center'),array('data'=>$v1, 'class'=>'text-center'),$button));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
    }//end method
}//end class