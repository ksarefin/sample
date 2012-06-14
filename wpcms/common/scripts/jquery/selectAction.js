

var selectAction={
	
		
	main : function()
	{
		
		
		j$("#entry_type").change(function() {

			if (j$("#entry_type").val() == 'text'){
				j$("#maxlength_id").attr('class', 'dspBlock');
				j$("#size_id").attr('class', 'dspBlock');
				j$("#rows_id").attr('class', 'dspNone');
				j$("#cols_id").attr('class', 'dspNone');
				j$("#options_id").attr('class', 'dspNone');
				
			}else if (j$("#entry_type").val() == 'textarea'){
				j$("#rows_id").attr('class', 'dspBlock');
				j$("#cols_id").attr('class', 'dspBlock');
				j$("#maxlength_id").attr('class', 'dspNone');
				j$("#size_id").attr('class', 'dspNone');
				j$("#options_id").attr('class', 'dspNone');
				
			}else if (j$("#entry_type").val() == 'radio' || j$("#entry_type").val() == 'checkbox' || j$("#entry_type").val() == 'select'){
				j$("#options_id").attr('class', 'dspBlock');
				j$("#maxlength_id").attr('class', 'dspNone');
				j$("#size_id").attr('class', 'dspNone');
				j$("#rows_id").attr('class', 'dspNone');
				j$("#cols_id").attr('class', 'dspNone');
			
			}else{
				j$("#options_id").attr('class', 'dspNone');
				j$("#maxlength_id").attr('class', 'dspNone');
				j$("#size_id").attr('class', 'dspNone');
				j$("#rows_id").attr('class', 'dspNone');
				j$("#cols_id").attr('class', 'dspNone');
			}
			

		});
		
		
		if (j$("#entry_type").val() == 'text'){
			j$("#maxlength_id").attr('class', 'dspBlock');
			j$("#size_id").attr('class', 'dspBlock');
			j$("#rows_id").attr('class', 'dspNone');
			j$("#cols_id").attr('class', 'dspNone');
			j$("#options_id").attr('class', 'dspNone');
			
		}else if (j$("#entry_type").val() == 'textarea'){
			j$("#rows_id").attr('class', 'dspBlock');
			j$("#cols_id").attr('class', 'dspBlock');
			j$("#maxlength_id").attr('class', 'dspNone');
			j$("#size_id").attr('class', 'dspNone');
			j$("#options_id").attr('class', 'dspNone');
			
		}else if (j$("#entry_type").val() == 'radio' || j$("#entry_type").val() == 'checkbox' || j$("#entry_type").val() == 'select'){
			j$("#options_id").attr('class', 'dspBlock');
			j$("#maxlength_id").attr('class', 'dspNone');
			j$("#size_id").attr('class', 'dspNone');
			j$("#rows_id").attr('class', 'dspNone');
			j$("#cols_id").attr('class', 'dspNone');
		
		}else{
			j$("#options_id").attr('class', 'dspNone');
			j$("#maxlength_id").attr('class', 'dspNone');
			j$("#size_id").attr('class', 'dspNone');
			j$("#rows_id").attr('class', 'dspNone');
			j$("#cols_id").attr('class', 'dspNone');
		}
		
		
		
		if (j$("div#entry_type").text() == 'text'){
			j$("#maxlength_id").attr('class', 'dspBlock');
			j$("#size_id").attr('class', 'dspBlock');
			j$("#rows_id").attr('class', 'dspNone');
			j$("#cols_id").attr('class', 'dspNone');
			j$("#options_id").attr('class', 'dspNone');
			
		}else if (j$("div#entry_type").text() == 'textarea'){
			j$("#rows_id").attr('class', 'dspBlock');
			j$("#cols_id").attr('class', 'dspBlock');
			j$("#maxlength_id").attr('class', 'dspNone');
			j$("#size_id").attr('class', 'dspNone');
			j$("#options_id").attr('class', 'dspNone');
			
		}else if (j$("div#entry_type").text() == 'radio' || j$("div#entry_type").text() == 'checkbox' || j$("div#entry_type").text() == 'select'){
			j$("#options_id").attr('class', 'dspBlock');
			j$("#maxlength_id").attr('class', 'dspNone');
			j$("#size_id").attr('class', 'dspNone');
			j$("#rows_id").attr('class', 'dspNone');
			j$("#cols_id").attr('class', 'dspNone');
			
		}else{
			j$("#options_id").attr('class', 'dspNone');
			j$("#maxlength_id").attr('class', 'dspNone');
			j$("#size_id").attr('class', 'dspNone');
			j$("#rows_id").attr('class', 'dspNone');
			j$("#cols_id").attr('class', 'dspNone');
		}
		
		
		
	
    },
		
    
    
   addEvent : function()
   {
        if (typeof j$ != 'undefined') {
            j$(document).ready(selectAction.main);
        } else if (typeof $ != 'undefined') {
            $(document).ready(selectAction.main);
        } else {
            window.alert('selectAction:initialize failed.');
        }
    }
    
    
};


selectAction.addEvent();
	
	