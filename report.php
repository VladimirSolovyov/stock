<?php 
$catList = json_decode($_POST['param']);
$rno = json_decode($_POST['common']);

require './vendor/autoload.php';

// $catList = [
// 	['name' => 'Tom', 'color' => 'red'],
// 	['name' => 'Bars', 'color' => 'white'],
// 	['name' => 'Jane', 'color' => 'Yellow'],
// ];

$document = new \PHPExcel();

$sheet = $document->setActiveSheetIndex(0); // Выбираем первый лист в документе

$columnPosition = 0; // Начальная координата x
$startLine = 2; // Начальная координата y

// Вставляем заголовок в "A2" 
$sheet->setCellValueByColumnAndRow($columnPosition, $startLine, 'Список товаров');

// Выравниваем по центру
$sheet->getStyleByColumnAndRow($columnPosition, $startLine)->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Объединяем ячейки "A2:C2"
$document->getActiveSheet()->mergeCellsByColumnAndRow($columnPosition, $startLine, $columnPosition+4, $startLine);

// Перекидываем указатель на следующую строку
$startLine++;

// Массив с названиями столбцов
$columns = ['№', 'Наименование', 'Код','Количество','Вес(кг/л)'];

// Указатель на первый столбец
$currentColumn = $columnPosition;

// Формируем шапку
foreach ($columns as $column) {
    // Красим ячейку
    $sheet->getStyleByColumnAndRow($currentColumn, $startLine)
        ->getFill()
        ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('4dbf62');

    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $column);

    // Смещаемся вправо
    $currentColumn++;
}

// Формируем список
foreach ($catList as $key=>$catItem) {
	// Перекидываем указатель на следующую строку
    $startLine++;
    // Указатель на первый столбец
    $currentColumn = $columnPosition;
    // Вставляем порядковый номер
    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $key+1);

    // Ставляем информацию об имени и цвете
    foreach ($catItem as $value) {
        $currentColumn++;
    	$sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $value);
    }
}


$currentColumn = $columnPosition;



// Формируем шапку

    $startLine = $startLine+3;
    // Красим ячейку
    $sheet->getStyleByColumnAndRow($currentColumn, $startLine)
        ->getFill()
        ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('4dbf62');

    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, "Итоговые результаты за период");

    $sheet->getStyleByColumnAndRow($columnPosition, $startLine)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    // Объединяем ячейки "A2:C2"
    $document->getActiveSheet()->mergeCellsByColumnAndRow($columnPosition, $startLine, $columnPosition+4, $startLine);

    $startLine++;
    $currentColumn = $columnPosition;
    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, "Общее количество товара отгружено: ");
    $sheet->getStyleByColumnAndRow($columnPosition, $startLine)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    // Объединяем ячейки "A2:C2"
    $document->getActiveSheet()->mergeCellsByColumnAndRow($columnPosition, $startLine, $columnPosition+3, $startLine);
    $currentColumn=4;

    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $rno->amountAll);

    $startLine++;
    $currentColumn = $columnPosition;
    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, "Общий вес товара отгруженого: ");
    $sheet->getStyleByColumnAndRow($columnPosition, $startLine)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    // Объединяем ячейки "A2:C2"
    $document->getActiveSheet()->mergeCellsByColumnAndRow($columnPosition, $startLine, $columnPosition+3, $startLine);
    $currentColumn=4;
    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $rno->weightAll);

// Формируем список
//foreach ($rno as $key=>$catItem) {
	// Перекидываем указатель на следующую строку
    //$startLine++;
    // Указатель на первый столбец
   // $currentColumn = $columnPosition;
    // Вставляем порядковый номер
    //$sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $key+1);

    // Ставляем информацию об имени и цвете
    //foreach ($catItem as $value) {
       // $currentColumn++;
     //   $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $rno->amountAll);
     //   $currentColumn++;
    //    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $rno->weightAll);
    //}
//}

$objWriter = \PHPExcel_IOFactory::createWriter($document, 'Excel5');
$objWriter->save("Report.xls");
$xlsData = ob_get_contents();
ob_end_clean();
$response =  array('op' => 'ok');
die(json_encode($response));
// header('Content-Type: application/vnd.ms-excel; charset=utf-8');
// header("Content-Disposition: attachment;filename=".date("d-m-Y")."-export.xls");
// header("Content-Transfer-Encoding: binary ");

// // !! Шапка хтмл

// echo '
//   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//   <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
// <head>
// <meta http-equiv="content-type" content="text/html; charset=utf-8" />
// <meta name="author" content="zabey" />
// <title>Demo</title>
// </head>
// <body>
// ';

// // !!! Таблица с данными

// // заголовок таблицы
// echo '
//  <table border="1">
// <tr>
// <th>Колонка 1</th>
// <th>Вторая колонка</th>
// </tr>
// ';
// //while($row = $STH->fetch()){ // формирование тела таблицы. Выберете ваш метод самостоятельно.
// echo '<tr>
// <td>'.$row['col1'].'</td>
// <td>'.$row['col2'].'</td>
//       </tr>';
// //}
// echo '</table>';
// echo '</body></html>';
?>