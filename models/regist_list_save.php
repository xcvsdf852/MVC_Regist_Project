<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
require_once("Connections/DB_Class.php");
require_once("Connections/DB_config.php");
// var_dump($_POST);
// exit;
// array(5) { 
// 	'id' => string(1) "5"
// 	'date' => string(10) "2016-07-12"
//  'items' => string(1) "1"
// 	'buy' => string(2) "25"
// 	'receipt' => string(6) "123456"
// 	'note' => string(3) "123"
//  'user' => string(1) "2" 
// 	}

#修改 id檢查 數字型態
if( !isset($_POST['id']) || empty($_POST['id']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$id = str_SQL_replace($_POST['id']);
if(!filter_var($id, FILTER_VALIDATE_INT))
    die('{"isTrue":0,"data":"資料格式錯誤!"}');
    
#user id檢查 數字型態
if( !isset($_POST['user']) || empty($_POST['user']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$user = str_SQL_replace($_POST['user']);
if(!filter_var($user, FILTER_VALIDATE_INT))
    die('{"isTrue":0,"data":"資料格式錯誤!"}');

#檢查是否為本人，或者是Admin
if($_SESSION['id'] != $user && $_SESSION['IsAdmin'] == 0 ){
    echo '{"isTrue":0,"data":"權限不足!"}';
    exit();
}

# 時間
if( !isset($_POST['date']) || empty($_POST['date']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$data = str_SQL_replace($_POST['date']);
if(!filter_var($data,  FILTER_SANITIZE_STRING))
    die('{"isTrue":0,"data":"資料格式錯誤!"}');

#項目檢查 數字型態
if( !isset($_POST['items']) || empty($_POST['items']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$items = str_SQL_replace($_POST['items'] );
if(!filter_var($items, FILTER_VALIDATE_INT))
    die('{"isTrue":0,"data":"資料格式錯誤!"}');

#金錢檢查 數字型態 不能小於零
if( !isset($_POST['buy']) || empty($_POST['buy']) || $_POST['buy'] <= 0)
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$buy = str_SQL_replace($_POST['buy'] );
if(!filter_var($buy, FILTER_VALIDATE_INT))
    die('{"isTrue":0,"data":"資料格式錯誤!"}');



#統一發票號碼檢查 字串型態 允許空值
if(!isset($_POST['receipt']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$receipt = str_SQL_replace($_POST['receipt'] );
if($receipt != ""){
    if(!filter_var($receipt, FILTER_SANITIZE_STRING))
        die('{"isTrue":0,"data":"資料格式錯誤!"}');
}

#備註檢查 字串型態 允許空值
if(!isset($_POST['note']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$note = str_SQL_replace($_POST['note'] );
if($note != "" && $note != "0"){
    if(!filter_var($note, FILTER_SANITIZE_STRING))
        die('{"isTrue":0,"data":"資料格式錯誤!"}');
}
$ip = getIP();
// 	'id' => string(1) "5"
// 	'date' => string(10) "2016-07-12"
//  'items' => string(1) "1"
// 	'buy' => string(2) "25"
// 	'receipt' => string(6) "123456"
// 	'note' => string(3) "123"
//  'user' => string(1) "2" 
$str_Sql='UPDATE `charge` 
SET `date`="'.$data.'"
,`buy`="'.$buy.'" 
,`items`="'.$items.'" 
,`note`="'.$note.'" 
,`ip`="'.$ip.'" 
,`receipt`="'.$receipt.'" 
WHERE `id`="'.$id.'" &&  `user_id` = "'.$user.'";';

// var_dump($str_Sql);
// exit;

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

// $result = mysql_query($str_Sql) ;    
$result = $db->query($str_Sql);

if($result){
	echo '{"isTrue":1,"data":""}';
}else{
	echo '{"isTrue":0,"data":"'. mysql_error().'"}';
	}

// mysql_close ($conn);
$db->closeDB();
exit();

?>