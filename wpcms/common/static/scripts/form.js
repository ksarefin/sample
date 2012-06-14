
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

  function RemoveErrroClass(field_id){

  	var get_val  = j$("#"+field_id).val();
	
	if (get_val !=''){
    	j$("#"+field_id+'_err').removeClass('wpfErrorBox');
    	j$("#"+field_id+'_err_msg').attr('class', 'dspNone');
    	j$("#"+field_id+"_yesno_err").attr('class', 'dspNone');
	}

  }
  
 
  function changeValue(field_id){
	           
    j$(document).ready(function(){

        if (field_id == 'wpf_entry_name_1'){

        	var kana_val_1  = j$("#entry_kana_name_1").val();

        	if (kana_val_1 != ''){
        		j$("#wpf_entry_kana_name_1").removeClass("em");
        	}      	
        } 

        if (field_id == 'wpf_entry_name_2'){
        	var kana_val_2  = j$("#entry_kana_name_2").val();

        	if (kana_val_2 != ''){
        		j$("#wpf_entry_kana_name_2").removeClass("em");
        	}      	
        } 


        var entry_val_1  = j$("#wpf_entry_name_1").val();
    	var entry_val_2  = j$("#wpf_entry_name_2").val();

    	if (entry_val_1 != '' && entry_val_2 != ''){
    		j$("#name_err").removeClass('errorBox');
    	}

    	var kana_val_1  = j$("#wpf_entry_kana_name_1").val();
    	var kana_val_2  = j$("#wpf_entry_kana_name_2").val();

    	if (kana_val_1 != '' && kana_val_2 != ''){
    		j$("#wpf_kana_name_err").removeClass('wpfErrorBox');
    	}


    	var mail_val = j$("#wpf_mailaddr").val();
    	var mail_conf_val = j$("#wpf_mail_confirm").val();

    	if (mail_val != '' && mail_val == mail_conf_val){
    		j$("#wpf_mail_err").removeClass('wpfErrorBox');
    		j$("#wpf_mail_err_msg").attr('class', 'dspNone');
    	}

    	var tel_val_1 = j$("#wpf_tel").val();
    	var tel_val_2 = j$("#wpf_tel_2").val();
    	var tel_val_3 = j$("#wpf_tel_3").val();
    	

    	if (tel_val_1 !='' && tel_val_2 != '' && tel_val_3 != ''){
    		j$("#wpf_tel_err").removeClass('wpfErrorBox');
    	}


    	

    	
    	var get_val  = j$("#"+field_id).val();
    	
    	if (get_val !=''){
        	j$("#"+field_id+'_err').removeClass('wpfErrorBox');
    	}
    	
    	var post_url = '/contact/activeir-entry/changedvalue/field/'+field_id+'/value/'+get_val;
		//alert(post_url);
		
		//if (field_id != 'wpf_company' || field_id != 'wpf_division'){
	    	j$.ajax({
				url: post_url,
				success: function(get_val){
					//alert(get_val);  
					j$("#"+field_id).val(get_val);
				}
			});
		//}

    });
  }
  
  

  j$(document).ready(function(){
	  
  	j$("ul#wpf_yesno_1").click(function(){
		if (j$("input[@name='wpf[demosite]']:checked").val() == 1){
			j$("#wpf_yesno_display_1").attr('class', 'dspBlock');
		}else if (j$("input[@name='wpf[demosite]']:checked").val() == 2){
			j$("#wpf_yesno_display_1").attr('class', 'dspNone');
		}		
	});


  	if (j$("input[@name='wpf[demosite]']:checked").val() == 1){
		j$("#wpf_yesno_1").attr('class', 'dspBlock');
	}else if (j$("input[@name='wpf[demosite]']:checked").val() == 2){
		j$("#wpf_yesno_1").attr('class', 'dspNone');
	}


  	var kana_val_1  = j$("#wpf_entry_kana_name_1").val();

	if (kana_val_1 != ''){
		j$("#wpf_entry_kana_name_1").removeClass("em");
	}  


	var kana_val_2  = j$("#wpf_entry_kana_name_2").val();

	if (kana_val_2 != ''){
		j$("#wpf_entry_kana_name_2").removeClass("em");
	}  

	

  });
