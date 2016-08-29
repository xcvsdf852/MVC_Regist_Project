<?php

class RegistController extends Controller {

    #顯示記帳頁面
    function regist_index(){
        $this->view("Regist/regist_index");
    }

    #取得消費項目
    function get_items(){
        $user = $this->model("items_list");
        $json_return = $user->get_items_list();
        $this->view("show_json",$json_return);
    }

    #新增消費紀錄
    function insert_charge(){
        $user = $this->model("add_charge");
        $user->POST_data = $_POST;
        // var_dump($user->POST_data);
        // exit;
        $arry_return = $user->charge();
        // var_dump($arry_return);
        if($arry_return['isTrue']){
            $this->view("Regist/regist_index",$arry_return);//登入成功要導入記帳頁面
        }else{
            $this->view("Regist/regist_index",$arry_return);//導回首頁
        }
    }
    #顯示記帳紀錄
    function show_list(){
        $this->view("Regist/regist_list_index");
    }

    #搜尋消費紀錄
    function search(){
        $user = $this->model("regist_list");
        $user->POST_data = $_POST;
        $json_return = $user->search_regist_list();
        $this->view("show_json",$json_return);
    }
    #修改
    function list_save(){
        $user = $this->model("regist_list_save");
        $user->POST_data = $_POST;
        $json_return = $user->regist_update();
        $this->view("show_json",$json_return);
    }
    #刪除
    function list_delete(){
        $user = $this->model("regist_list_delete");
        $user->POST_data = $_POST;
        $json_return = $user->regist_delete();
        $this->view("show_json",$json_return);
    }

}

?>