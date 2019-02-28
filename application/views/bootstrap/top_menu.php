<?php
/*  Tarikh Cipta    :   ?
 *  Programmer      :   ?
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (6 Okt 2015)    :   1. Indent semula snippet code
 *                      2. Buang snippet yang tidak diperlukan
 *	(4 Apr 2016)	:	1. Comment out line 74
 *						2. Tukarkan tbs_horizontal_password() kepada tbs_horizontal_input() pada line 75 dan 76
 */
?>
        <?php include(APPPATH.'/views/menu.php');?>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse">
                        <ul class="nav">
                        <?php if(isset($menu)){
                            foreach ($menu as $k => $v) { 
                                $active = ($cur1 == $k) ? 1 : 0; 
                                if($v['have_sub']){
                        ?>
                            <li class='divider-vertical'></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $v['title']; ?><b class="caret"></b></a>
                                <ul class="dropdown-menu"> 
                                    <?php foreach ($v['sub'] as $k1 => $v1) { 
                        		$active = ($cur1 == $k && $cur2 == $v1['item']) ? 1 : 0; 
                        		$v1['have_subsub']? $link = '#' : $link = site_url().'/'.$k.'/'.$v1['item']; 
                                    ?>
                                    <li <?php echo $v1['have_subsub'] ? 'class="dropdown-submenu"' : '';?>>
                                        <a href="<?php echo $link;?>"><i class="icon <?php echo $v1['icon']; ?>"></i> <?php echo $v1['title'];?></a>
                                        <?php if($v1['have_subsub']){?>
                                        <ul class="dropdown-menu">
                                        <?php foreach ($v[$v1['subcode']]['subsub'] as $k2 => $v2) { ?>
                                            <li><a href="<?php echo site_url()?>/<?php echo $k;?>/<?php echo $v2['item'];?>"><?php echo $v2['title']; ?></a></li>
                                        <?php }//end foreach ?>
                                        </ul>  
                                        <?php }//end if ?>
                                    </li>
                                    <?php }//end foreach ?>
                                </ul>
                            </li>
                        <?php }else{ ?>
                        <li class='divider-vertical'></li>
                        <li <?php echo ($active) ? 'class="active"' : '';?>><a href="<?php echo site_url()?>/<?php echo $k?>/<?php echo $v['item'];?>"><i class="icon <?php echo $v['icon']; ?>"></i> <?php echo $v['title'];?></a></li>  
                        <?php }//end if?>
                        <?php }//end foreach ?>
                        <?php }//end if?>
                        </ul>
                        <ul class="nav pull-right">
                	<?php if($this->authentication->is_logged_in()){?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="text-transform: none;"><i class="icon-user"></i>&nbsp;&nbsp;<?php echo $this->session->userdata('nama'); ?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a data-toggle="modal" data-target="#modal_password" href=""><i class="icon-lock"></i> Tukar Katalaluan</a></li>
                                    <li class="divider"></li>
                                    <li><a data-toggle="modal" data-target="#modal_logout" href=""><i class="icon-off"></i> Logout</a></li>
                                </ul>
                            </li>
                        <?php } else if(base_url("index.php/auth/login") != current_url() ) { ?>
                            <li><a class='brand' href="<?php echo base_url()?>index.php/auth/login"><i class="icon icon-lock"></i> Login</a></li>
                        <?php }//end if ?>
                        </ul>
                        <div class="modal hide fade" id="modal_password" data-backdrop="static" data-keyboard="false">
                            <div class="modal-header"><h3>Kemudahan Tukar Katalaluan</h3></div>
                            <?php echo tbs_horizontal_form_open('auth/change_password', array('id'=>'change_password'));?>
                            <div class="modal-body">
                                <div>                                
                                    <?php //echo tbs_horizontal_password(array('name'=>'old_password','id'=>'old_password','disabled'=>'disabled','value'=>set_value('old_password', $this->session->userdata('katalaluan')),'class'=>''), array('label'=>'Katalaluan Sedia Ada'), true);?>
                                    <?php echo tbs_horizontal_input(array('name'=>'new_password','id'=>'new_password','value'=>set_value('new_password', ''),'class'=>''), array('label'=>'Katalaluan Baru'), true);?>
                                    <?php echo tbs_horizontal_input(array('name'=>'new_cpassword','id'=>'new_cpassword','value'=>set_value('new_cpassword', ''),'class'=>''), array('label'=>'Pengesahan Katalaluan Baru'), true);?>        
                                </div>    
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
                                <a data-dismiss="modal" class="btn btn-orange" id="btn_batal_change_password"><i class="icon icon-remove icon-white"></i> Batal</a>
                            </div>
                            <?php echo form_close();?>                            
                        </div>
                        <script src='<?php echo base_url('assets/validation/login.js')?>'></script>
                        <div class="modal hide fade" id="modal_logout" data-backdrop="static" data-keyboard="false">
                            <div class="modal-header"><h3>Pengesahan Log Keluar</h3></div>
                            <div class="modal-body"><h5>Adakah anda pasti untuk keluar dari aplikasi ini?</h5></div>
                            <div class="modal-footer">
                                <a id="btn_logout_sah" class="btn btn-orange"><i class="icon icon-ok icon-white"></i> Pasti</a>
                                <a data-dismiss="modal" class="btn btn-grey"><i class="icon icon-remove icon-black"></i> Batal</a>
                            </div>
                        </div>
                    </div>
		</div>
            </div>
        </div>