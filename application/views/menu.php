<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   Mohd. Aidil Mohd. Nayan
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (12 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<?php
    $cur1 = $this->uri->segment(1); // get controller name
    $cur2 = $this->uri->segment(2); // get method name
    $menu = array();
    if($this->authentication->is_logged_in()){
        $module = $this->Eminda_model->get_list('_modul', null, array('statusAktif'=>'Y'));
        foreach ($module as $module_key => $module_value) {
            //check if module exist in ModulPengguna
            $curr_module = $this->Eminda_model->check_data_exist('ModulPengguna', array('cdModul'=>$module_value['cdModul'], 'cdPeranan'=>$this->session->userdata('role'), 'statusAktif'=>'Y'));
            if($curr_module) {            
                //split link
                $url = explode("/", $module_value['urlModul']);
                //assign menu got sub menu or not
                empty($url[1])? $sub = '1': $sub = '0';
                //create menu array
                $menu[$url[0]] = array('title'=>$module_value['ketModul'], 'item'=>$url[1], 'icon'=>'', 'have_sub'=>$sub);                
                //get all sub menu from ltSubModul1
                $submodule1 = $this->Eminda_model->get_list('_subModul1', null, array('statusAktif'=>'Y', 'cdModul'=>$module_value['cdModul']));                
                if(!empty($submodule1) && $sub == '1') {
                    foreach ($submodule1 as $submodule1_key => $submodule1_value) {                        
                        //check if submodule1 exist in ModulPengguna
                        $curr_submodule1 = $this->Eminda_model->check_data_exist('ModulPengguna', array('cdModul'=>$module_value['cdModul'], 'cdSubModul1'=>$submodule1_value['cdSubModul1'], 'cdPeranan'=>$this->session->userdata('role'), 'statusAktif'=>'Y'));
                        //print_r($this->db->last_query());
                        if($curr_submodule1) {
                            $url_sub = explode("/", $submodule1_value['urlSubModul1']);
                            empty($url_sub[1])? $subsub = '1': $subsub = '0';
                            //check if link in same class or not
                            $url_sub[0] == $url[0]? $new_url = $url_sub[1] : $new_url = '../'.$submodule1_value['urlSubModul1'];
                            $menu[$url[0]]['sub'][] = array('title'=>$submodule1_value['ketSubModul1'], 'subcode'=>$submodule1_value['cdSubModul1'], 'item'=>$new_url, 'icon'=>'', 'have_subsub'=>$subsub);    
                        }//end if
                    }//end foreach
                }//end if
            }//end if
        }//end foreach
    }//end if
?>