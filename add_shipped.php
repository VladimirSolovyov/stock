<?php
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "shipped";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
<h2>Отгрузить товар</h2>
<form method="POST">
<p>Наименование:<br> 
<input type="text" name="name" /></p>
<p>Количество: <br> 
<input type="text" name="amount" /></p>
<p>Код: <br> 
<input type="text" name="code" /></p>
<input type="submit" value="Добавить">
</form>
</body>
</html>