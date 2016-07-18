<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
require_once("Connections/DB_Class.php");
require_once("Connections/DB_config.php");


// var_dump($_POST);
// exit;
// $_POST = ['time_str' =>  "2016-07-01",
// 'time_end' =>  "2016-07-31",
// 'user_id' =>  "2" 
// ];

# 時間
if( !isset($_POST['time_str']) )
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$time_str = str_SQL_replace($_POST['time_str']);

if( !isset($_POST['time_end']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$time_end = str_SQL_replace($_POST['time_end']);


if($time_str != "" && $time_end == "" || $time_str == "" && $time_end != ""){
    echo '{"isTrue":0,"data":"注意起訖時間都必須填寫!"}';
	exit();
}

if($time_str == ""){$time_str = date("Y-m-d",strtotime("-1 month"));}
if($time_end == ""){$time_end = date("Y-m-d");}

if(strtotime($time_str)>strtotime($time_end)){ 
    echo '{"isTrue":0,"data":"起始日期不得小於結束日期!"}';
	exit();
}

#user id檢查 數字型態
if( !isset($_POST['user_id']) || empty($_POST['user_id']))
{
    echo '{"isTrue":0,"data":"資料傳輸失敗!"}';
	exit();
}
$user = str_SQL_replace($_POST['user_id']);
if(!filter_var($user, FILTER_VALIDATE_INT))
    die('{"isTrue":0,"data":"資料格式錯誤!"}');
    
#檢查是否為本人，或者是Admin
if($_SESSION['id'] != $user && $_SESSION['IsAdmin'] == 0 ){
    echo '{"isTrue":0,"data":"權限不足!"}';
    exit();
}



// echo $time_str."<br>";
// echo $time_end."<br>";


// SELECT i.items_list, SUM(c.buy) 
// FROM `charge` as c
// LEFT JOIN items as i
// ON c.items = i.items_id
// WHERE DATE_FORMAT(c.date,'%Y-%m-%d') BETWEEN '2016-07-01' AND '2016-07-31'
// AND  c.user_id = '2'
// GROUP BY items

$str_sql = "SELECT i.items_list, SUM(c.buy) as total
            FROM `charge` as c
            LEFT JOIN items as i
            ON c.items = i.items_id
            WHERE DATE_FORMAT(c.date,'%Y-%m-%d') BETWEEN '".$time_str."' AND '".$time_end."'
            AND  c.user_id = '".$user."'
            GROUP BY items
            ";
// echo $str_sql;
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

$return_json = [];
$str_json = '';

// $result = mysql_query($str_sql);
$result = $db->query($str_sql);

// while($row = mysql_fetch_assoc($result)){
while($row = $db->fetch_array($result)){
    $str_json .= '{"name": "'.$row['items_list'].'","y": '.$row['total'].'},';
}
$str_json = substr_replace($str_json, '', -1, 1);

// echo $str_json;
// exit;

echo '{"isTrue":1,"data":['.$str_json.']}';


// mysql_close ($conn);
$db->closeDB();
exit();


?>