/**
 * debug.cn@gmail.com
**/
$(document).ready(function(){
	$('textarea.autogrow').autogrow();
	// 全选        
	$("#allselect").click(function(){
		$("[name=dels[]]:checkbox").each(function(){
			$(this).prop("checked",true);	
			$.uniform.update();		
		}); 
	});

	//反选
	$("#invert").click(function(){
		$("[name=dels[]]:checkbox").each(function(){
			if ($(this).is(":checked")){
				$(this).prop("checked",false);	
				$.uniform.update();	
			}else{
				$(this).prop("checked",true);	
				$.uniform.update();	
			}
		}); 
	});
	$("#cancel").click(function(){
		$("[name=dels[]]:checkbox").each(function(){
			$(this).prop("checked",false);	
			$.uniform.update();		
		}); 
	});

});
$('.selectpicker').selectpicker();

