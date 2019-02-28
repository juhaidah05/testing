<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (23 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<br />
<div class="row-fluid">
    <div class="span10 offset1">        
        <?php echo tbs_horizontal_form_open('', array('id'=>'kemaskini_rekod'));?>
        <div class="span12"><span class="lblText" ><h5><b><u><center>SELENGGARA EMEL - KEMASKINI REKOD</center></u></b></h5></span></div>
        <br/><br/><br/>
        <?php
            $id = $this->session->userdata('username'); 		  
            $this->db->select('a.*, b.*');
            $this->db->from('pengguna a');
            $this->db->join('_kodFasiliti b','b.kodFasiliti=a.lokaliti');
			$this->db->where('a.mykad',$id);
            $this->db->order_by("a.mykad","desc");
			$query = $this->db->get();
			$sql_tcurr1 = $query->row_array();	
            echo tbs_horizontal_input(array('name'=>'lokaliti','id'=>'lokaliti','value'=>set_value('lokalitiAdmin',  $sql_tcurr1['perihalFasiliti']),'class'=>'input-xxlarge','readonly'=>'readonly'), array('label'=>'Lokaliti Pentadbir:'), true);  
        ?>   
        <input type="hidden" name="fasiliti" value="<?php echo $kemaskini['lokalitiAdmin'];?>" id="fasiliti" />
        <?php 
            echo tbs_horizontal_input(array('name'=>'jawatan','id'=>'jawatan','value'=>set_value('jawatanPN',  $kemaskini['jawatanPN']),'class'=>'input-xxlarge'), array('label'=>'Jawatan'), true); 
            echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>set_value('namaPN',  $kemaskini['namaPN']),'class'=>'input-xxlarge',), array('label'=>'Nama'), true);  
            echo tbs_horizontal_input(array('name'=>'alamatemel','id'=>'alamatemel','value'=>set_value('emelPN',  $kemaskini['emelPN']),'class'=>'input-xxlarge'), array('label'=>'Alamat Emel'), true); 
            echo tbs_horizontal_dropdown('status', array(''=>'--Sila Pilih--','1'=>'Aktif','0'=>'Tidak Aktif'),$kemaskini['statusPN'], array('id'=>'status','class'=>'input-xlarge',), array('label'=>'status'), true);
        ?> 
        <br /><br /> 
        <div class="" align="center">  
            <button type= "submit" class="btn btn-primary" id="simpan"><i class="icon icon-refresh icon-white"></i>Kemaskini </button>
        </div>
    </div>        
</div>
<div class="line"></div>
<?php echo form_close();?> 
<script src='<?php echo base_url('assets/validation/notis.js')?>'></script>