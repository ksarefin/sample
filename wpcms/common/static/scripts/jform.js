
jQuery(function() {
	j$('#wpfAgreeBtn').hide();
	j$("input[name='wpfAgreeCheck']").click(function () {
		if (j$("input[name='wpfAgreeCheck']:checked").val()){
			j$('#wpfAgreeBtn').show();
		}else{
			j$('#wpfAgreeBtn').hide();
		}
	});
});  


j$(document).ready(function(){
    
	  
	/**
	 * for yes no radio contents display hide 
	 * j$(".yesNoUl").each(function(){ use for default
	 * j$(".yesNoUl").click(function(){ use for on click
	 */  
	var y_n_ul_id = "";
	var radio_id  = "";
	
	j$(".yesNoUl").each(function(){
		
		//alert(this.id);
		y_n_ul_id = this.id; 
		
		radio_id = y_n_ul_id.replace('_ul', '');
		//alert(radio_id);
		  
		if (j$('input:radio[name=\'pd['+radio_id+']\']:checked').val() == 1){
					
			j$("."+radio_id+"_display").each(function(){
				j$(this).removeClass("dspNone");				
			});
					
		}else if (j$('input:radio[name=\'pd['+radio_id+']\']:checked').val() == 2){
					
			j$("."+radio_id+"_display").each(function(){
				j$(this).addClass("dspNone");				
			});
		}		
		
	}); // j$(".yesNoUl").each(function(){
	
	

	j$(".yesNoUl").click(function(){
		
		//alert(this.id);
		y_n_ul_id = this.id; 
		
		radio_id = y_n_ul_id.replace('_ul', '');
		//alert(radio_id);
		  
		if (j$('input:radio[name=\'pd['+radio_id+']\']:checked').val() == 1){
					
			j$("."+radio_id+"_display").each(function(){
				j$(this).removeClass("dspNone");				
			});
					
		}else if (j$('input:radio[name=\'pd['+radio_id+']\']:checked').val() == 2){
					
			j$("."+radio_id+"_display").each(function(){
				j$(this).addClass("dspNone");				
			});
		}		
		
	}); // j$(".yesNoUl").click(function(){
	
	
	
	/**
	 * wpfAgreeBtn show hide
	 */
	if (j$("input:checkbox[name='wpfAgreeCheck']").length){
		j$('#wpfAgreeBtn').hide();
	}
	else {
		j$('#wpfAgreeBtn').show();
	}
	
	
	/**
	 * remove error massege on change
	 */
	j$(".RemoveErrroMsg").change(function(){
		
		var main_field_id = this.id;
		
		var get_split = main_field_id.split('_');
		
		if (get_split[2] != '')
			field_id = get_split[0]+'_'+get_split[1];
		
		//alert(field_id);
		
		/**
		 * remove errbox and error massege from name field set
		 */
		if (field_id.match('name_')){
			
			var entry_val_1  = j$("#"+field_id+"_1").val();
	    	var entry_val_2  = j$("#"+field_id+"_2").val();

	    	if (entry_val_1 != '' && entry_val_2 != ''){
	    		removeErr(field_id);
	    	}
	    	
	    	var kana_val_1  = j$("#"+field_id+"_kana_1").val();
	        var kana_val_2  = j$("#"+field_id+"_kana_2").val();
	        
        	if (kana_val_1 != ''){
        		j$("#"+field_id+"_kana_1").removeClass("em");
        	}
	        	
        	if (kana_val_2 != ''){
        		j$("#"+field_id+"_kana_2").removeClass("em");
        	}
	        		        	
        	if (kana_val_1 != '' && kana_val_2 != ''){
        		removeErr(field_id+'_kana');
        	}
			
		} // if (field_id.match('name_')){
		
		
		/**
		 * remove errbox and error massege from mail field set
		 */
    	if (field_id.match('mail_')){
    		
    		var mail_val = j$("#"+field_id+"_mail").val();
        	var mail_conf_val = j$("#"+field_id+"_mail_conf").val();
        	
        	if (mail_val != '' && mail_val == mail_conf_val){
        		removeErr(field_id);
        	}
        	
    	} // if (field_id.match('mail_')){
    	
    	
    	/**
		 * remove errbox and error massege from address set
		 */
    	if (field_id.match('address_')){
    		
    		
    		/**
    		 * remove error massege from post code
    		 */
    		if (get_split[2] == 'pcode'){
    			
    			var post_val_1 = j$("#"+field_id+'_'+get_split[2]+"_1").val();
            	var post_val_2 = j$("#"+field_id+'_'+get_split[2]+"_2").val();
            	
            	if (post_val_1 !='' && post_val_2 != ''){
            		removeErr(field_id+'_'+get_split[2]);
            	}
            	
    		} // if (get_split[2] == 'pcode'){
    		
    		
    		/**
    		 * remove error massege from prefecture
    		 */
    		if (get_split[2] == 'pref'){
    			
    			var pref_val = j$("#"+field_id+'_'+get_split[2]).val();
            	
            	if (pref_val !=''){
            		removeErr(field_id+'_'+get_split[2]);
            	}
            	
    		} // if (get_split[2] == 'pref'){
    		
    		
    		/**
    		 * remove error massege from address a
    		 */
    		if (get_split[2] == 'address'){
    			
    			var address_a_val = j$("#"+field_id+'_'+get_split[2]+"_a").val();
            	
            	if (address_a_val !=''){
            		removeErr(field_id+'_'+get_split[2]);
            	}
            	
    		} // if (get_split[2] == 'address'){
    		
        	
    	} // if (field_id.match('address_')){
    	
    	
    	/**
		 * remove errbox and error massege from birthday fields set
		 */
    	if (field_id.match('birthday_')){
    		
    		var birth_year_val 	= j$("#"+field_id+"_year").val();
        	var birth_month_val = j$("#"+field_id+"_month").val();
        	var birth_day_val	= j$("#"+field_id+"_day").val();
        	

        	if (birth_year_val !='' && birth_month_val != '' && birth_day_val != ''){
        		removeErr(field_id);
        	}
        	
    	} // if (field_id.match('birthday_')){
    	
    	
    	/**
		 * remove errbox and error massege from tel field set
		 */
    	if (field_id.match('tel_')){
    		
    		var tel_val_1 = j$("#"+field_id+"_1").val();
        	var tel_val_2 = j$("#"+field_id+"_2").val();
        	var tel_val_3 = j$("#"+field_id+"_3").val();
        	

        	if (tel_val_1 !='' && tel_val_2 != '' && tel_val_3 != ''){
        		removeErr(field_id);
        	}
        	
    	} // if (field_id.match('tel_')){
    	
    	
    	
    	if (main_field_id)
			var get_val  = j$("#"+main_field_id).val();
		//alert(get_val);
    	
		if (get_val !=''){
	    	removeErr(main_field_id);
	    }
		
		
		var checkVal = j$(this).attr('checkVal');
		
		var wpcms_path = j$('#path').attr('wpcms_path');
		
		var post_url = wpcms_path+'/wpform/ajax/changeValue/field/'+main_field_id;
		
		if (checkVal)
			var post_data = "value="+get_val+"&checkType="+checkVal;
		else
			var post_data = "value="+get_val;
		
		
		j$.ajax({
		  type: "POST",
		  url: post_url,
		  data: post_data,
		}).done(function( get_val ){
			j$("#"+main_field_id).val(get_val);
		});
	    
		
	}); // j$(".RemoveErrroMsg").change(function(){

	  
	

  	var kana_val_1  = j$("#wpf_entry_kana_name_1").val();

	if (kana_val_1 != ''){
		j$("#wpf_entry_kana_name_1").removeClass("em");
	}  


	var kana_val_2  = j$("#wpf_entry_kana_name_2").val();

	if (kana_val_2 != ''){
		j$("#wpf_entry_kana_name_2").removeClass("em");
	}  

	

  });



function removeErr(field_id){
	j$("#"+field_id+'_err').removeClass('wpfErrorBox');
	j$("#"+field_id+'_err_msg').attr('class', 'dspNone');
}

  
  
  
  
  
  
  
  
  
