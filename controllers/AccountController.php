<?php
class AccountController extends Controller{
    
    function login(){ 到登入頁面

        $this->view("Account/ac_login");//是View底下的路徑
        // echo "Hello! $user->name";
    }
    
    function check_user(){ //登入功能
        $user = $this->model("User");//使用mldwls底下的User，New一個User物件
        $user->name = $_POST['txtUserName'];
        $user->password = $_POST['txtPassword'];
        
        $arry_return = $user->check_login();
        // var_dump($arry_return);
        //  array(3) { 'isTrue' => bool(false) 
        //  'errorCod' => int(3) 
        //  'mesg' => string(13) "密碼有誤!"}
        if($arry_return['isTrue']){
            // echo '{"callback":'.$arry_return["errorCod"].'}';
            unset($_SESSION['error']);
            $this->view("regist/regist_index");//登入成功要導入記帳頁面
        }else{
            // $user->mesg_alert($arry_return['mesg']);
            //  echo "<script>  alert('".$mesg."'); </script>";
             $this->view("Account/ac_login",$arry_return);//失敗回登入頁面
            // echo '{"callback":'.$arry_return["errorCod"].'}';
            // return;
        }
    }
    
    function logout(){ //登出
        $user = $this->model("logout");
        $user->unset_session();
        $this->view("Account/ac_login");
    }
    
    function regist(){//到註冊頁面
        $this->view("Account/ac_regist");
    }
    
    function regist_account(){//註冊動作
        // $this->view("Account/ac_login");
        
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