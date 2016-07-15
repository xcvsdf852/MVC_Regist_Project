<?php 
require_once("Connections/DB_Class.php");
?>


<?php
class isset_user {
    public $account;
    
    function check_account_isset(){
        // echo $this->account;
        // exit;
        require_once("Connections/DB_config.php"); 
        if(isset($this->account)){
          $EmpAccount = $this->account;
             if (!preg_match('/^([.0-9a-z]+)@([0-9a-z]+).([.0-9a-z]+)$/i', $EmpAccount)){ //過濾Email;
                echo '{"callback":0}';
                exit();
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
        //=====================================================================================
        //讀出資料並將資料編成HTML碼的字串
        //如果讀出的資料為0筆也會輸出沒內容的HTML碼字串
        //最後將字串顯示於頁面
        //=====================================================================================
        $sql = sprintf("SELECT COUNT(*) AS C FROM `account` WHERE `account`.`ac_email`='%s'",$EmpAccount);
        // echo $sql;
        // exit;
        
        $result = $db->query($sql);
        $count = $db->fetch_array($result);
        
        // $result = mysql_query($sql) or die(mysql_error);    
        // $count = mysql_fetch_assoc($result);
        
        if($count['C'] >0 ){
            echo '{"callback":0}';
        }
        else{
        	echo '{"callback":1}';
        	}
        // mysql_close ($conn);
        }
    }
}
	


?>
