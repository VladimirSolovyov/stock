<?php
session_start();
if (empty($_SESSION['login']) or empty($_SESSION['id']))
{
    exit ("Страница не найдена!" );
} else {
$host = "localhost";

$user = "a0144913_stock";

$password = "stock";

$db_name = "a0144913_stock";

$table = "shipped";



    $conn = mysql_connect($host,$user,$password);



    mysql_select_db($db_name, $conn);



    // if($conn == true) {

    //     echo"super";

    // } else {

    //     echo "Bad";        

    // }

?>

  <!DOCTYPE html>

  <html lang="en">



  <head>

    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script>

    function sortWho(t){

      $(".td-who").find("a:not(:contains('"+t.trim()+"'))").parents("tr").css('display','none');    

      $(".all-shiped").css('display','block');

    }

    function AllShipped(){

      location.reload();

    }

    $(document).ready(function(){
        // $.datapicker.setDefaults({
        //   dateFormat: 'yy-mm-dd'
        // });
        $(function(){
          $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd'
          });
          $("#to_date").datepicker({
            dateFormat: 'yy-mm-dd'
          });
        });      
        $('#filter').click(function(){
          var from_date = $("#from_date").val();
          var to_date = $("#to_date").val();
          if(from_date != '' && to_date != ''){
            $.ajax({
              url: "fetch.php",
              method: "POST",
              data:{from_date: from_date, to_date:to_date},
              success:function(data){
                    $('#order_table').html(data);
              }
            });
          }
          else{
            alert("Выберите интревал!");
          }
        });


        $('.reload-page').on('click', function(){
          location.reload();
        });
    });

    </script>

    <style>

    .nav>li.all-shiped{

      display:none;

      border: 2px solid #337ab7;

    }

    </style>

  </head>

  <body>

    <div class="container">
    <div class="row">
    <div class="col-sm-8">
    <h3>Отгрузка 2</h3>   
    </div>
    <div class="col-sm-4">
          <label for="user">Пользовватель: </label>
          <span><?php echo($_SESSION['login']); ?></span>
          <p><a href='viiti.php' class="btn btn-danger" style="float: right;">Выйти</a></p>
    </div>
  </div>
      <div class="row">
        <div class="span12">          
          <?php include 'menu.php'; ?>
        </div>
        </div>
        <div class="row">
        <div class="input-datarange">
        <div class="col-md-3">
          <input type="text" name="from_date" id="from_date" class="form-control" />
        </div>
        <div class="col-md-3">
          <input type="text" name="to" id="to_date" class="form-control" />
        </div>
        <div class="col-md-5">
          <input type="button" name="filter" id="filter" value="Фильтровать" class="btn btn-info" />
          <button type="button" class="btn btn-secondary reload-page">Сбросить фильтр</button>
        </div>
      </div>
        </div>
        <div class="row">
        <div class="span12" id="order_table">
          <?php

 $qr_result = mysql_query("SELECT name,amount,code,date,who_shipped,user FROM ".$table." ORDER BY `date` DESC");/* LIMIT 10*/
  echo '<table class="table">';

  echo '<thead>';

  echo '<tr>';

  echo '<th>Название</th>';

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

    echo '<td>' . $data['name'] . '</td>';

    echo '<td>' . $data['amount'] . '</td>';

    echo '<td class="td-who"><a href="#" onclick="sortWho(\''. $data['who_shipped'] .'\');">'. $data['who_shipped'] .'</a></td>';

    echo '<td>' . $data['code'] . '</td>';

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