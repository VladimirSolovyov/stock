<?php
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "coming";

    $conn = mysql_connect($host,$user,$password);

    mysql_select_db($db_name, $conn);

    // if($conn == true) {
    //     echo"super";
    // } else {
    //     echo "Bad";        
    // }
?>
<h3>Приход товара</h3>
<ul>
<li>
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
 $qr_result = mysql_query("SELECT name,amount,code,date FROM ".$table);
  echo '<table border="1">';
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