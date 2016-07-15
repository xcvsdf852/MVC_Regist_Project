<?php

class HomeController extends Controller {
    
    function index($firname,$lesname) {
        echo "home page of HomeController<br>";
        echo "firname:".$firname.$lesname;
    }
    
    function hello($name) { //針對Controller父 裡面的model"../EasyMVC/models/$model.php";
        $user = $this->model("User");//使用mldwls底下的User，New一個User物件
        $user->name = $name;
        $this->view("Home/hello", $user);
        // echo "Hello! $user->name";
    }
    function test($name) { //針對Controller父 裡面的model"../EasyMVC/models/$model.php";
        $user = $this->model("user_insert");//使用mldwls底下的User，New一個User物件
        $user->name = $name;
        $this->view("Home/test", $user);//是View底下的路徑
        // echo "Hello! $user->name";
    }
}





?>