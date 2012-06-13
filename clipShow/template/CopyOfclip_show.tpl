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

        var request_url = '/clipShow/ajaxUpdate/user_id/{$user_id|make_id}/clip_id/{$publish.clip_id|make_id}/room_no/{$room_no}';
		//alert(request_url);
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
					   view_html = '<div id="stageImg"><img src="/clipShow/thumbnail/user_id/{$user_id|make_id}/clip_id/{$clip_id|make_id}/image_name/'+view_split[1]+'/width/{$width}/height/{$height}" /></div>';
				   }

				   if (view_split[0] == 'movie'){
					   view_html = view_split[1];
				   }

				   if (view_split[0] == 'youtube'){
				   		//view_html = '<div id="stageYoutube"><embed src="http://www.youtube.com/v/'+view_split[1]+'&autoplay=1&controls=0&rel=0&start='+get_split[5]+'" type="application/x-shockwave-flash" frameborder="0" allowfullscreen　wmode="transparent" width="{$width}" height="{$height}"></embed></div>';
				   		view_html = '<div id="stageYoutube"><iframe src="http://www.youtube.com/embed/'+view_split[1]+'?autoplay=1&controls=0&rel=0&start='+get_split[5]+'" type="application/x-shockwave-flash" frameborder="0" allowfullscreen　wmode="transparent" width="{$width}" height="{$height}"></iframe></div>';
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

</script>

</head>
<body>

							
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