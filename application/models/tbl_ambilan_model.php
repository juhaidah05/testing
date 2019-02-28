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

class Tbl_ambilan_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;    
    
    function __construct(){
	parent::__construct();
        $this->tableName = "ambilan";
        $this->pk = "idAmbilan";
        $this->created_date = "tarikhWujud";
        $this->created_by = "idWujud";
        $this->updated_date = "tarikhKemaskini";
        $this->updated_by = "idKemaskini";
    }//end method
        
    public function findAll($condition='', $page=null) {
        $this->db->select('*');
        if($condition!=''){ $this->db->where($condition);}                
        return $this->db->get($this->tableName)->result_array();
    }//end method
            
    // insert data
    public function save($data=null){
        if($data!=null){   
            $this->db->select('kodJantina, perihalJantina');
            $this->db->where('kodJantina',$data['kodJantina']);
            $query = $this->db->get($this->tableName);
            if($query->num_rows() == 0){
                $this->db->insert($this->tableName, $data);
                return true;
                flashMsg('Rekod Berjaya Disimpan!','success');
                redirect('maintenance/senarai_kodjantina');
            } else { 
                return '';
            }//end if
        } else {
            return false;
        }
    }//end method
}//end class