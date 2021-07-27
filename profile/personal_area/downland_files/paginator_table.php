<?php
include ('../../../dbconnect.php');
// Поверка, есть ли GET запрос
if (isset($_GET['pageno'])) {
    // Если да то переменной $pageno присваиваем его
    $pageno = $_GET['pageno'];
} else { // Иначе
    // Присваиваем $pageno один
    $pageno = 1;
}

// Назначаем количество данных на одной странице
$size_page = 10;
// Вычисляем с какого объекта начать выводить
$offset = ($pageno-1) * $size_page;

// SQL запрос для получения количества элементов
$count_sql = "SELECT COUNT(*) FROM `sklad_tovar` ";
// Отправляем запрос для получения количества элементов
$result = mysqli_query($mysqli, $count_sql);
// Получаем результат
$total_rows = mysqli_fetch_array($result)[0];
// Вычисляем количество страниц
$total_pages = ceil($total_rows / $size_page);
