<!doctype html>
<head>
<meta charset="utf-8" />
<title>VoiceLink ClipBoard</title>
<meta name="description" content="VoiceLink ClipBoard" />
<link rel="stylesheet" href="/static/css/format.css" />
<link rel="stylesheet" href="/static/css/public.css" />
<script type="text/javascript" src="/static/scripts/jsloader.js"></script>
<script type="text/javascript" src="/static/scripts/jquery.js"></script>
<script type="text/javascript" src="/cms/common/scripts/AC_RunActiveContent.js"></script>
<script type="text/javascript" src="/cms/common/scripts/html5media.min.js"></script>

<script type="text/javascript">

$(function() {

	updateView();

    function updateView() {

    	var request_url;
        var request_from = $("#request_from").attr('r_from');

        if (request_from == 'voice_link'){
        	$("#request_from").attr('r_from', 'clip_board');
        	request_url = '/clipShow/ajaxUpdate/user_id/{$user_id|make_id}/clip_id/{$publish.clip_id|make_id}/r_from/voice_link';
        }else{
        	request_url = '/clipShow/ajaxUpdate/user_id/{$user_id|make_id}/clip_id/{$publish.clip_id|make_id}';
        }
        
		//trace('request_url='+request_url);

		$.ajax({
		   url: request_url,
		   success: function(get_response){
			  
			   var get_split = get_response.split(';:;');
			   //trace('get_split='+get_split);
			   
			   if (get_split[0] !='' && get_split[1] != ''){

				   var view_split = get_split[1].split(':ovo:');
				   //alert(view_split[1]);
				   
				   var view_html;

				   if (view_split[0] == 'image'){
					   view_html = '<div id="stageImg"><img src="/clipShow/thumbnail/user_id/{$user_id|make_id}/clip_id/{$clip_id|make_id}/image_name/'+view_split[1]+'/width/{$width}/height/{$height}" /></div>';
				   }

				   if (view_split[0] == 'movie'){
					   view_html = view_split[1];
				   }

				   if (view_split[0] == 'ustream'){
					   view_html = '<div id="stageUstrame"><iframe src="https://www.ustream.tv/embed/'+view_split[1]+'?autoplay=true" width="{$width}" height="{$height}" scrolling="no" frameborder="0" style="border: 0px none transparent;"></iframe></div>';
				   }

				   if (view_split[0] == 'youtube'){
				   		//view_html = '<div id="stageYoutube"><embed src="http://www.youtube.com/v/'+view_split[1]+'&autoplay=1&controls=0&rel=0&start='+get_split[5]+'" type="application/x-shockwave-flash" frameborder="0" allowfullscreen　wmode="transparent" width="{$width}" height="{$height}"></embed></div>';
				   		view_html = '<div id="stageYoutube"><iframe src="https://www.youtube.com/embed/'+view_split[1]+'?autoplay=1&rel=0&fs=0&start='+get_split[5]+'" type="application/x-shockwave-flash" frameborder="0" wmode="transparent" width="{$width}" height="{$height}"></iframe></div>';
				   }

				   if (view_split[0] == 'image_txt'){
				   		view_html = '<div class="stageScrollBox{$width}"><div id="stageText{$width}">'+view_split[1]+'</div></div>';
				   }

				  $("#update_image").html(view_html);
			   		
			   }else if (get_split == ''){
				   $("#update_image").html('');
			   }

			   if (get_split[3]){
				   $("#title").html( get_split[3] + 'title area<span>Author: <span>{$user_info.author}</span></span>');
			   }

			   if (get_split[4]){

				   var sound_html = get_split[4];
				   
				   $("#sound_play").html(sound_html);

			   }
			   
		   }
		});
		        
        setTimeout(updateView,3000);
    }

});

function trace(_msg) {
	if (!('console' in window))
		return;
	if (console)
		console.log(_msg);
}

</script>

</head>
<body>
			
<div id="request_from" r_from="voice_link"></div>				
<div id="document">
<div id="contents">

<div id="main">
<div id="mainInner">
<div id="update_image"></div>
<div  id="sound_play"></div>
</div>
</div><!-- /#main -->

<!--<div id="title"></div>-->

</div><!-- /#contents -->
</div><!-- /#document -->

</body>
</html>