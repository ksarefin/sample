<?php
/**
 * includes.php
 * 
 * @created on 2012/03/22
 * @package	   VoiceLink  
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2012/03/22-11:42:25 fabien 
 * 
 *File content
     includes.php
 *     
 */

 $smarty_class_path = BASE_DIR.LIB_SRC.ENGIN_DIR.ENGIN_CLASS;
 include_once ($smarty_class_path);
 
 $voicelink_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.VOICELINK; 
 include_once ($voicelink_class_path);
 
 $err_calss_path = BASE_DIR.LIB_SRC.CLASS_DIR.ERR_CLASS;
 include_once ($err_calss_path);
 
 $login_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.LOGIN_CLASS;
 include_once ($login_class_path);
 
 $ini_parser_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.INI_PARSER;
 include_once ($ini_parser_class_path);

 $form_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.FORM_CLASS;
 include_once ($form_class_path);
 
 $data_class_path = BASE_DIR.LIB_SRC.CLASS_DIR.DATA_CLASS;
 include_once ($data_class_path);
 
 $functions_path = BASE_DIR.LIB_SRC.FUNCTION_DIR.FUNCTIONS;
 include_once ($functions_path); 
 
 $model_define_path = BASE_DIR.CONFIG.MODEL_DEFINE; 
 include_once ($model_define_path);
 
 
 
 
 ?>