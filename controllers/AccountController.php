<?php
class AccountController extends Controller{
    #到登入頁面
    function login(){ 

        $this->view("Account/ac_login");//是View底下的路徑
        // echo "Hello! $user->name";
    }
    #登入功能
    function check_user(){ 
        $user = $this->model("User");//使用mldwls底下的User，New一個User物件
        $user->name = $_POST['txtUserName'];
        $user->password = $_POST['txtPassword'];
        
        $arry_return = $user->check_login();
        // var_dump($arry_return);
        if($arry_return['isTrue']){
            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
            $this->view("Regist/regist_index");//登入成功要導入記帳頁面
        }else{
             $this->view("Account/ac_login");//失敗回登入頁面
        }
    }
    
    #登出
    function logout(){ 
        $user = $this->model("logout");
        $user->unset_session();
        $this->view("Account/ac_login");
    }
    
    function check_login(){
        //檢查登入
    }
    
    #到註冊頁面
    function regist(){
        $this->view("Account/ac_regist");
    }
    
    #註冊動作
    function regist_account(){
        // var_dump($_POST);
        // { 'nickname' => string(8) "Eric_456"
        // 'txtUserName' => string(19) "xcvsdf456@gmail.com"
        // 'pw' => string(8) "12345678"
        // 'pwCheck' => string(8) "12345678"
        // 'check' => string(1) "1"
        // 'check_pass' => string(1) "1"
        // 'check_name' => string(1) "1" } 
        // exit;
        $user = $this->model("user_insert");
        
        $user->check = $_POST['check'];
        $user->nickname = $_POST['nickname'];
        $user->pw = $_POST['pw'];
        $user->pwCheck = $_POST['pwCheck'];
        $user->e_mail = $_POST['txtUserName'];
        
        $arry_return = $user->regist_insert();
        
        if($arry_return['isTrue']){
            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
            $this->view("Account/ac_login");//註冊成功，導入燈入頁
        }else{
             $this->view("Account/ac_regist");//失敗回登入頁面
        }

    }
    #檢查帳號是否註冊過
    function regist_isset_user(){
        // echo $_POST['account'];
        // exit;
        $user = $this->model("isset_user");
        $user->account = $_POST['account'];
        $user->check_account_isset();
    }
    
    #顯示修改密碼頁
    function change_password(){ 
        $this->view("Account/ac_ch_pass");
    }
    
    #修改密碼功能
    function ch_pass(){
        // var_dump($_POST);
        // exit;
        // array(6) { 'txtUserName' => string(19) "xcvsdf789@gmail.com"
        // 'oldPassword' => string(10) "aa12345678"
        // 'pw' => string(11) "aa987654321"
        // 'pwCheck' => string(11) "aa987654321"
        // 'check_pass' => string(1) "1"
        // 'check' => string(1) "1" }
        
        $user = $this->model("ch_pass");
        
        $user->oldPassword = $_POST['oldPassword'];
        $user->pw = $_POST['pw'];
        $user->pwCheck = $_POST['pwCheck'];
        $user->e_mail = $_POST['txtUserName'];
        $user->check = $_POST['check'];
        
        $arry_return = $user->ch_password();
        
        if($arry_return['isTrue']){
            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
            // $this->view("Account/logout");//密碼修改成功，登出
            header('Location: /homework0721_MVC/Account/logout');
        }else{
             $this->view("Account/ac_ch_pass");//失敗繼續在修改密碼頁
        }
    }
    
    

}


?>