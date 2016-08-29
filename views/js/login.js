// ------------------------------------------------------
//登入與簡易的登入驗證(判斷有沒有輸入)
//-------------------------------------------------------------------	
function login(){
	var EmpAccount=$("#txtUserName").val();
	var EmpPwd=$("#txtPassword").val();
	$.ajax({
    	type: 'POST',
    	url: '/homework0721_MVC/Account/check_user',
    	data:{
    		"EmpAccount":EmpAccount, 
    		"EmpPwd":EmpPwd
    		},
    	dataType: "json"
    	,
    	success: 
    	function(data){
        	if(data.callback==1){
        		//location.reload();
        		alert("登入成功!)");
        		// window.location="index.php";
        		
        	}else if(data.callback==2){
        		alert("登入失敗,查無該帳號)");
        	}else if(data.callback==3){
        		alert("登入失敗,請重新檢查密碼");
        	}else if(data.callback==4){
        		alert("登入失敗,請重新檢查帳號密碼");
        	}else if(data.callback==5){
        		alert("登入失敗,請重新檢查帳號密碼");
        	}else if(data.callback==6){
        		alert("登入失敗,資料傳輸失敗");
        	}else{
        		alert("登入失敗,未登入");
        	}
    	}
	});
}
