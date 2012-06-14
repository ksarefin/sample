<?php
/**
 * define.php
 * 
 * @created on 2011/05/13
 * @package	   FORM    
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/05/13-13:20:40 fabien 
 * 
 *File content
     define.php
 *     
 */
 
 define("BASE_DIR"			, realpath(dirname(__FILE__)));
 define("HOME_DIR" 			, BASE_DIR."/wpcms");
 define("WEB_DIR" 			, "/wpform/wpcms");
 define('COMMOM_DIR'		, "/common");
 define("UPLOAD"			, HOME_DIR.'/upload');
 define("TMP"				, '/tmp');
 define("COMMON"			, '/commonSetting.php');
 define("CONFIG"        	, "/config");
 define("INCLUDES"			, "/includes.php");
 define("VERSION"			, "/version.php");
 define("MODEL_DEFINE"		, "/model_define.php");
 define("CONFIG_PHP"    	, "/config.php");
 define("LIB_SRC"			, "/lib_src");
 define("LIB"				, "/lib");
 define("LIB_BASE"			, "/lib_base.php");
 define("CLASS_DIR"			, "/class");
 define('WPCMS'				, "/WpCms.class.inc.php");
 define("BASE_CLASS"		, "/BaseClass.inc.php");
 define("ERR_CLASS"			, "/ErrorClass.inc.php");
 define("ERR_CHECK"			, "/ErrorCheckClass.inc.php");
 define("LOGIN_CLASS"		, "/LoginClass.inc.php");
 define("INI_PARSER"		, "/IniParserClass.inc.php");
 define('RSS_PARSER'		, "/RssParserClass.inc.php");
 define("INI_GENERATOR"		, "/IniGeneratorClass.inc.php");
 define("FORM_CLASS"		, "/FormClass.inc.php");
 define("HTML_CODE_CLASS"	, "/HtmlCodeClass.inc.php");
 define("MAIL_TEMP_CLASS"	, "/MailTemplateClass.inc.php");
 define("DATA_CLASS"		, "/DataClass.inc.php");
 define("FUNCTION_DIR"		, "/function");
 define("FUNCTIONS"			, "/functions.php");
 define("JSON"				, "/json.php");
 define("SRC"				, "/src/web");
 define("SRC_ADMIN"			, "/src/admin");
 define("SRC_SETTINGS"		, "/src/settings");
 define("SRC_AGENCY"		, "/src/agency");
 define("SRC_SITE_ADMIN"	, "/src/site_admin");
 define("EXECUTE"			, "/execute.php");
 define("HOST"				, $_SERVER["HTTP_HOST"]);
 define("TOP_PAGE"     	 	, "/wpform/");
 define("ADMIN_TOP"    	 	, "/wpform/admin/");
 define("ENGIN_DIR"			, "/smarty");
 define("ENGIN_CLASS"		, "/Smarty.class.php");
 define("ADMIN_DISP"		, "10");
  
 


 define("_HOST"				, $_SERVER['HTTP_HOST']);
 define("_HTTPS"			, "https://"._HOST);
 define("_HTTP"				, "http://"._HOST);
 define("_FROM_MAIL"		, "");
 define("_ADMIN_MAIL"		, "");
 define("_CONTACT_MAIL"		, "");
 define("_REGIST_MAIL"		, "");
 define("_SITE_TITLE"		, "WPCMS");
 define("_CHARSET"			, "utf-8");
 define("_META_DESCRIPTION"	, "");
 define("_META_KEYWORD"		, "");
 define("_META_ROBOTS"		, "index,follow");
 define("_VERIFY"			, "");
 define("_Y_KEY"			, "");
 define("_MS"				, "");
 define("_GOOGLE_MAP_KEY"	, "");
 define("_REMOTE_ADDR"		, $_SERVER['REMOTE_ADDR']);
	
 define("_ADMIN_DISP_NUM"	, "10");
 define("_COOKIE_NAME"		, "bsii_auto_login");
 
 
 define("INI_DIR"			, BASE_DIR.'/ini');
 define("FORM_INI_DIR"		, BASE_DIR.'/ini/form');
 define("WPCMS_INI"			, INI_DIR.'/wpcms.ini');
 define("COMMON_INI"		, INI_DIR."/common.ini");
 define("FORM_SET_INI"		, INI_DIR."/formset.ini");
 define("MAIL_DATA_INI"		, INI_DIR."/mail_data.ini");
 
 
 define('TO_ENCODING'		, 'UTF-8');
 define('FROM_ENCODING'		, 'UTF-8');
 
 
 
 
 
 
 ?>