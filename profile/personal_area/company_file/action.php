<?php

	session_start();
    include ('../../../dbconnect.php');

    // Скрипт для мобильного телефона
    if (isset($_POST["btn_submit_number"])) {
        $inputNumber = $_POST["inputNumber"];
        $inputNumber = preg_replace("/(?:\+|\d)[\d\-\(\) ]{9,}\d/g", "", $inputNumber,);

        var_dump($inputNumber);
        header("Location: contact_company.php");
    }






// регулярка для мобилы               /(?:\+|\d)[\d\-\(\) ]{9,}\d/g











    // Скрипт кнопки ссылки сайта
	if(isset($_POST["btn_submit_site"])){
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
        $id_user = $_SESSION['id'];
        // Условие (если в сесси нет записи сайта - записывает в бд)/(если есть запись в сессии - обновляет по айдишнику)
        if ($_SESSION['site'] === 0) {
            $sqlCity = "INSERT INTO company (site, id_user) VALUES('$site', '{$_SESSION['id']}')";
            $mysqli->query($sqlCity);
        } else {
            $sqlCity = "UPDATE company SET site='$site' WHERE id_user='$id_user'";
            $mysqli->query($sqlCity);
        }
        // удаляет старое название  компани из сессии и перезаписывает его на новый
        unset($_SESSION['site']);
        $_SESSION['site'] = $site;
        header("Location: contact_company.php");

    }

    // Скрипт кнопки смены имени компании
    if (isset($_POST["btn_save_name"])) {
        $sname = $_POST["saveName"];
        // Почему-то нормальная регулярка не работает, а выяснять почему пока лень, да и много друго надо сделать
        $sname = str_replace(array(',', '"', "'", '«', '»', '!', '@', '<', '>', '#', '%', '$', '^', '&', '*', '(', ')', '_', '=', '+', '/', '?', "|", ';', ':', '.'), '', $sname);
        $sqlsName = "UPDATE users SET company='$sname' WHERE company='{$_SESSION['company']}'";
        $mysqli->query($sqlsName);
        // удаляет старое название  компани из сессии и перезаписывает его на новый
        unset($_SESSION['company']);
        $_SESSION['company'] = $sname;
        header("Location: main_info.php");
    }
