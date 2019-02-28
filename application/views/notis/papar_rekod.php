<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (8 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<br />
<div class="row-fluid">
    <div class="span10 offset1">        
        <?php echo tbs_horizontal_form_open('', array('id'=>'papar_rekod'));?>        
            <div class="span12"><span class="lblText" ><h5><b><u><center>SELENGGARA EMEL - PAPAR REKOD</center></u></b></h5></span></div>
            <br /><br /><br />
            <?php 
                $id = $this->session->userdata('username'); 
                $this->db->select('a.*, b.*');
                $this->db->from('pengguna a');
                $this->db->join('_kodFasiliti b','b.kodFasiliti=a.lokaliti');
                $this->db->where('a.mykad',$id);
                $this->db->order_by("a.mykad","desc");
                $query = $this->db->get();
                $sql_tcurr1 = $query->row_array();
            ?>
            <?php echo tbs_horizontal_input(array('name'=>'lokaliti', 'id'=>'lokaliti','value'=>set_value('lokalitiAdmin',  $sql_tcurr1['perihalFasiliti']),'class'=>'input-xxlarge','readonly'=>'readonly'), array('label'=>'Lokaliti Pentadbir:'), true);  ?>   
            <input type="hidden" name="fasiliti" value="<?php echo $papar1['lokalitiAdmin'];?>" id="fasiliti" />
            <?php echo tbs_horizontal_input(array('name'=>'jawatan','id'=>'jawatan','value'=>set_value('jawatanPN',  $papar1['jawatanPN']),'class'=>'input-xxlarge','readonly'=>'readonly'), array('label'=>'Jawatan'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>set_value('namaPN',  $papar1['namaPN']),'class'=>'input-xxlarge','readonly'=>'readonly'), array('label'=>'Nama'), true); ?>
            <?php echo tbs_horizontal_input(array('name'=>'alamatemel','id'=>'alamatemel','value'=>set_value('emelPN',  $papar1['emelPN']),'class'=>'input-xxlarge','readonly'=>'readonly'), array('label'=>'Alamat Emel'), true); ?>
            <?php echo tbs_horizontal_dropdown('status', array(''=>'--Sila Pilih--','1'=>'Aktif','0'=>'Tidak Aktif'),$papar1['statusPN'], array('id'=>'status','class'=>'input-xlarge','readonly'=>'readonly'), array('label'=>'status'), true)?> 
            <br/> <br />
            <div class="" align="center">  
                <a class="btn btn-primary" href="<?php echo site_url('notis/selenggara_emel')?>"><i class="icon-envelope icon-white"></i> Selenggara Emel</a>
            </div>
        <?php echo form_close();?>         
    </div>        
</div>
<div class="line"></div>
<script src='<?php echo base_url('assets/validation/notis.js')?>'></script>