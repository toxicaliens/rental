pic1 = new Image(16, 16); 
pic1.src = "assets/img/ajaxpic/loader.gif";

$(document).ready(function(){
$("#head_code_name").change(function(){
	var head_name=$("#head_code_name").val();
	if(head_name){
     $("#status").html('<img src="assets/img/ajaxpic/loader.gif" align="absmiddle"> &nbsb; Checking Availability...');
       $.ajax({
       	 type: "POST",
       	 url:"src/RMC_module/check_headcode.php",
       	 data:"#head_code_name="+ head_name,
       	 success: function(msg){
         $("#status").ajaxComplete(function(event,request,settings){
         	if(msg=='OK'){
         		$("#head_code_name").removeClass('object_error');
         		$("#head_code_name").addClass('object_ok');
         		$(this).html('&nbsp;<img src="assets/img/ajaxpic/tick.gif" align="absmiddle">');
         	} else{
         		$("#head_code_name").removeClass('object_ok');
         		$("#head_code_name").addClass('object_error');
         		$(this).html(msg);
         	}
         })
       	 }
       })
	}
})
})























