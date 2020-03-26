<?php

session_start();
if($_SESSION['login'] == "Igor") {

    $currentStock = 0;

    $moveStock = 1;

  } else {

    $currentStock = 1;

    $moveStock = 0;

  }

$ids = $_POST['ids'];

$amount = $_POST['amount'];

$amountBD = $_POST['amountBD'];

$code = $_POST['code'];

$name = $_POST['name'];



$host = "localhost";

$user = "a0144913_stock";

$password = "stock";

$db_name = "a0144913_stock";

$table = "stock";





$mysqli = new mysqli($host,$user,$password, $db_name);



// О нет!! переменная connect_errno существует, а это значит, что соединение не было успешным!

if ($mysqli->connect_errno) {

    echo "Извините, возникла проблема на сайте";

    exit;

}



// О нет!! переменная connect_errno существует, а это значит, что соединение не было успешным!

if ($mysqli->connect_errno) {

    echo "Извините, возникла проблема на сайте";

    exit;

}

if($amount == $amountBD) {
    $updateCurrentStock = "UPDATE `stock` SET `amount` = 0 WHERE `id` = $ids AND `num_stock`=$currentStock";
    $mysqli->query($updateCurrentStock);
    $sql = "SELECT amount FROM stock WHERE code = $code AND `num_stock`=$moveStock";
    $result = $mysqli->query($sql);
    if ($result->num_rows === 0) {
        $insertMoveStock = "INSERT INTO ".$table." VALUES(NULL, '$name','$amount','$code','$moveStock')";
        if (!$result = $mysqli->query($insertMoveStock)) {
            echo "Извините, возникла проблема в работе сайта.";    
            exit;    
        } else{    
            exit('true');    
        }
    } else {
        $actor = $result->fetch_assoc();
        $amount = $actor['amount'] + $amount;
        $updateMoveStock = "UPDATE `stock` SET `amount` = $amount WHERE `code` = $code AND `num_stock`=$moveStock";         
        if (!$result = $mysqli->query($updateMoveStock)) {
            echo "Извините, возникла проблема в работе сайта.";    
            exit;    
        } else{    
            exit('true');    
        }
    }
    

} else {
    $newamount = $amountBD-$amount;    
    $searchCode = "SELECT amount FROM stock WHERE code = $code AND `num_stock`=$moveStock";
    $result = $mysqli->query($searchCode);
    if ($result->num_rows === 0) {
        $sql ="INSERT INTO ".$table." VALUES(NULL, '$name','$amount','$code','$moveStock')";
        $mysqli->query($sql);
    } else {
        $actor = $result->fetch_assoc();
        $amountMove = $actor['amount'] + $amount;
        $updateMoveStock = "UPDATE `stock` SET `amount` = $amountMove WHERE `code` = $code AND `num_stock`=$moveStock";         
        $mysqli->query($updateMoveStock);
    }
    $sql2 = "UPDATE `stock` SET `amount` = $newamount WHERE `id` = $ids";
    $mysqli->query($sql2);
    exit('true');

}





// if ($result->num_rows === 0) {

//     // Решать Вам. В данном случае, может быть actor_id был слишком большим? 

//     echo "Мы не смогли найти совпадение для $code, простите. Пожалуйста, попробуйте еще раз.";

//     exit;

// }



?>