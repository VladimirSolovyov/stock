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

$table = "coming";

?>



    <!DOCTYPE html>

    <html lang="en">



    <head>

        <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="node_modules/jquery/dist/jquery.min.js"></script>

        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script>

        $(function(){

            $(".addComing").on('click',function(){

                let valueCode = $(".codeRequired").val();



                //Проверка введённого кода. 

                valueCode = parseInt(valueCode);

                if(isNaN(parseInt(valueCode)) || valueCode === 0) {

                    alert("Введите корректный штрих-код товара!");

                    $(".codeRequired").addClass("error");

                    return false;

                }

            });

            

            /* Цели Create:

            1. Проверка кода есть ли такой код в БД.

            2. Подстановка данных(Наименования) по коду если он есть в БД.*/

            $('.codeRequired').blur(function() {

                var code = $('.codeRequired').val();

                if(code.length == 0){

                    alert("Вы не ввели значения поля код!");

                    return false;

                }

                

                $.ajax({

                    url:"test.php", 

                    type: "post",

                    dataType: 'json',

                    data: {code: parseInt(code,10)},           

                    success: function(result) {

                        $('.name-tovar').val(result.name);
                        $('.weight-tovar').val(result.weight);

                        //$('.name-tovar').attr('disabled','disabled'); Задизейбленый не хочет подставлять

                        $('.amount-tovar').focus().val('');

                    },

                    error: function(result) {

                        console.log("error");

                    }

                });

            });



        });

        </script>

        <style>

        .error {

            border: 2px solid #b94a48;

        }

        </style>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3>Добавить товар</h3>
                </div>
                <div class="col-sm-4">
                    <label for="user">Пользователь: </label>
                    <span><?php echo($_SESSION['fullname']); ?></span>
                    <p>
                        <a href='viiti.php' class="btn btn-danger" style="float: right;">Выйти</a>
                    </p>
                </div>
        </div>
        <?php include 'menu.php'; ?>
        <?php
            if(isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['code'])) {
            // подключаемся к серверу
                $link = mysqli_connect($host, $user, $password, $db_name)
                or die("Ошибка " . mysqli_error($link));

            // экранирования символов для mysql
                $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
                $amount = htmlentities(mysqli_real_escape_string($link, $_POST['amount']));
                $code = htmlentities(mysqli_real_escape_string($link, $_POST['code']));
                $today = date("Y-m-d H:i:s");
                $user = $_SESSION['login'];
                $weight = htmlentities(mysqli_real_escape_string($link, $_POST['weight']));

            // создание строки запроса
                 $query ="INSERT INTO ".$table." VALUES(NULL, '$name','$amount','$code','$today','$user','$weight')";

            // выполняем запрос
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

                if($result) { echo "<span class='text-success'>Данные добавлены</span></br><a href='index.php'>Посмотреть документы прихода</a>"; }

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

if($_SESSION['id'] == 1){
    $numstock=0;
} else {
    $numstock=1;
}

/* Select запросы возвращают результирующий набор */

if ($result = $mysqli->query("SELECT amount FROM ".$table." WHERE code=".$code." AND num_stock=".$numstock)) {
    if($result->num_rows > 0){
       $sum_amount =  (int)$result->fetch_assoc()["amount"] + (int)$amount;
       $mysqli->query("UPDATE stock SET amount=".$sum_amount." WHERE code=".$code." AND num_stock=".$numstock);
        } else {
            $mysqli->query("INSERT INTO `stock` (`id`, `name`, `amount`, `code`, `num_stock`,`weight`) VALUES (NULL, '$name', '$amount', '$code',$numstock,$weight)");//, '$name','$amount','$code' || INSERT INTO `stock` (`id`, `name`, `amount`, `code`, `num_stock`) VALUES (NULL, ".$name.")
            
            
    }

    /* очищаем результирующий набор */

    $result->close();

}



$mysqli->close();



}

?>

                <div class="container">

                    <form method="POST">

                        <p><span style="color:red;">Внимание!</span> Если вы знаете <b>код товара</b> в первую очередь вводите его, <b>наименование</b> подставляется автоматически.</p>

                        <div class="row">

                            <div class="col-sm-2" style="padding:5px;"><label>Код: </label></div>

                            <div class="col-sm-2" style="padding:5px;"><input class="codeRequired" type="text" name="code" /></div>

                            <div class=col-sm-2>

                                <button class="btn btn-warning checkCode" style="display:none;" onclick="create()">Проверить код</button>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-2" style="padding:5px;"><label>Наименование:</label></div>

                            <div class="col-sm-4" style="padding:5px;"><input type="text" name="name" class="name-tovar"/></div>

                        </div>

                        <div class="row">

                            <div class="col-sm-2" style="padding:5px;"><label>Количество: </label></div>

                            <div class="col-sm-4" style="padding:5px;"><input type="text" name="amount" value="0" class="amount-tovar"/></div>

                        </div>

                        <div class="row">

                            <div class="col-sm-2" style="padding:5px;"><label>Вес товара: </label></div>

                            <div class="col-sm-4" style="padding:5px;"><input type="text" name="weight" class="weight-tovar"/></div>

                        </div>

                        <div class="row">

                            <div class="col-sm-4" style="padding: 10px;">

                                <button type="submit"  class="btn btn-primary addComing">Добавить</button>

                            </div>

                        </div>

                    </form>


                    <button class="btn btn-warning checkCode" style="width: 10px; height: 10px; background: white; border: 2px solid;" onclick="create()"></button>

                </div>

        </div>

    </body>



    </html>
<?php } ?>