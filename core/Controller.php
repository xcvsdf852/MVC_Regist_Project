<?php
session_start();
class Controller {
    public function model($model) {
        require_once "../homework0721_MVC/models/$model.php";
        return new $model ();
    }
    public function view($view, $data = Array()) {
        require_once "../homework0721_MVC/views/$view.php";
    }
}

?>