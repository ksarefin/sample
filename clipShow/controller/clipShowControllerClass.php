<?php
/**
 * clipShowControllerClass.php
 * 
 * @created on 2012/04/19
 * @package    VoiceLink
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/04/19 - 11:31:50 fabien 
 * 
 *File content
     clipShowControllerClass.php
 *     
 */
 
 
 class clipShowControllerClass extends Configuration{
 	
 	/**
 	 * voice link class insatance
 	 */
 	protected $voice_link;
 	
 	/**
 	 * data base model instance
 	 */
 	protected $db_model;
 	
 	/**
 	 * room no instance
 	 */
 	protected $room_no;
 	
 	/**
 	 * frame width instance
 	 */
 	protected $width;
 	
 	/**
 	 * frame height instance
 	 */
 	protected $height; 	
 	
 	/**
 	 * user id instance
 	 */
 	protected $user_id;
 	
 	/**
 	 * clip id instance
 	 */
 	protected $clip_id;
 
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		/**
 		 * voice link class object
 		 */
 		$this->voice_link = new VoiceLink();
 		
 		/**
 		 * data base model object
 		 */
 		$this->db_model = new clipShowModelClass();
 		
 		/**
 		 * get url room no
 		 */
 		$this->room_no = $this->getUrlParam('room_no');
 		
 		/**
 		 * save room no in session and assign to view
 		 */
 		if ($this->room_no)
 			$this->setAttribute('web_room_no', $this->room_no);
 		else
 			$this->removeAttribute('web_room_no');
 			
 		/**
 		 * get frame width and save in session
 		 */
 		$this->width = $this->getUrlParam('width');
 		if ($this->width)
 			$this->setAttribute('width', $this->width);
 		
 		/**
 		 * width assign to view
 		 */
 		$this->viewAssign('width', $this->getAttribute('width'));
 		
 		/**
 		 * get frame height and save in session
 		 */
 		$this->height = $this->getUrlParam('height');
 		if ($this->height)
 			$this->setAttribute('height', $this->height);
 			
 		/**
 		 * height assign to view
 		 */
 		$this->viewAssign('height', $this->getAttribute('height'));
 		
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
 		
 		
 		
 	} // indexAction
 	
 	
 	
 	/**
  	 * clipBoard action controller
  	 */
  	public function clipBoardAction(){
  		
  		/**
  		 * get room number
  		 */
  		$room_no = $this->getAttribute('web_room_no');

  		/**
  		 * view assign room number
  		 */
  		$this->viewAssign('room_no', $room_no);
  		
  		/**
  		 * get publish information
  		 */
  		if (is_numeric($room_no)){
  			$publish_info = $this->db_model->getPublishInfo($room_no);
  		}else {
  			$this->removeAttribute('last_publish_time');
  			$this->removeAttribute('last_frame_width');
  		}
  		
  		if (!empty($publish_info)){	
	  		/**
	  		 * get user id and assign to view
	  		 */
	  		$user_id = $publish_info['user_id'];
	  		$this->setAttribute('web_user_id', $this->user_id);
	  		$this->viewAssign('user_id', $user_id);
	  		
	  		/**
	  		 * get clip id and assign to view
	  		 */
	  		$clip_id = $publish_info['clip_id'];
	  		$this->setAttribute('web_clip_id', $this->clip_id);
	  		$this->viewAssign('clip_id', $clip_id);
	  		
	  		/**
	  		 * get user information
	  		 */
	  		if (!empty($user_id)){
	  			$user_info = $this->db_model->getUserInfo($user_id);
	  			$this->viewAssign('user_info', $user_info);  		
	  		}
	  		
	  		
	  		/**
	  		 * view assign publish information
	  		 */
	  		$this->viewAssign('publish', $publish_info);
  		}
		
		$this->setDisplay('clip_show', false);
		  		
  	} // clipBoardAction
  	
  	
  	
  	/**
  	 * publish action controller
  	 */
  	public function publishContentAction(){
  		
  		/**
  		 * get room number
  		 */
  		$room_no = $this->getAttribute('web_room_no');
  		
  		/**
  		 * view assign room number
  		 */
  		$this->viewAssign('room_no', $room_no);
  		
  		/**
  		 * get publish information
  		 */
  		if (is_numeric($room_no)){
  			$publish_info = $this->db_model->getPublishInfo($room_no);
  		}
  		
  		if (!empty($publish_info)){
  			
  			/**
	  		 * get user id and assign to view
	  		 */
	  		$user_id = $publish_info['user_id'];
	  		$this->setAttribute('web_user_id', $this->user_id);
	  		$this->viewAssign('user_id', $user_id);
	  		
	  		/**
	  		 * get clip id and assign to view
	  		 */
	  		$clip_id = $publish_info['clip_id'];
	  		$this->setAttribute('web_clip_id', $this->clip_id);
	  		$this->viewAssign('clip_id', $clip_id);
	  		
	  		echo 'display';
  		
  		}else{ 
  			
  			$this->removeAttribute('last_publish_time');
  			$this->removeAttribute('last_frame_width');
  			
  			echo 'noDisplay';
  			
  		}
  		
  		exit;
  		
  	} // publishContent
  	
  	
  	
  	/**
  	 * ajax update action controller
  	 */
  	public function ajaxUpdateAction(){
  		
  		/**
  		 * get request form
  		 */
  		$r_from = $this->getUrlParam('r_from');
  		
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
  		 * get frame width
  		 */
  		$width = $this->getAttribute('width');
  		
  		/**
  		 * get frame height
  		 */
  		$height = $this->getAttribute('height');
  		
  		
  		/**
  		 * get user publish information
  		 */
  		if (!empty($user_id) && !empty($clip_id))
  			$publish_info = $this->db_model->getUpdatePublishInfo($user_id, $clip_id);
  		
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
	  				
	  				$sound = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="1" height="1" id="player">
								<PARAM NAME=movie VALUE="/cms/mps/audioplay.swf?file='.$mp3_sound.'&auto=yes&sendstop=no&repeat=1&buttondir=/cms/mps/buttons/negative_small&bgcolor=0xffffff&mode=playstop">
								<PARAM NAME=quality VALUE=high>
								<PARAM NAME=wmode VALUE="transparent">
								<PARAM NAME="allowScriptAccess" value="always" />
								<embed wmode="transparent" src="/cms/mps/audioplay.swf?file='.$mp3_sound.'&auto=yes&sendstop=no&repeat=1&buttondir=/cms/mps/buttons/negative_small&bgcolor=0xffffff&mode=playstop" quality=high width="1" height="1" name="player" allowScriptAccess="always"
									align="" TYPE="application/x-shockwave-flash"
									pluginspage="https://www.macromedia.com/go/getflashplayer">
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
  			
  			$get_last_publish_time 	= $this->getAttribute('last_publish_time');
  			$get_last_frame_width 	= $this->getAttribute('last_frame_width');
  			//print $get_last_publish_time.'/--/'.$get_last_frame_width."\n";
  			
  			if ($get_last_publish_time != $publish_info['publish_date'] || $get_last_frame_width != $width || $r_from=='voice_link'){
  				
	  			if ($clip_image_info['type'] == 'image'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['image'];
	  			}elseif ($clip_image_info['type'] == 'movie'){
	  				$flsh_html = 
	  					'<div id="stageMovie">
							<object width='.$width.' height='.($height+25).' id=\'flvPlayer\'>
							  	<param name=\'allowFullScreen\' value=\'true\'>
							   	<param name="allowScriptAccess" value="always"> 
							  	<param name=\'movie\' value=\'/cms/common/images/OSplayer.swf?movie=/cms/upload/clip/uid_'.$user_id.'/cid_'.$clip_id.'/'.$clip_image_info['movie'].'&btncolor=0x333333&accentcolor=0x31b8e9&txtcolor=0xdddddd&volume=30&autoload=on&autoplay=on&vTitle=Super Mario Brothers Lego Edition&showTitle=yes\'>
							  	<embed src=\'/cms/common/images/OSplayer.swf?movie=/cms/upload/clip/uid_'.$user_id.'/cid_'.$clip_id.'/'.$clip_image_info['movie'].'&btncolor=0x333333&accentcolor=0x31b8e9&txtcolor=0xdddddd&volume=30&autoload=on&autoplay=on&vTitle=Super Mario Brothers Lego Edition&showTitle=yes\' width='.$width.' height='.($height+25).' allowFullScreen=\'true\' type=\'application/x-shockwave-flash\' allowScriptAccess=\'always\'>
							</object>
						</div>';
	  				
	  				$view_info = $clip_image_info['type'].':ovo:'.$flsh_html;
	  				
	  			}elseif ($clip_image_info['type'] == 'ustream'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['ustream'];
	  			}elseif ($clip_image_info['type'] == 'youtube'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['youtube'];
	  			}elseif ($clip_image_info['type'] == 'image_txt'){
	  				$view_info = $clip_image_info['type'].':ovo:'.$clip_image_info['image_txt'];
	  			}
	  			
	  			//print $room_no."\n";
	  			
	  			$this->setAttribute('view_info', $view_info);
	  			$this->setAttribute('last_publish_time', $publish_info['publish_date']);
	  			$this->setAttribute('last_frame_width', $width);
  				
  			}else {
  				$view_info = '';
  			}
  			
  			if (!empty($publish_info['youtube_time']))
  				$publish_time_length = (time()-$publish_info['publish_date'])+$publish_info['youtube_time'];
  			else 
  				$publish_time_length = (time()-$publish_info['publish_date'])+$clip_image_info['youtube_time'];
  				
  			$response = $publish_info['clip_id'].';:;'.$view_info.';:;'.$clip_info['room_no'].';:;'.$clip_info['title'].';:;'.$sound.';:;'.$publish_time_length;
  			echo $response;
  			
  		}
  		
  	} // ajaxUpdateAction
  	
  	
  	
  	/**
 	 * thumbnail action controller
 	 */
 	public function thumbnailAction(){
 		
 		/**
 		 * get user id
 		 */
 		$user_id = $this->getAttribute('web_user_id');
 		
 		/**
 		 * get clip id
 		 */
 		$clip_id = $this->getAttribute('web_clip_id');
 		
 		/**
 		 * get image name
 		 */
 		$image_name = $this->getUrlParam('image_name');
 		
 		/**
 		 * get frame width
 		 */
 		$frame_width = $this->getUrlParam('width');
 		
 		/**
 		 * get frame heigth
 		 */
 		$frame_heigth = $this->getUrlParam('height');
 		
 		/**
 		 * uploded image path
 		 */
 		$clip_image = UPLOAD.'/clip/uid_'.$user_id.'/cid_'.$clip_id.'/'.$image_name;
 		$types = array('','gif','jpeg','png');
 		
 		/**
		 * Get new dimensions
		 */ 
		list($width, $height, $type) = getimagesize($clip_image);
		$type = $types[$type];
		
		/**
		 * image resizing
		 */
		//$thumb_img = cropped_thumbnail($clip_image, $frame_width, $frame_heigth, $type);
		
		if ($frame_width == '640' || $frame_width =='427'){
			
			$thumb_img = cb_image($clip_image, $frame_width, $frame_heigth, $type);
			
			/**
			 * image display
			 */
	 		header('Content-type: image/'.$type);
			if($type=='jpeg') imagejpeg($thumb_img,null,100);
			if($type=='png') imagepng($thumb_img);
			if($type=='gif') imagegif($thumb_img);
			
		}else {
			
			
			$ext = substr($image_name, strrpos($image_name, '.') + 1);
	 		$ext = str_replace('jpg', 'jpeg', trim($ext));
	 		
		    header("Cache-Control: public");
		    header("Pragma: public");
			header("Content-Type: image/".$ext);
			readfile( $clip_image );
			
		}
		
 		
 	} // thumbnailAction
  	 	
  	
  
  	
 
 } // clipShowControllerClass
 
 
 ?>