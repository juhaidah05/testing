<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : Haezal Musa
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 */

class Site extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Eminda_model");
        $this->_ci =& get_instance();
    }//end method

    public function index() {
        redirect($this->controller.'/home');        
    }//end method
    
    public function home()  {
        $data['title'] = "Welcome to ".$this->config->item('site_name');
        if(!$this->authentication->is_logged_in()) { redirect('auth/login'); }
        $this->_render_page($data);        
    }//end method
}//end class