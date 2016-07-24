<?php

class StatisticsController extends Controller {
    
     #顯示統計圖表頁
    function Statistics_index(){ 
        $this->view("Statistics/statistics");
    }

}

?>