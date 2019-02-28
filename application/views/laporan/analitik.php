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
                <?php echo tbs_horizontal_form_open('', array('id'=>'laporan_analitik'));?>                
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
<div align="center">
    <div id="chartContainer" style="display:none; float:left; "></div>    
    <div id="chartContainer3" style="display:none; float:right;"></div>
    <div id="chartContainer2" style="display:none; float:left;"></div>
</div>
<script>   
$(document).ready(function() {           
    $('#genReport').live('click', function(e){
		//alert($('#penempatan').val());
        e.preventDefault();
        if( $('#ujian').val()!='' && $('#siri').val()!='') {              
            $( "#ujian" ).css("border", "");
            $( "#siri" ).css("border", "");
            $( "#ujian_msg" ).empty();
            $( "#siri_msg" ).empty();            
            var path = '';  
            if($('#jenis_fasiliti').val() && $('#fasiliti').val() && $('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana3')?>';
            } else if($('#jenis_fasiliti').val() && $('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana4')?>';
            } else if($('#jenis_fasiliti').val() && !$('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana7')?>';
            } else if(!$('#jenis_fasiliti').val() && !$('#fasiliti').val() && !$('#penempatan').val()){
               path =  '<?php echo base_url('index.php/laporan/status_jana8')?>';
            } //end if           
            //alert(path);
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
                        $('#chartContainer').hide();
                        $('#chartContainer2').hide();
                        $('#chartContainer3').hide();
                        $('#jana_mesej').modal('show');
                    } else {   
						$('#generateReport').show();
                        $('#generateReport').html(data);                        
                        
                        var myChart3 = new FusionCharts( '<?php echo base_url('assets/fscharts/MSColumn3D.swf')?>', 
                        "myChartId3", "550", "600", "0" );                        
                        var strXML = "<chart canvasBgAlpha='0' legendBgAlpha='0' yAxisMaxvalue='100' decimals='2' numberSuffix='%' caption='Peratusan Keputusan Ujian DASS Mengikut Kriteria Pengukuran' palette='5' showvalues='1' plotfillalpha='95' showborder='0'><categories><category label='Tekanan' /><category label='Kebimbangan' /><category label='Kemurungan' /></categories><dataset seriesname='Normal'><set value='"+$('#jumlah_sn').val()+"' /><set value='"+$('#jumlah_en').val()+"' /><set value='"+$('#jumlah_dn').val()+"' /></dataset><dataset seriesname='Ringan'><set value='"+$('#jumlah_sr').val()+"' /><set value='"+$('#jumlah_er').val()+"' /><set value='"+$('#jumlah_dr').val()+"' /></dataset><dataset seriesname='Sederhana'><set value='"+$('#jumlah_ss').val()+"' /><set value='"+$('#jumlah_es').val()+"' /><set value='"+$('#jumlah_ds').val()+"' /></dataset><dataset seriesname='Teruk'><set value='"+$('#jumlah_st').val()+"' /><set value='"+$('#jumlah_et').val()+"' /><set value='"+$('#jumlah_dt').val()+"' /></dataset><dataset seriesname='Sangat Teruk'><set value='"+$('#jumlah_st').val()+"' /><set value='"+$('#jumlah_est').val()+"' /><set value='"+$('#jumlah_dst').val()+"' /></dataset></chart>"; 
                        myChart3.setXMLData(strXML);                        
                        myChart3.render("chartContainer3");                          
                        $('#chartContainer3').show();
                        
                        var myChart2 = new FusionCharts( '<?php echo base_url('assets/fscharts/Pie3D.swf')?>',
                        "myChartId", "550", "600", "0" );
                        var strXML2 ="<chart canvasBgAlpha='0' legendBgAlpha='0' caption='Peratusan Warga KKM\nMenjawab Ujian Berbanding Pengguna Berdaftar' use3DLighting='1' palette='5' pieslicedepth='25' startingangle='125' showborder='0' showPercentInToolTip='0'><set label='Selesai Ambil' value='"+$('#jumlah_ambil').val()+"' issliced='1'/><set label='Belum Ambil' value='"+$('#jumlah_belum').val()+"' /><set label='Mengulang Ujian' value='"+$('#jumlah_ulang').val()+"' issliced='1'/></chart>"; 
                        myChart2.setXMLData(strXML2);  
                        myChart2.render("chartContainer");
                        $('#chartContainer').show();
                        
                        var myChart = new FusionCharts( '<?php echo base_url('assets/fscharts/MSColumn3D.swf')?>', 
                        "myChartId2", "550", "600", "0" );                        
                        var strXML = "<chart canvasBgAlpha='0' legendBgAlpha='0' caption='Jumlah Warga KKM\nDengan Keputusan Teruk/Sangat Teruk\nMengikut Jantina & Kriteria Ujian' palette='5' paletteColors='FF0000,0372AB,FF5904' showvalues='1' plotfillalpha='95' formatnumberscale='0' showborder='0'><categories><category label='Tekanan' /><category label='Kebimbangan' /><category label='Kemurungan' /></categories><dataset seriesname='Lelaki'><set value='"+$('#jumlah_lts').val()+"' /><set value='"+$('#jumlah_lte').val()+"' /><set value='"+$('#jumlah_ltd').val()+"' /></dataset><dataset seriesname='Perempuan'><set value='"+$('#jumlah_pts').val()+"' /><set value='"+$('#jumlah_pte').val()+"' /><set value='"+$('#jumlah_ptd').val()+"' /></dataset></chart>"; 
                        myChart.setXMLData(strXML);                        
                        myChart.render("chartContainer2");                          
                        $('#chartContainer2').show();
                    }    
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
    $('#resReport').live('click', function(e){
        e.preventDefault();
        $('#ujian').val('');
        $('#siri').val('');
        $('#tahun').val('');
        $('#jenis_fasiliti').val('');
        $('#fasiliti').val('');
        $('#penempatan').val('');
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
});    
</script>