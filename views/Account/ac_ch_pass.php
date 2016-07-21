
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab - Login</title>
    <link href="/homework0721_MVC/views/css/bootstrap.min.css" rel="stylesheet">
    <script src="/homework0721_MVC/views/js/jquery.js"></script>
    <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/homework0721_MVC/views/js/bootstrap-dialog.min.js"></script>
    <link href="/homework0721_MVC/views/css/bootstrap-dialog.min.css" rel="stylesheet">
    <script type="text/javascript" src="/homework0721_MVC/views/js/check_mail_regist.js"></script>
    <script type="text/javascript">
    
    	var istrue=false;
        function ch_pass_submit(){
        	istrue=ch_pass();
        	if(istrue){
                document.getElementById("ch_pass_form").submit();
             }
        }
        function ch_pass(){
	
        	if($("#check").val() != 1){
        // 		alert("請確實填寫帳號");
                BootstrapDialog.show({
				title: 'Oops 系統發生錯誤!',
				message: '請確實填寫帳號'
				}).setType(BootstrapDialog.TYPE_DANGER);
        		$("#txtUserName").focus();
        		istrue=false;
        		return false;
        	}
        	
        	if($("#oldPassword").val()==""){
                // alert("請填寫舊密碼！");
                BootstrapDialog.show({
				title: 'Oops 系統發生錯誤!',
				message: '請填寫舊密碼'
				}).setType(BootstrapDialog.TYPE_DANGER);
                $("#oldPassword").focus();
                istrue=false;
                return false;
            }

        	if($("#check_pass").val() != 1){
        // 		alert("請確實填寫密碼");
                BootstrapDialog.show({
				title: 'Oops 系統發生錯誤!',
				message: '請確實填寫密碼'
				}).setType(BootstrapDialog.TYPE_DANGER);
        		$("#pw").focus();
        		istrue=false;
        		return false;
        	}
        	
        	
        	if($("#pw").val()!=$("#pwCheck").val()){ 
                // alert("請確實填寫資料！");
                BootstrapDialog.show({
				title: 'Oops 系統發生錯誤!',
				message: '請確實填寫資料！'
				}).setType(BootstrapDialog.TYPE_DANGER);
                $("#pw").focus();
        		istrue=false;
        		return false;
        	
        	    }else{
        	        istrue=true;
            		return istrue;
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
        	
    </script>
    <style>
      .container {
         width:310px;
      }
      
      input {
        margin-bottom :10px;
      }
    </style>
  </head>

<body>
<?php include_once('views/header.html');?>
 <div class="container">
     <form class="form-signin" action = "ch_pass" method="post" id="ch_pass_form">
         <h2 class="form-signin-heading" style= "text-align : center">修改密碼</h2>
         <label for="inputEmail" class="sr-only">輸入帳號</label>
         <div id="account_set">
             <span id='account_message'></span>
             <input type="email" name="txtUserName" id="txtUserName" class="form-control" placeholder="輸入Email帳號" autofocus="" onBlur="check_mail_regist();" value = "<?php if(is_null($_SESSION['error']['account'])|| !isset($_SESSION['error'])){echo "";}else{echo $_SESSION['error']['account'];} ?>"> 
         </div>
         <label for="inputPassword" class="sr-only">輸入舊密碼</label> 
             <input type="password" name="oldPassword" id="oldPassword"  class="form-control" placeholder="輸入舊密碼" >
         <label for="inputPassword" class="sr-only">輸入新密碼</label> 
         <div id="PasswordCheck">
             <span id='PasswordCheck_message'></span>     
             <input type="password" name="pw" id="pw"  class="form-control" placeholder="輸入新密碼(包含英數字8~12碼)" >
         </div>
         <label for="inputPassword" class="sr-only">輸入第二次新密碼</label> 
         <div id="PasswordCheck2">
             <span id='PasswordCheck2_message'></span> 
             <input type="password" name="pwCheck" id="pwCheck"  class="form-control" placeholder="輸入第二次新密碼" onBlur="PasswordCheck();" >
         </div>
         <div style = "margin :10px 0px 10px 0px ">
           <label class ="label label-danger"><?php echo  $_SESSION['error']['mesg'];?></label>
         </div>
           <input type ="button" class="btn btn-lg btn-danger btn-block" value="送出修改" onclick="ch_pass_submit()">
           <input name="check_pass" type="hidden" value="0" id="check_pass" />
           <input name="check" type="hidden" value="0" id="check" />
       </form>
   </div>

</body>

</html>