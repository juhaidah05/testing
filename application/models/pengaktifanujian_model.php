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
 *                      5. Ubah lokasi date_default_timezone_set('Asia/Kuala_Lumpur'); ke dlm method __construct
 *                      6. tukar nama class daripada tbl_pengaktifanujian_model
 *                         kepada pengaktifanujian_model
 */

class Pengaktifanujian_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;
      
    function __construct() {
	parent::__construct();
        $this->tableName = "ambilan";
        $this->pk = "idAmbilan";
        $this->fk = "kodUjian";
        $this->created_date = "tarikhWujud";
        $this->created_by = "idWujud";
        $this->updated_date = "tarikhKemaskini";
        $this->updated_by = "idKemaskini";
    }//end method
        
    public function checkActive() {        
        $this->db->select('statusUjian');
        $this->db->where('statusUjian',1);
        $query = $this->db->get($this->tableName);
        return ($query->num_rows()>0) ? true:false;      
    }//end method
      
    public function findAll($kodUjian='', $siri='', $tahun='',$tarikhBuka='', $tarikhTutup='', $statusUjian='') {
        $this->db->select('ambilan.idAmbilan, ambilan.kodUjian, ambilan.siri, ambilan.tahun, ambilan.tarikhBuka,ambilan.tarikhTutup,ambilan.statusUjian,ambilan.idKemaskini,ambilan.tarikhKemaskini'); 
        $this->db->join('ujian', 'ujian.idAmbilan = ambilan.idAmbilan', 'left');
        $this->db->order_by('ambilan.idAmbilan', 'desc');        
        if($kodUjian != ''){ $this->db->like('ambilan.kodUjian',$kodUjian); }
        if($siri != ''){ $this->db->where('ambilan.siri',$siri); }
        if($tahun != ''){ $this->db->where('ambilan.tahun',$tahun);}
        if($tarikhBuka != ''){ $this->db->where('ambilan.tarikhBuka',$tarikhBuka);}
        if($tarikhTutup != ''){ $this->db->where('ambilan.tarikhTutup',$tarikhTutup);}
        if($statusUjian != ''){ $this->db->where('ambilan.statusUjian',$statusUjian);}        
        $this->db->group_by('ambilan.idAmbilan'); 
        return  $this->db->get($this->tableName)->result_array();       
    }//end method    
       
    //insert data
    public function save($data=null)    {
        if($data!=null){        
            $this->db->select('idAmbilan, kodUjian, siri, tahun, tarikhBuka, tarikhTutup, statusUjian,idWujud,tarikhWujud');
            $this->db->where('kodUJian',$data['kodUjian']);
            $this->db->where('siri',$data['siri']);
            $this->db->where('tahun',$data['tahun']);
            $query = $this->db->get($this->tableName);            
            if($query->num_rows() == 0) {
                $this->db->insert($this->tableName, $data);
                return true;
                flashMsg('Record Saved!','success');
             	redirect('pengaktifan/senggara_ujian');            
            } else {
                return '';
            }//end if             
        } else {
            return false;
        }//end if
    }//end method
    
    // update data
    public function update($id, $data=null){
        if($data!=null) {            
            //date_default_timezone_set('Asia/Kuala_Lumpur');
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('pengaktifan/senggara_ujian');            
        } else {
            return false;
        }//end if
    }//end method  
       
    public function update_status($id, $data=NULL){
        if($data!=null) {            
            //date_default_timezone_set('Asia/Kuala_Lumpur');
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('pengaktifan/senggara_ujian');            
        } else {
            return false;
        }//end if
    }//end method
   
    // delete data
    public function delete($id) {
        $this->db->where($this->pk,$id);
        $this->db->delete($this->tableName);
        return $this->db->affected_rows();
        //flashMsg('Record Deleted!','success');
        redirect('pengaktifan/senggara_ujian');
    }//end method
}//end class