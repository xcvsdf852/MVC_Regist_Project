<?php
session_start();
require_once("package/Tools.php");
require_once("Connections/DB_Class.php");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 

class password_send_mail{
    public $e_mail;
    public $data;
    private $md5_pass;

    function reset_password(){
        $this->data['password'] = Tools::getRandPassword();
        $this->data['updatetime'] = Tools::getCurrentDateTime();
        $this->md5_pass = Tools::getPasswordHash($this->data['password']); #MD5加密
        if (!preg_match('/^([.0-9a-z]+)@([0-9a-z]+).([.0-9a-z]+)$/i', $this->e_mail)){ #過濾Email;
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 2;
            $arry_result["mesg"] = "帳號格式為Email，請輸入正確格式!";
            $arry_result['e_mail'] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            return $arry_result;
         }
        $this->data['mail'] = $this->e_mail;
        // $sql_nick_name ="SELECT `ac_nick_name`
        //                 FROM  `account` 
        //                 WHERE `ac_email`= '".$this->e_mail."'
        //                 AND `is_enabled` = '0'"; 
        $sql_nick_name ="SELECT `ac_nick_name`
                        FROM  `account` 
                        WHERE `ac_email`= ?
                        AND `is_enabled` = '0'";  
         
        // $sql_update ="UPDATE `account` 
        //               SET `ac_password` = md5('".$this->data['password']."')
        //               WHERE `ac_email`= '".$this->e_mail."' 
        //               AND `is_enabled` = '0'";
        $sql_update ="UPDATE `account` 
                      SET `ac_password` = md5(?)
                      WHERE `ac_email`= ?
                      AND `is_enabled` = '0'";
                      
        // echo $sql_update;
        // echo "<br>".$this->data['password'];
        // exit;
        #連結資料庫
        // $db = new DB();
        // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $PDO = new myPDO();
        $conn = $PDO->getConnection();
        
        #取得使用者的暱稱
        // $result = $db->query($sql_nick_name);
        // $row = $db->fetch_array($result);
        $stmt = $conn->prepare($sql_nick_name);
        $stmt->bindValue(1, $this->e_mail, PDO::PARAM_STR);
        $result = $stmt->execute();
        $row = $stmt->fetch();
        if(!$row){ 
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 3;
            $arry_result["mesg"] = "重置密碼失敗，請重新申請!";
            $arry_result['e_mail'] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            // $db->closeDB();
            $PDO->closeConnection();
            return $arry_result;
        }
        $this->data['nickname'] = $row['ac_nick_name'];
        
        // echo $this->data['nickname'];
        // exit;
        
        // $result = $db->query($sql_update);
        $stmt = $conn->prepare($sql_update);
        $stmt->bindValue(1, $this->data['password'], PDO::PARAM_STR);
        $stmt->bindValue(2, $this->e_mail, PDO::PARAM_STR);
        $result = $stmt->execute();
        if($result){
        	if(Tools::sendResetPasswordMail($this->data)){
        	    $arry_result["isTrue"] = true;
                $arry_result["errorCod"] = 1;
                $arry_result["mesg"] = "申請成功，請至信箱收信!";
                $arry_result['e_mail'] = $this->e_mail;
                $arry_result['error'] = $arry_result;
                // $db->closeDB();
                $PDO->closeConnection();
                return $arry_result;
        	}else{
        	    $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 5;
                $arry_result["mesg"] = "寄信失敗，請重新申請!";
                $arry_result['e_mail'] = $this->e_mail;
                $arry_result['error'] = $arry_result;
                // $db->closeDB();
                $PDO->closeConnection();
                return $arry_result;
        	}
        }else{
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 4;
            $arry_result["mesg"] = "重置密碼失敗，請重新申請!";
            $arry_result['e_mail'] = $this->e_mail;
            $arry_result['error'] = $arry_result;
            // $db->closeDB();
            $PDO->closeConnection();
            return $arry_result;

        }

        // $db->closeDB();
        $PDO->closeConnection();
    }
}

?>