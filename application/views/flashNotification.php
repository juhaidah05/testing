<?php
$message_type = $this->session->flashdata('message_type');
$flash=$this->session->flashdata('flashMessage');
if ($flash != ""):?> 
	<div class="alert alert-<?php echo $message_type?>"> 
	    <?php echo $flash?>
	</div>
<?php  
endif;
?>
