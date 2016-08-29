<?php
session_start();
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
require_once("Connections/DB_Class.php");

class statistics_json{
    public $POST_data;
    function get_pie_data(){
        # 時間
        if( !isset($this->POST_data['time_str']) ){
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $time_str = str_SQL_replace($this->POST_data['time_str']);
        
        if( !isset($this->POST_data['time_end'])){
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        $time_end = str_SQL_replace($this->POST_data['time_end']);
        
        
        if($time_str != "" && $time_end == "" || $time_str == "" && $time_end != ""){
            return '{"isTrue":0,"data":"注意起訖時間都必須填寫!"}';
        }
        
        if($time_str == ""){
            $time_str = date("Y-m-d",strtotime("-1 month"));
        }
        if($time_end == ""){
            $time_end = date("Y-m-d");
        }
        
        if(strtotime($time_str)>strtotime($time_end)){ 
            return '{"isTrue":0,"data":"起始日期不得小於結束日期!"}';
        }
        
        #user id檢查 數字型態
        if( !isset($this->POST_data['user_id']) || empty($this->POST_data['user_id'])){
            return '{"isTrue":0,"data":"資料傳輸失敗!"}';
        }
        
        $user = str_SQL_replace($this->POST_data['user_id']);
        if(!filter_var($user, FILTER_VALIDATE_INT)){
            return '{"isTrue":0,"data":"資料格式錯誤!"}';
        }
        #檢查是否為本人，或者是Admin
        if($_SESSION['id'] != $user && $_SESSION['IsAdmin'] == 0 ){
            return '{"isTrue":0,"data":"權限不足!"}';
        }
        
        // echo $time_str."<br>";
        // echo $time_end."<br>";
        
        
        $str_sql = "SELECT i.`items_list`, SUM(c.`buy`) as `total`
                    FROM `charge` as c
                    LEFT JOIN `items` as i
                    ON c.`items` = i.`items_id`
                    WHERE DATE_FORMAT(c.`date`,'%Y-%m-%d') BETWEEN '".$time_str."' AND '".$time_end."'
                    AND  c.`user_id` = '".$user."'
                    GROUP BY `items`
                    ";
        // echo $str_sql;
        // exit;
        
        //=====================================================================================
        //進行連線
        //=====================================================================================
        
        // $db = new DB();
        // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $PDO = new myPDO();
        $conn = $PDO->getConnection();
        $stmt = $conn->prepare($str_sql);
        $result = $stmt->execute();
        
        $return_json = [];
        $str_json = '';
        
        // $result = $db->query($str_sql);
        
        while($row = $stmt->fetch()){
            $str_json .= '{"name": "'.$row['items_list'].'","y": '.$row['total'].'},';
        }
        $str_json = substr_replace($str_json, '', -1, 1);
        
        // echo $str_json;
        // exit;
        // $db->closeDB();
        $PDO->closeConnection();
        return '{"isTrue":1,"data":['.$str_json.']}';
    
        // exit();
    }
    
}



?>