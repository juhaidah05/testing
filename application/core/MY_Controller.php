<?php
/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Controller Class bagi proses capaian aplikasi
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (30 Sept 2015)   :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Ringkaskan pernyataan if
 *                      4. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->helper('form');				
        $this->load->helper('flashMsg');		
        $this->load->library('authentication');           
        //System wide : Show debug
        $this->debug = $this->config->item('debug');
        //User options : Show debug
        $this->controller = $this->uri->rsegment(1);
        $this->method = $this->uri->rsegment(2);
        //View Management
        (file_exists(APPPATH."views/".$this->controller."/".$this->method.".php")) ?
            $this->content_view = $this->controller."/".$this->method:$this->content_view = "not_found";         
    }//end method
	
    function _pre_printr($arr)	{
        echo "<pre>".print_r($arr)."</pre>";
    }//end method

    function _render_page($data='x'){
        ($data=='x')?
            $this->load->view($this->config->item('template')):$this->load->view($this->config->item('template'), $data);        
    }//end method
    
    function _render_page_No_template($data) {
        $this->load->view($this->content_view, $data);
    }//end method
        
    public function GetLogBrowser($inline = null) {
              $this->load->model('isis_model');
        $data['brohis'] = $this->isis_model->GetBrowser();
        if (!empty($inline)) {
            return $data['brohis'];
        } else {
            echo "<pre>";
            print_r($data['brohis']);
            exit;
        }//end if
    }//end method
    
    function UmEncode($string){
        if(!empty($string)){
            return $this->encryption->encode($this->encrypt->encode($string));
        }else{
            show_error("Please Call Ptm",404,"Security Issue");
        }//end if
    }//end method
    
    function UmDcode($string){
        if(!empty($string)){
            return $this->encrypt->decode($this->encryption->decode($string));
        } else {
            show_error("Please Call Ptm",404,"Security Issue");
        }//end if        
    }//end method
    
    function group_by($array, $colomn_name) {
        foreach ($array as $key => $val) { $output[$val[$colomn_name]][] = $val; }
        return $output;
    }//end method
}//end class