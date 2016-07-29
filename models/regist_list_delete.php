<?php
// var_dump($_POST);
// exit;
session_start();
header("Content-Type:text/html; charset=utf-8");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
require_once("Connections/DB_Class.php");

class regist_list_delete{
    public $POST_data;
    function regist_delete(){
        require_once("Connections/DB_config.php");
        #修改 id檢查 數字型態
        if( !isset($_POST['id']) || empty($_POST['id']))
        {
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $id = str_SQL_replace($_POST['id']);
        if(!filter_var($id, FILTER_VALIDATE_INT))
            return '{"isTrue":0,"data":"資料格式錯誤!"}';
            
        $user_id = str_SQL_replace($_POST['user_id']);
        if(!filter_var($user_id, FILTER_VALIDATE_INT))
            return '{"isTrue":0,"data":"資料格式錯誤!"}';
        
        #檢查是否為本人，或者是Admin
        if($_SESSION['id'] != $user_id && $_SESSION['IsAdmin'] == 0 ){
            return '{"isTrue":0,"data":"權限不足!"}';
        }
        
        // echo "$id<br>";
        // echo "$user_id<br>";
        // exit;
        
        
        $str_Sql='UPDATE `charge`  
        SET `is_enabled`=0
        WHERE id='.$id.';';
        
        // var_dump($str_Sql);
        // exit;
        
        //=====================================================================================
        //進行連線
        //=====================================================================================
        
        $db = new DB();
        $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $result = $db->query($str_Sql);
        
        if($result ){
        	return '{"isTrue":1,"data":""}';
        }else{
        	return '{"isTrue":0,"data":"執行失敗"}';
    	}
        
        $db->closeDB();
        exit();
    }
}

