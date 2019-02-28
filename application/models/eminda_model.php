<?php

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (14 Ogos 2015)  :   1. Indent semula snippet code
 *                      2. Ringkaskan Class
 *                      3. Baiki pernyataan tersarang
 *						4. Ubahsuai method get_select_list
 *                      5. Tambah method get_data_dependence
 *						6. Tambah method get_select_lest_admin
 */
 
class Eminda_model extends CI_Model {
            
	function __construct() {
        parent::__construct();
    }//end method
    
    function get_key($table,$where,$field) {
		$this->db->where($field,$where);
		$this->db->from($table);
		$query = $this->db->get();			
		return $query->result_array();
	}//end method
        
	function get_one_value($value,$col,$table) {
		$this->db->select($col);
		$this->db->where($col,$value);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) return TRUE;
	}//end method
        
    function check_data_exist($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) return TRUE;
	}//end method
	
	function get_one_field($col,$where,$table){
		$this->db->select($col);
		$this->db->where($where);
		$query = $this->db->get($table);
		return $query->row_array();
	}//end method
	
	function get_one_field2($col,$where,$field,$table){
		$this->db->select($col);
		$this->db->where($where);
		$this->db->order_by($field, "desc"); 
		$this->db->limit(1);
		$query = $this->db->get($table);
		return $query->row_array();
	}//end method
	
	function get_one_value_2($value,$where,$table){
		$this->db->select($value);
		$this->db->where($where[0],$where[1]);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			$data = $query->row_array();
			return $data[$value];
		}
	}//end method
	
	function get_info($table,$where=0){
		$this->db->select('*');
		$this->db->from($table);
		if($where != 0){
			foreach($where as $key=>$val){
				$this->db->where($key, $val);
			}	
		}
		$query = $this->db->get();				
        return $query->row_array();
    }//end method

    function get_jenisFasiliti($where){
		$this->db->select('a.*, b.*');
		$this->db->from('_padananFP a');
		$this->db->join('_kodFasiliti b','a.fasiliti=b.kodFasiliti');
		$this->db->where('a.idFP',$where);

		//print_r($this->db->last_query());
                
		$query = $this->db->get();				
        return $query->row_array();
    }//end method
    
    function get_data($table){
		$this->db->select('*');
		$this->db->from($table);		
		$query = $this->db->get();				
        return $query->result_array();
    }//end method   
	
    function get_count($table,$where){
		$this->db->from($table);
		$this->db->where($where);
        return $this->db->count_all_results();
    }//end method
    
    function get_sum($table,$field,$where){
		$this->db->select_sum($field);
		$this->db->where($where);
		$query = $this->db->get($table);		
		return $query->row_array();
    }//end method
    
    function get_count2($table,$where1,$where2,$where3,$where4){			
		$this->db->from($table);
		$this->db->where($where1);
		$this->db->where($where2);
		$this->db->where($where3);
		$this->db->where($where4);		
        return $this->db->count_all_results();
    }//end method
    
    function get_count2a($table,$where1,$where2){			
		$this->db->from($table);
		$this->db->where($where1);
		$this->db->where($where2);	
        return $this->db->count_all_results();
    }//end method
    
    function get_count3($table,$where1,$where2,$where3){			
		$this->db->from($table);
		$this->db->where($where1);
		$this->db->where($where2);
		$this->db->where($where3);	
        return $this->db->count_all_results();
    }//end method
    
    function get_count5($table,$where1,$where2,$where3,$where4,$where5){			
		$this->db->from($table);
		$this->db->where($where1);
		$this->db->where($where2);
		$this->db->where($where3);
		$this->db->where($where4);
		$this->db->where($where5);
		
        return $this->db->count_all_results();
    }//end method
    
    function get_count6($table,$where1,$where2,$where3,$where4,$where5,$where6){			
		$this->db->from($table);
		$this->db->where($where1);
		$this->db->where($where2);
		$this->db->where($where3);
		$this->db->where($where4);
		$this->db->where($where5);
		$this->db->where($where6);		
        return $this->db->count_all_results();
    }//end method
    
    function get_info2($table,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
        return $query->row_array();
    }
    
    function get_info3($table,$where1,$where2,$where3){		
        $this->db->select('*');
		$this->db->from($table);
		$this->db->where($where1);
		$this->db->where($where2);
		$this->db->where($where3);
		$query = $this->db->get();
        return $query->row_array();
    }//end method
    
	function get_table_fields($table){
		return $this->db->list_fields($table);
	}
	
	function insert_data($table,$data){
		if ($this->db->insert($table, $data)) { 
			return $this->db->insert_id();
		}
		else return false;
	}//end method

	function insert_log($table,$data){
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}//end method
	
	function get_select_list($table,$cols=array('key' => 'id','val' => 'name', 'orderby' => 'x'),$with_select=1, $where='x'){
		
		if($table=='siri_dependence'){
			$data[''] = 'Sila Pilih [Jenis Ujian] Terlebih Dahulu';			
		} else if($table=='fasiliti_dependence'){
			$data[''] = 'Sila Pilih [Jenis Fasiliti] Terlebih Dahulu';
		} else if($table=='penempatan_dependence'){
			$data[''] = 'Sila Pilih [Fasiliti] Terlebih Dahulu';
		} else {
			extract($cols);
			if($orderby=='x'){ $this->db->order_by($val); } 
			if($where!='x') { $this->db->where($where); }
			$query = $this->db->get($table);
			$arr = $query->result_array();
			if ($with_select) { $data[''] = '-- Sila Pilih --'; }
			foreach ($arr as $k => $v){
				extract($v);
				$data[$$key] = $$val;
			}
		}
       //echo $this->db->last_query();
                
		return $data;
	}//end method
    
	function get_select_list2($table,$cols=array('key' => 'id','val' => 'name'),$with_select=1,$where='x'){
		extract($cols);
		$this->db->order_by($val);
		if($where!='x') { $this->db->where($where); }
		$query = $this->db->get($table);
		$arr = $query->result_array();
		if ($with_select) { $data[''] = '-- Sila Pilih --'; }
		foreach ($arr as $k => $v){
			extract($v);
			$data[$$key] = $$val;
		}
		return $data;
	}//end method
	
	function get_select_list3($table,$cols=array('key' => 'id','val' => 'name', 'orderby' => 'x'),$with_select=1, $where='x'){
		extract($cols);
		if($orderby=='x'){ $this->db->order_by($val); } 
		if($where!='x') { $this->db->where($where); }
        $this->db->join('_kodPenempatan','_kodPenempatan.kodPenempatan = _padananFP.penempatan', 'left'); 
		$query = $this->db->get($table);
                
		$arr = $query->result_array();
		if ($with_select) { $data[''] = '-- Sila Pilih --'; }
		foreach ($arr as $k => $v){
			extract($v);
			$data[$$key] = $$val;
		}
		return $data;
	}//end method
	
	function get_select_list_admin($table,$cols=array('key' => 'id','val' => 'name', 'orderby' => 'x'),$with_select=1, $where='x'){
		
		if($table=='siri_dependence'){
			$data[''] = 'Sila Pilih [Jenis Ujian] Terlebih Dahulu';			
		} else if($table=='fasiliti_dependence'){
			$data[''] = 'Sila Pilih [Jenis Fasiliti] Terlebih Dahulu';
		} else if($table=='penempatan_dependence'){
			$data[''] = 'Sila Pilih [Fasiliti] Terlebih Dahulu';
		} else {
			extract($cols);
			if($orderby=='x'){ $this->db->order_by($val); } 
			if($where!='x') { $this->db->where($where); }
			$query = $this->db->get($table);
			$arr = $query->result_array();
			if ($with_select) { $data[''] = '-- Sila Pilih --'; }
			foreach ($arr as $k => $v){
				extract($v);
				$data[$$key] = $$val;
			}
		}
		return $data;
	}//end method	
	    
    function update_data($table,$key,$data) {
		$this->db->where($key);
		$this->db->update($table, $data); 
	}//end method
	
	function update_data2($table,$where='x',$data){
		if($where!='x') { $this->db->where($where); }
		$this->db->update($table, $data); 
	}//end method

	function delete_data($table,$where=0) {
		if($where != 0) {
			foreach($where as $key=>$val){
				$this->db->where($key, $val);
			}	
		}
		$this->db->delete($table); 
	}//end method

	function get_list($table,$order,$where=null,$sort="asc"){
		$this->db->select('*');
		if($where!=null){ $this->db->where($where); }		
		if($order!=null){ $this->db->order_by($order, $sort); }
		$query = $this->db->get($table);
		return $query->result_array();
	}//end method
        
	function update_one_field($table,$field,$value,$id) {
		$sql = "UPDATE ".$table." SET ".$field." = ".$value." WHERE id_user_pc=".$id;
		$this->db->query($sql);
	}//end method	
	
	function get_data_dependence($table,$clause='x'){
		$this->db->select('*');
		$this->db->from($table);
		if($clause!='x'){ $this->db->where($clause); }
		return $this->db->get()->result_array();
	}//end method	
        
        function semakMyKad($myKad) {
            
            $this->db->select('mykad');
            $this->db->where(array('mykad'=>$myKad));
            $query = $this->db->get('pengguna');
            return ($query->num_rows() == 0) ? "no":"yes";
	}
}