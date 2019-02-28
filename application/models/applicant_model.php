<?php

/*  Tarikh Cipta    :   ?
 *  Programmer      :   ptma208
 *  Tujuan Aturcara :   Model Class bagi ..
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Ringkaskan pernyataan if
 *                      4. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 *                      5. Comment Gallery_model()
 *                      6. Comment method ajaxdistrict()
 *                      7. Comment method ajaxklinik()
 *                      8. Comment method getapplicantdata()
 *                      9. Comment method getdata()
 *                      10. Comment method getdata_asma()
 */

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Applicant_Model extends CI_Model {
	
    public function __construct() {
	parent::__construct();		
    }//end method
    
    public function getdata_DASS(){  
        $query = $this->db->query("SELECT a.* FROM _kodUjian a WHERE a.kodUjian='DASS' ");
        return $query->result_array();
    }//end method
    
    public function getdata2($kodUjian){        
        $query = $this->db->query("SELECT a.kodUjian, b.idSoalan,b.soalan,b.idKategoriSoalan FROM _kodUjian a LEFT JOIN _soalan b ON a.kodUjian=b.kodUjian WHERE a.kodUjian='$kodUjian'");         
        return $query->result_array();
    }//end method
    
    public function getQuest($idSoalan){        
        $query = $this->db->query("SELECT * FROM _padananSJ WHERE idSoalan='$idSoalan'");         
	return $query->result_array();
    }//end method
    
    public function getansw($idSoalan){        
        $query = $this->db->query("SELECT a.*, c.* FROM _padananSJ a INNER JOIN _jawapan c ON a.idJawapan = c.idJawapan WHERE a.idSoalan='$idSoalan'");         
	return $query->result_array();
    }//end method
    
    public function getdatasoalan(){        
        $query = $this->db->query("SELECT a.*, c.desc_answ FROM lt_goalpscode a LEFT JOIN lt_answ_quest b ON a.id_answquest=b.id_answquest LEFT JOIN lt_answ_goals c ON b.id_answ=c.id_answ ORDER BY cd_goalpscode ASC");         
        return $query->result_array();
    }//end method
}//end class