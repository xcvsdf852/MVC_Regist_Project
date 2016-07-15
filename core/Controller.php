<?php
session_start();
class Controller {
    public function model($model) {
        require_once "../homework0721_MVC/models/$model.php";
        return new $model ();
    }
    public function view($view, $data = Array()) {
        require_once "../homework0721_MVC/views/$view.php";
        // $_SESSION['data'] = $data;
        // var_dump($_SESSION['data']);
        // array(2) { 'Error' => string(53) "登入失敗請檢查登入帳號密碼是否正確!!" 'data' => array(3) { 'isTrue' => bool(false) 'errorCod' => int(6) 'mesg' => string(19) "資料傳輸有誤!" } }
    }
}

?>