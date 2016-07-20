<?php 
session_start();
header("Content-Type:text/html; charset=utf-8");
require_once("Connections/DB_Class.php");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 

?>

<?php
// var_dump($_SESSION);

// var_dump($_POST);
// exit;
class add_charge{
    public $POST_data; 
    
    function charge(){
        // echo $this->POST_data['arry_num'];
        // exit;
        require_once("Connections/DB_config.php");
        $ip = getIP();
        $arry_num = explode(",",$this->POST_data['arry_num']);
        // var_dump($arry_num);
        // exit;
        $sql_str = "";
        foreach($arry_num as $value){
            // var_dump($this->POST_data['data_'.$value]);
            // exit;
            # 時間
            if( !isset($this->POST_data['data_'.$value]) || empty($this->POST_data['data_'.$value]))
            {
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 2;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料傳輸失敗!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;    
            	exit();
            }
            $data = str_SQL_replace($this->POST_data['data_'.$value]);
            if(!filter_var($data,  FILTER_SANITIZE_STRING)){
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 3;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料格式有誤!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
                exit();
            }
                

            
            
            #項目檢查 數字型態
            if( !isset($this->POST_data['items_'.$value]) || empty($this->POST_data['items_'.$value]))
            {
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 4;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料傳輸失敗!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
            	exit();
            }
            $items = str_SQL_replace($this->POST_data['items_'.$value] );
            if(!filter_var($items, FILTER_VALIDATE_INT)){
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 5;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料格式有誤!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
                exit();
            }
                
            
            #金錢檢查 數字型態 不能小於零
            if( !isset($this->POST_data['money_'.$value]) || empty($this->POST_data['money_'.$value]) || $this->POST_data['money_'.$value] <= 0)
            {
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 6;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料傳輸失敗!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
            	exit();
            }
            $money = str_SQL_replace($this->POST_data['money_'.$value] );
            if(!filter_var($money, FILTER_VALIDATE_INT)){
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 7;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料格式有誤!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
                exit();
            }
                
            
        
            #統一發票號碼檢查 字串型態 允許空值
            if( !isset($this->POST_data['receipt_'.$value]))
            {
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 8;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料傳輸失敗!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
            	exit();
            }
            $receipt = str_SQL_replace($this->POST_data['receipt_'.$value] );
            if($receipt != ""){
                if(!filter_var($receipt, FILTER_SANITIZE_STRING)){
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 9;
                    $arry_result["mesg"] = "新增消費紀錄失敗，資料格式有誤!";
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
                    exit();
                }
                    
            }
            // echo $_POST['receipt_'.$value]."<br>";
            #備註檢查 字串型態 允許空值
            if( !isset($this->POST_data['note_'.$value]))
            {
                $arry_result["isTrue"] = false;
                $arry_result["errorCod"] = 10;
                $arry_result["mesg"] = "新增消費紀錄失敗，資料傳輸失敗!";
                $_SESSION['error'] = $arry_result;
                return $arry_result;
            	exit();
            }
            $note = str_SQL_replace($this->POST_data['note_'.$value] );
            if($note != ""){
                if(!filter_var($note, FILTER_SANITIZE_STRING)){
                    $arry_result["isTrue"] = false;
                    $arry_result["errorCod"] = 11;
                    $arry_result["mesg"] = "新增消費紀錄失敗，資料格式有誤!";
                    $_SESSION['error'] = $arry_result;
                    return $arry_result;
                    exit();
                }
                   
            }
            // echo $_POST['note_'.$value]."<br>";
            
            $sql_str .= "('".$data."','".$items."','".$money."','".$receipt."','".$note."','".$ip."','".$_SESSION['id']."',NOW()),";
        }
        
        // echo $sql_str;
        $sql_str = substr_replace($sql_str, ';', -1, 1);
        $sql = "INSERT INTO `charge`(`date`,`items`,`buy`,`receipt`,`note`,`ip`,`user_id`,`creat_date`)
                VALUES".$sql_str ;
        // echo $sql;
        // exit();
        //=====================================================================================
        //進行連線
        //=====================================================================================
        $db = new DB();
        $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        
        $result = $db->query($sql);
        if(!$result){
            $arry_result["isTrue"] = false;
            $arry_result["errorCod"] = 12;
            $arry_result["mesg"] = "新增消費紀錄失敗，資料庫有誤!";
            $_SESSION['error'] = $arry_result;
            return $arry_result;
            exit();
        }
        
        $db->closeDB();
        $arry_result["isTrue"] = true;
        $arry_result["errorCod"] = 1;
        $arry_result["mesg"] = "紀錄新增成功!";
        return $arry_result;
        exit();
    }
}
?>