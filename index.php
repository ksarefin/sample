<?php
/**
 * index.php
 * 
 * @created on 2011/05/13
 * @package    WPCMS
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/05/13-13:10:32 fabien 
 * 
 *File content
     Index.php
 *     
 */

 ini_set('session.use_trans_sid', false);
 
 session_start();

 // clear Cache
 header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");             // Date in the past
 header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");  // always modified
 header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
 header("Cache-Control: no-store, no-cache, must-revalidate");
 header("Cache-Control: post-check=0, pre-check=0", false);
 header("Pragma: no-cache");                                   // HTTP/1.0
 //session_cache_limiter('private_no_expire');
 session_cache_limiter('nocache');
 session_cache_expire(0);

 include_once ('define.php');
 
 $base_class = BASE_DIR.LIB_SRC.CLASS_DIR.BASE_CLASS;
 include_once ($base_class);
 
 $config = BASE_DIR.CONFIG.CONFIG_PHP;
 include_once ($config);

 $execute = BASE_DIR.SRC.EXECUTE;
 include_once ($execute);
 
 
 
 
 ?>