<?php
session_start(); 
require_once("Connections/DB_Class.php");

class User {
    public $name;
    public $password;
    function check_login(){
        $Actions_result='';
        $arry_result = array();
        // echo $this->name."<br>";
        // echo $this->password."<br>";
        // exit;
        if(isset($this->name) && isset($this->password)){
        
            $EmpAccount = $this->name;
            $EmpPwd = $this->password;
            // echo $EmpAccount;
        //=====================================================================================
        //對接收到的帳號資料先做正規化判斷
        //密碼進行MD5加密
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
            // $db = new DB();
            // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
            
            $PDO = new myPDO();
            $conn = $PDO->getConnection();
            
        //=====================================================================================
        //判斷讀出來的密碼是否與MD5加密後的使用者輸入密碼相同 並且IsEnabled(是否已啟用)
        //相同將資訊存入Session
        //=====================================================================================
            // $sql = sprintf("SELECT ac_id,ac_nick_name,ac_email,ac_password,is_admin,is_enabled FROM  account WHERE
            // ac_email='%s'",str_replace("'","\'",$EmpAccount));
            // echo $sql;
            // exit;
            $sql = "SELECT ac_id,ac_nick_name,ac_email,ac_password,is_admin,is_enabled FROM  account WHERE
            ac_email= ? ";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindValue(1, $EmpAccount, PDO::PARAM_STR);
            $result = $stmt->execute();
            $count = $stmt->fetch();
            
            // $result = $db->query($sql);
            // $count = $db->fetch_array($result);
            // var_dump($count);
            // exit;
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
                return $arry_result;
                
         
        	}else if(($count['is_enabled']=='0')){#當密碼錯誤，但有權限時
        		if($count['ac_password'] == ""|| ($count['ac_email']!=$EmpAccount) ){
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 2;
                    $arry_result["mesg"] = "查無該帳號!";
                    $arry_result['account'] = $this->name;
                    $arry_result["pwd"] = $this->password;
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
        		}else if($count['ac_password']!= $EmpPwd){
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 3;
                    $arry_result["mesg"] = "密碼有誤!";
                    $arry_result['account'] = $this->name;
                    $arry_result["pwd"] = $this->password;
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
        		}else{
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
    // 	$db->closeDB();
        $PDO->closeConnection();
    }
}

?>
