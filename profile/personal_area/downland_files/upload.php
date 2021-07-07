<?php
session_start();

include ('../../../dbconnect.php');
include ("../../../vendor/autoload.php");

// Обозначаем переменные и имя файла
$uploaddir = 'uploaded_files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$sity = $_POST['sity'];

// Сообщения загрузки файла
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
}
else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

// Парсер файла с выдащей в виде таблицы в html (Показыает когда тестишь скрипт)
if ($xlsx = SimpleXLSX::parse($uploadfile)) {
    echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
    foreach ($xlsx->rows() as $v) {
        echo '<tr><td>' . implode('</td><td>', $v) . '</td></tr>';
    }
    echo '</table>';
}
else {
    echo SimpleXLSX::parseError();
}

// Парсит файл и загружает данные массивов в бд
if ($xlsx = SimpleXLSX::parse($uploadfile)) {
    // Производит ключи массива из значений 1 элемента массива
    $header_values = $rows = [];
    foreach ($xlsx->rows() as $k => $v) {
        if ($k === 0) {
            $header_values = $v;
            continue;
        }
        //Разбивает данные на столбцы
        $rows[] = array_combine($header_values, $v);
        for ($i = 0;$i < count($v);$i = $i + 5) {

            //Убирает лишние пробелы
            $title = trim(preg_replace('/ {2,}/', ' ', $v[$i]));
            $size = trim(preg_replace('/ {2,}/', ' ', $v[$i + 1]));
            $quant = trim(preg_replace('/ {2,}/', ' ', $v[$i + 2]));
            $unit = trim(preg_replace('/ {2,}/', ' ', $v[$i + 3]));
            $color = trim(preg_replace('/ {2,}/', ' ', $v[$i + 4]));

            //Конвертирует
            if ($unit === "м") {
                $quant = $quant / 1000;
                $unit = "км";
            }
            if ($unit === "") {
                $unit = "км";
            }

            //Запись в БД
            $mysqli->query("INSERT INTO `sklad_tovar` (`id_user`, `title`, `size`, `quant`, `unit`, `color`, `sity`)
                VALUES ('{$_SESSION['id']}','$title','$size','$quant','$unit','$color','$sity')
                ");
                print_r($_SESSION['id']);
        }
    }
}
header("Location: up_file.php");
exit;
