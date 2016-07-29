<?php

// $hostname = "10.0.0.240";
// $hostname = "localhost";
// $database = "homework";
// $username = "root";
// $password = "";
// $ERP_SQL = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 

// echo 'config page';

global $_DB;	
$_DB['host'] = "localhost";
$_DB['username'] = "root";
$_DB['password'] = "";
$_DB['dbname'] = "homework";

class Config {
    
    public $db;
    
    function __construct(){

        /* 資料庫連線設定 */
        $this->db['host']       = 'localhost';
        $this->db['port']       = '3306';
        $this->db['username']   = 'root';
        $this->db['password']   = '';
        $this->db['dbname']     = 'homework';
        

    }
}
?>


