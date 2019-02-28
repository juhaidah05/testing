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
 *                      5. Tukar nama class daripada Tbl_skimperkhidmatan_model
 *                         kepada tbl_kodskimperkhidmatan_model
 */

class Tbl_kodskimperkhidmatan_model extends CI_Model{
    private $tableName;
    private $pk;
    private $fk;   
    
    function __construct(){
	parent::__construct();
        $this->tableName = "_kodSkimPerkhidmatan";
        $this->pk = "IdSkim";
        $this->fk = "kodKlasifikasiSkim";        
    }//end method
        
    // return by array
    public function findAll($condition='', $page=null) {              
        if($page!=null){ 
            $this->db->select('_kodSkimPerkhidmatan.IdSkim, _kodSkimPerkhidmatan.kodKlasifikasiSkim, _kodSkimPerkhidmatan.perihalSkim, _kodSkimPerkhidmatan.kumpPerkhidmatan, _kodKumpulanPerkhidmatan.perihalKumpulan');
            $this->db->join('_kodKlasifikasiSkim', '_kodKlasifikasiSkim.kodKlasifikasiSkim = _kodSkimPerkhidmatan.kodKlasifikasiSkim');
            $this->db->join('_kodKumpulanPerkhidmatan', '_kodKumpulanPerkhidmatan.kodKumpulan = _kodSkimPerkhidmatan.kumpPerkhidmatan');
            $this->db->order_by('_kodSkimPerkhidmatan.IdSkim', 'asc'); 
        }
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array(); 
    }//end method   
        
    // insert data   
    public function save($data=null)    {
        if($data!=null){               
            $this->db->select('IdSkim, perihalSkim, kodKlasifikasiSkim, kumpPerkhidmatan');
            $this->db->where('IdSkim',$data['IdSkim']);
            $query = $this->db->get($this->tableName);
            if($query->num_rows() == 0){
                $this->db->insert($this->tableName, $data);
                return true;
                flashMsg('Rekod Berjaya Disimpan!','success');
                redirect('maintenance2/senarai_skimperkhidmatan');
            } else{
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
            redirect('maintenance2/senarai_skimperkhidmatan');
        }else{
            return false;
        }//end if
    }//end method
    
    // delete data
    public function delete($id){
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Rekod Berjaya Dihapus!','success');
        redirect('maintenance2/senarai_skimperkhidmatan');
    }//end method  
}//end class