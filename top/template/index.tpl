<!doctype html>
<head>
<meta charset="utf-8" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="description" content="" />
<title>Clipboard</title>
<link rel="stylesheet" href="/static/css/format.css" />
<link rel="stylesheet" href="/static/css/public.css" />
<script type="text/javascript" src="/static/scripts/jsloader.js"></script>
<script type="text/javascript" src="/static/scripts/jquery.js"></script>
<script type="text/javascript" src="/cms/common/scripts/AC_RunActiveContent.js"></script>
<script type="text/javascript" src="http://api.html5media.info/1.1.4/html5media.min.js"></script>


<script type="text/javascript">

$(function() {

	updateView();

    function updateView() {

        var request_url = '/top/ajaxUpdate/user_id/{$user_id|make_id}/clip_id/{$publish.clip_id|make_id}';
		
		$.ajax({
		   url: request_url,
		   success: function(get_response){
			   
			   var get_split = get_response.split(';:;');
			   //alert(get_split);
			   
			   if (get_split[0] !='' && get_split[1] != ''){

				   var view_split = get_split[1].split(':ovo:');
				  //alert(view_split[1]);
				   
				   var view_html;

				   if (view_split[0] == 'image'){
					   view_html = '<div id="stageImg"><img src="/cms/upload/clip/uid_{$user_id}/cid_'+get_split[0]+'/'+view_split[1]+'" /></div>';
				   }

				   if (view_split[0] == 'movie'){
					   view_html = view_split[1];
				   }

				   if (view_split[0] == 'youtube'){
				   		view_html = '<div id="stageYoutube"><embed src="http://www.youtube.com/v/'+view_split[1]+'&autoplay=1&rel=0" type="application/x-shockwave-flash" wmode="transparent" width="854" height="480"></embed></div>';
				   }

				   if (view_split[0] == 'image_txt'){
				   		view_html = '<div class="stageScrollBox"><div id="stageText">'+view_split[1]+'</div></div>';
				   }

				  $("#update_image").html(view_html);
			   		
			   }else if (get_split == ''){
				   $("#update_image").html('');
			   }

			   if (get_split[2]){
				   /*var prev_room = $("#voice_link").attr('room_id');
				   if (get_split[2] != prev_room){
					   	if ($("#linkSwitch").attr('class') == 'statusOn'){
						   	$("#voice_link").attr('room_id', get_split[2]);
							$("#voice_link").html('<iframe src="https://www.vlvlv.jp/#!/room'+get_split[2]+'" width="960" height="580"></iframe>');
						}
				   }*/
			   }

			   if (get_split[3]){
				   $("#title").html( get_split[3] + '<span>Author: <span>{$user_info.author}</span></span>');
			   }

			   if (get_split[4]){

				   //var sound_split = get_split[4].split('::');
				   //var sound_html = '<audio controls="controls" height="1px" width="1px" autoplay="autoplay"> <source src="'+sound_split[0]+'" type="audio/mpeg" /><source src="'+sound_split[1]+'" type="audio/ogg" /><embed src="'+sound_split[0]+'" width="1" height="1" autostart="true"></embed></audio>';
				   var sound_html = get_split[4];
				   //alert(sound_html);
				   $("#sound_play").html(sound_html);

				   /*audiojs.events.ready(function() {
					   audiojs.createAll();
				   });*/

			   }   

			   
		   }
		});
		        
        setTimeout(updateView,3000);
    }

});

jQuery(function() {
	$("#linkSwitch").click(function(){

		//alert($(this).attr('class'));

		if ($(this).attr('class') == 'statusOff'){
			
			$(this).removeClass('statusOff');
			$(this).addClass('statusOn');

			//$("#voice_link").html('<iframe src="https://www.vlvlv.jp/{if $room_no}#!/room{$room_no}{/if}" width="960" height="580" frameborder="0"></iframe>');
			
		}else if ($(this).attr('class') == 'statusOn'){
			
			$(this).removeClass('statusOn');
			$(this).addClass('statusOff');

			//$("#voice_link").html('');
		}
	});
});

</script>

</head>
<body>


<div id="gnav" class="clearfix">
<h1><img src="/static/images/head_logo.gif" width="145" height="32" alt="Clipboard" /></h1>
<!-- <p class="btn"><a class="statusOff" id="linkSwitch"><span>Status</span></a></p> -->
<ul class="ttl">
<li class="t01"><div id="title"></div></li>
</ul>
</div><!-- /#gnav -->

<div id="document">
<div id="contents">

<div id="main">
<div id="mainInner">
<div id="update_image"></div>

<div  id="sound_play"></div>

</div>
<div id="voice_link"></div>

</div><!-- /#main -->



<div id="footer">
<div class="copyright">Powerd by <a href="http://www.kiwami.com/" target="_blank">Kiwami</a></div>
</div>

</div><!-- /#contents -->
</div><!-- /#document -->

</body>
</html>