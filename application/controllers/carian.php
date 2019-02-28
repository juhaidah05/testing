<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Controller Class bagi proses carian
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (11 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Buang $this->load->helper('html');
 *                      4. Ringkaskan pernyataan if
 *  (21 Sept 2015)  :   1. Buang $this->load->library('email');
 *                      2. Tambah method2 baru:
 *                          a) papar_keputusan_depression()
 *                          b) papar_keputusan_enxiety()
 *                          c) papar_keputusan_stress()
 *                      3. Tambah pernyataan defined('BASEPATH') OR exit('No direct script access allowed');
 *	(12 Apr 2016)	: 	1. Tabah kawalan supaya memaparkan dropdown peranan mengikut capaian pengguna pada baris 116
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Carian extends MY_Controller {
    public function __construct() {
        parent::__construct();        
        $this->_ci =& get_instance();
        $this->authentication->check();	
        $this->load->model("Eminda_model");	
        $this->load->model('applicant_model');        
        $this->load->model('Tbl_pengguna_model');
        $this->load->model('Tbl_profil_model');
        $this->load->model('Tbl_perkhidmatan_model');
    }//end method
    
    function semakMyKad() {        
        $myKad  = $this->input->post('myKad');
        if($myKad != '') {
            $data = $this->Eminda_model->semakMyKad($myKad);
            echo $data;
        }
    }//end method
    
    function semakPassword() {
        echo ($this->input->post('password') == $this->input->post('repassword')) ? "no":"yes";
    }//end method

    function getFasiliti() {           
        $fasiliti = $this->input->post('id');
        if($fasiliti != '') {
            $levelAdmin = $this->session->userdata('role');
            if($levelAdmin<2) {
                $lokaliti = $this->session->userdata('lokaliti');
                $newfasiliti = $this->Eminda_model->get_info('_kodFasiliti', array('kodFasiliti'=>$lokaliti));
                $kodJenisFasiliti = $newfasiliti['kodJenisFasiliti'];
                $get_lokasi = ($kodJenisFasiliti == 6) ? array('kodJenisFasiliti'=>$fasiliti, 'lokalitiPentadbir'=>$lokaliti):array('kodJenisFasiliti'=>$fasiliti, 'kodFasiliti'=>$lokaliti);
            } else {
                $get_lokasi = array('kodJenisFasiliti'=>$fasiliti);
            }//end if
            $lokasiBertugas = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti','orderby'=>'x'),'Semua fasiliti',$get_lokasi);       
            echo '<div class="control-group"><label for="lokasiBertugas" class="control-label">Lokasi Bertugas</label><div class="controls" style="width:auto;">';
            echo form_dropdown('lokasiBertugas', $lokasiBertugas,'', 'id = "lokasiBertugas"');
            echo '<span class="help-inline"></span></div></div>';
        }
    }//end method
   
    function getPenempatan() {
        $lokasiBertugas = $this->input->post('id');
        if($lokasiBertugas != '') {
            $penempatan = $this->Eminda_model->get_select_list3('_padananFP', array('key'=>'penempatan', 'val'=>'perihalPenempatan','orderby'=>'x'),'Semua fasiliti','fasiliti = "'.$lokasiBertugas.'"');
            echo '<div class="control-group">';
            echo '<label for="lokasiBertugas" class="control-label">Penempatan</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('penempatan', $penempatan,'', 'id = "penempatan"');
            echo '<span class="help-inline"></span>';
            echo '</div>';
            echo '</div>';
        }
    }//end method
    
    //UNTUK CARIAN PENGGUNA
    //LISTING STAFF 
    function pengguna($ic='',$name=''){
        $levelAdmin = $this->session->userdata('role');
        if($levelAdmin<2) {
            $lokaliti = $this->session->userdata('lokaliti');
            $fasiliti = $this->Eminda_model->get_info('_kodFasiliti', array('kodFasiliti'=>$lokaliti));
            $kodJenisFasiliti = $fasiliti['kodJenisFasiliti'];
            if($kodJenisFasiliti == 6) {
                $list_jenis = "kodJenisFasiliti IN (SELECT kodJenisFasiliti FROM _kodFasiliti WHERE lokalitiPentadbir='".$lokaliti."')";
				//echo  $list_jenis;
                $list_lokasi = array('lokalitiPentadbir'=>$lokaliti);
				//echo $list_lokasi;
                $list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti IN (SELECT kodFasiliti FROM (_kodFasiliti) WHERE lokalitiPentadbir='".$lokaliti."'))";
				//echo $list_penempatan;
            } else {
                $list_jenis = array('kodJenisFasiliti'=>$kodJenisFasiliti);
                $list_lokasi = array('kodFasiliti'=>$lokaliti);
                $list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti='".$lokaliti."')";                 
            }//end if
        } else {
            $list_jenis = "x";
            $list_lokasi = "x";
            $list_penempatan = "x";
        }//end if
        
        $data['title'] = "Carian Pengguna";
        $data['nama'] = $this->input->post('nama');
        $data['mykad'] = $this->input->post('mykad');
        $data['jantina_u'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'x'),1); 
        $data['skim_u'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'IdSkim'),1); 
        $data['jenisFasiliti_u'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1,$list_jenis);
        $data['lokasiBertugas_u'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1,$list_lokasi);
        $data['penempatan_u'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1,$list_penempatan);   
        $data['status_u'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif');
        
		if($levelAdmin==2){
			$data['levelAdmin_u'] = array(''=>'-- Sila Pilih --', '2'=>' Super Admin', '1'=>'Admin', '0'=>'Pengguna'); 
		} else {
			$data['levelAdmin_u'] = array(''=>'-- Sila Pilih --', '1'=>'Admin', '0'=>'Pengguna'); 
		}	
        
		$data['ic'] = $ic;
		$data['name'] = $name;		
		
        $this->_render_page($data);

    }//end method
    
    //TAMBAH STAFF LIST
    function tambah_rekod($id=NULL){
        $levelAdmin = $this->session->userdata('role');
        if($levelAdmin<2) {
            $lokaliti = $this->session->userdata('lokaliti');
            $fasiliti = $this->Eminda_model->get_info('_kodFasiliti', array('kodFasiliti'=>$lokaliti));
            $kodJenisFasiliti = $fasiliti['kodJenisFasiliti'];
            if($kodJenisFasiliti == 6) {
                $list_jenis = "kodJenisFasiliti IN (SELECT kodJenisFasiliti FROM _kodFasiliti WHERE lokalitiPentadbir='".$lokaliti."')";
                $list_lokasi = array('lokalitiPentadbir'=>$lokaliti);
                $list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti IN (SELECT kodFasiliti FROM (_kodFasiliti) WHERE lokalitiPentadbir='".$lokaliti."'))";
            } else {
                $list_jenis = array('kodJenisFasiliti'=>$kodJenisFasiliti);
                $list_lokasi = array('kodFasiliti'=>$lokaliti);
                $list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti='".$lokaliti."')";                 
            }//end if
        } else {
            $list_jenis = "x";
            $list_lokasi = "x";
            $list_penempatan = "x";
        }//end if
        $dataic = $this->Eminda_model->get_count('perkhidmatan', array('mykad'=>$id));
        if($dataic==''){
            $data = $this->Eminda_model->get_info('profil', array('mykad'=>$id));
        } else {
            $this->db->select('a.*, b.*');
            $this->db->from('perkhidmatan a');
            $this->db->join('profil b','b.mykad=a.mykad');
            $this->db->where('b.mykad',$id);
            $this->db->order_by("a.idPerkhidmatan","desc");
            $query_data = $this->db->get();
			$data = $query_data->row_array();
			
			 
        }//end if                
        $data['status_u'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif');
        $data['levelAdmin_u'] = array(''=>'-- Sila Pilih --', '2'=>' Super Admin', '1'=>'Admin', '0'=>'Pengguna'); 
        $data['jantina_u'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'x'),1);  
        $data['skim_u'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'IdSkim'),1); 
        $data['jenisFasiliti_u'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1,$list_jenis);
        $data['lokasiBertugas_u'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1,$list_lokasi);
        $data['penempatan_u'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1,$list_penempatan);     
        $data['title'] = "DAFTAR PROFIL PENGGUNA";
        $data['upengguna']['mykad'] = $this->input->post('mykad');
        $data['upengguna_profil']['mykad'] = $this->input->post('mykad');
        $data['upengguna_profil']['nama'] = $this->input->post('nama');
        $data['upengguna_profil']['jantina'] = $this->input->post('jantina');
        $data['upengguna']['emel'] = $this->input->post('emel');
        $data['pengguna']['mykad'] = $this->input->post('mykad');
        $data['pengguna']['katalaluan'] = md5 ($this->input->post('katalaluan'));
        $data['pengguna']['re_katalaluan'] = md5($this->input->post('re_katalaluan'));
        $data['pengguna']['lokaliti'] = $this->input->post('lokasiBertugas'); // Untuk Table pengguna
        $data['pengguna']['tarikhKemaskini'] = $this->input->post('tarikhKemaskini');
        $data['upengguna']['skim'] = $this->input->post('skim');
        $data['upengguna']['gred'] = $this->input->post('gred');
        $data['upengguna']['jenisFasiliti'] = $this->input->post('jenisFasiliti');
        $data['upengguna']['lokasiBertugas'] = $this->input->post('lokasiBertugas');
        $data['upengguna']['penempatan'] = $this->input->post('penempatan');
        $data['pengguna']['status'] = $this->input->post('status');
        $data['pengguna']['levelAdmin'] = $this->input->post('levelAdmin');
        $userid = $this->input->post('mykad');
        $this->form_validation->set_rules('mykad','No MyKad','required|max_length[12]');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('jantina','Jantina','required');
        $this->form_validation->set_rules('katalaluan','Katalaluan','required');
        $this->form_validation->set_rules('re_katalaluan','re_katalaluan','required');
        $this->form_validation->set_rules('emel','Emel','required');  
        $this->form_validation->set_rules('skim','Jawatan','required');
        $this->form_validation->set_rules('gred','Gred','required');  
        $this->form_validation->set_rules('jenisFasiliti','Jenis Fasiliti','required');       
        $this->form_validation->set_rules('lokasiBertugas','Lokasi Bertugas','required');
        $this->form_validation->set_rules('penempatan','Penempatan','required');
        $this->form_validation->set_rules('status','Status','required');
        $this->form_validation->set_rules('levelAdmin','LevelAdmin','required');              
        if($this->form_validation->run() == true){
            $userid = $this->input->post('mykad');
            //$nama = $this->input->post('nama');
            $emel = $this->input->post('emel');
            $tarikhKemaskini=  date('d-m-Y');
            $katalaluan = $this->input->post('katalaluan');	
            //$this->load->library('email');
            $this->email->from('eminda@moh.gov.my', 'Aplikasi Saringan Minda Sihat');
            $this->email->to($emel);
            $this->email->cc('');
            $this->email->bcc('');
            $this->email->subject('Kata Laluan eMINDA');
            $this->email->message(
"Salam Sejahtera,
    
ID Pengguna dan Kata Laluan eMINDA telah diwujudkan

pada " .$tarikhKemaskini. " sebagaimana berikut :  

ID Pengguna : " .$userid. "
    
Kata Laluan : " .$katalaluan. "

    
Sekian , terima kasih.

Daripada,
Pentadbir eMINDA");
            $this->email->send();
            $this->Tbl_pengguna_model->save($data['pengguna']); 
            $this->Tbl_profil_model->save($data['upengguna_profil']);
            $this->db->select('lokalitiPentadbir');
            $this->db->from('_kodFasiliti');
            $this->db->where('kodFasiliti',$this->input->post('lokasiBertugas'));
            $query_fasiliti = $this->db->get();
            $lokalitiP = $query_fasiliti->row_array();
            $lokalitiPentadbir = $lokalitiP['lokalitiPentadbir'];
            $data['upengguna']['lokalitiPentadbir'] = $lokalitiPentadbir;
            $this->Tbl_perkhidmatan_model->save($data['upengguna']);
            flashMsg('ID Pengguna '.$userid.' Telah Berjaya Didaftarkan', 'success');
            //dapatkan id perkhidmatan
            $this->db->select('idPerkhidmatan');
            $this->db->from('perkhidmatan');
            $this->db->order_by("idPerkhidmatan","desc");
            $query_perkhidmatan = $this->db->get();
            $perkhidmatan = $query_perkhidmatan->row_array();
            //$idPerkhidmatan =  $perkhidmatan['idPerkhidmatan'];
            redirect('carian/pengguna');
        } else { }            
        if(!$this->input->is_ajax_request()){
            $this->_render_page($data);
        }
    }//end method   
    
    //PAPAR STAFF LIST
    function papar_rekod($id){                 
		$dataic = $this->Eminda_model->get_count('perkhidmatan', array('mykad'=>$id));
		if($dataic==''){
            $data = $this->Eminda_model->get_info('profil', array('mykad'=>$id));
        } else {
            $this->db->select('a.*, b.*, c.levelAdmin');
            $this->db->from('perkhidmatan a');
            $this->db->join('profil b','b.mykad=a.mykad');
            $this->db->join('pengguna c','c.mykad=a.mykad');
            $this->db->where('b.mykad',$id);
            $this->db->order_by("a.idPerkhidmatan","desc");
            //$this->db->limit(0, 1);
            
            $query_data = $this->db->get();
            
            //echo $this->db->last_query();
            $data = $query_data->row_array();
            //$idPerkhidmatan=$data['idPerkhidmatan'];
        }//end if     
		$data['role'] = $data['levelAdmin'];	
        $data['status'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif'); 
        $data['jantina_u'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'x'),1);  
        $data['skim_u'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'x'),1); 
        $data['jenisFasiliti_u'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
        $data['lokasiBertugas_u'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1);
        $data['penempatan_u'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);       
        $data['upengguna']['mykad'] = $this->session->userdata('username');
        $data['upengguna_profil']['nama'] = $this->input->post('nama');
        $data['upengguna_profil']['jantina'] = $this->input->post('jantina');
        $data['upengguna']['emel'] = $this->input->post('emel');
        $data['upengguna']['skim'] = $this->input->post('skim');
        $data['upengguna']['gred'] = $this->input->post('gred');
        $data['upengguna']['jenisFasiliti'] = $this->input->post('jenisFasiliti');
        $data['upengguna']['lokasiBertugas'] = $this->input->post('lokasiBertugas');
        $data['upengguna']['penempatan'] = $this->input->post('penempatan');        
        //paparan sejarah ujian
        $this->db->select('a.*, b.*');
        $this->db->from('ujian a');
        $this->db->join('ambilan b','a.idAmbilan = b.idAmbilan');
        $this->db->where(array('mykad'=>$id));
        $this->db->order_by("a.idAmbilan","desc");
        $query_u = $this->db->get();
        $u = $query_u->result_array();
        $data['kodUjian']= $u;        
        //untuk table tbl_users
        if(!$this->input->is_ajax_request()){
            $this->_render_page($data);
        }
    }//end method
	
    //lihat keputusan
    function lihat_keputusan(){
        $id = $this->session->userdata('username');
        $role = $this->session->userdata('role');
		$dataic = $this->Eminda_model->get_count('perkhidmatan', array('mykad'=>$id));       
        if($dataic==''){
            $data = $this->Eminda_model->get_info('profil', array('mykad'=>$id));
        } else {
            $this->db->select('a.*, b.*,c.levelAdmin');
            $this->db->from('perkhidmatan a');
            $this->db->join('profil b','b.mykad=a.mykad');
			$this->db->join('pengguna c','c.mykad=a.mykad');
            $this->db->where('b.mykad',$id);
            $this->db->order_by("a.idPerkhidmatan","desc");
            $query_data = $this->db->get();
            $data = $query_data->row_array();
            //$idPerkhidmatan=$data['idPerkhidmatan'];
        }//end if     
        $data['role'] = $role;
        $data['status'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif'); 
        $data['jantina_u'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'kodJantina'),1);  
        $data['skim_u'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'IdSkim'),1); 
        $data['jenisFasiliti_u'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
        $data['lokasiBertugas_u'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1);
        $data['penempatan_u'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);       
        $data['upengguna']['mykad'] = $this->session->userdata('username');
        $data['upengguna_profil']['nama'] = $this->input->post('nama');
        $data['upengguna_profil']['jantina'] = $this->input->post('jantina');
        $data['upengguna']['emel'] = $this->input->post('emel');
        $data['upengguna']['skim'] = $this->input->post('skim');
        $data['upengguna']['gred'] = $this->input->post('gred');
        $data['upengguna']['jenisFasiliti'] = $this->input->post('jenisFasiliti');
        $data['upengguna']['lokasiBertugas'] = $this->input->post('lokasiBertugas');
        $data['upengguna']['penempatan'] = $this->input->post('penempatan');        
        //paparan sejarah ujian
        $this->db->select('a.*, b.*');
        $this->db->from('ujian a');
        $this->db->join('ambilan b','a.idAmbilan = b.idAmbilan');
        $this->db->where(array('mykad'=>$id));
        $this->db->order_by("a.idAmbilan","desc");
        $query_u = $this->db->get();
        $u = $query_u->result_array();
        $data['kodUjian']= $u;        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){
            $this->_render_page($data);
        }
    }//end method
	
    //PAPARAN SEJARAH
    function papar_sejarah($mykad,$idUjian,$idPerkhidmatan){
        $username =  $this->session->userdata('username');
		$this->db->select('a.*');
        $this->db->from('pengguna a');
        $this->db->where('a.mykad',$username);
        $this->db->order_by("a.mykad","desc");
        $query_data_user = $this->db->get();
        $d2tr = $query_data_user->row_array();
		
		
        $data['history']= $d2tr;		   
		//dapatkan siri/tahun
        $this->db->select('g.*,f.siri, f.tahun ');
        $this->db->from('ujian g');
        $this->db->join('ambilan f','f.idAmbilan=g.idAmbilan');
        $this->db->where('g.mykad',$mykad);
        $this->db->where('g.idPerkhidmatan',$idPerkhidmatan);
        $this->db->where('g.idUjian ="'.$idUjian.'"');
        $this->db->order_by("g.tarikhWujud","desc");
        $queryambil = $this->db->get();
        $ambil = $queryambil->row_array();
		
        $data['siri']= $ambil['siri'];
        $data['tahun']= $ambil['tahun'];
        //dapatkan data profil dan perkhidmatan
        $this->db->select('a.*, b.nama, c.perihalSkim, d.perihalFasiliti, e.perihalPenempatan,f.*,j.*');
        $this->db->from('perkhidmatan a');
        $this->db->join('profil b','b.mykad=a.mykad');
        $this->db->join('_kodSkimPerkhidmatan c','c.IdSkim=a.skim');
        $this->db->join('_kodFasiliti d','d.kodFasiliti=a.lokasiBertugas');
        $this->db->join('_kodPenempatan e','e.kodPenempatan=a.penempatan');
        $this->db->join('_kodJenisFasiliti f','a.jenisFasiliti=f.kodJenisFasiliti');
        $this->db->join('_kodJantina j','b.jantina=j.kodJantina');
        $this->db->where('a.mykad',$mykad);
        $this->db->where('a.idPerkhidmatan',$idPerkhidmatan);
        $this->db->order_by("a.tarikhWujud","desc");
        $querydetail = $this->db->get();
        $detail = $querydetail->row_array();  
      
        //----------------------------------------------------------
        $data['nama']= $detail['nama'];
        $data['mykad']= $detail['mykad'];
        $data['perihalSkim']= $detail['perihalSkim'];
        $data['gred']= $detail['gred'];
        $data['perihalJenisFasiliti']= $detail['perihalJenisFasiliti'];
        $data['perihalFasiliti']= $detail['perihalFasiliti'];
        $data['perihalPenempatan']= $detail['perihalPenempatan'];
        $data['jantina']= $detail['perihalJantina'];
        $data['emel']= $detail['emel'];
        $data['idPerkhidmatan']= $detail['idPerkhidmatan'];
        $this->db->select('*');
        $this->db->from('ujian');
        $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
        $this->db->order_by("tarikhWujud","desc");
        $this->db->where('idUjian ="'.$idUjian.'"');
        $querym = $this->db->get();
        $marks = $querym->row_array(); 
		
        $data['idUjian'] = $marks['idUjian'];
        $data['tarikhUjian'] = date('d-m-Y', strtotime($marks['tarikhUjian']));			   
        //kemurungan
        $data['skor1'] = $this->papar_keputusan_depression($marks['skor1']);
		//Anxiety
        $data['skor2'] = $this->papar_keputusan_enxiety($marks['skor2']);
        //stress
		$data['skor3'] = $this->papar_keputusan_stress($marks['skor3']);        
        $this->db->select('a.* ');                                 
        $this->db->from('txnUjian a');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 1));
        $this->db->order_by("tarikhWujud","desc");
        $query_markah_kemurungan = $this->db->get();
        $u1 = $query_markah_kemurungan->result_array();
		
        $data['td1'] = '';
        $data['td2'] = '';
		//-------------------------------------------------------------
        $bil = 1; 
        foreach ($u1 as $key => $val) {
            $data['td1'].= '<td align="center"><strong>'.'S'.$val['idSoalan'].'</strong></td>';
            $data['td2'].= '<td align="center">'.$val['skor'].'</td>';
	    $bil++;
		}//end foreach				
        $this->db->select('a.* ');                                 
        $this->db->from('txnUjian a');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' =>2));
        $this->db->order_by("tarikhWujud","desc");
        $query_markah_anziety = $this->db->get();
        $u2 = $query_markah_anziety->result_array();
		
        $data['td3'] = '';
        $data['td4'] = '';
        //-------------------------------------------------------------				
		$bil = 1; 
        foreach ($u2 as $key => $val) {
            $data['td3'].= '<td align="center"><strong>'.'S'.$val['idSoalan'].'</strong></td>';
            $data['td4'].= '<td align="center">'.$val['skor'].'</td>';
            $bil++;
		}//end foreach	
        $this->db->select('a.* ');                                 
        $this->db->from('txnUjian a');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 3));
        $this->db->order_by("tarikhWujud","desc");
        $query_markah_stres = $this->db->get();
        $u3 = $query_markah_stres->result_array();
		
        $data['td5'] = '';
        $data['td6'] = '';	
        //-------------------------------------------------------------				
        $bil = 1; 
        foreach ($u3 as $key => $val)   {
            $data['td5'].= '<td align="center"><strong>'.'S'.$val['idSoalan'].'</strong></td>';
            $data['td6'].= '<td align="center">'.$val['skor'].'</td>';
            $bil++;
        }//end foreach													
        //dapatkan jumlah kemurungan
        $this->db->select_sum('skor');
        $this->db->from('txnUjian');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 1));
        $query_markah_m = $this->db->get();
        $m = $query_markah_m->row_array(); 
        $data['m'] = $m['skor'];
        //dapatkan jumlah anxiety
        $this->db->select_sum('skor');
        $this->db->from('txnUjian');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 2));
        $query_markah_a = $this->db->get();
        $a = $query_markah_a->row_array();
		
        $data['a'] = $a['skor'];
        //dapatkan jumlah stress
        $this->db->select_sum('skor');
        $this->db->from('txnUjian');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 3));
        $query_markah_s = $this->db->get();
        $s = $query_markah_s->row_array();
        $data['s'] = $s['skor'];	   
		//---------------------------------------------------------   
        $this->_render_page($data);
    }//end method		 
           
    //KEMASKINI STAFF LIST
    function kemaskini_rekod($id){           
        $levelAdmin = $this->session->userdata('role');
        if($levelAdmin<2) {
            $lokaliti = $this->session->userdata('lokaliti');
            $fasiliti = $this->Eminda_model->get_info('_kodFasiliti', array('kodFasiliti'=>$lokaliti));
            $kodJenisFasiliti = $fasiliti['kodJenisFasiliti'];                
            if($kodJenisFasiliti == 6) {
                $list_jenis = "kodJenisFasiliti IN (SELECT kodJenisFasiliti FROM _kodFasiliti WHERE lokalitiPentadbir='".$lokaliti."')";
                $list_lokasi = array('lokalitiPentadbir'=>$lokaliti);
                $list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti IN (SELECT kodFasiliti FROM (_kodFasiliti) WHERE lokalitiPentadbir='".$lokaliti."'))";
            } else {
                $list_jenis = array('kodJenisFasiliti'=>$kodJenisFasiliti);
                $list_lokasi = array('kodFasiliti'=>$lokaliti);
                $list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti='".$lokaliti."')";
            }//end if
        } else {
            $list_jenis = "x";
            $list_lokasi = "x";
            $list_penempatan = "x";
        }//end if
        $dataic = $this->Eminda_model->get_count('perkhidmatan', array('mykad'=>$id));       
        if($dataic==''){           
            $data = $this->Eminda_model->get_info('profil', array('mykad'=>$id));
        } else {
            //$this->db->select('a.*, b.*, c.*');
            $this->db->select('a.idPerkhidmatan, b.mykad, b.nama, a.emel, a.gred, b.jantina, a.skim, a.jenisFasiliti, a.lokasiBertugas, a.penempatan, c.status, c.levelAdmin');
            $this->db->from('perkhidmatan a');
            $this->db->join('profil b','b.mykad=a.mykad');
            $this->db->join('pengguna c','c.mykad=a.mykad');
            $this->db->where('b.mykad',$id);
            $this->db->order_by("a.idPerkhidmatan","DESC");
            //$this->db->limit(0, 1);
            
            $query_data = $this->db->get();
            
            //echo $this->db->last_query();
            $data = $query_data->row_array();
        }        
        
		$data['status_u'] = array(''=>'-- Sila Pilih --', '1'=>'Aktif', '0'=>'Tidak Aktif'); 
        
		if($levelAdmin==2){
		$data['levelAdmin_u'] = array(''=>'-- Sila Pilih --', '2'=>' Super Admin', '1'=>'Admin', '0'=>'Pengguna'); 
		} else {
			$data['levelAdmin_u'] = array(''=>'-- Sila Pilih --', '1'=>'Admin', '0'=>'Pengguna'); 
		}
        
		$data['jantina_u'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'kodJantina'),1);  
        $data['skim_u'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'IdSkim'),1); 
        $data['jenisFasiliti_u'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'kodJenisFasiliti'),1,$list_jenis);
        $data['lokasiBertugas_u'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'kodFasiliti'),1,$list_lokasi);
        $data['penempatan_u'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'kodPenempatan'),1,$list_penempatan);     
        $data['title'] = "KEMASKINI PROFIL PENGGUNA";
        $idPerkhidmatan = $this->input->post('idPerkhidmatan');
        $data['upengguna_profil']['nama'] = $this->input->post('nama');
        $data['upengguna_profil']['jantina'] = $this->input->post('jantina');
        $data['upengguna']['mykad'] = $this->input->post('mykad');
        $data['upengguna']['emel'] = $this->input->post('emel');
        $data['upengguna']['skim'] = $this->input->post('skim');
        $data['upengguna']['gred'] = $this->input->post('gred');
        $data['upengguna']['jenisFasiliti'] = $this->input->post('jenisFasiliti');
        $data['upengguna']['lokasiBertugas'] = $this->input->post('lokasiBertugas'); // Untuk Table perkhidmatan
        $data['pengguna']['lokaliti'] = $this->input->post('lokasiBertugas'); // Untuk Table pengguna
        $data['upengguna']['penempatan'] = $this->input->post('penempatan');
        $data['pengguna']['status'] = $this->input->post('status');
        $data['pengguna']['levelAdmin'] = $this->input->post('levelAdmin');        
        $this->form_validation->set_rules('mykad','No MyKad','required|max_length[12]');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('jantina','Jantina','required');
        $this->form_validation->set_rules('emel','Emel','required');  
        $this->form_validation->set_rules('skim','Jawatan','required');
        $this->form_validation->set_rules('gred','Gred','required');  
        $this->form_validation->set_rules('jenisFasiliti','Jenis Fasiliti','required');       
        $this->form_validation->set_rules('lokasiBertugas','Lokasi Bertugas','required');
        $this->form_validation->set_rules('penempatan','Penempatan','required');
        $this->form_validation->set_rules('status','Status','required');
        $this->form_validation->set_rules('levelAdmin','LevelAdmin','required');            
        if($this->form_validation->run() == true){
            $this->Tbl_pengguna_model->update($id, $data['pengguna']); 
            $this->Tbl_profil_model->update($id,$data['upengguna_profil']);
            $this->db->select('lokalitiPentadbir');
            $this->db->from('_kodFasiliti');
            $this->db->where('kodFasiliti',$this->input->post('lokasiBertugas'));
            $query_fasiliti = $this->db->get();
            $lokalitiP = $query_fasiliti->row_array();
            $data['upengguna']['lokalitiPentadbir'] = $lokalitiP['lokalitiPentadbir'];//$lokalitiPentadbir;
            //$this->Tbl_perkhidmatan_model->update($idPerkhidmatan, $data['upengguna']);
            $this->Tbl_perkhidmatan_model->save($data['upengguna']);
            flashMsg('Rekod Berjaya Dikemaskini', 'success');
            //dapatkan id perkhidmatan
            $this->db->select('idPerkhidmatan');
            $this->db->from('perkhidmatan');
            $this->db->order_by("idPerkhidmatan","desc");
            $query_perkhidmatan = $this->db->get();
            $perkhidmatan = $query_perkhidmatan->row_array();
            $idPerkhidmatan =  $perkhidmatan['idPerkhidmatan'];
            redirect('carian/pengguna');                
        } else {}     
        $this->_render_page($data);           
    }//end method
       
    //SENARAI STAFF
    function listJson(){        
        $nama = $this->input->post('nama');
        $mykad = $this->input->post('mykad');        
        $levelAdmin = $this->session->userdata('role');        
        $lokaliti = $this->session->userdata('lokaliti');        
        $users = $this->Tbl_profil_model->findAll($nama, $mykad, $levelAdmin, $lokaliti);
		//echo $users; 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array( array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'), array('data'=>'Nama', 'class'=>'text-center'), array('data'=>'No Kad Pengenalan','class'=>'text-center'), array('data'=>'Status', 'class'=>'text-center'), array('data'=>'Tindakan', 'class'=>'text-center', 'width'=>'150') ));
        //set table data
        $bil = 1;
        foreach ($users as $key => $val) {
            $button = "<a href='".site_url('/carian/papar_rekod/'.$val['mykad'])."' class='btn btn-mini' id='view'  title='Papar' attr='".$val['mykad']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='".site_url('/carian/kemaskini_rekod/'.$val['mykad'])."' class='btn btn-mini' id='update' title='Kemaskini' attr='".$val['mykad']."'><i class='icon icon-edit'></i></a>";
            //$button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Tukar Status' id='tukar_status' attr='".$val['mykad']."'><i class='icon icon-refresh'></i></a>";
            
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Tukar Status' id='tkr_status' attr='".$val['mykad']."'><i class='icon icon-refresh'></i></a>";
            //------------
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Reset Kata Laluan' id='reset_password' attr='".$val['mykad']."'><i class='icon icon-repeat'></i></a>";
            $status = ($val['status']>0) ? "Aktif":"Tidak Aktif";
            $this->table->add_row(array( array('data'=>$bil, 'class'=>'text-center'), $val['nama'], array('data'=>$val['mykad'], 'class'=>'text-center'), array('data'=>$status, 'class'=>'text-center'), array('data'=>$button, 'class'=>'text-center') ));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>"; 
    }//end method    
    
    //HAPUS STAF LIST
    function hapus_rekod(){
        $this->Tbl_profil_model->delete($this->input->post('id'));
        echo "Rekod Berjaya Dihapuskan";
    }//end method
    
//    function tukar_status(){
//        $pengguna = $this->Eminda_model->get_info('pengguna', array('mykad'=>$this->input->post('id')));        
//        $currentStatus = ($pengguna['status']>0)?0:1;
//       
//        if ($pengguna )
//        $this->Tbl_pengguna_model->update($this->input->post('id'),$currentStatus);        
//        if($this->input->is_ajax_request()) {            
//            echo "Status Rekod Berjaya Ditukar!";            
//        } else {          
//            flashMsg('Status Rekod Berjaya Ditukar!','refresh');
//            //redirect('carian/pengguna');
//        }//end if
//        
//    
//}//end method	

//edit Status shj---------------------------------------------------------
function senggara_status()
{    
     $id = $this->input->post('id');
     date_default_timezone_set('Asia/Kuala_Lumpur');
     $tarikhKemaskini = date('Y-m-d H:i:s');
     $idKemaskini = $this->session->userdata('username');
     $pengguna = $this->Eminda_model->get_info('pengguna', array('mykad'=>$id));
     $currStatus = $pengguna['status'];
     if($currStatus > 0) 
     { 
       $data['update']['status'] = 0;
       $data['update']['tarikhKemaskini'] = $tarikhKemaskini; 
       $data['update']['idWujud'] = $idKemaskini;
     }
     else 
           { $data['update']['status'] = 1;
            $data['update']['tarikhKemaskini'] = $tarikhKemaskini; 
            $data['update']['idWujud'] = $idKemaskini;
           }
     $this->Tbl_pengguna_model->update($id,$data['update']);    
           if($this->input->is_ajax_request())
              {
                  echo "Tukar Status Berjaya!";  
              }else
                   {
                    redirect('/carian/pengguna/', 'refresh');
                   }
} //tutup tukar status
     
    
    public function cetak_keputusan($mykad,$idPerkhidmatan,$idUjian){ 		  
        $this->load->library('mpdf');    
        $data['title'] = "KEPUTUSAN UJIAN eMINDA";  
        //dapatkan siri/tahun
        $this->db->select('g.*,f.siri, f.tahun ');
        $this->db->from('ujian g');
        $this->db->join('ambilan f','f.idAmbilan=g.idAmbilan');
        $this->db->where('g.mykad',$mykad);
        $this->db->where('g.idPerkhidmatan',$idPerkhidmatan);
        $this->db->where('g.idUjian ="'.$idUjian.'"');
        $this->db->order_by("g.tarikhWujud","desc");
        $queryambil = $this->db->get();
        $ambil = $queryambil->row_array();
        $data['siri']= $ambil['siri'];
        $data['tahun']= $ambil['tahun'];
        //dapatkan data prifil dan perkhidmatan
        $this->db->select('a.*, b.nama, c.perihalSkim, d.perihalFasiliti, e.perihalPenempatan');
        $this->db->from('perkhidmatan a');
        $this->db->join('profil b','b.mykad=a.mykad');
        $this->db->join('_kodSkimPerkhidmatan c','c.IdSkim=a.skim');
        $this->db->join('_kodFasiliti d','d.kodFasiliti=a.lokasiBertugas');
        $this->db->join('_kodPenempatan e','e.kodPenempatan=a.penempatan');
        $this->db->where('a.mykad',$mykad);
        $this->db->where('a.idPerkhidmatan',$idPerkhidmatan);
        $this->db->order_by("a.tarikhWujud","desc");
        $querydetail = $this->db->get();
        $detail = $querydetail->row_array();
        $data['nama']= $detail['nama'];
        $data['mykad']= $detail['mykad'];
        $data['perihalSkim']= $detail['perihalSkim'];
        $data['gred']= $detail['gred'];
        $data['perihalFasiliti']= $detail['perihalFasiliti'];
        $data['perihalPenempatan']= $detail['perihalPenempatan'];
        $this->db->select('*');
        $this->db->from('ujian');
        $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
        $this->db->order_by("tarikhWujud","desc");
        $this->db->where('idUjian ="'.$idUjian.'"');
        $querym = $this->db->get();
        $marks = $querym->row_array();
        $data['tarikhUjian'] = date('d-m-Y', strtotime($marks['tarikhUjian']));		
		//kemurungan
		$data['skor1'] = $this->papar_keputusan_depression($marks['skor1']) ;
        //enxiety
		$data['skor2'] = $this->papar_keputusan_enxiety($marks['skor2']);
        //stress
		$data['skor3'] = $this->papar_keputusan_stress($marks['skor3']);        	   
        $html .= $this->load->view($this->controller.'/cetak_keputusan',$data, true);
        $this->mpdf->AddPage('P');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output('KEPUTUSAN UJIAN eMINDA', 'D');
    }//end method  
    
    public function cetak_keputusan_admin($mykad,$idPerkhidmatan,$idUjian){ 		  
        $this->load->library('mpdf');    
        $data['title'] = "KEPUTUSAN UJIAN eMINDA"; 				
        //dapatkan siri/tahun
        $this->db->select('g.*,f.siri, f.tahun ');
        $this->db->from('ujian g');
        $this->db->join('ambilan f','f.idAmbilan=g.idAmbilan');
        $this->db->where('g.mykad',$mykad);
        $this->db->where('g.idPerkhidmatan',$idPerkhidmatan);
        $this->db->where('g.idUjian ="'.$idUjian.'"');
        $this->db->order_by("g.tarikhWujud","desc");
        $queryambil = $this->db->get();
        $ambil = $queryambil->row_array();
        $data['siri']= $ambil['siri'];
        $data['tahun']= $ambil['tahun'];
        //dapatkan data prifil dan perkhidmatan
        $this->db->select('a.*, b.nama, c.perihalSkim, d.perihalFasiliti, e.perihalPenempatan');
        $this->db->from('perkhidmatan a');
        $this->db->join('profil b','b.mykad=a.mykad');
        $this->db->join('_kodSkimPerkhidmatan c','c.IdSkim=a.skim');
        $this->db->join('_kodFasiliti d','d.kodFasiliti=a.lokasiBertugas');
        $this->db->join('_kodPenempatan e','e.kodPenempatan=a.penempatan');
        $this->db->where('a.mykad',$mykad);
        $this->db->where('a.idPerkhidmatan',$idPerkhidmatan);
        $this->db->order_by("a.tarikhWujud","desc");
        $querydetail = $this->db->get();
        $detail = $querydetail->row_array();			   
        //----------------------------------------------------------	   
        $data['nama']= $detail['nama'];
        $data['mykad']= $detail['mykad'];
        $data['perihalSkim']= $detail['perihalSkim'];
        $data['gred']= $detail['gred'];
        $data['perihalFasiliti']= $detail['perihalFasiliti'];
        $data['perihalPenempatan']= $detail['perihalPenempatan'];
        $this->db->select('*');
        $this->db->from('ujian');
        $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
        $this->db->where('idUjian ="'.$idUjian.'"');
        $this->db->order_by("tarikhWujud","desc");
        $querym = $this->db->get();
        $marks = $querym->row_array();				
        $data['tarikhUjian'] = date('d-m-Y', strtotime($marks['tarikhUjian']));
		//kemurungan
		$data['skor1'] = $this->papar_keputusan_depression($marks['skor1']);
        //anxiety
		$data['skor2'] = $this->papar_keputusan_enxiety($marks['skor2']);
        //stress
		$data['skor3'] = $this->papar_keputusan_stress($marks['skor3']);		   
        $this->db->select('a.* ');                                 
        $this->db->from('txnUjian a');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 1));
        $this->db->order_by("tarikhWujud","desc");
        $query_markah_kemurungan = $this->db->get();
        $u1 = $query_markah_kemurungan->result_array();
        $data['td1'] = '';
        $data['td2'] = '';	
        //-------------------------------------------------------------        
        $bil = 1; 
        foreach ($u1 as $key => $val) {
            $data['td1'].= '<td><strong>'.'S'.$val['idSoalan'].'</strong></td>';
            $data['td2'].= '<td align="center">'.$val['skor'].'</td>';
            $bil++;
        }//end foreach				
        $this->db->select('a.* ');                                 
        $this->db->from('txnUjian a');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' =>2));
        $this->db->order_by("tarikhWujud","desc");
        $query_markah_anziety = $this->db->get();
        $u2 = $query_markah_anziety->result_array();				
        $data['td3'] = '';
        $data['td4'] = '';				
		//-------------------------------------------------------------				
		$bil = 1; 
        foreach ($u2 as $key => $val) {
            $data['td3'].= '<td><strong>'.'S'.$val['idSoalan'].'</strong></td>';
            $data['td4'].= '<td align="center">'.$val['skor'].'</td>';
            $bil++;
        }//end foreach	
        $this->db->select('a.* ');                                 
        $this->db->from('txnUjian a');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 3));
        $this->db->order_by("tarikhWujud","desc");
        $query_markah_stres = $this->db->get();
        $u3 = $query_markah_stres->result_array();

        $data['td5'] = '';
        $data['td6'] = '';				
        //-------------------------------------------------------------				
        $bil = 1; 
        foreach ($u3 as $key => $val) {
            $data['td5'].= '<td><strong>'.'S'.$val['idSoalan'].'</strong></td>';
            $data['td6'].= '<td align="center">'.$val['skor'].'</td>';
            $bil++;
        }//end foreach												
        //dapatkan jumlah kemurungan
        $this->db->select_sum('skor');
        $this->db->from('txnUjian');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 1));
        $query_markah_m = $this->db->get();
        $m = $query_markah_m->row_array(); 
        $data['m'] = $m['skor'];
        //dapatkan jumlah anzieti
        $this->db->select_sum('skor');
        $this->db->from('txnUjian');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 2));
        $query_markah_a = $this->db->get();
        $a = $query_markah_a->row_array(); 
        $data['a'] = $a['skor'];
        //dapatkan jumlah stres
        $this->db->select_sum('skor');
        $this->db->from('txnUjian');
        $this->db->where(array('idUjian'=>$idUjian, 'idKategoriSoalan' => 3));
        $query_markah_s = $this->db->get();
        $s = $query_markah_s->row_array(); 
        $data['s'] = $s['skor'];        
        //---------------------------------------------------------        
        $html .= $this->load->view($this->controller.'/cetak_keputusan_admin',$data, true);
        $this->mpdf->AddPage('P');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output('KEPUTUSAN UJIAN eMINDA', 'D');
    }//end method

    public function reset_password() {        
        $id = $this->input->post('id');        
        $pengguna = $this->Tbl_pengguna_model->get_pengguna($id);        
        $userid = $pengguna['mykad'];
        //$nama = $pengguna['nama'];
        $email = $pengguna['emel'];
        $tarikhKemaskini=  date('d-m-Y');
        //$katalaluan = $pengguna['mykad'];        
        $data['pengguna']['katalaluan'] = md5("A".$id);
        $data['pengguna']['re_katalaluan'] = md5("A".$id);
        $this->Tbl_pengguna_model->update($id, $data['pengguna']);
        if($this->input->is_ajax_request()){
            echo "Kata Laluan Berjaya Direset!";
			//redirect('/carian/pengguna');
        } else{
            //flashMsg('Kata Laluan Berjaya Direset!','success');
            //redirect('carian/pengguna');
        }//end if
        //$this->load->library('email');
        $this->email->from('eminda@moh.gov.my', 'Aplikasi Saringan Minda Sihat');
        $this->email->to($email);
        $this->email->cc('');
        $this->email->bcc('');
        $this->email->subject('Penukaran Kata Laluan eMINDA');
        $this->email->message(
"Salam Sejahtera,
    
Kata laluan bagi pengguna " .$userid. " telah diset semula kepada 

A".$userid." berkuatkuasa pada " .$tarikhKemaskini. "

Tuan/puan adalah dinasihatkan untuk menukar semula kata laluan tersebut.
      
Terima Kasih.

Daripada,
Pentadbir eMINDA");
        $this->email->send();
        //if(!$this->input->is_ajax_request()){ $this->_render_page($data);}        
    }//end method
    
    //kira jenis keputusan markah bagi kemurungan
    function papar_keputusan_depression($skor1){        		
        switch(true){
            case in_array($skor1, range(0,5)): $keputusan= 'NORMAL'; break;
            case in_array($skor1, range(6,7)): $keputusan= 'RINGAN'; break;
            case in_array($skor1, range(8,10)): $keputusan= 'SEDERHANA'; break;
            case in_array($skor1, range(11,14)): $keputusan= 'TERUK'; break;
            case ($skor1 >= 15 ): $keputusan= 'SANGAT TERUK'; break;
        }
        return $keputusan;	
    }//end method

    //kira jenis keputusan markah bagi enxiety    
    function papar_keputusan_enxiety($skor2){
        switch($skor2){
            case in_array($skor2, range(0,4)): $keputusan= 'NORMAL'; break;
            case in_array($skor2, range(5,6)): $keputusan= 'RINGAN'; break;
            case in_array($skor2, range(7,8)): $keputusan= 'SEDERHANA'; break;
            case in_array($skor2, range(9,10)): $keputusan= 'TERUK'; break;
            case ($skor2 >= 11 ): $keputusan= 'SANGAT TERUK'; break;
        }		
        return $keputusan;	
    }//end method
    
    //kira jenis keputusan markah bagi stress
    function papar_keputusan_stress($skor3){
        switch($skor3){
            case in_array($skor3, range(0,7)): $keputusan= 'NORMAL'; break;
            case in_array($skor3, range(8,9)): $keputusan= 'RINGAN'; break;
            case in_array($skor3, range(10,13)): $keputusan= 'SEDERHANA'; break;
            case in_array($skor3, range(14,17)): $keputusan= 'TERUK'; break;
            case ($skor3 >= 18 ): $keputusan= 'SANGAT TERUK'; break;
        }		
        return $keputusan;	
    }//end method    
 }//end class 