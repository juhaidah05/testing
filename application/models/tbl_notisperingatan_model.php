<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (24 Ogos 2015)   :  1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Tambah method check_exist(), get_tajuk() dan get_notis()
 */

class Tbl_notisperingatan_model extends CI_Model{
    private $tableName;
    private $pk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();
        $this->tableName = "notisPeringatan";
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
    
    function update_data($tableName,$key,$data)  {
        $this->db->where($key);
        $this->db->update($tableName, $data); 
    }//end method
    
    public function findAll($condition='', $page=null) {
        if($page!=null){$this->db->select('*');}           
        if($condition!='') {$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method  
    
    //digunakan untuk menyemak samaada notis peringatan
    //telah ditetapkan bagi seseorang pentadbir atau sebaliknya.
    //public function check_exist($mykad,$lokaliti){
    public function check_exist($lokaliti){
        $this->db->select('idPengguna');
        $this->db->from('notisPeringatan');
        //$this->db->where(array('idPengguna'=>$mykad,'lokalitiAdmin'=>$lokaliti));
        $this->db->where(array('lokalitiAdmin'=>$lokaliti));
        return $this->db->count_all_results();  
    }//end method
    
    function get_tajuk($mykad){
        $this->db->select('tajukNotis');
        $this->db->from($this->tableName);
        $this->db->where('idPengguna',$mykad);        
        return $this->db->get()->row('tajukNotis');        
    }//end method
    
    function get_notis($mykad){
        $this->db->select('notis');
        $this->db->from($this->tableName);
        $this->db->where('idPengguna',$mykad);        
        return $this->db->get()->row('notis');        
    }//end method
}//end class