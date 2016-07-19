<?php
session_start(); 
header("Content-Type:text/html; charset=utf-8");
require_once("Connections/DB_Class.php");
require_once("Connections/DB_config.php");



if(isset($_GET['P'])){$P=intval($_GET['P']);}else{$P=1;}
if(isset($_GET['P_number'])){$P_number=intval($_GET['P_number']);}else{$P_number=5;}
if(isset($_POST['time_str'])){$time_str=$_POST['time_str'];}else{$time_str='';}//起始時間
if(isset($_POST['time_end'])){$time_end=$_POST['time_end'];}else{$time_end='';}//結束時間
if(isset($_POST['select_value'])){$select_value=$_POST['select_value'];}else{$select_value='';}
if(isset($_POST['text_value'])){$text_value=$_POST['text_value'];}else{$text_value='';}


$str_where='';
//時間區間
if($time_str!="" && $time_end!=""){
	$str_where=$str_where.' && DATE_FORMAT(c.date,"%Y-%m-%d") BETWEEN DATE('."'".$time_str."'".') AND DATE('."'".$time_end."'".')';
}
#項目
if($select_value != ""){
	$str_where=$str_where.' && c.items='.intval($select_value);
}


if(trim($text_value)!=""){
	$RegexpString = reSet_RegexpString($text_value);
	$str_where=$str_where.' && ( c.receipt REGEXP "'.$RegexpString.'" || c.note REGEXP "'.$RegexpString.'" )';
}



#搜尋條件  DATE(c.creat_date)這邊只用年月日排序 所以第一筆不會在最上面
// $str_sql = "SELECT c.id, DATE_FORMAT(c.date,'%Y-%m-%d') as date, i.items_list, c.buy, c.receipt, c.note, c.items, c.user_id
// FROM `charge` as c LEFT JOIN items as i ON c.items = i.items_id
// WHERE c.is_enabled = 1 && c.user_id = '".$_SESSION['id']."' ".$str_where."
// ORDER BY DATE(c.creat_date) DESC 
// LIMIT ".(($P-1)*$P_number).",".$P_number.";";
#搜尋條件
$str_sql = "SELECT c.id, DATE_FORMAT(c.date,'%Y-%m-%d') as date, i.items_list, c.buy, c.receipt, c.note, c.items, c.user_id
FROM `charge` as c LEFT JOIN items as i ON c.items = i.items_id
WHERE c.is_enabled = 1 && c.user_id = '".$_SESSION['id']."' ".$str_where."
ORDER BY  c.creat_date DESC 
LIMIT ".(($P-1)*$P_number).",".$P_number.";";

// echo $str_sql;
// exit;


#依照搜尋結果統計總筆數
$str_sql_c = "SELECT COUNT(c.id) AS C
FROM `charge` as c LEFT JOIN items as i ON c.items = i.items_id
WHERE c.is_enabled =1 && c.user_id = '".$_SESSION['id']."' ".$str_where.";";

// echo $str_sql_c;
// exit;


// $i=$P_number * ($P-1)+1;

//var_dump($str_sql_c);

#輸入關鍵字進行搜尋功能
function reSet_RegexpString($value){
    $str = trim($value);
    $str = explode(" ", $str);
    $str_output='';

    for($i=1;$i<count($str);$i++) {
    	if($str[$i]!=''){
    		$str_output=$str_output.'|'.addslashes($str[$i]);
    	}
    }
    $str_output=addslashes($str[0]).$str_output;
    return $str_output;
}

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

// $result = mysql_query($str_sql);  
$result = $db->query($str_sql);

?>


<table class="table table-hover">
  <thead class="thead-inverse">
    <tr>
      <th>#</th>
      <th>消費日期</th>
      <th>項目</th>
      <th>消費金額</th>
      <th>統一發票</th>
      <th>備註</th>
      <th>修改</th>
      <th>刪除</th>
    </tr>
  </thead>
  <tbody>

<?php
    // while( $row = mysql_fetch_array($result)) {
    while( $row = $db->fetch_array($result)) {
        echo'
        <tr>
          <th scope="row"></th>
          <td><input style = "line-height: 100%;" type="date" id="date_'.$row['id'].'" value ="'.$row['date'].'" /></td>
          <td>
            <select id= "items_'.$row['id'].'" >
                <option value = "1">食</option>   
                <option value = "2">衣</option>
                <option value = "3">住</option>
                <option value = "4">行</option>
                <option value = "5">育</option>
                <option value = "6">樂</option>
            </select>
            <script language="javascript">$("#items_'.$row['id'].'").val("'.$row['items'].'");</script>
          </td>
          <td>
            <input type = "text" id="buy_'.$row['id'].'" size = "10" value ="'.$row['buy'].'"/>
          </td>
          <td>
            <input type = "text" id="receipt_'.$row['id'].'" size = "10" value ="'.$row['receipt'].'"/>
          </td>
           <td>
            <input type = "textarea" id="note_'.$row['id'].'" size = "15" value ="'.$row['note'].'" />
          </td>
          <td>
            <button class="btn btn-warning" onClick="save('.$row['id'].');" >修改</button>
          </td>
          <td>
            <button class="btn btn-danger" onClick="remove_data('.$row['id'].');" >刪除</button>
            <input type = "hidden" id="user_'.$row['id'].'" value ="'.$row['user_id'].'" />
          </td>
        </tr>';
    }
// $result = mysql_query($str_sql_c); 
// $count = mysql_fetch_assoc($result);
$result = $db->query($str_sql_c);
$count = $db->fetch_array($result);
?>
      </tbody>              
    </table>
<input type="hidden" id="count" value="<?php echo $count['C'];?>">
