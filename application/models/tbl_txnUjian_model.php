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
 */

class Tbl_txnUjian_model extends CI_Model{
    private $tableName;
    private $pk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();        
        $this->tableName = "txnUjian";
        $this->pk = "idTxnUjian";
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
        } else {
            return false;
        }//end if
    }//end method
    
    // update data
    public function update($id, $data=null){
        if($data!=null) {
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
        } else {
            return false;
        }//end if
    }//end method     
    
    public function getData($id) {
        $this->db->select('*');            
        $this->db->where($this->fk,$id);          
        return $this->db->get($this->tableName)->result_array();        
    }//end method
    
    public function findAll($condition='', $page=null)  {
        if($page!=null){$this->db->select('*');}           
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method    
}//end class