<?php
class AccountController extends Controller{
    
    function login(){ //到登入頁面

        $this->view("Account/ac_login");//是View底下的路徑
        // echo "Hello! $user->name";
    }
    
    function check_user(){ //登入功能
        $user = $this->model("User");//使用mldwls底下的User，New一個User物件
        $user->name = $_POST['txtUserName'];
        $user->password = $_POST['txtPassword'];
        
        $arry_return = $user->check_login();
        // var_dump($arry_return);
        if($arry_return['isTrue']){
            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
            $this->view("regist/regist_index");//登入成功要導入記帳頁面
        }else{
             $this->view("Account/ac_login");//失敗回登入頁面
        }
    }
    
    function logout(){ //登出
        $user = $this->model("logout");
        $user->unset_session();
        $this->view("Account/ac_login");
    }
    
    function check_login(){
        //檢查登入
    }
    
    function regist(){//到註冊頁面
        $this->view("Account/ac_regist");
    }
    
    function regist_account(){//註冊動作
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
    
    function regist_isset_user(){
        // echo $_POST['account'];
        // exit;
        $user = $this->model("isset_user");//使用mldwls底下的User，New一個User物件
        $user->account = $_POST['account'];
        $user->check_account_isset();
    }
    
    

}


?>