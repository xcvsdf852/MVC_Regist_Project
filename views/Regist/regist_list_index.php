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

      $.get("get_items",function(d){
        i=0;
        $.each(d,function(){
          $("#select_value").append("<option value = "+d[i].items_id+">"+d[i].items_list+"</option>")
          i++;
        })
      })

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
  	 $.post("search",{
  	  "P":P,
  	  "P_number":P_number,
  		"time_str":time_str,
  		"time_end":time_end,
  		"select_value":select_value,
  		"text_value":text_value
  		},function(d){
  		  console.log(d);
  		  if(d.isTrue){
    		  i=0;
    		  $("#content").html("");
    		  $.each(d.date,function(){
    		    $("#content").append(
      		      '<tr>'
                      +'<th scope="row"></th>'
                      +'<td><input style = "line-height: 100%;" type="date" id="date_'+d.date[i].id+'" value ="'+d.date[i].date+'" /></td>'
                      +'<td>'
                        +'<select id= "items_'+d.date[i].id+'" >'
                            +d.items
                        +'</select>'
                      +'</td>'
                      +'<td>'
                        +'<input type = "text" id="buy_'+d.date[i].id+'" size = "10" value ="'+d.date[i].buy+'"/>'
                      +'</td>'
                      +'<td>'
                        +'<input type = "text" id="receipt_'+d.date[i].id+'" size = "10" value ="'+d.date[i].receipt+'"/>'
                      +'</td>'
                      +'<td>'
                       +'<input type = "textarea" id="note_'+d.date[i].id+'" size = "15" value ="'+d.date[i].note+'" />'
                      +'</td>'
                      +'<td>'
                        +'<button class="btn btn-warning" onClick="save('+d.date[i].id+');" >修改</button>'
                      +'</td>'
                      +'<td>'
                        +'<button class="btn btn-danger" onClick="remove_data('+d.date[i].id+');" >刪除</button>'
                        +'<input type = "hidden" id="user_'+d.date[i].id+'" value ="'+d.date[i].user_id+'" />'
                      +'</td>'
                    +'</tr>'
              );
              $("#items_"+d.date[i].id).val(d.date[i].items);
              i++;
    		    });
  		  }else{
  		    BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: d.mesg
          }).setType(BootstrapDialog.TYPE_DANGER);;
          return false;
  		  }

    		$("#P").val(P);
    		$("#P_number").val(P_number);
    		// var c=$("#count").val();
    		var c=d.page_num;
    		$("#tage").load('/homework0721_MVC/models/package/Tage.php?P='+P+'&P_number='+P_number+'&count_num='+c+'&function=list_load');
  	  },"json");
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
          // alert("發票號碼長度錯誤唷!!");
          BootstrapDialog.show({
          title: 'Oops 系統發生錯誤!',
          message: "發票號碼長度錯誤唷!!"
          }).setType(BootstrapDialog.TYPE_DANGER);
         $("#receipt_"+id).focus();
         return false;
      }
    }


    $.post('list_save',{
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

   	// if(!confirm("確定要刪除"+datetime+"，金額"+buy+"?(刪除後無法復原!!)")){
   	// 	return;
   	// }
    // remove_post(id,user);

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
  }
function  remove_post(id,user){
  	$.post('list_delete',{"id":id,"user_id":user},function(date){
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
<?php require_once('views/header.html');?>



<!----搜尋功能開始---->
<div class = "row">
  <div class="col-md-2"></div>
  <div class="col-md-7">
    <div>
      <input style = "line-height: 100%;" type="date" name ="time_str" id ="time_str"> ~
      <input style = "line-height: 100%;" type="date" name ="time_end" id = "time_end">
      <select name = "select_value" id = "select_value">
        <option value = ""></option>
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
      <table class="table table-hover">
        <thead class="thead-inverse">
          <tr>
            <th>#</th>
            <th>消費日期</th>
            <th>項目</th>
            <th>消費金額</th>
            <th>統一發票</th>
            <th>備註</th>
            <th>修改</th>
            <th>刪除</th>
          </tr>
        </thead>
        <tbody id="content">

        </tbody>
      </table>
      <input type="hidden" id="count" value="">
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
