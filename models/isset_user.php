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
        $db = new DB();
        $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        
        $sql = sprintf("SELECT COUNT(*) AS C FROM `account` WHERE `account`.`ac_email`='%s'",$EmpAccount);
        // echo $sql;
        // exit;
        
        $result = $db->query($sql);
        $count = $db->fetch_array($result);
        
        if($count['C'] >0 ){
            echo '{"callback":0}';
        }
        else{
        	echo '{"callback":1}';
        	}
        $db->closeDB();
        }
    }
}
	


?>
