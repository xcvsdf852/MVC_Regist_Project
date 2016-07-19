<?php

class App {
    private $whiteAction = array(
                        "Account/login",
                        "Account/regist",
                        "Account/forget_password",
                        "Account/forget_password_send_mail",
                        "Account/regist_isset_user"
                        );
    
    public function __construct() {
        
        $url = $this->parseUrl();
        
        $controllerName = "{$url[0]}Controller";
        
    //      if(!in_array($_GET["url"], $this->whiteAction)){
    //         if (session_status() == PHP_SESSION_NONE) {
    //             session_start();
    //         }
    // 		if(empty( $_SESSION['isLogin'] ) || $_SESSION['isLogin'] != 'true'){
    // 		    header("Location: /home");
    // 		}
    //     }
        
        if(!in_array($_GET["url"], $this->whiteAction)){
            if(isset($_SESSION['id']) && isset($_SESSION['EmpAccount']) && isset($_SESSION['IsAdmin']))
            {
                if($_SESSION['IsAdmin']==1){$user="admin";}
                else{$user="user";}
            }else{
                // echo "<script type='text/javascript'>alert('尚未登入');</script>";
                 // echo "<script type='text/javascript'>document.location.href='ac_login.html'</script>";
                echo "<script type='text/javascript'>document.location.href='/homework0721_MVC/Account/login'</script>";
                // header("Location: /homework0721_MVC/Account/login");
            }
        }       
        
        
        
        if (!file_exists("controllers/$controllerName.php")) //判斷該資料夾內有沒有該檔案
            return;
        require_once "controllers/$controllerName.php";  //有HomeController 的php
        $controller = new $controllerName;   //NEW 該物件，所以物件名稱要與檔名相同
        $methodName = isset($url[1]) ? $url[1] : "index";  //路徑第二位置 判斷是否有
        if (!method_exists($controller, $methodName))//檢查類別的方法是否存在，不存在停
            return;
        unset($url[0]); unset($url[1]); //清除掉類別與方法
        $params = $url ? array_values($url) : Array(); //判斷是否有參數
        call_user_func_array(Array($controller, $methodName), $params); //有參數就送到類別的方法中
    }
    
    public function parseUrl() {
        if (isset($_GET["url"])) {
            $url = rtrim($_GET["url"], "/"); //右邊空白去除
            $url = explode("/", $url);
            return $url;
        }
    }
    
}

?>