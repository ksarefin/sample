<?php
/**
 * topControllerClass.php
 * 
 * @created on 2012/03/22
 * @package    VoiceLink
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2012/03/22-10:20:53 fabien 
 * 
 *File content
     topControllerClass.php
 *     
 */
  
  
  class topControllerClass extends Configuration {

  	/**
 	 * voice link class insatance
 	 */
 	protected $voice_link;
 	
 	/**
 	 * data base model instance
 	 */
 	protected $db_model;
 	
 	/**
 	 * user id instance
 	 */
 	protected $user_id;
 	
 	/**
 	 * clip id instance
 	 */
 	protected $clip_id;
 	
 	
 	
 	public function commonAction(){
 		
 		/**
 		 * voice link class object
 		 */
 		$this->voice_link = new VoiceLink();
 		
 		/**
 		 * data base model object
 		 */
 		$this->db_model = new topModelClass();
 		
 		/**
 		 * get user url id
 		 */
 		$url_user_id = $this->getUrlParam('user_id');
 		$this->user_id = get_id($url_user_id);
 		
 		/**
 		 * save user id in session and assign to view
 		 */
 		if ($this->user_id)
 			$this->setAttribute('web_user_id', $this->user_id);
 		else
 			$this->removeAttribute('web_user_id'); 

 			
 		$this->viewAssign('user_id', $this->getAttribute('web_user_id'));
 		
 		/**
 		 * get clip url id
 		 */
 		$url_clip_id = $this->getUrlParam('clip_id');
 		$this->clip_id = get_id($url_clip_id);
 		
 		/**
 		 * save clip id in session and assign to view
 		 */
 		if ($this->clip_id)
 			$this->setAttribute('web_clip_id', $this->clip_id);
 		else
 			$this->removeAttribute('web_clip_id'); 
 			
 		$this->viewAssign('clip_id', $this->getAttribute('web_clip_id'));
 		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
  		 * get user id
  		 */
  		$user_id = $this->getAttribute('web_user_id');
  		
  		/**
  		 * if user id empty goes to admin 
  		 */
  		if (empty($user_id)){
  			/*$url_array = array( 'admin');
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);*/
  			
  			$this->setDisplay('top', false);
  			exit;
  			
  		} // if (empty($user_id)){
  		
  		/**
  		 * get user publish information
  		 */
  		$publish_info = $this->db_model->getPublishInfo($user_id);
  		
  		/**
  		 * if any publish data has
  		 */
  		if (!empty($publish_info)){
  			
  			/**
	  		 * check password
	  		 */
	  		$check = $this->db_model->checkPassword($user_id, $publish_info['clip_id']);
	  		
	  		if (empty($check['password'])){
	  			
	  			/**
	  			 * set login information
	  			 */
	  			$this->login_class->setLogin($this->access_name, array('password'=>'guest'));
	  			
	  			/**
	  			 * redirect to clip board
	  			 */
	  			$url_array = array( 
	  				$this->module_name, 'clipBoard',
	  				'user_id', make_id($user_id),
	  				'clip_id', make_id($publish_info['clip_id']),
	  			);
	  			$url = $this->makeUrl($url_array);
	  			$this->redirect($url);
	  			
	  		}elseif (!empty($check['password'])) {
	  			
		  		/**
	  			 * get login info
	  			 */
	  			$login_check = $_SESSION[$this->access_name] ? $_SESSION[$this->access_name] : $_COOKIE[$this->access_name];
			  	if (is_string($login_check)){
			  		if (preg_match('/::/', $login_check)){
			  			$expl = explode('::', $login_check);
			  			$login_check['password'] = $expl[0];
			  		}
		  		}
	  			
	  			if ( empty($login_check) || ($login_check['password'] != $check['password'])){
	  				
	  				/**
		  			 * redirect to clip board
		  			 */
		  			$url_array = array(
		  				$this->module_name, 'login',
		  				'user_id', make_id($user_id),
		  				'clip_id', make_id($publish_info['clip_id']),
		  			);
		  			$url = $this->makeUrl($url_array);
		  			$this->redirect($url);
		  			
	  			}else{
	  				
	  				/**
		  			 * redirect to clip board
		  			 */
		  			$url_array = array(
		  				$this->module_name, 'clipBoard',
		  				'user_id', make_id($user_id),
		  				'clip_id', make_id($publish_info['clip_id']),
		  			);
		  			$url = $this->makeUrl($url_array);
		  			$this->redirect($url);
	  				
	  			} // if ( empty($login_check) || ($login_check['password'] != $check['password'])){
	  			
	  		} //if (empty($check['password'])){
  			
  			
  		}else {
  			
  			/*$url_array = array( 'admin');
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);*/
  			$this->setDisplay('index', false);
  			exit;
  		} // // if (!empty($publish_info)){
  		
 		
 	} // indexAction
 	
 	
 	
 	
  	/**
  	 * clipBoard action controller
  	 */
  	public function clipBoardAction(){
  		
  		/**
  		 * get user id
  		 */
  		$user_id = $this->getAttribute('web_user_id');
  		
  		/**
  		 * get clip id
  		 */
  		$clip_id = $this->getAttribute('web_clip_id');
  		
  		/**
  		 * get user information
  		 */
  		$user_info = $this->db_model->getUserInfo($user_id);
  		$this->viewAssign('user_info', $user_info);  		
  		
  		/**
  		 * if user id empty goes to admin 
  		 */
  		if (empty($user_id) || empty($clip_id)){
  			
  			/*$url_array = array( 'admin');
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);*/
  			$this->setDisplay('index', false);
  			exit;
  			
  		} // if (empty($user_id) || empty($clip_id)){
  		
  		/**
	  	 * get login info
	  	 */
	  	$login_check = $_SESSION[$this->access_name] ? $_SESSION[$this->access_name] : $_COOKIE[$this->access_name];
	  	if (is_string($login_check)){
	  		if (preg_match('/::/', $login_check)){
	  			$expl = explode('::', $login_check);
	  			$login_check['password'] = $expl[0];
	  		}
  		}
	  	
	  	/**
	  	 * if empty login information redirect to login page
	  	 */		
	  	if ( empty($login_check)){
	  				
	  		/**
		  	 * redirect to clip board
		  	 */
		  	$url_array = array(
		  		$this->module_name, 'login',
		  		'user_id', make_id($user_id),
		  		'clip_id', make_id($publish_info['clip_id']),
		  	);
		  	$url = $this->makeUrl($url_array);
		  	$this->redirect($url);
		
	  	} // if ( empty($login_check)){
  		
  		
  		
  		/**
		 * get room noumber
		 */
		if (!empty($clip_id) && is_numeric($clip_id)){
			$room_number = $this->db_model->getRoomNumber($user_id, $clip_id);
			$this->viewAssign('room_no', $room_number);
		}
		
		
		/**
  		 * get user publish information
  		 */
  		$publish_info = $this->db_model->getPublishInfo($user_id);
  		$this->viewAssign('publish', $publish_info);
		
		
		$this->setDisplay('index', false);
		  		
  	} // clipBoardAction
  	
  	
  	
  	
  	/**
  	 * ajax update action controller
  	 */
  	public function ajaxUpdateAction(){
  		
  		/**
  		 * get user id
  		 */
  		$user_id = $this->getAttribute('web_user_id');
  		
  		if (empty($user_id)){
  			echo '';
  			exit;
  		}
  		
  		/**
  		 * get clip id
  		 */
  		$url_clip_id = $this->getUrlParam('clip_id');
  		$clip_id = get_id($url_clip_id); 
  		
  		if (empty($clip_id)){
  			echo '';
  			exit;
  		}
  		
  		/**
  		 * get user publish information
  		 */
  		$publish_info = $this->db_model->getPublishInfo($user_id);
  		
  		/**
  		 * generate image html
  		 */
  		if (!empty($publish_info)){
  			
  			$clip_info = $this->db_model->getClipInfo($user_id, $publish_info['clip_id']);
  			
  			$audio_path = '/cms/upload/sound';
  			
  			if (!empty($publish_info['sound_id'])){
  				
  				$prev_sound_publish_time = $this->getAttribute('sound_publish_time');
  				
  				if ($prev_sound_publish_time != $publish_info['sound_publish_date']){
	  				
  					$mp3 = $clip_info['se'.$publish_info['sound_id'].'_mp3'];
	  				$mp3_file = UPLOAD.'/sound/uid_'.$user_id.'/'.$mp3;
	  				
	  				if (file_exists($mp3_file))
	  					$mp3_sound = $audio_path.'/uid_'.$user_id.'/'.$mp3;
	  				else 
	  					$mp3_sound = $audio_path.'/'.$mp3;
	  					
	  				$ogg = $clip_info['se'.$publish_info['sound_id'].'_ogg'];
	  				$ogg_file = UPLOAD.'/sound/uid_'.$user_id.'/'.$ogg;
	  				
	  				if (file_exists($ogg_file))
	  					$ogg_sound = $audio_path.'/uid_'.$user_id.'/'.$ogg;
	  				else 
	  					$ogg_sound = $audio_path.'/'.$ogg;	  				
	  				
	  				$sound = $mp3_sound.'::'.$ogg_sound;
	  				
	  				$sound = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="1" height="1" id="player">
								<PARAM NAME=movie VALUE="/cms/mps/audioplay.swf?file='.$mp3_sound.'&auto=yes&sendstop=no&repeat=1&buttondir=/cms/mps/buttons/negative_small&bgcolor=0xffffff&mode=playstop">
								<PARAM NAME=quality VALUE=high>
								<PARAM NAME=wmode VALUE="transparent">
								<PARAM NAME="allowScriptAccess" value="always" />
								<embed wmode="transparent" src="/cms/mps/audioplay.swf?file='.$mp3_sound.'&auto=yes&sendstop=no&repeat=1&buttondir=/cms/mps/buttons/negative_small&bgcolor=0xffffff&mode=playstop" quality=high width="1" height="1" name="player" allowScriptAccess="always"
									align="" TYPE="application/x-shockwave-flash"
									pluginspage="http://www.macromedia.com/go/getflashplayer">
								</embed>
							</object>
							';
	  				
	  				$this->setAttribute('sound_publish_time', $publish_info['sound_publish_date']);
	  				
  				}else {
  					$sound = '';
  				}
  				
  			} // if (!empty($publish_info['sound_id'])){
  			
  			/**
  			 * get clip image table information
  			 */
  			$clip_image_info = $this->db_model->getClipImageInfo($publish_info['clip_image_id']);
  			
  			$get_last_publish_time = $this->getAttribute('last_publish_time');
  			//print "last:-".$get_last_publish_time."|||now:-".$publish_info['publish_date'];
  			if ($get_last_publish_time != $publish_info['publish_date']){
  				
	  			if ($clip_image_info['type'] == 'image'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['image'];
	  			}elseif ($clip_image_info['type'] == 'movie'){
	  				$flsh_html = 
	  					'<div id="stageMovie">
							<object width=\'854\' height=\'505\' id=\'flvPlayer\'>
							  	<param name=\'allowFullScreen\' value=\'true\'>
							   	<param name="allowScriptAccess" value="always"> 
							  	<param name=\'movie\' value=\'/cms/common/images/OSplayer.swf?movie=/cms/upload/clip/uid_'.$user_id.'/cid_'.$clip_id.'/'.$clip_image_info['movie'].'&btncolor=0x333333&accentcolor=0x31b8e9&txtcolor=0xdddddd&volume=30&autoload=on&autoplay=on&vTitle=Super Mario Brothers Lego Edition&showTitle=yes\'>
							  	<embed src=\'/cms/common/images/OSplayer.swf?movie=/cms/upload/clip/uid_'.$user_id.'/cid_'.$clip_id.'/'.$clip_image_info['movie'].'&btncolor=0x333333&accentcolor=0x31b8e9&txtcolor=0xdddddd&volume=30&autoload=on&autoplay=on&vTitle=Super Mario Brothers Lego Edition&showTitle=yes\' width=\'854\' height=\'505\' allowFullScreen=\'true\' type=\'application/x-shockwave-flash\' allowScriptAccess=\'always\'>
							</object>
						</div>';
	  				
	  				$view_info = $clip_image_info['type'].':ovo:'.$flsh_html;
	  				
	  			}elseif ($clip_image_info['type'] == 'youtube'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['youtube'];
	  			}elseif ($clip_image_info['type'] == 'image_txt'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['image_txt'];
	  			}
	  			
	  			$this->setAttribute('view_info', $view_info);
	  			$this->setAttribute('last_publish_time', $publish_info['publish_date']);
  				
  			}else {
  				$view_info = '';
  			}
  			
  			
  			$response = $publish_info['clip_id'].';:;'.$view_info.';:;'.$clip_info['room_no'].';:;'.$clip_info['title'].';:;'.$sound;
  			echo $response;
  			
  		}
  		
  	} // updateViewAction
  	
  	
  	/**
  	 * login action control
  	 */
  	public function loginAction(){
  		
  		$this->setDisplay('login',false);
  	
  	} //loginAction
  	
  	
  	
  	/**
  	 * login confirm action control
  	 */
  	public function loginConfAction(){
  		
  		/**
  		 * get user id
  		 */
  		$user_id = $this->getAttribute('web_user_id');
  		
  		/**
  		 * get post data
  		 */
  		$post = $this->getPost();
  		
  		if (empty($post['password']))
  			$msg[] = "Password cna not be empty";
  		
  		/**
  		 * get user publish information
  		 */
  		$publish_info = $this->db_model->getPublishInfo($user_id);
  		
  		/**
  		 * check password
  		 */
  		if (!empty($publish_info))
  			$check = $this->db_model->checkPassword($user_id, $publish_info['clip_id'], $post);
  		
  		if (empty($check))
  			$msg[] = "Enter currect password";

  		if ($msg){
  			
  			$this->viewAssign('err',$msg);
  			$this->setDisplay('login', false);
  			
  		}else{
  			
  			/**
  			 * set login information
  			 */
  			$this->login_class->setLogin($this->access_name, $check, $post['memorize']);
  			
  			
	 		/**
	 		 * page redirect to index
	 		 */
  			$url_array = array(
	  			$this->module_name, 'clipBoard',
	  			'user_id', make_id($user_id),
	  			'clip_id', make_id($publish_info['clip_id']),
  			);
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);
  			
  		} // if ($msg){
  		
  	} // loginConfAction
  	
  	
  	
  	
  	
  	
  } // Configuration
 
  
 ?>