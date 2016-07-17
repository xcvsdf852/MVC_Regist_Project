<?php

class RegistController extends Controller {
    
     #顯示修改密碼頁
    function regist_index(){ 
        $this->view("Regist/regist_index");
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
             echo '<script>alert("紀錄新增成功!");</script>';
            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
            $this->view("Regist/regist_index");//登入成功要導入記帳頁面
        }else{
            echo '<script>alert("'.$arry_return['mesg'].'");</script>';
            $this->view("Regist/regist_index");//導回首頁
        }
    }
    
    function show_list(){
        $this->view("Regist/regist_list_index");
    }
    
    #刪除紀錄 
    // function  list_delete(){
      
    //     $user = $this->model("regist_list_delete");
    //     $user->id = $_POST['id'];
    //     $user->user_id = $_POST['user_id'];
        
    // }
}

?>