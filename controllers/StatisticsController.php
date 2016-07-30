<?php

class StatisticsController extends Controller {
    
     #顯示統計圖表頁
    function Statistics_index(){ 
        $this->view("Statistics/statistics");
    }
    
    function Paint_Pie(){
        $user = $this->model("statistics_json");
        $user->POST_data = $_POST;
        // var_dump($user->POST_data);
        // exit;
        $json_return = $user->get_pie_data();
        $this->view("show_json",$json_return);
        
    }

}

?>