<?php 

/*  Tarikh Cipta    : ?
 *  Programmer      : Mohd. Aidil Mohd Nayan
 *  Tujuan Aturcara : Controller Class bagi proses pengambil ujian
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (11 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Buang $this->load->helper('html');
 *                      4. Ringkaskan pernyataan if
 *  (21 Sept 2015)  :   1. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 *                      2. Buang $this->load->library('email');
 * (maria 10.3.2016):   1. Line 148 ($this->_ci->session->unset_userdata('username');) tukar keatas
 *	(04 April 2016)	:	1. Comment out line 109, 124-126, 152-157	 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	
    function __construct() {
        parent::__construct(); 
	$this->_ci =& get_instance();
        $this->load->model("Eminda_model");
        $this->load->model("Tbl_pengguna_model");        
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }//end method
    
    function login(){
        $data['title'] = "Login";
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');        
        if($this->_ci->session->userdata('username') && $this->_ci->session->userdata('username') != '') {
           $data['username'] = $this->_ci->session->userdata('username');
        }//end if	
        if($data['username'] && $data['password']){
            $this->authentication->login();
        }//end if		                        
        $this->_render_page($data);
    }//end method   
	
    function logout() {
        $this->authentication->logout();
	return true;
    }//end method
    
    public function lost_password() {
        $data['title'] = "Lupa Kata Laluan";        
        if($_POST) {
            $data['model']['mykad'] = $this->input->post('mykad');
            $data['model']['new_password'] = $this->input->post('new_password');
            $data['model']['new_cpassword'] = $this->input->post('new_cpassword');            
        }//end if 
        // set form rules
        $this->form_validation->set_rules('mykad', '<b>IC No.</b>', 'required');//|callback__check_password');
        $this->form_validation->set_rules('new_password', '<b>New Password</b>', 'required|min_length[6]|max_length[100]|matches[new_cpassword]');
        $this->form_validation->set_rules('new_cpassword', '<b>Re enter New Password</b>', 'required|min_length[6]|max_length[100]');
        if($this->form_validation->run() == true)   {
            if($check['mykad'] != '') {
                flashMsg('Password Successfully Reset. Please Login Again', 'success');
                redirect($this->controller.'/login');
            } else {
                flashMsg('IC No. Not Exist. Please Try Again.', 'error');
                redirect($this->controller.'/'.$this->method);
            }//end if
            $check = $this->Eminda_model->get_one_field2('mykad',array('emel'=>$this->input->post('emel'),'mykad'=>$this->input->post('mykad')),'idPerkhidmatan','perkhidmatan');
            if(!empty($check)) {
                $this->Eminda_model->get_one_field('mykad,tarikhKemaskini',array('mykad'=>$this->input->post('mykad')),'pengguna');
                $userid = $this->input->post('mykad');
                $nama = $this->input->post('nama');
                $email = $this->input->post('email');
                $tarikhKemaskini=  date('d-m-Y');
                $katalaluan = $this->input->post('nokp');	
                //$this->load->library('email');
                $this->email->from('eminda@moh.gov.my', 'Aplikasi Saringan Minda Sihat');
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject('Penukaran Kata Laluan eMINDA');
                $this->email->message(
"Salam Sejahtera,
    
Kata laluan bagi pengguna " .$userid. " telah diset semula kepada 

R" .$userid. " berkuatkuasa pada " .$tarikhKemaskini. "

Tuan/puan adalah dinasihatkan untuk menukar semula kata laluan tersebut.
      
Terima Kasih.

Daripada,
Pentadbir eMINDA");
                $this->email->send();
                flashMsg('Penukaran Kata Laluan Berjaya.', 'success');
                redirect('auth/login');
                // update data
                $this->Eminda_model->update_data('pengguna',array('mykad'=>$userid),array('katalaluan' => md5("R".$userid),'tarikhKemaskini' => date('Y-m-d')));
            } else {
              flashMsg('Emel tidak wujud. Sila hubungi Pentadbir Sistem.', 'error');
            }//end if 
        }//end if
        $this->_render_page($data);        
    }//end method
    
    public function change_password(){
        if($_POST) {
            //$data['model']['old_password'] = $this->input->post('old_password');
            $data['model']['new_password'] = $this->input->post('new_password');
            $data['model']['new_cpassword'] = $this->input->post('new_cpassword');            
        }
        // set form rules
        $this->form_validation->set_rules('old_password', '<b>Kata Laluan Sedia Ada</b>', 'required');//|callback__check_password');
        $this->form_validation->set_rules('new_password', '<b>Kata Laluan Baru</b>', 'required|min_length[6]|max_length[100]|matches[new_cpassword]');
        $this->form_validation->set_rules('new_cpassword', '<b>Pengesahan Kata Laluan Baru</b>', 'required|min_length[6]|max_length[100]');
        $this->db->select('emel');
        $this->db->from('perkhidmatan');
        $this->db->where('mykad',$this->_ci->session->userdata('username'));
        $this->db->order_by("tarikhWujud","desc");
        $query_fasiliti = $this->db->get();
        $lokalitiP = $query_fasiliti->row_array();
        $email = $lokalitiP['emel'];        
        //if($this->form_validation->run() == true) {
            //$check = $this->Eminda_model->get_one_field('katalaluan',array('mykad'=>$this->_ci->session->userdata('username')),'pengguna');
            //if($check['katalaluan'] == md5($data['model']['old_password'])) {		
                $this->Eminda_model->update_data('pengguna',array('mykad'=>$this->_ci->session->userdata('username')),array('katalaluan' => md5($data['model']['new_password']),'re_katalaluan' => md5($data['model']['new_cpassword']),'idKemaskini'=>$this->_ci->session->userdata('username'),'tarikhKemaskini'=>date('Y-m-d') ));                       
                $tarikhKemaskini=  date('d-m-Y');                       
                $katalaluanbaru = $this->input->post('new_password');
                //$this->load->library('email');
                $this->email->from('eminda@moh.gov.my', 'Aplikasi Saringan Minda Sihat');
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject('Penukaran Kata Laluan eMINDA');
                $this->email->message(
"Salam Sejahtera,
    
Kata laluan bagi pengguna " .$this->_ci->session->userdata('username'). " telah ditukar kepada 
" .$katalaluanbaru. " berkuatkuasa pada " .$tarikhKemaskini. ".
      
Terima Kasih.

Daripada,
Pentadbir eMINDA");
				$this->email->send();
                flashMsg('Kata Laluan baru telah dihantar ke emel '.$email.'. Sila Semak. ', 'success');
                $this->_ci->session->unset_userdata('username');	
                $this->_ci->session->unset_userdata('id');
                redirect($this->controller.'/login');
               
            //}//end if 
			/*else {
                flashMsg('Kata Laluan sedia ada tidak sah. Sila cuba lagi', 'error');
                redirect($this->controller.'/'.$this->method);
            }//end if
			*/	
        //}//end if
        $this->_render_page($data);
    }//end method
    
    function _check_password($str) {
        $model = $this->model->findByPk($this->session->userdata('id'));        
        if($model['user_password'] != md5($str)){
            $this->form_validation->set_message('_check_password', 'Katalaluan lama yang dimasukkan tidak tepat');
            return false;
        } else {
            return true;
        }//end if
    }//end method
    
    public function lupa_password() {
        $mykad = $this->input->post('mykad');
        $emel = $this->input->post('emel');
        $check_pengguna = $this->Tbl_pengguna_model->check_pengguna($mykad, $emel);        
        if($check_pengguna) {            
            $userid = $mykad;
            $email = $emel;
            $tarikhKemaskini=  date('d-m-Y');
            $data['pengguna']['katalaluan'] = md5("R".$mykad);
            $data['pengguna']['re_katalaluan'] = md5("R".$mykad);
            $this->Tbl_pengguna_model->update($mykad, $data['pengguna']);
            if($this->input->is_ajax_request()){
                echo "Kata Laluan Berjaya Direset!";
            } else {
                flashMsg('Kata Laluan Berjaya Direset!','success');
                redirect('carian/pengguna');
            }//end if
            //$this->load->library('email');
            $this->email->from('eminda@moh.gov.my', 'Aplikasi Saringan Minda Sihat');
            $this->email->to($email);
            $this->email->cc('');
            $this->email->bcc('');
            $this->email->subject('Penukaran Kata Laluan eMINDA');
            $this->email->message(
    "Salam Sejahtera,

    Kata laluan bagi pengguna " .$userid. " telah diset semula kepada 

    R".$userid." berkuatkuasa pada " .$tarikhKemaskini. "

    Tuan/puan adalah dinasihatkan untuk menukar semula kata laluan tersebut.

    Terima Kasih.

    Daripada,
    Pentadbir eMINDA");
            $this->email->send();
        } else {
            echo "No. Mykad Atau Emel Tiada Dalam Pendaftaran eMINDA!";
        }//end if        
        if(!$this->input->is_ajax_request()){ $this->_render_page($data); }        
    }//end method
}//end class