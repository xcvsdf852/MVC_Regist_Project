function check_mail_regist(){
    
    	if(!ChackEmail($("#txtUserName").val())){
            //格式有問題
    		$("#account_set").attr("class","form-group has-error has-feedback");
    		$("#account_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
            $("#check").val(0);
            // alert("請輸入正確email");
            BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: '請輸入正確email'
            }).setType(BootstrapDialog.TYPE_DANGER);
    	}else{
    		//成功的
            $.ajax({
    			type: 'POST',
    			url: 'regist_isset_user',
    			data:{
    			account:$("#txtUserName").val()
    			},
    			dataType: "json",
    			success: function(data){
                    //console.log(data);
                    
    				if(data.callback==0)
                    {   
                      $("#account_set").attr("class","form-group has-success has-feedback");
                      $("#account_message").attr("class","glyphicon glyphicon-ok form-control-feedback");
                      $("#check").val(1);
                    }
                    else
                    {
                      $("#account_set").attr("class","form-group has-error has-feedback");
                      $("#account_message").attr("class","glyphicon glyphicon-remove form-control-feedback");
                      // alert("此信箱帳號無人註冊，請再次確認!");   
                      BootstrapDialog.show({
                      title: 'Oops 系統發生錯誤!',
                      message: '此信箱帳號無人註冊，請再次確認!'
                      }).setType(BootstrapDialog.TYPE_DANGER);
                      $("#check").val(0);
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
  
  function submit_form(){
    if($("#check").val()==1){
      document.getElementById("form1").submit();
    }else{
      // alert("請再次確認信箱帳號!");
      BootstrapDialog.show({
      title: 'Oops 系統發生錯誤!',
      message: '請再次確認信箱帳號!'
      }).setType(BootstrapDialog.TYPE_DANGER);
      return;
    }
    
  }
  