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
 *                      5. Tukar nama class daripada tbl_modul_pengguna_model
 *                         kepada tbl_modulpengguna_model
 */

class Tbl_modulpengguna_model extends CI_Model{
    private $tableName;
    private $pk;
    private $fk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();        
        $this->tableName = "ModulPengguna";
        $this->pk = "idModul";
        $this->fk = "cdPeranan";
        $this->created_by = "idcreated";
        $this->created_date = "dtcreated";
        $this->updated_by = "idupdated";
        $this->updated_date = "dtupdated";          
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method
    
    public function save($data=null) {               
        if($data!=null){
            $this->db->set($this->created_by, $this->session->userdata('username'));
            $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->set('statusAktif', 'Y');
            $this->db->insert($this->tableName, $data);
            $this->db->last_query();
            return $this->db->insert_id();
        }else{
            return false;
        }//end if   
    }//end method
    
    // update data
    public function update($id, $data=null){
        if($data!=null){
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
        }else {
            return false;
        }//end if
    }//end method   
    
    public function delete($id){
        $this->db->where($this->fk,$id);
        $this->db->delete($this->tableName);
    }//end method     
}//end class