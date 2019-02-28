<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (8 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 *                      3. Buang type="button"
 */
?>
<div class="row-fluid">
    <?php echo tbs_horizontal_form_open('', array('id'=>'senarai_calon'));?>        
        <input type="hidden" id="idAmbilan" value="<?=$idAmbilan;?>" />
        <table>     
            <tr>
                <td width="50%">
                    <?php echo tbs_horizontal_dropdown('kodJantina', $list_jantina, $calon['kodJantina'],array('id'=>'kodJantina','class'=>''),array('label'=>'Jantina','class'=>''),false);?>
                    <?php echo tbs_horizontal_dropdown('idSkim', $list_jawatan, $calon['idSkim'],array('id'=>'idSkim','class'=>''),array('label'=>'Jawatan','class'=>''),false);?>
                    <div id="ajaxgred">
                        <?php echo tbs_horizontal_dropdown('gred', $list_gred, $gred,array('id'=>'gred','class'=>''),array('label'=>'Gred','class'=>''),false);?>
                    </div>
                </td>
                <td width="50%">
                    <?php echo tbs_horizontal_dropdown('kodJenisFasiliti', $list_kodJenisFasiliti, $kodJenisFasiliti,array('id'=>'kodJenisFasiliti','class'=>''),array('label'=>'Jenis Fasiliti','class'=>''),false);?>
                    <div id="ajaxlokasibertugas">
                        <?php echo tbs_horizontal_dropdown('kodFasiliti', $list_kodFasiliti, $kodFasiliti,array('id'=>'kodFasiliti','class'=>''),array('label'=>'Lokasi Bertugas','class'=>''),false);?>  
                    </div>
                    <div id="ajaxpenempatan">
                        <?php echo tbs_horizontal_dropdown('kodPenempatan', $list_penempatan, $kodPenempatan,array('id'=>'kodPenempatan','class'=>''),array('label'=>'Penempatan','class'=>''),false);?>
                    </div>
                </td>
            </tr>
        </table>    
        <div class="" align="center">
            <button id="cari" class="btn btn-orange"><i class="icon icon-search icon-white"></i> Carian</button>
            <button type="reset" id="semula" class="btn btn-orange"><i class="icon icon-repeat icon-white"></i> Reset</button>
            <button id="kembali" class="btn btn-orange" onclick="window.location.href='<?php echo base_url('/index.php/pengaktifanUlangan/ujian_ulangan') ?>'"><i class="icon icon-chevron-left icon-white"></i> Kembali</button>
        </div>
    <?php echo form_close();?>    
</div>
<div class="line"></div>
<div id="listUser"></div>
<div id="callback"></div>
<script src='<?php echo base_url('assets/validation/pengaktifan.js')?>'></script>
<script>
    window.listUser = function(param){ AjaxCall(base_url+'index.php/pengaktifanUlangan/listJson_calon', param, 'listUser', 'id', '', ''); };
    $(document).ready(function(){        
        var idAmbilan = $('#idAmbilan').val();        
        var options = {'idAmbilan' : idAmbilan};
        listUser(options);
        $('#cari').live('click', function(){                
            var idAmbilan = $('#idAmbilan').val();
            var kodJantina = $('#kodJantina').val();
            var idSkim = $('#idSkim').val();
            var gred = $('#gred').val();
            var kodJenisFasiliti = $('#kodJenisFasiliti').val();
            var kodFasiliti = $('#kodFasiliti').val();
            var kodPenempatan = $('#kodPenempatan').val();
            var options = {
                'idAmbilan' : idAmbilan,
                'kodJantina' : kodJantina,
                'idSkim' : idSkim,
                'gred' : gred,
                'kodJenisFasiliti' : kodJenisFasiliti,
                'kodFasiliti' : kodFasiliti,
                'kodPenempatan' : kodPenempatan,
            };
            listUser(options);        
        });    
        $('#idSkim').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/pengaktifanUlangan/getGred', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxgred").slideUp('fast').html(data):$("#ajaxgred").html(data).slideDown('fast');
            });
        });    
        $('#kodJenisFasiliti').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/pengaktifanUlangan/getFasiliti', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxlokasibertugas").slideUp('fast').html(data):$("#ajaxlokasibertugas").html(data).slideDown('fast');
            });
        });        
        $('#kodFasiliti').live('change', function(e){
            e.preventDefault();
            $.post(base_url+'index.php/pengaktifanUlangan/getPenempatan', 'id='+$(this).val(), function(data) {
                (data == '') ? $("#ajaxpenempatan").slideUp('fast').html(data):$("#ajaxpenempatan").html(data).slideDown('fast');
            });
        });
    });    
</script>