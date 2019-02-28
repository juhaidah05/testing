<?php  

/*  Tarikh Cipta    : ?
 *  Programmer      : ?
 *  Tujuan Aturcara : Tetapan aplikasi sokongan CI
 *  Pengubahsuai    :   1. Mohd. Hafidz Bin Abdul Kadir  
 *  Perubahan       :   
 *  (21 Sept 2015)  :   1. Indent semula snippet code
 *                      2. Buang semua comment yang tidak perlu
 *                      3. Tukar pernyataan if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 *                         kepada defined('BASEPATH') OR exit('No direct script access allowed');
 *                      4. Set $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/eMINDA/' 
 *                         kepada $config['base_url']	= 'http://'.filter_input(INPUT_SERVER, 'HTTP_HOST').'/eMINDA/'                           
 *                      5. Set $config['encryption_key'] = 'eMINDA_PROJECT'
 *                      6. Tambah nama aplikasi dan template loader
 */

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

//Base Site URL
//$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/eMINDA/';
$config['base_url']	= 'http://'.filter_input(INPUT_SERVER, 'HTTP_HOST').'/exNewComer/';

//Index File
$config['index_page'] = 'index.php';

//URI PROTOCOL
$config['uri_protocol']	= 'AUTO';
//   $config['uri_protocol']  = 'REQUEST_URI';

//URL suffix
$config['url_suffix'] = '';

//Default Language
$config['language']	= 'english';

//Default Character Set
$config['charset'] = 'UTF-8';

//Enable/Disable System Hooks
$config['enable_hooks'] = FALSE;

//Class Extension Prefix
$config['subclass_prefix'] = 'MY_';

//Allowed URL Characters
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

//Enable Query Strings
$config['allow_get_array']	= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']	= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use

//Error Logging Threshold
$config['log_threshold'] = 0;

//Error Logging Directory Path
$config['log_path'] = '';

//Date Format for Logs
$config['log_date_format'] = 'Y-m-d H:i:s';

//Cache Directory Path
$config['cache_path'] = '';

//Encryption Key
$config['encryption_key'] = 'eMINDA_PROJECT';

//Session Variables
$config['sess_cookie_name']	= 'ci_session';
$config['sess_expiration']	= 7200;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']	= 'ci_sessions';
$config['sess_match_ip']	= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;

//Cookie Related Variables
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

//Global XSS Filtering
$config['global_xss_filtering'] = FALSE;

//Cross Site Request Forgery
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

//Output Compression
$config['compress_output'] = FALSE;

//Master Time Reference
$config['time_reference'] = 'local';

//Rewrite PHP Short Tags
$config['rewrite_short_tags'] = FALSE;

//Reverse Proxy IPs
$config['proxy_ips'] = '';

//Application's name
$config['site_name'] = "Aplikasi Saringan Minda Sihat";

//$config['debug'] = false;

//Template Loading
$config['template_folder'] = "bootstrap";
$config['template'] = "bootstrap/template";