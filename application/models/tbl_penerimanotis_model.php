<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (24 Ogos 2015)   :  1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Tambah method get_total(), get_namaPN1(), 
 *                         get_emelPN1(), get_namaPN2() dan get_emelPN2()
 */

class Tbl_penerimanotis_model extends CI_Model {
    private $tableName;
    private $pk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();        
        $this->tableName = "penerimaNotis";
        $this->pk = "ID";
        $this->created_by = "idWujud";
        $this->created_date = "tarikhWujud";
        $this->updated_by = "idKemaskini";
        $this->updated_date = "tarikhKemaskini";          
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method
    
    public function save($data=null) {               
        if($data!=null) {
            $this->db->set($this->created_by, $this->session->userdata('username'));
            $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();
        } else {
            return false;
        }//end if
    }//end method
    
    // update data
    public function update($id, $data=null) {
        if($data!=null) {
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
        } else {
            return false;
        }//end if
    }//end method
	
    function update_data($tableName,$key,$data) {
	    $this->db->set($this->updated_by, $this->session->userdata('username'));
        $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
        $this->db->where($key);
        $this->db->update($tableName, $data); 		
    }//end method   
    
    public function delete($id) {
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();     
    }//end method    
    
    public function getData($id) {
        $this->db->select('*');            
        $this->db->where($this->fk,$id);          
        return $this->db->get($this->tableName)->result_array();        
    }//end method
    
    public function findAll($condition='', $page=null) {
        if($page!=null){$this->db->select('*');}        
        if($condition!=''){ $this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method
    
    //digunakan untuk menyemak samaada penerima notis
    //telah ditetapkan oleh pentadbir atau sebaliknya
    //dengan syarat status penerima notis yang wujud mestilah = Aktif (1)
    //public function check_exist($mykad,$lokaliti){
    public function check_exist($lokaliti){
        $this->db->select('idPengguna');
        $this->db->from('penerimaNotis');
        //$this->db->where(array('idPengguna'=>$mykad,'lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where(array('lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        return $this->db->count_all_results();  
    }//end method
    
    //digunakan untuk mendapatkan nama penerima notis pertama
    //dengan syarat status penerima notis yang wujud mestilah = Aktif (1)
    //public function get_namaPN1($mykad,$lokaliti){
    public function get_namaPN1($lokaliti){
        $this->db->select('namaPN');
        $this->db->from('penerimaNotis');
        //$this->db->where(array('idPengguna'=>$mykad,'lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where(array('lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->limit(1);
        return $this->db->get()->row('namaPN'); 
    }//end method 
    
    //digunakan untuk mendapatkan alamat emel penerima notis pertama
    //dengan syarat status penerima notis yang wujud mestilah = Aktif (1)
    //public function get_emelPN1($mykad,$lokaliti){
    public function get_emelPN1($lokaliti){
        $this->db->select('emelPN');
        $this->db->from('penerimaNotis');
        //$this->db->where(array('idPengguna'=>$mykad,'lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where(array('lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->limit(1);
        return $this->db->get()->row('emelPN'); 
    }//end method 
    
    //digunakan untuk mendapatkan nama penerima notis kedua
    //dengan syarat status penerima notis yang wujud mestilah = Aktif (1)
    //public function get_namaPN2($mykad,$lokaliti, $emelPN1){
    public function get_namaPN2($lokaliti, $emelPN1){
        $this->db->select('namaPN');
        $this->db->from('penerimaNotis');
        //$this->db->where(array('idPengguna'=>$mykad,'lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where(array('lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where("emelPN != '".$emelPN1."'");
        $this->db->limit(1);
        return $this->db->get()->row('namaPN'); 
    }//end method
    
    //digunakan untuk mendapatkan alamat emel penerima notis kedua
    //dengan syarat status penerima notis yang wujud mestilah = Aktif (1)
    public function get_emelPN2($lokaliti, $emelPN1){
        $this->db->select('emelPN');
        $this->db->from('penerimaNotis');
        //$this->db->where(array('idPengguna'=>$mykad,'lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where(array('lokalitiAdmin'=>$lokaliti, 'statusPN'=>1));
        $this->db->where("emelPN != '".$emelPN1."'");
        $this->db->limit(1);
        return $this->db->get()->row('emelPN'); 
    }//end method
}//end class