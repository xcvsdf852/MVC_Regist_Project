<?php
// session_start(); 
// if(isset($_SESSION['id']) && isset($_SESSION['EmpAccount']) && isset($_SESSION['IsAdmin']))
// {
//     if($_SESSION['IsAdmin']==1){$user="admin";}
//     else{$user="user";}
// }else{
//     echo "<script type='text/javascript'>alert('尚未登入');</script>";
//      // echo "<script type='text/javascript'>document.location.href='ac_login.html'</script>";
//     echo "<script type='text/javascript'>document.location.href='/homework0721_MVC/Account/login'</script>";
// }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/homework0721_MVC/views/css/bootstrap.min.css" rel="stylesheet">
  <script src="/homework0721_MVC/views/js/jquery.js"></script>
  <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
  <link href="/homework0721_MVC/views/css/bootstrap-dialog.min.css" rel="stylesheet">
  <script type="text/javascript" src="/homework0721_MVC/views/js/bootstrap-dialog.min.js"></script>
  <title>Lab - index</title>
 
  <script type="text/javascript">
  $(document).ready(function(){
    var today = new Date();
    // today_year = today.getFullYear()+1; //西元年份
    // today_month = today.getMonth()-4; //一年中的第幾月
    // today_date = today.getDate(); //一月份中的第幾天
    // var CurrentDate = today_year+"-"+today_month+"-"+today_date;
    // alert(CurrentDate);
    if((Date.parse(today.getFullYear()+"-03-25")).valueOf() < (Date.parse(today)).valueOf() 
    && (Date.parse(today.getFullYear()+"-07-05")).valueOf() > (Date.parse(today)).valueOf()){
        $("#select").append('<button class="btn btn-warning" onclick="check_receipt('+getCurrentYear()+'01)">1-2月份</button>');
    }
    if((Date.parse(today.getFullYear()+"-05-25")).valueOf() < (Date.parse(today)).valueOf() 
    && (Date.parse(today.getFullYear()+"-09-05")).valueOf() > (Date.parse(today)).valueOf()){
        $("#select").append('<button class="btn btn-warning" onclick="check_receipt('+getCurrentYear()+'03)">3-4月份</button>');    }
    
    if((Date.parse(today.getFullYear()+"-07-25")).valueOf() < (Date.parse(today)).valueOf() 
    && (Date.parse(today.getFullYear()+"-11-05")).valueOf() > (Date.parse(today)).valueOf()){
        $("#select").append('<button class="btn btn-warning" onclick="check_receipt('+getCurrentYear()+'05)">5-6月份</button>');
    }
    if((Date.parse(today.getFullYear()+"-09-25")).valueOf() < (Date.parse(today)).valueOf() 
    && (Date.parse((today.getFullYear()+1)+"-01-05")).valueOf() > (Date.parse(today)).valueOf()){
        $("#select").append('<button class="btn btn-warning" onclick="check_receipt('+getCurrentYear()+'07)">7-8月份</button>');
    }
    if((Date.parse(today.getFullYear()+"-11-25")).valueOf() < (Date.parse(today)).valueOf() 
    && (Date.parse((today.getFullYear()+1)+"-03-05")).valueOf() > (Date.parse(today)).valueOf()){
        $("#select").append('<button class="btn btn-warning" onclick="check_receipt('+getCurrentYear()+'09)">9-10月份</button>');
    }
    if((Date.parse((today.getFullYear()+1)+"-01-25")).valueOf() < (Date.parse(today)).valueOf() 
    && (Date.parse((today.getFullYear()+1)+"-05-05")).valueOf() > (Date.parse(today)).valueOf()){
        $("#select").append('<button class="btn btn-warning" onclick="check_receipt('+(getCurrentYear()-1)+'11)">11-12月份</button>');
    }
    
  });
  
    //取得今年民國年  
     function getCurrentYear(){ 
        var date = new Date();  
        return date.getFullYear() - 1911;    
     } 
    
    // function check_receipt(d){
    //     $.post("package/get_receipt.php",
    //         {"date":d},
    //         function(result){
    //             if(result.isTrue == 1){
    //                 i=0;
    //                 $.each(result.data, function(i){
    //                     console.log(result.data[i]);
    //                     $("#content").append('<p>'+result.data[i]+'</p>');
    //                     i++;
    //                 });
                    
    //             }else if(result.isTrue == 2){
    //                 $("#content").append('<p>'+result.data+'</p>');
    //             }else{
    //                 BootstrapDialog.show({
    //                     title: 'Oops 系統發生錯誤!',
    //                     message: result.data
    //                 }).setType(BootstrapDialog.TYPE_DANGER);
    //             }
    //         },"json");
    // }
    
    function check_receipt(d){
        $.post("/homework0721_MVC/models/get_receipt.php",
            {"date":d},
            function(result){
               i=0;
                    $.each(result.data, function(i){
                         if(result.isTrue == 1){
                            
                            console.log(result.data[i]);
                            $("#content").append('<p>'+result.data[i]+'</p>');
                            i++;
                        }else{
                                BootstrapDialog.show({
                                    title: 'Oops 系統發生錯誤!',
                                    message: result.data
                                }).setType(BootstrapDialog.TYPE_DANGER);
                           }           
                        });
                    
                
            },"json");
    }
   
    
  </script>
</head>
<body>
<?php include_once('views/header.html');?>



<!----搜尋功能開始---->
<div class = "row">
  <div class="col-md-3"></div>
    <div class="col-md-6">
        <div id = "select"></div>

    </div>
  <div class="col-md-3"></div>
</div>
<!----搜尋功能開始---->

<!----消費清單列表開始---->
<div class = "row">
  <div class="col-md-3">
  </div>
  <div class="col-md-6">
<!----------內容位置-------------->
    <hr>
    <div style="width:100%;" id="content">
    
    </div>
    
    
    
<!----------內容位置結束-------------->
  </div>
  <div class="col-md-3">
  </div>
</div>


<!----消費清單列表結束---->

<!--<input type="hidden" id="date" value="" />-->





</body>
</html>