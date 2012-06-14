

function optionAdd(add_position){
	//alert(add_position);
	var get_split = add_position.split('_');
	var position = parseInt(get_split[2].replace(':', ''));
	var add_button_id = get_split[0]+'_'+get_split[1];
	var options_count = get_split[1];
	var next_position = (position+1);

	//alert(add_button_id);

	var name = j$("#"+add_button_id).attr("name");
	//alert(name);


   var newTextBoxDiv = j$(document.createElement('div'))
	 .attr("id", 'option'+position+'_'+name+'_id')
	 .attr("class", 'option'+position+'_'+name);


    newTextBoxDiv.after().html('' +position+
     '<input type="text" name="pd['+name+'_options][]" size="60" class="text" id="option'+position+'_id" maxlength="50" />'
     +'');
    //alert(newTextBoxDiv);

    newTextBoxDiv.appendTo("#options_"+name);


    var add_remove_button = '<input name="'+name+'" value="　＋　" id="'+add_button_id+'" type="button" onClick="optionAdd(\''+add_button_id+'_'+next_position+':\');">'
    +'<input name="'+name+'" value="　－　" id="removeButton_'+get_split[1]+'" type="button" onClick="optionRemove(\'removeButton_'+get_split[1]+'_'+position+':\')"></div></div>';

    j$("#add_remove_"+name).html(add_remove_button);

}


function optionRemove(remove_position){

	var get_split = remove_position.split('_');
	var position = parseInt(get_split[2].replace(':', ''));
	var remove_div_id = get_split[0]+'_'+get_split[1];
	var options_count = get_split[1];
	var previous_position = (position-1);

	if(position==2){
	      return false;
	}

	var name = j$("#"+remove_div_id).attr("name");

	j$("#option"+position+'_'+name+'_id').remove();


	var add_remove_button = '<input name="'+name+'" value="　＋　" id="addButton_'+get_split[1]+'" type="button" onClick="optionAdd(\'addButton_'+get_split[1]+'_'+position+':\');">'
    +'<input name="'+name+'" value="　－　" id="'+remove_div_id+'" type="button" onClick="optionRemove(\''+remove_div_id+'_'+previous_position+':\')"></div></div>';

	j$("#add_remove_"+name).html(add_remove_button);

}


function removeField(field_id){

	var div_id = field_id.replace(':', '');
	j$("#"+div_id).remove();
}


function getOtherDivId(other_div_id){
	
	if (j$("input:radio[name='pd["+other_div_id+"]']:checked").val() == 1){
		
		j$("#"+other_div_id+"_size").attr('class', 'dspBlock');
		j$("#"+other_div_id+"_maxlength").attr('class', 'dspBlock');
		j$("#"+other_div_id+"_check").attr('class', 'dspBlock');
	
	}else if (j$("input:radio[name='pd["+other_div_id+"]']:checked").val() == 2){
		
		j$("#"+other_div_id+"_size").attr('class', 'dspNone');
		j$("#"+other_div_id+"_maxlength").attr('class', 'dspNone');
		j$("#"+other_div_id+"_check").attr('class', 'dspNone');
	}
	  
} // function getOtherDivId(other_div_id){

