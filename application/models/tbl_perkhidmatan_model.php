<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (14 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *			4. Tambah method getData_carian()
 */

class Tbl_perkhidmatan_model extends CI_Model {
    private $tableName;
    private $pk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();        
        $this->tableName = "perkhidmatan";
        $this->pk = "idPerkhidmatan";
        $this->created_by = "idWujud";
        $this->created_date = "tarikhWujud";
        $this->updated_by = "idKemaskini";
        $this->updated_date = "tarikhKemaskini";  
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method
    
    public function save($data=null) {               
        if($data!=null){
            $this->db->set($this->created_by, $this->session->userdata('username'));
            $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();
        } else{
            return false;
        }//end if
    }//end method
    
    // update data
    public function update($idPerkhidmatan, $data=null){
        if($data!=null) {
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where('idPerkhidmatan',$idPerkhidmatan);
            $this->db->update($this->tableName, $data);
            
            //echo $this->db->last_query();
            exit;
        } else {
            return false;
        }//end if
    }//end method    
    
    public function getData($id) {
        $this->db->select('*');            
        $this->db->where($this->fk,$id);  
        return $this->db->get($this->tableName)->result_array();        
    }//end method
	
    public function getData_carian($id) {
        $this->db->select('a.*, b.*');
        $this->db->from('perkhidmatan a');
        $this->db->join('profil b','b.mykad=a.mykad');
        $this->db->where('b.mykad',$id);
        $this->db->order_by("a.idPerkhidmatan","desc");
        return $this->db->get()->result_array();        
    }//end method
    
    public function findAll($condition='', $page=null){
        if($page!=null){$this->db->select('*');}           
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method    
}//end class