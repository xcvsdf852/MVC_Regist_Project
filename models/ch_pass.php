<?php 
session_start();
require_once("Connections/DB_Class.php");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
?>


<?php
// var_dump($_POST);
// array(5) {
//     'oldPassword' => string(9) "a12345678"
//     'pw' => string(10) "aa12345678"
//     'pwCheck' => string(10) "aa12345678"
//     'e_mail' => string(19) "xcvsdf123@gmail.com"
//     'check' => string(1) "1" } OK
// exit;
// var_dump($_SESSION);
// exit;

class ch_pass{
    
    public $oldPassword;
    public $pw;
    public $pwCheck;
    public $e_mail;
    public $check;
    
    function ch_password(){
        require_once("Connections/DB_config.php");
        if(!isset($this->check) || empty($this->check) || $this->check != 1 )
        {
        // 	echo '{"callback":4}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 2;
            $arry_result["mesg"] = "修改密碼失敗，資料傳輸失敗!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        	exit();
        }
        
        //判斷是否有值傳進來
        if(!isset($this->e_mail) || empty($this->e_mail))
        {
        // 	echo '{"callback":4}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 3;
            $arry_result["mesg"] = "修改密碼失敗，資料傳輸失敗!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        	exit();
        }
        //e_mail正規表示法檢查
        $bool_isEmailtrue = preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $this->e_mail);
        if(!$bool_isEmailtrue)
        {
        // 	echo '{"callback":3}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 4;
            $arry_result["mesg"] = "修改密碼失敗，資料格式有誤!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        	exit();
        }
        
        
        //判斷是否有值傳進來
        if(!isset($this->pw) || empty($this->pw) ||!isset($this->pwCheck) || empty($this->pwCheck)
            ||!isset($_POST['oldPassword']) || empty($_POST['oldPassword'])
        )
        {
        // 	echo '{"callback":4}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 5;
            $arry_result["mesg"] = "修改密碼失敗，資料傳輸失敗!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        	exit();
        }
        //密碼正規表示法檢查
        $bool_isPasstrue1 = preg_match('/^[A-Za-z0-9]*[0-9]+[A-Za-z0-9]*$/', $this->pw);
        $bool_isPasstrue2 = preg_match('/^[A-Za-z0-9]*[A-Za-z]+[A-Za-z0-9]*$/', $this->pwCheck);
        $bool_isPasstrue3 = preg_match('/^[A-Za-z0-9]*[A-Za-z]+[A-Za-z0-9]*$/', $this->oldPassword);
        
        // echo strlen($_POST['pw']);
        // exit;
        
        if(strlen($this->pw) < 8 || strlen($this->pw) > 12){ #8-12碼檢查
            // echo '{"callback":3}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 6;
            $arry_result["mesg"] = "修改密碼失敗，密碼至少8~12碼!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        	exit();
        }
        
        //不符合格式
        if(!$bool_isPasstrue1 || !$bool_isPasstrue2|| !$bool_isPasstrue3)  
        {
        // 	echo '{"callback":3}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 7;
            $arry_result["mesg"] = "修改密碼失敗，需英數字混和!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
        	exit();
        }
        
        //---------------------------------
        
        
        $str_pw = str_sql_replace($this->pw);
        $str_e_mail = str_sql_replace($this->e_mail);
        $str_oldPassword = str_sql_replace($this->oldPassword);
        $str_ip = getIP();
        
        
        
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
        #檢查帳號密碼是否符合
        $sql = sprintf("SELECT COUNT(ac_id) AS C FROM  account 
                        WHERE ac_email='%s' AND ac_password = MD5('%s')" ,
                        str_replace("'","\'",$str_e_mail),
                        str_replace("'","\'",$str_oldPassword)
                        );
        // echo $sql;
        // exit;
        // $result = mysql_query($sql) or die(mysql_error);    
        // $count = mysql_fetch_assoc($result);
        $result = $db->query($sql);
        // var_dump($result);
        
        if(!$result){
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 8;
            $arry_result["mesg"] = "修改密碼失敗，資料庫請求失敗!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
            exit();
        }
        $count = $db->fetch_array($result);
        
        if($count['C'] <= 0 ){
            // echo '{"callback":2}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 9;
            $arry_result["mesg"] = "修改密碼失敗，驗證帳密有誤!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
            exit();
        }
        
        #檢查是否為本人，或者是Admin
        if($_SESSION['EmpAccount'] != $str_e_mail && $_SESSION['IsAdmin'] ==0 ){
            // echo '{"callback":5}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 10;
            $arry_result["mesg"] = "修改密碼失敗，修改權限有誤!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
            exit();
        }
        
        
        $sql = sprintf("UPDATE `account` SET ac_password = MD5('%s') WHERE ac_email='%s'"
                        ,str_replace("'","\'",$str_pw),
                        str_replace("'","\'",$str_e_mail)
                        );
        // echo $sql;
        // exit;
        // $result = mysql_query($sql) 
        // or die('{"callback":6}');
        $result = $db->query($sql);
        $count = $db->fetch_array($result);
        if(!$result){
            // echo '{"callback":2}';
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 11;
            $arry_result["mesg"] = "修改密碼失敗，驗證帳密有誤!";
            $arry_result['account'] = $this->e_mail;
            $_SESSION['error'] = $arry_result;
            return $arry_result;
            exit();
        }
        
        // mysql_close ($conn);
        // echo '{"callback":1}';
        $db->closeDB();
        $arry_result["isTrue"] = true;
        $arry_result["errorCod"] = 1;
        $arry_result["mesg"] = "密碼修改完成!";
        return $arry_result;
        exit();
    }
}

?>