<?php  

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Memuatnaik function CI secara automatik
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (21 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 *                      4. Tukar $autoload['config'] = array('config_item');
 *                         kepada $autoload['config'] = array();
 *                      5. Tambah nilai 'email', 'excel', 'pagination' pada $autoload['libraries']
 *                      6. Tambah nilai 'form' dan 'html' pada $autoload['helper']
 */

defined('BASEPATH') OR exit('No direct script access allowed');

//Auto-load Packges
$autoload['packages'] = array();

//Auto-load Libraries
$autoload['libraries'] = array('database','email','excel','form_validation','pagination', 'session','table');

//Auto-load Helper Files
$autoload['helper'] = array('form', 'html', 'url');

//Auto-load Config files
//$autoload['config'] = array('config_item');
$autoload['config'] = array();

//Auto-load Language files
$autoload['language'] = array();

//Auto-load Models
$autoload['model'] = array();