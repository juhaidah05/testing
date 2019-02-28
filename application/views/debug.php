<?php 
/*  Tarikh Cipta    :   ?
 *  Programmer      :   Mohd. Aidil Mohd. Nayan
 *  Tujuan Aturcara :   -
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (12 Okt 2015)   :   1. Indent semula snippet code
 *                      2. Semak html5 for standard code
 */
?>
<?php if ($this->config->item('debug')): ?>
<hr/>
<font color="red">Debug Info</font>
<pre>
    <?php
    if (isset($this->debug_list) && count($this->debug_list) > 0) {
        foreach($this->debug_list as $k => $v) {
            echo '<b>$this->'.$v."</b><br>";
            if (isset($this->$v)) {
                print_r($this->$v);
            }
        }
    }
    echo "<hr>";
    $this->output->enable_profiler(TRUE);
    echo "<hr>";
    print_r($this->session->userdata);
    echo "<hr>";
    print_r($_SERVER);
    if (isset($this->data)){
        echo "<hr>";
        print_r($this->table1);
    }
    if (isset($this->table1)){
        echo "<hr>";
        print_r($this->table1);
    }	
    ?>
</pre>
<?php endif; ?>