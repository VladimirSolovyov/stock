  <!DOCTYPE html>

  <html lang="en">



  <head>

    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <style>
    div.block-exit {
      position: absolute;
    top: 30%;
    left: 50%;
    margin-top: -50px;
    margin-left: -50px;
    width: 300px;
    padding: 20px;
    background-color: #f0f0f1;
    }

    div.block-exit h1{
      font-family:Open Sans,sans-serif;
      color:#96a2b2;
      letter-spacing:1px;
      font-size:22px;
      margin-bottom:20px;
      margin-top:20px
    }

     div.block-exit img.logo {
      width: 140px;
      height: 110px;
      margin-left: 60px;
     }
    </style>
  </head>
  <body>
  <?php
    session_start();
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {

  ?>
<div class="block-exit">
<img src="img/logo.png" class="logo" alt="logo">
  <h1>Введите свои данные</h1>	
<form action="proverca.php" method="post">
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
  <input name="login" type="text" class="form-control" placeholder="Ваш логин">
  </div>
</div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
  <input name="password" type="password" class="form-control" placeholder="Ваш суперпароль">
  </div>
</div>
  <input type="submit" value="Войти" class="btn btn-primary btn-block"><br/><br/>
</form>
<div>Здравствуйте, <font color="red">Гость</font>! <br/>
Авторизуйтесь и пройдите по ссылке! </div>
</div> 


  <!-- <div class="login-block">
	<img src="1.png" alt="Scanfcode">
  <h1>Введите свои данные</h1>	
<form action="proverca.php" method="post">
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user ti-user"></i></span>
  <input name="login" type="text" class="form-control" placeholder="Ваш логин">
  </div>
</div>
 
<hr class="hr-xs">
 
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-lock ti-unlock"></i></span>
  <input name="password" type="password" class="form-control" placeholder="Ваш суперпароль">
  </div>
</div>
  <input type="submit" value="войти" class="btn btn-primary btn-block" >
</form>
Здравствуйте <font color="red">гость</font>! <br/>
Авторизуйтесь и пройдите по ссылке! 
</div> -->

<?php
    }
    else  //Иначе. 
    {      
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

        <div class="span12">
          <h3>Приход товара</h3>
          <a href='viiti.php' class="btn btn-danger" style="float: right;">Выйти</a> 
        </div>

      </div>

      <div class="row">

        <div class="span12">

          <ul class="nav nav-pills">

            <ul class="nav nav-pills">

              <li>

                <a href="stock.php">Склад</a>

              </li>

              <li class="active">

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

        </div>

      </div>

      <div class="row">

        <div class="span12">

          <?php

 $qr_result = mysql_query("SELECT name,amount,code,date FROM ".$table." ORDER BY `date` DESC");

  echo '<table class="table table-hover">';

  echo '<thead>';

  echo '<tr>';

  echo '<th>Название</th>';

  echo '<th>Количество</th>';

  echo '<th>Код товара</th>';

  echo '<th>Дата</th>';

  echo '</tr>';

  echo '</thead>';

  echo '<tbody>';

 while($data = mysql_fetch_array($qr_result)){ 

    echo '<tr>';

    echo '<td>' . $data['name'] . '</td>';

    echo '<td>' . $data['amount'] . '</td>';

    echo '<td>' . $data['code'] . '</td>';

    echo '<td>' . $data['date'] . '</td>';

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