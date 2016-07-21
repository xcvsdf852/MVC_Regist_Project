<?php
session_start(); 
// var_dump($_SESSION['isTrue']);
// var_dump($data);
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab - Login</title>
    
    <script src="/homework0721_MVC/views/js/jquery.js"></script>
    <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/homework0721_MVC/views/js/bootstrap-dialog.min.js"></script>
    <link href="/homework0721_MVC/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/homework0721_MVC/views/css/bootstrap-dialog.min.css" rel="stylesheet">
    <script type="text/javascript" src="/homework0721_MVC/views/js/login.js"></script>
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
     <form class="form-signin" role="form" id="form1" name="form1" action="/homework0721_MVC/Account/check_user" method="post">
         <h2 class="form-signin-heading" style= "text-align : center">記帳管理 - 登入</h2>
         <label for="inputEmail" class="sr-only">輸入帳號</label>
         <input type="text" name="txtUserName" id="txtUserName" class="form-control" placeholder="輸入帳號" autofocus="" value = "<?php if(is_null($_SESSION['error']['account'])|| !isset($_SESSION['error'])){echo "";}else{echo $_SESSION['error']['account'];} ?>"> 
         <label for="inputPassword" class="sr-only">輸入密碼</label> 
             <input type="password" name="txtPassword" id="txtPassword"  class="form-control" placeholder="輸入密碼" value ="<?php if(is_null($_SESSION['error']['pwd'])|| !isset($_SESSION['error'])){echo "";}else{echo $_SESSION['error']['pwd'];} ?>">
         <div style = "margin :10px 0px 10px 0px ">
           <label class ="label label-danger"><?php echo  $_SESSION['error']['mesg']; ?></label>
         </div>
           <button class="btn btn-lg btn-info btn-block" type="submit" name="btnOK" id="btnOK" >登入</button>
           <a class="btn btn-lg btn-warning btn-block" href="regist" name="btnOK" id="btnOK" >註冊</a>
           <div style= "text-align : right">
             <a href="forget_password">忘記密碼...</a>
           </div>
       </form>
   </div>

   
  </body>

</html>
