<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang snippet yang tidak diperlukan
 *                      4. Ringkaskan snippet code
 *	(23 Dis 2015)	:	1. Gantikan if(con == true){ AjaxCall(base_url+'index.php/carian/reset_password', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert'); }
 *						   dengan 	if(con == true){ AjaxCall(base_url+'index.php/carian/reset_password', 'id='+$(this).attr('attr'), '', '', '', 'jAlert'); }
 * 
 *  (8 Mar 2016) 	: 	maria-added function tkr_status 
 *	(12 Apr 2016)	: 	1. Tambah trigger untuk class autodisable supaya hanya menerima input selain nombor
 *						2. Tambah trigger supaya input pada ruangan nama tidak boleh copy,cut atau paste	
 */
?>
<?php echo tbs_horizontal_form_open('', array('id'=>'carian_staf'));?>
<div class="row-fluid">
    <div class="span8 offset2">
        <div class="widget-box">
            <div class="widget-content nopadding">
                <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>  set_value('nama', $nama['nama']),'class'=>'input-xlarge'), array('label'=>'Nama'), false); ?>
                <?php echo tbs_horizontal_input(array('name'=>'mykad','id'=>'mykad','value'=>  set_value('mykad', $mykad['mykad']),'class'=>'input-xlarge','maxlength'=>'12'), array('label'=>'No Kad Pengenalan','desc'=>'Contoh : 888888888888'), false); ?>
                <div style="margin:10px auto">    
                    <div class="text-center">
                        <button class="btn btn-primary search"><i class="icon icon-search icon-white"></i> Cari</button>
                        <button type="reset" id="batal" class="btn btn-grey"><i class="icon icon-repeat"></i> Reset</button>
                        <button type="button" id="tambah2" class="btn btn-orange"><i class="icon-user icon-white"></i> Daftar Pengguna</button>
                    </div>    
                </div>
            </div>
        </div>    
    </div>
</div>
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>
<?php echo form_close();?>  

<!-- Tambah Rekod Pengguna -->
<div id="myModal_Tambah2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h3 id="myModalLabel">Daftar Profil Pengguna Baru</h3>
    </div>
    <?php echo tbs_horizontal_form_open('carian/tambah_rekod', array('id'=>'tambah_rekod'));?>
    <div class="modal-body" >        
            <div class="hide alert alert-fail"><span id="msgbox"></span></div> 
            <div style="margin-left: 10px;  ">
                <?php echo tbs_horizontal_input(array('name'=>'mykad', 'id'=>'mykad2','value'=>set_value('mykad', $mykad),'class'=>'input-large','maxlength'=>'12'), array('label'=>'No. MyKad'), true); ?>
                <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','class'=>'input-xlarge autoDisable'), array('label'=>'Nama'), true); ?>
                <?php echo tbs_horizontal_dropdown('jantina',$jantina_u,$jantina, array('id'=>'jantina','class'=>'input-medium'), array('label'=>'Jantina'), true); ?>     
                <?php echo tbs_horizontal_input(array('name'=>'katalaluan','id'=>'katalaluan','class'=>'input-medium'), array('label'=>'Kata Laluan'), true); ?>            
                <?php echo tbs_horizontal_input(array('name'=>'re_katalaluan','id'=>'re_katalaluan','class'=>'input-medium'), array('label'=>'Pengesahan Kata Laluan'), true); ?>             
                <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $emel),'class'=>'input-xlarge'), array('label'=>'Emel'), true); ?>
                <?php echo tbs_horizontal_dropdown('skim', $skim_u,$skim, array('id'=>'skim','class'=>'input-xlarge'), array('label'=>'Jawatan'), true)?>         
                <?php echo tbs_horizontal_input(array('name'=>'gred','id'=>'gred','value'=>  set_value('gred',  $gred),'class'=>'input-small','maxlength'=>'10','style'=>'display:inline-block'), array('label'=>'Gred','desc'=>'Contoh: 17 / 41 / JUSA A / TURUS 3'), true);?>
                <?php echo tbs_horizontal_dropdown('jenisFasiliti', $jenisFasiliti_u,$jenisFasiliti, array('id'=>'jenisFasiliti','class'=>'input-xlarge'), array('label'=>'Jenis Fasiliti'), true)?>  
                <div id="ajaxjenisFasiliti">
                    <?php echo tbs_horizontal_dropdown('lokasiBertugas', $lokasiBertugas_u,$lokasiBertugas, array('id'=>'lokasiBertugas','class'=>'input-xlarge', 'orderby'=>'x'), array('label'=>'Lokasi Bertugas'), true)?>  
                </div>
                <div id="ajaxpenempatan">    
                    <?php echo tbs_horizontal_dropdown('penempatan', $penempatan_u,$penempatan, array('id'=>'penempatan','class'=>'input-xlarge', 'orderby'=>'x'), array('label'=>'Penempatan'), true)?>
                </div>     
                <!-- Dropdown Untuk STATUS AKTIF -->        
                <?php echo tbs_horizontal_dropdown('status',$status_u,$status,array('id'=>'status','class'=>'', 'orderby'=>'x'),array('label'=>'Status Aktif','class'=>''),true);?>
                <!-- Dropdown Untuk Peranan -->
				<?php echo tbs_horizontal_dropdown('levelAdmin',$levelAdmin_u,$levelAdmin,array('id'=>'levelAdmin','class'=>''),array('label'=>'Peranan','class'=>''),true);?>
            </div>            
        
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
        <button type="reset" id="reset2" class="btn btn-grey"><i class="icon icon-repeat"></i> Reset</button>
        <button class="btn btn-orange" data-dismiss="modal" aria-hidden="true" id="button_tutup"><i class="icon icon-remove icon-white"></i> Tutup</button>
    </div>          
    <?php echo form_close();?>
</div>

<!--script src='<?php echo base_url('assets/validation/carian.js');?>'></script-->
<script src='<?php echo base_url('assets/validation/pengguna.js');?>'></script>
<script>

	window.listUser = function(param){ AjaxCall(base_url+'index.php/carian/listJson',param, 'listUser', 'id', '', ''); };
    $(document).ready(function(){
		
		$('.autoDisable').keypress(function (e) {
			var regex = new RegExp("^[0-9]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (!regex.test(str)) {
				return true;
			}
			else
			{
				e.preventDefault();
				//alert('Please Enter Alphabate');
				return false;
			}
		});
		
		$('.autoDisable').bind("cut copy paste",function(e) {
          e.preventDefault();
		});
		
		<?php if ($ic!='')
        {
        ?>
        $('#mykad').val('<?php echo $ic; ?>');
        listUser('mykad=<?php echo $ic; ?>&nama=');   
        <?php 
		}
		else if ($name!='')
		{
		?>
		$('#nama').val('<?php echo $name; ?>');
        listUser('nama=<?php echo $nama; ?>&mykad=');
		<?php
		}
		else
		{
		?>
		$('#mykad').val('<?php echo $ic; ?>');
		$('#nama').val('<?php echo $name; ?>');
        listUser('mykad=<?php echo $ic; ?>&nama=<?php echo $name; ?>'); 
		<?php
		}
		?>

        $('button.search').live('click', function() {
            var $var = "";
            $('#carian_staf').find(':input[type=text]').each(function(key, val){ if(val.value != '') { $var += val.name+"="+val.value+"&"; } });
            if($var != '') { AjaxCall(base_url+'index.php/carian/listJson', $var, '', '', 'listUser("'+$var+'")', ''); }
            return false;
        });
//        $('#hapus_rekod').live('click', function() {
//            var con = confirm('Adakah Anda Pasti Untuk Menukar Status Rekod Ini?');
//            if(con == true){ AjaxCall(base_url+'index.php/carian/tukar_status', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert'); }
//            else{ return false; }
        });
        $('#reset_password').live('click', function() {
            var con = confirm('Adakah Anda Pasti Untuk Reset Kata Laluan Rekod Ini?');
            //if(con == true){ AjaxCall(base_url+'index.php/carian/reset_password', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert'); }
            if(con == true){ AjaxCall(base_url+'index.php/carian/reset_password', 'id='+$(this).attr('attr'), '', '', '', 'jAlert'); }
			else{return false;}
        });
        $('#tambah2').live('click', function() {
            $('#myModal_Tambah2').modal('show');
        });
        $('#jenisFasiliti').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/carian/getFasiliti', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxjenisFasiliti").slideUp('fast').html(data):$("#ajaxjenisFasiliti").html(data).slideDown('fast');
            });
        });
        $('#lokasiBertugas').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/carian/getPenempatan', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxpenempatan").slideUp('fast').html(data):$("#ajaxpenempatan").html(data).slideDown('fast');
            });
        });
        $("#mykad2").blur(function(){
            //check the username exists or not from ajax
            var val = $("#mykad2").val();
            $.post(base_url+'index.php/carian/semakMyKad',{ myKad:val } , function(data) { 
                if(data=='yes') { 
                    $('input#mykad2').css({ "border": '#FF0000 1px solid'});
                    $("input#mykad2").after(' <font id="redundant" color="red">No. MyKad Telah Wujud</font>');
                    setTimeout(function(){
                       $("#redundant").remove();
                       $("#mykad2").val('');
                       $('input#mykad2').css({ "border": '#d3d3d3 1px solid'});
                    }, 4000);
                } //end if
            });
        });    
        $("#katalaluan").blur(function() {             
            var password = $("#katalaluan").val();
            var repassword = $("#re_katalaluan").val();
            if(password != '' && repassword != '') {		
                //check the username exists or not from ajax
                $.post(base_url+'index.php/carian/semakPassword',{ password:password, repassword:repassword } ,	function(data) { 
                    if(data=='yes') { 
                        $('input#katalaluan').css({ "border": '#FF0000 1px solid'});
                        $("input#katalaluan").after(' <font id="mismatch" color="red">Tidak sepadan Pengesahan Kata Laluan</font>');
                        setTimeout(function(){
                           $("#mismatch").remove();
                           $("#katalaluan").val('');
                           $('input#katalaluan').css({ "border": '#d3d3d3 1px solid'});
                        }, 4000);  
                    } //end if
                });
            }//end if
        });        
        $("#re_katalaluan").blur(function() {             
            var password = $("#katalaluan").val();
            var repassword = $("#re_katalaluan").val();
            if(password != '' && repassword != '') {		
                //check the username exists or not from ajax
                $.post(base_url+'index.php/carian/semakPassword',{ password:password, repassword:repassword } ,	function(data) { 
                    if(data=='yes') { 
                        $('input#re_katalaluan').css({ "border": '#FF0000 1px solid'});
                        $("input#re_katalaluan").after(' <font id="mismatch2" color="red">Tidak sepadan Kata Laluan</font>');
                        setTimeout(function(){
                           $("#mismatch2").remove();
                           $("#re_katalaluan").val('');
                           $('input#re_katalaluan').css({ "border": '#d3d3d3 1px solid'});
                        }, 4000);  
                    } //end if
                });
            }//end if
        });
		
		$('#reset2').click(function() {
			location.reload();
		});
// ------------for tukar status -------------------------
     $('#tkr_status').live('click', function() {
            var con = confirm('Anda pasti untuk menukar STATUS?');
            if(con == true){
                AjaxCall(base_url+'index.php/carian/senggara_status', 'id='+$(this).attr('attr'), '', '', 'listUser()', 'jAlert');
                //$('#myModal_Tambah').modal('hide');
            }
            else{
                return false;
            }
           
        });
       
   // --------------------------------------------------end for tukar status -----------------------------          

    
    
</script>