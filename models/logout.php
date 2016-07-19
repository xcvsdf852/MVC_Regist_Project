<?php
session_start();
class logout{
    
    function unset_session(){
        if(isset($_SESSION['EmpAccount']))
        {unset($_SESSION['EmpAccount']); }
        if(isset($_SESSION['nick_name']))
        {unset($_SESSION['nick_name']); }
        if(isset($_SESSION['IsAdmin']))
        {unset($_SESSION['IsAdmin']); }
        if(isset($_SESSION['id']))
        {unset($_SESSION['id']); }
        if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
        
    }
}
?>