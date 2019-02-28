<?php
class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        // load model
        // put your model Class
        $this->_ci =& get_instance();
        $this->load->model("Tbl_tr_userregistration_model");
        $this->load->model("Chimss_model");
        $this->load->helper('html');

        
    }
  
 
  
  
  function facilityType() {
      
      $id = $this->input->post('id');
      $data = $this->Tbl_tr_userregistration_model->ajaxFacilityType($id);
      
      //echo $data;
      echo '<select class="input-xlarge" id="cd_facilitytype" name="cd_facilitytype">';
      echo '<option value="">-- Please Select --</option>';
      foreach ($data as $index => $value) {
          //echo '<pre>'.print_r($value).'</pre>';
          echo '<option value="'.$value['cd_facilitytype'].'">'.$value['decs_facilitytype'].'</option>';
      }
      echo '</select>';
      
  }
  
   function facilityName() {
      
      $id = $this->input->post('id');
      $data = $this->Tbl_tr_userregistration_model->ajaxFacilityName($id);
      
      echo '<select class="input-xlarge" id="usr_facilitycode" name="usr_facilitycode">';
      echo '<option value="">-- Please Select --</option>';
      foreach ($data as $index => $value) {
          //echo '<pre>'.print_r($value).'</pre>';
          echo '<option value="'.$value['facilitycode'].'">'.$value['FullName'].'</option>';
      }
      echo '</select>';
      
  }

 function facilityNameType() {
      
      $state = $this->input->post('state');      
      $fcode = $this->input->post('fcode'); 
      $id = $this->input->post('id');  
      $data = $this->Tbl_tr_userregistration_model->ajaxFacilityNameType($state, $fcode, $id);
      
      echo '<select class="input-xlarge" id="usr_facilitycode" name="usr_facilitycode">';
      echo '<option value="">-- Please Select --</option>';
      foreach ($data as $index => $value) {
          //echo '<pre>'.print_r($value).'</pre>';
          echo '<option value="'.$value['facilitycode'].'">'.$value['FullName'].'</option>';     
          }
      echo '</select>';
      
  }
  
//    function agencyType_add() {
//      
//      $id = $this->input->post('id');
//      $data = $this->Tbl_tr_userregistration_model->ajaxagencyType_add($id);
//      
//      echo '<select class="input-xlarge" id="cd_agencytype" name="cd_agencytype">';
//      echo '<option value="">-- Please Select --</option>';
//      foreach ($data as $index => $value) {
//          //echo '<pre>'.print_r($value).'</pre>';
//          echo '<option value="'.$value['cd_agencytype'].'">'.$value['decs_agenctype'].'</option>';
//      }
//      echo '</select>';
//      
//  }

  
     function facilityType_add() {
      
      $id = $this->input->post('id');
      $data = $this->Tbl_tr_userregistration_model->ajaxfacilityType_add($id);
      
      //echo $data;
      
      echo '<select class="input-xlarge" id="cd_facilitytype" name="cd_facilitytype">';
      echo '<option value="">-- Please Select --</option>';
      foreach ($data as $index => $value) {
         // echo '<pre>'.print_r($value).'</pre>';
          echo '<option value="'.$value['cd_facilitytype'].'">'.$value['decs_facilitytype'].'</option>';
      }
      echo '</select>';
      
  }
  
  function facilityName_add() {

      
        
      $state = $this->input->post('state');      
      $fcode = $this->input->post('fcode'); 
      $id = $this->input->post('id');   
       
      $data = $this->Tbl_tr_userregistration_model->ajaxfacilityName_add($state, $fcode, $id);
          
    //  echo $data;
      
       echo '<select class="input-xlarge" id="usr_facilitycode" name="usr_facilitycode">';
      echo '<option value="">-- Please Select --</option>';
      foreach ($data as $index => $value) {
       //echo '<pre>'.print_r($value).'</pre>';
          echo '<option value="'.$value['facilitycode'].'">'.$value['FullName'].'</option>';
      }
      echo '</select>';
      
  }
  
  
  
  function update($id){

       $data = $this->Chimss_model->get_info('tr_userregistration', array('usr_regnumber'=>$id));
//       print_r($data);
//       exit;        
       
       // echo '<pre>'.print_r($data).'</pre>';
        $data['title'] = "UPDATE REGISTRATION";
        $data['userregistration']['usr_active'] = $this->input->post('usr_active');
        $data['userregistration']['usr_icno'] = $this->input->post('usr_icno');
        $data['userregistration']['usr_fullname'] = $this->input->post('usr_fullname');
        $data['userregistration']['usr_profesion'] = $this->input->post('usr_profesion');
        $data['userregistration']['usr_profesion_regnumber'] = $this->input->post('usr_profesion_regnumber');
        $data['userregistration']['cd_agencytype'] = $this->input->post('cd_agencytype');
        $data['userregistration']['cd_facilitytype'] = $this->input->post('cd_facilitytype');
        $data['userregistration']['usr_facilitycode'] = $this->input->post('usr_facilitycode');
        $data['userregistration']['usr_facilityaddr1'] = $this->input->post('usr_facilityaddr1');
        $data['userregistration']['usr_facilityaddr2'] = $this->input->post('usr_facilityaddr2');
        $data['userregistration']['usr_facilityaddr3'] = $this->input->post('usr_facilityaddr3');
        $data['userregistration']['usr_facilityposcode'] = $this->input->post('usr_facilityposcode');
        $data['userregistration']['usr_cdstate'] = $this->input->post('usr_cdstate');
        $data['userregistration']['usr_phonenumber'] = $this->input->post('usr_phonenumber');
        $data['userregistration']['usr_hponenumber'] = $this->input->post('usr_hponenumber');
        $data['userregistration']['usr_faxnumber'] = $this->input->post('usr_faxnumber');
        $data['userregistration']['usr_email'] = $this->input->post('usr_email');
            if($data['usr_id']!= $this->input->post('usr_id'))
            {
                $data['userregistration']['usr_id'] = $this->input->post('usr_id');
            }
        $data['userregistration']['cd_role'] = $this->input->post('cd_role');
        
        
        $data['userregistration']['cd_securityquestion'] = $this->input->post('cd_securityquestion');
        $data['userregistration']['securityanswer'] = $this->input->post('securityanswer');

       //untuk buat dropdown
       $data['status'] = array(''=>'-- Please Select --', 'A'=>'Aktif', 'T'=>'Tidak');   
       $data['profession'] = $this->Chimss_model->get_select_list('lt_profession', array('key'=>'cd_profession', 'val'=>'desc_profession', 'orderby'=>'cd_casestatus'),1);  
       $data['agency'] = $this->Chimss_model->get_select_list('lt_agencytype', array('key'=>'cd_agencytype', 'val'=>'decs_agenctype', 'orderby'=>'cd_agencytype'),1); 
       $data['state'] = $this->Chimss_model->get_select_list('lt_state', array('key'=>'cd_state', 'val'=>'desc_state', 'orderby'=>'cd_state'),1);
       $data['facilitytype'] = $this->Chimss_model->get_select_list('lt_facilitytype', array('key'=>'cd_facilitytype', 'val'=>'decs_facilitytype', 'orderby'=>'cd_facilitytype'), 0, array('active_status'=>'Y','cd_agencytype'=>$data['cd_agencytype']));        
       $data['namefacility'] = $this->Chimss_model->get_select_list('lt_facilities', array('key'=>'facilitycode', 'val'=>'FullName', 'orderby'=>'facilitycode'), 0, array('active_status'=>'Y','State'=>$data['usr_cdstate']));      
       $data['role'] = $this->Chimss_model->get_select_list('lt_role', array('key'=>'cd_role', 'val'=>'desc_role', 'orderby'=>'cd_role'), 1, array('active_status'=>'Y'));        
       $data['secquestion'] = $this->Chimss_model->get_select_list('lt_secquestion', array('key'=>'cd_securityquestion', 'val'=>'desc_securityquestion', 'orderby'=>'cd_securityquestion'), 1);
        
//       print_r($data['namefacility']);
//       exit;
       //form validation
        
        $this->form_validation->set_rules('usr_active','User Active','required');
        $this->form_validation->set_rules('usr_icno','User IC NO','required|max_length[14]');
        $this->form_validation->set_rules('usr_fullname','User Name','required');
        $this->form_validation->set_rules('usr_profesion','Profession','required');
        $this->form_validation->set_rules('cd_agencytype','Agency','required');
        $this->form_validation->set_rules('usr_facilityaddr1','Adress','required');
        $this->form_validation->set_rules('cd_facilitytype','Type of Facilities','required');
        $this->form_validation->set_rules('usr_facilitycode','Name of Facilities','required');
        $this->form_validation->set_rules('usr_cdstate','State','required');       
        $this->form_validation->set_rules('usr_facilityposcode','Facility Poscode','required');
        $this->form_validation->set_rules('usr_phonenumber','Phone Number','required');
        $this->form_validation->set_rules('usr_id','User Id','required');
        $this->form_validation->set_rules('cd_role','Role','required');
        //$this->form_validation->set_rules('usr_password','Password','required');
        //$this->form_validation->set_rules('usr_repassword','Reconfirm Password','required');
        $this->form_validation->set_rules('cd_securityquestion','Security Question','required');
        $this->form_validation->set_rules('securityanswer','Answer Question','required');
        
        
    if($this->form_validation->run() == true){

        
            $update_id = $this->Tbl_tr_userregistration_model->update($id,$data['userregistration']);

            if($update_id == '1') {     

                flashMsg('Record Updated','success');
                redirect('admin/listing');
                
            }else{
                
               flashMsg('User Id Already Exists!','success');
               redirect('admin/listing');
            }
     }
        
     
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){
        $this->_render_page($data);
        }
        //$this->_render_page($data);
    }
    
    
    
  function view($id){

       
        
        $data = $this->Chimss_model->get_info('tr_userregistration', array('usr_regnumber'=>$id));
        
        //echo '<pre>'.print_r($data).'</pre>';
        $data['title'] = "VIEW REGISTRATION";
        $data['userregistration']['usr_active'] = $this->input->post('usr_active');
        $data['userregistration']['usr_icno'] = $this->input->post('usr_icno');
        $data['userregistration']['usr_fullname'] = $this->input->post('usr_fullname');
        $data['userregistration']['usr_profesion'] = $this->input->post('usr_profesion');
        $data['userregistration']['usr_profesion_regnumber'] = $this->input->post('usr_profesion_regnumber');
        $data['userregistration']['cd_agencytype'] = $this->input->post('cd_agencytype');
        $data['userregistration']['cd_facilitytype'] = $this->input->post('cd_facilitytype');
        $data['userregistration']['usr_facilitycode'] = $this->input->post('usr_facilitycode');
        $data['userregistration']['usr_facilityaddr1'] = $this->input->post('usr_facilityaddr1');
        $data['userregistration']['usr_facilityaddr2'] = $this->input->post('usr_facilityaddr2');
        $data['userregistration']['usr_facilityaddr3'] = $this->input->post('usr_facilityaddr3');
        $data['userregistration']['usr_facilityposcode'] = $this->input->post('usr_facilityposcode');
        $data['userregistration']['usr_cdstate'] = $this->input->post('usr_cdstate');
        $data['userregistration']['usr_phonenumber'] = $this->input->post('usr_phonenumber');
        $data['userregistration']['usr_hponenumber'] = $this->input->post('usr_hponenumber');
        $data['userregistration']['usr_faxnumber'] = $this->input->post('usr_faxnumber');
        $data['userregistration']['usr_email'] = $this->input->post('usr_email');
        $data['userregistration']['usr_id'] = $this->input->post('usr_id');
        $data['userregistration']['cd_role'] = $this->input->post('cd_role');
        //$data['userregistration']['usr_password'] = $this->input->post('usr_password');
        //$data['userregistration']['usr_repassword'] = $this->input->post('usr_repassword');
        $data['userregistration']['cd_securityquestion'] = $this->input->post('cd_securityquestion');
        $data['userregistration']['securityanswer'] = $this->input->post('securityanswer');

       

        //untuk buat dropdown
        $data['status'] = array(''=>'-- Please Select --', 'Y'=>'Yes', 'N'=>'No');   
        $data['profession'] = $this->Chimss_model->get_select_list('lt_profession', array('key'=>'cd_profession', 'val'=>'desc_profession', 'orderby'=>'cd_casestatus'),1);  
        $data['agency'] = $this->Chimss_model->get_select_list('lt_agencytype', array('key'=>'cd_agencytype', 'val'=>'decs_agenctype', 'orderby'=>'cd_agencytype'),1);
        $data['facilitytype'] = $this->Chimss_model->get_select_list('lt_facilitytype', array('key'=>'cd_facilitytype', 'val'=>'decs_facilitytype', 'orderby'=>'cd_facilitytype'), 1, array('active_status'=>'Y'));
        $data['namefacility'] = $this->Chimss_model->get_select_list('lt_facilities', array('key'=>'facilitycode', 'val'=>'FullName', 'orderby'=>'facilitycode'), 1);
        $data['state'] = $this->Chimss_model->get_select_list('lt_state', array('key'=>'cd_state', 'val'=>'desc_state', 'orderby'=>'cd_state'),1);
        $data['role'] = $this->Chimss_model->get_select_list('lt_role', array('key'=>'cd_role', 'val'=>'desc_role', 'orderby'=>'cd_role'), 1, array('active_status'=>'Y'));
        $data['secquestion'] = $this->Chimss_model->get_select_list('lt_secquestion', array('key'=>'cd_securityquestion', 'val'=>'desc_securityquestion', 'orderby'=>'cd_securityquestion'), 1);
        
        $this->_render_page($data);
               
    }
    

    //LISTING CASE STATUS
    function listing(){
        
        
        
        $data = $this->Chimss_model->get_info('tr_userregistration', array('usr_regnumber'=>$id));
         //echo '<pre>'.print_r($data).'</pre>';
        
        $data['userregistration']['usr_regnumber'] = $this->input->post('usr_regnumber');
        $data['userregistration']['usr_fullname'] = $this->input->post('usr_fullname');
         
        $data['title'] = "List of CHIMSS's User";
        $data['state'] = $this->Chimss_model->get_select_list('lt_state', array('key'=>'cd_state', 'val'=>'desc_state', 'orderby'=>'cd_state'),1);
        $data['agency'] = $this->Chimss_model->get_select_list('lt_agencytype', array('key'=>'cd_agencytype', 'val'=>'decs_agenctype', 'orderby'=>'cd_agencytype'), 1);
        $data['facilitytype'] = $this->Chimss_model->get_select_list('lt_facilitytype', array('key'=>'cd_facilitytype', 'val'=>'decs_facilitytype', 'orderby'=>'cd_facilitytype'), 1, array('active_status'=>'Y'));
        $data['namefacility'] = $this->Chimss_model->get_select_list('lt_facilities', array('key'=>'facilitycode', 'val'=>'FullName', 'orderby'=>'facilitycode'), 1);
        $data['status'] = array(''=>'-- Please Select --', 'Y'=>'Yes', 'N'=>'No');   
        
        
        $this->form_validation->set_rules('usr_regnumber','User Registration');
        
        
        $this->_render_page($data);
    }
   
    
      function add(){
          
        $data['title'] = "USER REGISTRATION";
          
        // untuk post data
        
        $data['userregistration']['usr_active'] = $this->input->post('usr_active');
        $data['userregistration']['usr_icno'] = $this->input->post('usr_icno');
        $data['userregistration']['usr_fullname'] = $this->input->post('usr_fullname');
        $data['userregistration']['usr_profesion'] = $this->input->post('usr_profesion');
        $data['userregistration']['usr_profesion_regnumber'] = $this->input->post('usr_profesion_regnumber');
        $data['userregistration']['cd_agencytype'] = $this->input->post('cd_agencytype');
        $data['userregistration']['cd_facilitytype'] = $this->input->post('cd_facilitytype');
        $data['userregistration']['usr_facilitycode'] = $this->input->post('usr_facilitycode');
        $data['userregistration']['usr_facilityaddr1'] = $this->input->post('usr_facilityaddr1');
        $data['userregistration']['usr_facilityaddr2'] = $this->input->post('usr_facilityaddr2');
        $data['userregistration']['usr_facilityaddr3'] = $this->input->post('usr_facilityaddr3');
        $data['userregistration']['usr_facilityposcode'] = $this->input->post('usr_facilityposcode');
        $data['userregistration']['usr_cdstate'] = $this->input->post('usr_cdstate');
        $data['userregistration']['usr_phonenumber'] = $this->input->post('usr_phonenumber');
        $data['userregistration']['usr_hponenumber'] = $this->input->post('usr_hponenumber');
        $data['userregistration']['usr_faxnumber'] = $this->input->post('usr_faxnumber');
        $data['userregistration']['usr_email'] = $this->input->post('usr_email');
        $data['userregistration']['usr_id'] = $this->input->post('usr_id');
        $data['userregistration']['cd_role'] = $this->input->post('cd_role');
        
        
         
//        if($this->input->post('usr_password')!= '') {
//          $data['userregistration']['usr_password'] =  md5($this->input->post('usr_password'));
          $data['userregistration']['usr_password'] =  md5('abcd1234');
//        }
        
//       if($this->input->post('usr_repassword')!= '') {
//          $data['userregistration']['usr_repassword']= md5($this->input->post('usr_repassword'));
          $data['userregistration']['usr_repassword']= md5('abcd1234');
//        }
        
         
        $data['userregistration']['cd_securityquestion'] = $this->input->post('cd_securityquestion');
        $data['userregistration']['securityanswer'] = $this->input->post('securityanswer');



        //untuk buat dropdown
        $data['status'] = array(''=>'-- Please Select --', 'Y'=>'Yes', 'N'=>'No');   
        $data['profession'] = $this->Chimss_model->get_select_list('lt_profession', array('key'=>'cd_profession', 'val'=>'desc_profession', 'orderby'=>'cd_casestatus'),1);  
        $data['agency'] = $this->Chimss_model->get_select_list('lt_agencytype', array('key'=>'cd_agencytype', 'val'=>'decs_agenctype', 'orderby'=>'cd_agencytype'),1);
        $data['facilitytype'] = $this->Chimss_model->get_select_list('lt_facilitytype', array('key'=>'cd_facilitytype', 'val'=>'decs_facilitytype', 'orderby'=>'cd_facilitytype'), 1, array('active_status'=>'Y'));
        $data['namefacility'] = $this->Chimss_model->get_select_list('lt_facilities', array('key'=>'facilitycode', 'val'=>'FullName', 'orderby'=>'facilitycode'), 1);
        $data['state'] = $this->Chimss_model->get_select_list('lt_state', array('key'=>'cd_state', 'val'=>'desc_state', 'orderby'=>'cd_state'),1);
        $data['role'] = $this->Chimss_model->get_select_list('lt_role', array('key'=>'cd_role', 'val'=>'desc_role', 'orderby'=>'cd_role'), 1, array('active_status'=>'Y'));
        $data['secquestion'] = $this->Chimss_model->get_select_list('lt_secquestion', array('key'=>'cd_securityquestion', 'val'=>'desc_securityquestion', 'orderby'=>'cd_securityquestion'), 1);
        
        //form validation
        
        $this->form_validation->set_rules('usr_active','User Active','required');
        $this->form_validation->set_rules('usr_icno','User IC NO','required|max_length[14]');
        $this->form_validation->set_rules('usr_fullname','User Name','required');
        $this->form_validation->set_rules('usr_profesion','Profession','required');
        $this->form_validation->set_rules('cd_agencytype','Agency','required');
        $this->form_validation->set_rules('cd_facilitytype','Type of Facilities','required');
        $this->form_validation->set_rules('usr_facilitycode','Name of Facilities','required');
        $this->form_validation->set_rules('usr_cdstate','State','required');
        $this->form_validation->set_rules('usr_facilityaddr1','Facility Address','required');
        $this->form_validation->set_rules('usr_facilityposcode','Facility Poscode','required');
        $this->form_validation->set_rules('usr_phonenumber','Telephone Number','required');
        $this->form_validation->set_rules('usr_id','User Id','required');
        $this->form_validation->set_rules('cd_role','Role','required');
//        $this->form_validation->set_rules('usr_password','Password','required');
//        $this->form_validation->set_rules('usr_repassword','Reconfirm Password','required');
        $this->form_validation->set_rules('cd_securityquestion','Security Question','required');
        $this->form_validation->set_rules('securityanswer','Answer Question','required');
        
        
       if($this->form_validation->run() == true){
      
        $insert_id = $this->Tbl_tr_userregistration_model->save($data['userregistration']);
        
              
                  
          if($insert_id == '1') {    
        
         //echo '<pre>'.print_r($insert_id).'</pre>';
        
            //if($this->input->is_ajax_request()){
              
              
            
                        $userid = $this->input->post('usr_id');
                        $name = $this->input->post('usr_fullname');
                        $emel = $this->input->post('usr_email');	
//			$password = $this->input->post('usr_password');	
			$password = 'abcd1234';	
			
			$this->load->library('email');
			$this->email->from('chimss@moh.gov.my', 'Bahagian Kawalan Penyakit');
			$this->email->to($emel);
			$this->email->cc('');
			$this->email->bcc('');
			$this->email->subject('Maklumat Password dan Username');
			$this->email->message(
"Dear " .$name. ",

Congratulations on your CHIMSS registration.      
Your User ID and Password are shown below : 							   
...............................................

User ID : " .$userid. "
Password  : " .$password. "

............................................... 
Thank you.

Yours sincerely,
CHIMSS Administrator ");

			$this->email->send();
			//echo $this->email->print_debugger();						
			flashMsg('Registration successful. Your User ID and Password have been sent to the registered email address.', 'success');
			redirect('admin/listing');
			
                
       
                
                echo "Record Saved!";

                flashMsg('Record Saved!','success');
                redirect('admin/listing');

            
             } else {
                //echo "Record Code Already Exists!";
                
                flashMsg('User Id Already Exists!','success');
                redirect('admin/listing');
             }
            
      
         
       }
        
        // untuk table tbl_users
        if(!$this->input->is_ajax_request()){
        $this->_render_page($data);
        }
    }

    

    function listJson(){
        
        if($this->input->post('usr_id') != '') {
            $data['search']['tr_userregistration.usr_id'] = $this->input->post('usr_id');
        }
        
        if($this->input->post('usr_fullname') != '') {
            $data['like_search']['tr_userregistration.usr_fullname'] = $this->input->post('usr_fullname');
        }
        
         if($this->input->post('usr_cdstate') != '') {
            $data['search']['tr_userregistration.usr_cdstate'] = $this->input->post('usr_cdstate');
        }
        
        if($this->input->post('cd_agencytype') != '') {
            $data['search']['tr_userregistration.cd_agencytype'] = $this->input->post('cd_agencytype');
        }
        
          if($this->input->post('usr_facilitycode') != '') {
            $data['search']['tr_userregistration.usr_facilitycode'] = $this->input->post('usr_facilitycode');
        }
        
         if($this->input->post('usr_active') != '') {
            $data['search']['tr_userregistration.usr_active'] = $this->input->post('usr_active');
        }
        
        $users = $this->Tbl_tr_userregistration_model->searchCases($data['search'], $data['like_search']);
        
         
        
        //set template
        $this->table->set_template(array(
            'table_open'=>'<table class="table table-condensed table-bordered table-striped table-hover dynamic">',
        ));

        //set table heading
        $this->table->set_heading(array(
            array('data'=>'User Id'),
            array('data'=>'User Name', 'width'=>'300px'),
            array('data'=>'IC.No/Passport'),
            array('data'=>'Facilities Name'),
            array('data'=>'State'),
          'Action'
        ));
        

                
        //set table data
        
        
        $bil = 1;
        foreach ($users as $key => $val) {
        $button = "<a href='view/".$val['usr_regnumber']."' class='btn btn-mini' id='view'  title='View User Information' attr='".$val['usr_regnumber']."'><i class='icon icon-zoom-in'></i></a>";
        $button .= nbs(1)."<a href='update/".$val['usr_regnumber']."' class='btn btn-mini' id='update' title='Update User Information' attr='".$val['usr_regnumber']."'><i class='icon icon-edit'></i></a>";
        $button .= nbs(1)."<a href='javascript:void(0);' class='btn btn-mini' title='Delete User Information' id='delete' attr='".$val['usr_regnumber']."'><i class='icon icon-trash'></i></a>";
       

        
            $this->table->add_row(array(
                
                array('data'=>$val['usr_id'], 'class'=>'text-left'),                      
                strtoupper($val['usr_fullname']),
                $val['usr_icno'],
                strtoupper($val['FullName']),
                strtoupper($val['desc_state']),
                $button,
         
            ));     
            $bil++;
        }

        //generate table
        echo $this->table->generate(); 
        
        $sDom = '"sDom": "<\'row-fluid\'<\'span4\'l><\'span8\'f>r>t<\'row-fluid\'<\'span8\'i><\'span4\'p>>", "sPaginationType": "bootstrap", "oLanguage": {"sLengthMenu": "_MENU_ records per page"}, "aoColumnDefs": [{"aTargets": [ 0 ], "bSortable": false },{"aTargets": [ -1 ], "bSortable": false },{ "aTargets": [ \'_all\' ], "bSortable": true }]';
        //load class dynamic di Controller, tidak boleh load pada View sbb nanti nak Search, Paging dan Sorting
        echo "<script>$(document).ready(function() { $('.dynamic').dataTable({".$sDom."}); });</script>"; 
        
    }
    
    
  /// loc incidence delete ///
    function delete(){
        $id = $this->input->post('id');
        
        $this->Tbl_tr_userregistration_model->delete($id);
        echo "Record Deleted";
    }
     
}
?>
