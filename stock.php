<!DOCTYPE html>
<html lang="en">
<head>
<link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
 <script src="node_modules/jquery/dist/jquery.min.js"></script>
 <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
 <script>
    $(function(){
      $.each($(".amount"),function(i,el){  
          if(+$(el).text() === 0){
            $(el).parents('tr').addClass('empty-amount');
          }
      });
    });
    function moveStock(){
      var itemLst = $('.id-item:checked');
      if(itemLst.length == 0){
        alert('Товары не выбраны');
        return false;
      }
      var result =[];    

      for(var i = 0; i<itemLst.length; i++){
        var amountBD = +$(itemLst[i]).parents('tr').find('.amount').html();
        var code = +$(itemLst[i]).parents('tr').find('.code').html();
        var name =$(itemLst[i]).parents('tr').find('.name').html();
        var amount = 0;

        if(amountBD>1){
          amount = prompt('Какое количество товара переместить?', '');
          if(amountBD < +amount ){
            alert('Количество товара на складе меньше перемещаемого!!!');
            return false; 
          }
        }
        if(amountBD==1) amount = 1;
        result.push($(itemLst[i]).val());
      }
      $.ajax({

      url:"move_on_stock.php", 

      type: "post",

      dataType: 'json',

      data: {ids: parseInt(result[0],10), amount: parseInt(amount,10),amountBD:amountBD,code: parseInt(code,10),name:name},           

      success: function(result) {
        alert('Товар отправляеться');
        setTimeout(function(){document.location.reload(true)},1000);
   },
error: function(result) {
    console.log("error");
}
});
    }

    </script>
  </head>
  <body>
  <?php
session_start();
if (empty($_SESSION['login']) or empty($_SESSION['id']))
{
  include 'registr.php'; 
} else {
$host = "localhost";
$user = "a0144913_stock";
$password = "stock";
$db_name = "a0144913_stock";
$table = "stock";
$t_list_stock = "list_stock";
    $conn = mysql_connect($host,$user,$password);
    mysql_select_db($db_name, $conn);
    if($_SESSION['id'] == 1) {
      $numStock = 0;
    } else {
      $numStock = 1;
    }

    $qr_result_liststock = mysql_query("SELECT name FROM ".$t_list_stock." WHERE `id_stock`=".$numStock);

    while($d_liststock = mysql_fetch_array($qr_result_liststock)){ 
      $nameStock = $d_liststock['name'];
    }

?>

    <div class="container">
    
    <div class="row">
    <div class="col-sm-8">
    <?php echo '<h3>Склад: ' .$nameStock. '</h3>'; ?>      
    </div>
    <div class="col-sm-4">
          <label for="user">Пользователь: </label>
          <span><?php echo($_SESSION['fullname']); ?></span>
          <p><a href='viiti.php' class="btn btn-danger" style="float: right;">Выйти</a></p>
    </div>
    </div>

      <div class="row">

        <div class="span12">
        <?php include 'menu.php'; ?>
          
          
          
          <?php
          if($_SESSION['id'] == 3){
            $qr_result = mysql_query("SELECT id,name,weight,amount,code,num_stock FROM ".$table);

            echo '<table class="table">';
          
            echo '<thead>';
          
            echo '<tr>';
          
            echo '<th></th>';
          
            echo '<th>Название</th>';

            echo '<th>Вес(кг/л)</th>';
          
            echo '<th>Количество</th>';
          
            echo '<th>Код товара</th>';

            echo '<th>Номер склада</th>';
          
            echo '</tr>';
          
            echo '</thead>';
          
            echo '<tbody>';
          
           while($data = mysql_fetch_array($qr_result)){ 
          
              echo '<tr>';
              echo '<td style="width: 20px;"><input class="id-item" value="' . $data['id'] . '" type="checkbox"></td>'; 
          
              echo '<td class="name">' . $data['name'] . '</td>';

              echo '<td>' . $data['weight'] . '</td>';
          
              echo '<td class="amount">' . $data['amount'] . '</td>';
          
              echo '<td class="code">' . $data['code'] . '</td>';
              
              echo '<td>' . $data['num_stock'] . '</td>';
          
              echo '</tr>';
          
            }
            echo '</tbody>';
            echo '</table>';
          } else {
  
 $qr_result = mysql_query("SELECT id,name,weight,amount,code FROM ".$table." WHERE `num_stock`=".$numStock);

  echo '<table class="table">';

  echo '<thead>';

  echo '<tr>';

  echo '<th></th>';

  echo '<th>Название</th>';

  echo '<th>Вес(кг/л)</th>';

  echo '<th>Количество</th>';

  echo '<th>Код товара</th>';

  echo '</tr>';

  echo '</thead>';

  echo '<tbody>';

 while($data = mysql_fetch_array($qr_result)){ 

    echo '<tr>';
    echo '<td style="width: 20px;"><input class="id-item" value="' . $data['id'] . '" type="checkbox"></td>'; 

    echo '<td class="name">' . $data['name'] . '</td>';

    echo '<td>' . $data['weight'] . '</td>';

    echo '<td class="amount">' . $data['amount'] . '</td>';

    echo '<td class="code">' . $data['code'] . '</td>';

    echo '</tr>';

  }
  echo '</tbody>';
  echo '</table>';
}
?>

        </div>

      </div>

    </div>

  </body>
<?php }?>