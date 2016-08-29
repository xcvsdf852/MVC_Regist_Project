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
      $.get("get_items",function(d){
        i=0;
        $.each(d,function(){
          $("#items_1").append("<option value = "+d[i].items_id+">"+d[i].items_list+"</option>")
          i++;
        })
      })

    })

    function check_value(){
      var arry_num = new Array();
      var ispass = true;
      $("#tbody tr").each(function(){
          arry_num.push($(this).attr("class"));
      });
      arry_num[0] = '1';
      // console.log(arry_num);
      $.each(arry_num, function(i, num){
        // console.log(num);
        $("#arry_num").val(arry_num);
        // console.log($("#data_"+num).val());
        if($("#data_"+num).val() == ""){
          // alert("日期不能是空白");
          BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "日期不能是空白!!"
            }).setType(BootstrapDialog.TYPE_DANGER);

           $("#data_"+num).focus();
           ispass = false;
           return false;
         }


        if($("#money_"+num).val() == ""){
          // alert("金額不能空白");
          BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "金額不能空白!!"
            }).setType(BootstrapDialog.TYPE_DANGER);

          $("#money_"+num).focus();
          ispass = false;
          return false;
        }
        if($("#money_"+num).val() <= 0){
          // alert("金額不能小於零");
          BootstrapDialog.show({
            title: 'Oops 系統發生錯誤!',
            message: "金額不能小於零!!"
          }).setType(BootstrapDialog.TYPE_DANGER);
          $("#money_"+num).focus();
          ispass = false;
          return false;
        }
        if($("#receipt_"+num).val() != ""){
          var receipt=$("#receipt_"+num).val()
          if(receipt.length != 8){
            // alert("發票號碼長度錯誤唷!!");
            BootstrapDialog.show({
              title: 'Oops 系統發生錯誤!',
              message: "發票號碼長度錯誤唷!!"
            }).setType(BootstrapDialog.TYPE_DANGER);
            $("#receipt_"+num).focus();
            ispass = false;
            return false;
          }
        }

      });

      if(ispass){
        document.getElementById("charge_form").submit();
      }

    }

    var tr_count = 1;
    function add(){
      tr_count++
      $("#tbody").append("<tr id ='row_"+tr_count+"' class= '"+tr_count+"'>"+$("#row_1").html()+"</tr>");
      // $('#row_'+tr_count+" th").text(tr_count);
      $('#row_'+tr_count+" button").attr("onclick","remov("+tr_count+")").show();

      $('#row_'+tr_count+" input").each(function(){
         var name = $(this).attr("name").split("_")[0];
         $(this).attr("name", name+"_"+tr_count);
      });
      $('#row_'+tr_count+" input").each(function(){
         var id = $(this).attr("id").split("_")[0];
         $(this).attr("id", id+"_"+tr_count);
      });

      $('#row_'+tr_count+" select").each(function(){
         var name = $(this).attr("name").split("_")[0];
         $(this).attr("name", name+"_"+tr_count);
      });
    }

    function remov(n){
      $('#row_'+n).remove();
    }
  </script>
  <?php
    if(!empty($data)){

        if($data['isTrue']){
            echo "<script>
                    $(document).ready(function(){
                      BootstrapDialog.show({
                        title: '執行操作成功!',
                        message: '".$data['mesg']."'
                      }).setType(BootstrapDialog.TYPE_SUCCESS);
                    });
                  </script>
                  ";
        }else{
            echo "<script>
                    $(document).ready(function(){
                        BootstrapDialog.show({
                          title: 'Oops 系統發生錯誤!',
                          message: '".$data['mesg']."'
                        }).setType(BootstrapDialog.TYPE_DANGER);
                    });
                  </script>
                  ";
        }
    }

    ?>
</head>
<body>

<?php require_once('views/header.html');?>

<div class = "row">
  <div class="col-md-2">
  </div>
  <div class="col-md-7">
    <form action = "/homework0721_MVC/Regist/insert_charge" method="post" id ="charge_form" >
      <table class="table table-hover">
        <thead class="thead-inverse">
          <tr>
            <th>#</th>
            <th>消費日期</th>
            <th>項目</th>
            <th>消費金額</th>
            <th>統一發票</th>
            <th>備註</th>
            <th>刪除</th>
          </tr>
        </thead>
        <tbody id="tbody">
          <tr name= "row_1" id = "row_1" clsaa ="1">
            <th scope="row" id = "1"></th>
            <td><input style = "line-height: 100%;" type="date" name = "data_1" id ="data_1" value ="" /></td>
            <td>
              <select  name = "items_1" id ="items_1">

              </select>
            </td>
            <td>
              <input type = "number" size = "10" name = "money_1" id ="money_1"m value = ''/>
            </td>
            <td>
              <input type = "number" size = "10" name = "receipt_1" id ="receipt_1"/>
            </td>
             <td>
              <input type = "textarea" size = "15"name ="note_1" id ="note_1" />
            </td>
            <td>
              <button class = "btn btn-danger" type="button"  style = "display:none">刪除</button>
            </td>
          </tr>

        </tbody>
      </table>
      <input name="arry_num" type="hidden" value="" id="arry_num" />
    </form>
  </div>
  <div class="col-md-3">
  </div>
</div>


<div class="col-md-3"></div>
<div class="col-md-6">
   <button class = "btn btn-info" onclick="add()"><span class ="glyphicon glyphicon-plus-sign"></span><span style = "margin:0px 0px 15px 10px; ">新增一筆</span></button>
   <button  onclick ="check_value()" class = "btn btn-success" style = "float:right" ><span class ="glyphicon glyphicon-log-in"></span><span style = "margin:0px 0px 15px 10px; ">送出</span></button>
</div>
<div class="col-md-3">

</div>



</div>
<button class = "btn btn-info" onclick="add()" style = "position:fixed; top:90%; left:80%;"><span class ="glyphicon glyphicon-plus-sign"></span><span style = "margin:0px 0px 15px 10px; ">新增一筆</span></button>
<button  onclick ="check_value()" class = "btn btn-success" style = "position:fixed; top:90%; left:90%;" ><span class ="glyphicon glyphicon-log-in"></span><span style = "margin:0px 0px 15px 10px; ">送出</span></button>



</body>
</html>
