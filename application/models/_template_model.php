<?php 

/*  Tarikh Cipta    :   ?
 *  Programmer      :   Haezal Musa
 *  Tujuan Aturcara :   Model Class bagi ..
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Ringkaskan pernyataan if
 *                      4. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 *                      5. Comment public function _join() { }//end method
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class ClassName extends CI_Model{    
    // global variable
    private $tableName;
    private $pk;
    private $name;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "";
        $this->pk = "";
        $this->name = "";
        $this->created_date = "";
        $this->created_by = "";
        $this->updated_date = "";
        $this->updated_by = "";
    }//end method
    
    public function dropdown($all=false) {
        $query = $this->db->get($this->tableName);        
        $arr = $query->result_array();
        $data[''] = ($all==false)? '-- Pilih --':'-- Semua --';
        foreach ($arr as $k => $v){ $data[$v[$this->pk]] = $v[$this->name]; }
        return $data;
    }//end method
    
    public function find($condition=null){
        if($condition!=null) { $this->db->where($condition); }
        return $this->db->get($this->tableName)->row();
    }//end method
    
    public function find_all($condition=null) {
        if($condition!=null) { $this->db->where($condition); }        
        return $this->db->get($this->tableName)->result();
    }//end method
    
    public function find_by_pk($id) {
        $this->db->where($this->pk, $id);
        return $this->db->get($this->tableName)->row_array();
    }//end method
    
    // insert data
    public function save($data=null) {
        if($this->created_by) { $this->db->set($this->created_by, $this->authentication->getId()); }
        if($this->created_date) { $this->db->set($this->created_date, date('Y-m-d H:i:s')); }
        $this->db->insert($this->tableName, $data);
        return $this->db->insert_id();   
    }//end method
   
    // update data
    public function update($id, $data=null) {
        if($this->updated_by) { $this->db->set($this->updated_by, $this->authentication->getId()); }
        if($this->updated_date) { $this->db->set($this->updated_date, date('Y-m-d H:i:s')); }
        $this->db->where($this->pk, $id);
        $this->db->update($this->tableName, $data);
    }//end method    
}//end class