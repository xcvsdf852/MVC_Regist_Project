<?php

class testController extends Controller {
    
    function name($firname,$lesname) {
        echo "firname:".$firname.$lesname;
    }
    function testhello($name) { //針對Controller 裡面的model"../EasyMVC/models/$model.php";
        $user = $this->model("User");
        $user->name = $name;
        $this->view("Home/hello", $user);
        // echo "Hello! $user->name";
    }
    
}

?>