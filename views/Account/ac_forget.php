 <html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab - Login</title>
    <script src="/homework0721_MVC/views/js/jquery.js"></script>
    <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
    <link href="/homework0721_MVC/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/homework0721_MVC/views/css/bootstrap-dialog.min.css" rel="stylesheet">
    <script type="text/javascript" src="/homework0721_MVC/views/js/bootstrap-dialog.min.js"></script>
    <script type="text/javascript" src="/homework0721_MVC/views/js/check_mail_regist.js"></script>

    <style>
      .container {
         width:310px;
      }
      input {
        margin-bottom :10px;
      }
    </style>
    <?php
    if(!empty($data)){
        
        if($data['isTrue']){
            echo "<script>
                $(document).ready(function(){
                      BootstrapDialog.show({
                      title: '執行操作成功!',
                      message: '".$data['mesg']."'
                      }).setType(BootstrapDialog.TYPE_SUCCESS);
                });
                  </script>
                  ";
        }else{
            echo "<script>
                $(document).ready(function(){
                      BootstrapDialog.show({
                      title: 'Oops 系統發生錯誤!',
                      message: '".$data['mesg']."'
                      }).setType(BootstrapDialog.TYPE_DANGER);
                });
                  </script>
                  ";
        }
    }
    
    ?>
  </head>   

  <body>


 <div class="container">
     <form class="form-signin" role="form" id="form1" name="form1" method="post" action="/homework0721_MVC/Account/forget_password_send_mail">
         <h2 class="form-signin-heading" style= "text-align : center">忘記密碼</h2>
         <label for="inputEmail" class="sr-only">輸入帳號</label>
         <div id="account_set">
             <span id='account_message'></span>
           <input type="text" name="txtUserName" id="txtUserName" class="form-control" placeholder="輸入Email帳號" autofocus="" onBlur="check_mail_regist();"> 
         </div>
           <button class="btn btn-lg btn-success btn-block" type="button" name="btnOK" id="btnOK" onclick ="submit_form()">寄信至Mail</button>
           <a class="btn btn-lg btn-info btn-block" href="login">回登入</a>
           <input name="check" type="hidden" value="0" id="check" />
       </form>
   </div>
   
  </body>
</html>