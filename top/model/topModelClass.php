<?php
/**
 * topModelClass.php
 * 
 * @created on 2012/03/22
 * @package    VoiceLink
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/03/22-15:51:53 fabien 
 * 
 *File content
     topModelClass.php
 *     
 */
 
 
 class topModelClass extends Configuration{
 	
 	
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
 	 * @param $user_id
 	 */
 	public function getPublishInfo($user_id){
 		
 		if (empty($user_id) || !is_numeric($user_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: user id is empty or invalid");
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('user_id', $user_id);
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
 	 * get room number
 	 * @param $user_id
 	 * @param $clip_id
 	 * @return room no
 	 */
 	public function getRoomNumber($user_id, $clip_id){
 		
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
 		$sql .= " room_no ";
 		$sql .= " FROM "; 
 		$sql .= " clip_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0]['room_no'];
 		
 	} // getRoomNumber
 	
 	
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
 	
 	
 	
 	/**
 	 * check clip password
 	 * @param $user_id
 	 * @param $clip_id
 	 * @param $post
 	 * @return true or false
 	 */
 	public function checkPassword($user_id, $clip_id, $post=null){
 		
 		if (empty($user_id) || !is_numeric($user_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: user id is empty or invalid");
	 		
	 	if (empty($clip_id) || !is_numeric($clip_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: clip id is empty or invalid");

	 	
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $clip_id);
	 	$QB->setInteger('user_id', $user_id);
	 	
	 	if (!empty($post['password']))
	 		$QB->setEqual('password', $post['password']);
	 	
	 	$QB->setInteger('display_flg', 1);
	 	$QB->setInteger('delete_flg', 0);
	 	
 		$sql  = " SELECT ";
 		$sql .= " password ";
 		$sql .= " FROM "; 
 		$sql .= " clip_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 			
 	} // checkPassword

 	
 	
  	
 		 	
 	
 } // topModelClass.php
 
 
 ?>