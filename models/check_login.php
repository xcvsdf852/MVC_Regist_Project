<?php
session_start();
class check_login{
    private $whiteAction = array(
                        "Account/login",
                        "Account/regist",
                        "Account/forget_password",
                        "Account/forget_password_send_mail",
                        "Account/regist_isset_user",
                        "Account/regist_account",
                        "Account/check_user"
                        );
    
    function check(){
        if(!in_array($_GET["url"], $this->whiteAction)){
            if(isset($_SESSION['id']) && isset($_SESSION['EmpAccount']) && isset($_SESSION['IsAdmin']))
                {
                    return true;
                }else{
                    return false;
                }
        }else{
            return true;
        }
    }
}
?>