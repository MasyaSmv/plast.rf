<?php

include 'F:/XAMPP/htdocs/dbconnect.php';
$loadfile = $_POST['file_name'];
require_once $_SERVER['DOCUMENT_ROOT']."../../../../Classes/PHPExcel/IOFactory.php";
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/profile/personal_area/downland_files/uploaded_files/".$loadfile);
foreach ($objPHPExcel -> getWorksheetIterator() as $worksheet) {
    $highestRow = $worksheet -> getHighestRow();
    $highestColumn = $worksheet -> getHighestColumn();

    for ($row = 1; $row <= $highestRow; ++ $row)
    {
        $cell1 = $worksheet -> getCellByColumnAndRow(0, $row);
        $cell2 = $worksheet -> getCellByColumnAndRow(1, $row);
        $cell3 = $worksheet -> getCellByColumnAndRow(2, $row);
        $cell4 = $worksheet -> getCellByColumnAndRow(3, $row);
        $sql = "INSERT INTO `sklad_tovar` (`name`, `quantity`, `unit`) VALUES ('$cell','$cell2','$cell3','$cell4')";
        $query = mysqli_query($sqli) or die ('Ошибка записи чтения: '.mysqli_error());
    }
}

?>
