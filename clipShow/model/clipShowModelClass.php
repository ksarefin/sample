<?php
/**
 * clipShowModelClass.php
 * 
 * @created on 2012/04/19
 * @package    VoiceLink
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/04/19 - 11:31:50 fabien 
 * 
 *File content
     clipShowModelClass.php
 *     
 */
 
 
 class clipShowModelClass extends Configuration{
 	
 	/**
 	 * wpcms instance
 	 */
 	private $voice_link; 
 	
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
 		$this->voice_link = new VoiceLink();

 		/**
 		 * assign table name
 		 */
 		$this->table = 'publish_tab';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * get publish informaion
 	 * @param $room_no
 	 * @return information
 	 */
 	public function getPublishInfo($room_no){
 		
 		if (empty($room_no) || !is_numeric($room_no))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: room number is empty or invalid");
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('room_no', $room_no);
	 	$QB->setInteger('publish_flg', 1);
	 	$QB->setLimit(1);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 			
 		
 	} // getPublishInfo
 	
 	
 	/**
 	 * get update publish information
 	 * @param $user_id
 	 * @param $clip_id
 	 * @return information
 	 */
 	public function getUpdatePublishInfo($user_id, $clip_id){
 		
 		if (empty($user_id) || !is_numeric($user_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: user id is empty or invalid");
	 	
	 	if (empty($clip_id) || !is_numeric($clip_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: clip id is empty or invalid");
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('user_id', $user_id);
	 	$QB->setInteger('clip_id', $clip_id);
	 	$QB->setInteger('publish_flg', 1);
	 	$QB->setLimit(1);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 			
 	} // getUpdatePublishInfo
 	
 	
 	
 	/**
 	 * user check 
 	 * @param $user
 	 * return result
 	 */
 	public function getUserInfo($user_id){
 		
 		if (empty($user_id) || !is_numeric($user_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: user id is empty or invalid");
 			
 			
 		$fields = array('id','name','passwd','type', 'author');
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('id', $user_id);
 		$QB->setInteger('activeuser', 1);
 		$QB->setInteger('type', 1);
 		$QB->setOrder(" id DESC ");
 		$QB->setLimit(1);
 		
 		$sql  = " SELECT ";
 		$sql .= join(",", $fields);
 		$sql .= " FROM ";
 		$sql .= 'account_users';
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		return $result[0];
 		
 	} // userCheck
 	
 	
 	/**
 	 * get clip informain
 	 * @param $user_id
 	 * @param $clip_id
 	 * @return clip info
 	 */
 	public function getClipInfo($user_id, $clip_id){
 		
 		if (empty($user_id) || !is_numeric($user_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: user id is empty or invalid");
	 		
	 	if (empty($clip_id) || !is_numeric($clip_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: clip id is empty or invalid");
	 		
	 	
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $clip_id);
	 	$QB->setInteger('user_id', $user_id);
	 	$QB->setInteger('display_flg', 1);
	 	$QB->setInteger('delete_flg', 0);
	 	
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= " clip_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 		
 	} // getClipInfo
 	
 	
 	/**
 	 * get clip image informain
 	 * @param $clip_image_id
 	 * @return clip image info
 	 */
 	public function getClipImageInfo($clip_image_id){
 		
 		if (empty($clip_image_id) || !is_numeric($clip_image_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: clip image id is empty or invalid");
	 		
	 	
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $clip_image_id);
	 	$QB->setInteger('display_flg', 1);
	 	$QB->setInteger('delete_flg', 0);
	 	
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= " clip_image_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 		
 	} // getClipImageInfo
 	
 	
 	
 	
 
 } // clipShowModelClass.php
 
 
 ?>