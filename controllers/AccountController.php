<?php
class AccountController extends Controller{
    
    #取得帳號資訊
    function use_info(){
        $user=$this->model("info");
        $this->view("show_json",$user->session_info());
    }
    #到登入頁面
    function login(){ 
        $this->view("Account/ac_login");//是View底下的路徑    
    }
    #登入功能
    function check_user(){
        $user = $this->model("User");//使用mldwls底下的User，New一個User物件
        $user->name = $_POST['txtUserName'];
        $user->password = $_POST['txtPassword'];
        // var_dump($_POST);
        // exit;
        $arry_return = $user->check_login();
        // var_dump($arry_return);
        // exit;
        if($arry_return['isTrue']){
            header('Location: /homework0721_MVC/Regist/regist_index');
        }else{
             $this->view("Account/ac_login",$arry_return);//失敗回登入頁面
        }
    }
    
    #登出
    function logout(){ 
        $user = $this->model("logout");
        $user->unset_session();
        // $this->view("Account/ac_login");
        header('Location: /homework0721_MVC/Account/login');
    }
    
    #到註冊頁面
    function regist(){
        $this->view("Account/ac_regist");
    }
    
    #註冊動作
    function regist_account(){
        // var_dump($_POST);
        // exit;
        $user = $this->model("user_insert");
        
        $user->check = $_POST['check'];
        $user->nickname = $_POST['nickname'];
        $user->pw = $_POST['pw'];
        $user->pwCheck = $_POST['pwCheck'];
        $user->e_mail = $_POST['txtUserName'];

        $arry_return = $user->regist_insert();
        // var_dump($arry_return);
        // exit;
        if($arry_return['isTrue']){
            $this->view("Account/ac_login",$arry_return);//註冊成功，導入登入頁
        }else{
            $this->view("Account/ac_regist",$arry_return);//失敗繼續註冊頁
        }

    }
    #檢查帳號是否註冊過
    function regist_isset_user(){
        // echo $_POST['account'];
        // exit;
        $user = $this->model("isset_user");
        $user->account = $_POST['account'];
        $json_return = $user->check_account_isset();
        $this->view("show_json",$json_return);
    }
    
    #顯示修改密碼頁
    function change_password(){ 
        $this->view("Account/ac_ch_pass");
    }
    
    #修改密碼功能
    function ch_pass(){
        // var_dump($_POST);
        // exit;

        $user = $this->model("ch_pass");
        
        $user->oldPassword = $_POST['oldPassword'];
        $user->pw = $_POST['pw'];
        $user->pwCheck = $_POST['pwCheck'];
        $user->e_mail = $_POST['txtUserName'];
        $user->check = $_POST['check'];
        
        $arry_return = $user->ch_password();
        
        if($arry_return['isTrue']){
            header('Location: /homework0721_MVC/Account/logout');
        }else{
             $this->view("Account/ac_ch_pass",$arry_return);//失敗繼續在修改密碼頁
        }
    }
    
    #顯示忘記密碼頁
    function forget_password(){
        $this->view("Account/ac_forget");
    }
    #忘記密碼修改後寄信
    function forget_password_send_mail(){
        
        $user = $this->model("password_send_mail");
        $user->e_mail = $_POST['txtUserName'];
        
        $arry_return = $user->reset_password();
        // var_dump($arry_return);
        // exit;
        if($arry_return['isTrue']){
            $this->view("Account/ac_login",$arry_return);///密碼修改成功，登入畫面
        }else{ 
            $this->view("Account/ac_forget",$arry_return);//失敗回到忘記密碼頁
        }
    }
    

}


?>