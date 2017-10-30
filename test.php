<? 
//Поймал переменную кода
$code = $_POST['code'];

//Включил БД
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "stock";

/*$conn = mysql_connect($host,$user,$password);

mysql_select_db($db_name, $conn);

$array[] = $var;

$qr_result = mysql_query("SELECT * FROM ".$table);


while($data = mysql_fetch_array($qr_result)){ 
    array_push($var, $data['name']);
}
*/
// Подключаемся к базе MySQL и выбираем базу под названием db
$mysqli = new mysqli($host,$user,$password, $db_name);

// О нет!! переменная connect_errno существует, а это значит, что соединение не было успешным!
if ($mysqli->connect_errno) {
    echo "Извините, возникла проблема на сайте";
    exit;
}

// Выполняем запрос SQL
$sql = "SELECT name FROM stock WHERE code = $code";
if (!$result = $mysqli->query($sql)) {
    // О нет! запрос не удался. 
    echo "Извините, возникла проблема в работе сайта.";
    exit;
}


if ($result->num_rows === 0) {
    // Решать Вам. В данном случае, может быть actor_id был слишком большим? 
    echo "Мы не смогли найти совпадение для $code, простите. Пожалуйста, попробуйте еще раз.";
    exit;
}

$actor = $result->fetch_assoc();
echo json_encode($actor['name']); // Выводим из бд Имя.
?>
