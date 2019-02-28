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
 */

class Tbl_modul_model extends CI_Model{
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;    
    
    function __construct(){
        parent::__construct();
        $this->tableName = "_modul";
        $this->pk = "cdModul";
        $this->created_date = "dtCreated";
        $this->created_by = "idCreated";
        $this->updated_date = "dtUpdated";
        $this->updated_by = "idUpdated";
    }//end method
        
    // return by array
    public function findAll($condition='', $page=null) {
        $this->db->select('cdModul, ketModul, urlModul, statusAktif');
        if($condition!='') {$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method   
        
    // insert data   
    public function save($data=null) {
        if($data!=null){  
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $this->db->set($this->created_by, $this->session->userdata('username'));
            $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();                        
            flashMsg('Rekod Berjaya Disimpan!','success');
            redirect('maintenance/senarai_modul');                    
        } else {
            return false;
        }//end if
    }//end method    
    
    // update data
    public function update($id, $data=null) {
        if($data!=null) {
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();            
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('maintenance/senarai_modul');
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
        redirect('maintenance/senarai_modul');
    }//end method    
}//end class