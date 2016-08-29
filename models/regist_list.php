<?php
session_start();
require_once("Connections/DB_Class.php");
require_once('package/str_sql_replace.php');
class regist_list{
  public $POST_data;

  function search_regist_list(){

    if(isset($this->POST_data['P'])){
      $P=intval($this->POST_data['P']);
    }else{
      $P=1;
    }
    if(isset($this->POST_data['P_number'])){
      $P_number=intval($this->POST_data['P_number']);
    }else{
      $P_number=5;
    }
    if(isset($this->POST_data['time_str'])){
      $time_str=str_SQL_replace($this->POST_data['time_str']);
    }else{
      $time_str='';
    }//起始時間
    if(isset($this->POST_data['time_end'])){
      $time_end=str_SQL_replace($this->POST_data['time_end']);
    }else{
      $time_end='';
    }//結束時間
    if(isset($this->POST_data['select_value'])){
      $select_value=str_SQL_replace($this->POST_data['select_value']);
    }else{
      $select_value='';
    }
    if(isset($this->POST_data['text_value'])){
      $text_value=str_SQL_replace($this->POST_data['text_value']);
    }else{
      $text_value='';
    }

    $str_where='';
    //時間區間
    if($time_str!="" && $time_end!=""){
    	$str_where=$str_where.' && DATE_FORMAT(c.`date`,"%Y-%m-%d") BETWEEN DATE('."'".$time_str."'".') AND DATE('."'".$time_end."'".')';
    }
    #項目
    if($select_value != ""){
    	$str_where=$str_where.' && c.`items`='.intval($select_value);
    }


    if(trim($text_value)!=""){
    	$RegexpString = $this->reSet_RegexpString($text_value);
    	$str_where=$str_where.' && ( c.`receipt` REGEXP "'.$RegexpString.'" || c.`note` REGEXP "'.$RegexpString.'" )';
    }


    #搜尋條件
    $str_sql = "SELECT c.`id`, DATE_FORMAT(c.`date`,'%Y-%m-%d') as date, i.`items_list`, c.`buy`, c.`receipt`, c.`note`, c.`items`, c.`user_id`
    FROM `charge` as c LEFT JOIN `items` as i ON c.`items` = i.`items_id`
    WHERE c.`is_enabled` = 1 && c.`user_id` = '".$_SESSION['id']."' ".$str_where."
    ORDER BY  c.`creat_date` DESC
    LIMIT ".(($P-1)*$P_number).",".$P_number.";";

    // echo $str_sql;
    // exit;


    #依照搜尋結果統計總筆數
    $str_sql_c = "SELECT COUNT(c.`id`) AS C
    FROM `charge` as c LEFT JOIN `items` as i ON c.`items` = i.`items_id`
    WHERE c.`is_enabled` =1 && c.`user_id` = '".$_SESSION['id']."' ".$str_where.";";

    // echo $str_sql_c;
    // exit;
    // $i=$P_number * ($P-1)+1;
    //var_dump($str_sql_c);

    //=====================================================================================
    //進行連線
    //=====================================================================================

    // $db = new DB();
    // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $PDO = new myPDO();
    $conn = $PDO->getConnection();
    // $result = mysql_query($str_sql);

    // $result = $db->query($str_sql); #查詢結果
    $stmt = $conn->prepare($str_sql);
    $result = $stmt->execute();
    // echo $result;
    // exit;
    if(!$result){
      $ary_list['isTrue'] = false;
      $ary_list['mesg'] = "資料庫讀取錯誤!!";
      return json_encode($ary_list);
    }


    $ary_list = array();
    $ary_list['isTrue'] = true;
    while( $row =  $stmt->fetch()){
      // var_dump($row);
      $ary_list['date'][] = array('id'=>$row['id'],'date'=>$row['date'],'items'=>$row['items'],'buy'=>$row['buy'],'receipt'=>$row['receipt'],'note'=>$row['note'],'user_id'=>$row['user_id']);
    }
    // var_dump($ary_list['date']);
    // exit;


    // $result_c = $db->query($str_sql_c);
    // $count = $db->fetch_array($result_c);
    // $ary_list['page_num'] = $count['C'];

    $sql_items = "SELECT  `items_id` ,  `items_list`
                FROM  `items`
                WHERE  `user_id` IN (0,?)
                AND `is_enabled` = 1";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bindValue(1, $_SESSION['id'], PDO::PARAM_INT);
    $result = $stmt_items->execute();
    $str_html = "";

    // $count = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
    while($count = $stmt_items->fetch()){
      $str_html .= "<option value = '".$count['items_id']."'>".$count['items_list']."</option>";
    }

    $ary_list['items'] = $str_html;

    $stmt_c = $conn->prepare($str_sql_c);#查詢筆數
    $result_c = $stmt_c->execute();
    $count =  $stmt_c->fetch();
    $ary_list['page_num'] = $count['C'];
    $PDO->closeConnection();
    return json_encode($ary_list);
  }
  #輸入關鍵字進行搜尋功能
  function reSet_RegexpString($value){
      $str = trim($value);
      $str = explode(" ", $str);
      $str_output='';

      for($i=1;$i<count($str);$i++){
      	if($str[$i]!=''){
      		$str_output=$str_output.'|'.addslashes($str[$i]);
      	}
      }
      $str_output=addslashes($str[0]).$str_output;
      return $str_output;
  }
}

?>
 <?php
        //     while( $row = $db->fetch_array($result)) {
        //         echo'
        //         <tr>
        //           <th scope="row"></th>
        //           <td><input style = "line-height: 100%;" type="date" id="date_'.$row['id'].'" value ="'.$row['date'].'" /></td>
        //           <td>
        //             <select id= "items_'.$row['id'].'" >
        //                 <option value = "1">食</option>
        //                 <option value = "2">衣</option>
        //                 <option value = "3">住</option>
        //                 <option value = "4">行</option>
        //                 <option value = "5">育</option>
        //                 <option value = "6">樂</option>
        //             </select>
        //             <script language="javascript">$("#items_'.$row['id'].'").val("'.$row['items'].'");</script>
        //           </td>
        //           <td>
        //             <input type = "text" id="buy_'.$row['id'].'" size = "10" value ="'.$row['buy'].'"/>
        //           </td>
        //           <td>
        //             <input type = "text" id="receipt_'.$row['id'].'" size = "10" value ="'.$row['receipt'].'"/>
        //           </td>
        //           <td>
        //             <input type = "textarea" id="note_'.$row['id'].'" size = "15" value ="'.$row['note'].'" />
        //           </td>
        //           <td>
        //             <button class="btn btn-warning" onClick="save('.$row['id'].');" >修改</button>
        //           </td>
        //           <td>
        //             <button class="btn btn-danger" onClick="remove_data('.$row['id'].');" >刪除</button>
        //             <input type = "hidden" id="user_'.$row['id'].'" value ="'.$row['user_id'].'" />
        //           </td>
        //         </tr>';
        //     }

        // $count = $db->fetch_array($result);
?>