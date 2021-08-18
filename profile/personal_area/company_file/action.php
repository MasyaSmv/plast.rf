<?php

session_start();
include '../../../dbconnect.php';
$id_user = $_SESSION['id'];

// Скрипт для мобильного телефона
if (isset($_POST["btn_comp_phone"])) {
    $compPhone = $_POST["compPhone"];

    if (preg_match(("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/"), $compPhone)) {

        // Условие (если в сесси нет записи сайта - записывает в бд)/(если есть запись в сессии - обновляет по айдишнику)
        if ($_SESSION['compPhone'] === 0) {
            $sqlComNum = "INSERT INTO company (numphone, id_user) VALUES('$compPhone', '{$_SESSION['id']}')";
            $mysqli->query($sqlComNum);
        } else {
            $sqlComNum = "UPDATE company SET numphone='$compPhone' WHERE id_user='$id_user'";
            $mysqli->query($sqlComNum);
        }
        // удаляет старое название  компани из сессии и перезаписывает его на новый
        unset($_SESSION['compPhone']);
        $_SESSION['compPhone'] = $compPhone;
    } else {
        unset($_SESSION['compPhone']);
        echo ('Неверно введен телефон');
    }
    ;
    echo '<pre>';
    var_dump($compPhone);
    header("Location: contact_company.php");
    exit();
}

// Скрипт добавления адресных данных             ============ ВЕРНУТЬСЯ К СКРИПТУ =============
if (isset($_POST["btn_submit_adress"])) {
    $state = $_POST['state'];
    $sqlState = "UPDATE company
SET state_id =
SELECT (`id`)
FROM `state_id`
WHERE state_ru = '$state', id_user= '$id_user'";
    echo '<pre>';
    var_dump($state);
    var_dump($sqlState);
    exit();
}

// Скрипт кнопки ссылки сайта
if (isset($_POST["btn_submit_site"])) {
    // Убираем слэши и пробелы
    $site = str_replace("/", "", trim($_POST["site"]));
    // Переменные для поиска протоколов
    $scheme0 = "http";
    $scheme0 = "https";
    // Сам поиск в ссылке
    $pos0 = strripos($site, $scheme0);
    $pos1 = strripos($site, $scheme0);
    // Условие (если есть протоколы - вырезает)/(если нет протоколов - просто оставляет домен)
    if ($pos0 === true || $pos1 === true) {
        $site = parse_url($site, PHP_URL_HOST);
    } else {
        $site = parse_url($site);
        $site = $site['path'];
    }
    // Условие (если в сесси нет записи сайта - записывает в бд)/(если есть запись в сессии - обновляет по айдишнику)
    if ($_SESSION['site'] === 0) {
        $sqlSite = "INSERT INTO company (site, id_user) VALUES('$site', '{$_SESSION['id']}')";
        $mysqli->query($sqlSite);
    } else {
        $sqlSite = "UPDATE company SET site='$site' WHERE id_user='$id_user'";
        $mysqli->query($sqlSite);
    }
    // удаляет старое название  компани из сессии и перезаписывает его на новый
    unset($_SESSION['site']);
    $_SESSION['site'] = $site;
    header("Location: contact_company.php");
    exit();
}

// Скрипт кнопки смены имени компании
if (isset($_POST["btn_save_name"])) {
    $sname = $_POST["saveName"];
    // Почему-то нормальная регулярка не работает, а выяснять почему пока лень, да и много друго надо сделать
    $sname = str_replace(array(',', '"', "'", '«', '»', '!', '@', '<', '>', '#', '%', '$', '^', '&', '*', '(', ')', '_', '=', '+', '/', '?', "|", ';', ':', '.'), '', $sname);
    $sqlsName = "UPDATE users SET company='$sname' WHERE company='{$_SESSION['company']}'";
    $sqlsCompName = "UPDATE company SET title='$sname' WHERE title='{$_SESSION['company']}'";
    $mysqli->query($sqlsName);
    $mysqli->query($sqlsCompName);
    // удаляет старое название  компани из сессии и перезаписывает его на новый
    unset($_SESSION['company']);
    $_SESSION['company'] = $sname;
    header("Location: main_info.php");
    exit();
}


