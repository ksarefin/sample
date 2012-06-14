<?php
/**
 * wpnoticeControllerClass.php
 * 
 * @created on 2011/10/28
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/10/28 - 19:07:29 fabien 
 * 
 *File content
     wpnoticeControllerClass.php
 *     
 */
 
 
 class wpnoticeControllerClass extends Configuration{
 
 	
 	/**
 	 * common handler for project
 	 */
 	protected $wpcms;
 	
 	/**
 	 * data handler for this module
 	 */
 	protected $db_model;

 	/**
 	 * data class instance
 	 */
 	protected $data_class;
 	
 	/**
 	 * numbers of rows instance
 	 */
 	protected $num_rows;
 	
 	/**
 	 * notice id instance
 	 */
 	protected $notice_id;
 	
 	
 	
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		/**
 		 * wpcms handler
 		 */
 		$this->wpcms = new WpCms();
 		
 		/**
 		 * this database model
 		 */
 		$this->db_model = new wpnoticeModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		/**
 		 * get url notice_id
 		 */
 		$url_notice_id = $this->getUrlParam('notice_id');
 		$this->notice_id = get_id($url_notice_id);
 			
 		if ($this->notice_id)
 			$this->setAttribute('notice_id', $this->notice_id);
 		
 		$this->viewAssign('notice_id', $this->getAttribute('notice_id'));
 		
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'お知らせ');
 		
 	} // commonAction
 	
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
 		 * page limit
 		 */
 		$limit = 5;
 		
 		/**
		 * get from data list and assign to view
		 */
 		$result = $this->db_model->getList($limit);
 		
 		$list = array();
 		foreach ($result as $row){
 			
 			$tmp = array();
 			$tmp = $row;
 			$tmp['label_name'] = $this->data_class->getLabelName($row['label']);
 			
 			$list[] = $tmp;
 		}
 		//print_r($list);
 		
 		$this->viewAssign('list', $list); 		
 			
 		
 		$this->setDisplay('index');
 		
 	} // indexAction
 	
 	
 	
 	
 	public function listAction(){
 		
 		
 		/**
 		 * set page url array
 		 */
 		$url_array = array($this->module_name, $this->action_name);
 		
 		/**
 		 * get page number from url and set attribute
 		 */
 		$page_no = $this->getUrlParam('page');
 		if (!empty($page_no) && !is_numeric($page_no))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: page number is empty or invalid");
 		
 		/**
 		 * set page number to 1 if page number is empty and assign to view
 		 */
 		if (empty($page_no)){
 			
 			$page_no = 1;
 		}else {
 			
 			if (is_numeric($page_no))
 				array_push($url_array, 'page',$page_no);
 		}

 		$this->viewAssign('page_no', $page_no);
 		
 		/**
 		 * get page limit from parameter
 		 */
 		$limit = $this->getUrlParam('limit');
 		if (!empty($limit) && !is_numeric($limit))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: page limit is empty or invalid");
 			
 		if (is_numeric($limit))
 			$this->setAttribute('limit', $limit);
 		
 		/**
 		 * if page limit is empty set page limit and assign to view
 		 */	
 		if (empty($limit)){
 			
 			$limit = ADMIN_DISP;
 		}else {
 			
 			if (is_numeric($limit))
 				array_push($url_array, 'limit', $limit);
 		}
 		
 		$this->viewAssign('limit', $limit);
 		
 		/**
 		 * set paging offset
 		 */
 		$offse = ($page_no-1) * $limit;
 		
 		/**
 		 * set number to dispaly list number on view
 		 */
 		$this->viewAssign('number', (($page_no-1)*$limit));
 		
 		/**
 		 * data base row count and assign to view
 		 */
 		if (empty($this->num_rows))
 			$this->num_rows = $this->wpcms->getNumRows('notice_tab');
 		
 		$this->viewAssign('num_rows', $this->num_rows);	
 			
 		/**
 		 * if show all in one page
 		 */
		if ($limit == 'all'){
 			
 			$limit = 0;
 			$this->viewAssign("paging",'<li><span>1</span></li>');
 		}else {
 			
 			/**
 			 * get paging html, previous, next page info and assign to view
 		 	 */
 			$page_class = new PageClass($this->num_rows, $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/limit/'.$limit;;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		
 		}
 		
 		/**
		 * make list from data and assign to view
		 */
 		$result = $this->db_model->getList($limit, $offse);
 		
 		$list = array();
 		foreach ($result as $row){
 			
 			$tmp = array();
 			$tmp = $row;
 			$tmp['label_name'] = $this->data_class->getLabelName($row['label']);
 			
 			$list[] = $tmp;
 		}
 		//print_r($list);
 		
 		$this->viewAssign('list', $list); 		
 		
 		/**
 		 * get total row number and assign to view 
 		 */
 		$total_rows = $this->wpcms->getTotal('notice_tab');
 		$this->viewAssign('total_rows', $total_rows);
 		
 		/**
 		 * make url for other page
 		 */
 		if (is_array($url_array))
 			$this->setAttribute('list_page_url', $this->makeUrl($url_array));
 		
 			
 		
 		$this->setDisplay('list');
 	
 	} // listAction
 	
 	
 	/**
 	 * detail action controller
 	 */
 	public function detailAction(){
 		
 		/**
 		 * get notice_id
 		 */
 		$notice_id = $this->getAttribute('notice_id');
 		
 		/**
 		 * get notice detail and assign to view 
 		 */
 		$notice_detail = $this->db_model->getDetail($notice_id);
 		$notice_detail['label_name'] = $this->data_class->getLabelName($notice_detail['label']);
  		
  		$this->viewAssign('notice_detail', $notice_detail);
  		
  		
 		$list_page_url = $this->getAttribute('list_page_url');
 		
 		/**
 		 * get list page url and to view as back url
 		 */
 		if (!empty($list_page_url)){
 			$back_url = $this->getAttribute('list_page_url');
 		}
 		else{
 			$url_array = array();
 			$back_url = $this->makeUrl($url_array);
 		}
 		$this->removeAttribute('list_page_url');
 		
 		$this->viewAssign('back', $back_url);
 		
 		
 		
 		
 		$this->setDisplay('detail');
 		
 	} // detailAction
 	
 	
 	
 	/**
 	 * rss action controller
 	 */
 	public function rssAction(){
 		
 		/**
 		 * rss xml file path
 		 */
 		$file_name = HOME_DIR.'/rss/wpr/rss.xml';
		
 		/**
 		 * get rss file contect
 		 */
 		//$rss_content = file_get_contents($file_name);

 		
		//echo $rss_content;
		
 	$filename = HOME_DIR.'/rss/wpr/rss.xml';
$http_stat_code = readfile_if_modified($filename, array('Content-Type: text/xml'));
switch($http_stat_code) {
case 404:
    header('HTTP/1.0 404 Not Found');
    echo '<html><head></head><body><a href="http://example.com/">http://example.com/<a></body></html>';
    exit;
default:
    header('X-System-Url: http://example.com/', true, $http_stat_code);
}


 		
 		
 	} // rssAction
 	
 	
 
 
 
 } // wpnoticeControllerClass
 
 function readfile_if_modified($filename, $http_header_additionals = array()) {

    if(!is_file($filename)) {
//      header('HTTP/1.0 404 Not Found');
        return 404;
    }

    if(!is_readable($filename)) {
//      header('HTTP/1.0 403 Forbidden');
        return 403;
    }

    $stat = @stat($filename);
    $etag = sprintf('%x-%x-%x', $stat['ino'], $stat['size'], $stat['mtime'] * 1000000);

    header('Expires: ');
    header('Cache-Control: ');
    header('Pragma: ');

    if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
        header('Etag: "' . $etag . '"');
//      header('HTTP/1.0 304 Not Modified');
        return 304;
    } elseif(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $stat['mtime']) {
        header('Last-Modified: ' . date('r', $stat['mtime']));
//      header('HTTP/1.0 304 Not Modified');
        return 304;
    }

    header('Last-Modified: ' . date('r', $stat['mtime']));
    header('Etag: "' . $etag . '"');
    header('Accept-Ranges: bytes');
    header('Content-Length:' . $stat['size']);
    foreach($http_header_additionals as $header) {
        header($header);
    }

    if(@readfile($filename) === false) {
//      header('HTTP/1.0 500 Internal Server Error');
        return 500;
    } else {
//      header('HTTP/1.0 200 OK');
        return 200;
    }

}

 ?>