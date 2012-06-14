<?php
/**
 * responseControllerClass.php
 * 
 * @created on 2012/03/08
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/03/08 - 18:23:10 fabien 
 * 
 *File content
     responseControllerClass.php
 *     
 */
 
 
 class responseControllerClass extends Configuration{
 
 	/**
 	 * wpcms class instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * model class instance
 	 */
 	protected $db_model;
 	
 	/**
 	 * data class instance
 	 */
 	protected $data_class;
 	
 	
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		/**
 		 * wpcms class object
 		 */
 		$this->wpcms = new WpCms();
 		
 		/**
 		 * database model class object
 		 */
 		$this->db_model = new responseModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * domain serial action controller
 	 */
 	public function dsAction(){
 		
 		/**
 		 * get post
 		 */
 		$post = $_POST;
 		//print_r($post);exit;
 		
 		$domain = str_replace('www.', '', $post['domain']);
 		$host	= str_replace('www.', '', $post['host']);
 		
 		if ($domain != $host){
 			print 'false'; exit;
 		}
 		
 		$get_result = $this->db_model->getResult($post);
 		$sql['drop_account_users'] = "DROP TABLE IF EXISTS `account_users`";
 		$sql['account_users_sql'] = "CREATE TABLE IF NOT EXISTS `account_users` (  `id` int(11) NOT NULL auto_increment,  `name` varchar(128) collate utf8_unicode_ci NOT NULL,  `passwd` varchar(128) collate utf8_unicode_ci NOT NULL,  `type` int(11) NOT NULL,  `remarks` varchar(256) collate utf8_unicode_ci NOT NULL,  `activeuser` int(11) NOT NULL default '0',  PRIMARY KEY  (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['insert_sql'] = "INSERT INTO `account_users` (`id`, `name`, `passwd`, `type`, `remarks`, `activeuser`) VALUES (1, '".$post['domain']."', '".$post['serial']."', 1, '', 1)";
 		$sql['drop_form_entry_tab'] = "DROP TABLE IF EXISTS `form_entry_tab`";
 		$sql['form_entry_tab_sql'] = "CREATE TABLE IF NOT EXISTS `form_entry_tab` (  `id` int(11) NOT NULL auto_increment,  `form_id` int(11) NOT NULL,  `set_id` int(11) NOT NULL,  `survey_id` int(11) default NULL,  `label` varchar(256) collate utf8_unicode_ci NOT NULL,  `field_labels` varchar(256) collate utf8_unicode_ci default NULL,  `type` varchar(256) collate utf8_unicode_ci default NULL,  `name` varchar(256) collate utf8_unicode_ci NOT NULL,  `txt_check` tinyint(4) default NULL,  `options` text collate utf8_unicode_ci,  `maxlength` int(11) default NULL,  `minlength` tinyint(4) default NULL,  `size` int(11) default NULL,  `rows` int(11) default NULL,  `cols` int(11) NOT NULL,  `auto_mail` smallint(6) default NULL,  `required` int(11) NOT NULL default '0',  `value` text collate utf8_unicode_ci,  `ynfields` text collate utf8_unicode_ci,  `pp_detail` text collate utf8_unicode_ci,  `pp_detail_ex` text collate utf8_unicode_ci,  `url_txt` varchar(256) collate utf8_unicode_ci default NULL,  `url` varchar(256) collate utf8_unicode_ci default NULL,  `exemple` text collate utf8_unicode_ci,  `description` text collate utf8_unicode_ci,  `class` varchar(256) collate utf8_unicode_ci default NULL,  `field_id` varchar(128) collate utf8_unicode_ci default NULL,  `divClass` varchar(256) collate utf8_unicode_ci default NULL,  `divId` varchar(256) collate utf8_unicode_ci default NULL,  `order_num` tinyint(4) NOT NULL,  `display_flg` tinyint(4) NOT NULL default '1',  `delete_flg` tinyint(4) NOT NULL default '0',  `entry_date` text collate utf8_unicode_ci,  `update_date` text collate utf8_unicode_ci,  `admin_user_id` int(11) default NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['drop_form_report'] = "DROP TABLE IF EXISTS `form_report`";
 		$sql['form_report_sql'] = "CREATE TABLE IF NOT EXISTS `form_report` (  `id` int(11) NOT NULL auto_increment,  `form_tab_id` int(11) default NULL,  `page_view` varchar(128) collate utf8_unicode_ci NOT NULL,  `top_view` int(11) default '0',  `form_view` int(11) default '0',  `conf_view` int(11) default '0',  `send_view` int(11) default '0',  `check_month` text collate utf8_unicode_ci NOT NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['drop_form_tab'] = "DROP TABLE IF EXISTS `form_tab`";
 		$sql['form_tab_sql'] = "CREATE TABLE IF NOT EXISTS `form_tab` (  `id` int(11) NOT NULL auto_increment,  `title` varchar(256) collate utf8_unicode_ci NOT NULL,  `detail` text collate utf8_unicode_ci,  `admin_mail1` varchar(128) collate utf8_unicode_ci NOT NULL,  `admin_mail2` varchar(128) collate utf8_unicode_ci default NULL,  `admin_mail3` varchar(128) collate utf8_unicode_ci default NULL, `thanks` text collate utf8_unicode_ci, `customer_mail_title` text collate utf8_unicode_ci, `customer_mail_header` text collate utf8_unicode_ci, `customer_mail_footer` text collate utf8_unicode_ci, `admin_mail_title` text collate utf8_unicode_ci, `admin_mail_header` text collate utf8_unicode_ci, `admin_mail_footer` text collate utf8_unicode_ci, `form_style` int(11) NOT NULL,  `display_flg` int(11) NOT NULL default '1',  `delete_flg` int(11) NOT NULL default '0',  `entry_date` text collate utf8_unicode_ci,  `update_date` text collate utf8_unicode_ci,  `admin_user_id` int(11) default NULL,  `timer_flg` int(11) default NULL,  `timer_time` int(11) default NULL,  `order_num` int(11) NOT NULL,  `is_open` int(11) NOT NULL default '0',  `status` int(11) NOT NULL default '0',  `edited_id` int(11) default NULL,  `edited_time` int(11) default NULL,  `accepted_id` int(11) default NULL,  `accepted_time` int(11) default NULL,  `released_id` int(11) default NULL,  `released_time` int(11) default NULL,  `applicated_id` int(11) default NULL,  `applicated_time` int(11) default NULL,  `comment` text collate utf8_unicode_ci,  `comment_id` int(11) default NULL,  `rejected_id` int(11) default NULL,  `rejected_time` int(11) default NULL,  `comment_time` int(11) default NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['drop_form_mail_tab'] = "DROP TABLE IF EXISTS `form_mail_tab`";
 		$sql['form_mail_tab_sql'] = "CREATE TABLE `form_mail_tab` ( `id` int(11) NOT NULL auto_increment,   `form_id` int(11) NOT NULL,   `mail_from` text collate utf8_unicode_ci,   `mail_to` text collate utf8_unicode_ci, `mail_subject` text collate utf8_unicode_ci NOT NULL, `mail_body` text collate utf8_unicode_ci NOT NULL, `entry_date` text collate utf8_unicode_ci NOT NULL, PRIMARY KEY  (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ";
 		$sql['drop_survey_tab'] = "DROP TABLE IF EXISTS `survey_tab`";
 		$sql['survey_tab_sql'] = "CREATE TABLE IF NOT EXISTS `survey_tab` (  `id` int(11) NOT NULL auto_increment,  `type` varchar(256) collate utf8_unicode_ci default NULL,  `name` varchar(256) collate utf8_unicode_ci NOT NULL,  `options` text collate utf8_unicode_ci,  `value` varchar(128) collate utf8_unicode_ci default NULL,  `description` text collate utf8_unicode_ci,  `required` int(11) NOT NULL default '0',  `class` varchar(256) collate utf8_unicode_ci default NULL,  `field_id` varchar(128) collate utf8_unicode_ci default NULL,  `divClass` varchar(256) collate utf8_unicode_ci default NULL,  `divId` varchar(256) collate utf8_unicode_ci default NULL,  `display_flg` int(11) NOT NULL default '1',  `delete_flg` int(11) NOT NULL default '0',  `entry_date` text collate utf8_unicode_ci,  `update_date` text collate utf8_unicode_ci,  `admin_user_id` int(11) default NULL,  `order_num` int(11) NOT NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['drop_set_tab'] = "DROP TABLE IF EXISTS `set_tab`";
 		$sql['set_tab_sql'] = "CREATE TABLE IF NOT EXISTS `set_tab` (  `id` int(11) NOT NULL auto_increment,  `form_id` int(11) NOT NULL,  `title` varchar(256) collate utf8_unicode_ci NOT NULL,  `class` varchar(256) collate utf8_unicode_ci default NULL,  `set_type` varchar(128) collate utf8_unicode_ci NOT NULL,  `answer_count` int(11) NOT NULL default '0',  `display_flg` int(11) NOT NULL default '1',  `delete_flg` int(11) NOT NULL default '0',  `entry_date` text collate utf8_unicode_ci,  `update_date` text collate utf8_unicode_ci,  `admin_user_id` int(11) default NULL,  `timer_flg` int(11) default NULL,  `timer_time` int(11) default NULL,  `order_num` int(11) NOT NULL,  `is_open` int(11) NOT NULL default '0',  `status` int(11) NOT NULL default '0',  `edited_id` int(11) default NULL,  `edited_time` int(11) default NULL,  `accepted_id` int(11) default NULL,  `accepted_time` int(11) default NULL,  `released_id` int(11) default NULL,  `released_time` int(11) default NULL,  `applicated_id` int(11) default NULL,  `applicated_time` int(11) default NULL,  `comment` text collate utf8_unicode_ci,  `comment_id` int(11) default NULL,  `rejected_id` int(11) default NULL,  `rejected_time` int(11) default NULL,  `comment_time` int(11) default NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['drop_survey_report_tab'] = "DROP TABLE IF EXISTS `survey_report_tab`";
 		$sql['survey_report_tab_sql'] = "CREATE TABLE `survey_report_tab` (  `id` int(11) NOT NULL auto_increment,  `form_id` int(11) NOT NULL,  `set_id` int(11) NOT NULL,  `survey_id` int(11) NOT NULL,  `survey_name` text collate utf8_unicode_ci,  `answer` text collate utf8_unicode_ci,  `entry_date` text collate utf8_unicode_ci,  PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
 		$sql['drop_form_report_view'] = "DROP VIEW IF EXISTS `form_report_view`";
 		$sql['form_report_view_sql'] = "create view form_report_view as select form_report.*, form_tab.id as form_id, form_tab.title, form_tab.display_flg as form_tab_display_flg from form_report right join form_tab on form_report.form_tab_id = form_tab.id order by form_tab.order_num desc";
 		$sql['drop_form_monthly_report_view'] = "DROP VIEW IF EXISTS `form_monthly_report_view`";
 		$sql['form_monthly_report_view_sql'] = "create view form_monthly_report_view as select form_report.top_view as form_monthly_report_top_view , form_report_view.* from form_report inner join form_report_view on form_report_view.check_month = form_report.check_month and form_report.page_view = 'top'";
 		$sql['drop_survey_report_view'] = "DROP VIEW IF EXISTS `survey_report_view`"; 
 		$sql['survey_report_view_sql'] = "create view survey_report_view as select set_tab.id, set_tab.form_id, form_tab.title as form_title, set_tab.title as set_title, set_tab.display_flg as set_display_flg, form_entry_tab.display_flg as form_tab_display_flg, count(form_entry_tab.set_id) as survey_count from set_tab inner join form_tab inner join form_entry_tab on set_tab.form_id = form_tab.id and set_tab.set_type = 'survey_set' and set_tab.form_id = form_entry_tab.form_id and set_tab.id = form_entry_tab.set_id and form_entry_tab.delete_flg = 0 group by form_entry_tab.set_id";
 		
 		$response_sql = join(':sql:', $sql);
 		
 		echo $response_sql;
 		
 	} // dsAction
 	
 	
 	
 	public function installAction(){
 		
 		/**
 		 * get post
 		 */
 		$post = $_POST;
 		
 		$domain['name'] = $this->db_model->getDomainNmae($post);
 		
 		$request_url 	= 'http://'.$post['domain'].'/'.$post['web'].'/wpform/lib_src/smarty/back/demo/templates/tmp/cp/cp.php';
 		$method		  	= 'POST';
		$response		= request($request_url,$method,$domain);
		
		print $response;
 	
 	} // installAction
 
 
 
 } // responseControllerClass
 
 
 ?>