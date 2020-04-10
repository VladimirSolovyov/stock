<?php
    header('Content-Type: text/html; charset=utf-8');
    setlocale(LC_ALL,'ru_RU.65001','rus_RUS.65001','Russian_Russia.65001','russian');
    session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!

    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }

    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
    if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
        require_once 'template/msg_not_all_text.php';
    }

    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);

    //удаляем лишние пробелы
    $login = trim($login);
    $passwordCurrent = trim($password);
	
     //Подключаемся к базе данных.
     require_once '../connection.php';
     $table = "coming";
     $conn = mysql_connect($host, $user, $password);
     mysql_select_db($db_name, $conn);

	if (!$conn) {
        echo "<p>Произошла ошибка при подсоединении к MySQL!</p>".mysql_error(); exit();
    } else {
    if (!mysql_select_db($db_name, $conn)) {
        echo("<p>Выбранной базы данных не существует!</p>");
        }
	}

    //извлекаем из базы все данные о пользователе с введенным логином
    $result = mysql_query("SELECT * FROM signup WHERE username='$login'", $conn);
    $myrow = mysql_fetch_array($result);

    if (empty($myrow["password"])) {
        //если пользователя с введенным логином не существует
        require_once 'template/msg_fail.php';
    }
    else {
        //если существует, то сверяем пароли
        if ($myrow["password"] == $passwordCurrent) {
        //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
        $_SESSION['login']=$myrow["username"];
        $_SESSION['id']=$myrow["user_id"];//эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
        $_SESSION['fullname']=$myrow["fullname"];//Возможно это глупо, но пока так - для отображения пользователя
        header("Location:../index.php");
        }
        else {
        //если пароли не сошлись
        require_once 'template/msg_fail.php';
        }
    }
?>