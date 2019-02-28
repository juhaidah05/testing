<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   Mohd. Hafidz Bin Abdul Kadir
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (7 Okt 2015)    :   1. Indent semula snippet code
 *  (10 Okt 2015)   :   1. Ubahsuai javascript supaya memenuhi keperluan UAT1.0 (18092015)
 *                      Perkara 4.3.2
 *  (3 Nov 2015)    :   1. Tambah validation untuk Jenis Ujian dan Siri
 *                      2. Buang fail include validation/laporan.js
 *  (9 Dis 2015 )	:	1. Ubahsuai jenis paparan mengikut peranan
 */
?>
<div class="row-fluid">
    <div class="span10 offset1">
        <div class="widget-box">
            <div class="widget-content nopadding">
                <?php echo tbs_horizontal_form_open('', array('id'=>'laporan_ulang'));?>                
                <?php echo tbs_horizontal_dropdown('ujian',$ujian, '', array('id'=>'ujian','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Jenis Ujian' ),true); ?> 
                <div id="siri_dummy">
                    <?php echo tbs_horizontal_dropdown('siri_dependence',$siri_dependence, '', array('id'=>'siri_dependence','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Siri/Tahun Ujian' ),true); ?>
                </div>
                <div id="siri_real" style="display:none"></div>
                <?php if($peranan==2){?>
				<?php echo tbs_horizontal_dropdown('jenis_fasiliti',$jenis_fasiliti, '', array('id'=>'jenis_fasiliti','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Jenis Fasiliti' )); ?>
                <div id="fasiliti_dummy">
                    <?php echo tbs_horizontal_dropdown('fasiliti_dependence',$fasiliti_dependence, '', array('id'=>'fasiliti_dependence','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Lokasi Bertugas' )); ?>
                </div>
                <div id="fasiliti_real" style="display:none"></div>
                <div id="penempatan_dummy">
                    <?php echo tbs_horizontal_dropdown('penempatan_dependence',$penempatan_dependence, '', array('id'=>'penempatan_dependence','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Penempatan' )); ?>
                </div>
                <div id="penempatan_real" style="display:none"></div>
                <?php } else {?>
				<?php echo tbs_horizontal_dropdown('jenis_fasiliti',$jfasiliti, '', array('id'=>'jenis_fasiliti','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Jenis Fasiliti' )); ?>
				<?php echo tbs_horizontal_dropdown('fasiliti',$fasiliti, '', array('id'=>'fasiliti','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Lokasi Bertugas' )); ?>
                <?php echo tbs_horizontal_dropdown('penempatan',$penempatan, '', array('id'=>'penempatan','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Penempatan' )); ?>
				<?php } ?>
                <div style="margin:10px auto">
                    <div class="text-center">
                        <button id="genReport" class="btn btn-primary"><i class="icon icon-fire icon-white"></i> Jana Laporan</button>
                        <button id="resReport" class="btn btn-grey"><i class="icon icon-repeat icon-black"></i> Reset</button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div> 
</div>
<div id="generateReport" style="display:none"></div> 
<div><hr/></div>
<div id="senarai_ulang" style="display:none"></div>
<div id="callback"></div>  
<div id="dis_export_ulang_excel" class="span2 text-center" style="display:none; margin:10px 100px 0px 100px; float:right;">
    <button id="jana_ulang_excel" class="btn btn-primary"><i class="icon icon-download-alt icon-white"></i> Export ke MS Excel</button>
</div>
<div id="jana_mesej" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mesej Jana Laporan</h4>
            </div>
            <div class="modal-body">
                <pre style="color:red;font-family:inherit; border:0; background-color:#FFF">Harap maaf, tiada rekod ditemui dengan padanan carian.</pre>
            </div>
        </div>
    </div>
</div>
<div id="hantar_notis" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
<script>    
$(document).ready(function() {   
	$('#genReport').live('click', function(e){
        e.preventDefault();        
        if( $('#ujian').val()!='' && $('#siri').val()!='') {  
            $( "#ujian" ).css("border", "");
            $( "#siri" ).css("border", "");
            $( "#ujian_msg" ).empty();
            $( "#siri_msg" ).empty();
            
            var path = '';
            var path4 = '';            
            if($('#jenis_fasiliti').val() && $('#fasiliti').val() && $('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana_ulang')?>';
               path4 = '<?php echo base_url('index.php/laporan/senarai_ulang')?>';
            } else if($('#jenis_fasiliti').val() && $('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana_ulang2')?>';
               path4 = '<?php echo base_url('index.php/laporan/senarai_ulang2')?>';
            } else if($('#jenis_fasiliti').val() && !$('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana_ulang5')?>';
               path4 = '<?php echo base_url('index.php/laporan/senarai_ulang5')?>';
            } else if(!$('#jenis_fasiliti').val() && !$('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana_ulang6')?>';
               path4 = '<?php echo base_url('index.php/laporan/senarai_ulang6')?>';
            } //end if             
            var asal = $('#siri').val();
            var n = asal.search("/");               
            var i = asal.search("-"); 
            var id_ambilan = asal.substring(i+1);              
            $.ajax({
                type: 'POST', 
                url: path,
                data: { 
                    ujian: $('#ujian').val(),
                    id_ambilan: id_ambilan,
                    jenis_fasiliti : $('#jenis_fasiliti').val(),
                    fasiliti : $('#fasiliti').val(),
                    penempatan : $('#penempatan').val()
                },
                success : function(data){                    
                    if(data == 'tiada data'){
                        $('#generateReport').hide();
                        $('#senarai_ulang').hide();
                        $('#dis_export_ulang_excel').hide();
                        $('#jana_mesej').modal('show');
                    } else {    
                        $('#generateReport').show();
                        $('#generateReport').html(data);
                    }    
                }
            });				
            $.ajax({
                type: 'POST',
                url: path4,
                data: { 
                    ujian: $('#ujian').val(),
                    id_ambilan: id_ambilan,
                    jenis_fasiliti : $('#jenis_fasiliti').val(),
                    fasiliti : $('#fasiliti').val(),
                    penempatan : $('#penempatan').val()
                },
                success : function(data){                 
                    $('#senarai_ulang').html(data); 
                }
            });
        }else {
            if($("#ujian").val()==''){
                $("#ujian")
                    .css("border", "1px solid red")
                    .effect('pulsate', 100)
                    .effect("highlight", 5000)
                    .after(' <font id="ujian_msg" color="red"><i>Medan ini perlu diisi</i></font>');    
            }
            if($("#siri").val()==''){
                $( "#siri" )
                    .css("border", "1px solid red")
                    .effect('pulsate', 100)
                    .effect("highlight", 5000)
                    .after(' <font id="siri_msg" color="red"><i>Medan ini perlu diisi</i></font>');    
            }
            
            $("#ujian").change(function(){
                if($(this).val()!=''){
                    $(this).css("border", "");
                    $( "#ujian_msg" ).empty();
                }    
            });

            $("#siri").change(function(){
                if($(this).val()!=''){
                    $(this).css("border", "");
                    $( "#siri_msg" ).empty();
                }    
            }); 
        }
    });      
    var components = {
        iframe: function(url){
             return '<iframe id="printPage" name="printPage" src="'+url+'" style="position:absolute;top:0px; left:0px;width:0px; height:0px;border:0px;overfow:none; z-index:-1"></iframe>';
        }
    }; 	
    $('#jana_ulang_excel').live('click', function(e){
        e.preventDefault();         
        var asal = $('#siri').val();
        var n = asal.search("/"); 
        var siri = asal.substr(0, n);
        var tahun = asal.substr(n+1, 4);                
        var i = asal.search("-"); 
        var id_ambilan = asal.substring(i+1);        
        var ujian = $('#ujian').val();
        var jenis_fasiliti = $('#jenis_fasiliti').val();
        var fasiliti = $('#fasiliti').val();
        var penempatan = $('#penempatan').val(); 
        var data = '';        
        if(!jenis_fasiliti && !fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ulang6") ?>?'+data));
        } else if(jenis_fasiliti && !fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ulang5") ?>?'+data));
        } else if(jenis_fasiliti && fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti+"&fasiliti="+fasiliti;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ulang2") ?>?'+data));
        } else if(jenis_fasiliti && fasiliti && penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti+"&fasiliti="+fasiliti+"&penempatan="+penempatan;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ulang") ?>?'+data));			
        } //end if 
    });	
    $('#resReport').live('click', function(e){
        e.preventDefault();
        $('#ujian').val('');
        $('#siri').val('');
        $('#tahun').val('');
        $('#jenis_fasiliti').val('');
        $('#fasiliti').val('');
        $('#penempatan').val('');
        $('#dis_export_excel').hide();
        location.reload();            
    }); 
    //dependence dropdown untuk ujian->siri/tahun...
    $('#ujian').live('change', function(e){
        e.preventDefault();            
        var path = '<?php echo base_url('index.php/laporan/siri')?>';
        $.ajax({
            type: 'POST', 
            url: path,
            data: { ujian: $('#ujian').val() },
            success : function(data){
                $('#siri_dummy').hide();
                $('#siri_real').show().html(data);
            }
        });
    });
    //dependence dropdown untuk jenis fasiliti->fasiliti...
    $('#jenis_fasiliti').live('change', function(e){
        e.preventDefault();            
        var path = '<?php echo base_url('index.php/laporan/lokasi_bertugas')?>';
        $.ajax({
            type: 'POST', 
            url: path,
            data: { jenis_fasiliti: $('#jenis_fasiliti').val() },
            success : function(data){
                $('#fasiliti_dummy').hide();
                $('#fasiliti_real').show().html(data);
            }
        });
    });
    //dependence dropdown untuk fasiliti->penempatan...
    $('#fasiliti').live('change', function(e){
        e.preventDefault();            
        var path = '<?php echo base_url('index.php/laporan/penempatan')?>';
        $.ajax({
            type: 'POST', 
            url: path,
            data: { fasiliti: $('#fasiliti').val() },
            success : function(data){
                $('#penempatan_dummy').hide();
                $('#penempatan_real').show().html(data);
            }
        });
    });
    $('#papar_ulang').live('click', function(e){
        e.preventDefault();                             
        $('#senarai_ulang').show();
        $('#dis_export_ulang_excel').show(); 
    });		
});    
</script>