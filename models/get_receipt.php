<?php
session_start(); 
require_once("Connections/DB_Class.php");
require_once('package/str_sql_replace.php'); 
require_once('package/get_IP.php'); 
require_once('package/receipt.php'); 

// var_dump($_POST);
// exit;
// { 'date' => string(5) "10503" }
// $_POST["date"] = "10505";

// $receipt = "08513139";
// var_dump($num);
// exit;
// echo $num[0];//特別獎 Special_Award
// echo $num[1];//特獎  Special
// echo $num[2];//頭獎  First
// echo $num[3];//增開六獎 Six

// 0=>18498950
// 1=>08513139
// 2=>21881534、53050416、85174778
// 3=>086


class get_receipt{
    public $data;
    public $Award = array(  "1"=> "特別獎 壹仟萬元",
                            "2"=> "特獎 貳佰萬元",
                            "3"=> "第六獎 貳佰元",
                            "4"=> "第五獎 壹仟元",
                            "5"=> "第四獎 肆仟元",
                            "6"=> "第三獎 壹萬元",
                            "7"=> "第二獎 肆萬元",
                            "8"=> "頭獎 貳佰萬元"
                        );
    #讀取資料庫發票與網頁資料對獎
    function get_db_check_numbers(){
        #項目檢查 數字型態
        if( !isset($this->data) || empty($this->data))
        {
            $return_temp['isTrue'] = 0;
            $return_temp['data'][]= "資料傳輸失敗!";
            return json_encode($return_temp);
        }
        $date = str_SQL_replace($this->data);
        if(!filter_var($date, FILTER_VALIDATE_INT)){
            $return_temp['isTrue'] = 0;
            $return_temp['data'][]= "資料格式不符!";
            return json_encode($return_temp);
        }
        $mon =  substr($date,-2); //取得月份
        $year =  substr($date,0,3); //取得年
        $AD_year = $year+1911;
        // echo $AD_year;
        // exit;
        
        $arry_date = $this->getdays("$AD_year-$mon-01");//Array ( [0] => 2016-03-01 [1] => 2016-04-30 )
        // print_r($arry_date);
        // exit;
        
        #擷取網址
        include_once('package/simple_html_dom.php');
        $html = file_get_html('http://www.etax.nat.gov.tw/etw-main/front/ETW183W2_'.$date.'/');
        $num = array();
        foreach($html->find('.t18Red') as $element){
            $num[] = trim($element->plaintext);//取純文字
        }
        $First = explode("、",$num[2]);//頭獎  First
        $six = explode("、",$num[3]);//增開六獎 Six
        $receiptObj= array();
        
        //=====================================================================================
        //開始資料庫內符合兌獎日期的發票號碼讀取進行兌獎
        //=====================================================================================
        // $sql =" SELECT id,receipt
        //         FROM  `charge` 
        //         WHERE 	is_enabled = '1'
        //         AND receipt <> ''
        //         AND user_id = '".$_SESSION['id']."'
        //         AND DATE_FORMAT(date,'%Y-%m-%d') BETWEEN '".$arry_date[0]."' AND '".$arry_date[1]."'";
        //  echo $sql;
        //  exit;
        $sql =" SELECT id,receipt
                FROM  `charge` 
                WHERE 	is_enabled = '1'
                AND receipt <> ''
                AND user_id = ?
                AND DATE_FORMAT(date,'%Y-%m-%d') BETWEEN ? AND ? ";
        
        //=====================================================================================
        //進行連線
        //=====================================================================================
        // $db = new DB();
        // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $PDO = new myPDO();
        $conn = $PDO->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $_SESSION['id']);
        $stmt->bindValue(2, $arry_date[0]);#起始日期
        $stmt->bindValue(3, $arry_date[1]);#迄日期
        $result = $stmt->execute();
        // $count = $stmt->fetch();
        // $result = $db->query($sql);
        
        $temp=array();
        
        while($row = $stmt->fetch()){
            $temp[] = $this->first_Award($row['id'],$row['receipt'],$First,$six,$num[0],$num[1]);//$num[0];特別獎$num[1];特獎
            // echo $row['id']."<br>";
            // echo $row['receipt']."<br>";
        }
        $return_temp=array();

        if(empty($temp)){
            $return_temp['isTrue'] = 1;
            $return_temp['data'][]= "無發票可兌獎";
            echo json_encode($return_temp);
            exit;
        }
        
        if($temp){
            foreach($temp as $Tval){
                    foreach($Tval as $value) {
                        $return_temp['isTrue'] = 1;
                        if($value->isTrue){
                            // var_dump($value);
                            $return_temp['data'][]= "中獎號碼 : ".$value->number."- 獎項 : ".$this->Award[$value->award];
                        }else{
                            $return_temp['data'][] = "未中獎號碼 : ".$value->number;
                            // echo json_encode($return_temp);
                        }
                    }
            }
            return json_encode($return_temp);
        }
        $PDO->closeConnection();
    }
    //$id 放發票號碼資料庫存放的ID   $receiptz 發票號碼 $First頭獎陣列 $six六獎陣列  特別獎 特獎
    function first_Award($id,$receipt,$First,$six,$Special_1,$Special_2){
        $temp = 0;
        foreach($First as $First_val){
            for($i=3; $i<=8; $i++){
                $n = $i * -1;
                if($i == 3){
                    foreach($six as $val_six){
                        // echo $val_six."<br>";
                        if($val_six == substr($receipt, $n)){
                            $temp = $i;
                            // echo $temp;
                        }
                    }
                }
                // echo substr($First_val, $n)."<br>";
                if(substr($First_val, $n) == substr($receipt, $n)){
                    $temp = $i;
                }
            }
        }
    
        if($Special_1 == $receipt){  //特別獎
            $temp = 1;
        }
        if($Special_2 == $receipt){  //特獎
            $temp = 2;
        }
    
        // echo $temp;
        if($temp != 0){
            // echo $temp."<br>";
            // echo $receipt;
            $receiptObj[] = new receipt(true, $id, $receipt, $temp);
            return $receiptObj;
        }else{
            // return false;
            $receiptObj[] = new receipt(false, $id, $receipt, $temp);
            return $receiptObj;
        }
        
    }
    #根據傳入的日期 取得該日期月份的第一天 以及該月份下個月份的最後一天。 
    function getdays($day){
    	$firstday = date('Y-m-01',strtotime($day));
    	$lastday = date('Y-m-d',strtotime("$firstday +2 month -1 day"));
    	return array($firstday,$lastday);
    }
}














// var_dump(empty($temp));//bool(true)
// exit;
// var_dump($temp);
// exit;

// var_dump($receiptObj);
// exit;

 
?>
