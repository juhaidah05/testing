<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Controller Class bagi proses carian
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (27 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Buang $this->load->helper('html');
 *                      4. Ringkaskan pernyataan if
 *                      5. Buang $this->load->helper('html');
 *                      6. Tambah pernyataan defined('BASEPATH') OR exit('No direct script access allowed');
 *                      7. Buang variable2 yang tidak perlu
 *	(5 Apr 2016)	:	1. Tukar $data['title'] = "Senarai Kod Kumpulan Skim"; kepada $data['title'] = "Senarai Kod Kumpulan Perkhidmatan";
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends MY_Controller {
    public function __construct() {
        parent::__construct();       
        $this->_ci =& get_instance();
        $this->authentication->check();         
        $this->load->model("Eminda_model");
        $this->load->model("Tbl_modul_model");
        $this->load->model("Tbl_submodul1_model");
        $this->load->model("Tbl_jawapan_model");
        $this->load->model("Tbl_kodkategorisoalan_model");
        $this->load->model("Tbl_kodfasiliti_model");
       
        $this->load->model("Tbl_kodjantina_model");

        $this->load->model("Tbl_kodjenisfasiliti_model");        
        $this->load->model("Tbl_kodnegeri_model"); // 1. kod negeri 
        $this->load->model("Tbl_kodpenempatan_model"); // 2. penempatan
        $this->load->model("Tbl_kodujian_model"); // 3. kod ujian
        $this->load->model("Tbl_kodkskim_model"); // 4. klasifikasi skim        
        $this->load->model("Tbl_kodkumpulan_model"); // 5. kumpulan perkhidmatan        
        $this->load->model("Tbl_kodskimperkhidmatan_model"); // 6. skim perkhidmatan
        $this->load->model("Tbl_soalan_model"); // 7. soalan        
        $this->load->model("Tbl_padanansj_model");
        $this->load->model("Tbl_padananfp_model");        
        //$this->load->helper('html');        
    }//end method
    
    //LIST - MAINTENANCES
    function listing(){        
        $data['title'] = 'Senarai Selenggaraan';
        $this->_render_page($data);
    }//end method

    // UNTUK MODUL
    //SENARAI - MODUL
    function senarai_modul(){
        $data['title'] = "Senarai Modul";
        $data['status'] = array(''=>'-- Sila Pilih --', 'Y'=>'Aktif', 'N'=>'Tidak Aktif'); 
        $this->_render_page($data);
    }//end method
        
    //TAMBAH - MODUL
    function modul_tambah(){
        $data['title'] = "Tambah Modul";       
        $data['modul']['ketModul'] = $this->input->post('ketModul');      
        $data['modul']['urlModul'] = $this->input->post('urlModul');        
        $data['modul']['statusAktif'] = $this->input->post('statusAktif');// Dropdown List
        //form validation
        $this->form_validation->set_rules('ketModul','Keterangan Modul','required');
        $this->form_validation->set_rules('urlModul','URL Modul','required');
        $this->form_validation->set_rules('statusAktif','Status Aktif','required');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_modul_model->save($data['modul']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_modul');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method
    
    //PAPAR - MODUL
    function modul_papar(){           
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id'); 
            $modul = $this->Eminda_model->get_info('_modul', array('cdModul'=>$id));            
            echo json_encode($modul);
        }    
    }//end method
      
    //KEMASKINI - MODUL
    function modul_kemaskini(){    
        $id = $this->input->post('cdModul');
        $data['modul']['ketModul'] = $this->input->post('ketModul');     
        $data['modul']['urlModul'] = $this->input->post('urlModul');        
        $data['modul']['statusAktif'] = $this->input->post('statusAktif');// Dropdown List
        //form validation
        $this->form_validation->set_rules('ketModul','Keterangan Modul','required');     
        $this->form_validation->set_rules('urlModul','URL Modul','required');
        $this->form_validation->set_rules('statusAktif','Status Aktif','required');
        if($this->form_validation->run() == true){
            $this->Tbl_modul_model->update($id,$data['modul']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";                
            }else{            
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_modul');
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method    
        
    //HAPUS - MODUL
    function modul_hapus(){
        $id = $this->input->post('id');
        $this->Tbl_modul_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end if
    
    // SENARAI - HASIL CARIAN
    function listJson_modul(){
        $modul = $this->Tbl_modul_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod Modul', 'class'=>'text-center'),array('data'=>'Keterangan Modul', 'class'=>'text-center'),array('data'=>'URL Modul', 'class'=>'text-center'),array('data'=>'Status Aktif', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($modul as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['cdModul']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['cdModul']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['cdModul']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['cdModul'], 'class'=>'text-center'),$val['ketModul'],$val['urlModul'],array('data'=>$val['statusAktif'], 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>"; 
    }//end method

    // UNTUK SUBMODUL
    //SENARAI - SUBMODUL
    function senarai_submodul(){            
        $data['title'] = "Senarai Sub Modul";
        $data['modul_list'] = $this->Eminda_model->get_select_list('_modul', array('key'=>'cdModul', 'val'=>'ketModul', 'orderby'=>'x'),1);
        $data['status'] = array(''=>'-- Sila Pilih --', 'Y'=>'Aktif', 'N'=>'Tidak Aktif'); 
        $this->_render_page($data);
    }//end method
        
    //TAMBAH - SUBMODUL
    function submodul_tambah(){
        $data['title'] = "Tambah Sub Modul";       
        $data['submodul']['ketSubModul1'] = $this->input->post('ketSubModul1');      
        $data['submodul']['urlSubModul1'] = $this->input->post('urlSubModul1');        
        $data['submodul']['cdModul'] = $this->input->post('cdModul');
        $data['submodul']['statusAktif'] = $this->input->post('statusAktif');// Dropdown List
        $this->form_validation->set_rules('ketSubModul1','Keterangan Sub Modul','required');
        $this->form_validation->set_rules('urlSubModul1','URL Sub Modul','required');
        $this->form_validation->set_rules('cdModul','Modul','required');
        $this->form_validation->set_rules('statusAktif','Status Aktif','required');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_submodul1_model->save($data['submodul']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_submodul');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method
        
    //PAPAR - SUBMODUL
    function submodul_papar(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $submodul = $this->Eminda_model->get_info('_subModul1', array('cdSubModul1'=>$id));            
            echo json_encode($submodul);
        }    
    }//end method
      
    //KEMASKINI - SUBMODUL
    function submodul_kemaskini(){    
        $id = $this->input->post('cdSubModul1');
        $data['submodul']['ketSubModul1'] = $this->input->post('ketSubModul1');     
        $data['submodul']['urlSubModul1'] = $this->input->post('urlSubModul1');
        $data['submodul']['cdModul'] = $this->input->post('cdModul');
        $data['submodul']['statusAktif'] = $this->input->post('statusAktif');// Dropdown List        
        //form validation        
        $this->form_validation->set_rules('ketSubModul1','Keterangan Sub Modul','required');     
        $this->form_validation->set_rules('urlSubModul1','URL Sub Modul','required');
        $this->form_validation->set_rules('cdModul','Modul','required');
        $this->form_validation->set_rules('statusAktif','Status Aktif','required');
        if($this->form_validation->run() == true){
            $this->Tbl_submodul1_model->update($id,$data['submodul']);                      
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";                
            } else {            
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_submodul');
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method    
        
    //HAPUS - SUBMODUL
    function submodul_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_submodul1_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
    
    // SENARAI - HASIL CARIAN
    function listJson_submodul(){
        $submodul = $this->Tbl_submodul1_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod Sub Modul', 'class'=>'text-center'),array('data'=>'Keterangan Sub Modul', 'class'=>'text-center'),array('data'=>'URL Sub Modul', 'class'=>'text-center'),array('data'=>'Modul', 'class'=>'text-center'),array('data'=>'Status Aktif', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($submodul as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['cdSubModul1']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['cdSubModul1']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['cdSubModul1']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['cdSubModul1'], 'class'=>'text-center'),$val['ketSubModul1'],$val['urlSubModul1'],$val['ketModul'],array('data'=>$val['statusAktif'], 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method

    // UNTUK JAWAPAN
    //SENARAI - JAWAPAN
    function senarai_jawapan(){
        $data['title'] = "Senarai Jawapan";
        $this->_render_page($data);
    }//end method
    
    //TAMBAH - JAWAPAN
    function jawapan_tambah(){
        $data['title'] = "Tambah Jawapan";
        $data['jawapan']['pilihanJawapan'] = $this->input->post('pilihanJawapan');      
        $data['jawapan']['skor'] = $this->input->post('skor');
        $data['jawapan']['inputType'] = $this->input->post('inputType');
        $this->form_validation->set_rules('pilihanJawapan','Pilihan Jawapan','required');
        $this->form_validation->set_rules('skor','Skor','required|max_length[2]');
        $this->form_validation->set_rules('inputType','Jenis Input','required');        
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_jawapan_model->save($data['jawapan']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_jawapan');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method  
        
    //PAPAR - JAWAPAN
    function jawapan_papar(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $jawapan = $this->Eminda_model->get_info('_jawapan', array('idJawapan'=>$id));
            echo json_encode($jawapan);
        }    
    }//end method
      
    //KEMASKINI - JAWAPAN
    function jawapan_kemaskini(){    
        $id = $this->input->post('idJawapan');
        $data['jawapan']['pilihanJawapan'] = $this->input->post('pilihanJawapan');     
        $data['jawapan']['skor'] = $this->input->post('skor');
        $data['jawapan']['inputType'] = $this->input->post('inputType');        
        //form validation        
        $this->form_validation->set_rules('pilihanJawapan','Pilihan Jawapan','required');     
        $this->form_validation->set_rules('skor','Skor','required|max_length[2]');
        $this->form_validation->set_rules('inputType','Jenis Input','required');
        if($this->form_validation->run() == true){            
            $this->Tbl_jawapan_model->update($id,$data['jawapan']);                      
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";                
            } else {            
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_jawapan');
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method    
        
    //HAPUS - JAWAPAN
    function jawapan_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_jawapan_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method    
    
    // SENARAI - HASIL CARIAN
    function listJson_jawapan(){
        $jawapan = $this->Tbl_jawapan_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'ID Jawapan', 'class'=>'text-center'),array('data'=>'Pilihan Jawapan', 'class'=>'text-center'),array('data'=>'Skor', 'class'=>'text-center'),array('data'=>'Jenis Input', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($jawapan as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['idJawapan']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['idJawapan']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['idJawapan']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['idJawapan'], 'class'=>'text-center'),$val['pilihanJawapan'],array('data'=>$val['skor'], 'class'=>'text-center'),$val['inputType'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method

    // UNTUK KATEGORI SOALAN      
    //SENARAI - KATEGORI SOALAN
    function senarai_kategorisoalan(){
        $data['title'] = "Senarai Kategori Soalan";            
        $data['kodUjian_list'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'perihalUjian', 'orderby'=>'x'),1);
        $this->_render_page($data);
    }//end method
    
    //TAMBAH - KATEGORI SOALAN
    function kategorisoalan_tambah(){
        $data['title'] = "Tambah Kategori Soalan";       
        $data['kategorisoalan']['kategoriSoalan'] = $this->input->post('kategoriSoalan');      
        $data['kategorisoalan']['kodUjian'] = $this->input->post('kodUjian');
        //form validation
        $this->form_validation->set_rules('kategoriSoalan','Kategori Soalan','required');
        $this->form_validation->set_rules('kodUjian','Kod Ujian','required');        
        if($this->form_validation->run() == true) {
            $insert_id = $this->Tbl_kodkategorisoalan_model->save($data['kategorisoalan']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_kategorisoalan');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method
    
    //PAPAR - KATEGORI SOALAN
    function kategorisoalan_papar(){           
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $kategorisoalan = $this->Eminda_model->get_info('_kategoriSoalan', array('idKategoriSoalan'=>$id));
            echo json_encode($kategorisoalan);
        }    
    }//end method
      
    //KEMASKINI - KATEGORI SOALAN
    function kategorisoalan_kemaskini(){    
        $id = $this->input->post('idKategoriSoalan');
        $data['kategorisoalan']['kategoriSoalan'] = $this->input->post('kategoriSoalan');     
        $data['kategorisoalan']['kodUjian'] = $this->input->post('kodUjian');
        //form validation
        $this->form_validation->set_rules('kategoriSoalan','Kategori Soalan','kategoriSoalan');     
        $this->form_validation->set_rules('kodUjian','Kod Ujian','kodUjian');
        if($this->form_validation->run() == true){
            $this->Tbl_kodkategorisoalan_model->update($id,$data['kategorisoalan']);
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";
            } else {
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_kategorisoalan');
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method    
        
    //HAPUS - KATEGORI SOALAN
    function kategorisoalan_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_kodkategorisoalan_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method    
    
    // SENARAI - HASIL CARIAN
    function listJson_kategorisoalan(){     
        $kategorisoalan = $this->Tbl_kodkategorisoalan_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'ID Kategori Soalan', 'class'=>'text-center'),array('data'=>'Kategori Soalan', 'class'=>'text-center'),array('data'=>'Kod Ujian', 'class'=>'text-center'),array('data'=>'Perihal Ujian', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($kategorisoalan as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['idKategoriSoalan']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['idKategoriSoalan']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['idKategoriSoalan']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['idKategoriSoalan'], 'class'=>'text-center'),$val['kategoriSoalan'],array('data'=>$val['kodUjian'], 'class'=>'text-center'),$val['perihalUjian'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
    
    // UNTUK KOD FASILITI
    //SENARAI - JAWAPAN
    function senarai_kodfasiliti(){
        $data['title'] = "Senarai Kod Fasiliti";
        $data['kodJenisFasiliti_list'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
        $this->_render_page($data);
    }//end method
    
    //TAMBAH - KOD FASILITI
    function kodfasiliti_tambah(){
        $data['title'] = "Tambah Kod Fasiliti";
        $data['kodfasiliti']['kodFasiliti'] = $this->input->post('kodFasiliti');
        $data['kodfasiliti']['perihalFasiliti'] = $this->input->post('perihalFasiliti');      
        $data['kodfasiliti']['kodJenisFasiliti'] = $this->input->post('kodJenisFasiliti');
        $data['kodfasiliti']['lokalitiPentadbir'] = $this->input->post('lokalitiPentadbir');        
        //form validation        
        $this->form_validation->set_rules('kodFasiliti','Kod Fasiliti','required|max_length[15]');
        $this->form_validation->set_rules('perihalFasiliti','Perihal Fasiliti','required');
        $this->form_validation->set_rules('kodJenisFasiliti','Jenis Fasiliti','required');
        $this->form_validation->set_rules('lokalitiPentadbir','Lokaliti Pentadbir','required|max_length[15]');        
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_kodfasiliti_model->save($data['kodfasiliti']);
            if($insert_id){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_kodfasiliti');
                }//end if
            } else { 
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method    
    
    //PAPAR - KOD FASILITI
    function kodfasiliti_papar(){           
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $kodfasiliti = $this->Eminda_model->get_info('_kodFasiliti', array('kodFasiliti'=>$id));
            echo json_encode($kodfasiliti);
        }    
    }//end method
      
    //KEMASKINI - KOD FASILITI
    function kodfasiliti_kemaskini(){    
        $id = $this->input->post('kodFasiliti');
        $data['kodfasiliti']['perihalFasiliti'] = $this->input->post('perihalFasiliti');     
        $data['kodfasiliti']['kodJenisFasiliti'] = $this->input->post('kodJenisFasiliti');
        $data['kodfasiliti']['lokalitiPentadbir'] = $this->input->post('lokalitiPentadbir');        
        //form validation        
        $this->form_validation->set_rules('perihalFasiliti','Perihal Fasiliti','required');
        $this->form_validation->set_rules('kodJenisFasiliti','Jenis Fasiliti','required');
        $this->form_validation->set_rules('lokalitiPentadbir','Lokaliti Pentadbir','required|max_length[15]');
        if($this->form_validation->run() == true){            
            $this->Tbl_kodfasiliti_model->update($id,$data['kodfasiliti']);                      
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";                
            }else{            
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_kodfasiliti');
            }//end if
        }else{
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
        
     //HAPUS - KOD FASILITI
    function kodfasiliti_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_kodfasiliti_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
    
    // SENARAI - HASIL CARIAN
    function listJson_kodfasiliti(){
        $kodfasiliti = $this->Tbl_kodfasiliti_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod Fasiliti', 'class'=>'text-center'),array('data'=>'Perihal Fasiliti', 'class'=>'text-center'),array('data'=>'Jenis Fasiliti', 'class'=>'text-center'),array('data'=>'Lokaliti Pentadbir', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($kodfasiliti as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['kodFasiliti']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['kodFasiliti']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['kodFasiliti']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodFasiliti'], 'class'=>'text-center'),$val['perihalFasiliti'],array('data'=>$val['perihalJenisFasiliti'], 'class'=>'text-center'),array('data'=>$val['lokalitiPentadbir'], 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end mtehod    
    
	
	
	
	
    // UNTUK KOD JANTINA
     //LIST - KOD JANTINA
    function senarai_kodjantina(){
        $data['title'] = "Senarai Kod Jantina";
        $this->authentication->check();
        $this->_render_page($data);
    }//end method    
        
    // ADD - KOD JANTINA
    function kodjantina_add(){
        $data['title'] = "Tambah kodjantina";
        // untuk table tbl_profile
        $data['_kodJantina']['kodJantina'] = $this->input->post('kodJantina');
        $data['_kodJantina']['perihalJantina'] = $this->input->post('perihalJantina');
        //form validation
        $this->form_validation->set_rules('kodJantina','Code','required|max_length[3]');
        $this->form_validation->set_rules('perihalJantina','Description','required');
        if($this->form_validation->run() == true){      
            $insert_id = $this->Tbl_kodjantina_model->save($data['_kodJantina']);
            if($insert_id) {
                if($this->input->is_ajax_request()){
                   echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_kodjantina');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if              
        } else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //VIEW - kodjantina
    function kodjantina_view(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $_kodJantina = $this->Eminda_model->get_info('_kodJantina', array('kodJantina'=>$id));
            echo json_encode($_kodJantina);
        }       
    }//end method
    
    //UPDATE - KOD JANTINA
    function kodjantina_update(){
        $id = $this->input->post('kodJantina');
        $data['_kodJantina']['perihalJantina'] = $this->input->post('perihalJantina');
        $this->form_validation->set_rules('perihalJantina','Description','required');
        if($this->form_validation->run() == true){
            $this->Tbl_kodjantina_model->update($id,$data['_kodJantina']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_kodjantina');
            }//end if
        }else{
            echo "Rekod Tidak Di Kemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //DELETE  - KOD JANTINA
    function kodjantina_delete(){
        $id = $this->input->post('id');
        $this->Tbl_kodjantina_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method

    // LIST -  OUPUT FROM SEARCHING
    function listJson_kodjantina(){
        $_kodJantina = $this->Tbl_kodjantina_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod', 'class'=>'text-center'),array('data'=>'Keterangan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($_kodJantina as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar kod' attr='".$val['kodJantina']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini kod' attr='".$val['kodJantina']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus kod' id='delete' attr='".$val['kodJantina']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array (array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodJantina'], 'class'=>'text-center'),$val['perihalJantina'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end method
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod setiap muka surat"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
    
	
	
	

    // UNTUK KOD JENIS FASILITI
    //SENARAI - KOD JENIS FASILITI
    function senarai_kodjenisfasiliti(){
        $data['title'] = "Senarai Kod Jenis Fasiliti";
        $this->_render_page($data);
    }//end method
        
    //TAMBAH - KOD JENIS FASILITI
    function kodjenisfasiliti_tambah(){
        $data['title'] = "Tambah Kod Jenis Fasiliti"; 
        $data['kodjenisfasiliti']['perihalJenisFasiliti'] = $this->input->post('perihalJenisFasiliti');        
        //form validation
        $this->form_validation->set_rules('perihalJenisFasiliti','Perihal Kod Jenis Fasiliti','required');        
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_kodjenisfasiliti_model->save($data['kodjenisfasiliti']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_kodjenisfasiliti');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
        
    //PAPAR - KOD JENIS FASILITI
    function kodjenisfasiliti_papar(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $kodjenisfasiliti = $this->Eminda_model->get_info('_kodJenisFasiliti', array('kodJenisFasiliti'=>$id));
            echo json_encode($kodjenisfasiliti);
        }    
    }//end method
      
    //KEMASKINI - KOD JENIS FASILITI
    function kodjenisfasiliti_kemaskini(){
        $id = $this->input->post('kodJenisFasiliti');
        $data['kodjenisfasiliti']['perihalJenisFasiliti'] = $this->input->post('perihalJenisFasiliti');        
        //form validation
        $this->form_validation->set_rules('perihalJenisFasiliti','Perihal Kod Jenis Fasiliti','required');
        if($this->form_validation->run() == true){
           $this->Tbl_kodjenisfasiliti_model->update($id,$data['kodjenisfasiliti']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_kodjenisfasiliti');
            }//end if
        } else{
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
        
    //HAPUS - KOD JENIS FASILITI
    function kodjenisfasiliti_hapus(){
        $id = $this->input->post('id');
        $this->Tbl_kodjenisfasiliti_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
    
    // SENARAI - HASIL CARIAN
    function listJson_kodjenisfasiliti(){
        $kodjenisfasiliti = $this->Tbl_kodjenisfasiliti_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod Jenis Fasiliti', 'class'=>'text-center'),array('data'=>'Perihal Jenis Fasiliti', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($kodjenisfasiliti as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['kodJenisFasiliti']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['kodJenisFasiliti']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['kodJenisFasiliti']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodJenisFasiliti'], 'class'=>'text-center'),$val['perihalJenisFasiliti'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method

    
	  // KOD NEGERI
	 //SENARAI - KOD NEGERI
    function negeri_listing(){
        $data['title'] = "Senarai Kod Negeri";
        $this->authentication->check();
        $this->_render_page($data);
    }//end method    
        
    // ADD - KOD NEGERI
    function kodNegeri_add(){
        $data['title'] = "Tambah kodnegeri";
        // untuk table tbl_profile
        $data['_kodNegeri']['kodNegeri'] = $this->input->post('kodNegeri');
        $data['_kodNegeri']['perihalNegeri'] = $this->input->post('perihalNegeri');
        //form validation
        $this->form_validation->set_rules('kodNegeri','Code','required|max_length[3]');
        $this->form_validation->set_rules('perihalNegeri','Description','required');
        if($this->form_validation->run() == true){      
            $insert_id = $this->Tbl_kodnegeri_model->save($data['_kodNegeri']);
            if($insert_id) {
                if($this->input->is_ajax_request()){
                   echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/negeri_listing');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if              
        } else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //VIEW - kodnegeri
    function kodNegeriview(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $_kodNegeri = $this->Eminda_model->get_info('_kodNegeri', array('kodNegeri'=>$id));
            echo json_encode($_kodNegeri);
        }       
    }//end method
    
    //UPDATE - KOD NEGERI
    function kodNegeri_update(){
        $id = $this->input->post('kodNegeri');
        $data['_kodNegeri']['perihalNegeri'] = $this->input->post('perihalNegeri');
        $this->form_validation->set_rules('perihalNegeri','Description','required');
        if($this->form_validation->run() == true){
            $this->Tbl_kodnegeri_model->update($id,$data['_kodNegeri']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/negeri_listing');
            }//end if
        }else{
            echo "Rekod Tidak Di Kemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //DELETE  - KOD NEGERI
    function kodNegeri_delete(){
        $id = $this->input->post('id');
        $this->Tbl_kodnegeri_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method

    // LIST -  OUPUT FROM SEARCHING
    function listJson_kodNegeri(){
        $_kodNegeri = $this->Tbl_kodnegeri_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod', 'class'=>'text-center'),array('data'=>'Keterangan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($_kodNegeri as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar kod' attr='".$val['kodNegeri']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini kod' attr='".$val['kodNegeri']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus kod' id='delete' attr='".$val['kodNegeri']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array (array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodNegeri'], 'class'=>'text-center'),$val['perihalNegeri'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end method
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod setiap muka surat"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method

	
	
    
    // FOR MAINTENANCES - 2. PENEMPATAN
    //LIST - PENEMPATAN
    function penempatan_listing(){
        $data['title'] = "Senarai Penempatan";
        $this->authentication->check();
        $this->_render_page($data);
    }//end method    
        
    //ADD - PENEMPATAN
    //TAMBAH - JAWAPAN
    function tempat_add(){
        $data['title'] = "Tambah Penempatan";       
        $data['penempatan']['perihalPenempatan'] = $this->input->post('perihalPenempatan');      
        //form validation
        $this->form_validation->set_rules('perihalPenempatan','Perihal Penempatan','required');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_kodpenempatan_model->save($data['penempatan']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/penempatan_listing');
                }//end if
            }else{
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
    
    //VIEW - PENEMPATAN
    function tempat_view(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $listkodPenempatan = $this->Eminda_model->get_info('_kodPenempatan', array('kodPenempatan'=>$id));
            echo json_encode($listkodPenempatan);
        }       
    }//end method
    
    //UPDATE - PENEMPATAN
    function tempat_update(){
        $id = $this->input->post('kodPenempatan');
        $data['penempatan']['perihalPenempatan'] = $this->input->post('perihalPenempatan');      
        $this->form_validation->set_rules('perihalPenempatan','Description','required');
        if($this->form_validation->run() == true){
            $this->Tbl_kodpenempatan_model->update($id,$data['penempatan']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/penempatan_listing');
            }//end if
        }else{
            echo "Rekod Tidak Di Kemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
    
    //DELETE  - PENEMPATAN
    function tempat_delete(){
        $id = $this->input->post('id');
        $this->Tbl_kodpenempatan_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
           
    // LIST -  OUPUT FROM SEARCHING
    function listJson_tempat(){
        $senaraiTempat = $this->Tbl_kodpenempatan_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod', 'class'=>'text-center'),array('data'=>'Keterangan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($senaraiTempat as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Kod' attr='".$val['kodPenempatan']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Kod' attr='".$val['kodPenempatan']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Kod' id='delete' attr='".$val['kodPenempatan']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodPenempatan'], 'class'=>'text-center'),$val['perihalPenempatan'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod setiap muka surat"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>"; 
    }//end method
    
    // UNTUK 3.KOD UJIAN
    //SENARAI - KOD UJIAN
    function senarai_kujian(){
        $data['title'] = "Senarai Kod Ujian";
        $this->_render_page($data);
    }//end method            
        
    //TAMBAH - KOD UJIAN
    function kujian_tambah(){
        $data['title'] = "Tambah Kod Ujian";       
        $data['_kodUjian']['kodUjian'] = $this->input->post('kodUjian');
        $data['_kodUjian']['perihalUjian'] = $this->input->post('perihalUjian');      
        $data['_kodUjian']['keterangan1'] = $this->input->post('keterangan1');        
        $data['_kodUjian']['keterangan2'] = $this->input->post('keterangan2');// Dropdown List
        //form validation
        $this->form_validation->set_rules('kodUjian','Kod Ujian','required|max_length[5]');
        $this->form_validation->set_rules('perihalUjian','Perihal Ujian','required');
        $this->form_validation->set_rules('keterangan1','keterangan 1','required');
        $this->form_validation->set_rules('keterangan1','keterangan 2','required');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_kodujian_model->save($data['_kodUjian']);
            if($insert_id =='true') {
                if($this->input->is_ajax_request()){
                   echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_kujian');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if              
        } else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //PAPAR - KOD UJIAN
    function kujian_papar(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id'); 
            $kujian = $this->Eminda_model->get_info('_kodUjian', array('kodUjian'=>$id));            
            echo json_encode($kujian);
        }    
    }//end method
      
    //KEMASKINI - KOD UJIAN
    function kujian_kemaskini(){    
        $id = $this->input->post('kodUjian');
        $data['kujian']['perihalUjian'] = $this->input->post('perihalUjian');     
        $data['kujian']['keterangan1'] = $this->input->post('keterangan1');        
        $data['kujian']['keterangan2'] = $this->input->post('keterangan2');// Dropdown List
        //form validation
        $this->form_validation->set_rules('perihalUjian','Keterangan Kod Ujian','required');     
        $this->form_validation->set_rules('keterangan1','Keterangan 1','required');
        $this->form_validation->set_rules('keterangan2','keterangan 2','required');
        if($this->form_validation->run() == true){
            $this->Tbl_kodujian_model->update($id,$data['kujian']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";                
            }else{            
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_kujian');
            }//end if
        }else{
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
            
    //HAPUS - KOD UJIAN
    function kujian_hapus(){
        $id = $this->input->post('id');
        $this->Tbl_kodujian_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
     
    // SENARAI - HASIL CARIAN
    function listJson_kujian(){
        $kujian = $this->Tbl_kodujian_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod', 'class'=>'text-center'),array('data'=>'Keterangan Kod Ujian', 'class'=>'text-center'),array('data'=>'Keterangan 1', 'class'=>'text-center'),array('data'=>'Keterangan 2', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($kujian as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Kod' attr='".$val['kodUjian']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Kod' attr='".$val['kodUjian']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus MoKod' id='delete' attr='".$val['kodUjian']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodUjian'], 'class'=>'text-center'),$val['perihalUjian'],$val['keterangan1'],$val['keterangan2'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
          
    
    // FOR MAINTENANCES - 4. KOD KLASIFIKASI SKIM
    //LIST - KOD KLASIFIKASI SKIM
    function kodkskim_listing(){
        $data['title'] = "Senarai Kod Klasifikasi Skim";
        $this->authentication->check();
        $this->_render_page($data);
    }//end method    
        
    // ADD - KOD KLASIFIKASI SKIM
    function kodkskim_add(){
        $data['title'] = "Tambah kodkskim";
        // untuk table tbl_profile
        $data['_kodKlasifikasiSkim']['kodKlasifikasiSkim'] = $this->input->post('kodKlasifikasiSkim');
        $data['_kodKlasifikasiSkim']['perihalKlasifikasiSkim'] = $this->input->post('perihalKlasifikasiSkim');
        //form validation
        $this->form_validation->set_rules('kodKlasifikasiSkim','Code','required|max_length[3]');
        $this->form_validation->set_rules('perihalKlasifikasiSkim','Description','required');
        if($this->form_validation->run() == true){      
            $insert_id = $this->Tbl_kodkskim_model->save($data['_kodKlasifikasiSkim']);
            if($insert_id) {
                if($this->input->is_ajax_request()){
                   echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/kodkskim_listing');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if              
        } else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //VIEW - kodkskim
    function kodkskim_view(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $_kodKlasifikasiSkim = $this->Eminda_model->get_info('_kodKlasifikasiSkim', array('kodKlasifikasiSkim'=>$id));
            echo json_encode($_kodKlasifikasiSkim);
        }       
    }//end method
    
    //UPDATE - KOD KLASIFIKASI SKIM
    function kodkskim_update(){
        $id = $this->input->post('kodKlasifikasiSkim');
        $data['_kodKlasifikasiSkim']['perihalKlasifikasiSkim'] = $this->input->post('perihalKlasifikasiSkim');
        $this->form_validation->set_rules('perihalKlasifikasiSkim','Description','required');
        if($this->form_validation->run() == true){
            $this->Tbl_kodkskim_model->update($id,$data['_kodKlasifikasiSkim']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/kodkskim_listing');
            }//end if
        }else{
            echo "Rekod Tidak Di Kemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
    
    //DELETE  - KOD KLASIFIKASI SKIM
    function kodkskim_delete(){
        $id = $this->input->post('id');
        $this->Tbl_kodkskim_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method

    // LIST -  OUPUT FROM SEARCHING
    function listJson_kodkskim(){
        $_kodKlasifikasiSkim = $this->Tbl_kodkskim_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod', 'class'=>'text-center'),array('data'=>'Keterangan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
        $bil = 1;
        foreach ($_kodKlasifikasiSkim as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar kod' attr='".$val['kodKlasifikasiSkim']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini kod' attr='".$val['kodKlasifikasiSkim']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus kod' id='delete' attr='".$val['kodKlasifikasiSkim']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array (array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodKlasifikasiSkim'], 'class'=>'text-center'),$val['perihalKlasifikasiSkim'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end method
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod setiap muka surat"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
     
    // FOR MAINTENANCES - 5.KOD KUMPULAN Perkhidmatan
    //LIST - KOD KUMPULAN Perkhidmatan
    function kodkumpulan_listing(){
        $data['title'] = "Senarai Kod Kumpulan Perkhidmatan";
        $this->authentication->check();
        $this->_render_page($data);
    }//end method
    
    //VIEW - KOD KUMPULAN SKIM
    function kodkumpulan_view(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $listkod = $this->Eminda_model->get_info('_kodKumpulanPerkhidmatan', array('kodKumpulan'=>$id));
            echo json_encode($listkod);
        }       
    }//end method    
    
    //TAMBAH - 5. kod kumulan skim
    function kodkumpulan_add(){
        $data['title'] = "Tambah Kod Kumpulan";       
        $data['modul']['kodKumpulan'] = $this->input->post('kodKumpulan');      
        $data['modul']['perihalKumpulan'] = $this->input->post('perihalKumpulan');        
        //form validation
        $this->form_validation->set_rules('kodKumpulan','kodKumpulan','required');
        $this->form_validation->set_rules('perihalKumpulan','Keterangan','required');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_kodkumpulan_model->save($data['modul']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/kodkumpulan_listing');
                }//end if
            }else{
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        }else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
    
    //UPDATE - KOD KUMPULAN SKIM
    function kodkumpulan_update(){
        $id = $this->input->post('kodKumpulan');       
        $data['kodkumpulan']['perihalKumpulan'] = $this->input->post('perihalKumpulan');      
        $this->form_validation->set_rules('perihalKumpulan','Description','required');        
        if($this->form_validation->run() == true){            
            $this->Tbl_kodkumpulan_model->update($id,$data['kodkumpulan']);                      
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/kodkumpulan_listing');
            }//end if
        }else{
            echo "Rekod Tidak Di Kemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
    
    //DELETE  - KOD KUMPULAN SKIM
    function kodkumpulan_delete(){
        $id = $this->input->post('id');
        $this->Tbl_kodkumpulan_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
    
    // LIST -  OUPUT FROM SEARCHING
    function listJson_kodkumpulan(){
        $senaraikodkskim = $this->Tbl_kodkumpulan_model->findAll();
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading3
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod', 'class'=>'text-center'),array('data'=>'Keterangan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data
		$bil = 1;
        foreach ($senaraikodkskim as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Kod' attr='".$val['kodKumpulan']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Kod' attr='".$val['kodKumpulan']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Kod' id='delete' attr='".$val['kodKumpulan']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['kodKumpulan'], 'class'=>'text-center'),$val['perihalKumpulan'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate(); 
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod setiap muka surat"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
    
    //SENARAI - 6.KOD SKIM PERKHIDMATAN
    //SENARAI - KOD SKIM PERKHIDMATAN
    function senarai_kodsp(){
        $data['title'] = "Senarai Skim Perkhidmatan";
        $data['kodsp_list'] = $this->Eminda_model->get_select_list('_kodSkimPerkhidmatan', array('key'=>'IdSkim', 'val'=>'perihalSkim', 'orderby'=>'x'),1);
        $data['kod_KlasifikasiSkim_list'] = $this->Eminda_model->get_select_list('_kodKlasifikasiSkim', array('key'=>'kodKlasifikasiSkim', 'val'=>'perihalKlasifikasiSkim', 'orderby'=>'x'),1);            
        $data['kodkumpulanPerkhidmatan_list'] = $this->Eminda_model->get_select_list('_kodKumpulanPerkhidmatan', array('key'=>'kodKumpulan', 'val'=>'perihalKumpulan', 'orderby'=>'x'),1);
        $this->_render_page($data);
    }//end method            
        
    //TAMBAH - KOD SKIM PERKHIDMATAN
    function kodsp_tambah(){
        $data['title'] = "Tambah Kod Fasiliti";       
        $data['kodsp']['perihalSkim'] = $this->input->post('perihalSkim');      
        $data['kodsp']['kodKlasifikasiSkim'] = $this->input->post('kodKlasifikasiSkim');
        $data['kodsp']['kumpPerkhidmatan'] = $this->input->post('kodKumpulan');
        $this->form_validation->set_rules('perihalSkim','Perihal Skim','required');
        $this->form_validation->set_rules('kodKlasifikasiSkim','Jenis Klasifikasi Skim','required');
        $this->form_validation->set_rules('kodKumpulan','Kumpulan Perkhidmatan');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_kodskimperkhidmatan_model->save($data['kodsp']);
            if($insert_id){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_kodsp');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
        
    //PAPAR - KOD SKIM PERKHIDMATAN
    function kodsp_papar(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $kod_skim = $this->Eminda_model->get_info('_kodSkimPerkhidmatan', array('IdSkim'=>$id));
            echo json_encode($kod_skim);
        }    
    }//end method
      
    //KEMASKINI - KOD SKIM PERKHIDMATAN
    function kodsp_kemaskini(){    
        $id = $this->input->post('IdSkim');
        $data['kodsp']['perihalSkim'] = $this->input->post('perihalSkim');     
        $data['kodsp']['kodKlasifikasiSkim'] = $this->input->post('kodKlasifikasiSkim');
        $data['kodsp']['kumpPerkhidmatan'] = $this->input->post('kumpPerkhidmatan');        
        $data['kodsp']['kumpPerkhidmatan'] = $this->input->post('kumpPerkhidmatan');        
        $data['kod_KlasifikasiSkim_list'] = $this->Eminda_model->get_select_list('_kodKlasifikasiSkim', array('key'=>'kodKlasifikasiSkim', 'val'=>'perihalKlasifikasiSkim', 'orderby'=>'x'),1);
        $data['kodkumpulanPerkhidmatan_list'] = $this->Eminda_model->get_select_list('_kodKumpulanPerkhidmatan', array('key'=>'kodKumpulan', 'val'=>'perihalKumpulan', 'orderby'=>'x'),1);
        //form validation
        $this->form_validation->set_rules('perihalSkim',' perihalSkim','required');
        $this->form_validation->set_rules('kodKlasifikasiSkim','Jenis Fasiliti','required');
        $this->form_validation->set_rules('kumpPerkhidmatan','kumpPerkhidmatan','required|max_length[4]');
        if($this->form_validation->run() == true){
            $this->Tbl_kodskimperkhidmatan_model->update($id,$data['kodsp']);                      
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";                
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_kodsp');
            }//end if
        }else{
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method    
        
    //HAPUS - KOD SKIM PERKHIDMATAN
    function kodsp_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_kodskimperkhidmatan_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method                 
    
    // SENARAI - HASIL CARIAN
    function listJson_kodsp(){
        $IdSkim = $this->Tbl_kodskimperkhidmatan_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod Id Skim', 'class'=>'text-center'),array('data'=>'Perihal Skim','class'=>'text-center'),array('data'=>'Kod Klasifikasi Skim', 'class'=>'text-center'),array('data'=>'Kumpulan Perkhidmatan','class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data       
        $bil = 1;
        foreach ($IdSkim as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar' attr='".$val['IdSkim']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini' attr='".$val['IdSkim']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus' id='delete' attr='".$val['IdSkim']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['IdSkim'], 'class'=>'text-center'),$val['perihalSkim'],array('data'=>$val['kodKlasifikasiSkim'], 'class'=>'text-center'),array('data'=>$val['kumpPerkhidmatan'], 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
        
    // UNTUK PADANAN SJ
    //SENARAI - PADANAN SJ
    function senarai_padanansj(){
        $data['title'] = "Senarai Padanan Soalan Jawapan";
        $data['soalan_list'] = $this->Eminda_model->get_select_list('_soalan', array('key'=>'idSoalan', 'val'=>'soalan', 'orderby'=>'x'),1);
        $data['jawapan_list'] = $this->Eminda_model->get_select_list('_jawapan', array('key'=>'idJawapan', 'val'=>'pilihanJawapan', 'orderby'=>'x'),1);
        $this->_render_page($data);
    }//end method
    
    //TAMBAH - PADANAN SJ
    function padanansj_tambah(){
        $data['title'] = "Tambah Padanan Soalan Jawapan";       
        $data['padanansj']['idSoalan'] = $this->input->post('idSoalan');
        $data['padanansj']['idJawapan'] = $this->input->post('idJawapan');
        //form validation
        $this->form_validation->set_rules('idSoalan','Soalan','required');
        $this->form_validation->set_rules('idJawapan','Jawapan','required');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_padanansj_model->save($data['padanansj']);
            if($insert_id > '0'){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_padanansj');
                }//end if
            } else{
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method
    
    //PAPAR - PADANAN SJ
    function padanansj_papar(){
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $padanansj = $this->Eminda_model->get_info('_padananSJ', array('idSJ'=>$id));
            echo json_encode($padanansj);
        }    
    }//end method      
      
    //KEMASKINI - PADANAN SJ
    function padanansj_kemaskini(){
        $id = $this->input->post('idSJ');
        $data['padanansj']['idSoalan'] = $this->input->post('idSoalan');
        $data['padanansj']['idJawapan'] = $this->input->post('idJawapan');
        //form validation
        $this->form_validation->set_rules('idSoalan','ID Soalan','required');
        $this->form_validation->set_rules('idJawapan','id Jawapan','required');
        if($this->form_validation->run() == true){
            $this->Tbl_padanansj_model->update($id,$data['padanansj']);
            if($this->input->is_ajax_request()){
                echo "Rekod Berjaya Dikemaskini!";
            }else{
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_padanansj');
            }//end if
        }else{
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method    
        
     //HAPUS - KOD JENIS FASILITI
    function padanansj_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_padanansj_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
    
    // SENARAI - HASIL CARIAN
    function listJson_padanansj(){
        $padanansj = $this->Tbl_padanansj_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'ID Soalan Jawapan', 'class'=>'text-center'),array('data'=>'ID Soalan', 'class'=>'text-center'),array('data'=>'Soalan', 'class'=>'text-center'),array('data'=>'ID Jawapan', 'class'=>'text-center'),array('data'=>'Jawapan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));
        //set table data       
        $bil = 1;
        foreach ($padanansj as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['idSJ']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['idSJ']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['idSJ']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['idSJ'], 'class'=>'text-center'),array('data'=>$val['idSoalan'], 'class'=>'text-center'),$val['soalan'],array('data'=>$val['idJawapan'], 'class'=>'text-center'),$val['pilihanJawapan'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
    
    //SENARAI - 7.SOALAN
    //SENARAI - KOD SKIM PERKHIDMATAN
    function senarai_soalan(){
        $data['title'] = "Senarai Soalan";
        $data['kategoriSoalan_list'] = $this->Eminda_model->get_select_list('_kategoriSoalan', array('key'=>'idKategoriSoalan', 'val'=>'kategoriSoalan', 'orderby'=>'x'),1);
        $data['kodUjian_list'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'perihalUjian', 'orderby'=>'x'),1);            
        $this->_render_page($data);
    }//end method            
        
    //TAMBAH - SOALAN
    function soalan_tambah(){
        $data['title'] = "Tambah Soalan";
        $data['soalan']['soalan'] = $this->input->post('soalan');      
        $data['soalan']['idKategoriSoalan'] = $this->input->post('idKategoriSoalan');
        $data['soalan']['kodUjian'] = $this->input->post('kodUjian');
        //form validation
        $this->form_validation->set_rules('soalan','Perihal Skim','required');
        $this->form_validation->set_rules('idKategoriSoalan','Jenis Kategori Soalan','required');
        $this->form_validation->set_rules('kodUjian','kodUjian');
        if($this->form_validation->run() == true){
            $insert_id = $this->Tbl_soalan_model->save($data['soalan']);
            if($insert_id){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                } else {
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_soalan');
                }//end if
            } else {
                echo "Kod Rekod Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){$this->_render_page($data);}
    }//end method        
        
    //PAPAR - KOD SOALAN
    function soalan_papar(){           
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id'); 
            $senarai_soalan = $this->Eminda_model->get_info('_soalan', array('idSoalan'=>$id));            
            echo json_encode($senarai_soalan);
        }    
    }//end method          
      
    //KEMASKINI - KOD SOALAN
    function soalan_kemaskini(){    
        $id = $this->input->post('idSoalan');
        $data['soalan']['soalan'] = $this->input->post('soalan');     
        $data['soalan']['idKategoriSoalan'] = $this->input->post('idKategoriSoalan');
        $data['soalan']['kodUjian'] = $this->input->post('kodUjian');
        //form validation        
        $this->form_validation->set_rules('soalan','Perihal Skim','required');
        $this->form_validation->set_rules('idKategoriSoalan','Jenis Kategori Soalan','required');
        $this->form_validation->set_rules('kodUjian','kodUjian','required');
        if($this->form_validation->run() == true){            
            $this->Tbl_soalan_model->update($id,$data['soalan']);                      
            if($this->input->is_ajax_request()){                
                echo "Rekod Berjaya Dikemaskini!";                
            } else {            
                flashMsg('Rekod Berjaya Dikemaskini!','success');
                redirect('maintenance/senarai_soalan');
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data);}
    }//end method    
        
    //HAPUS - SOALAN
    function soalan_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_soalan_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
                 
    // SENARAI - HASIL CARIAN
    function listJson_soalan(){
        $senarai_soalan = $this->Tbl_soalan_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'Kod Id Soalan', 'class'=>'text-center'),array('data'=>'Soalan','class'=>'text-center'),array('data'=>'Id Kategori Soalan', 'class'=>'text-center'),array('data'=>'Kod Ujian','class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));                       
        //set table data       
        $bil = 1;
        foreach ($senarai_soalan as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar' attr='".$val['idSoalan']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini' attr='".$val['idSoalan']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus' id='delete' attr='".$val['idSoalan']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['idSoalan'], 'class'=>'text-center'),$val['soalan'],array('data'=>$val['kategoriSoalan'], 'class'=>'text-center'),array('data'=>$val['kodUjian'], 'class'=>'text-center'),array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }//end foreach
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method
    
    // UNTUK PADANAN FP  
    //SENARAI - PADANAN SJ
    function senarai_padananfp(){
        $data['title'] = "Senarai Padanan Fasiliti Penempatan";
        $data['jenisFasiliti_list'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
        $data['fasiliti_list'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1);
        $data['penempatan_list'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);
        $this->_render_page($data);
    }//end method
        
    //TAMBAH - PADANAN SJ
    function padananfp_tambah(){
        $data['title'] = "Tambah Padanan Fasiliti Penempatan";
        $data['padananfp']['fasiliti'] = $this->input->post('fasiliti');
        $data['padananfp']['penempatan'] = $this->input->post('penempatan');
        //form validation
        $this->form_validation->set_rules('fasiliti','Fasiliti','required');
        $this->form_validation->set_rules('penempatan','Penempatan','required');        
        if($this->form_validation->run() == true) {
            $insert_id = $this->Tbl_padananfp_model->save($data['padananfp']);
            if($insert_id){
                if($this->input->is_ajax_request()){
                    echo "Rekod Berjaya Disimpan!";
                }else{
                    flashMsg('Rekod Berjaya Disimpan!','success');
                    redirect('maintenance/senarai_padanansj');
                }//end if
            }else{
                echo "Padanan Sudah Wujud!";
            }//end if
        } else{
            echo "Rekod Tidak Berjaya Disimpan!";
        }//end if        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method
    
    //PAPAR - PADANAN SJ
    function padananfp_papar(){           
        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id'); 
            $padananfp = $this->Eminda_model->get_jenisFasiliti($id);
            
            echo json_encode($padananfp);
        }    
    }//end method
      
    //KEMASKINI - PADANAN SJ
    function padananfp_kemaskini(){    
        $id = $this->input->post('idFP');
        $data['padananfp']['fasiliti'] = $this->input->post('fasiliti');
        $data['padananfp']['penempatan'] = $this->input->post('penempatan');        
        //form validation        
        $this->form_validation->set_rules('fasiliti','Fasiliti','required');
        $this->form_validation->set_rules('penempatan','Penempatan','required');
        if($this->form_validation->run() == true){            
            $update_id = $this->Tbl_padananfp_model->update($id,$data['padananfp']);                      
            if($update_id) {
               if($this->input->is_ajax_request()) {                   
                   echo "Rekod Berjaya Dikemaskini!";                                      
               }else {                   
                   flashMsg('Rekod Berjaya Dikemaskini!','success');
                   redirect('maintenance/senarai_padananfp');
               }//end if
            } else {
               echo "Padanan Sudah Wujud!";
            }//end if
        } else {
            echo "Rekod Tidak Berjaya Dikemaskini!";
        }//end if
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }
    }//end method    
        
    //HAPUS - KOD JENIS FASILITI
    function padananfp_hapus(){
        $id = $this->input->post('id');        
        $this->Tbl_padananfp_model->delete($id);
        echo "Rekod Berjaya Dihapus!";
    }//end method
    
    // SENARAI - HASIL CARIAN
    function listJson_padananfp(){
        $padananfp = $this->Tbl_padananfp_model->findAll();        
        //set template
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        //set table heading
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'30px', 'class'=>'text-center'),array('data'=>'ID Fasiliti Penempatan', 'class'=>'text-center'),array('data'=>'Kod Fasiliti', 'class'=>'text-center'),array('data'=>'Perihal Fasiliti', 'class'=>'text-center'),array('data'=>'Kod Penempatan', 'class'=>'text-center'),array('data'=>'Perihal Penempatan', 'class'=>'text-center'),array('data'=>'Tindakan', 'width'=>'120px', 'class'=>'text-center')));                       
        //set table data       
        $bil = 1;
        foreach ($padananfp as $key => $val) {
            $button = "<a href='#myModalView' class='btn btn-mini' id='view' data-toggle='modal' title='Papar Modul' attr='".$val['idFP']."'><i class='icon icon-zoom-in'></i></a>";
            $button .= nbs(1)."<a href='#myModalUpdate' class='btn btn-mini' id='edit' data-toggle='modal' title='Kemaskini Modul' attr='".$val['idFP']."'><i class='icon icon-edit'></i></a>";
            $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Hapus Modul' id='delete' attr='".$val['idFP']."'><i class='icon icon-trash'></i></a>";
            $this->table->add_row(array(array('data'=>$bil, 'class'=>'text-center'),array('data'=>$val['idFP'], 'class'=>'text-center'),array('data'=>$val['kodFasiliti'], 'class'=>'text-center'),$val['perihalFasiliti'],array('data'=>$val['kodPenempatan'], 'class'=>'text-center'),$val['perihalPenempatan'],array('data'=>$button, 'class'=>'text-center')));     
            $bil++;
        }
        //generate table
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";         
    }//end method   
    
    function getFasiliti() {
           
        $fasiliti = $this->input->post('id');
        
        if($fasiliti != '') {            
            $lokasiBertugas = $this->Eminda_model->get_select_list('_kodFasiliti',array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1, array('kodJenisFasiliti'=>$fasiliti));       
            
            echo '<div class="control-group">';
            echo '<label for="fasiliti" class="control-label">Fasiliti</label>';
            echo '<div class="controls" style="width:auto;">';
            echo form_dropdown('fasiliti', $lokasiBertugas,'', 'id = "fasiliti"');
            echo '<span class="help-inline"></span>';
            echo '</div>';
            echo '</div>';
            
        }
    }
}//end class  