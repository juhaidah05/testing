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
 *                      5. Buang $this->load->helper(array('form', 'url'));
 *                      6. Buang $this->load->library('form_validation');
 *                      7. Buang $this->load->library('pagination');
 *                      8. Tambah function papar_keputusan_depression()
 *                      9. Tambah function papar_keputusan_enxiety()
 *                      10. Tambah function papar_keputusan_stress()
 *                      11. Buang variable2 yang tidak perlu
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MY_Controller { 
    
    public function __construct(){
        parent::__construct();
        $this->authentication->check();
        $this->load->model("Eminda_model");
        $this->load->model('applicant_model');			
        $this->load->model('Tbl_pengguna_model');
        $this->load->model('Tbl_profil_model');
        $this->load->model('Tbl_perkhidmatan_model');
    }//end method
   
   function getFasiliti() {
        $fasiliti = $this->input->post('id');
        if($fasiliti != '') {
            $lokasiBertugas = $this->Eminda_model->get_select_list('_kodFasiliti',array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti'),'Semua fasiliti','kodJenisFasiliti = "'.$fasiliti.'"');       
            echo '<div class="control-group">';
            echo '<label for="lokasiBertugas" class="control-label">Lokasi Bertugas</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('lokasiBertugas', $lokasiBertugas,'', 'id = "lokasiBertugas"');
            echo '<span class="help-inline"></span></div></div>';            
        }
    }//end method
   
    function getPenempatan() {
        $lokasiBertugas = $this->input->post('id');
        if($lokasiBertugas != '') {
            $penempatan = $this->Eminda_model->get_select_list3('_padananFP', array('key'=>'penempatan', 'val'=>'perihalPenempatan'),'Semua fasiliti','fasiliti = "'.$lokasiBertugas.'"');       
            echo '<div class="control-group">';
            echo '<label for="Penempatan" class="control-label">Penempatan</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('penempatan', $penempatan,'', 'id = "penempatan"');
            echo '<span class="help-inline"></span></div></div>';
        }
    }//end method
   
   function kemaskini_pengguna(){
        $this->authentication->check();         
        $id = $this->session->userdata('username');
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
        $data['upengguna']['mykad'] = $this->session->userdata('username');
        $data['upengguna_profil']['nama'] = $this->input->post('nama');
        $data['upengguna_profil']['jantina'] = $this->input->post('jantina');
        $data['upengguna']['emel'] = $this->input->post('emel');
        $data['upengguna']['skim'] = $this->input->post('skim');
        $data['upengguna']['gred'] = $this->input->post('gred');
        $data['upengguna']['jenisFasiliti'] = $this->input->post('jenisFasiliti');
        $data['upengguna']['lokasiBertugas'] = $this->input->post('lokasiBertugas');
        $data['upengguna']['penempatan'] = $this->input->post('penempatan');
        //untuk buat dropdown
        $data['jantina_u'] = $this->Eminda_model->get_select_list('_kodJantina', array('key'=>'kodJantina', 'val'=>'perihalJantina', 'orderby'=>'kodJantina'),1);  
        $data['skim_u'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'IdSkim'),1); 
        $data['jenisFasiliti_u'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'kodJenisFasiliti'),1);
        $data['lokasiBertugas_u'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'kodFasiliti'),1);
        $data['penempatan_u'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);        
        //form validation
        $this->form_validation->set_rules('mykad','No MyKad','required|max_length[12]');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('jantina','Jantina','required');
        $this->form_validation->set_rules('emel','Emel','required');  
        $this->form_validation->set_rules('skim','Jawatan','required');
        $this->form_validation->set_rules('gred','Gred','required');  
        $this->form_validation->set_rules('jenisFasiliti','Jenis Fasiliti','required');       
        $this->form_validation->set_rules('lokasiBertugas','Lokasi Bertugas','required');
        $this->form_validation->set_rules('penempatan','Penempatan','required');
        $mykad = $this->session->userdata('username');   
        if($this->form_validation->run() == true){
            //kemaskini data profil
            $this->Tbl_profil_model->update($id,$data['upengguna_profil']);
            //kemaskini data pengguna
            $data['penggunalokaliti']['lokaliti'] = $this->input->post('lokasiBertugas');
            $this->Tbl_pengguna_model->update2($id,$data['penggunalokaliti']);
            $this->db->select('lokalitiPentadbir');
            $this->db->from('_kodFasiliti');
            $this->db->where('kodFasiliti',$this->input->post('lokasiBertugas'));
            $query_fasiliti = $this->db->get();
            $lokalitiP = $query_fasiliti->row_array();
            $lokalitiPentadbir = $lokalitiP['lokalitiPentadbir'];
            $data['upengguna']['lokalitiPentadbir'] = $lokalitiPentadbir;
            if(($data['emel'] != $this->input->post('emel')) || ($data['skim'] != $this->input->post('skim')) || ($data['gred'] != $this->input->post('gred')) || ($data['jenisFasiliti'] != $this->input->post('jenisFasiliti')) || ($data['lokasiBertugas'] != $this->input->post('lokasiBertugas')) || ($data['penempatan'] != $this->input->post('penempatan')) ) {
                $this->Tbl_perkhidmatan_model->save($data['upengguna']);
                flashMsg('Rekod Berjaya Dikemaskini', 'success');
                //dapatkan id perkhidmatan
                $this->db->select('idPerkhidmatan');
                $this->db->from('perkhidmatan');
                $this->db->order_by("idPerkhidmatan","desc");
                $query_perkhidmatan = $this->db->get();
                $perkhidmatan = $query_perkhidmatan->row_array();
                $idPerkhidmatan =  $perkhidmatan['idPerkhidmatan'];
                redirect('question/soalan1/'.$mykad.'/'.$idPerkhidmatan);
            } else {
                $idPerkhidmatan =  $data['idPerkhidmatan'];    
                redirect('question/soalan1/'.$mykad.'/'.$idPerkhidmatan);    
            }//end if
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method
    
    /////////////////SOALAN1 KLINIK////////////////////////////////
    public function soalan1($mykad,$idPerkhidmatan){ 
        $this->authentication->check();
        if(!$this->session->userdata('username')) {      
            redirect('general');     
	} else {  
            $data['appData'] = $this->applicant_model->getdata_DASS(); 
            if($_POST) {   
                $dataPOST = $this->input->post();                        
                //validation jawapan
                $this->form_validation->set_rules('answer-1','Jawapan','required'); 
                $this->form_validation->set_rules('answer-2','Jawapan','required'); 
                $this->form_validation->set_rules('answer-3','Jawapan','required'); 
                $this->form_validation->set_rules('answer-4','Jawapan','required'); 
                $this->form_validation->set_rules('answer-5','Jawapan','required'); 
                $this->form_validation->set_rules('answer-6','Jawapan','required'); 
                $this->form_validation->set_rules('answer-7','Jawapan','required'); 
                $this->form_validation->set_rules('answer-8','Jawapan','required'); 
                $this->form_validation->set_rules('answer-9','Jawapan','required'); 
                $this->form_validation->set_rules('answer-10','Jawapan','required'); 
                $this->form_validation->set_rules('answer-11','Jawapan','required'); 
                $this->form_validation->set_rules('answer-12','Jawapan','required'); 
                $this->form_validation->set_rules('answer-13','Jawapan','required'); 
                $this->form_validation->set_rules('answer-14','Jawapan','required'); 
                $this->form_validation->set_rules('answer-15','Jawapan','required'); 
                $this->form_validation->set_rules('answer-16','Jawapan','required');
                $this->form_validation->set_rules('answer-17','Jawapan','required');
                $this->form_validation->set_rules('answer-18','Jawapan','required');
                $this->form_validation->set_rules('answer-19','Jawapan','required');
                $this->form_validation->set_rules('answer-20','Jawapan','required');
                $this->form_validation->set_rules('answer-21','Jawapan','required');
                if($this->form_validation->run() == true){
                    foreach($dataPOST as $key => $value) {
                        if($key!="btn_Save"){
                            $id_soalan = explode('-', $key); //answer-4
                            $id_soalan[0]; //answer
                            $id_soalan[1]; //idsoalan
                            //dapatkan idSJ, skor & idKategoriSoalan
                            $this->db->select('a.idSJ,b.skor,c.idKategoriSoalan');
                            $this->db->from('_padananSJ a');
                            $this->db->join('_jawapan b','b.idJawapan=a.idJawapan');
                            $this->db->join('_soalan c','c.idSoalan=a.idSoalan');
                            $this->db->where('a.idSoalan',$id_soalan[1]);
                            $this->db->where('a.idJawapan',$this->input->post('answer-'.$id_soalan[1]));
                            $queryjwb = $this->db->get();
                            $jwb = $queryjwb->row_array();
                            $idSJ = $jwb['idSJ'];	
                            $skor = $jwb['skor'];
                            $idKategoriSoalan = $jwb['idKategoriSoalan'];
                            $data['post']['mykad']= $mykad;   
                            $data['post']['idSoalan']= $id_soalan[1];  
                            $data['post']['idSJ']=$idSJ; 
                            $data['post']['skor']=$skor;
                            $data['post']['idKategoriSoalan']=$idKategoriSoalan;
                            $data['post']['idWujud']=$mykad;
                            $data['post']['tarikhWujud']=date('Y-m-d H:i:s');
                            $this->Eminda_model->insert_data('txnUjian', $data['post'] );
                        }//end if
                    }//end foreach
                }//end if
                //insert data dlm table ujian////////////////////////////////////////////////////////////////////////////////                 
                //kiraan bagi status ulang
                $data['postmarkah']['idPerkhidmatan']= $idPerkhidmatan; 
                $data['postmarkah']['idAmbilan']= $this->session->userdata('idAmbilan');
                $data['postmarkah']['mykad']= $mykad; 
                $data['postmarkah']['kodUjian']= $this->session->userdata('kodUjian'); 
                $data['postmarkah']['tarikhUjian']=date('Y-m-d H:i:s'); 
                $data['postmarkah']['statusJawab']=1; 
                $data['postmarkah']['idWujud']=$mykad;
                $data['postmarkah']['tarikhWujud']=date('Y-m-d H:i:s');
                $this->Eminda_model->insert_data('ujian', $data['postmarkah'] );
                //update idUjian dlm table txnUjian////////////////////////////////////////////////////////////
                $this->db->select('*');
                $this->db->from('ujian');
                $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
                $this->db->order_by("tarikhWujud","desc");
                $query_u = $this->db->get();
                $u = $query_u->row_array();
                $idUjian = $u['idUjian'];
                $tarikhWujud = $u['tarikhWujud'];
                $data['postidUjian']['idUjian']=$idUjian;
                $this->Eminda_model->update_data('txnUjian', array('mykad'=>$mykad, 'tarikhWujud'=>$tarikhWujud ), $data['postidUjian']);
                //update dalam table ujian markah skor/////////////////////////////////////////////////////
                //dapatkan jumlah kemurungan
                $this->db->select_sum('skor');
                $this->db->from('txnUjian');
                $this->db->where(array('mykad'=>$mykad, 'idKategoriSoalan' => 1));
                $this->db->where('idUjian ="'.$idUjian.'"');
                $this->db->order_by("tarikhWujud","desc");
                $query_markah_kemurungan = $this->db->get();
                $kemurungan = $query_markah_kemurungan->row_array(); 
                $markah_kemurungan = $kemurungan['skor'];
                //dapatkan jumlah anzieti
                $this->db->select_sum('skor');
                $this->db->from('txnUjian');
                $this->db->where(array('mykad'=>$mykad, 'idKategoriSoalan' => 2));
                $this->db->where('idUjian ="'.$idUjian.'"');
                $this->db->order_by("tarikhWujud","desc");
                $query_markah_anzieti = $this->db->get();
                $anzieti = $query_markah_anzieti->row_array(); 
                $markah_anzieti = $anzieti['skor'];
                //dapatkan jumlah stres
                $this->db->select_sum('skor');
                $this->db->from('txnUjian');
                $this->db->where(array('mykad'=>$mykad, 'idKategoriSoalan' => 3));
                $this->db->where('idUjian ="'.$idUjian.'"');
                $this->db->order_by("tarikhWujud","desc");
                $query_markah_stres = $this->db->get();
                $stres = $query_markah_stres->row_array(); 
                $markah_stres = $stres['skor'];
                $data['postmarkah2']['idUjian']=$idUjian;
                $data['postmarkah2']['skor1']= $markah_kemurungan;
                $data['postmarkah2']['skor2']= $markah_anzieti;
                $data['postmarkah2']['skor3']= $markah_stres;  
                if(($markah_kemurungan <=10)&&($markah_anzieti <=8)&&($markah_stres <=13)){
                    $data['postmarkah2']['statusUlang']= 0;
                } else {
                    $data['postmarkah2']['statusUlang']= 1;  
                }
                $this->Eminda_model->update_data('ujian', array('idUjian'=>$idUjian), $data['postmarkah2']);
                //insert dlm table senaraiUlang////////////////////////////////////////////////////////////      
                $this->db->select('*');
                $this->db->from('ujian');
                $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
                $this->db->where('idUjian ="'.$idUjian.'"');
                $this->db->order_by("tarikhWujud","desc");
                $query_uji = $this->db->get();
                $uji = $query_uji->row_array(); 
                $statusUlang = $uji['statusUlang'];
                if($statusUlang==1){
                    $data['ujian']['idUjian']=$idUjian; 
                    $data['ujian']['idAmbilan']=$this->session->userdata('idAmbilan'); 
                    $data['ujian']['kodUjian']= $this->session->userdata('kodUjian');    
                    $data['ujian']['mykad']= $mykad;     
                    $data['ujian']['idWujud']=$mykad;
                    $data['ujian']['tarikhWujud']=date('Y-m-d H:i:s');
                    $this->Eminda_model->insert_data('senaraiUlang', $data['ujian'] );  
                }  
                redirect('question/soalan1_tq/'.$mykad.'/'.$idPerkhidmatan.'/'.$idUjian); 
            }      
        }        
        $data['mykad']=$mykad;
        $this->data = $data;
        $this->_render_page($data);
    }//end method   
           
    public function soalan1_tq($mykad,$idPerkhidmatan,$idUjian){ 
        $this->authentication->check();               
        if(!$this->session->userdata('username')) {      
            redirect('general');     
        } else {  
            //dapatkan data prifil dan perkhidmatan///////////////////////
            $this->db->select('a.*, b.nama, c.perihalSkim, d.perihalFasiliti, e.perihalPenempatan ');
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
            $data['idPerkhidmatan']= $detail['idPerkhidmatan'];
            //dapatkan siri/tahun
            $this->db->select('g.*,f.siri, f.tahun ');
            $this->db->from('ujian g');
            $this->db->join('ambilan f','f.idAmbilan=g.idAmbilan');
            $this->db->where('g.mykad',$mykad);
            $this->db->where('g.idPerkhidmatan',$idPerkhidmatan);
            $this->db->where('g.idUjian',$idUjian);
            $queryambil = $this->db->get();
            $ambil = $queryambil->row_array();
            $data['siri']= $ambil['siri'];
            $data['tahun']= $ambil['tahun'];
            //dapatkan data markah///////////////////////
            $this->db->select('*');
            $this->db->from('ujian');
            $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan,'idUjian' => $idUjian));
            //$this->db->where('idUjian',$idUjian);
            $querym = $this->db->get();
            $marks = $querym->row_array(); 
            $data['idUjian']= $idUjian;
            $data['tarikhUjian'] = date('d-m-Y', strtotime($marks['tarikhUjian']));
            //kemurungan
            $data['skor1']= $this->papar_keputusan_depression($marks['skor1']);
            //Anxiety
            $data['skor2']= $this->papar_keputusan_enxiety($marks['skor2']);
            //stress
            $data['skor3']= $this->papar_keputusan_stress($marks['skor3']);
        }
        //$this->data = $data;
        $this->_render_page($data);              
     }//end method
     
     public function soalan1_tq_2($mykad){ 
          $this->authentication->check();               
        if(!$this->session->userdata('username')) {      
                redirect('general');     
        } else {                          
            //dapatkan data prifil dan perkhidmatan///////////////////////
            $this->db->select('a.*, b.nama, c.perihalSkim, d.perihalFasiliti, e.perihalPenempatan ');
            $this->db->from('perkhidmatan a');
            $this->db->join('profil b','b.mykad=a.mykad');
            $this->db->join('_kodSkimPerkhidmatan c','c.IdSkim=a.skim');
            $this->db->join('_kodFasiliti d','d.kodFasiliti=a.lokasiBertugas');
            $this->db->join('_kodPenempatan e','e.kodPenempatan=a.penempatan');
            $this->db->where('a.mykad',$mykad);
            $this->db->order_by("a.tarikhWujud","desc");
            //$this->db->where('a.idPerkhidmatan',$idPerkhidmatan);
            $querydetail = $this->db->get();
            $detail = $querydetail->row_array();
            $data['nama']= $detail['nama'];
            $data['mykad']= $detail['mykad'];
            $data['perihalSkim']= $detail['perihalSkim'];
            $data['gred']= $detail['gred'];
            $data['perihalFasiliti']= $detail['perihalFasiliti'];
            $data['perihalPenempatan']= $detail['perihalPenempatan'];
            $data['idPerkhidmatan']= $detail['idPerkhidmatan'];
            $idPerkhidmatan =$detail['idPerkhidmatan'];
            //dapatkan siri/tahun
            $this->db->select('g.*,f.siri, f.tahun ');
            $this->db->from('ujian g');
            $this->db->join('ambilan f','f.idAmbilan=g.idAmbilan');
            $this->db->where('g.mykad',$mykad);
            $this->db->where('g.idPerkhidmatan',$idPerkhidmatan);
            $this->db->order_by("g.tarikhWujud","desc");
            $queryambil = $this->db->get();
            $ambil = $queryambil->row_array();
            $idUjian = $ambil['idUjian'];
            $data['siri']= $ambil['siri'];
            $data['tahun']= $ambil['tahun'];
            //dapatkan data markah///////////////////////
            $this->db->select('*');
            $this->db->from('ujian');
            $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
            $this->db->where('idUjian ="'.$idUjian.'"');
            $querym = $this->db->get();
            $marks = $querym->row_array(); 
            $data['tarikhUjian'] = date('d-m-Y', strtotime($marks['tarikhUjian']));
            //kemurungan
            $data['skor1']= $this->papar_keputusan_depression($marks['skor1']);
            //Anxiety
            $data['skor2']= $this->papar_keputusan_enxiety($marks['skor2']);
            //stress
            $data['skor3']= $this->papar_keputusan_stress($marks['skor3']);
        }
        //$this->data = $data;
        $this->_render_page($data);              
    }//end method
     
    public function cetak($mykad,$idPerkhidmatan,$idUjian){ 
        $this->authentication->check();		  
        $this->load->library('mpdf');    
        $data['title'] = "KEPUTUSAN UJIAN eMINDA";                 
        //dapatkan siri/tahun
        $this->db->select('g.*,f.siri, f.tahun ');
        $this->db->from('ujian g');
        $this->db->join('ambilan f','f.idAmbilan=g.idAmbilan');
        $this->db->where('g.mykad',$mykad);
        $this->db->where('g.idPerkhidmatan',$idPerkhidmatan);
        //$this->db->where('g.idUjian ="'.$idUjian.'"');
        $this->db->order_by("g.tarikhWujud","desc");
        $queryambil = $this->db->get();
        $ambil = $queryambil->row_array();
        $data['siri']= $ambil['siri'];
        $data['tahun']= $ambil['tahun'];
        //dapatkan data prifil dan perkhidmatan///////////////////////
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
        //dapatkan data markah///////////////////////
        $this->db->select('*');
        $this->db->from('ujian');
        $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
        $this->db->order_by("tarikhWujud","desc");
        //$this->db->where('idUjian ="'.$idUjian.'"');
        $querym = $this->db->get();
        $marks = $querym->row_array(); 
        $data['tarikhUjian'] = date('d-m-Y', strtotime($marks['tarikhUjian']));
        //kemurungan
        $data['skor1']= $this->papar_keputusan_depression($marks['skor1']);
        //Anxiety
        $data['skor2']= $this->papar_keputusan_enxiety($marks['skor2']);
        //stress
        $data['skor3']= $this->papar_keputusan_stress($marks['skor3']);
        
        $html .= $this->load->view($this->controller.'/soalan1_tq_1',$data, true);
        $this->mpdf->AddPage('P');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output('KEPUTUSAN UJIAN eMINDA', 'D');
    }//end method
    
    //kira jenis keputusan markah depression
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
    
    //kira jenis keputusan markah enxiety
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
    
    //kira jenis keputusan markah stress
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