<?php 

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Controller Class bagi proses capaian aplikasi
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (3 Sept 2015)   :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Buang $this->load->helper('html');
 *                      4. Ringkaskan pernyataan if
 *                      5. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends MY_Controller {    
    
    //menetapkan penggunaan model2 dan libraries
    function __construct() {
        parent::__construct();
        $this->load->model("Tbl_modulpengguna_model");
        $this->load->model("Eminda_model");
        $this->load->helper('html');
        $this->_ci =& get_instance();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method    
	
    function control(){
        $data['title'] = "Selenggara Kawalan Capaian";
        $data['dropdown_role'] = $this->Eminda_model->get_select_list('_peranan', array('key'=>'kodPeranan', 'val'=>'peranan'), 1);
        $data['checkbox_module'] = $this->Eminda_model->get_list('_modul','', array('statusAktif'=>'Y'),'');
        $this->_render_page($data);
    }//end method   
    
    function retrieve($id_role) {
        $curr_module = $this->Eminda_model->get_list('ModulPengguna', null, array('cdPeranan'=>$id_role, 'statusAktif'=>'Y'));
        echo json_encode($curr_module);
    }//end method
    
    function update() {        
        $data['role'] = $this->input->post('role');        
        $data['modulPeranan']['cdPeranan'] = $this->input->post('role');
        $cdModul = $this->input->post('cdModul');        
        if(is_array($cdModul)) {
            $this->Tbl_modulpengguna_model->delete($data['role']);
            foreach ($cdModul as $key => $value) {
                $data['modulPeranan']['cdModul'] = $value;
                $data['modulPeranan']['curAkses'] = 'RW';
                $cdSubModul1 = $this->input->post('cdSubModul1-'.$value);
                if(is_array($cdSubModul1)) {
                    foreach ($cdSubModul1 as $key1 => $value1) {
                    	$data['modulPeranan']['cdSubModul1'] = $value1;
                    	$this->Tbl_modulpengguna_model->save($data['modulPeranan']);
                    }//end foreach
                } else {
                    $this->Tbl_modulpengguna_model->save($data['modulPeranan']);
                }//end if
            }//end foreach
        }//end if
    }//end method        
}//end class