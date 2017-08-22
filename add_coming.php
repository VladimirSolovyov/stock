<?php
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "coming";
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
        echo "<span style='color:blue;'>Данные добавлены</span></br><a href='index.php'>Посмотреть документы прихода</a>";
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
       $sum_amount =  (int)$result->fetch_assoc()["amount"] + (int)$amount;
            $mysqli->query("UPDATE stock SET amount=".$sum_amount." WHERE code=".$code);
        } else {
            $mysqli->query("INSERT INTO stock VALUES(NULL, '$name','$amount','$code')");
    }
    /* очищаем результирующий набор */
    $result->close();
}

$mysqli->close();

}
?>
<h2>Добавить товар</h2>
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