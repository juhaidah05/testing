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
				<?php echo tbs_horizontal_form_open('', array('id'=>'laporan_status'));?>                
                <?php echo tbs_horizontal_dropdown('ujian',$ujian, '', array('name'=>'ujian','id'=>'ujian','class'=>'input-xlarge', 'style'=>"width:auto"), array( 'label'=>'Jenis Ujian' ),true); ?> 
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
<div id="senarai_ambil" style="display:none"></div>
<div id="senarai_belum" style="display:none"></div>
<div id="callback"></div>  
<div id="dis_export_ambil_excel" class="span2 text-center" style="display:none; margin:10px 100px 0px 100px; float:right;">
    <button id="jana_ambil_excel" class="btn btn-primary"><i class="icon icon-download-alt icon-white"></i> Export ke MS Excel</button>
</div>
<div id="dis_export_belum_excel" class="text-center" style="display:none; margin:10px 100px 0px 100px; float:right;">
    <button id="btn_hantar_notis" class="btn btn-info btn-orange" data-toggle="modal" data-target="#hantar_notis"><i class="icon icon-envelope icon-white"></i> Hantar Notis</button>
    <button id="jana_belum_excel" class="btn btn-primary" style=""><i class="icon icon-download-alt icon-white"></i> Export ke MS Excel</button>    
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
    
    $('#btn_hantar_notis').click(function(){
	var asal = $('#siri').val();
       	var n = asal.search("/");               
        var i = asal.search("-"); 
        var id_ambilan = asal.substring(i+1);
            $.ajax({
            type: 'POST', 
            url: '<?php echo base_url('index.php/laporan/hantar_notis')?>',
            data: { 
                ujian: $('#ujian').val(),
                id_ambilan: id_ambilan,
                jenis_fasiliti : $('#jenis_fasiliti').val(),
                fasiliti : $('#fasiliti').val(),
                penempatan : $('#penempatan').val()
            },
            success : function(data){                    
                $('#hantar_notis').html(data);				
                $('#btn_jana_hantar_notis').click(function(){ 
                    $.ajax({
                        type: 'POST', 
                        url: '<?php echo base_url('index.php/laporan/jana_hantar_notis')?>',
                        data: { 
                            ujian: $('#ujian').val(),
                            id_ambilan: id_ambilan,
                            jenis_fasiliti : $('#jenis_fasiliti').val(),
                            fasiliti : $('#fasiliti').val(),
                            penempatan : $('#penempatan').val()
                        },
                        success : function(data){
                            $('#hantar_notis').modal('toggle');
                        }
                    });
                });
            }
      	});	
    });	
    
    $('#genReport').live('click', function(e){
		e.preventDefault();
         if( $('#ujian').val()!='' && $('#siri').val()!='') {
            $( "#ujian" ).css("border", "");
            $( "#siri" ).css("border", "");
            $( "#ujian_msg" ).empty();
            $( "#siri_msg" ).empty();
            var path = '';
            var path2 = '';
            var path3 = '';             
            if($('#jenis_fasiliti').val() && $('#fasiliti').val() && $('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana')?>';
               path2 = '<?php echo base_url('index.php/laporan/senarai_ambil')?>';
               path3 = '<?php echo base_url('index.php/laporan/senarai_belum')?>';
            } else if($('#jenis_fasiliti').val() && $('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana2')?>';
               path2 = '<?php echo base_url('index.php/laporan/senarai_ambil2')?>';
               path3 = '<?php echo base_url('index.php/laporan/senarai_belum2')?>';
            } else if($('#jenis_fasiliti').val() && !$('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana5')?>';
               path2 = '<?php echo base_url('index.php/laporan/senarai_ambil5')?>';
               path3 = '<?php echo base_url('index.php/laporan/senarai_belum5')?>';
            } else if(!$('#jenis_fasiliti').val() && !$('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana6')?>';
               path2 = '<?php echo base_url('index.php/laporan/senarai_ambil6')?>';
               path3 = '<?php echo base_url('index.php/laporan/senarai_belum6')?>';
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
                        $('#senarai_ambil').hide();
                        $('#senarai_belum').hide();
                        $('#dis_export_ambil_excel').hide();
                        $('#dis_export_belum_excel').hide();
                        $('#jana_mesej').modal('show');
                    } else {    
                        $('#generateReport').show();
                        $('#generateReport').html(data);
                    } //end if   
                }
            });	            
            $.ajax({
                type: 'POST',
                url: path2,
                data: { 
                    ujian: $('#ujian').val(),
                    id_ambilan: id_ambilan,
                    jenis_fasiliti : $('#jenis_fasiliti').val(),
                    fasiliti : $('#fasiliti').val(),
                    penempatan : $('#penempatan').val()
                },
                success : function(data){                 
                    $('#senarai_ambil').html(data); 
                }
            });            
            $.ajax({
                type: 'POST',
                url: path3,
                data: { 
                    ujian: $('#ujian').val(),
                    id_ambilan: id_ambilan,
                    jenis_fasiliti : $('#jenis_fasiliti').val(),
                    fasiliti : $('#fasiliti').val(),
                    penempatan : $('#penempatan').val()
                },
                success : function(data){                 
                    $('#senarai_belum').html(data); 
                }
            });
        } else {
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
    $('#jana_ambil_excel').live('click', function(e){
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
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ambil6") ?>?'+data));
        } else if(jenis_fasiliti && !fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ambil5") ?>?'+data));
        } else if(jenis_fasiliti && fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti+"&fasiliti="+fasiliti;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ambil2") ?>?'+data));
        } else if(jenis_fasiliti && fasiliti && penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti+"&fasiliti="+fasiliti+"&penempatan="+penempatan;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_ambil") ?>?'+data));			
        } //end if     
    });  
    
    $('#jana_belum_excel').live('click', function(e){
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
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_belum6") ?>?'+data));
        } else if(jenis_fasiliti && !fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_belum5") ?>?'+data));
        } else if(jenis_fasiliti && fasiliti && !penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti+"&fasiliti="+fasiliti;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_belum2") ?>?'+data));
        } else if(jenis_fasiliti && fasiliti && penempatan){
            data = "siri="+siri+'/'+tahun+"&id_ambilan="+id_ambilan+"&ujian="+ujian+"&jenis_fasiliti="+jenis_fasiliti+"&fasiliti="+fasiliti+"&penempatan="+penempatan;
            $("body").append(components.iframe('<?php echo base_url("index.php/laporan/jana_laporan_belum") ?>?'+data));			
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
		
		//alert( $('#jenis_fasiliti').val() );
		
        $.ajax({
            type: 'POST', 
            url: path,
            data: { jenis_fasiliti: $('#jenis_fasiliti').val() },
            success : function(data){
				
				//alert (data);
				
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
    
    $('#papar_ambil').live('click', function(e){
        e.preventDefault();                             
        $('#senarai_ambil').show();
        $('#senarai_belum').hide();
        $('#dis_export_ambil_excel').show(); 
        $('#dis_export_belum_excel').hide(); 
    });    
    
    $('#papar_belum').live('click', function(e){
        e.preventDefault();                             
        $('#senarai_ambil').hide(); 
        $('#senarai_belum').show();
        $('#dis_export_ambil_excel').hide(); 
        $('#dis_export_belum_excel').show(); 
    });		
});    
</script>