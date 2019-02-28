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
 *                      5. Ubah lokasi date_default_timezone_set('Asia/Kuala_Lumpur'); ke dlm method __construct()
 *                      6. Tukar nama class daripada tbl_senaraicalon_model
 *                         kepada senaraicalon_model
 */

class Senaraicalon_model extends CI_Model {
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
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method
        
    public function findAll($idAmbilan='', $kodJantina='', $idSkim='', $gred='', $kodJenisFasiliti='', $kodFasiliti='', $kodPenempatan='') {
        $this->db->select('MAX(B.idUjian) AS maxID, C.nama, C.mykad, C.jantina, F.perihalFasiliti, G.perihalPenempatan');
        $this->db->join('ujian B', 'B.idAmbilan=A.idAmbilan');
        $this->db->join('profil C', 'C.mykad=B.mykad');
        $this->db->join('perkhidmatan D', 'D.idPerkhidmatan=B.idPerkhidmatan');
        $this->db->join('_kodJenisFasiliti E', 'E.kodJenisFasiliti=D.jenisFasiliti');
        $this->db->join('_kodFasiliti F', 'F.kodFasiliti=D.lokasiBertugas');
        $this->db->join('_kodPenempatan G', 'G.kodPenempatan=D.penempatan');
        $this->db->where('B.mykad NOT IN (SELECT mykad FROM ujian WHERE statusUlang=0 AND idAmbilan=B.idAmbilan)', NULL, FALSE);
        $this->db->where('B.idAmbilan', $idAmbilan);                
        if($kodJantina!=''){ $this->db->where('C.jantina',$kodJantina); }
        if($idSkim!=''){ $this->db->where('D.skim',$idSkim); }
        if($gred!=''){ $this->db->where('D.gred',$gred);}
        if($kodJenisFasiliti!='') { $this->db->where('D.jenisFasiliti',$kodJenisFasiliti);}
        if($kodFasiliti!='') {$this->db->where('D.lokasiBertugas',$kodFasiliti); }
        if($kodPenempatan!=''){$this->db->where('D.penempatan',$kodPenempatan); }            
        $this->db->group_by('B.mykad');
        $this->db->order_by('C.nama', 'asc');
        if($condition!=''){$this->db->where($condition);}
        return $this->db->get($this->tableName)->result_array();
    }//end method
    
    // update data
    public function update($id, $data=null) {
        if($data!=null) {            
            //date_default_timezone_set('Asia/Kuala_Lumpur');
            $this->db->set($this->updated_by, $this->session->userdata('username'));
            $this->db->set($this->updated_date, "'".date('Y-m-d H:i:s')."'", FALSE);
            $this->db->where($this->pk,$id);
            $this->db->update($this->tableName, $data);
            return $this->db->affected_rows();
            flashMsg('Rekod Berjaya Dikemaskini!!','success');
            redirect('maintenance/senarai_modul');
        } else {
            return false;
        }//end if
    }//end method  
}//end class