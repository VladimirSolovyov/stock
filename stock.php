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

$table = "stock";



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

    $(function(){

      $.each($(".amount"),function(i,el){  

          if(+$(el).text() === 0){

            $(el).parents('tr').addClass('empty-amount');

          }

      });

    });

    </script>

    <style>

    .empty-amount {

      color: red;

      background: #eeeeee;

    }

    </style>

  </head>



  <body>

    <div class="container">

      <div class="row">

        <div class="span12">

          <h3>Склад</h3>

          <ul class="nav nav-pills">

            <li class="active">

              <a href="stock.php">Склад</a>

            </li>

            <li>

              <a href="index.php">Приход</a>

            </li>

            <li>

              <a href="shipped.php">Отгрузка</a>

            </li>

            <li>

              <a href="add_coming.php">Оформить приход</a>

            </li>

            <li>

              <a href="add_shipped.php">Оформить отгрузку</a>

            </li>

          </ul>

          <?php
  if($_SESSION['login'] == "Igor") {
    $numStock = 0;
  } else {
    $numStock = 1;
  }
 $qr_result = mysql_query("SELECT name,amount,code FROM ".$table." WHERE `num_stock`=".$numStock);

  echo '<table class="table">';

  echo '<thead>';

  echo '<tr>';

  echo '<th>Название</th>';

  echo '<th>Количество</th>';

  echo '<th>Код товара</th>';

  echo '</tr>';

  echo '</thead>';

  echo '<tbody>';

 while($data = mysql_fetch_array($qr_result)){ 

    echo '<tr>';

    echo '<td>' . $data['name'] . '</td>';

    echo '<td class="amount">' . $data['amount'] . '</td>';

    echo '<td>' . $data['code'] . '</td>';

    echo '</tr>';

  }



  echo '</tbody>';

  echo '</table>';



?>

        </div>

      </div>

    </div>

  </body>
<?php }?>