<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (5 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Buang snippet yang tidak digunakan
 *                      5. tukar nama class daripada tbl_penempatan_model
 *                         kepada tbl_kodpenempatan_model
 */

class Tbl_kodpenempatan_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;   
    
    function __construct(){
	parent::__construct();
        $this->tableName = "_kodPenempatan";
        $this->pk = "kodPenempatan";
        $this->fk = "";        
    }//end method
        
    // return by array
    public function findAll($condition='', $page=null) {
        $this->db->order_by('kodPenempatan', 'asc');        
        if($page!=null){ $this->db->select('kodPenempatan, perihalPenempatan'); }
        if($condition!='') { $this->db->where($condition); }
        return $this->db->get($this->tableName)->result_array();
    }//end method   
    
    // insert data
    public function save($data=null)  {
        if($data!=null) {  
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();
            flashMsg('Record Saved!','success');
            redirect('maintenance/penempatan_listing');      
        } else {
            return false;
        }//end if
    }//end method    
    
    // update data
    public function update($id, $data=null) {
        if($data!=null) {
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();            
            flashMsg('Record Updated!','success');
            redirect('maintenance/penempatan_listing');
        } else {
            return false;
        }//end if
    }//end method   
    
    // delete data
    public function delete($id) {
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Record Deleted!','success');
        redirect('maintenance/penempatan_listing');
    }//end method   
    
    public function getData($id) {
        $this->db->select('*');            
        $this->db->where($this->pk,$id);          
        return $this->db->get($this->tableName)->result_array();        
    }//end method
    
    function get_perihal($id){
        $this->db->select('perihalPenempatan');
        $this->db->from($this->tableName);
        $this->db->where($this->pk,$id);        
        return $this->db->get()->row('perihalPenempatan');
    }//end method
}//end class