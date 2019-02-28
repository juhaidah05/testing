<?php

/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (5 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Buang snippet yang tidak perlu
 *                      5. Buang variable private $fk;
 */

class Tbl_kodujian_model extends CI_Model{
    private $tableName;
    private $pk;
    //private $fk;   
   
    function __construct(){
	parent::__construct();
        $this->tableName = "_kodUjian";
        $this->pk = "kodUjian";
        $this->fk = "";        
    }//end method
        
    // return by array
    public function findAll($condition='', $data=null){
        $this->db->order_by('kodUjian', 'asc');        
        if($data!=null){$this->db->select('kodUjian, perihalUjian, keterangan1, keterangan2');}
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method

    //inser data
    public function save($data=null) {
        if($data!=null) {        
            $this->db->select('kodUjian, perihalUjian, keterangan1, keterangan2');
            $this->db->where('kodUjian',$data['kodUjian']);
            $query = $this->db->get($this->tableName);            
            if($query->num_rows() == 0) {                            
                $this->db->insert($this->tableName, $data);
                return true;
                flashMsg('Record Saved!','success');
             	redirect('maintenance/senarai_kujian');            
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
            redirect('maintenance/senarai_kujian');
        } else {
            return false;
        }
    }//end method    
    
     // delete data
    public function delete($id) {
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Record Deleted!','success');
        redirect('maintenance/senarai_kujian');
    }//end method    
}//end class