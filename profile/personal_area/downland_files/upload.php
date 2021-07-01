<?php
include ('../../../header.php');
include ('F:/XAMPP/htdocs/dbconnect.php');
require_once "../../../vendor/autoload.php";

$uploaddir = 'uploaded_files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
}
else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

if ($xlsx = SimpleXLSX::parse($uploadfile)) {
    echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
    foreach ($xlsx->rows() as $r) {
        echo '<tr><td>' . implode('</td><td>', $r) . '</td></tr>';
    }
    echo '</table>';
}
else {
    echo SimpleXLSX::parseError();
}

if ($xlsx = SimpleXLSX::parse($uploadfile)) {
    // Производит ключи массива из значений 1 элемента массива
    $header_values = $rows = [];
    foreach ($xlsx->rows() as $k => $r) {
        if ($k === 0) {
            $header_values = $r;
            continue;
        }
        $rows[] = array_combine($header_values, $r);
        for ($i = 0;$i < count($r);$i = $i + 3) {
            $mysqli->query("INSERT INTO `sklad_tovar` (`name`, `quantity`, `unit`) VALUES ('{$r[$i]}','{$r[$i + 1]}','{$r[$i + 2]}')");
        }
    }
    print_r($rows);
}

echo "\n Некоторая отладочная информация:";
print_r($_FILES);

print "</pre>";

// header("Location: up_file.php");
