<?php
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "coming";

    $conn = mysql_connect($host,$user,$password);

    mysql_select_db($db_name, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="span12">
        <h3>Приход товара</h3>
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
 $qr_result = mysql_query("SELECT name,amount,code,date FROM ".$table);
  echo '<table class="table">';
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

?>
</div>
</div>
</div>
</body>
</html>