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
<div class="row-fluid">
    <div class="span10 offset1">
        <div class="widget-box">
            <div class="widget-content nopadding">        
                <?php echo tbs_horizontal_form_open('notis/selenggara_emel', array('id'=>'selenggara_emel'));?>
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
                <?php echo tbs_horizontal_input(array('name'=>'lokaliti','id'=>'lokaliti','value'=>set_value('lokalitiAdmin',  $sql_tcurr1['perihalFasiliti']),'class'=>'input-xxlarge','readonly'=>'readonly'), array('label'=>'Lokaliti Pentadbir:'), true);?>   
                <input type="hidden" name="fasiliti" value="<?php echo $sql_tcurr1['lokaliti'];?>" id="fasiliti" />
                <?php echo tbs_horizontal_input(array('name'=>'jawatan','id'=>'jawatan','value'=>'','class'=>'input-xxlarge'), array('label'=>'Jawatan'), true); ?>
                <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>'','class'=>'input-xxlarge'), array('label'=>'Nama'), true); ?>
                <?php echo tbs_horizontal_input(array('name'=>'alamatemel','id'=>'alamatemel','value'=>'','class'=>'input-xxlarge'), array('label'=>'Alamat Emel'), true); ?>
                <?php echo tbs_horizontal_dropdown('status', array(''=>'--Sila Pilih--','1'=>'Aktif','0'=>'Tidak Aktif'),'', array('id'=>'status','class'=>'input-xlarge'), array('label'=>'Status'), true)?>
                <div style="margin:10px auto">    
                    <div class="text-center">   
                        <button type= "submit" class="btn btn-primary" id="simpan"><i class="icon icon-plus icon-white"></i> Tambah </button>
                        <a class="btn btn-orange" href="<?php echo site_url('notis/selenggara_notis/'.$id)?>"><i class="icon-tag icon-white"></i> Selenggara Template</a>
                    </div>
                </div>    
                <?php echo form_close();?>  
            </div>
        </div>    
    </div>    
</div>
<div class="line"></div>
<div id="listStaf" class="span9 offset1"></div>
<div id="callback"></div>
<script src='<?php echo base_url('assets/validation/notis.js')?>'></script>
<script>
    window.listStaf = function(param){ AjaxCall(base_url+'index.php/notis/listJson',param, 'listStaf', 'id', '', ''); };
    $(document).ready(function(){
        listStaf();	
        $('#delete').live('click', function() {
            var con = confirm('Adakah Anda Pasti untuk Hapus Rekod Ini?');
            if(con == true){ AjaxCall(base_url+'index.php/notis/delete', 'id='+$(this).attr('attr'), '', '', 'listStaf()', 'jAlert'); }
            else{ return false; }
        });
    }); 
</script>