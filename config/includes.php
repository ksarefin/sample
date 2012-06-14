<?php
/**
 * includes.php
 * 
 * @created on 2011/07/15
 * @package	   FORM  
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/07/15-11:42:25 fabien 
 * 
 *File content
     includes.php
 *     
 */
  
 $smarty_class_path = BASE_DIR.LIB_SRC.ENGIN_DIR.ENGIN_CLASS;
 include_once ($smarty_class_path);
 
 $wpcms = BASE_DIR.LIB_SRC.CLASS_DIR.WPCMS; 
 include_once ($wpcms);
 
 $err_calss_path = BASE_DIR.LIB_SRC.CLASS_DIR.ERR_CLASS;
 include_once ($err_calss_path);
 
 $err_check_calss_path = BASE_DIR.LIB_SRC.CLASS_DIR.ERR_CHECK;
 include_once ($err_check_calss_path);
 
 $login_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.LOGIN_CLASS;
 include_once ($login_class_path);
 
 $ini_parser_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.INI_PARSER;
 include_once ($ini_parser_class_path);
 
 $rss_parser_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.RSS_PARSER;
 include_once ($rss_parser_class_path);

 $ini_generator_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.INI_GENERATOR;
 include_once ($ini_generator_class_path);
 
 $form_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.FORM_CLASS;
 include_once ($form_class_path);
 
 $html_code_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.HTML_CODE_CLASS;
 include_once ($html_code_class_path);
 
 $mail_temp_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.MAIL_TEMP_CLASS;
 include_once ($mail_temp_class_path);
 
 $data_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.DATA_CLASS;
 include_once ($data_class_path);
 
 $functions_path = BASE_DIR.LIB_SRC.FUNCTION_DIR.FUNCTIONS;
 include_once ($functions_path); 
 
 $model_define_path = BASE_DIR.CONFIG.MODEL_DEFINE; 
 include_once ($model_define_path);
 
 $version_path = BASE_DIR.CONFIG.VERSION;
 include_once ($version_path);
 
 
 ?>