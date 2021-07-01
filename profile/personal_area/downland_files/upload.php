<?php
include ('../../../header.php');
include ('F:/XAMPP/htdocs/dbconnect.php');
require_once "../../../vendor/autoload.php";

// Обозначаем переменные и имя файла
$uploaddir = 'uploaded_files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$sity = $_POST['sity'];
$user_id = $_SESSION['id'];

// Сообщения загрузки файла
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
}
else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

// Парсер файла с выдащей в виде таблицы в html
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

                                            //============= прикрепить пользователя id к бд =============//

// Парсит файл и загружает данные массивов в бд
if ($xlsx = SimpleXLSX::parse($uploadfile)) {
    // Производит ключи массива из значений 1 элемента массива
    $header_values = $rows = [];
    foreach ($xlsx->rows() as $k => $r) {
        if ($k === 0) {
            $header_values = $r;
            continue;
        }
        $rows[] = array_combine($header_values, $r);
        for ($i = 0;$i < count($r);$i = $i + 5) {
            $mysqli->query("INSERT INTO `sklad_tovar` (`name`, `id_user` `size`, `quantity`, `unit`, `color`, `sity`) VALUES ('{$r[$i]}','{$r[$i + 1]}','{$r[$i + 2]}','{$r[$i + 3]}','{$r[$i + 4]}','$sity')");
        }
    }
    print_r($rows);
}

echo "\n Некоторая отладочная информация:";
print_r($_FILES);

print "</pre>";

// header("Location: up_file.php");
