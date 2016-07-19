<?php
// session_start(); 
// if(isset($_SESSION['id']) && isset($_SESSION['EmpAccount']) && isset($_SESSION['IsAdmin']))
// {
//     if($_SESSION['IsAdmin']==1){$user="admin";}
//     else{$user="user";}
// }else{

//     echo "<script type='text/javascript'>alert('尚未登入');</script>";
//     // echo "<script type='text/javascript'>document.location.href='ac_login.html'</script>";
//     echo "<script type='text/javascript'>document.location.href='/homework0721_MVC/Account/login'</script>";
// }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/homework0721_MVC/views/css/bootstrap.min.css" rel="stylesheet">
  <title>Lab - index</title>
  <style type="text/css">
    .table-hover tbody tr:hover > th {
      background-color:  #b3ffff;
    }
  </style>
    <script src="/homework0721_MVC/views/js/jquery.js"></script>
    <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
    <link href="/homework0721_MVC/views/css/bootstrap-dialog.min.css" rel="stylesheet">
    <script type="text/javascript" src="/homework0721_MVC/views/js/bootstrap-dialog.min.js"></script>
    <script src="/homework0721_MVC/views/js/highcharts.js"></script>
    <script src="/homework0721_MVC/views/js/exporting.js"></script>
    <script type="text/javascript">

    
        $(document).ready(function () {
            
            function search_post(){
                time_str = $("#time_str").val();
                time_end = $("#time_end").val();user_id
                user_id = $("#user_id").val();
                // console.log(time_str);
                
                if(time_str !="" && time_end =="" || time_str =="" && time_end !=""){
                  BootstrapDialog.show({
                        title: 'Oops 系統發生錯誤!',
                        message: "注意起訖時間都必須填寫!!"
                  }).setType(BootstrapDialog.TYPE_DANGER);;
                  return false;
                }
                
                if(Date.parse(time_str).valueOf() > Date.parse(time_end).valueOf()){
                  // alert("注意開始時間不能晚於結束時間！");
                  BootstrapDialog.show({
                        title: 'Oops 系統發生錯誤!',
                        message: "注意開始時間不能晚於結束時間!!"
                  }).setType(BootstrapDialog.TYPE_DANGER);;
                  return false;
                }
                
                $.post("/homework0721_MVC/models/statistics_json.php",{"time_str":time_str,"time_end":time_end,"user_id":user_id},function(d){
                    // console.log(d);
                    if(d.isTrue){
                        $('#container').highcharts({
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: '你的錢究竟花去哪了?!',
                                style:{ "color": "#ff1a1a", "fontSize": "30px" }
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: false
                                    },
                                    showInLegend: true
                                }
                            },
                            series: [{
                                name: 'Brands',
                                colorByPoint: true,
                                data:d.data
                            }]
                         });
                    }else{
                        BootstrapDialog.show({
                            title: 'Oops 系統發生錯誤!',
                            message: d.data
                        }).setType(BootstrapDialog.TYPE_DANGER);;
                        
                    }
                 },'json');
                    
                     
            }
            $("text .highcharts-title").css("color","yellow");
            $("text").hide();
            search_post();
            $("#search").click(function(){search_post()});
        });
            
      
        
        
        
  </script>
  
</head>
<body>
<?php include_once('views/header.html');?>



<!----搜尋功能開始---->
<div class = "row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div>
      <input style = "line-height: 100%;" type="date" id="time_str" value ="<?php echo date("Y-m-d",strtotime("-1 month")); ?>"> ~ 
      <input style = "line-height: 100%;" type="date" id="time_end" value ="<?php echo date("Y-m-d"); ?>">
      <input type = "hidden" id="user_id" value =<?php echo $_SESSION['id']; ?> />
          <button class = "btn btn-success" style = "float:right" id="search"><span class ="glyphicon glyphicon-log-in"></span><span style = "margin:0px 0px 15px 10px; ">送出</span></button>
    </div>

    </div>
  <div class="col-md-3"></div>
</div>
<!----搜尋功能開始---->

<!----消費清單列表開始---->

      <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

<!----消費清單列表結束---->


</div>




</body>
</html>
