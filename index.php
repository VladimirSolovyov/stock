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
            include 'authorization/registr.php';
        }
    else
        {
            if($_SESSION['id']==1 ||$_SESSION['id']==2)
                {
                    header('Location: http://a0144913.xsph.ru/stock.php ');
                }
            require_once 'connection.php';

            $conn = mysql_connect($host,$user,$password);
            mysql_select_db($db_name, $conn);
            $table = "coming";
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
            $qr_result = mysql_query("SELECT name,weight,amount,code,date,user FROM ".$table." WHERE  `date` > DATE_ADD(NOW(), INTERVAL -30 DAY) ORDER BY `date` DESC");
            echo '<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Вес(кг/л)</th>
                            <th>Количество</th>
                            <th>Код товара</th>
                            <th>Дата</th>
                            <th>Кто оприходовал</th>
                        </tr>
                    </thead>
                    <tbody>';
                    while($data = mysql_fetch_array($qr_result))
                    {
                        echo '<tr>
                                <td>' . $data['name'] . '</td>
                                <td>' . $data['weight'] . '</td>
                                <td>' . $data['amount'] . '</td>
                                <td>' . $data['code'] . '</td>
                                <td>' . $data['date'] . '</td>
                                <td>' . $data['user'] . '</td>
                              </tr>';
                    }
            echo   '</tbody>
                    </table>';
            }
          ?>
        </div>
      </div>
   </div>
  </body>
  </html>