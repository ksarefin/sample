<?php
/**
 * form_reportModelClass.php
 * 
 * @created on 2012/02/09
 * @package    FORM
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/02/09 - 17:35:25 fabien 
 * 
 *File content
     form_reportModelClass.php
 *     
 */
 
 
 class form_reportModelClass extends Configuration{

 	/**
 	 * wpcms instance
 	 */
 	private $wpcms; 
 	
 	/**
 	 * table instance
 	 */
 	private $table;
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;

 	
 	
 	/**
 	 * class construct
 	 */
 	function __construct(){
 		
 		/**
 		 * wpcms class object
 		 */
 		$this->wpcms = new WpCms();

 		/**
 		 * assign table name
 		 */
 		$this->table = 'form_report_view';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	/**
 	 * get page view list
 	 * @return list
 	 */
 	public function getPageViewList($limit = null, $offset = null){
 		
 		
 		$search_array = array(
	 		'id',
	 		'form_tab_id',
	 		'sum(top_view) as top_view',
	 		'sum(form_view) as form_view',
	 		'sum(conf_view) as conf_view',
	 		'sum(send_view) as send_view',
	 		'check_month',
	 		'form_id',
	 		'title',
	 		'form_tab_display_flg'
 		);
 		
 		$QB = new QueryBuilder();
 		
 		$sql  = " SELECT ";
 		$sql .= join(',', $search_array);
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		$sql .= " GROUP BY ";
 		$sql .= " form_id ";
 		
 		$query_txt = $QB->out($sql);
 		
 		if (!empty($limit) && is_numeric($limit)){
 			$query_txt .= " LIMIT ".$limit; 
 		}
 		
 		if (!empty($offset) && is_numeric($offset)){
 			$query_txt .= " OFFSET ".$offset;
 		}
 		
 		$result = $this->DB->refer($query_txt);
 		
 		
 		return $result;
 		
 	} // getPageViewList
 	
 	
 	
 	
 	/**
 	 * get monthly report list
 	 * @return list
 	 */
 	public function getMonthlyReportList($form_id, $limit = null, $offset = null){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid");
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_tab_id', $form_id);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= " form_monthly_report_view ";
 		
 		$query_txt = $QB->out($sql);
 		
 		if (!empty($limit) && is_numeric($limit)){
 			$query_txt .= " LIMIT ".$limit; 
 		}
 		
 		if (!empty($offset) && is_numeric($offset)){
 			$query_txt .= " OFFSET ".$offset;
 		}
 		
 		$result = $this->DB->refer($query_txt);
 		
 		
 		return $result;
 		
 	} // getPageViewList
 	
 	
 	
 	/**
 	 * get survey report list
 	 * @return list
 	 */
 	public function getSurveyReportList($limit = null, $offset = null){
 		
 		
 		$QB = new QueryBuilder();
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= " survey_report_view ";
 		
 		$query_txt = $QB->out($sql);
 		
 		if (!empty($limit) && is_numeric($limit)){
 			$query_txt .= " LIMIT ".$limit; 
 		}
 		
 		if (!empty($offset) && is_numeric($offset)){
 			$query_txt .= " OFFSET ".$offset;
 		}
 		
 		$result = $this->DB->refer($query_txt);
 		
 		
 		return $result;
 		
 	} // getPageViewList
 	
 	
 	
 	
 	/**
 	 * get set survey list 	 
 	 * @param $form_id
 	 * @param $set_id
 	 * @return survey list  
 	 */
 	public function getSurleyList($form_id, $set_id, $limit = null, $offset = null){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid");
	 		
	 	if (empty($set_id) || !is_numeric($set_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: set id is empty or invalid");

	 	$QB = new QueryBuilder();
	 	$QB->setInteger('display_flg', 1);
	 	$QB->setInteger('delete_flg', 0);
	 	$QB->setInteger('form_id', $form_id);
	 	$QB->setInteger('set_id', $set_id);
	 	
	 	$sql  = " SELECT ";
 		$sql .= " survey_id ";
 		$sql .= " FROM ";
 		$sql .= " form_entry_tab ";
 		
 		if (!empty($limit) && is_numeric($limit)){
 			$query_txt .= " LIMIT ".$limit; 
 		}
 		
 		if (!empty($offset) && is_numeric($offset)){
 			$query_txt .= " OFFSET ".$offset;
 		}
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		/**
 		 * get survey information
 		 */
 		$survey_list = array();
 		foreach ($result as $row){
 			if (!empty($row))
 				$survey_list[] = $this->getSurveyInfo($row['survey_id']);
 		}
 		
 		if(!empty($survey_list)) 
 			return $survey_list;
	 	
 	} // getSurleyList
 	
 	
 	
 	
 	/**
 	 * get survey information
 	 * @param $survey_id
 	 * @return survey info
 	 */
 	public function getSurveyInfo($survey_id){
 		
 		if (empty($survey_id) || !is_numeric($survey_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: survey id is empty or invalid");
	 		
	 	$search_array = array(
	 		'id',
	 		'type',
	 		'name',
	 		'options',
	 		'value',
	 	);

	 	$QB = new QueryBuilder();
	 	//$QB->setInteger('display_flg', 1);
	 	$QB->setInteger('delete_flg', 0);
	 	$QB->setInteger('id', $survey_id);
	 	
	 	$sql  = " SELECT ";
 		$sql .= join(',', $search_array);
 		$sql .= " FROM ";
 		$sql .= " survey_tab ";
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) 
 			return $result[0];
	 	
 	} // getSurveyInfo
 	
 	
 	
 	/**
 	 * get option count
 	 * @param $form_id
 	 * @param $set_id
 	 * @param $survey_id
 	 * @param $option
 	 * @return count
 	 */
 	public function getOptionCount($form_id, $set_id, $survey_id, $option, $params = null){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid");
 		
 		if (empty($set_id) || !is_numeric($set_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: set id is empty or invalid");
 		
 		if (empty($survey_id) || !is_numeric($survey_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: survey id is empty or invalid");
	 		
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('form_id', $form_id);
	 	$QB->setInteger('set_id', $set_id);
	 	$QB->setInteger('survey_id', $survey_id);
	 	$QB->setLike('answer', $option);
	 	
	 	if (!empty($params)){
	 		$QB->set(" entry_date >='".$params['start_date']."'");
	 		$QB->set(" entry_date <='".$params['end_date']."'");	 		
	 	}
	 	
	 	$sql  = " SELECT ";
 		$sql .= " count(survey_id) as survey_count ";
 		$sql .= " FROM ";
 		$sql .= " survey_report_tab ";
 		
 		$query_txt = $QB->out($sql);
 		//print "<br>".$query_txt."<br>";
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0]['survey_count'];
 		
 	} // getOptionCount
 	
 	
 	
 	/**
 	 * get number of display rows
 	 * @return number of row
 	 */
 	public function getNumRows(){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_tab_display_flg', 1);
 			
 		$sql  = " SELECT ";
 		$sql .= " count(form_id) AS count_id";
 		$sql .= " FROM ";
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) 
 			$num_rows = $result[0]['count_id'];
 			
 		return $num_rows;
 		
 	} // getNumRows
 	
 	
 	
 	
 	/**
 	 * 
 	 * get total row number
 	 * @return row number 
 	 */
 	public function getTotalRows(){
 			

 		$QB = new QueryBuilder();
 		
 		$sql  = " SELECT ";
 		$sql .= " count(form_id) as count_id ";
 		$sql .= " FROM ";
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
 			$total = $result[0]['count_id'];
 		

 		return $total;
 		
 	} // getTotalRows
 	
 	
 	
 	
 	
 	
 } // form_reportModelClass.php
 
 
 ?>