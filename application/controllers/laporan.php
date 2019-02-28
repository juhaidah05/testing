<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (1 Ogos 2015)   :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *  (25 Ogos 2015)  :	1. Tambah method jana_hantar_notis()
 *  (28 Ogos 2015)  :   1. Tambah method status_jana_ulang(), status_jana_ulang2(), 
 * 			   jana_laporan_ulang() dan jana_laporan_ulang2()
 *  (1 Sept 2015)   :	1. Tambah column Fasiliti dan Lokasi Bertugas pada semua 
 *  			   paparan senarai pengguna 
 *  (2 Sept 2015)   :	1. Ubahsuai method jana_laporan_ulang() dan jana_laporan_ulang2()
 *                         supaya memaparkan maklumat tarikhUjian, skor1-3 dan keputusan masing2.	
 *  (13 Sept 2015)  :   1. Tambah method anatilik(), status_jana3() dan status_jana4() 
 *                         untuk menyokong/menyediakan data bagi kemudahan janaan statistik/carta.
 *  (10 Okt 2015)   :   1. Ubahsuai method jana_laporan_ambil() dan jana_laporan_ambil2()
 *  (23 Okt 2015)   :   1. Baiki method hantar_notis supaya sistem menyemak kewujudan rekod
 *                         pada kedua-dua table notisperingatan dan penerimanotis. 
 *                         Semakan ini membantu dalam memaparkan mesej yang tepat.
 *  (26 Okt 2015)   :   1. Ubah format Mykad mengikut: setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)
 *                         supaya nilai yang akan terpapar pada MS Excel adalah dalam format nomnbor Mykad yang betul
 *  (27 Okt 2015)   :   1. Buang $this->load->helper('html'); 
 *  (9 Dis 2015 )	:	1. Ubahsuai method status(),ulang() dan analitik() untuk menapis jenis paparan mengikut peranan
 *						   					
 */

class Laporan extends MY_Controller {
    public function __construct() {
        parent::__construct();        
        $this->_ci =& get_instance();        
        $this->load->model("Eminda_model");
        $this->load->model('Tbl_pengguna_model');
        $this->load->model('Tbl_profil_model');
        $this->load->model('Tbl_perkhidmatan_model');
        $this->load->model('Tbl_ujian_model');
        $this->load->model('Tbl_kodjenisfasiliti_model');
        $this->load->model('Tbl_kodfasiliti_model');
        $this->load->model('Tbl_kodpenempatan_model');
        $this->load->model('Tbl_padananfp_model');
        $this->load->model('Tbl_notisperingatan_model');
        $this->load->model('Tbl_penerimanotis_model');
        //$this->load->helper('html'); 
    }//end method... 
    
    function status(){         
        $mykad = $this->_ci->session->userdata('username');
        $peranan = $this->Tbl_pengguna_model->get_peranan($mykad);
        $lokaliti = $this->Tbl_pengguna_model->get_lokaliti($mykad);
        $fasiliti = $this->Tbl_kodfasiliti_model->get_fasiliti($lokaliti);    		

		$fasiliti_arr = '';
		$bil=1;
		foreach ($fasiliti as $nilai) { 
			if($bil!=1){ $fasiliti_arr.= ','; }
			$fasiliti_arr.= $nilai['kodJenisFasiliti'];	
			$bil++;
		}	
        
		$data['title'] = "Status Pengisian";      
        $data['ujian'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'perihalUjian', 'orderby'=>'kodUjian'),1);  
        $data['siri_dependence'] = $this->Eminda_model->get_select_list('siri_dependence', '',1); 
        $data['siri'] = $this->Eminda_model->get_select_list('ambilan', array('key'=>'siri', 'val'=>'siri', 'orderby'=>'siri'),1);
        $data['tahun'] = $this->Eminda_model->get_select_list('ambilan', array('key'=>'tahun', 'val'=>'tahun', 'orderby'=>'tahun'),1);
        $data['peranan'] = $peranan;
		
        if($peranan==2){//sekiranya pengguna adalah superadmin...
            $data['peranan']=$peranan;
			$data['jenis_fasiliti'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
            $data['fasiliti_dependence'] = $this->Eminda_model->get_select_list('fasiliti_dependence', '',1); 
            $data['fasiliti'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1);             
            $data['penempatan_dependence'] = $this->Eminda_model->get_select_list('penempatan_dependence', '',1);
            $data['penempatan'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);            
        } else { //sekiranya pengguna adalah admin...            
			$data['peranan']=$peranan;
			//maklumat jenis fasiliti
			$jenis_fasiliti_kod=$this->Tbl_kodfasiliti_model->get_jenisfasiliti_kod($lokaliti);
			$data['jenis_fasiliti_perihal']=$this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti_kod);
			$jenis_fasiliti_perihal=$this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti_kod);
			$data['jfasiliti']=array($jenis_fasiliti_kod=>$jenis_fasiliti_perihal);
			
			//maklumat fasiliti
			$data['fasiliti_perihal']=$this->Tbl_kodfasiliti_model->get_fasiliti_perihal($lokaliti);
			$fasiliti_perihal=$this->Tbl_kodfasiliti_model->get_fasiliti_perihal($lokaliti);
			$data['fasiliti']=array($lokaliti=>$fasiliti_perihal);
			
			//maklumat penempatan
			//$data['penempatan'] = $this->Eminda_model->get_select_list_admin('_kodPenempatan a', array('key'=>'a.kodPenempatan', 'val'=>'a.perihalPenempatan'),1,'a.kodPenempatan = (SELECT b.penempatan FROM _padananFP b WHERE b.penempatan = a.kodPenempatan AND b.fasiliti = '.$lokaliti.')');
			$list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti='".$lokaliti."')";
			$data['penempatan'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'kodPenempatan'),1,$list_penempatan);     
		}		
        $this->_render_page($data);
    }//end method...
    
    function ulang(){  
        $mykad = $this->_ci->session->userdata('username');
        $peranan = $this->Tbl_pengguna_model->get_peranan($mykad);
        $lokaliti = $this->Tbl_pengguna_model->get_lokaliti($mykad);
        $fasiliti = $this->Tbl_kodfasiliti_model->get_fasiliti($lokaliti);
        $fasiliti_arr = '';
        $bil=1;
        foreach ($fasiliti as $nilai) { 
            if($bil!=1){ $fasiliti_arr.= ','; }
            $fasiliti_arr.= $nilai['kodJenisFasiliti'];	
            $bil++;
        }
        $data['title'] = "Status Mengulang";      
        $data['ujian'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'perihalUjian', 'orderby'=>'kodUjian'),1);  
        $data['siri_dependence'] = $this->Eminda_model->get_select_list('siri_dependence', '',1); 
        $data['siri'] = $this->Eminda_model->get_select_list('ambilan', array('key'=>'siri', 'val'=>'siri', 'orderby'=>'siri'),1);
        $data['tahun'] = $this->Eminda_model->get_select_list('ambilan', array('key'=>'tahun', 'val'=>'tahun', 'orderby'=>'tahun'),1);
        
        if($peranan==2){//superadmin...
            $data['peranan']=$peranan;
			$data['jenis_fasiliti'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
            $data['fasiliti_dependence'] = $this->Eminda_model->get_select_list('fasiliti_dependence', '',1); 
            $data['fasiliti'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1);             
            $data['penempatan_dependence'] = $this->Eminda_model->get_select_list('penempatan_dependence', '',1);
            $data['penempatan'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);            
        } else {//admin...
            $data['peranan']=$peranan;
			//maklumat jenis fasiliti
			$jenis_fasiliti_kod=$this->Tbl_kodfasiliti_model->get_jenisfasiliti_kod($lokaliti);
			$data['jenis_fasiliti_perihal']=$this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti_kod);
			$jenis_fasiliti_perihal=$this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti_kod);
			$data['jfasiliti']=array($jenis_fasiliti_kod=>$jenis_fasiliti_perihal);
			//maklumat fasiliti
			$data['fasiliti_perihal']=$this->Tbl_kodfasiliti_model->get_fasiliti_perihal($lokaliti);
			$fasiliti_perihal=$this->Tbl_kodfasiliti_model->get_fasiliti_perihal($lokaliti);
			$data['fasiliti']=array($lokaliti=>$fasiliti_perihal);
			//maklumat penempatan
			$list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti='".$lokaliti."')";
			$data['penempatan'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'kodPenempatan'),1,$list_penempatan);  
        } 
        $this->_render_page($data);
    }//end method...  
    
    function analitik(){         
        $mykad = $this->_ci->session->userdata('username');
        $peranan = $this->Tbl_pengguna_model->get_peranan($mykad);
        $lokaliti = $this->Tbl_pengguna_model->get_lokaliti($mykad);
        $fasiliti = $this->Tbl_kodfasiliti_model->get_fasiliti($lokaliti);
        $fasiliti_arr = '';
        $bil=1;
        foreach ($fasiliti as $nilai) { 
            if($bil!=1){ $fasiliti_arr.= ','; }
            $fasiliti_arr.= $nilai['kodJenisFasiliti'];	
            $bil++;
        }		
        $data['title'] = "Ringkasan Analitik";      
        $data['ujian'] = $this->Eminda_model->get_select_list('_kodUjian', array('key'=>'kodUjian', 'val'=>'perihalUjian', 'orderby'=>'kodUjian'),1);  
        $data['siri_dependence'] = $this->Eminda_model->get_select_list('siri_dependence', '',1); 
        $data['siri'] = $this->Eminda_model->get_select_list('ambilan', array('key'=>'siri', 'val'=>'siri', 'orderby'=>'siri'),1);
        $data['tahun'] = $this->Eminda_model->get_select_list('ambilan', array('key'=>'tahun', 'val'=>'tahun', 'orderby'=>'tahun'),1);
        
        if($peranan==2){//superadmin...
            $data['peranan']=$peranan;
			$data['jenis_fasiliti'] = $this->Eminda_model->get_select_list('_kodJenisFasiliti', array('key'=>'kodJenisFasiliti', 'val'=>'perihalJenisFasiliti', 'orderby'=>'x'),1);
            $data['fasiliti_dependence'] = $this->Eminda_model->get_select_list('fasiliti_dependence', '',1); 
            $data['fasiliti'] = $this->Eminda_model->get_select_list('_kodFasiliti', array('key'=>'kodFasiliti', 'val'=>'perihalFasiliti', 'orderby'=>'x'),1);             
            $data['penempatan_dependence'] = $this->Eminda_model->get_select_list('penempatan_dependence', '',1);
            $data['penempatan'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'x'),1);            
        } else {//admin...
            $data['peranan']=$peranan;
			//maklumat jenis fasiliti
			$jenis_fasiliti_kod=$this->Tbl_kodfasiliti_model->get_jenisfasiliti_kod($lokaliti);
			$data['jenis_fasiliti_perihal']=$this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti_kod);
			$jenis_fasiliti_perihal=$this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti_kod);
			$data['jfasiliti']=array($jenis_fasiliti_kod=>$jenis_fasiliti_perihal);
			//maklumat fasiliti
			$data['fasiliti_perihal']=$this->Tbl_kodfasiliti_model->get_fasiliti_perihal($lokaliti);
			$fasiliti_perihal=$this->Tbl_kodfasiliti_model->get_fasiliti_perihal($lokaliti);
			$data['fasiliti']=array($lokaliti=>$fasiliti_perihal);
			//maklumat penempatan
			$list_penempatan = "kodPenempatan IN (SELECT penempatan FROM _padananFP WHERE fasiliti='".$lokaliti."')";
			$data['penempatan'] = $this->Eminda_model->get_select_list('_kodPenempatan', array('key'=>'kodPenempatan', 'val'=>'perihalPenempatan', 'orderby'=>'kodPenempatan'),1,$list_penempatan);  
        }         
        $this->_render_page($data);
    }//end method...
    
    function status_jana(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua($jenis_fasiliti,$fasiliti,$penempatan);    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $papar_ambil = ($jumlah_ambil>0)? "<button id='papar_ambil' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            $papar_belum = ($jumlah_belum>0)? "<button id='papar_belum' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>".$papar_ambil."</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>".$papar_belum."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function status_jana2(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua2($jenis_fasiliti,$fasiliti);    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil2($id_ambilan,$jenis_fasiliti,$fasiliti):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum2($id_ambilan,$jenis_fasiliti,$fasiliti):0;
            $papar_ambil = ($jumlah_ambil>0)? "<button id='papar_ambil' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            $papar_belum = ($jumlah_belum>0)? "<button id='papar_belum' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>".$papar_ambil."</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>".$papar_belum."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function status_jana3(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua($jenis_fasiliti,$fasiliti,$penempatan);
        //jika wujud pengguna
		if($jumlah_semua>0){  
			$jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ltd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_lelaki_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ptd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_perempuan_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_lelaki_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_perempuan_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_lelaki_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_perempuan_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0; 
            
            $jumlah_dn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_depression_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_depression_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ds= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_depression_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dt= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_depression_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_depression_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_en= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_enxiety_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_er= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_enxiety_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_es= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_enxiety_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_et= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_enxiety_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_est= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_enxiety_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_sn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_stress_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_stress_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ss= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_stress_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_st= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_stress_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil_stress_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;

            echo "<div style='padding:0px 100px 0px 100px !important;'>                                
                    <table width='100%'>
                    <tr><td width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td></tr>
                            <tr><td><div align='right'>4.</div></td><td>Mengulangi Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td></tr>                                
                        </tbody>    
                    </table>
                    </td>
                    <td  width='5%'></td>
                    <td  width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead>
                            <tr><th rowspan='2'>Perkara</th><th colspan='3'><div align='center'>Peratusan %</div></th></tr>
                            <tr><td><div align='center'>Tekanan</div></th></td><td><div align='center'>Kebimbangan</div></th></td><td><div align='center'>Kemurungan</div></th></td></tr>
                        </thead>
                        <tbody>";
						if($jumlah_ambil>0){
							echo "	
                            <tr><td>Normal</td><td><div align='center'><b>".round((($jumlah_sn/$jumlah_ambil)*100),2)." (".$jumlah_sn.")</b></div></td><td><div align='center'><b>".round((($jumlah_en/$jumlah_ambil)*100),2)." (".$jumlah_en.")</b></div></td><td><div align='center'><b>".round((($jumlah_dn/$jumlah_ambil)*100),2)." (".$jumlah_dn.")</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>".round((($jumlah_sr/$jumlah_ambil)*100),2)." (".$jumlah_sr.")</b></div></td><td><div align='center'><b>".round((($jumlah_er/$jumlah_ambil)*100),2)." (".$jumlah_er.")</b></div></td><td><div align='center'><b>".round((($jumlah_dr/$jumlah_ambil)*100),2)." (".$jumlah_dr.")</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>".round((($jumlah_ss/$jumlah_ambil)*100),2)." (".$jumlah_ss.")</b></div></td><td><div align='center'><b>".round((($jumlah_es/$jumlah_ambil)*100),2)." (".$jumlah_es.")</b></div></td><td><div align='center'><b>".round((($jumlah_ds/$jumlah_ambil)*100),2)." (".$jumlah_ds.")</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>".round((($jumlah_st/$jumlah_ambil)*100),2)." (".$jumlah_st.")</b></div></td><td><div align='center'><b>".round((($jumlah_et/$jumlah_ambil)*100),2)." (".$jumlah_et.")</b></div></td><td><div align='center'><b>".round((($jumlah_dt/$jumlah_ambil)*100),2)." (".$jumlah_dt.")</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>".round((($jumlah_sst/$jumlah_ambil)*100),2)." (".$jumlah_sst.")</b></div></td><td><div align='center'><b>".round((($jumlah_est/$jumlah_ambil)*100),2)." (".$jumlah_est.")</b></div></td><td><div align='center'><b>".round((($jumlah_dst/$jumlah_ambil)*100),2)." (".$jumlah_dst.")</b></div></td></tr>
							";    
                        } else {
							echo "
							<tr><td>Normal</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
							";
						}
						echo "
						</tbody>    
                    </table>
                    </td>
                    </table>
                </div>
                    <input type='hidden' id='jumlah_ambil' value='".$jumlah_ambil."' />
                    <input type='hidden' id='jumlah_belum' value='".$jumlah_belum."' />
                    <input type='hidden' id='jumlah_ulang' value='".$jumlah_ulang."' />
                    <input type='hidden' id='jumlah_lts' value='".$jumlah_lts."' />
                    <input type='hidden' id='jumlah_pts' value='".$jumlah_pts."' />
                    <input type='hidden' id='jumlah_lte' value='".$jumlah_lte."' />
                    <input type='hidden' id='jumlah_pte' value='".$jumlah_pte."' />
                    <input type='hidden' id='jumlah_ltd' value='".$jumlah_ltd."' />
                    <input type='hidden' id='jumlah_ptd' value='".$jumlah_ptd."' />";
                    
					if($jumlah_ambil>0){
					echo "
                    <input type='hidden' id='jumlah_sn' value='".(($jumlah_sn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sr' value='".(($jumlah_sr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ss' value='".(($jumlah_ss/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_st' value='".(($jumlah_st/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sst' value='".(($jumlah_sst/$jumlah_ambil)*100)."' />
                        
                    <input type='hidden' id='jumlah_en' value='".(($jumlah_en/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_er' value='".(($jumlah_er/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_es' value='".(($jumlah_es/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_et' value='".(($jumlah_et/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_est' value='".(($jumlah_est/$jumlah_ambil)*100)."' />

                    <input type='hidden' id='jumlah_dn' value='".(($jumlah_dn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dr' value='".(($jumlah_dr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ds' value='".(($jumlah_ds/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dt' value='".(($jumlah_dt/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dst' value='".(($jumlah_dst/$jumlah_ambil)*100)."' />
					";
					} else {
					echo "
					<input type='hidden' id='jumlah_sn' value='0' />
                    <input type='hidden' id='jumlah_sr' value='0' />
                    <input type='hidden' id='jumlah_ss' value='0' />
                    <input type='hidden' id='jumlah_st' value='0' />
                    <input type='hidden' id='jumlah_sst' value='0' />
                        
                    <input type='hidden' id='jumlah_en' value='0' />
                    <input type='hidden' id='jumlah_er' value='0' />
                    <input type='hidden' id='jumlah_es' value='0' />
                    <input type='hidden' id='jumlah_et' value='0' />
                    <input type='hidden' id='jumlah_est' value='0' />

                    <input type='hidden' id='jumlah_dn' value='0' />
                    <input type='hidden' id='jumlah_dr' value='0' />
                    <input type='hidden' id='jumlah_ds' value='0' />
                    <input type='hidden' id='jumlah_dt' value='0' />
                    <input type='hidden' id='jumlah_dst' value='0' />
					";							
					}//end if                 
        } else {
            echo 'tiada data';
        }//end if    
    }//end method...
    
    function status_jana4(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua2($jenis_fasiliti,$fasiliti);            
        if($jumlah_semua>0){            
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil2($id_ambilan,$jenis_fasiliti,$fasiliti):0;  
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum2($id_ambilan,$jenis_fasiliti,$fasiliti):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang2($id_ambilan,$jenis_fasiliti,$fasiliti):0;
            $jumlah_ltd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_lelaki_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ptd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_perempuan_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_lelaki_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_perempuan_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_lelaki_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_perempuan_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0; 
            
            $jumlah_dn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_depression_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_depression_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ds= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_depression_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dt= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_depression_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_depression_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_en= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_enxiety_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_er= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_enxiety_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_es= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_enxiety_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_et= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_enxiety_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_est= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_enxiety_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_sn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_stress_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_stress_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ss= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_stress_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_st= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_stress_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil2_stress_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            echo "<div style='padding:0px 100px 0px 100px !important;'>                                
                    <table width='100%'>
                    <tr><td width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td></tr>
                            <tr><td><div align='right'>4.</div></td><td>Mengulangi Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td></tr>                                
                        </tbody>    
                    </table>
                    </td>
                    <td  width='5%'></td>
                    <td  width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead>
                            <tr><th rowspan='2'>Perkara</th><th colspan='3'><div align='center'>Peratusan %</div></th></tr>
                            <tr><td><div align='center'>Tekanan</div></th></td><td><div align='center'>Kebimbangan</div></th></td><td><div align='center'>Kemurungan</div></th></td></tr>
                        </thead>
                        <tbody>";
                            if($jumlah_ambil>0){
							echo "	
                            <tr><td>Normal</td><td><div align='center'><b>".round((($jumlah_sn/$jumlah_ambil)*100),2)." (".$jumlah_sn.")</b></div></td><td><div align='center'><b>".round((($jumlah_en/$jumlah_ambil)*100),2)." (".$jumlah_en.")</b></div></td><td><div align='center'><b>".round((($jumlah_dn/$jumlah_ambil)*100),2)." (".$jumlah_dn.")</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>".round((($jumlah_sr/$jumlah_ambil)*100),2)." (".$jumlah_sr.")</b></div></td><td><div align='center'><b>".round((($jumlah_er/$jumlah_ambil)*100),2)." (".$jumlah_er.")</b></div></td><td><div align='center'><b>".round((($jumlah_dr/$jumlah_ambil)*100),2)." (".$jumlah_dr.")</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>".round((($jumlah_ss/$jumlah_ambil)*100),2)." (".$jumlah_ss.")</b></div></td><td><div align='center'><b>".round((($jumlah_es/$jumlah_ambil)*100),2)." (".$jumlah_es.")</b></div></td><td><div align='center'><b>".round((($jumlah_ds/$jumlah_ambil)*100),2)." (".$jumlah_ds.")</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>".round((($jumlah_st/$jumlah_ambil)*100),2)." (".$jumlah_st.")</b></div></td><td><div align='center'><b>".round((($jumlah_et/$jumlah_ambil)*100),2)." (".$jumlah_et.")</b></div></td><td><div align='center'><b>".round((($jumlah_dt/$jumlah_ambil)*100),2)." (".$jumlah_dt.")</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>".round((($jumlah_sst/$jumlah_ambil)*100),2)." (".$jumlah_sst.")</b></div></td><td><div align='center'><b>".round((($jumlah_est/$jumlah_ambil)*100),2)." (".$jumlah_est.")</b></div></td><td><div align='center'><b>".round((($jumlah_dst/$jumlah_ambil)*100),2)." (".$jumlah_dst.")</b></div></td></tr>
							";    
                        } else {
							echo "
							<tr><td>Normal</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
							";
						}
						echo "    
                        </tbody>    
                    </table>
                    </td>
                    </table>
                </div>    
                    <input type='hidden' id='jumlah_ambil' value='".$jumlah_ambil."' />
                    <input type='hidden' id='jumlah_belum' value='".$jumlah_belum."' />
                    <input type='hidden' id='jumlah_ulang' value='".$jumlah_ulang."' />
                    <input type='hidden' id='jumlah_lts' value='".$jumlah_lts."' />
                    <input type='hidden' id='jumlah_pts' value='".$jumlah_pts."' />
                    <input type='hidden' id='jumlah_lte' value='".$jumlah_lte."' />
                    <input type='hidden' id='jumlah_pte' value='".$jumlah_pte."' />
                    <input type='hidden' id='jumlah_ltd' value='".$jumlah_ltd."' />
                    <input type='hidden' id='jumlah_ptd' value='".$jumlah_ptd."' />";
                    
                    if($jumlah_ambil>0){
					echo "
                    <input type='hidden' id='jumlah_sn' value='".(($jumlah_sn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sr' value='".(($jumlah_sr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ss' value='".(($jumlah_ss/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_st' value='".(($jumlah_st/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sst' value='".(($jumlah_sst/$jumlah_ambil)*100)."' />
                        
                    <input type='hidden' id='jumlah_en' value='".(($jumlah_en/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_er' value='".(($jumlah_er/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_es' value='".(($jumlah_es/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_et' value='".(($jumlah_et/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_est' value='".(($jumlah_est/$jumlah_ambil)*100)."' />

                    <input type='hidden' id='jumlah_dn' value='".(($jumlah_dn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dr' value='".(($jumlah_dr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ds' value='".(($jumlah_ds/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dt' value='".(($jumlah_dt/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dst' value='".(($jumlah_dst/$jumlah_ambil)*100)."' />
					";
					} else {
					echo "
					<input type='hidden' id='jumlah_sn' value='0' />
                    <input type='hidden' id='jumlah_sr' value='0' />
                    <input type='hidden' id='jumlah_ss' value='0' />
                    <input type='hidden' id='jumlah_st' value='0' />
                    <input type='hidden' id='jumlah_sst' value='0' />
                        
                    <input type='hidden' id='jumlah_en' value='0' />
                    <input type='hidden' id='jumlah_er' value='0' />
                    <input type='hidden' id='jumlah_es' value='0' />
                    <input type='hidden' id='jumlah_et' value='0' />
                    <input type='hidden' id='jumlah_est' value='0' />

                    <input type='hidden' id='jumlah_dn' value='0' />
                    <input type='hidden' id='jumlah_dr' value='0' />
                    <input type='hidden' id='jumlah_ds' value='0' />
                    <input type='hidden' id='jumlah_dt' value='0' />
                    <input type='hidden' id='jumlah_dst' value='0' />
					";							
					}//end if                 
        } else {
            echo 'tiada data';
        }//end if    
    }//end method...
    
    function status_jana5(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua3($jenis_fasiliti);    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil3($id_ambilan,$jenis_fasiliti):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum3($id_ambilan,$jenis_fasiliti):0;
            $papar_ambil = ($jumlah_ambil>0)? "<button id='papar_ambil' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            $papar_belum = ($jumlah_belum>0)? "<button id='papar_belum' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>".$papar_ambil."</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>".$papar_belum."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function status_jana6(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua4();    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil4($id_ambilan):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum4($id_ambilan):0;
            $papar_ambil = ($jumlah_ambil>0)? "<button id='papar_ambil' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            $papar_belum = ($jumlah_belum>0)? "<button id='papar_belum' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>".$papar_ambil."</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>".$papar_belum."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function status_jana7(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua3($jenis_fasiliti);            
        if($jumlah_semua>0){            
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil3($id_ambilan,$jenis_fasiliti):0;  
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum3($id_ambilan,$jenis_fasiliti):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang3($id_ambilan,$jenis_fasiliti):0;
            $jumlah_ltd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_lelaki_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ptd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_perempuan_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_lelaki_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_perempuan_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_lelaki_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_perempuan_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0; 
            
            $jumlah_dn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_depression_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_depression_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ds= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_depression_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dt= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_depression_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_depression_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_en= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_enxiety_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_er= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_enxiety_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_es= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_enxiety_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_et= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_enxiety_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_est= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_enxiety_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_sn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_stress_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_stress_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ss= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_stress_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_st= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_stress_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil3_stress_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            echo "<div style='padding:0px 100px 0px 100px !important;'>                                
                    <table width='100%'>
                    <tr><td width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td></tr>
                            <tr><td><div align='right'>4.</div></td><td>Mengulangi Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td></tr>                                
                        </tbody>    
                    </table>
                    </td>
                    <td  width='5%'></td>
                    <td  width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead>
                            <tr><th rowspan='2'>Perkara</th><th colspan='3'><div align='center'>Peratusan %</div></th></tr>
                            <tr><td><div align='center'>Tekanan</div></th></td><td><div align='center'>Kebimbangan</div></th></td><td><div align='center'>Kemurungan</div></th></td></tr>
                        </thead>
                        <tbody>";
                            if($jumlah_ambil>0){
							echo "	
                            <tr><td>Normal</td><td><div align='center'><b>".round((($jumlah_sn/$jumlah_ambil)*100),2)." (".$jumlah_sn.")</b></div></td><td><div align='center'><b>".round((($jumlah_en/$jumlah_ambil)*100),2)." (".$jumlah_en.")</b></div></td><td><div align='center'><b>".round((($jumlah_dn/$jumlah_ambil)*100),2)." (".$jumlah_dn.")</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>".round((($jumlah_sr/$jumlah_ambil)*100),2)." (".$jumlah_sr.")</b></div></td><td><div align='center'><b>".round((($jumlah_er/$jumlah_ambil)*100),2)." (".$jumlah_er.")</b></div></td><td><div align='center'><b>".round((($jumlah_dr/$jumlah_ambil)*100),2)." (".$jumlah_dr.")</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>".round((($jumlah_ss/$jumlah_ambil)*100),2)." (".$jumlah_ss.")</b></div></td><td><div align='center'><b>".round((($jumlah_es/$jumlah_ambil)*100),2)." (".$jumlah_es.")</b></div></td><td><div align='center'><b>".round((($jumlah_ds/$jumlah_ambil)*100),2)." (".$jumlah_ds.")</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>".round((($jumlah_st/$jumlah_ambil)*100),2)." (".$jumlah_st.")</b></div></td><td><div align='center'><b>".round((($jumlah_et/$jumlah_ambil)*100),2)." (".$jumlah_et.")</b></div></td><td><div align='center'><b>".round((($jumlah_dt/$jumlah_ambil)*100),2)." (".$jumlah_dt.")</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>".round((($jumlah_sst/$jumlah_ambil)*100),2)." (".$jumlah_sst.")</b></div></td><td><div align='center'><b>".round((($jumlah_est/$jumlah_ambil)*100),2)." (".$jumlah_est.")</b></div></td><td><div align='center'><b>".round((($jumlah_dst/$jumlah_ambil)*100),2)." (".$jumlah_dst.")</b></div></td></tr>
							";    
                        } else {
							echo "
							<tr><td>Normal</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
							";
						}
						echo "    
                        </tbody>    
                    </table>
                    </td>
                    </table>
                </div>    
                    <input type='hidden' id='jumlah_ambil' value='".$jumlah_ambil."' />
                    <input type='hidden' id='jumlah_belum' value='".$jumlah_belum."' />
                    <input type='hidden' id='jumlah_ulang' value='".$jumlah_ulang."' />
                    <input type='hidden' id='jumlah_lts' value='".$jumlah_lts."' />
                    <input type='hidden' id='jumlah_pts' value='".$jumlah_pts."' />
                    <input type='hidden' id='jumlah_lte' value='".$jumlah_lte."' />
                    <input type='hidden' id='jumlah_pte' value='".$jumlah_pte."' />
                    <input type='hidden' id='jumlah_ltd' value='".$jumlah_ltd."' />
                    <input type='hidden' id='jumlah_ptd' value='".$jumlah_ptd."' />";
                    
                    if($jumlah_ambil>0){
					echo "
                    <input type='hidden' id='jumlah_sn' value='".(($jumlah_sn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sr' value='".(($jumlah_sr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ss' value='".(($jumlah_ss/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_st' value='".(($jumlah_st/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sst' value='".(($jumlah_sst/$jumlah_ambil)*100)."' />
                        
                    <input type='hidden' id='jumlah_en' value='".(($jumlah_en/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_er' value='".(($jumlah_er/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_es' value='".(($jumlah_es/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_et' value='".(($jumlah_et/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_est' value='".(($jumlah_est/$jumlah_ambil)*100)."' />

                    <input type='hidden' id='jumlah_dn' value='".(($jumlah_dn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dr' value='".(($jumlah_dr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ds' value='".(($jumlah_ds/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dt' value='".(($jumlah_dt/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dst' value='".(($jumlah_dst/$jumlah_ambil)*100)."' />
					";
					} else {
					echo "
					<input type='hidden' id='jumlah_sn' value='0' />
                    <input type='hidden' id='jumlah_sr' value='0' />
                    <input type='hidden' id='jumlah_ss' value='0' />
                    <input type='hidden' id='jumlah_st' value='0' />
                    <input type='hidden' id='jumlah_sst' value='0' />
                        
                    <input type='hidden' id='jumlah_en' value='0' />
                    <input type='hidden' id='jumlah_er' value='0' />
                    <input type='hidden' id='jumlah_es' value='0' />
                    <input type='hidden' id='jumlah_et' value='0' />
                    <input type='hidden' id='jumlah_est' value='0' />

                    <input type='hidden' id='jumlah_dn' value='0' />
                    <input type='hidden' id='jumlah_dr' value='0' />
                    <input type='hidden' id='jumlah_ds' value='0' />
                    <input type='hidden' id='jumlah_dt' value='0' />
                    <input type='hidden' id='jumlah_dst' value='0' />
					";							
					}//end if                 
        } else {
            echo 'tiada data';
        }//end if     
    }//end method...
    
    function status_jana8(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua4();            
        if($jumlah_semua>0){            
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil4($id_ambilan):0;  
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum4($id_ambilan):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang4($id_ambilan):0;
            $jumlah_ltd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_lelaki_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ptd= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_perempuan_teruk_depression($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_lelaki_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pte= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_perempuan_teruk_enxiety($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_lts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_lelaki_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_pts= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_perempuan_teruk_stress($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0; 
            
            $jumlah_dn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_depression_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_depression_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ds= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_depression_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dt= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_depression_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_dst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_depression_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_en= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_enxiety_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_er= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_enxiety_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_es= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_enxiety_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_et= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_enxiety_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_est= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_enxiety_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            $jumlah_sn= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_stress_normal($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sr= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_stress_ringan($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ss= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_stress_sederhana($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_st= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_stress_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_sst= ($jumlah_ambil>0)? $this->Tbl_ujian_model->get_count_ambil4_stress_sangat_teruk($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            
            echo "<div style='padding:0px 100px 0px 100px !important;'>                                
                    <table width='100%'>
                    <tr><td width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td></tr>
                            <tr><td><div align='right'>4.</div></td><td>Mengulangi Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td></tr>                                
                        </tbody>    
                    </table>
                    </td>
                    <td  width='5%'></td>
                    <td  width='45%' valign='top'>
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead>
                            <tr><th rowspan='2'>Perkara</th><th colspan='3'><div align='center'>Peratusan %</div></th></tr>
                            <tr><td><div align='center'>Tekanan</div></th></td><td><div align='center'>Kebimbangan</div></th></td><td><div align='center'>Kemurungan</div></th></td></tr>
                        </thead>
                        <tbody>";
                            if($jumlah_ambil>0){
							echo "	
                            <tr><td>Normal</td><td><div align='center'><b>".round((($jumlah_sn/$jumlah_ambil)*100),2)." (".$jumlah_sn.")</b></div></td><td><div align='center'><b>".round((($jumlah_en/$jumlah_ambil)*100),2)." (".$jumlah_en.")</b></div></td><td><div align='center'><b>".round((($jumlah_dn/$jumlah_ambil)*100),2)." (".$jumlah_dn.")</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>".round((($jumlah_sr/$jumlah_ambil)*100),2)." (".$jumlah_sr.")</b></div></td><td><div align='center'><b>".round((($jumlah_er/$jumlah_ambil)*100),2)." (".$jumlah_er.")</b></div></td><td><div align='center'><b>".round((($jumlah_dr/$jumlah_ambil)*100),2)." (".$jumlah_dr.")</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>".round((($jumlah_ss/$jumlah_ambil)*100),2)." (".$jumlah_ss.")</b></div></td><td><div align='center'><b>".round((($jumlah_es/$jumlah_ambil)*100),2)." (".$jumlah_es.")</b></div></td><td><div align='center'><b>".round((($jumlah_ds/$jumlah_ambil)*100),2)." (".$jumlah_ds.")</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>".round((($jumlah_st/$jumlah_ambil)*100),2)." (".$jumlah_st.")</b></div></td><td><div align='center'><b>".round((($jumlah_et/$jumlah_ambil)*100),2)." (".$jumlah_et.")</b></div></td><td><div align='center'><b>".round((($jumlah_dt/$jumlah_ambil)*100),2)." (".$jumlah_dt.")</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>".round((($jumlah_sst/$jumlah_ambil)*100),2)." (".$jumlah_sst.")</b></div></td><td><div align='center'><b>".round((($jumlah_est/$jumlah_ambil)*100),2)." (".$jumlah_est.")</b></div></td><td><div align='center'><b>".round((($jumlah_dst/$jumlah_ambil)*100),2)." (".$jumlah_dst.")</b></div></td></tr>
							";    
                        } else {
							echo "
							<tr><td>Normal</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Ringan</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sederhana</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
                            <tr><td>Sangat Teruk</td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td><td><div align='center'><b>0</b></div></td></tr>
							";
						}
						echo "    
                        </tbody>    
                    </table>
                    </td>
                    </table>
                </div>    
                    <input type='hidden' id='jumlah_ambil' value='".$jumlah_ambil."' />
                    <input type='hidden' id='jumlah_belum' value='".$jumlah_belum."' />
                    <input type='hidden' id='jumlah_ulang' value='".$jumlah_ulang."' />
                    <input type='hidden' id='jumlah_lts' value='".$jumlah_lts."' />
                    <input type='hidden' id='jumlah_pts' value='".$jumlah_pts."' />
                    <input type='hidden' id='jumlah_lte' value='".$jumlah_lte."' />
                    <input type='hidden' id='jumlah_pte' value='".$jumlah_pte."' />
                    <input type='hidden' id='jumlah_ltd' value='".$jumlah_ltd."' />
                    <input type='hidden' id='jumlah_ptd' value='".$jumlah_ptd."' />";
                    
                    if($jumlah_ambil>0){
					echo "
                    <input type='hidden' id='jumlah_sn' value='".(($jumlah_sn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sr' value='".(($jumlah_sr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ss' value='".(($jumlah_ss/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_st' value='".(($jumlah_st/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_sst' value='".(($jumlah_sst/$jumlah_ambil)*100)."' />
                        
                    <input type='hidden' id='jumlah_en' value='".(($jumlah_en/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_er' value='".(($jumlah_er/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_es' value='".(($jumlah_es/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_et' value='".(($jumlah_et/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_est' value='".(($jumlah_est/$jumlah_ambil)*100)."' />

                    <input type='hidden' id='jumlah_dn' value='".(($jumlah_dn/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dr' value='".(($jumlah_dr/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_ds' value='".(($jumlah_ds/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dt' value='".(($jumlah_dt/$jumlah_ambil)*100)."' />
                    <input type='hidden' id='jumlah_dst' value='".(($jumlah_dst/$jumlah_ambil)*100)."' />
					";
					} else {
					echo "
					<input type='hidden' id='jumlah_sn' value='0' />
                    <input type='hidden' id='jumlah_sr' value='0' />
                    <input type='hidden' id='jumlah_ss' value='0' />
                    <input type='hidden' id='jumlah_st' value='0' />
                    <input type='hidden' id='jumlah_sst' value='0' />
                        
                    <input type='hidden' id='jumlah_en' value='0' />
                    <input type='hidden' id='jumlah_er' value='0' />
                    <input type='hidden' id='jumlah_es' value='0' />
                    <input type='hidden' id='jumlah_et' value='0' />
                    <input type='hidden' id='jumlah_est' value='0' />

                    <input type='hidden' id='jumlah_dn' value='0' />
                    <input type='hidden' id='jumlah_dr' value='0' />
                    <input type='hidden' id='jumlah_ds' value='0' />
                    <input type='hidden' id='jumlah_dt' value='0' />
                    <input type='hidden' id='jumlah_dst' value='0' />
					";							
					}//end if                 
        } else {
            echo 'tiada data';
        }//end if     
    }//end method....
    
    function status_jana_ulang(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua($jenis_fasiliti,$fasiliti,$penempatan);    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan):0;
            $papar_ulang = ($jumlah_ulang>0)? "<button id='papar_ulang' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>4.</div></td><td>Ulang Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td><td><div align='center'>".$papar_ulang."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
	
    function status_jana_ulang2(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua2($jenis_fasiliti,$fasiliti,$penempatan);    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil2($id_ambilan,$jenis_fasiliti,$fasiliti):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum2($id_ambilan,$jenis_fasiliti,$fasiliti):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang2($id_ambilan,$jenis_fasiliti,$fasiliti):0;
            $papar_ulang = ($jumlah_ulang>0)? "<button id='papar_ulang' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>-</div></td></tr>
							<tr><td><div align='right'>4.</div></td><td>Ulang Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td><td><div align='center'>".$papar_ulang."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function status_jana_ulang5(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua5($jenis_fasiliti);    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil5($id_ambilan,$jenis_fasiliti):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum5($id_ambilan,$jenis_fasiliti):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang5($id_ambilan,$jenis_fasiliti):0;
            $papar_ulang = ($jumlah_ulang>0)? "<button id='papar_ulang' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>-</div></td></tr>
							<tr><td><div align='right'>4.</div></td><td>Ulang Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td><td><div align='center'>".$papar_ulang."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function status_jana_ulang6(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jumlah_semua= $this->Tbl_ujian_model->get_count_semua6();    
        
        if($jumlah_semua>0){
            $jumlah_ambil= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ambil6($id_ambilan):0;         
            $jumlah_belum= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_belum6($id_ambilan):0;
            $jumlah_ulang= ($jumlah_semua>0)? $this->Tbl_ujian_model->get_count_ulang6($id_ambilan):0;
            $papar_ulang = ($jumlah_ulang>0)? "<button id='papar_ulang' class='btn btn-grey'><i class='icon icon-list icon-black'></i> Papar</button>":'-';
            echo "<div align='center' style='padding:0px 300px 0px 300px !important;'>                                
                    <table border=1 class='table table-condensed table-bordered table-striped table-hover'>
                        <thead><tr><th><div align='center'>Bil.</div></th><th>Perkara</th><th><div align='center'>Jumlah</div></th><th><div align='center'>Tindakan</div></th></tr></thead>
                        <tbody>
                            <tr><td><div align='right'>1.</div></td><td>Pengguna Berdaftar</td><td><div align='center'><b>".$jumlah_semua."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>2.</div></td><td>Selesai Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ambil."</b></div></td><td><div align='center'>-</div></td></tr>
                            <tr><td><div align='right'>3.</div></td><td>Belum Menduduki Ujian</td><td><div align='center'><b>".$jumlah_belum."</b></div></td><td><div align='center'>-</div></td></tr>
							<tr><td><div align='right'>4.</div></td><td>Ulang Menduduki Ujian</td><td><div align='center'><b>".$jumlah_ulang."</b></div></td><td><div align='center'>".$papar_ulang."</div></td></tr>
                        </tbody>    
                    </table>
                </div> ";
        } else {
            echo 'tiada data';
        }    
    }//end method...
    
    function siri(){
        $ujian = $this->input->post('ujian');
        $data = $this->Eminda_model->get_data_dependence('ambilan',array('kodUjian'=>$ujian));
        echo '<div class="control-group">';
        echo '<label class="control-label" for="siri">Siri/Tahun Ujian <span style="color:red"> * </span></label>';
        echo '<div class="controls">';
        echo '<select class="input-small" style="width:auto" id="siri">';
        echo '<option selected="selected" value="" >-- Sila Pilih --</option>';
        foreach ($data as $value) { echo '<option value="'.$value['siri'].'/'.$value['tahun'].'-'.$value['idAmbilan'].'">'.$value['siri'].'/'.$value['tahun'].'</option>'; }
        echo '</select></div></div>';
    }//end method...
    
    function lokasi_bertugas(){
		$mykad = $this->_ci->session->userdata('username');
        $peranan = $this->Tbl_pengguna_model->get_peranan($mykad);
        $lokaliti = $this->Tbl_pengguna_model->get_lokaliti($mykad);
		$jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $data = ($peranan=='2')? 
			$this->Tbl_kodfasiliti_model->getData($jenis_fasiliti):
			//$this->Tbl_kodfasiliti_model->getData_admin($jenis_fasiliti,$lokaliti);				
			$this->Tbl_kodfasiliti_model->getData_admin($jenis_fasiliti,'11-08040017');
		
		echo '<div class="control-group">';
        echo '<label class="control-label" for="fasiliti">Lokasi Bertugas </label>';
        echo '<div class="controls">';
        echo '<select style="width:auto" class="input-xlarge" id="fasiliti">';
        echo '<option selected="selected" value="">-- Sila Pilih --</option>';
        foreach ($data as $value) { 
			echo '<option value="'.$value['kodFasiliti'].'">'.$value['perihalFasiliti'].'</option>'; 
		}
        echo '</select></div></div>';
		
		//echo $data;		
    }//end method...
    
    function penempatan(){
        $fasiliti = $this->input->post('fasiliti');
        $data = $this->Tbl_padananfp_model->getData($fasiliti);        
        echo '<div class="control-group">';
        echo '<label class="control-label" for="penempatan">Penempatan </label>';
        echo '<div class="controls">';
        echo '<select style="width:auto" class="input-xlarge" id="penempatan">';
        echo '<option selected="selected" value="">-- Sila Pilih --</option>';
        foreach ($data as $value) { echo '<option value="'.$value['penempatan'].'">'.$value['perihalPenempatan'].'</option>'; }
        echo '</select></div></div>';
    }//end method...
    
    function get_count_status($ujian) {
        $this->db->select('*');
        $this->db->from('ujian');  
        $this->db->where('kodUjian',$ujian);        
        return $this->db->count_all_results();
    }//end method... 
    
    //senarai pengguna telah ambil ujian
    function senarai_ambil(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');
                
        $users = $this->Tbl_ujian_model->get_list_ambil($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(
            array(
                array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), 
                array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), 
                array('data'=>'No. MyKad','width'=>'30px', 'class'=>'text-center'), 
                array('data'=>'Jantina','width'=>'30px', 'class'=>'text-center'),
				array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'),
				array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'),
                array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...    
    
    //senarai pengguna telah ambil ujian
    function senarai_ambil2(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
                
        $users = $this->Tbl_ujian_model->get_list_ambil2($id_ambilan, $jenis_fasiliti, $fasiliti); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...   
    
    //senarai pengguna telah ambil ujian
    function senarai_ambil3(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
                
        $users = $this->Tbl_ujian_model->get_list_ambil5($id_ambilan, $jenis_fasiliti); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...  
    
    //senarai pengguna telah ambil ujian
    function senarai_ambil5(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
                
        $users = $this->Tbl_ujian_model->get_list_ambil5($id_ambilan, $jenis_fasiliti); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...
    //
    //senarai pengguna telah ambil ujian
    function senarai_ambil6(){         
        $id_ambilan = $this->input->post('id_ambilan');
                
        $users = $this->Tbl_ujian_model->get_list_ambil6($id_ambilan); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...
    
    //senarai pengguna telah ambil ujian
    function senarai_belum(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');        
        $users = $this->Tbl_ujian_model->get_list_belum($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan);    
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic2">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));              
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array( array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));      
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Belum Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic2').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method... 
    
    //senarai pengguna telah ambil ujian
    function senarai_belum2(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        
        $users = $this->Tbl_ujian_model->get_list_belum2($id_ambilan, $jenis_fasiliti, $fasiliti);    
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic2">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));              
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array( array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Belum Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic2').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method... 
    
    //senarai pengguna telah ambil ujian
    function senarai_belum5(){        
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        
        $users = $this->Tbl_ujian_model->get_list_belum5($id_ambilan, $jenis_fasiliti);    
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic2">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));              
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array( array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Belum Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic2').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method... 
    
    //senarai pengguna telah ambil ujian
    function senarai_belum6(){        
        $id_ambilan = $this->input->post('id_ambilan');
        
        $users = $this->Tbl_ujian_model->get_list_belum6($id_ambilan);    
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic2">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));              
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array( array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));     
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Belum Selesai Menduduki Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic2').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...
    
    //senarai pengguna telah ambil ujian
    function senarai_ulang(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');
                
        $users = $this->Tbl_ujian_model->get_list_ulang($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'), array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'), array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'), array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));              
        $bil = 1;
        foreach ($users as $val) {
            $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'), $val['nama'], $val['mykad'], $val['perihalJantina'], $val['perihalJenisFasiliti'], $val['perihalFasiliti'], $val['perihalPenempatan']));      
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Mengulangi Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...    
    
    //senarai pengguna telah ambil ujian
    function senarai_ulang2(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
                
        $users = $this->Tbl_ujian_model->get_list_ulang2($id_ambilan, $jenis_fasiliti, $fasiliti); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'),array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'),array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'),array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {         	
			$this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'),$val['nama'],$val['mykad'],$val['perihalJantina'],$val['perihalJenisFasiliti'],$val['perihalFasiliti'],$val['perihalPenempatan']));      
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Mengulangi Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method... 
    
    //senarai pengguna telah ambil ujian
    function senarai_ulang5(){         
        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
                
        $users = $this->Tbl_ujian_model->get_list_ulang5($id_ambilan, $jenis_fasiliti); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'),array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'),array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'),array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {         	
			$this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'),$val['nama'],$val['mykad'],$val['perihalJantina'],$val['perihalJenisFasiliti'],$val['perihalFasiliti'],$val['perihalPenempatan']));      
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Mengulangi Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...
    
    //senarai pengguna telah ambil ujian
    function senarai_ulang6(){         
        $id_ambilan = $this->input->post('id_ambilan');
                
        $users = $this->Tbl_ujian_model->get_list_ulang6($id_ambilan); 
        $this->table->set_template(array('table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">'));
        $this->table->set_heading(array(array('data'=>'Bil.', 'width'=>'20px', 'class'=>'text-center'), array('data'=>'Nama', 'width'=>'110px', 'class'=>'text-center'), array('data'=>'No. MyKad','width'=>'50px', 'class'=>'text-center'), array('data'=>'Jantina','width'=>'50px', 'class'=>'text-center'),array('data'=>'Fasiliti','width'=>'80px', 'class'=>'text-center'),array('data'=>'Lokasi Bertugas','width'=>'80px', 'class'=>'text-center'),array('data'=>'Penempatan','width'=>'80px', 'class'=>'text-center')));             
        $bil = 1;
        foreach ($users as $val) {         	
                $this->table->add_row(array(array('data'=>$bil,'class'=>'text-center'),$val['nama'],$val['mykad'],$val['perihalJantina'],$val['perihalJenisFasiliti'],$val['perihalFasiliti'],$val['perihalPenempatan']));      
            $bil++;
        }        
        echo '<div style="margin:0px 100px 0px 100px;">';
        echo '<h5>Senarai Mengulangi Ujian</h5>';
        echo $this->table->generate();         
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ rekod per halaman"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ 0 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>";  
        echo '</div>';
    }//end method...
    
    public function jana_laporan_ambil(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $fasiliti = $this->input->get('fasiliti'); 
        $penempatan = $this->input->get('penempatan');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        $nama_fasiliti = $this->Tbl_kodfasiliti_model->get_perihal($fasiliti);
        $nama_penempatan = $this->Tbl_kodpenempatan_model->get_perihal($penempatan);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Telah Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Telah Selesai Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', $nama_fasiliti)->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ambil3($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan);
	foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengambil_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    public function jana_laporan_ambil2(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $fasiliti = $this->input->get('fasiliti');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        $nama_fasiliti = $this->Tbl_kodfasiliti_model->get_perihal($fasiliti);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Telah Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Telah Selesai Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', $nama_fasiliti)->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ambil4($id_ambilan, $jenis_fasiliti, $fasiliti);
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengambil_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method..
    
    public function jana_laporan_ambil5(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Telah Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Telah Selesai Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', '-')->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ambil5($id_ambilan, $jenis_fasiliti);
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengambil_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method..
    
    public function jana_laporan_ambil6(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Telah Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Telah Selesai Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', '-')->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', '-')->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ambil6($id_ambilan);
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengambil_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method..
    
    function jana_laporan_belum(){          
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $fasiliti = $this->input->get('fasiliti'); 
        $penempatan = $this->input->get('penempatan');         
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        $nama_fasiliti = $this->Tbl_kodfasiliti_model->get_perihal($fasiliti);
        $nama_penempatan = $this->Tbl_kodpenempatan_model->get_perihal($penempatan);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Belum Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Belum Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', $nama_fasiliti)->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', $nama_penempatan)->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Fasiliti')->mergeCells('J9:M9')->getStyle('J9:M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('N9','Lokasi Bertugas')->mergeCells('N9:Q9')->getStyle('N9:Q9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('R9','Penempatan')->mergeCells('R9:U9')->getStyle('R9:U9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_belum($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan);    
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('J'.($i+9).':M'.($i+9))->getStyle('J'.($i+9).':M'.($i+9))->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->setCellValue('N'.($i+9),$val['perihalFasiliti'])->mergeCells('N'.($i+9).':Q'.($i+9))->getStyle('N'.($i+9).':Q'.($i+9))->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->setCellValue('R'.($i+9),$val['perihalPenempatan'])->mergeCells('R'.($i+9).':U'.($i+9))->getStyle('R'.($i+9).':U'.($i+9))->getAlignment()->setWrapText(true);
            $i++;            
        }       
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Belum_Menduduki_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...      
    
    function jana_laporan_belum2(){          
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $fasiliti = $this->input->get('fasiliti');         
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        $nama_fasiliti = $this->Tbl_kodfasiliti_model->get_perihal($fasiliti);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Belum Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Belum Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:M1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', $nama_fasiliti)->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Fasiliti')->mergeCells('J9:M9')->getStyle('J9:M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('N9','Lokasi Bertugas')->mergeCells('N9:Q9')->getStyle('N9:Q9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('R9','Penempatan')->mergeCells('R9:U9')->getStyle('R9:U9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_belum2($id_ambilan, $jenis_fasiliti, $fasiliti);    
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('J'.($i+9).':M'.($i+9))->getStyle('J'.($i+9).':M'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('N'.($i+9),$val['perihalFasiliti'])->mergeCells('N'.($i+9).':Q'.($i+9))->getStyle('N'.($i+9).':Q'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('R'.($i+9),$val['perihalPenempatan'])->mergeCells('R'.($i+9).':U'.($i+9))->getStyle('R'.($i+9).':U'.($i+9))->getAlignment()->setWrapText(true);
            $i++;            
        }       
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Belum_Menduduki_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...  
    
    function jana_laporan_belum5(){          
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Belum Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Belum Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:M1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', '-')->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Fasiliti')->mergeCells('J9:M9')->getStyle('J9:M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('N9','Lokasi Bertugas')->mergeCells('N9:Q9')->getStyle('N9:Q9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('R9','Penempatan')->mergeCells('R9:U9')->getStyle('R9:U9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_belum5($id_ambilan, $jenis_fasiliti);    
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('J'.($i+9).':M'.($i+9))->getStyle('J'.($i+9).':M'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('N'.($i+9),$val['perihalFasiliti'])->mergeCells('N'.($i+9).':Q'.($i+9))->getStyle('N'.($i+9).':Q'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('R'.($i+9),$val['perihalPenempatan'])->mergeCells('R'.($i+9).':U'.($i+9))->getStyle('R'.($i+9).':U'.($i+9))->getAlignment()->setWrapText(true);
            $i++;            
        }       
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Belum_Menduduki_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    function jana_laporan_belum6(){          
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Belum Ambil');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Belum Menduduki Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:M1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', '-')->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', '-')->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Fasiliti')->mergeCells('J9:M9')->getStyle('J9:M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('N9','Lokasi Bertugas')->mergeCells('N9:Q9')->getStyle('N9:Q9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('R9','Penempatan')->mergeCells('R9:U9')->getStyle('R9:U9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_belum6($id_ambilan);    
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('J'.($i+9).':M'.($i+9))->getStyle('J'.($i+9).':M'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('N'.($i+9),$val['perihalFasiliti'])->mergeCells('N'.($i+9).':Q'.($i+9))->getStyle('N'.($i+9).':Q'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('R'.($i+9),$val['perihalPenempatan'])->mergeCells('R'.($i+9).':U'.($i+9))->getStyle('R'.($i+9).':U'.($i+9))->getAlignment()->setWrapText(true);
            $i++;            
        }       
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Belum_Menduduki_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    public function jana_laporan_ulang(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $fasiliti = $this->input->get('fasiliti'); 
        $penempatan = $this->input->get('penempatan');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        $nama_fasiliti = $this->Tbl_kodfasiliti_model->get_perihal($fasiliti);
        $nama_penempatan = $this->Tbl_kodpenempatan_model->get_perihal($penempatan);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Ulang Ujian');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Perlu Mengulangi Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', $nama_fasiliti)->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ulang3($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan);
	foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengulangi_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    public function jana_laporan_ulang2(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $fasiliti = $this->input->get('fasiliti');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        $nama_fasiliti = $this->Tbl_kodfasiliti_model->get_perihal($fasiliti);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Ulang Ujian');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Perlu Mengulangi Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', $nama_fasiliti)->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ulang4($id_ambilan, $jenis_fasiliti, $fasiliti);
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengulangi_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    public function jana_laporan_ulang5(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        $jenis_fasiliti = $this->input->get('jenis_fasiliti');
        $nama_jenis_fasiliti = $this->Tbl_kodjenisfasiliti_model->get_perihal($jenis_fasiliti);
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Ulang Ujian');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Perlu Mengulangi Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', $nama_jenis_fasiliti)->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', '-')->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ulang5($id_ambilan, $jenis_fasiliti);
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengulangi_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    public function jana_laporan_ulang6(){      
        $ujian = $this->input->get('ujian');
        $siri = $this->input->get('siri');
        $id_ambilan = $this->input->get('id_ambilan');
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Senarai Ulang Ujian');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Senarai Pengguna Yang Perlu Mengulangi Ujian');
        $this->excel->getActiveSheet()->mergeCells('A1:H1')->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A3', 'Nama Ujian')->mergeCells('A3:B3')->setCellValue('C3', $ujian)->mergeCells('C3:H3');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Siri/Tahun Ujian')->mergeCells('A4:B4')->setCellValue('C4', $siri)->mergeCells('C4:H4');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Jenis Fasiliti')->mergeCells('A5:B5')->setCellValue('C5', '-')->mergeCells('C5:H5');
        $this->excel->getActiveSheet()->setCellValue('A6', 'Lokasi Bertugas')->mergeCells('A6:B6')->setCellValue('C6', '-')->mergeCells('C6:H6');
        $this->excel->getActiveSheet()->setCellValue('A7', 'Penempatan ')->mergeCells('A7:B7')->setCellValue('C7', '-')->mergeCells('C7:H7');
        $this->excel->getActiveSheet()->setCellValue('A9','Bil.')->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B9','Nama')->mergeCells('B9:E9')->getStyle('B9:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F9','No. MyKad')->mergeCells('F9:G9')->getStyle('F9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('H9','Jantina')->mergeCells('H9:I9')->getStyle('H9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('J9','Emel')->mergeCells('J9:L9')->getStyle('J9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('M9','Jawatan')->mergeCells('M9:O9')->getStyle('M9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('P9','Gred')->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Q9','Fasiliti')->mergeCells('Q9:T9')->getStyle('Q9:T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('U9','Lokasi Bertugas')->mergeCells('U9:X9')->getStyle('U9:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('Y9','Penempatan')->mergeCells('Y9:AB9')->getStyle('Y9:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AC9','Tarikh Ujian')->mergeCells('AC9:AD9')->getStyle('AC9:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AE9','MarkahS1')->getStyle('AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AF9','MarkahS2')->getStyle('AF9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AG9','MarkahS3')->getStyle('AG9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AH9','MarkahS4')->getStyle('AH9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AI9','MarkahS5')->getStyle('AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AJ9','MarkahS6')->getStyle('AJ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AK9','MarkahS7')->getStyle('AK9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AL9','MarkahS8')->getStyle('AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AM9','MarkahS9')->getStyle('AM9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AN9','MarkahS10')->getStyle('AN9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AO9','MarkahS11')->getStyle('AO9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AP9','MarkahS12')->getStyle('AP9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AQ9','MarkahS13')->getStyle('AQ9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AR9','MarkahS14')->getStyle('AR9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AS9','MarkahS15')->getStyle('AS9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AT9','MarkahS16')->getStyle('AT9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AU9','MarkahS17')->getStyle('AU9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AV9','MarkahS18')->getStyle('AV9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AW9','MarkahS19')->getStyle('AW9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AX9','MarkahS20')->getStyle('AX9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AY9','MarkahS21')->getStyle('AY9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('AZ9','Tekanan')->mergeCells('AZ9:BA9')->getStyle('AZ9:BA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BB9','Kebimbangan')->mergeCells('BB9:BC9')->getStyle('BB9:BC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('BD9','Kemurungan')->mergeCells('BD9:BE9')->getStyle('BD9:BE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Loop Result
        $i=1;
        $users = $this->Tbl_ujian_model->get_list_ulang6($id_ambilan);
        foreach($users as $val){
            $this->excel->getActiveSheet()->setCellValue('A'.($i+9),$i);
            $this->excel->getActiveSheet()->setCellValue('B'.($i+9),$val['nama'])->mergeCells('B'.($i+9).':E'.($i+9))->getStyle('B'.($i+9).':E'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.($i+9),$val['mykad'], PHPExcel_Cell_DataType::TYPE_STRING)->mergeCells('F'.($i+9).':G'.($i+9))->getStyle('F'.($i+9).':G'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('H'.($i+9),$val['perihalJantina'])->mergeCells('H'.($i+9).':I'.($i+9))->getStyle('H'.($i+9).':I'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('J'.($i+9),$val['emel'])->mergeCells('J'.($i+9).':L'.($i+9))->getStyle('J'.($i+9).':L'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('M'.($i+9),$val['perihalSkim'])->mergeCells('M'.($i+9).':O'.($i+9))->getStyle('M'.($i+9).':O'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('P'.($i+9),$val['gred'])->getStyle('P'.($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('Q'.($i+9),$val['perihalJenisFasiliti'])->mergeCells('Q'.($i+9).':T'.($i+9))->getStyle('Q'.($i+9).':T'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('U'.($i+9),$val['perihalFasiliti'])->mergeCells('U'.($i+9).':X'.($i+9))->getStyle('U'.($i+9).':X'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('Y'.($i+9),$val['perihalPenempatan'])->mergeCells('Y'.($i+9).':AB'.($i+9))->getStyle('Y'.($i+9).':AB'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AC'.($i+9),$val['tarikhUjian'])->mergeCells('AC'.($i+9).':AD'.($i+9))->getStyle('AC'.($i+9).':AD'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AE'.($i+9),$val['MarkahS1'])->getStyle('AE'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AF'.($i+9),$val['MarkahS2'])->getStyle('AF'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AG'.($i+9),$val['MarkahS3'])->getStyle('AG'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AH'.($i+9),$val['MarkahS4'])->getStyle('AH'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AI'.($i+9),$val['MarkahS5'])->getStyle('AI'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AJ'.($i+9),$val['MarkahS6'])->getStyle('AJ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AK'.($i+9),$val['MarkahS7'])->getStyle('AK'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AL'.($i+9),$val['MarkahS8'])->getStyle('AL'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AM'.($i+9),$val['MarkahS9'])->getStyle('AM'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AN'.($i+9),$val['MarkahS10'])->getStyle('AN'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AO'.($i+9),$val['MarkahS11'])->getStyle('AO'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AP'.($i+9),$val['MarkahS12'])->getStyle('AP'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AQ'.($i+9),$val['MarkahS13'])->getStyle('AQ'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AR'.($i+9),$val['MarkahS14'])->getStyle('AR'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AS'.($i+9),$val['MarkahS15'])->getStyle('AS'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AT'.($i+9),$val['MarkahS16'])->getStyle('AT'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AU'.($i+9),$val['MarkahS17'])->getStyle('AU'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AV'.($i+9),$val['MarkahS18'])->getStyle('AV'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AW'.($i+9),$val['MarkahS19'])->getStyle('AW'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AX'.($i+9),$val['MarkahS20'])->getStyle('AX'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AY'.($i+9),$val['MarkahS21'])->getStyle('AY'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('AZ'.($i+9),$val['skor3'].' ('.$this->papar_keputusan_stress($val['skor3']).')')->mergeCells('AZ'.($i+9).':BA'.($i+9))->getStyle('AZ'.($i+9).':BA'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BB'.($i+9),$val['skor2'].' ('.$this->papar_keputusan_enxiety($val['skor2']).')')->mergeCells('BB'.($i+9).':BC'.($i+9))->getStyle('BB'.($i+9).':BC'.($i+9))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->setCellValue('BD'.($i+9),$val['skor1'].' ('.$this->papar_keputusan_depression($val['skor1']).')')->mergeCells('BD'.($i+9).':BE'.($i+9))->getStyle('BD'.($i+9).':BE'.($i+9))->getAlignment()->setWrapText(true);
            $i++;
        }     
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Senarai_Mengulangi_Ujian_eMINDA.xls"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');                
    }//end method...
    
    private function papar_keputusan_depression($skor1){
        //kira jenis keputusan markah		
        switch(true){
            case in_array($skor1, range(0,5)): $keputusan= 'NORMAL'; break;
            case in_array($skor1, range(6,7)): $keputusan= 'RINGAN'; break;
            case in_array($skor1, range(8,10)): $keputusan= 'SEDERHANA'; break;
            case in_array($skor1, range(11,14)): $keputusan= 'TERUK'; break;
            case ($skor1 >= 15 ): $keputusan= 'SANGAT TERUK'; break;
        }
        return $keputusan;	
    }

    private function papar_keputusan_enxiety($skor2){
        //kira jenis keputusan markah
        switch($skor2){
            case in_array($skor2, range(0,4)): $keputusan= 'NORMAL'; break;
            case in_array($skor2, range(5,6)): $keputusan= 'RINGAN'; break;
            case in_array($skor2, range(7,8)): $keputusan= 'SEDERHANA'; break;
            case in_array($skor2, range(9,10)): $keputusan= 'TERUK'; break;
            case ($skor2 >= 11 ): $keputusan= 'SANGAT TERUK'; break;
        }		
        return $keputusan;	
    }
	
    private function papar_keputusan_stress($skor3){
        //kira jenis keputusan markah
        switch($skor3){
            case in_array($skor3, range(0,7)): $keputusan= 'NORMAL'; break;
            case in_array($skor3, range(8,9)): $keputusan= 'RINGAN'; break;
            case in_array($skor3, range(10,13)): $keputusan= 'SEDERHANA'; break;
            case in_array($skor3, range(14,17)): $keputusan= 'TERUK'; break;
            case ($skor3 >= 18 ): $keputusan= 'SANGAT TERUK'; break;
        }		
        return $keputusan;	
    }
	
    function hantar_notis(){     	
        $mykad = $this->_ci->session->userdata('username');
        $lokaliti = $this->Tbl_pengguna_model->get_lokaliti($mykad);
        $exist_peringatan = $this->Tbl_notisperingatan_model->check_exist($lokaliti);
        $exist_penerima = $this->Tbl_penerimanotis_model->check_exist($lokaliti);
                
        if($exist_penerima>0 && $exist_peringatan>0){            
            $tajuk = $this->Tbl_notisperingatan_model->get_tajuk($mykad);
            $notis = $this->Tbl_notisperingatan_model->get_notis($mykad);            
            $bil_penerima= $this->Tbl_penerimanotis_model->check_exist($lokaliti);
            
            if($bil_penerima==1){
                $namaPN1 = $this->Tbl_penerimanotis_model->get_namaPN1($lokaliti); 
                $emelPN1 = $this->Tbl_penerimanotis_model->get_emelPN1($lokaliti); 
                $kepada = '<tr><td>Kepada</td><td>:</td><td><b>'.$namaPN1.' ('.$emelPN1.')</b></td></tr>';
            } else {
                $namaPN1 = $this->Tbl_penerimanotis_model->get_namaPN1($lokaliti); 
                $emelPN1 = $this->Tbl_penerimanotis_model->get_emelPN1($lokaliti); 
                $namaPN2 = $this->Tbl_penerimanotis_model->get_namaPN2($lokaliti,$emelPN1);
                $emelPN2 = $this->Tbl_penerimanotis_model->get_emelPN2($lokaliti,$emelPN1);
                
                if ($emelPN2 == $emelPN1){
                    $penerima_kedua = '-';
                } else {
                    $penerima_kedua = $namaPN2.' ('.$emelPN2.')';
                }
                
                $kepada = '<tr><td>Kepada</td><td>:</td><td><b>'.$namaPN1.' ('.$emelPN1.')</b></td></tr>'
                        . '<tr><td>Salinan</td><td>:</td><td><b>'.$penerima_kedua.'</b></td></tr>';
            }//end if

            $id_ambilan = $this->input->post('id_ambilan');
            $jenis_fasiliti = $this->input->post('jenis_fasiliti');
            $fasiliti = $this->input->post('fasiliti'); 
            $penempatan = $this->input->post('penempatan');        
            //$users = ($penempatan!='')? 
            if($jenis_fasiliti && $fasiliti && $penempatan){
                $users = $this->Tbl_ujian_model->get_list_belum($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan);
            } elseif($jenis_fasiliti && $fasiliti && !$penempatan){    
                $users = $this->Tbl_ujian_model->get_list_belum2($id_ambilan, $jenis_fasiliti, $fasiliti);
            } elseif($jenis_fasiliti && !$fasiliti && !$penempatan){    
                $users = $this->Tbl_ujian_model->get_list_belum5($id_ambilan, $jenis_fasiliti);
            } elseif(!$jenis_fasiliti && !$fasiliti && !$penempatan){    
                $users = $this->Tbl_ujian_model->get_list_belum6($id_ambilan);
            }
            
            echo '
                <style>
                    .table-curved {border-collapse:separate;border: solid #ccc 1px;border-radius: 5px;}
                    .table-curved tr:last-child td {border-bottom-left-radius: 5px;border-bottom-right-radius: 5px; }
                    .table-curved tr{
                        background: #b8d1f3;
                    }
                    .table-curved tr:nth-child(odd){ 
                        background: #b8d1f3;
                    }
                    .table-curved tr:nth-child(even){
                            background: #dae5f4;
                    }
                </style>
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Penghantaran Notis</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                            <table width="100%" >
                                '.$kepada.'
                                <tr><td>Tajuk</td><td>:</td><td><b>'.$tajuk.'</b></td></tr>
                                <tr><td colspan="3"><hr style="margin-bottom:2px;" /></td></tr>
                                <tr><td colspan="3"><pre style="margin:0px auto; font-family:inherit; border:0; background-color:#FFF">'.$notis.'</pre></td></tr>					
                                <tr><td colspan="3">
                                    <table align="center" class="table table-curved" style="font-size:11px;margin:0 30 0 30;">
                                        <thead>
                                        <tr style="background-color:#FFFF99">
                                            <th>Bil</th><th>Nama</th><th>No. Mykad</th><th>Jantina</th><th>Penempatan</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
                                        $bil=1;
                                        foreach ($users as $val) {
                                            echo '<tr><td>'.$bil.'</td>'
                                                    . '<td>'.$val["nama"].'</td>'
                                                    . '<td>'.$val["mykad"].'</td>'
                                                    . '<td>'.$val["perihalJantina"].'</td>'
                                                    . '<td>'.$val["perihalPenempatan"].'</td>'
                                                    . '</tr>';	
                                            $bil++;                                        
                                        }
                                    echo '</tbody></table>	
                                </td></tr>
                                <tr><td colspan="3"><b>Pentadbir eMINDA</b></td></tr>	
                            </table>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_jana_hantar_notis" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Hantar</button>
                            <button class="btn btn-orange" data-dismiss="modal"><i class="icon icon-plus icon-white"></i> Batal</button>
                        </div>
                    </div>
            </div>';
        } else {
            if ($exist_penerima < 1 && $exist_peringatan < 1){
                echo '<div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Penghantaran Notis</h4>
                            </div>
                            <div class="modal-body">
                                <pre style="color:red;font-family:inherit; border:0; background-color:#FFF">Harap maaf, proses penghantaran gagal dilaksanakan kerana tiada tetapan notis peringatan dan emel penerima notis (atau penerima notis adalah tidak aktif).<br/>Sila buat penetapan notis dan emel di dalam Modul Selenggara Notis terlebih dahulu.</pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-orange" data-dismiss="modal"><i class="icon icon-plus icon-white"></i> Batal</button>
                            </div>
                        </div>
                </div>';
            } else if ($exist_penerima < 1 && $exist_peringatan > 0){
                echo '<div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Penghantaran Notis</h4>
                            </div>
                            <div class="modal-body">
                                <pre style="color:red;font-family:inherit; border:0; background-color:#FFF">Harap maaf, proses penghantaran gagal dilaksanakan kerana tiada tetapan emel penerima notis  (atau penerima notis adalah tidak aktif).<br/>Sila buat penetapan emel di dalam Modul Selenggara Notis terlebih dahulu.</pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-orange" data-dismiss="modal"><i class="icon icon-plus icon-white"></i> Batal</button>
                            </div>
                        </div>
                </div>';
            } else if ($exist_penerima > 0 && $exist_peringatan < 1){
                echo '<div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Penghantaran Notis</h4>
                            </div>
                            <div class="modal-body">
                                <pre style="color:red;font-family:inherit; border:0; background-color:#FFF">Harap maaf, proses penghantaran gagal dilaksanakan kerana tiada tetapan notis peringatan.<br/>Sila buat penetapan notis peringatan di dalam Modul Selenggara Notis terlebih dahulu.</pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-orange" data-dismiss="modal"><i class="icon icon-plus icon-white"></i> Batal</button>
                            </div>
                        </div>
                </div>';
            }//end if...
        }//end if...
    }//end method...  
	
    public function jana_hantar_notis() {        
        $mykad = $this->_ci->session->userdata('username');
        $lokaliti = $this->Tbl_pengguna_model->get_lokaliti($mykad);
        $tajuk = $this->Tbl_notisperingatan_model->get_tajuk($mykad);
        $notis = $this->Tbl_notisperingatan_model->get_notis($mykad);
        $bil_penerima= $this->Tbl_penerimanotis_model->check_exist($lokaliti);
        if($bil_penerima==1){
            $emelPN1 = $this->Tbl_penerimanotis_model->get_emelPN1($lokaliti); 
            $emelPN2 = '';
        } else {
            $emelPN1 = $this->Tbl_penerimanotis_model->get_emelPN1($lokaliti); 
            $emelPN2 = $this->Tbl_penerimanotis_model->get_emelPN2($lokaliti,$emelPN1);
        }

        $id_ambilan = $this->input->post('id_ambilan');
        $jenis_fasiliti = $this->input->post('jenis_fasiliti');
        $fasiliti = $this->input->post('fasiliti'); 
        $penempatan = $this->input->post('penempatan');        
        //$users = ($penempatan!='')? 
        if($jenis_fasiliti && $fasiliti && $penempatan){
            $users = $this->Tbl_ujian_model->get_list_belum($id_ambilan, $jenis_fasiliti, $fasiliti, $penempatan);
        } elseif($jenis_fasiliti && $fasiliti && !$penempatan){    
            $users = $this->Tbl_ujian_model->get_list_belum2($id_ambilan, $jenis_fasiliti, $fasiliti);
        } elseif($jenis_fasiliti && !$fasiliti && !$penempatan){    
            $users = $this->Tbl_ujian_model->get_list_belum5($id_ambilan, $jenis_fasiliti);
        } elseif(!$jenis_fasiliti && !$fasiliti && !$penempatan){    
            $users = $this->Tbl_ujian_model->get_list_belum6($id_ambilan);
        }		

        $data = '<table width="100%"  >
                    <tr><td colspan="3"><pre style="font-size:16px;">'.$notis.'</pre></td></tr>
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr><td colspan="3">
                        <table border="1" style="border-style: 1px solid #333">
                            <tr><td>Bil</td><td>Nama</td><td>No. Mykad</td><td>Jantina</td><td>Penempatan</td></tr>';
        $bil=1;
        foreach ($users as $val) {
            $data.= '<tr><td>'.$bil.'</td><td>'.$val["nama"].'</td><td>'.$val["mykad"].'</td><td>'.$val["perihalJantina"].'</td><td>'.$val["perihalPenempatan"].'</td></tr>';	
            $bil++;                                        
        }

        $data.= '</table>	
                    </td></tr>
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr><td colspan="3"><b>Pentadbir eMINDA</b></td></tr>	
                </table>';

        $this->load->library('email');
        $this->email->set_mailtype('html');
        $this->email->from('eminda@moh.gov.my', 'Aplikasi Saringan Minda Sihat');        
        $this->email->to($emelPN1);
        if($bil_penerima>1 && $emelPN2!=$emelPN1){
            $this->email->cc($emelPN2);
        }
        //$this->email->bcc('');
        $this->email->subject($tajuk);		
        $this->email->message($data);	
            $this->email->send();		
        if(!$this->input->is_ajax_request()){
            $this->_render_page($data);
        }        
    }//end method...
}//end class