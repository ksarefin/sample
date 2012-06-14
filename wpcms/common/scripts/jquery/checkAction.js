

var checkAction={
	
		
	main : function()
	{
		/*j$("div#other_div").click(function(){
			
			if (j$("input[@name='pd[other]']:checked").val() == 1){
				j$("#other_maxlength_id").attr('class', 'dspBlock');
				j$("#other_size_id").attr('class', 'dspBlock');
				j$("#other_check_id").attr('class', 'dspBlock');
			
			}else if (j$("input[@name='pd[other]']:checked").val() == 2){
				
				j$("#other_maxlength_id").attr('class', 'dspNone');
				j$("#other_size_id").attr('class', 'dspNone');
				j$("#other_check_id").attr('class', 'dspNone');
			}
			
		});
		
		
		if (j$("input[@name='pd[other]']:checked").val() == 1){
			j$("#other_maxlength_id").attr('class', 'dspBlock');
			j$("#other_size_id").attr('class', 'dspBlock');
			j$("#other_check_id").attr('class', 'dspBlock');
		
		}else if (j$("input[@name='pd[other]']:checked").val() == 2){
			
			j$("#other_maxlength_id").attr('class', 'dspNone');
			j$("#other_size_id").attr('class', 'dspNone');
			j$("#other_check_id").attr('class', 'dspNone');
		}
		*/
		
	
    },
    
    
    other : function(){
    	
    	j$(".other_div_class").each(function(){
    		
    		//alert(this.id);
    		other_div_id = this.id;
    		
    		if (j$("input:radio[name='pd["+other_div_id+"]']:checked").val() == 1){
    			
    			j$("#"+other_div_id+"_size").attr('class', 'dspBlock');
    			j$("#"+other_div_id+"_maxlength").attr('class', 'dspBlock');
    			j$("#"+other_div_id+"_check").attr('class', 'dspBlock');
    		
    		}else if (j$("input:radio[name='pd["+other_div_id+"]']:checked").val() == 2){
    			
    			j$("#"+other_div_id+"_size").attr('class', 'dspNone');
    			j$("#"+other_div_id+"_maxlength").attr('class', 'dspNone');
    			j$("#"+other_div_id+"_check").attr('class', 'dspNone');
    		}
    		
    		
    	});
    	
    	
    	j$(".other_div_class").click(function(){
    		
    		other_div_id = this.id;
    		
    		if (j$("input:radio[name='pd["+other_div_id+"]']:checked").val() == 1){
    			
    			j$("#"+other_div_id+"_size").attr('class', 'dspBlock');
    			j$("#"+other_div_id+"_maxlength").attr('class', 'dspBlock');
    			j$("#"+other_div_id+"_check").attr('class', 'dspBlock');
    		
    		}else if (j$("input:radio[name='pd["+other_div_id+"]']:checked").val() == 2){
    			
    			j$("#"+other_div_id+"_size").attr('class', 'dspNone');
    			j$("#"+other_div_id+"_maxlength").attr('class', 'dspNone');
    			j$("#"+other_div_id+"_check").attr('class', 'dspNone');
    		}

    		
    	});	
    	
    	
    },
		
    
    
   addEvent : function()
   {
        if (typeof j$ != 'undefined') {
            j$(document).ready(checkAction.main);
            j$(document).ready(checkAction.other);
        } else if (typeof $ != 'undefined') {
            $(document).ready(checkAction.main);
        } else {
            window.alert('selectAction:initialize failed.');
        }
    }
    
    
};


checkAction.addEvent();



	
	