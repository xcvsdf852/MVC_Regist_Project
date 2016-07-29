<?php 
require_once("Connections/DB_Class.php");
?>


<?php
class isset_user {
    public $account;
    
    function check_account_isset(){
        // echo $this->account;
        // exit;
        if(isset($this->account)){
          $EmpAccount = $this->account;
             if (!preg_match('/^([.0-9a-z]+)@([0-9a-z]+).([.0-9a-z]+)$/i', $EmpAccount)){ //過濾Email;
                return '{"callback":0}';
             }
        //=====================================================================================
        //進行連線
        //=====================================================================================
        // $db = new DB();
        // $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $PDO = new myPDO();
        $conn = $PDO->getConnection();
        
        // $sql = sprintf("SELECT COUNT(*) AS C FROM `account` WHERE `account`.`ac_email`='%s'",$EmpAccount);
        // echo $sql;
        // exit;
        $sql = "SELECT COUNT(*) AS C FROM `account` WHERE `account`.`ac_email`= ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $EmpAccount, PDO::PARAM_STR);
        $result = $stmt->execute();
        $count = $stmt->fetch();
        
        // $result = $db->query($sql);
        // $count = $db->fetch_array($result);
        
        if($count['C'] >0 ){
            return '{"callback":0}';
        }
        else{
            return '{"callback":1}';
    	}
        // $db->closeDB();
        $PDO->closeConnection();
        }
    }
}
	


?>
