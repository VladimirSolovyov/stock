<?php
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
    <script>
    function sortWho(t){
      $(".td-who").find("a:not(:contains('"+t.trim()+"'))").parents("tr").css('display','none');    
      $(".all-shiped").css('display','block');
    }
    function AllShipped(){
      location.reload();
    }
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
        <div class="span12">
          <h3>Отгрузка</h3>
          <ul class="nav nav-pills">
            <li>
              <a href="stock.php">Склад</a>
            </li>
            <li>
              <a href="index.php">Приход</a>
            </li>
            <li class="active">
              <a href="shipped.php">Отгрузка</a>
            </li>
            <li>
              <a href="add_coming.php">Оформить приход</a>
            </li>
            <li>
              <a href="add_shipped.php">Оформить отгрузку</a>
            </li>
            <li class="all-shiped">
              <a href="#" onclick="AllShipped()">Показать все отгрузки</a>
            </li>
          </ul>
          <?php
 $qr_result = mysql_query("SELECT name,amount,code,date,who_shipped FROM ".$table." ORDER BY `date` DESC");/* LIMIT 10*/
  echo '<table class="table">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Название</th>';
  echo '<th>Количество</th>';
  echo '<th>Кому отгружаем</th>';
  echo '<th>Код товара</th>';
  echo '<th>Дата</th>';
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