<?php 

 if(isset($_POST["from_date"], $_POST["to_date"]))
 {
     $host = "localhost";
     $user = "a0144913_stock";
     $password = "stock";
     $db_name = "a0144913_stock";
     $connect = mysqli_connect($host,$user,$password,$db_name);
     $output = '';
     
     $query = "
         SELECT * FROM shipped
         WHERE date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
        
     ";
        
      if(!empty($_POST["user_date"]))
      {
         $query .= "
             AND user='".$_POST["user_date"]."'
         ";
      } 
     
     $result = mysqli_query($connect, $query);
     
     $output .="
     <table class='table'>
     <thead>
     <tr>
        <th>Название</th>
        <th>Вес(кг/л)</th>
        <th>Количество</th>
        <th>Кому отгружаем</th>
        <th>Код товара</th>
        <th>Дата</th>
        <th>Кто отгружал</th>
    </tr>
    </thead>
    <tbody class='body-table'>
     ";
     
     if(mysqli_num_rows($result) > 0)
     {
        
         while($row = mysqli_fetch_array($result))
         {
             $output .='
                 <tr>
                     <td class="name">'.$row['name'].'</td>
                     <td class="weight">'.$row['weight'].'</td>
                     <td class="amount">'.$row['amount'].'</td>
                     <td>'.$row['who_shipped'].'</td>
                     <td class="code">'.$row['code'].'</td>
                     <td>'.$row['date'].'</td>
                     <td>'.$row['user'].'</td>
                 </tr>';
         }
     } else {
     $output .="
                <tr>
                     <td colspan='6'>В данный период отгрузок не было.</td>
                </tr>";     
     }
    $output .='</tbody></table>';
    echo $output;
 }





?>

