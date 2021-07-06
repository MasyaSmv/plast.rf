<?php
include ('../../../header.php');
include ('F:/XAMPP/htdocs/dbconnect.php');
require_once "../../../vendor/autoload.php";

// Обозначаем переменные и имя файла
$uploaddir = 'uploaded_files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$sity = $_POST['sity'];

//запрос в таблицу с ед. измерения
$r = $mysqli -> query("SELECT * FROM sklad_unit ORDER BY id");
foreach ($r as $rr)
{
    list($unid, $ed) = $rr; //присваивает переменным из списка значения массива
    $unit[$unid] = $ed;
}

$unitf = array_flip($unit); //меняет местами ключи с массивами
echo "\n Некоторая отладочная информация:";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Сообщения загрузки файла
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
{
    echo "Файл корректен и был успешно загружен.\n";
}
else
{
    echo "Возможная атака с помощью файловой загрузки!\n";
}

// Парсер файла с выдащей в виде таблицы в html
if ($xlsx = SimpleXLSX::parse($uploadfile))
{
    echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
    foreach ($xlsx->rows() as $v)
    {
        echo '<tr><td>' . implode('</td><td>', $v) . '</td></tr>';
    }
    echo '</table>';
}
else
{
    echo SimpleXLSX::parseError();
}

// ПРАВИЛЬНАЯ, НО НИЖЕ ПРОБУЮ КОД С ДРУГОГО ПРОЕКТА
// Парсит файл и загружает данные массивов в бд
/* if ($xlsx = SimpleXLSX::parse($uploadfile)) {
    // Производит ключи массива из значений 1 элемента массива
    $header_values = $vows = [];
    foreach ($xlsx->rows() as $k => $v) {
        if ($k === 0) {
            $header_values = $v;
            continue;
        }
        $vows[] = array_combine($header_values, $v);
        for ($i = 0;$i < count($v);$i = $i + 5) {

            $title = trim(preg_replace('/ {2,}/',' ',$v[$i]));
            $size = $v[$i+1];
            $quant = $v[$i+2];
            $unit = $v[$i+3];
            $color = $v[$i+4];

            $mysqli -> query(
                "INSERT INTO `sklad_tovar` (`id_user`, `name`, `size`, `quant`, `unit`, `color`, `sity`)
                VALUES ('{$_SESSION['id']}','$title','$size','$quant','$unit','$color','$sity')
                ");
            // print_r($header_values);
            print_r($title);
            echo "\n";
        }
    }
    print_r($vows);
} */

if ($xlsx = SimpleXLSX::parse($uploadfile))
{
    // Производит ключи массива из значений 1 элемента массива
    $header_values = $vows = [];
    foreach ($xlsx as $k => $v)
    {
        $title = $v['title'];
        $kol = str_replace(".", ",", $v['quant']);
        $ed = $v['id_user'];
        $q = "INSERT INTO `sklad_tovar` SET `title`='$title',`quant`='$kol', `id_user`='$ed'";
        mysqli_query($link, $q);
        if ($k === 0)
        {
            $header_values = $v;
            continue;
        }

        $vows[] = array_combine($header_values, $v);
        for ($i = 0;$i < count($v);$i = $i + 5)
        {

            $title = trim(preg_replace('/ {2,}/', ' ', $v[$i]));
            $size = $v[$i + 1];
            $quant = $v[$i + 2];
            $unit = $v[$i + 3];
            $color = $v[$i + 4];

            $mysqli->query("INSERT INTO `sklad_tovar` (`id_user`, `title`, `size`, `quant`, `unit`, `color`, `sity`)
                VALUES ('{$_SESSION['id']}','$title','$size','$quant','$unit','$color','$sity')
                ");
            // print_r($header_values);
            print_r($title);
            echo "\n";
        }
    }
    print_r($vows);
}

echo "\n Некоторая отладочная информация:";
print_r($header_values);
echo "\n";
echo $quant;
print "</pre>";

// header("Location: up_file.php");
