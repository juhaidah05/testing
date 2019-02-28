<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Buang variable var cdSubModul1
 */
?>
<div class="row-fluid">
    <div class="alert alert-success" style="display:none">Kawalan Capaian Berjaya Dikemaskini.</div>
	<div class="span10 offset1">
        <div class="widget-box">
            <!--div class="widget-title">
                <span class="icon">
                    <i class="icon-th-large"></i>
                </span>
                <h5>Selenggara Kawalan Capaian</h5>
            </div-->
            <div class="widget-content nopadding">
                <?php echo tbs_horizontal_form_open('', array('id'=>'access_control'));?>        
                    <?php echo tbs_horizontal_dropdown('role', $dropdown_role,
                    $role, array( 'id'=>'role','class'=>''), array('label'=>'Peranan'), true)?>  
                    <div class="control-group" id="role_module">
                        <label class="control-label" for="module">Modul <span style='color:red'>*</span></label>
                        <div class="controls">
                        <?php
                        foreach ($checkbox_module as $module) {
                            echo '<div class="pull-left" style="padding-top:5px; padding-bottom:15px; width: 100%">';                 
                            echo tbs_form_checkbox2('cdModul[]', $module['ketModul'], $module['cdModul'], $checked, 'id="cdModul'.$module['cdModul'].'"');                
                            $checkbox_submodule1 = $this->Eminda_model->get_list('_subModul1','',array('cdModul'=>$module['cdModul'],'statusAktif'=>'Y'),'');                
                            if($checkbox_submodule1 != null) {
                                echo '<div class="subcontrols '.$module['cdModul'].' pull-left" '.$style.'>'; 
                                if($module['cdModul'] == 1) {
                                    echo '<div>';
                                    echo 'Read/Write Mode : ';
                                    echo form_dropdown('curAkses', array('RW'=>'Read / Write', 'R'=>'Read Only'), '', 'class="input-medium" id="curAkses"');
                                    echo '</div>';
                                }//end if          
                                foreach ($checkbox_submodule1 as $submodule1) {
                                    echo '<div class="inline-chkboxOradio">';
                                    echo tbs_inline_form_checkbox('cdSubModul1-'.$module['cdModul'].'[]', 
                                        $submodule1['ketSubModul1'], 
                                        $submodule1['cdSubModul1'], 
                                        $checked, 'id="cdSubModul1-'.$module['cdModul'].'-'.$submodule1['cdSubModul1'].'"');
                                    echo '</div>';                     
                                }//end foreach
                                echo '</div>';  
                            }//end if
                            echo '</div>';  
                        }//end foreach       
                        ?>
                        </div>
                    </div>         
                    <div class="form-actions">
                        <!--div class="span2 offset2"><a class="btn" href="<?php echo base_url()?>"><i class="icon icon-chevron-left"></i> Kembali</a></div-->            
                        <div class="span offset4"><button type="submit" class="btn btn-primary update"><i class="icon icon-refresh icon-white"></i> Kemaskini</button></div>
                    </div>
                <?php echo form_close();?>
            </div>                
        </div>
    </div>
</div>
<script src='<?php echo base_url('assets/validation/access_control.js')?>'></script>
<script>    
    $(document).ready(function() {         
        $('#role').live('change', function(e){
            e.preventDefault();
            $("#role_module").fadeOut('fast');
            $.post(base_url+'index.php/access/retrieve/'+$(this).val(), '', function(data) {
                $("#access_control").find('input[type=checkbox]:checked').each(function(key, val) {
                    $(this).attr('checked',false);
                });
                $("#curAkses").val('');              
                $.each(data, function(i, v){
                    var cdModul = '';
                    //var cdSubModul1 = '';
                    $.each(v, function (key, val) {
                        if(key == 'cdModul') {
                            $("#access_control #"+key+val).attr('checked', true);
                            cdModul = val;
                        }
                        if(key == 'curAkses' && cdModul == '1') {
                            $("#access_control #"+key).val(val);
                        }
                        if(key == 'cdSubModul1') {
                            $("#access_control input[name*="+key+"-"+cdModul+"][value="+val+"]").attr('checked', true);
                            //cdSubModul1 = val;
                        }
                    });
                });
                $("#role_module").fadeIn('fast');                
            }, "json");
        });        
        $('#access_control .update').live('click', function(e){
            e.preventDefault();
            var options = '';
            $("#access_control").find('select, input[type=checkbox]:checked').each(function(key, val) {
                    options += val.name+"="+val.value+"&";
            });
            var valid = $("#access_control").valid();
            if(valid){
                AjaxCall(base_url+'index.php/access/update', options, '', '', '', '');
                $("div.alert").slideDown(function(){
                    setTimeout('$("div.alert").slideUp()',3000);    
                });
            }
        });  

    });       
</script>