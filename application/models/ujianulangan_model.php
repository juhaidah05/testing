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
 *                      5. Tukar nama class daripada tbl_ujianulagan_model
 *                         kepada ujianulangan_model
 */

class Ujianulangan_model extends CI_Model{
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;
    
    function __construct(){
        parent::__construct();
        $this->tableName = "ambilan A";
        $this->pk = "idAmbilan";
        $this->fk = "kodUjian";
        $this->created_date = "tarikhWujud";
        $this->created_by = "idWujud";
        $this->updated_date = "tarikhKemaskini";
        $this->updated_by = "idKemaskini";
    }//end method
        
    // return by array    
    public function checkActive($id, $data=null) {        
        if($data!=null)  {
            $this->db->select('A.statusUjian');
            $this->db->where('A.statusUjian',1);
            $this->db->where('A.idAmbilan !=',$id);
            $query = $this->db->get($this->tableName);
            if($query->num_rows()>0) {
                return true;
            }else {
                return false;
            }//end if      
        }//end if        
    }//end method
    
    public function findAll($condition='', $page=null) {              
        $this->db->select('A.idAmbilan, A.kodUjian, A.siri, A.tahun');
        $this->db->select('COUNT(DISTINCT(B.mykad)) AS bilCalon');
        $this->db->select('A.tarikhBuka, A.tarikhTutup');
        $this->db->select('A.tarikhMulaUlang, A.tarikhAkhirUlang');
        $this->db->select('A.statusUjian');
        $this->db->join('ujian B', 'B.idAmbilan=A.idAmbilan');
        $this->db->where('B.mykad NOT IN (SELECT mykad FROM ujian WHERE statusUlang=0 AND idAmbilan=B.idAmbilan)', NULL, FALSE);
        $this->db->group_by('B.idAmbilan');
        $this->db->order_by('B.idAmbilan', 'desc');
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method
    
    // update data
    public function update($id, $data=null){
        if($data!=null){            
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('maintenance/senarai_modul');            
        } else{
            return false;
        }//end if
    }//end mehod 
}//end class