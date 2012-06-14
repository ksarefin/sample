<div id="pageTtl">
<h2>フォーム編集 &gt; {$page_title}{if !empty($pd.id)}
編集
{else}
追加
{/if}</h2>
</div>

{literal}
<script>
//<!CDATA[

  j$(document).ready(function(){

	  
    var counter;
    
    if ({/literal}{$pd.options|count}{literal}){
    	counter = {/literal}{$pd.options|count}{literal};
    	counter = counter+1;   
    }else{
    	counter = 5;
    }

    /* 
    j$("#addButton").click(function () {
 
	if(counter>10){
           // return false;
	}   
 //alert(counter);
	var newTextBoxDiv = j$(document.createElement('div'))
		 .attr("class", 'option'+counter+'_div')
	     .attr("id", 'option'+counter+'_div_id');
 
	newTextBoxDiv.after().html('<div class="form_l"></div><div class="form_r">' +
	      '<input type="text" name="pd[options][]" size="60" class="text" id="option'+counter+'_id" maxlength="50" /></div>');
 
	
	newTextBoxDiv.appendTo("#servey_div");
 
 
	counter++;
     });
 
     j$("#removeButton").click(function () {

         //alert(counter);

 		if(counter==3){
          //alert("No more textbox to remove");
          return false;
       }   
        counter--;
 
        j$("#option" + counter+'_div_id').remove();
 
     });*/

    j$("#addButton").click(function () {

	    var name = j$("#addButton").attr("name");

	    //alert(name);
	    
 		var newTextBoxDiv = j$(document.createElement('div'))
			 .attr("class", 'option'+counter+'_'+name)
		     .attr("id", 'option'+counter+'_'+name+'_id');
	 
		newTextBoxDiv.after().html('<input type="text" name="pd[options][]" size="60" class="wFull" id="option'+counter+'_id" maxlength="50" /></div>');
	 
		newTextBoxDiv.appendTo("#options_"+name);
	 
	 
		counter++;
     });
 


	    j$("#removeButton").click(function () {

	    	var name = j$("#addButton").attr("name");
	    	
	    	if(counter==3){
          return false;
     	}   
 
		counter--;
	 
	     j$("#option" + counter+'_'+name+'_id').remove();
	 
   });
	    
 
     
  });

          
          
          
//]]>
</script>
{/literal}



<div class="formBox01">

{if !empty($err)}
<ul class="errorList">
{foreach from=$err item=val}
<li>{$val}</li>
{/foreach}
</ul>
{/if}

<form name="frm" method="post" action="{$self}/save" enctype="multipart/form-data">
<input type="hidden" name='pd[id]' value="{$pd.id}" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$form_html}
</table>

<ul class="btnList">
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る" onClick="window.location='{$back}';" /></li>
<li><input type="submit" name="login" id="login" class="btnGreenB" value="保存" /></li>
</ul>
							
</form>

</div><!-- /formBox01 -->
