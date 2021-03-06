<?php 
session_start();
require_once("Connections/DB_Class.php");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
?>

<?php 

class user_insert{
    public $check;
    public $nickname;
    public $pw;
    public $pwCheck;
    public $e_mail;
    
    function regist_insert(){
        if(!isset($this->check) || empty($this->check) || $this->check != 1 ){
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 3;
            $arry_result["mesg"] = "新增會員失敗,資料傳輸失敗!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        
        //判斷是否有值傳進來
        if(!isset($this->e_mail) || empty($this->e_mail)){
        	$arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 4;
            $arry_result["mesg"] = "新增會員失敗,資料傳輸失敗!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        //e_mail正規表示法檢查
        $bool_isEmailtrue = preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $this->e_mail);
        if(!$bool_isEmailtrue){
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 5;
            $arry_result["mesg"] = "新增會員失敗,資料格式不符!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        
        
        
        //判斷是否有值傳進來
        if(!isset($this->pw) || empty($this->pw) ||!isset($this->pwCheck) || empty($this->pwCheck)){
        	$arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 6;
            $arry_result["mesg"] = "新增會員失敗,資料傳輸失敗!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        //密碼正規表示法檢查
        $bool_isPasstrue1 = preg_match('/^[A-Za-z0-9]*[0-9]+[A-Za-z0-9]*$/', $this->pw);
        $bool_isPasstrue2 = preg_match('/^[A-Za-z0-9]*[A-Za-z]+[A-Za-z0-9]*$/', $this->pwCheck);
        
        
        // echo strlen($_POST['pw']);
        // exit;
        
        if(strlen($this->pw) < 8 || strlen($this->pw) > 12){ #8-12碼檢查
        	$arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 7;
            $arry_result["mesg"] = "新增會員失敗,密碼要8-12英數字混和!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        
        //不符合格式
        if(!$bool_isPasstrue1 || !$bool_isPasstrue2)  {
        	$arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 8;
            $arry_result["mesg"] = "新增會員失敗,密碼需英數字混和!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        
        //檢查暱稱
        if( !isset($this->nickname) || empty($this->nickname)){
        	$arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 9;
            $arry_result["mesg"] = "新增會員失敗,資料傳輸失敗!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        $str_nickname = str_SQL_replace($this->nickname);
        if(!filter_var($str_nickname,  FILTER_SANITIZE_STRING)){
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 10;
            $arry_result["mesg"] = "新增會員失敗,資料格式不符!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        //---------------------------------
        
        
        $str_pw = str_sql_replace($this->pw);
        $str_e_mail = str_sql_replace($this->e_mail);
        $str_ip = getIP();
        
        
        
        //=====================================================================================
        //進行連線
        //=====================================================================================
        // $db = new DB();
        // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $PDO = new myPDO();
        $conn = $PDO->getConnection();
        //============================存入資料庫==========================================
        //判斷所有輸入值都通過function驗證才開始輸入資料庫
        //==============================================================================
        
        $query = sprintf("INSERT INTO `account`(`ac_password`,`ac_nick_name`,`ac_email`,`creat_date`,`is_enabled`,`is_admin`,`ac_ip`) 
                          VALUES (MD5('%s'),'%s','%s',NOW(),0,0,'%s')",
                          str_replace("'","\'",$str_pw), 
                          str_replace("'","\'",$str_nickname), 
                          str_replace("'","\'",$str_e_mail), 
                          str_replace("'","\'",$str_ip)
                        );
        // echo $query;
        // exit;
        $stmt = $conn->prepare($query);
        $result = $stmt->execute();
        // $result = $db->query($query);
        if($result){
            $arry_result["isTrue"] = true;
            $arry_result["errorCod"] = 1;
            $arry_result["mesg"] = "新增會員成功!";
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }else{
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 2;
            $arry_result["mesg"] = "新增會員失敗,資料庫設定錯誤!";
            $arry_result['nickname'] = $this->nickname;
            $arry_result["pw"] = $this->pw;
            $arry_result["pwCheck"] = $this->pwCheck;
            $arry_result["e_mail"] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
        }
        // $db->closeDB();
        $PDO->closeConnection();
    }
}

?>

