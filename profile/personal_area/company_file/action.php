<?php

session_start();
include '../../../sql_scripts.php';

// Скрипт для мобильного телефона
if (isset($_POST["btn_comp_phone"])) {
    $compPhone = $_POST["compPhone"];
    if (preg_match(("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/"), $compPhone)) {
        // Условие (если в сесси нет записи телефона - записывает в бд)/(если есть запись в сессии - обновляет по айдишнику)
        if ($_SESSION['compPhone'] === 0) {
            $sqlComNum = "INSERT INTO company (numphone, id_user) VALUES('$compPhone', '{$_SESSION['id']}')";
            $mysqli->query($sqlComNum);
        } else {
            $sqlComNum = "UPDATE company SET numphone='$compPhone' WHERE id_user='{$_SESSION['id']}'";
            $mysqli->query($sqlComNum);
        }
        header("Location: contact_company.php");
    } else {
        echo ('Неверно введен телефон');
    };
    echo '<pre>';
    var_dump($compPhone);
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
    if ($site = preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', trim($_POST["site"]))) {
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
    if ($company_arr['site'] === 0) {
        $sqlSite = "INSERT INTO company (site, id_user) VALUES('$site', '{$_SESSION['id']}')";
        $mysqli->query($sqlSite);
    } else {
        $sqlSite = "UPDATE company SET site='$site' WHERE id_user='{$_SESSION['id']}'";
        $mysqli->query($sqlSite);
    }
    header("Location: contact_company.php");
    exit();
    }else{
        echo ('Чота не так с ссылкой');
    }
}

// Скрипт кнопки смены имени компании
if (isset($_POST["btn_save_name"])) {
    $sname = $_POST["saveName"];
    // Почему-то нормальная регулярка не работает, а выяснять почему пока лень, да и много друго надо сделать
    $sname = str_replace(array(',', '"', "'", '«', '»', '!', '@', '<', '>', '#', '%', '$', '^', '&', '*', '(', ')', '_', '=', '+', '/', '?', "|", ';', ':', '.'), '', $sname);
    $sqlsName = "UPDATE users SET company='$sname' WHERE company='{$user_arr['company']}'";
    $sqlsCompName = "UPDATE company SET title='$sname' WHERE title='{$company_arr['compName']}'";
    $mysqli->query($sqlsName);
    $mysqli->query($sqlsCompName);
    header("Location: main_info.php");
    exit();
}

// Скрипт кнопки почты
if (isset($_POST["btn_comp_mail"])) {
    $compMail = $_POST["compMail"];
    if (preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/', $compMail)) {
        // Условие (если в сесси нет записи почты - записывает в бд)/(если есть запись в сессии - обновляет по айдишнику)
        if ($company_arr['compMail'] === 0) {
            $sqlCompMail = "INSERT INTO company (email, id_user) VALUES('$compMail', '{$_SESSION['id']}')";
            $mysqli->query($sqlCompMail);
        } else {
            $sqlCompMail = "UPDATE company SET email='$compMail' WHERE id_user='{$_SESSION['id']}'";
            $mysqli->query($sqlCompMail);
        }
        header("Location: contact_company.php");
    } else {
        echo ('Данные почты не верны и будут кастрированны');
    };
    echo '<pre>';
    var_dump($compMail);
    exit();
}

// Скрипт кнопки Инн
if (isset($_POST["btn_submit_inn"])) {
    $inn = $_POST["inn"];
    if (preg_match('/^[\d+]{10,12}$/', $inn)) {
        // Условие (если в сесси нет записи сайта - записывает в бд)/(если есть запись в сессии - обновляет по айдишнику)
        if ($company_arr['inn'] === 0) {
            $sqlInn = "INSERT INTO company (inn, id_user) VALUES ('$inn', '{$_SESSION['id']}')";
            $mysqli->query($sqlInn);
        } else {
            $sqlInn = "UPDATE company SET inn='$inn' WHERE id_user='{$_SESSION['id']}'";
            $mysqli->query($sqlInn);
        }
        header("Location: contact_company.php");
    } else {
        echo ('Уебанский Инн');
    };
    echo '<pre>';
    var_dump($inn);
    exit();
}
