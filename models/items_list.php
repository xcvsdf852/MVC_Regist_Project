<?php
session_start();
require_once("Connections/DB_Class.php");

class items_list
{
    function get_items_list()
    {
        $PDO = new myPDO();
        $conn = $PDO->getConnection();

        $sql = "SELECT  `items_id` ,  `items_list`
                FROM  `items`
                WHERE  `user_id` IN (0,?)
                AND `is_enabled` = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $_SESSION['id'], PDO::PARAM_INT);
        $result = $stmt->execute();
        $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($count);
        return json_encode($count);
    }
}

// $t = new items_list;
// $t->get_items_list();
