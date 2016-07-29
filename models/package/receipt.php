<?php
class receipt{
    public $isTrue;
    public $id; //db_id
    public $number; //發票號碼
    public $award;  //獎項
    function __construct($isTrue,$id,$number,$award){
        $this->isTrue =$isTrue;
        $this->id = $id;
        $this->number = $number;
        $this->award = $award;
    }
    
    function toString(){
        return  $this->number.$this->award;
    }
}



// $receiptObj[] = new receipt($receipt, '3');
// var_dump($receiptObj);
// exit;
?>