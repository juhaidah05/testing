<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (1 Ogos 2015)   :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *  (28 Ogos 2015 ) :   1. Tambah method get_count_ulang(), get_count_ulang2(),
 * 			get_list_ulang() dan get_list_ulang2()	
 *  (1 Sept 2015)   :   1. Tambah column Fasiliti dan Lokasi Bertugas pada semua 
 *  					   method untuk paparan senarai pengguna.
 *  (13 Sept 2015)  :	1. Tambah method2:
 *                          1). get_count_ambil_lelaki_teruk_depression(),
 *                          2). get_count_ambil_lelaki_teruk_enxiety(),
 *                          3). get_count_ambil_lelaki_teruk_stress(), 
 *                          4). get_count_ambil_perempuan_teruk_depression(),
 *                          5). get_count_ambil_perempuan_teruk_depression(),
 *			    6). get_count_ambil_perempuan_teruk_depression(),
 *			    7). get_count_ambil2_lelaki_teruk_depression(),
 *			    8). get_count_ambil2_lelaki_teruk_enxiety(),
 *			    9). get_count_ambil2_lelaki_teruk_stress(), 
 *			   10). get_count_ambil2_perempuan_teruk_depression(),
 *			   11). get_count_ambil2_perempuan_teruk_depression(),
 *			   12). get_count_ambil2_perempuan_teruk_depression(), 
 *			   13). get_list_ulang3() dan 
 *             14). get_list_ulang4()
 *                  untuk menyokong/menyediakan data bagi kemudahan janaan statistik/carta. 
 */

class Tbl_ujian_model extends CI_Model {
    private $tableName;
    private $pk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();        
        $this->tableName = "ujian";
        $this->pk = "idUjian";
        $this->created_by = "idWujud";
        $this->created_date = "tarikhWujud";
        $this->updated_by = "idKemaskini";
        $this->updated_date = "tarikhKemaskini";         
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method...
    
    //digunakan untuk memaparkan data...
    public function getData($id) {
        $this->db->select('*');            
        $this->db->where($this->fk,$id); 
        return $this->db->get($this->tableName)->result_array();        
    }//end method...
	
    //digunakan untuk memaparkan data...
    public function getData_carian_sejarah($id) {
        $this->db->select('a.*, b.*');
        $this->db->from('ujian a');
        $this->db->join('ambilan b','a.idAmbilan = b.idAmbilan');
        $this->db->where(array('mykad'=>$id));
        $this->db->order_by("a.idAmbilan","desc");
        return $this->db->get()->result_array();       
    }//end method...
    
    //digunakan untuk mencari data...
    public function findAll($condition='', $page=null) {
        if($page!=null){ $this->db->select('*');  }           
        if($condition!='') { $this->db->where($condition); }
        return $this->db->get($this->tableName)->result_array();
    }//end method...
	
    //digunakan untuk menyimpan data...
    public function save($data=null) {               
        if($data!=null) {
            $this->db->set($this->created_by, $this->session->userdata('username'));
            $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();
        } else {
            return false;
        }//end if
    }//end method...
    
    //digunakan untuk mengemaskini data...
    public function update($id, $data=null) {
        if($data!=null) {
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
        } else {
            return false;
        }//end if
    }//end method...    
    
    //
    function get_count($ujian) {
        $this->db->select('title, content, date');
        $this->db->from('ujian');  
        $this->db->where('kodUjian',$ujian);        
        return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //mengikut jenis fasiliti, fasiliti dan penempatan...
    function get_count_semua($jenis_fasiliti,$fasiliti,$penempatan) {        
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');        
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        return $this->db->count_all_results();
    }//end method...    
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //mengikut jenis fasiliti, fasiliti...
    function get_count_semua2($jenis_fasiliti,$fasiliti) {        
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');        
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        return $this->db->count_all_results();		
    } //end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //mengikut jenis fasiliti...
    function get_count_semua3($jenis_fasiliti) {        
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');        
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        return $this->db->count_all_results();		
    } //end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    function get_count_semua4() {        
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');        
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        return $this->db->count_all_results();		
    } //end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //mengikut jenis fasiliti...
    function get_count_semua5($jenis_fasiliti) {        
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');        
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        return $this->db->count_all_results();		
    } //end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    function get_count_semua6() {        
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');        
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        return $this->db->count_all_results();		
    } //end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {  
        $this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti,'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->count_all_results();
    }//end method...    
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan 
    //mengikut jenis fasiliti... 
    function get_count_ambil3($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian
    function get_count_ambil4($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil5($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian
    function get_count_ambil6($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan depression teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil_lelaki_teruk_depression ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan depression teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil_perempuan_teruk_depression ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1',  'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan enxiety teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil_lelaki_teruk_enxiety ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti,'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan enxiety teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil_perempuan_teruk_enxiety ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan stress teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil_lelaki_teruk_stress ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan stress teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil_perempuan_teruk_stress ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //depression
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression normal dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_depression_normal ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 < 6');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression ringan dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_depression_ringan ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 5 AND d.skor1 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sederhana dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_depression_sederhana ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 7 AND d.skor1 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression teruk dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_depression_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 10 AND d.skor1 < 15');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sangat teruk dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_depression_sangat_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //depression e
    
    //enxiety
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety normal dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_enxiety_normal ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 < 5');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety ringan dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_enxiety_ringan ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 4 AND d.skor2 < 7');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sederhana dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_enxiety_sederhana ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 6 AND d.skor2 < 9');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety teruk dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_enxiety_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 8 AND d.skor2 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sangat teruk dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_enxiety_sangat_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //enxiety e
    
    //stress
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress normal dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_stress_normal ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress ringan dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_stress_ringan ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 7 AND d.skor3 < 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sederhana dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_stress_sederhana ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 9 AND d.skor3 < 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress teruk dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_stress_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 13 AND d.skor3 < 18');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sangat teruk dan
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ambil_stress_sangat_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 17');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //stress e
    
    //mula 2
    //depression
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression normal dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_depression_normal ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 < 6');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression ringan dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_depression_ringan ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 5 AND d.skor1 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sederhana dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_depression_sederhana ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 7 AND d.skor1 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_depression_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 10 AND d.skor1 < 15');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_depression_sangat_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //depression e
    
    //enxiety
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety normal dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_enxiety_normal ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 < 5');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety ringan dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_enxiety_ringan ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 4 AND d.skor2 < 7');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sederhana dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_enxiety_sederhana ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 6 AND d.skor2 < 9');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_enxiety_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 8 AND d.skor2 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_enxiety_sangat_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //enxiety e
    
    //stress
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress normal dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_stress_normal ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress ringan dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_stress_ringan ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 7 AND d.skor3 < 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sederhana dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_stress_sederhana ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 9 AND d.skor3 < 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_stress_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 13 AND d.skor3 < 18');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_stress_sangat_teruk ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 17');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //stress e
    //tamat 2
    
    //mula 3
    //depression
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression normal dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_depression_normal ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 < 6');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression ringan dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_depression_ringan ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 5 AND d.skor1 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sederhana dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_depression_sederhana ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 7 AND d.skor1 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_depression_teruk ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 10 AND d.skor1 < 15');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_depression_sangat_teruk ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //depression e
    
    //enxiety
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety normal dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_enxiety_normal ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 < 5');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety ringan dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_enxiety_ringan ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 4 AND d.skor2 < 7');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sederhana dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_enxiety_sederhana ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 6 AND d.skor2 < 9');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_enxiety_teruk ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 8 AND d.skor2 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_enxiety_sangat_teruk ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //enxiety e
    
    //stress
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress normal dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_stress_normal ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress ringan dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_stress_ringan ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 7 AND d.skor3 < 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sederhana dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_stress_sederhana ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 9 AND d.skor3 < 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_stress_teruk ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 13 AND d.skor3 < 18');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_stress_sangat_teruk ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 17');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //stress e
    //tamat 3
    
    //mula 4
    //depression
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression normal
    function get_count_ambil4_depression_normal ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 < 6');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression ringan
    function get_count_ambil4_depression_ringan ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 5 AND d.skor1 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sederhana
    function get_count_ambil4_depression_sederhana ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 7 AND d.skor1 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression teruk
    function get_count_ambil4_depression_teruk ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 10 AND d.skor1 < 15');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan depression sangat teruk
    function get_count_ambil4_depression_sangat_teruk ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor1 > 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //depression e
    
    //enxiety
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety normal
    function get_count_ambil4_enxiety_normal ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 < 5');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety ringan
    function get_count_ambil4_enxiety_ringan ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 4 AND d.skor2 < 7');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sederhana
    function get_count_ambil4_enxiety_sederhana ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 6 AND d.skor2 < 9');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety teruk
    function get_count_ambil4_enxiety_teruk ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 8 AND d.skor2 < 11');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan enxiety sangat teruk
    function get_count_ambil4_enxiety_sangat_teruk ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor2 > 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //enxiety e
    
    //stress
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress normal
    function get_count_ambil4_stress_normal ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 < 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress ringan
    function get_count_ambil4_stress_ringan ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 7 AND d.skor3 < 10');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sederhana
    function get_count_ambil4_stress_sederhana ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 9 AND d.skor3 < 14');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress teruk 
    function get_count_ambil4_stress_teruk ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 13 AND d.skor3 < 18');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //mempunyai keputusan stress sangat teruk
    function get_count_ambil4_stress_sangat_teruk ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('d.skor3 > 17');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    //stress e
    //tamat 4
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan depression teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_lelaki_teruk_depression ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan depression teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_perempuan_teruk_depression ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan enxiety teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_lelaki_teruk_enxiety ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan enxiety teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_perempuan_teruk_enxiety ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan stress teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_lelaki_teruk_stress ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0,'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan stress teruk/sangat teruk dan
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ambil2_perempuan_teruk_stress ($id_ambilan,$jenis_fasiliti,$fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1',  'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan depression teruk/sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_lelaki_teruk_depression ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan depression teruk/sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_perempuan_teruk_depression ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan enxiety teruk/sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_lelaki_teruk_enxiety ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan enxiety teruk/sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_perempuan_teruk_enxiety ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan stress teruk/sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_lelaki_teruk_stress ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0,'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan stress teruk/sangat teruk dan
    //mengikut jenis fasiliti... 
    function get_count_ambil3_perempuan_teruk_stress ($id_ambilan,$jenis_fasiliti) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1',  'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    ////digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan depression teruk/sangat teruk
    function get_count_ambil4_lelaki_teruk_depression ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan depression teruk/sangat teruk
    function get_count_ambil4_perempuan_teruk_depression ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor1 > 10');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan enxiety teruk/sangat teruk
    function get_count_ambil4_lelaki_teruk_enxiety ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan enxiety teruk/sangat teruk
    function get_count_ambil4_perempuan_teruk_enxiety ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor2 > 8');
        $this->db->where(array('c.status'=>'1','c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah lelaki dan 
    //mempunyai keputusan stress teruk/sangat teruk
    function get_count_ambil4_lelaki_teruk_stress ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','L');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan
    //jantina adalah perempuan dan
    //mempunyai keputusan stress teruk/sangat teruk
    function get_count_ambil4_perempuan_teruk_stress ($id_ambilan) {	    
        $this->db->distinct('a.mykad'); 
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil f', 'f.mykad = a.mykad', 'left');
        $this->db->where('f.jantina','P');
        $this->db->where('d.skor3 > 13');
        $this->db->where(array('c.status'=>'1',  'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();        
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_list_ambil($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
        $this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti... 
    function get_list_ambil2($id_ambilan,$jenis_fasiliti,$fasiliti) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
	$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
	$this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_list_ambil3($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17,SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20,SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
	$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
	$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti,'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
	
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_list_ambil4($id_ambilan,$jenis_fasiliti,$fasiliti) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17, SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20, SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
	$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
	$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1, 'c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian
    //mengikut jenis fasiliti... 
    function get_list_ambil5($id_ambilan,$jenis_fasiliti) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17, SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20, SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
		$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
		$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1, 'c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian
    //mengikut jenis fasiliti... 
    function get_list_ambil6($id_ambilan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17, SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20, SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
	$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
	$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1, 'c.levelAdmin'=>0,'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti dan penempatan...
    function get_count_belum($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->where(array('c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad FROM ujian d WHERE d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->count_all_results();
    }//end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti...
    function get_count_belum2($id_ambilan,$jenis_fasiliti,$fasiliti) {
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->where(array('c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad FROM ujian d WHERE d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->count_all_results();
    }//end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti...
    function get_count_belum3($id_ambilan,$jenis_fasiliti) {
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->where(array('c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad FROM ujian d WHERE d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian
    function get_count_belum4($id_ambilan) {
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->where(array('c.levelAdmin'=>0,'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad FROM ujian d WHERE d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti...
    function get_count_belum5($id_ambilan,$jenis_fasiliti) {
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->where(array('c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad FROM ujian d WHERE d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->count_all_results();
    }//end method... 
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian
    function get_count_belum6($id_ambilan) {
        $this->db->select('a.mykad');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->where(array('c.levelAdmin'=>0,'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad FROM ujian d WHERE d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti dan penempatan...
    function get_list_belum($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
        $this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad from ujian d where d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->get()->result_array();        
    }//end method...    
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti, fasiliti...
    function get_list_belum2($id_ambilan,$jenis_fasiliti,$fasiliti) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
        $this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad from ujian d where d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->get()->result_array();        
    }//end method... 
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian dan 
    //mengikut jenis fasiliti...
    function get_list_belum5($id_ambilan,$jenis_fasiliti) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
        $this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad from ujian d where d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang belum mengambil ujian
    function get_list_belum6($id_ambilan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
        $this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('c.levelAdmin'=>0, 'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1) AND NOT EXISTS (SELECT d.mykad from ujian d where d.idAmbilan ='.$id_ambilan.' AND d.mykad = a.mykad)');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_count_ulang($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {  
	$this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        return $this->db->count_all_results();
    }//end method...
	
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ulang2($id_ambilan,$jenis_fasiliti,$fasiliti) {  
	$this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti... 
    function get_count_ulang3($id_ambilan,$jenis_fasiliti) {  
	$this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    function get_count_ulang4($id_ambilan) {  
	$this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti... 
    function get_count_ulang5($id_ambilan,$jenis_fasiliti) {  
	$this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0, 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan jumlah semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    function get_count_ulang6($id_ambilan) {  
		$this->db->select('a.mykad');      
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->where(array('c.status'=>'1', 'c.levelAdmin'=>0));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->count_all_results();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_list_ulang($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
	$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1','a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti,'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti... 
    function get_list_ulang2($id_ambilan,$jenis_fasiliti,$fasiliti) {
        $this->db->select('a.mykad,e.nama,f.perihalJantina,g.perihalPenempatan,h.perihalJenisFasiliti,i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
	$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
	return $this->db->get()->result_array();	
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti dan penempatan... 
    function get_list_ulang3($id_ambilan,$jenis_fasiliti,$fasiliti,$penempatan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17,SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20,SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
		$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
		$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan,'d.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti, 'a.lokasiBertugas'=>$fasiliti, 'a.penempatan'=>$penempatan));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti, fasiliti... 
    function get_list_ulang4($id_ambilan,$jenis_fasiliti,$fasiliti) {
        $this->db->select('a.mykad,e.nama,f.perihalJantina,a.emel,k.perihalSkim,a.gred,g.perihalPenempatan,h.perihalJenisFasiliti,i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17,SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20,SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
        $this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
        $this->db->join('txnUjian j', 'j.mykad = a.mykad', 'INNER');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1,'c.levelAdmin'=>0, 'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti,'a.lokasiBertugas'=>$fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();		
    }//end method... 
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    //mengikut jenis fasiliti... 
    function get_list_ulang5($id_ambilan,$jenis_fasiliti) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17, SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20, SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
		$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
		$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1, 'c.levelAdmin'=>0,'c.status'=>'1', 'a.jenisFasiliti'=>$jenis_fasiliti));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
    
    //digunakan untuk mendapatkan senarai semua pengguna berdaftar (aktif)
    //yang telah mengambil ujian dan perlu mengulang
    function get_list_ulang6($id_ambilan) {
        $this->db->select('a.mykad, e.nama, f.perihalJantina, a.emel,k.perihalSkim,a.gred,g.perihalPenempatan, h.perihalJenisFasiliti, i.perihalFasiliti,d.skor1,d.skor2,d.skor3,d.tarikhUjian,SUM(CASE WHEN j.idSoalan = 1 THEN j.skor ELSE 0 END) AS MarkahS1,SUM(CASE WHEN j.idSoalan = 2 THEN j.skor ELSE 0 END) AS MarkahS2,SUM(CASE WHEN j.idSoalan = 3 THEN j.skor ELSE 0 END) AS MarkahS3,SUM(CASE WHEN j.idSoalan = 4 THEN j.skor ELSE 0 END) AS MarkahS4,SUM(CASE WHEN j.idSoalan = 5 THEN j.skor ELSE 0 END) AS MarkahS5,SUM(CASE WHEN j.idSoalan = 6 THEN j.skor ELSE 0 END) AS MarkahS6,SUM(CASE WHEN j.idSoalan = 7 THEN j.skor ELSE 0 END) AS MarkahS7,SUM(CASE WHEN j.idSoalan = 8 THEN j.skor ELSE 0 END) AS MarkahS8,SUM(CASE WHEN j.idSoalan = 9 THEN j.skor ELSE 0 END) AS MarkahS9,SUM(CASE WHEN j.idSoalan = 10 THEN j.skor ELSE 0 END) AS MarkahS10,SUM(CASE WHEN j.idSoalan = 11 THEN j.skor ELSE 0 END) AS MarkahS11,SUM(CASE WHEN j.idSoalan = 12 THEN j.skor ELSE 0 END) AS MarkahS12,SUM(CASE WHEN j.idSoalan = 13 THEN j.skor ELSE 0 END) AS MarkahS13,SUM(CASE WHEN j.idSoalan = 14 THEN j.skor ELSE 0 END) AS MarkahS14,SUM(CASE WHEN j.idSoalan = 15 THEN j.skor ELSE 0 END) AS MarkahS15,SUM(CASE WHEN j.idSoalan = 16 THEN j.skor ELSE 0 END) AS MarkahS16,SUM(CASE WHEN j.idSoalan = 17 THEN j.skor ELSE 0 END) AS MarkahS17, SUM(CASE WHEN j.idSoalan = 18 THEN j.skor ELSE 0 END) AS MarkahS18,SUM(CASE WHEN j.idSoalan = 19 THEN j.skor ELSE 0 END) AS MarkahS19,SUM(CASE WHEN j.idSoalan = 20 THEN j.skor ELSE 0 END) AS MarkahS20, SUM(CASE WHEN j.idSoalan = 21 THEN j.skor ELSE 0 END) AS MarkahS21');
        $this->db->from('perkhidmatan a');          
        $this->db->join('pengguna c', 'c.mykad = a.mykad', 'left'); 
        $this->db->join('ujian d', 'd.mykad = a.mykad', 'left');
        $this->db->join('profil e', 'e.mykad = a.mykad', 'left');
        $this->db->join('_kodJantina f', 'f.kodJantina = e.jantina', 'left');
        $this->db->join('_kodPenempatan g', 'g.kodPenempatan = a.penempatan', 'left');
		$this->db->join('_kodJenisFasiliti h', 'h.kodJenisFasiliti = a.jenisFasiliti', 'left');
        $this->db->join('_kodFasiliti i', 'i.kodFasiliti = a.lokasiBertugas', 'left');
		$this->db->join('txnUjian j', 'j.mykad = a.mykad', 'inner');
        $this->db->join('_kodSkimPerkhidmatan k', 'k.IdSkim = a.skim', 'left');
        $this->db->where(array('d.idAmbilan'=>$id_ambilan, 'd.statusJawab' => 1, 'c.levelAdmin'=>0,'c.status'=>'1'));
        $this->db->where('a.idPerkhidmatan = (SELECT b.idPerkhidmatan FROM perkhidmatan b WHERE b.mykad = a.mykad ORDER BY b.idPerkhidmatan DESC LIMIT 1)');
        $this->db->where('d.idUjian = (SELECT e.idUjian FROM ujian e WHERE e.mykad = a.mykad AND e.statusJawab = 1 AND e.statusUlang = 1 AND e.idAmbilan = '.$id_ambilan.' ORDER BY e.idUjian DESC LIMIT 1)');
        $this->db->group_by('j.mykad');
        return $this->db->get()->result_array();
    }//end method...
}//end class