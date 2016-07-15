//-------------------------------------------------------------------
//載入新增會員
//-------------------------------------------------------------------	
var istrue=false;
function User_Insert(){
	istrue=check();
	if(istrue){
        document.getElementById("form1").submit();
	}
  
}
function check(){
	if($("#check").val() != 1){
		alert("請確實填寫帳號");
		$("#txtUserName").focus();
		istrue=false;
		return false;
	}
	
	if($("#check_name").val() != 1){
		alert("請確實填寫暱稱");
		$("#nickname").focus();
		istrue=false;
		return false;
	}
	
	if($("#check_pass").val() != 1){
		alert("請確實填寫密碼");
		$("#pw").focus();
		istrue=false;
		return false;
	}
	if($("#pw").val()!=$("#pwCheck").val()){ 
		alert("密碼不相同，請重新填寫!");
		istrue=false;
		return false;
	}
	return true;
}



//-------------------------------------------------------------------
//提示密碼確認
//-------------------------------------------------------------------	
function PasswordCheck(){
	re = /^[A-Za-z0-9]{8,15}$/;
	if($("#pw").val()==$("#pwCheck").val() && $("#pw").val()!="" && re.test($("#pwCheck").val()) ){
		$("#PasswordCheck").attr("class","form-group has-success has-feedback");
		$("#PasswordCheck2").attr("class","form-group has-success has-feedback");
		$("#PasswordCheck_message").attr("class","glyphicon glyphicon-ok form-control-feedback");
		$("#PasswordCheck2_message").attr("class","glyphicon glyphicon-ok form-control-feedback");
		$("#check_pass").val(1);
	}else{
		$("#PasswordCheck").attr("class","form-group has-error has-feedback");
		$("#PasswordCheck2").attr("class","form-group has-error has-feedback");
		$("#PasswordCheck_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
		$("#PasswordCheck2_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
		$("#check_pass").val(0);
		}
	}
//-------------------------------------------------------------------
//郵件信箱格式不符提示
//-------------------------------------------------------------------	
function User_Isset(){

	if(!ChackEmail($("#txtUserName").val())){
        //格式有問題
		$("#account_set").attr("class","form-group has-error has-feedback");
		$("#account_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
        $("#check").val(0);
        alert("請輸入正確email");
	}else{
		//成功的
        $.ajax({
			type: 'POST',
			url: '/homework0721_MVC/Account/regist_isset_user',
			data:{
			account:$("#txtUserName").val()
			},
			dataType: "json",
			success: function(data){
                //console.log(data);
                
				if(data.callback==0)
                {
                    $("#account_set").attr("class","form-group has-error has-feedback");
                    $("#account_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
                    alert("此帳號已有人註冊");
                    $("#check").val(data.callback);
                }
                else
                {
                    $("#account_set").attr("class","form-group has-success has-feedback");
                    $("#account_message").attr("class","glyphicon glyphicon-ok form-control-feedback");
                   // alert(1);
                   $("#check").val(data.callback);
                }
            }
        });
    }
}
		
		
		
		
 function ChackEmail(strEmail){	
	var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;  
	if(strEmail.search(emailRule)== -1){
		return false;
	}else{
		return true;
	}
}

function Checkname(){
	if($("#nickname").val() != ''){
		$("#name_set").attr("class","form-group has-success has-feedback");
		$("#name_message").attr("class","glyphicon glyphicon-ok form-control-feedback");
		$("#check_name").val(1);
	}else{
		$("#name_set").attr("class","form-group has-error has-feedback");
		$("#name_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
		$("#check_name").val(0);
	}
}