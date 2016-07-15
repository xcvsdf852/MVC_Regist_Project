//-------------------------------------------------------------------
//載入新增會員
//-------------------------------------------------------------------	
function User_Insert(){
	
	if($("#check").val() != 1){
		alert("請確實填寫帳號");
		$("#txtUserName").focus();
		return;
	}
	
	if($("#check_name").val() != 1){
		alert("請確實填寫暱稱");
		$("#nickname").focus();
		return;
	}
	
	if($("#check_pass").val() != 1){
		alert("請確實填寫密碼");
		$("#pw").focus();
		return;
	}
	
	// if($("#pw").val()==$("#pwCheck").val()){ 
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: 'user_insert.php',
	// 		data:{
 //           	nickname:$("#nickname").val(),
 //               pw:$("#pw").val(),
 //               pwCheck:$("#pwCheck").val(),
 //               e_mail:$("#txtUserName").val(),
 //               check:$("#check").val()
	// 		},
	// 		dataType: "json",
	// 		success: function(data){
 //              if(data.callback==1){
 //                   alert("新增會員成功");
 //                  document.location.href="ac_login.html";
 //               }
 //               else if(data.callback==2){alert("新增會員失敗,資料庫設定錯誤(會員ID重複)");}
 //               else if(data.callback==3){alert("新增會員失敗,資料格式不符");}
 //               else if(data.callback==4){alert("新增會員失敗,資料傳輸失敗");}
 //               else if(data.callback==5){alert("新增會員失敗,沒有新增會員的權限");}
 //               else{alert("新增會員失敗,未登入");}
	// 		}
	// 		});
	
	// }else{alert("請確實填寫資料！");}
	if($("#pw").val()!=$("#pwCheck").val()){ 
		alert("密碼不相同，請重新填寫!");
		return;
	}
	
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