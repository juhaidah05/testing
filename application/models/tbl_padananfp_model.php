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

class Tbl_padananfp_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fasiliti;
    private $penempatan; 
    
    function __construct(){
        parent::__construct();
        $this->tableName = "_padananFP";
        $this->pk = "idFP";
        $this->fasiliti = "fasiliti";
        $this->penempatan = "penempatan";
    }//end method    
    
    public function getData($kodfasiliti) {
        $this->db->select('_padananFP.*,_kodPenempatan.perihalPenempatan');            
        $this->db->where($this->fasiliti,$kodfasiliti);
        $this->db->join('_kodPenempatan', '_kodPenempatan.kodPenempatan=_padananFP.penempatan', 'left');
        $this->db->group_by('_kodPenempatan.perihalPenempatan');
        $this->db->order_by('_kodPenempatan.perihalPenempatan', 'asc');
        return $this->db->get($this->tableName)->result_array();        
    }//end method
    
    public function findAll($condition='', $page=null){
        $this->db->select('_padananFP.idFP, _kodFasiliti.kodFasiliti, _kodFasiliti.perihalFasiliti, _kodPenempatan.kodPenempatan, _kodPenempatan.perihalPenempatan');
        $this->db->join('_kodFasiliti', '_kodFasiliti.kodFasiliti=_padananFP.fasiliti');
        $this->db->join('_kodPenempatan', '_kodPenempatan.kodPenempatan=_padananFP.penempatan');
        $this->db->order_by('_padananFP.idFP', 'desc');
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method    
        
    // insert data   
    public function save($data=null){
        if($data!=null){             
            $this->db->select('fasiliti, penempatan');
            $this->db->where('fasiliti',$data['fasiliti']);
            $this->db->where('penempatan',$data['penempatan']);
            $query = $this->db->get($this->tableName);
            if($query->num_rows() == 0){
                $this->db->insert($this->tableName, $data);                       
                return $this->db->insert_id();
                flashMsg('Rekod Berjaya Disimpan!','success');
                redirect('maintenance/senarai_padananfp');
            } else {
                return false;
            }//end if
        } else {
            return false;
        }//end if
    }//end method    
    
    // update data
    public function update($id, $data=null) {
        if($data!=null) {
            $this->db->select('fasiliti, penempatan');
            $this->db->where('fasiliti',$data['fasiliti']);
            $this->db->where('penempatan',$data['penempatan']);
            $this->db->where('idFP !=',$id);           
            $query = $this->db->get($this->tableName);  
            if($query->num_rows() == 0) {
                $this->db->where($this->pk,$id);
                $this->db->update($this->tableName, $data);
                return true;
                flashMsg('Rekod Berjaya Dikemaskini!!','success');
                redirect('maintenance/senarai_padananfp');
            }else{
                return false;
            }//end if
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
        redirect('maintenance/senarai_padananfp');
    }//end method
}//end class