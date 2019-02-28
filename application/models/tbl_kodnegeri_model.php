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
 *                      5. Tukar nama class daripada tbl_negeri_model
 *                         kepada tbl_kodnegeri_model
 *                      6. Buang variable private $fk;
 */

class Tbl_kodnegeri_model extends CI_Model{
    private $tableName;
    private $pk;
    private $fk;   
    
    function __construct(){
        parent::__construct();
        $this->tableName = "_kodNegeri";
        $this->pk = "kodNegeri";
        $this->fk = "";        
    }//end method
        
    // return by array
    public function findAll($condition='', $page=null) {
        $this->db->order_by('kodNegeri', 'asc');        
        if($page!=null){ $this->db->select('kodNegeri, negeri'); }
        if($condition!='') { $this->db->where($condition); }
        return $this->db->get($this->tableName)->result_array();
    }//end method    
    
    // insert data
    public function save($data=null) {
        if($data!=null) {            
            $this->db->select('kodNegeri, perihalNegeri');
            $this->db->where('kodNegeri = '.$data['kodNegeri']);
            $query = $this->db->get($this->tableName);            
            if($query->num_rows() == 0) {    
                $this->db->insert($this->tableName, $data);
                return $this->db->insert_id();
                flashMsg('Record Saved!','success');
                redirect('maintenance/negeri_listing');            
            } else {
                return '';
            }//end if            
        }else{
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
            redirect('maintenance/negeri_listing');
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
        redirect('maintenance/negeri_listing');
    }//end method    
}//end class