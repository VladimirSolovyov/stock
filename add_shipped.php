<?php
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "shipped";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<?php
 
if(isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['code'])){
 
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $db_name) 
        or die("Ошибка " . mysqli_error($link)); 
     
    // экранирования символов для mysql
    $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
    $amount = htmlentities(mysqli_real_escape_string($link, $_POST['amount']));
    $code = htmlentities(mysqli_real_escape_string($link, $_POST['code']));
    $today = date("Y-m-d H:i:s");
     
    // создание строки запроса
    $query ="INSERT INTO ".$table." VALUES(NULL, '$name','$amount','$code','$today')";
     
    // выполняем запрос
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    if($result)
    {
        echo "<span style='color:blue;'>Товар отгружан</span></br><a href='shipped.php'>Посмотреть документы отгрузки</a>";
    }
    // закрываем подключение
    mysqli_close($link);
}
?>

<?php 

if(!empty($code)){
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "stock";

$conn = mysql_connect($host,$user,$password);
mysql_select_db($db_name, $conn);

$mysqli = new mysqli("localhost", $user, $password, $db_name);

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    exit();
}

/* Select запросы возвращают результирующий набор */
if ($result = $mysqli->query("SELECT amount FROM ".$table." WHERE code=".$code)) {
    if($result->num_rows > 0){
       $sum_amount =  (int)$result->fetch_assoc()["amount"] - (int)$amount;
            $mysqli->query("UPDATE stock SET amount=".$sum_amount." WHERE code=".$code);
        } 
    /* очищаем результирующий набор */
    $result->close();
}

$mysqli->close();

}
?>
<div class="container">
<h3>Отгрузить товар</h3>
<ul class="nav nav-pills">
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
<li  class="active">
<a href="add_shipped.php">Оформить отгрузку</a>
</li>
</ul>

<form method="POST">
    <legend>Отгрузить товар</legend>
<div class="row">
<div class="col-sm-2" style="padding:5px;"><label>Наименование:</label></div>
<div class="col-sm-4" style="padding:5px;"><input type="text" name="name" /></div>
</div>
<div class="row">
<div class="col-sm-2" style="padding:5px;"><label>Количество: </label></div> 
<div class="col-sm-4" style="padding:5px;"><input type="text" name="amount" /></div>
</div>
<div class="row">
<div class="col-sm-2" style="padding:5px;"><label>Код: </label></div> 
<div class="col-sm-4" style="padding:5px;"><input type="text" name="code" /></div>
</div>
<div class="row">
    <div class="col-sm-4" style="padding: 10px;">
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
</div>
</form>
</div>
</body>
</html>