<?php

/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Buang snippet yang tidak perlu
 */

class Tbl_kodkategorisoalan_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;    
    
    public function __construct() {
        parent::__construct();        
        $this->tableName = "_kategoriSoalan";
        $this->pk = "idKategoriSoalan";
        $this->fk = "kodUjian";
        $this->created_date = "dtCreated";
        $this->created_by = "idCreated";
        $this->updated_date = "dtUpdated";
        $this->updated_by = "idUpdated";
    }//end method
        
    // return by array
    public function findAll($condition='', $page=null){
        $this->db->select('_kategoriSoalan.idKategoriSoalan, _kategoriSoalan.kategoriSoalan, _kodUjian.kodUjian, _kodUjian.perihalUjian');
        $this->db->join('_kodUjian', '_kodUjian.kodUjian=_kategoriSoalan.kodUjian');
        $this->db->order_by('_kategoriSoalan.idKategoriSoalan', 'asc'); 
        if($condition!='') { $this->db->where($condition); }
        return $this->db->get($this->tableName)->result_array();
        //print_r($this->db->last_query());
        //die();
    }//end method

    // insert data   
    public function save($data=null) {
        if($data!=null){               
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();
            flashMsg('Rekod Berjaya Disimpan!','success');
            redirect('maintenance/senarai_kategorisoalan');
        } else {
            return false;
        }//end if
    }//end method    
    
    // update data
    public function update($id, $data=null) {
        if($data!=null){
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('maintenance/senarai_kategorisoalan');
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
        redirect('maintenance/senarai_kategorisoalan');
    }//end method
}//end class