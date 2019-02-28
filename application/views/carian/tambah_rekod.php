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
 */
?>
<div class="">
    <div class="span10 offset1">
        <div class="widget-box" >
            <div class="widget-title">
                <span class="icon"><i class="icon-th-large"></i></span>
                <h5>Daftar Pengguna</h5>
            </div>
            <div class="widget-content" >
                <?php echo tbs_horizontal_form_open('carian/tambah_rekod', array('id'=>'tambah_rekod'));?>
                    <div class="alert alert-fail"><span id="msgbox"></span></div> 
                    <div style="margin-left: 10px;  ">
                        <?php echo tbs_horizontal_input(array('name'=>'mykad', 'id'=>'mykad','value'=>set_value('mykad', $mykad),'class'=>'input-large','maxlength'=>'12'), array('label'=>'No. MyKad'), true); ?>
                        <?php echo tbs_horizontal_input(array('name'=>'nama','id'=>'nama','value'=>  set_value('nama',  $nama),'class'=>'input-xxlarge'), array('label'=>'Nama'), true); ?>
                        <?php echo tbs_horizontal_dropdown('jantina',$jantina_u,$jantina, array('id'=>'jantina','class'=>'input-medium'), array('label'=>'Jantina'), true); ?>     
                        <?php echo tbs_horizontal_password(array('name'=>'katalaluan','id'=>'katalaluan','value'=>set_value('katalaluan', $katalaluan),'class'=>'input-medium'), array('label'=>'Kata Laluan'), true); ?>            
                        <?php echo tbs_horizontal_password(array('name'=>'re_katalaluan','id'=>'re_katalaluan','value'=>set_value('re_katalaluan', $re_katalaluan),'class'=>'input-medium'), array('label'=>'Pengesahan Kata Laluan'), true); ?>             
                        <?php echo tbs_horizontal_input(array('name'=>'emel','id'=>'emel','value'=>  set_value('emel', $emel),'class'=>'input-xlarge'), array('label'=>'Emel'), true); ?>
                        <?php echo tbs_horizontal_dropdown('skim', $skim_u,$skim, array('id'=>'skim','class'=>'input-xlarge'), array('label'=>'Jawatan'), true)?>         
                        <?php echo tbs_horizontal_input(array('name'=>'gred','id'=>'gred','value'=>  set_value('gred',  $gred),'class'=>'input-small','maxlength'=>'10'), array('label'=>'Gred'), true); ?>                  
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style=" color:  #CC0000"> (Contoh: 17 / 41 / JUSA A / TURUS 3) </font>
                        <br/> 
                        <?php echo tbs_horizontal_dropdown('jenisFasiliti', $jenisFasiliti_u,$jenisFasiliti, array('id'=>'jenisFasiliti','class'=>'input-xlarge'), array('label'=>'Jenis Fasiliti'), true)?>  
                        <div id="ajaxjenisFasiliti">
                            <?php echo tbs_horizontal_dropdown('lokasiBertugas', $lokasiBertugas_u,$lokasiBertugas, array('id'=>'lokasiBertugas','class'=>'input-xlarge'), array('label'=>'Lokasi Bertugas'), true)?>  
                        </div>
                        <div id="ajaxpenempatan">    
                            <?php echo tbs_horizontal_dropdown('penempatan', $penempatan_u,$penempatan, array('id'=>'penempatan','class'=>'input-xlarge'), array('label'=>'Penempatan'), true)?>
                        </div>     
                        <!-- Dropdown Untuk STATUS AKTIF -->        
                        <?php echo tbs_horizontal_dropdown('status',$status_u,$status,array('id'=>'status','class'=>'',),array('label'=>'Status Aktif','class'=>''),true);?>
                        <!-- Dropdown Untuk Peranan -->
                        <?php echo tbs_horizontal_dropdown('levelAdmin',$levelAdmin_u,$levelAdmin,array('id'=>'levelAdmin','class'=>''),array('label'=>'Peranan','class'=>''),true);?>
                    </div>
                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-orange" id="daftar"><i class="icon icon-plus icon-white"></i> Daftar</button>
                        <button type="reset" id="semula" class="btn btn-orange"><i class="icon icon-repeat icon-white"></i> Reset</button>
                        <a class="btn btn-orange" href="<?php echo base_url('index.php/carian/pengguna')?>"><i class="icon icon-chevron-left  icon-white"></i> Kembali</a>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
        <script src='<?php echo base_url('assets/validation/pengguna.js')?>'></script>        
        <script>
            $(document).ready(function(){
                $('#simpan').live('click', function() {
                    var check_validate = $('#tambah_rekod').valid();
                    if(check_validate == true){ return true;}
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
                $("#mykad").blur(function() { 		
                    //remove all the class add the messagebox classes and start fading
                    $("#msgbox").removeClass().addClass('messagebox').text('semak...').fadeIn("slow");
                    //check the username exists or not from ajax
                    var val = $("#mykad").val();
                    $.post(base_url+'index.php/carian/semakMyKad',{ myKad:val } , function(data) { 
                        if(data=='yes') { 
                            $("#msgbox").fadeTo(200,0.1,function() {  //start fading the messagebox
                                $("#mykad").val("");
                                $(this).html('No. MyKad Telah Wujud').addClass('messageboxerror').fadeTo(900,1);
                            });
                        } else {
                            //start fading the messagebox
                            $("#msgbox").fadeTo(200,0.1,function() {  $("#msgbox").text(""); });
                        }//end if
                    });
                });        
                $("#katalaluan").blur(function() {             
                    var password = $("#katalaluan").val();
                    var repassword = $("#re_katalaluan").val();
                    if(password != '' && repassword != '') {		
                        //remove all the class add the messagebox classes and start fading
                        $("#msgbox").removeClass().addClass('messagebox').text('semak...').fadeIn("slow");
                        //check the username exists or not from ajax
                        $.post(base_url+'index.php/carian/semakPassword',{ password:password, repassword:repassword } ,	function(data) { 
                            if(data=='yes') { 
                                $("#msgbox").fadeTo(200,0.1,function() {  //start fading the messagebox
                                    $("#katalaluan").val("");
                                    $("#re_katalaluan").val("");
                                    $(this).html('Kata Laluan Dan Pengesahan Kata Laluan Tidak Sepadan').addClass('messageboxerror').fadeTo(900,1);
                                });
                            } else {
                                //start fading the messagebox
                                $("#msgbox").fadeTo(200,0.1,function() {  $("#msgbox").text(""); });
                            }//end if
                        });
                    }//end if
                });        
                $("#re_katalaluan").blur(function() {             
                    var password = $("#katalaluan").val();
                    var repassword = $("#re_katalaluan").val();
                    if(password != '' && repassword != '') {		
                        //remove all the class add the messagebox classes and start fading
                        $("#msgbox").removeClass().addClass('messagebox').text('semak...').fadeIn("slow");
                        //check the username exists or not from ajax
                        $.post(base_url+'index.php/carian/semakPassword',{ password:password, repassword:repassword } ,	function(data) { 
                            if(data=='yes') { //093
                                $("#msgbox").fadeTo(200,0.1,function() {  //start fading the messagebox
                                    $("#katalaluan").val("");
                                    $("#re_katalaluan").val("");
                                    $(this).html('Kata Laluan Dan Pengesahan Kata Laluan Tidak Sepadan').addClass('messageboxerror').fadeTo(900,1);
                                });
                            } else {
                                //start fading the messagebox
                                $("#msgbox").fadeTo(200,0.1,function() {  $("#msgbox").text(""); });
                            } //end if
                        });
                    }//end if
                });
            });
        </script>