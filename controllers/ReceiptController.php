<?php

class ReceiptController extends Controller {
    
     #顯示發票兌獎頁
    function Receipt_index(){ 
        $this->view("Receipt/receipt");
    }
    
    function check_numbers(){
        $user = $this->model("get_receipt");
        $user->data = $_POST['date'];
        $json_return = $user->get_db_check_numbers();
        $this->view("show_json",$json_return);
    }

}

?>