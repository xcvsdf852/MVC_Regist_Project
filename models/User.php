<?php
session_start(); 
header("Content-Type:text/html; charset=utf-8");
// require_once('homework0721_MVC/models/Connections/DB_connect.php');
// require_once("Connections/DB_config.php");
require_once("Connections/DB_Class.php");

class User {
    public $name;
    public $password;
    function check_login(){
        require_once("Connections/DB_config.php");
        // require_once("Connections/DB_Class.php");
        $Actions_result='';
        $arry_result = array();
        
        // echo $this->name."<br>";
        // echo $this->password."<br>";
        // var_dump($_DB);
        // echo $_DB['host']."<br>";
        // echo $_DB['username']."<br>";
        // exit;
        //---------------------------------------------------------------------------------------------
        //在接受到POST情況下進行資料比對
        //---------------------------------------------------------------------------------------------
        if(isset($this->name) && isset($this->password)){
        
            $EmpAccount = $this->name;
            $EmpPwd = $this->password;
            
            // echo $EmpAccount;
        //=====================================================================================
        //對接收到的帳號資料先做正規化判斷
        //是否是純英文與數字
        //密碼則是直接進行MD5加密
        //=====================================================================================
            if (!preg_match('/^([.0-9a-z]+)@([0-9a-z]+).([.0-9a-z]+)$/i', $EmpAccount)){ //過濾Email;
                
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 7;
                $arry_result["mesg"] = "帳號格式為Email，請輸入正確格式!";
                $arry_result['account'] = $this->name;
                $arry_result["pwd"] = $this->password;
                $_SESSION['error'] = $arry_result;
                
                $EmpAccount="";$IsError= 'EmpAccount is error';
                return $arry_result;
             }
            $EmpPwd=md5($EmpPwd);
            
        //=====================================================================================
        //進行連線
        //=====================================================================================
            // $conn = @mysql_connect($hostname,$username ,$password );
            // if (!$conn){
            //     die("資料庫連接失敗：" . mysql_error());
            // }
            // mysql_select_db($database, $conn);
            // mysql_query("set character set 'utf8'"); 
            $db = new DB();
            $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
            
            // echo $EmpPwd;
            // exit;
        //=====================================================================================
        //判斷讀出來的密碼是否與MD5加密後的使用者輸入密碼相同 並且IsEnabled(是否已啟用)是否設為一
        //相同將資訊存入Session
        //不同則不存入session並回傳錯誤的提醒
        //=====================================================================================
            $sql = sprintf("SELECT ac_id,ac_nick_name,ac_email,ac_password,is_admin,is_enabled FROM  account WHERE
            ac_email='%s'",str_replace("'","\'",$EmpAccount));
            // echo $sql;
            // exit;
            // $result = mysql_query($sql); 
            // $count = mysql_fetch_assoc($result);
            $result = $db->query($sql);
            $count = $db->fetch_array($result);
            // var_dump($count);
            // exit;
            // array(6) { 'ac_id' => string(1) "1" 
            // 'ac_nick_name' => string(9) "管理者"
            // 'ac_email' => string(19) "xcvsdf852@gmail.com" 
            // 'ac_password' => string(32) "7c497868c9e6d3e4cf2e87396372cd3b" 
            // 'is_admin' => string(1) "1" 'is_enabled' => string(1) "0" }
            
            if(($EmpPwd== $count['ac_password'])&&($count['is_enabled']=='0')){
        
                $_SESSION['id']=$count['ac_id'];
                $_SESSION['nick_name']=$count['ac_nick_name'];
                $_SESSION['EmpAccount']=$count['ac_email'];
                $_SESSION['IsAdmin']=$count['is_admin'];
        
                $IsAdmin=$count['IsAdmin'];
                $Actions_result="true";
                
                $arry_result["isTrue"] = true;
                $arry_result["errorCod"] = 1;
                $arry_result["mesg"] = "登入成功";
                // echo '{"callback":1}';
                return $arry_result;
                
         
        	}else if(($count['is_enabled']=='0')){//當密碼錯誤，但有權限時
        		if($count['ac_password'] == ""|| ($count['ac_email']!=$EmpAccount) ){
        // 			$Actions_result="not have the EmpAccount";
                //  echo '{"callback":2}';
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 2;
                    $arry_result["mesg"] = "查無該帳號!";
                    $arry_result['account'] = $this->name;
                    $arry_result["pwd"] = $this->password;
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
        		}else if($count['ac_password']!= $EmpPwd){
        // 			echo '{"callback":3}';
        // 			$Actions_result="EmpPwd is error";
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 3;
                    $arry_result["mesg"] = "密碼有誤!";
                    $arry_result['account'] = $this->name;
                    $arry_result["pwd"] = $this->password;
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
        		}else{
        // 			echo '{"callback":4}';
        // 			$Actions_result='The EmpAccount not Enabled';
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 4;
                    $arry_result["mesg"] = "帳密有誤!";
                    $arry_result['account'] = $this->name;
                    $arry_result["pwd"] = $this->password;
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
        		}
                    $IsAdmin=$count['IsAdmin'];
        	}else{
                // echo '{"callback":5}';
                // $Actions_result='Not have the EmpAccount';$IsAdmin="";
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 5;
                $arry_result["mesg"] = "帳號無權限!";
                $arry_result['account'] = $this->name;
                $arry_result["pwd"] = $this->password;
                $_SESSION['error'] = $arry_result;
                return $arry_result;
        	}
        }else{
            //=====================================================================================
            //沒有接收到傳送資料的狀況
            //=====================================================================================
        // 	echo '{"callback":6}';
        // 	$EmpAccount="not get";
        // 	$EmpPwd="not get";
        // 	$IsAdmin="";
        // 	$Actions_result='not get';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 6;
            $arry_result["mesg"] = "資料傳輸有誤!";
            $arry_result['account'] = $this->name;
            $arry_result["pwd"] = $this->password;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        }
        	
        if($Actions_result!="true"){
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 8;
            $arry_result["mesg"] = "登入失敗請檢查登入帳號密碼是否正確!";
            $arry_result['account'] = $this->name;
            $arry_result["pwd"] = $this->password;
            $_SESSION['error'] = $arry_result;
        }
        	$db->closeDB();
        // mysql_close ($conn);
    }
    function mesg_alert($mesg){
        echo '我有跑Alert'.$mesg;
        echo "<script>alert('".$mesg."');</script>";
    }
}

?>