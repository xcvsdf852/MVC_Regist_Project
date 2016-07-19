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
  <script src="/homework0721_MVC/views/js/jquery.js"></script>
  <script src="/homework0721_MVC/views/js/bootstrap.min.js"></script>
  <link href="/homework0721_MVC/views/css/bootstrap-dialog.min.css" rel="stylesheet">
  <script type="text/javascript" src="/homework0721_MVC/views/js/bootstrap-dialog.min.js"></script>
  <title>Lab - index</title>
  <style type="text/css">
    .table-hover tbody tr:hover > th {
      background-color:  #b3ffff;
    }
  </style>
  <script type="text/javascript">
  $(document).ready(function(){
      list_load(1,5);
  });
  
  //載入列表頁
  function list_load(P,P_number){
  	var time_str=$("#time_str").val();
  	var time_end=$("#time_end").val();
  	var select_value=$("#select_value").val();
  	var text_value=$("#text_value").val();
  	
  	if(Date.parse(time_str).valueOf() > Date.parse(time_end).valueOf()){
      // alert("注意開始時間不能晚於結束時間！");
      BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "注意開始時間不能晚於結束時間!!"
      }).setType(BootstrapDialog.TYPE_DANGER);;
      return false;
    }
  	
//   	$("#content").load("regist_list.php?P="+P+"&P_number="+P_number,{
    $("#content").load("/homework0721_MVC/models/regist_list.php?P="+P+"&P_number="+P_number,{
  		"time_str":time_str,
  		"time_end":time_end,
  		"select_value":select_value,
  		"text_value":text_value
  		},function(){
  		$("#P").val(P);
  		$("#P_number").val(P_number);
  		var c=$("#count").val();
  		$("#tage").load('/homework0721_MVC/models/package/Tage.php?P='+P+'&P_number='+P_number+'&count_num='+c+'&function=list_load');
  	});
  }

  
  function save(id){
    var date=$("#date_"+id).val();
    var items=$("#items_"+id).val();
    var buy=$("#buy_"+id).val();
  	var receipt = $("#receipt_"+id).val();
  	var note = $("#note_"+id).val();
    var user = $("#user_"+id).val();
    if(date == ""){
      // alert("日期不能是空白");
      BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "日期不能是空白!!"
      }).setType(BootstrapDialog.TYPE_DANGER);
      $("#data_"+id).focus();
      return false;
    }
    if(buy == ""){
      // alert("金額不能空白");
      BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "金額不能空白!!"
      }).setType(BootstrapDialog.TYPE_DANGER);
      $("#buy_"+id).focus();
       return false;
    }
    if(buy <= 0){
      // alert("金額不能小於零");
       BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "金額不能小於零!!"
      }).setType(BootstrapDialog.TYPE_DANGER);
       $("#buy_"+id).focus();
       return false;
    }
   if($("#receipt_"+id).val() != ""){
      var receipt=$("#receipt_"+id).val()
      if(receipt.length != 8){
         BootstrapDialog.show({
          title: 'Oops 系統發生錯誤!',
          message: "發票號碼長度錯誤唷!!"
          }).setType(BootstrapDialog.TYPE_DANGER);
         $("#receipt_"+id).focus();
         return false;
      }        
    }
  	
//   	$.post('regist_list_save.php',{
    $.post('/homework0721_MVC/models/regist_list_save.php',{
  		"id":id,
  		"date":date,
  		"items":items,
  		"buy":buy,
  		"receipt":receipt,
  		"note":note,
  		"user":user
  	},function(data){
  		if(data.isTrue==1){
  		// 	alert('更新成功!');
  			BootstrapDialog.show({
            title: '執行操作成功!',
            message: "更新成功!!"
        }).setType(BootstrapDialog.TYPE_SUCCESS);
  			list_load($("#P").val(),$("#P_number").val());
  		}else{
  		// 	alert('更新失敗!\r\n'+data.data);
  			BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: '更新失敗!\r\n'+data.data
        }).setType(BootstrapDialog.TYPE_DANGER);
  		}
  	},'json');
  	
  }
  
  //編輯刪除
  function remove_data(id){
  	var datetime = $("#date_"+id).val();
  	var buy = $("#buy_"+id).val();
  	var user = $("#user_"+id).val();
  	var isdelete = false;

  // 	if(!confirm("確定要刪除"+datetime+buy+"?(刪除後無法復原!!)")){
  // 		return;
  // 	}
  
  	BootstrapDialog.show({
            title: 'Oops 警告!',
            message: "確定要刪除"+datetime+"金額:"+buy+"?(刪除後無法復原!!)",
            buttons: [{
                label: '確認',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    // isdelete = true;
                     remove_post(id,user);
                    dialogItself.close();
                }
            }, {
                label: '取消',
                cssClass: 'btn-danger',
                action: function(dialogItself){
                    // isdelete = false;
                    dialogItself.close();
                }
            }]
      }).setType(BootstrapDialog.TYPE_WARNING);
  	 
  // 	if(!isdelete){
  // 	  return;
  // 	}
  	
  	
  }
function  remove_post(id,user){
  	$.post('/homework0721_MVC/models/regist_list_delete.php',{"id":id,"user_id":user},function(date){
//   	$.post('Regist/list_delete',{"id":id,"user_id":user},function(date){
  		if(date.isTrue==1){
  		// 	alert('刪除成功');
  			BootstrapDialog.show({
            title: '執行操作成功!',
            message: "刪除成功!!"
       }).setType(BootstrapDialog.TYPE_SUCCESS);
  			list_load($("#P").val(),$("#P_number").val());
  		}else{
  		  // alert('刪除失敗!\n\r'+date.data);
  		  BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "刪除失敗!!"
       }).setType(BootstrapDialog.TYPE_DANGER);
  		  
  		}
  	},'json');
}
  </script>
</head>
<body>
<?php include_once('views/header.html');?>



<!----搜尋功能開始---->
<div class = "row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div>
      <input style = "line-height: 100%;" type="date" name ="time_str" id ="time_str"> ~ 
      <input style = "line-height: 100%;" type="date" name ="time_end" id = "time_end">
      <select name = "select_value" id = "select_value">
        <option value = ""></option>
        <option value = "1">食</option>
        <option value = "2">衣</option>
        <option value = "3">住</option>
        <option value = "4">行</option>
        <option value = "5">育</option>
        <option value = "6">樂</option>
      </select>
      <input style = "line-height: 100%;" type="text" name ="text_value" id="text_value"  placeholder="輸入關鍵字">
          <button onclick="list_load(1,5);" class = "btn btn-success" style = "float:right" ><span class ="glyphicon glyphicon-log-in"></span><span style = "margin:0px 0px 15px 10px; ">送出</span></button>
    </div>

    </div>
  <div class="col-md-3"></div>
</div>
<!----搜尋功能開始---->

<!----消費清單列表開始---->
<div class = "row">
  <div class="col-md-2">
  </div>
  <div class="col-md-7">
<!----------內容位置-------------->
    <div style="width:100%;" id="content">
    
    </div>
    
    
    <div class="pagination" id="tage" align="center" style="width:100%;">
    
    </div>
    
    
<!----------內容位置結束-------------->
  </div>
  <div class="col-md-3">
  </div>
</div>


<!----消費清單列表結束---->

<input type="hidden" id="P" value="1" />
<input type="hidden" id="P_number" value="5" />




</body>
</html>
