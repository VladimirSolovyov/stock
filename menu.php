<?php 
echo "<script>console.log(".$_SESSION['id'] .")</script>";
if($_SESSION['id'] == 1) {
?>

<!-- for igor -->

<ul class="nav nav-pills main-menu">
    <li>
        <a href="stock.php">Склад</a>
    </li>
    <!-- <li>
        <a href="index.php">Приход</a>
    </li>
    <li>
        <a href="shipped.php">Отгрузка</a>
    </li> -->
    <li>
        <a href="add_coming.php">Оформить приход</a>
    </li>
    <li>
        <a href="add_shipped.php">Оформить отгрузку</a>
    </li>
    <li>
        <a href="#" onclick="moveStock();">Переместить на склад</a>
    </li>
</ul>
<?php } else if($_SESSION['id'] == 2) { ?>
<!-- for Oleg -->

<ul class="nav nav-pills main-menu">
    <li>
        <a href="stock.php">Склад</a>
    </li>
    <!-- <li>
        <a href="index.php">Приход</a>
    </li>
    <li>
        <a href="shipped.php">Отгрузка</a>
    </li> -->
    <li>
        <a href="add_coming.php">Оформить приход</a>
    </li>
    <li>
        <a href="add_shipped.php">Оформить отгрузку</a>
    </li>
    <li>
        <a href="#" onclick="moveStock();">Переместить на склад</a>
    </li>
</ul>
<?php } else if($_SESSION['id'] == 3) { ?>
<!-- for admin -->

<ul class="nav nav-pills main-menu">
    <li>
        <a href="stock.php">Склад</a>
    </li>
    <li>
        <a href="index.php">Приход</a>
    </li>
    <li>
        <a href="shipped.php">Отгрузка</a>
    </li>
    <!-- <li>
        <a href="add_coming.php">Оформить приход 0</a>
    </li>
    <li>
        <a href="add_shipped.php">Оформить отгрузку 0</a>
    </li> -->
    <!-- <li>
        <a href="#" onclick="moveStock();">Переместить на склад 1</a>
    </li> -->
</ul>
<?php } ?>


<script>
    function getActiveItemMenu(){
        var namePage = document.location.href.split('/')[3].replace('#',''); 
    
        if(namePage){
            
            $('a[href="'+namePage+'"]').parent('li').addClass('active');

        } 
    }
    getActiveItemMenu();
    

$('.main-menu li').on('click',function(){
    $(this).addClass('active');
})
</script>