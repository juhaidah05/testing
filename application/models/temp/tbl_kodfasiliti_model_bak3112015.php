<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *                      4. Tambah method getData() dan get_perihal()
 *                      5. Tambah $this->db->order_by('perihalFasiliti', 'ASC');
 *                         pada method getdata() dan getdata_admin()
 */

class Tbl_kodfasiliti_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;    
    
    function __construct() {
        parent::__construct();
        $this->tableName = "_kodFasiliti";
        $this->pk = "kodFasiliti";
        $this->fk = "kodJenisFasiliti";
        $this->created_date = "dtCreated";
        $this->created_by = "idCreated";
        $this->updated_date = "dtUpdated";
        $this->updated_by = "idUpdated";
    }//end method...
        
    public function findAll($condition='', $page=null){              
        $this->db->select('_kodFasiliti.kodFasiliti, _kodFasiliti.perihalFasiliti, _kodJenisFasiliti.perihalJenisFasiliti, _kodFasiliti.lokalitiPentadbir');
        $this->db->join('_kodJenisFasiliti', '_kodJenisFasiliti.kodJenisFasiliti=_kodFasiliti.kodJenisFasiliti');
        $this->db->order_by('_kodFasiliti.kodFasiliti', 'asc'); 
        if($condition!=''){ $this->db->where($condition);}        
        return $this->db->get($this->tableName)->result_array();
    }//end method...
   
    // simpan data
    public function save($data=null)  {
   	if($data!=null) {               
            $this->db->select('kodFasiliti, perihalFasiliti, kodJenisFasiliti, lokalitiPentadbir');
            $this->db->where('kodFasiliti',$data['kodFasiliti']);
            $query = $this->db->get($this->tableName);
            if($query->num_rows() == 0) {
	        $this->db->insert($this->tableName, $data);
                return true;
                flashMsg('Rekod Berjaya Disimpan!','success');
                redirect('maintenance/senarai_kodfasiliti');
            } else {
                return '';
            }//end if
        } else {
            return false;
        }//end if
    }//end method...
    
    // update data
    public function update($id, $data=null) {
    	if($data!=null) {
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('maintenance/senarai_kodfasiliti');
        } else {
            return false;
        }//end if
    }//end method...
    
    // delete data
    public function delete($id){
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Rekod Berjaya Dihapus!','success');
        redirect('maintenance/senarai_kodfasiliti');
    } //end method...   

    public function getData($id){
        $this->db->select('*');
        $this->db->where($this->fk,$id);
        $this->db->order_by('perihalFasiliti', 'ASC');
        return $this->db->get($this->tableName)->result_array();
    }//end method...
	
    public function getData_admin($jenis_fasiliti,$lokaliti){
        $this->db->select('*');
        $this->db->where(array($this->fk=>$jenis_fasiliti,'lokalitiPentadbir'=>$lokaliti));
        $this->db->order_by('perihalFasiliti', 'ASC');
        return $this->db->get($this->tableName)->result_array();
    }//end method...

    public function get_perihal($id){
        $this->db->select('perihalFasiliti');
        $this->db->from($this->tableName);
        $this->db->where($this->pk,$id);
        return $this->db->get()->row('perihalFasiliti');
    }//end method...

    public function get_fasiliti($lokaliti){
        $this->db->select('kodJenisFasiliti');
        $this->db->from($this->tableName);
        $this->db->where('lokalitiPentadbir',$lokaliti);
        $this->db->order_by($this->fk,'ASC');
        $this->db->group_by($this->fk);
        return $this->db->get()->result_array();
    }//end method...
}//end class