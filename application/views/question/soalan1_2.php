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
            <br/>
            <?php echo tbs_horizontal_form_open('', array('class'=>'form-horizontal', 'name' => 'form1', 'id' => 'form1')) ?> 
            <?php	           	
                foreach($appData as $row) :
                    $no++;
            ?>
            <div class="span12">
                <div class="row-fluid" >
                    <div class="span12"><b><h4><u><span class="lblText"><center><?php echo $row['perihalUjian'];?></center> </span></u></h4></b></div>
                    <br/><br/>
                    <div class="row-fluid">
                        <div class="span12"><span class="lblText">Sila baca setiap kenyataan dan tandakan jawapan yang menggambarkan keadaan anda <b>SEMINGGU YANG LEPAS</b>. Tidak ada jawapan betul atau salah. <b>JANGAN</b> guna terlalu banyak masa untuk mana-mana kenyataan.</span></div>
                    </div>
                    <br/>
                    <?php   
                        $data2 = $this->applicant_model->getdata2($row['kodUjian']); 
                        foreach($data2 as $row1):
                            $i++;
                            $bil++;
                        ?> 
                        <div class="row-fluid">
                            <div class="span12"><span class="lblText"><b><?php echo $bil; ?>. <?php echo $row1['soalan'];?></b></span></div>
                        </div>
                        <br/> 
                        <div class="row-fluid">
                            <div class="span12">
                                <span class="lblText">
                                    <div class="error_message_holder"></div>
                                    <?php   
                                        $jawapan = $this->applicant_model->getansw($row1['idSoalan']); 
                                        $this->db->select('*');
                                        $this->db->from('ujian');
                                        $this->db->where(array('mykad'=>$mykad, 'idPerkhidmatan' => $idPerkhidmatan));
                                        $query_updt2 = $this->db->get();
                                        $updt2 = $query_updt2->row_array();
                                        $idUjian2 = $updt2['idUjian'];                          
                                        foreach($jawapan as $row3):
                                            $j++;
                                            $ansData = $this->Eminda_model->get_info3('txnUjian',array('mykad'=>$mykad),array('idUjian'=>$idUjian2),array('idSoalan'=>$row1['idSoalan']),array('idSJ'=>$row3['idSJ']));
                                            //cari data id_anws where id_quest dan id_answ_quest
                                            $d = ($row3['idSJ'] == $ansData['idSJ']) ? TRUE:FALSE;  
                                    ?> 
                                    <input  type="radio" name="answer-<?php echo $row1['idSoalan'];?>" id="answer<?php $i;?>" value="<?php echo $row3['idJawapan'];?>" <?php echo set_radio('answer-'.$row1['idSoalan'].'-'.$row3['idSJ'], $row3['idJawapan'],$d); ?> />
                                    <?php echo $row3['pilihanJawapan']; ?>
                                    <br/>
                                    <?php endforeach; ?><br/>	
                                </span>	
                            </div>
                        </div>           
                    <?php endforeach; ?>
                </div>     
            <?php endforeach; ?>
            <div class="container-fluid" align="right">
                <a class="btn btn-orange" href="<?php echo site_url('auth/login')?>"><i class="icon icon-chevron-left icon-white"></i> Log Keluar</a>
                <?php echo $links;  ?>
                <button type="submit" class="btn btn-orange" id="btn_Save" name="btn_Save"><i class=""></i>Hantar Soalselidik</button>
            </div>
            <?php echo form_close();?>  
            </div>    
        </div>
        <script src='<?php echo base_url('assets/validation/admin.js')?>'></script>
    </div>