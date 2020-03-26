<?php
//Редирект
 //if (empty($_SESSION['login']){
  
//} 
?> 
 <!DOCTYPE html>
  <html lang="en">
  <head>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>        
  </head>
  <body>  
  <?php
  session_start();
  if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
      header('Location: http://a0144913.xsph.ru/stock.php ');
      include 'registr.php'; 
    }
    else  //Иначе. 
    {      
      if($_SESSION['id']==1 ||$_SESSION['id']==2){
        header('Location: http://a0144913.xsph.ru/stock.php ');
      }

      $host = "localhost";

      $user = "a0144913_stock";
      
      $password = "stock";
      
      $db_name = "a0144913_stock";
      
      $table = "coming";
      
      
      
          $conn = mysql_connect($host,$user,$password);
          mysql_select_db($db_name, $conn);
          ?>
    <div class="container">


      <div class="row">
    <div class="col-sm-8">
    <h3>Приход товара</h3>
    </div>
    <div class="col-sm-4">
          <label for="user">Пользователь: </label>
          <span><?php echo($_SESSION['fullname']); ?></span>
          <p><a href='viiti.php' class="btn btn-danger" style="float: right;">Выйти</a></p>
    </div>
  </div>
  <?php include 'menu.php'; ?>

      <div class="row">

        <div class="span12">

          <?php

 $qr_result = mysql_query("SELECT name,weight,amount,code,date,user FROM ".$table." ORDER BY `date` DESC");

  echo '<table class="table table-hover">';

  echo '<thead>';

  echo '<tr>';

  echo '<th>Название</th>';

  echo '<th>Вес(кг/л)</th>';

  echo '<th>Количество</th>';

  echo '<th>Код товара</th>';

  echo '<th>Дата</th>';

  echo '<th>Кто оприходовал</th>';

  echo '</tr>';

  echo '</thead>';

  echo '<tbody>';

 while($data = mysql_fetch_array($qr_result)){ 

    echo '<tr>';

    echo '<td>' . $data['name'] . '</td>';

    echo '<td>' . $data['weight'] . '</td>';

    echo '<td>' . $data['amount'] . '</td>';

    echo '<td>' . $data['code'] . '</td>';

    echo '<td>' . $data['date'] . '</td>';

    echo '<td>' . $data['user'] . '</td>';

    echo '</tr>';

  }



  echo '</tbody>';

  echo '</table>';


    }   



?>

        </div>

      </div>

    </div>

  </body>


  </html>