<?php

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


