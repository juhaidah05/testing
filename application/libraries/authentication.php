<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Authentication {
    private $_ci;  
    private $table_name = "pengguna";
    private $field_username = "mykad";
    private $field_password = "katalaluan";
    private $field_lokaliti = "lokaliti";
    private $field_active= "status";
    //private $field_dtupdated = "dtupdated";
    private $field_dtlastlogin = "dtlastlogin";
    
    function __construct() {
        $this->_ci =& get_instance(); // get the CodeIgniter object
    	date_default_timezone_set('Asia/Kuala_Lumpur');
    }// end function
    
    public function _join(){
    }// end function   
    
    public function getData() {
        $this->_ci->db->where('user_id', $this->_ci->session->userdata('id'));
        $this->_join();
        return $this->_ci->db->get($this->table_name)->row_array();
    }// end function 
 
    public function isAdmin() {
        $username = $this->_ci->session->userdata("username");
        $this->_ci->db->where(array($this->field_username=>$username));
        $data = $this->_ci->db->get($this->table_name)->row_array(); // check valid user
        return ($data['cd_role'] == 1)?true:false;
    }// end function
     
    function check($_lock_to_role=null, $_only=null) {
        if(!$this->is_logged_in()) {
            flashMsg("Login required",'error');
            redirect('auth/login');
        }
    }// end function
   
    function login(){
        $username = $this->_ci->input->post('username'); // get username from post
        $password = $this->_ci->input->post('password'); // get password from post
        $this->_ci->form_validation->set_rules('username', '<b>Username</b>', 'required|xss_clean');
        $this->_ci->form_validation->set_rules('password', '<b>Password</b>', 'required|xss_clean');        
        if($this->_ci->form_validation->run() == true) {
            $this->check_login($username, md5($password)); // enable this for encypted password
        }
    }// end function
    
    function check_login($username, $password){
		
        $this->_ci->db->where(array($this->field_username=>$username, $this->field_password=>$password));
        $data = $this->_ci->db->get($this->table_name)->row_array(); // check valid user
                
      	if($data){			
            if($data[$this->field_active] == '1') {				
            $this->_ci->db->select('profil.nama, profil.mykad, pengguna.katalaluan'); 
            $this->_ci->db->where('profil.mykad',$data[$this->field_username]);
            $this->_ci->db->join('profil', 'profil.mykad = pengguna.mykad', 'left');   
            $query = $this->_ci->db->get('pengguna');
            $info = $query->row_array();
            $data['nama'] = $info['nama'];
			$data['mykad'] = $info['mykad'];
			$data['katalaluan'] = $info['katalaluan'];

            $this->_ci->session->set_userdata("username", $data[$this->field_username]);
            $this->_ci->session->set_userdata("nama", $data['nama']);
			$this->_ci->session->set_userdata("mykad", $data['mykad']);
			$this->_ci->session->set_userdata("katalaluan", $data['katalaluan']);
            $this->_ci->session->set_userdata("lokaliti", $data[$this->field_lokaliti]);
            $this->_ci->session->set_userdata("role", $data['levelAdmin']);

            if($data['levelAdmin']==0){

                $this->_ci->db->where(array('statusUjian'=>1));
                $ambilan = $this->_ci->db->get('ambilan')->row_array(); // check valid user
                $this->_ci->session->set_userdata("idAmbilan", $ambilan['idAmbilan']);
                $this->_ci->session->set_userdata("kodUjian", $ambilan['kodUjian']);

                $this->_ci->session->set_userdata("username", $data[$this->field_username]);
                $this->_ci->session->set_userdata("nama", $data['nama']);
				
				$this->_ci->session->set_userdata("mykad", $data['mykad']);
				$this->_ci->session->set_userdata("katalaluan", $data['katalaluan']);
				
                $this->_ci->session->set_userdata("lokaliti", $data[$this->field_lokaliti]);
                $this->_ci->session->set_userdata("role", $data['levelAdmin']);
                $this->_ci->session->set_userdata("idAmbilan", $ambilan['idAmbilan']);
                $this->_ci->session->set_userdata("kodUjian", $ambilan['kodUjian']);
                $this->_ci->session->set_userdata("kemas", 1);
                $this->_ci->session->set_userdata("soal", 2);
                $id = $this->_ci->session->userdata('username');
                $mykad = $this->_ci->session->userdata('username');
                $role = $this->_ci->session->userdata('role');

                $this->_ci->db->select("*");			
                $this->_ci->db->from('ujian');
                $this->_ci->db->join('ambilan', 'ambilan.idAmbilan = ujian.idAmbilan', 'left');
                $this->_ci->db->where('ujian.mykad',$id);
                $this->_ci->db->where('ambilan.kodUjian = "DASS"');  
                $this->_ci->db->where('ambilan.statusUjian = "1"'); 
                $this->_ci->db->order_by('ujian.tarikhWujud','desc');
                $query_ujian = $this->_ci->db->get();
                $ujianA = $query_ujian->row_array();

                $statusJawabA = $ujianA['statusJawab'];
                $statusUlangA = $ujianA['statusUlang'];
                $statusUjian = $ujianA['statusUjian'];

                $tarikhUjianA = date('d M Y',strtotime($ujianA['tarikhUjian']));

                if(($statusJawabA==1) && ($statusUlangA==0) && ($statusUjian==1)  ){
                    //flashMsg('Pengguna '.$id. ' telah selesai menjawab ujian DASS pada '.$tarikhUjianA , 'success');
                    //redirect('question/soalan1_tq_2/'.$mykad);
                    redirect('utama/semak_ujian');
                } else if (($statusJawabA==1) && ($statusUlangA==1) && ($statusUjian==1)) { 
                    //redirect('question/kemaskini_pengguna/'.$mykad);
                    redirect('utama/semak_ujian');
                }					

                flashMsg('Login Berjaya', 'success');
                redirect('utama/semak_ujian');

                } else {
                    flashMsg('Login Berjaya', 'success');
                    redirect('carian/pengguna');
                }			
                	
            } else {
                flashMsg('Pengguna tidak aktif. Sila hubungi Pentadbir Sistem.', 'error');
                redirect('auth/login');                
            }			
        } else {
            flashMsg('Kombinasi ID Pengguna dan Kata Laluan salah. Sila cuba lagi.', 'error');
            redirect('auth/login');
            return false; // no record
        }//end if...
    }// end function
    
    function is_logged_in() { // checking for user authentication
        if(!$this->_ci->session->userdata('username') || $this->_ci->session->userdata('username') == ""){
            return false;
        } else{
            return $this->checkAuthntication($this->_ci->session->userdata('username'));
        }
    }// end function
     
    function checkAuthntication($mmusername) {
        $this->_ci->db->select($this->field_username);
        $this->_ci->db->where($this->field_username,$mmusername);
        $query1 = $this->_ci->db->get($this->table_name);
        $res1=$query1->row_array();
        return($res1) ? true:false;
    }// end function
	
    function logout() {		
        // update bil login
        $this->_ci->db->where('mykad', $this->_ci->session->userdata('id'));
        $this->_ci->session->unset_userdata('username');	
        $this->_ci->session->unset_userdata('id');	
        $this->_ci->session->sess_destroy();
        //redirect('auth/login');
        return true;
    }// end function
    
    function get_name(){
        $this->_ci->db->select('name');
        $this->_ci->db->join('profile', 'profile.user_id = user.id', 'left');
        $this->_ci->db->where($this->field_username,$this->_ci->session->userdata('username'));

        $query1 = $this->_ci->db->get($this->table_name);
        $res1=$query1->row_array();
        return $res1['name'];
    } // end function
	
    function get_photo($id=null) {
        $this->_ci->db->select('file_name');
        $this->_ci->db->join('user_photo', 'user_photo.user_id = user.id', 'left');
        if($id!=null) $this->_ci->db->where('user.id', $id);
            $this->_ci->db->where($this->field_username,$this->_ci->session->userdata('username'));
            $query1 = $this->_ci->db->get($this->table_name);
            $res1=$query1->row_array();
            return $res1['file_name'];
	}// end function
	
    function get_role(){
        $this->_ci->db->select('group_id');
        $this->_ci->db->where($this->field_username,$this->_ci->session->userdata('username'));
        $query1 = $this->_ci->db->get($this->table_name);
        $res1=$query1->row_array();
        return $res1['group_id'];
    }// end function
        
    function login_count($username){
        if($username != '') {
            $this->_ci->db->where($this->field_username,$username);
            $query1 = $this->_ci->db->get($this->table_name);
            $res1=$query1->row_array();
        }
    }
	
    function details() {
        $this->_ci->db->where($this->field_username,$this->_ci->session->userdata('username'));
        $query1 = $this->_ci->db->get($this->table_name);
        $res1=$query1->row_array();
        return $res1;
    }// end function
	
    function leader(){		
        $this->_ci->db->where($this->field_username,$this->_ci->session->userdata('username'));
        $query = $this->_ci->db->get($this->table_name);
        $res1=$query->row_array();
        $_position = $res1['position_id'];
        
        // check position is leader or not        
        $this->_ci->db->where('id',$_position);

        $query1 = $this->_ci->db->get('ref_position')->row_array();
        if($query1['leader'] == 1){
            return true;
        } else {
            return ($this->get_role() == "1")? true:false;
        }
    }// end function
}