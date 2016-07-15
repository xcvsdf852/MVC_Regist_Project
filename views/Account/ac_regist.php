  <html>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab - Login</title>
    <link href="/homework0721_MVC/views/css/bootstrap.min.css" rel="stylesheet">
    <script src="/homework0721_MVC/views/js/jquery.js"></script>
    <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/homework0721_MVC/views/js/regist.js"></script>
    <style>
      .container {
         width:310px;
      }
      
      input {
        margin-bottom :10px;
        /*width:240px !important;  */
      }
    </style>
  </head>

  <body>


 <div class="container">
     <form class="form-signin" role="form" id="form1" name="form1" method="post">
         <h2 class="form-signin-heading" style= "text-align : center">記帳管理 - 註冊</h2>
         <label for="inputEmail" class="sr-only">輸入暱稱</label>
         
         <div id="name_set">
            <input type="text" name="nickname" id="nickname" class="form-control" placeholder="輸入暱稱" autofocus="" onBlur="Checkname();">
            <span id='name_message'></span>
         </div>
         
         <label for="inputEmail" class="sr-only">輸入帳號</label>
         <div id="account_set">
             <span id='account_message'></span>
             <input type="email" name="txtUserName" id="txtUserName" class="form-control" placeholder="輸入Email帳號" autofocus=""  onBlur="User_Isset();"> 
             
         </div>
         <label for="inputPassword" class="sr-only">輸入密碼</label> 
         <div id="PasswordCheck">
             <span id='PasswordCheck_message'></span>
             <input type="password" name="pw" id="pw"  class="form-control" placeholder="輸入密碼(包含英數字8~12碼)"  >
             
         </div>
         <label for="inputPassword" class="sr-only">輸入密碼</label> 
         <div id="PasswordCheck2">
             <span id='PasswordCheck2_message'></span> 
             <input type="password" name="pwCheck" id="pwCheck"  class="form-control" placeholder="輸入第二次密碼" onBlur="PasswordCheck();" >
             
         </div>
         <div style = "margin :10px 0px 10px 0px ">
           <label class ="label label-danger"><?php echo  $errorMSG;?></label>
         </div>
           <button class="btn btn-lg btn-success btn-block" type="button" name="btnOK" id="btnOK" onclick ="User_Insert()">邁向理財的第一步
             <span class="glyphicon glyphicon-usd" aria-hidden="true" ></span>
           </button>
          <input name="check" type="hidden" value="0" id="check" />
          <input name="check_pass" type="hidden" value="0" id="check_pass" />
          <input name="check_name" type="hidden" value="0" id="check_name" />
       </form>
   </div>

  </body>

  </html>