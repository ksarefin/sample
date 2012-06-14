<?php
/**
 * commonSetting.php
 * 
 * @created on 2011/05/16
 * @package    ActiveIR
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/05/16-10:27:49 fabien 
 * 
 *File content
     commonSetting.php
 *     
 */

 $includes = BASE_DIR.CONFIG.INCLUDES;
 include_once ($includes);
 
 $ini_parser = new IniParserClass();
 $ini_array = $ini_parser->iniParse(WPCMS_INI);
 
 $gl_databaseInfo = array("dbType"   => @$ini_array[db_info][dbtype],
 	"dbName"   => @$ini_array[db_info][dbname],
    "host"     => @$ini_array[db_info][host],
    "port"     => @$ini_array[db_info][port],
    "user"     => @$ini_array[db_info][user],
    "password" => @$ini_array[db_info][password],
 );
                        
 $gl_wpcms_Info = array(
	"domain"   			=> @$ini_array['server_info']['domain'],
	"host"   			=> @$ini_array['server_info']['host'],
	"wpcms_path"		=> @$ini_array['server_info']['wpcms_path'],
 );
 
 $gl_enc = 'UTF-8';
 
  
 $smarty = new Smarty();
 $smarty->setCompileDir(HOME_DIR.'/templates_c');
 $smarty->setCacheDir(HOME_DIR.'/cache');
 $smarty->setConfigDir(HOME_DIR.'/configs');
 
 $smarty->assign("host"				, _HOST);
 $smarty->assign("http"				, _HTTP);
 $smarty->assign("https	"			, _HTTPS);
 $smarty->assign('wpcms_path'		, $gl_wpcms_Info['wpcms_path']);
 $smarty->assign('site_title'		, _SITE_TITLE);
 $smarty->assign('meta_description'	, _META_DESCRIPTION);
 $smarty->assign('meta_keyword'		, _META_KEYWORD);
 $smarty->assign('meta_robots'		, _META_ROBOTS);
 $smarty->assign('_charset'			, _CHARSET);
 $smarty->assign("verify"			, _VERIFY);
 $smarty->assign("y_key"			, _Y_KEY);
 $smarty->assign("ms"				, _MS);
 $smarty->assign("google_map_key"	, _GOOGLE_MAP_KEY);
 $smarty->assign("remote_addr"		, _REMOTE_ADDR);
 
 
 header("Content-type: text/html; charset=UTF-8");
 ini_set("output_buffering", "On");
 ini_set('mbstring.http_input', 'UTF-8');
 ini_set('mbstring.http_output', 'UTF-8');
 ini_set('mbstring.internal_encoding', 'UTF-8');
 ini_set('display_errors', 'On');
 mb_language("Japanese");
 mb_internal_encoding("UTF-8");
 mb_regex_encoding("UTF-8");
 error_reporting(E_ALL ^ E_NOTICE);
 
 $lib_base = BASE_DIR.LIB_SRC.LIB.LIB_BASE;
 include_once ($lib_base);
 
 ?>