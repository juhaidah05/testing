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

class Tbl_soalan_model extends CI_Model{
    private $tableName;
    private $pk;
    private $fk1;
    private $fk2;   
    
    function __construct(){
        parent::__construct();
        $this->tableName = "_soalan";
        $this->pk = "idSoalan";
        $this->fk1 = "kodUjian";
        $this->fk2 = "idKategoriSoalan";        
    }//end method
        
    // return by array
    public function findAll($condition='', $page=null) {  
        $this->db->select('_soalan.idSoalan, _soalan.soalan, _soalan.idKategoriSoalan, _soalan.kodUjian, _kategoriSoalan.kategoriSoalan,_kodUjian.perihalUjian');
        $this->db->join('_kodUjian', '_kodUjian.kodUjian = _soalan.kodUjian');
        $this->db->join('_kategoriSoalan', '_kategoriSoalan.idKategoriSoalan = _soalan.idKategoriSoalan');
        $this->db->order_by('_soalan.idSoalan', 'asc'); 
        if($condition!='') {$this->db->where($condition); }
        return $this->db->get($this->tableName)->result_array();
    }//end method   
        
    // insert data
    public function save($data=null) {
        if($data!=null){               
            $this->db->select('idSoalan, soalan, idKategoriSoalan, kodUjian');
            $this->db->where('idSoalan',$data['idSoalan']);
            $query = $this->db->get($this->tableName);
            if($query->num_rows() == 0){                                            
                $this->db->insert($this->tableName, $data);
                return true;                        
                flashMsg('Rekod Berjaya Disimpan!','success');
                redirect('maintenance/senarai_soalan');
            }else{
                return '';
            }//end if
        }else {
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
            redirect('maintenance/senarai_soalan');
        }else{
            return false;
        }//end if
    }//end method
    
     // delete data
    public function delete($id) {
       $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Rekod Berjaya Dihapus!','success');
        redirect('maintenance/senarai_soalan');
    }//end method  
}//end class