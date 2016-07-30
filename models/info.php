<?php
session_start();
class info{
    function session_info(){
        return json_encode($_SESSION);
    }
}

?>