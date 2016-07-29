<?php
session_start();
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
require_once("Connections/DB_Class.php");

// var_dump($_POST);
// exit;

class regist_list_save{
    public $POST_data;
    function regist_update(){
        // var_dump($this->POST_data);
        // exit;
        #修改 id檢查 數字型態
        if( !isset($this->POST_data['id']) || empty($this->POST_data['id']))
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $id = str_SQL_replace($this->POST_data['id']);
        if(!filter_var($id, FILTER_VALIDATE_INT))
        {
            return '{"isTrue":0,"data":"資料格式錯誤!"}';
        }
        #user id檢查 數字型態
        if( !isset($this->POST_data['user']) || empty($this->POST_data['user']))
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $user = str_SQL_replace($this->POST_data['user']);
        if(!filter_var($user, FILTER_VALIDATE_INT))
        {
            return'{"isTrue":0,"data":"資料格式錯誤!"}';
        }
        #檢查是否為本人，或者是Admin
        if($_SESSION['id'] != $user && $_SESSION['IsAdmin'] == 0 )
        {
            return '{"isTrue":0,"data":"權限不足!"}';
        }
        
        # 時間
        if( !isset($this->POST_data['date']) || empty($this->POST_data['date']))
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $data = str_SQL_replace($this->POST_data['date']);
        if(!filter_var($data,  FILTER_SANITIZE_STRING))
        {
            return'{"isTrue":0,"data":"資料格式錯誤!"}';
        }
        #項目檢查 數字型態
        if( !isset($this->POST_data['items']) || empty($this->POST_data['items']))
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $items = str_SQL_replace($this->POST_data['items'] );
        if(!filter_var($items, FILTER_VALIDATE_INT))
        {
            return'{"isTrue":0,"data":"資料格式錯誤!"}';
        }
        #金錢檢查 數字型態 不能小於零
        if( !isset($this->POST_data['buy']) || empty($this->POST_data['buy']) || $this->POST_data['buy'] <= 0)
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $buy = str_SQL_replace($this->POST_data['buy'] );
        if(!filter_var($buy, FILTER_VALIDATE_INT)){
            return '{"isTrue":0,"data":"資料格式錯誤!"}';
        }
        
        
        #統一發票號碼檢查 字串型態 允許空值
        if(!isset($this->POST_data['receipt']))
        {
            return'{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $receipt = str_SQL_replace($this->POST_data['receipt'] );
        if($receipt != ""){
            if(!filter_var($receipt, FILTER_SANITIZE_STRING)){
                return '{"isTrue":0,"data":"資料格式錯誤!"}';
            }
        }
        
        #備註檢查 字串型態 允許空值
        if(!isset($this->POST_data['note']))
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $note = str_SQL_replace($this->POST_data['note'] );
        if($note != "" && $note != "0"){
            if(!filter_var($note, FILTER_SANITIZE_STRING)){
                return '{"isTrue":0,"data":"資料格式錯誤!"}';
            }
        }
        $ip = getIP();
         
        // $str_Sql='UPDATE `charge` 
        // SET `date`="'.$data.'"
        // ,`buy`="'.$buy.'" 
        // ,`items`="'.$items.'" 
        // ,`note`="'.$note.'" 
        // ,`ip`="'.$ip.'" 
        // ,`receipt`="'.$receipt.'" 
        // WHERE `id`="'.$id.'" &&  `user_id` = "'.$user.'";';
        $str_Sql='UPDATE `charge` 
        SET `date`= :data
        ,`buy`= :money 
        ,`items`= :items
        ,`note`= :note
        ,`ip`= :ip
        ,`receipt`= :receipt
        WHERE `id`= :id &&  `user_id` = :user;';
        
        // var_dump($str_Sql);
        // exit;
        
        //=====================================================================================
        //進行連線
        //=====================================================================================
        
        // $db = new DB();
        // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $PDO = new myPDO();
        $conn = $PDO->getConnection();
        
        // $result = $db->query($str_Sql);
        $sth = $conn->prepare($str_Sql);
        $sth->bindParam("data", $data);
        $sth->bindParam("items", $items);
        $sth->bindParam("money", $buy);
        $sth->bindParam("receipt", $receipt);
        $sth->bindParam("note", $note);
        $sth->bindParam("ip", $ip);
        $sth->bindParam("id", $id);
        $sth->bindParam("user", $user);
        $result = $sth->execute();
        
        if($result){
        	return '{"isTrue":1,"data":""}';
        }else{
        	return '{"isTrue":0,"data":"'. mysql_error().'"}';
    	}
        $PDO->closeConnection();
        // $db->closeDB();
        exit();
    }
}



?>