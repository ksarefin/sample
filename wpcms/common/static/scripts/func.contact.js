j$(function(){

	// ボタンカスタマイズ
	// j$("select, input:checkbox, input:radio").uniform();




	/*j$("ul#demosite").click(function(){
		if (j$("input[@name='pd[demosite]']:checked").val() == 1){
			//j$("#tglBox01").slideToggle("fast");
			j$("#hiddenBox").attr('class', 'dspBlock');
		}else if (j$("input[@name='pd[demosite]']:checked").val() == 2){
			j$("#hiddenBox").attr('class', 'dspNone');
		}
		
	});
*/
	// 強調
	var input_val = [];
	j$(".wpfInputMust").each(function() {
		input_val.push(j$(this).val());
		if(j$(this).val() == '') {
			j$(this).addClass("em");
		}
		if(j$(this).val() != '') {
			j$(this).removeClass("em");
		}
	});
	j$(".wpfInputMust").focus(function() {
		if(chk_val == input_val[chk_num]) {
			var chk_num = j$(".wpfInputMust").index(this);
			var chk_val = j$(".wpfInputMust").eq(chk_num).val();
			var def_val = j$(this).val();
			//j$(this).val('');
			j$(this).removeClass("em");
			j$(this).blur(function() {
				if(j$(this).val() == '') {
					j$(this).val(def_val);
					j$(this).addClass("em");
				}
			});
		}
	});

	j$("#wpfAgreeCheck:checkbox").attr("checked",false); 

});
