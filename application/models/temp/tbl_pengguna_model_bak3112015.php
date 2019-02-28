<?php
/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (1 Sept 2015)   :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 * 			4. Tambah method get_peranan()
 *			5. Tambah method get_lokaliti()
 */
 
class Tbl_pengguna_model extends CI_Model {
    private $tableName;
    private $pk;
    private $usr_counting;
    private $created_date;
    private $updated_date;
    
    function __construct() {
        parent::__construct(); 
        $this->tableName = "pengguna";
        $this->pk = "mykad";
        $this->fk = "";
        $this->usr_counting = "";
        $this->created_by = "idWujud";
        $this->created_date = "tarikhWujud";
        $this->updated_by = "idKemaskini";
        $this->updated_date = "tarikhKemaskini";     
    }//end method...
    
    // update data
    public function get_pengguna($id) {        
        $this->db->select('*'); 
        $this->db->join('profil', 'profil.mykad=pengguna.mykad');
        $this->db->join('perkhidmatan', 'perkhidmatan.mykad=pengguna.mykad');
        $this->db->where('pengguna.mykad', $id);        
        $query = $this->db->get($this->tableName);        
        return $query->row_array();        
    }//end method...
    
    public function check_pengguna($mykad, $emel) {        
        $this->db->select('*'); 
        $this->db->join('profil', 'profil.mykad=pengguna.mykad');
        $this->db->join('perkhidmatan', 'perkhidmatan.mykad=pengguna.mykad');
        $this->db->where('pengguna.mykad', $mykad);
        $this->db->where('perkhidmatan.emel', $emel);
        $query = $this->db->get($this->tableName);
        return ($query->num_rows()>0)?  true:false;
    }//end method...
            
    public function update2($id, $data=null) {
        if($data!=null){
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
        } else {
            return false;
        }//end if
    }//end method...    
    
    // update data
    public function update($id, $data=null) {
        if($data!=null)  {
            $this->db->select('mykad');
            $this->db->where('mykad = "'.$data[mykad].'"');
            $query = $this->db->get($this->tableName);            
            if($query->num_rows() == 0) {                 
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $this->db->set($this->updated_by, $this->session->userdata('username'));
                $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
                $this->db->where($this->pk,$id);
                $this->db->update($this->tableName, $data);
                return $this->db->affected_rows();
                flashMsg('Record Updated!','success');
                redirect('user_registration/listing');
            } else {
                return '';
            }//end if
        } else {
            return false;
        }//end if
    }//end method...    
    
    //save data
    public function save($data=null) {
        if($data!=null) {
            $this->db->select('mykad');
            $this->db->where('mykad = "'.$data[mykad].'"');
            $query = $this->db->get($this->tableName);            
            if($query->num_rows() == 0) {            
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $this->db->set($this->created_by, $this->session->userdata('username'));
                $this->db->set($this->created_date, "'".date('Y-m-d H:i:s')."'", FALSE);
                $this->db->insert($this->tableName, $data);
                return $this->db->affected_rows();
                flashMsg('Record has been save!','success');
                redirect('user_registration/listing');
            } else {
                return '';
            }//end if
        } else {
            return false;
        }//end if
    } //end method...   
     
    public function delete($id) {
       	$this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();        
        flashMsg('Record Deleted!','success');
        redirect('user_registration/listing');
    }//end method...    
    
    public function searchCases($where='',  $like_where='') {
        $this->db->select('pengguna.*, profil.emel '); 
        $this->db->join('profil', 'profil.mykad = pengguna.mykad', 'left');   
        if($where != ''){$this->db->where($where);}        
        if($like_where!= ''){$this->db->like($like_where);}        
        if($where != ''){$this->db->where($where);} 
        $this->db->group_by('mykad'); 
        return  $this->db->get($this->tableName)->result_array();
    }//end method...    
    
    public function cariDASS($where='',  $like_where='') {         
        $this->db->select('ambilan.*'); 
        $this->db->where('statusUjian = "1" and kodUjian = "DASS"');          
        if($where != ''){$this->db->where($where);}        
        if($like_where!= ''){$this->db->like($like_where);}        
        if($where != ''){ $this->db->where($where);} 
        return  $this->db->get('ambilan')->row_array();
    }//end method...    
    
    function get_peranan($mykad){
        $this->db->select('levelAdmin');
        $this->db->from($this->tableName);
        $this->db->where($this->pk,$mykad);        
        return $this->db->get()->row('levelAdmin');        
    }//end method...
    
    function get_lokaliti($mykad){
        $this->db->select('lokaliti');
        $this->db->from($this->tableName);
        $this->db->where($this->pk,$mykad);        
        return $this->db->get()->row('lokaliti');        
    }//end method...
}//end class