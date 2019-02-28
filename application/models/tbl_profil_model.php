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

class Tbl_profil_model extends CI_Model {
    private $tableName;
    private $pk;
    private $created_by;
    private $created_date;
    private $updated_by;
    private $updated_date;
    
    function __construct() {
        parent::__construct();        
        $this->tableName = "profil";
        $this->pk = "mykad";
        $this->created_by = "idWujud";
        $this->created_date = "tarikhWujud";
        $this->updated_by = "idKemaskini";
        $this->updated_date = "tarikhKemaskini";          
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method
    
    public function save($data=null) {               
        if($data!=null) {
            $this->db->set($this->created_by, $this->session->userdata('username'));
            $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->insert($this->tableName, $data);
            return $this->db->insert_id();
        } else {
            return false;
        }//end if
    }//end method
    
    // update data
    public function update($id, $data=null) {
        if($data!=null) {
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
        } else  {
            return false;
        }//end if
    }//end method    
    
    public function getData($id) {
        $this->db->select('*');            
        $this->db->where($this->fk,$id);         
        return $this->db->get($this->tableName)->result_array();        
    }//end method
    
    public function findAll($nama='', $mykad='', $levelAdmin='', $lokaliti='')    {
        $this->db->select('profil.nama, profil.mykad, pengguna.status'); 
        $this->db->join('pengguna', 'pengguna.mykad=profil.mykad', 'left');                
        if($nama!=null){$this->db->like('profil.nama',$nama); }           
        if($mykad!=''){$this->db->where('profil.mykad',$mykad);}        
        if($levelAdmin<2) {$this->db->where('pengguna.lokaliti',$lokaliti);}                
		if($levelAdmin<2) {$this->db->where('pengguna.levelAdmin < ',$levelAdmin);}
        return $this->db->get($this->tableName)->result_array();
    }//end method 
}//end class