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
 *                      5. Baiki pernyataan SQL
 *                      6. Tukar nama class daripada tbl_semakpengguna_model
 *                         kepada semakpengguna_model
 */

class Semakpengguna_model extends CI_Model {
    private $tableName;
    private $pk;
    private $fk;
    private $created_date;
    private $created_by;
    private $updated_date;
    private $updated_by;
    
    function __construct(){
	parent::__construct();
        $this->tableName = "ambilan";
        $this->pk = "idAmbilan";
        $this->fk = "kodUjian";
        $this->created_date = "tarikhWujud";
        $this->created_by = "idWujud";
        $this->updated_date = "tarikhKemaskini";
        $this->updated_by = "idKemaskini";
    }//end method
        
    public function ambilan_aktif() {
        $this->db->select('idAmbilan, kodUjian, siri, tahun, tarikhBuka, tarikhTutup, tarikhMulaUlang, tarikhAkhirUlang, statusUjian');
        $this->db->where('statusUjian',1);
        $this->db->where('(CURDATE() BETWEEN tarikhBuka AND tarikhTutup');
        $this->db->or_where('CURDATE() BETWEEN tarikhMulaUlang AND tarikhAkhirUlang)');
        $query = $this->db->get($this->tableName);
        return $query->row_array();
    }//end method    
    
    public function semak_ujian($idAmbilan, $mykad) {
        $this->db->SELECT('MAX(idUjian) AS idUjian, COUNT(mykad) AS bil_ujian, MIN(statusUlang) AS statusUlang');
        $this->db->FROM('ujian');
        $this->db->WHERE('idAmbilan',$idAmbilan);
        $this->db->WHERE('mykad',$mykad);
        $query = $this->db->get();
        return $query->row_array();
    }//end method
}//end class