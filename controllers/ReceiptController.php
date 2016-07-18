<?php

class ReceiptController extends Controller {
    
     #顯示發票兌獎頁
    function Receipt_index(){ 
        $this->view("Receipt/receipt");
    }

}

?>