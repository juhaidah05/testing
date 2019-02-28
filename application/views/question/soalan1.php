<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (12 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">                                    
                <div class="span12"><b><h4><u><span class="lblText"><center>Ujian DASS(Depression, Anxiety, Stress Scale</center> </span></u></h4></b></div>
                <br/><br/>
                <div class="row-fluid">
                    <div class="span12"><span class="lblText">Sila baca setiap kenyataan dan tandakan jawapan yang menggambarkan keadaan anda <b>SEMINGGU YANG LEPAS</b>. Tidak ada jawapan betul atau salah. <b>JANGAN</b> guna terlalu banyak masa untuk mana-mana kenyataan.</span></div>
                </div>
                <br/>
                <?php echo tbs_horizontal_form_open('', array('class'=>'form-horizontal', 'name' => 'form1', 'id' => 'form1')) ?>  
                    <table width="100%" border="1" cellspacing="0" cellpadding="10">
                        <tr bgcolor="#F6CECE">
                            <td align="center" width="3%" ><strong>BIL</strong></td>
                            <td align="center" width="49%"><strong>SOALAN</strong></td>
                            <td align="center" width="12%"><strong>TIDAK PERNAH</strong></td>
                            <td align="center" width="12%"><strong>JARANG</strong></td>
                            <td align="center" width="12%"><strong>KERAP</strong></td>
                            <td align="center" width="12%"><strong>SANGAT KERAP</strong></td>
                        </tr>				
                        <?php foreach($appData as $row) : ?>                              
                        <?php	
                            $data2 = $this->applicant_model->getdata2($row['kodUjian']); 
                            foreach($data2 as $row1):
                                $i++;
                                $bil++;
                        ?>
                        <tr >
                            <td bgcolor="#F6CECE" align="center"><strong><?php echo $bil; ?></strong></td>
                            <td bgcolor="#F2F2F2" ><strong><?php echo $row1['soalan'];?></strong></td>
                            <?php 
                            $jawapan = $this->applicant_model->getansw($row1['idSoalan']); 
                            $this->db->select('*');
                            $this->db->from('ujian');
                            $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
                            $query_updt2 = $this->db->get();
                            $updt2 = $query_updt2->row_array();
                            $idUjian2 = $updt2['idUjian'];
                            foreach($jawapan as $row3):
                                $ansData = $this->Eminda_model->get_info3('txnUjian',array('mykad'=>$mykad),array('idUjian'=>$idUjian2),array('idSoalan'=>$row1['idSoalan']),array('idSJ'=>$row3['idSJ']));
                                //cari data id_anws where id_quest dan id_answ_quest
                                $d = ($row3['idSJ'] == $ansData['idSJ']) ? TRUE:FALSE;
                            ?>
                            <td align="center" class="lblText" ><div class="error_message_holder"></div>
                                <input  type="radio" name="answer-<?php echo $row1['idSoalan'];?>" id="answer<?php $i;?>" value="<?php echo $row3['idJawapan'];?>" <?php echo set_radio('answer-'.$row1['idSoalan'].'-'.$row3['idSJ'], $row3['idJawapan'],$d); ?> />					
                            </td>
                            <?php endforeach; ?>							
                        </tr>			
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>		
                    <?php  if($this->session->userdata('soal')=='2'){ ?>		 
                    <div align="right">
                        <button type="submit" class="btn btn-orange" id="btn_Save" name="btn_Save">Hantar Soalselidik <i class="icon icon-chevron-right icon-white"></i></button>
                    </div>
                    <?php  } ?>
                <?php echo form_close();?> 
            </div> 
            <script src='<?php echo base_url('assets/validation/admin.js')?>'></script>
	</div>    
    </div> 
</div>