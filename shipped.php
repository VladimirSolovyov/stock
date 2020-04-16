<?php
    session_start();
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    { exit ("Страница не найдена!" ); } else {
        require_once 'connection.php';
        $table = "shipped";
        $conn = mysql_connect($host,$user,$password);
        mysql_select_db($db_name, $conn);
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/style.css" rel="stylesheet">
    <script>
        function sortWho(t){
            $(".td-who").find("a:not(:contains('"+t.trim()+"'))").parents("tr").css('display','none');
            $(".all-shiped").css('display','block');
        }
        function AllShipped() {
            location.reload();
        }

    $(document).ready(function(){
        $(function(){
            $("#from_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#to_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
        $('#filter').click(function(){
          var from_date = $("#from_date").val(),
              to_date = $("#to_date").val(),
              user_date = $("#user_date").val(),
              name_product = $("#id_name_product").val(),
              id_who = $("#id_who").val();


          if(from_date != '' && to_date != ''){
            $.ajax({
              url: "fetch.php",
              method: "POST",
              data:{from_date: from_date, to_date:to_date, user_date:user_date,name_product:name_product,id_who:id_who},
              success:function(data){
                    $('#order_table').html(data);
                    $('#report').show();
                    $('#filter').hide();
              }
            });
          }
          else alert("Выберите интревал!");
        });

        $('.reload-page').on('click', function(){
          location.reload();
        });

        $('#report').on('click',function(){
          report();
          $('#report').hide();
          $('#filter').show();
        })
    });

    function report(){
      var $shippedLst = $('.body-table tr'),
          arrayCode = []
          objectReport = [];
          commonAmount = 0;
          commonWeight = 0;
         // countObject = 0;

      for(var i = 0; i<$shippedLst.length; i++){
       var new_item = parseInt($shippedLst.eq(i).find('.code').text(),10);
       if (arrayCode.indexOf(new_item) === -1) {
         // Здесь кладём новую запись в объект
          arrayCode.push(new_item); 
          objectReport.push({
            "name":$shippedLst.eq(i).find('.name').text(),
            "code":parseInt($shippedLst.eq(i).find('.code').text(),10),
            "amount":parseInt($shippedLst.eq(i).find('.amount').text(),10),
            "weight":$shippedLst.eq(i).find('.weight').text()            
            });

            commonAmount += parseInt($shippedLst.eq(i).find('.amount').text(),10);
            commonWeight += parseInt($shippedLst.eq(i).find('.weight').text(),10)*parseInt($shippedLst.eq(i).find('.amount').text(),10);
         // countObject++;
        } else {
         // Здесь будем увеличивать amount
            for(var j = 0; j<objectReport.length; j++) {
              if(objectReport[j]["code"] === new_item) {
                objectReport[j]["amount"] += parseInt($shippedLst.eq(i).find('.amount').text(),10);
                commonAmount += parseInt($shippedLst.eq(i).find('.amount').text(),10);
                commonWeight += parseInt($shippedLst.eq(i).find('.weight').text(),10)*parseInt($shippedLst.eq(i).find('.amount').text(),10);
                break;
              }
            }
        }               
      }

      console.log(objectReport);
      console.log("Общее количество товаров: " + commonAmount);
      console.log("Общий вес товаров: "+ commonWeight);
      var objectCommon= { 'amountAll':commonAmount,'weightAll':commonWeight };

      $.ajax({
        type:'POST',
        url:'report.php',
        dataType:'json',
        data:{param:JSON.stringify(objectReport), common:JSON.stringify(objectCommon)},
      }).done(function(){
          window.location.href="http://a0144913.xsph.ru/Report.xls";
});
    }
    </script>
    <style>
        .nav>li.all-shiped {
          display:none;
          border: 2px solid #337ab7;
        }
    </style>
  </head>

  <body>
  <div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h3>Отгрузка</h3>
        </div>
        <div class="col-sm-4">
            <label for="user">Пользовватель: </label>
            <span><?php echo($_SESSION['fullname']); ?></span>
            <p><a href='viiti.php' class="btn btn-danger" style="float: right;">Выйти</a></p>
        </div>
    </div>
    <div class="row">
       <div class="span12">
          <?php include 'menu.php'; ?>
       </div>
    </div>
     <div id="filter-panel" class="collapse filter-panel" style="padding: 10px 0;">
        <h3>Фильтрация данных</h3>
        <div class="row">
            <div class="input-datarange">
                <div class="col-md-4">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Дата начало" />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to" id="to_date" class="form-control" placeholder="Дата окончания" />
                </div>
            </div>
            <div class="col-md-4">
                <input type="text" name="name_product" id="id_name_product" class="form-control" placeholder="Название продукта" />
            </div>
        </div>
        <div class="row" style="padding-top:5px;">
            <div class="col-md-4">
                <input type="text" name="who_shipped" id="id_who" class="form-control" placeholder="Кому отгружаем" />
            </div>
            <div class="col-md-4">
                    <select class="custom-select mr-sm-2 form-control" id="user_date">
                        <option value="" selected>Кто отгружал</option>
                        <option value="Igor">Igor</option>
                        <option value="Oleg">Oleg</option>
                    </select>
            </div>
            <div class="col-md-4">
                <input type="button" name="filter" id="filter" value="Фильтровать" class="btn btn-info" />
                <input type="button" name="report" style="display:none;" id="report" value="Отчёт" class="btn btn-success" />
                <button type="button" class="btn btn-secondary reload-page">Сбросить фильтр</button>
             </div>
        </div>
     </div>
     <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#filter-panel">
                 <span class="glyphicon glyphicon-filter"></span> Фильтр
     </button>
        <div class="row">
        <div class="span12" id="order_table">
          <?php

 $qr_result = mysql_query("SELECT name,weight,amount,code,date,who_shipped,user FROM ".$table." WHERE  `date` > DATE_ADD(NOW(), INTERVAL -30 DAY) ORDER BY `date` DESC");/* LIMIT 10*/
  echo '<table class="table">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Название</th>';
  echo '<th>Вес(кг/л)</th>';
  echo '<th>Количество</th>';
  echo '<th>Кому отгружаем</th>';
  echo '<th>Код товара</th>';
  echo '<th>Дата</th>';
  echo '<th>Кто отгружал</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="body-table">';

  while($data = mysql_fetch_array($qr_result)){ 

    echo '<tr>';

    echo '<td class="name">' . $data['name'] . '</td>';

    echo '<td class="weight">' . $data['weight'] . '</td>';

    echo '<td class="amount">' . $data['amount'] . '</td>';

    echo '<td class="td-who"><a href="#" onclick="sortWho(\''. $data['who_shipped'] .'\');">'. $data['who_shipped'] .'</a></td>';

    echo '<td class="code">' . $data['code'] . '</td>';

    echo '<td>' . $data['date'] . '</td>';

    echo '<td>' . $data['user'] . '</td>';

    echo '</tr>';

  }

  

  echo '</tbody>';

  echo '</table>';

?>

        </div>

      </div>



      <div class="row" style="display:none;">

        <div class="col-sm-4">

            <button class="btn btn-primary">Показать все отгрузки</button>

        </div>

      </div>

    </div>

  </body>
<?php } ?>