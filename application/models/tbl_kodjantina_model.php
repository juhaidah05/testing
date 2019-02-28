<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Buang snippet yang tidak digunakan
 */

class Tbl_kodjantina_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;    
    
    function __construct(){
	parent::__construct();
        $this->tableName = "_kodJantina";
        $this->pk = "kodJantina";
        $this->created_date = "dtCreated";
        $this->created_by = "idCreated";
        $this->updated_date = "dtUpdated";
        $this->updated_by = "idUpdated";
    }//end method
        
    public function findAll($condition='', $page=null) {
        $this->db->select('kodJantina, perihalJantina');
        if($condition!='') { $this->db->where($condition); }
        return $this->db->get($this->tableName)->result_array();
    }//end method    
        
    // insert data   
    public function save($data=null){            
        if($data!=null) {   
            $this->db->select('kodJantina, perihalJantina');
            $this->db->where('kodJantina',$data['kodJantina']);
            $query = $this->db->get($this->tableName);

            if($query->num_rows() == 0) {
                $this->db->insert($this->tableName, $data);
                return true;
                flashMsg('Rekod Berjaya Disimpan!','success');
                redirect('maintenance/senarai_kodjantina');
            } else {
                return '';
            }//end if
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
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('maintenance/senarai_kodjantina');
        } else {
            return false;
        }//end if
    }//end method
    
     // delete data
    public function delete($id) {
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Rekod Berjaya Dihapus!','success');
        redirect('maintenance/senarai_kodjantina');
    }//end method    
}//end class