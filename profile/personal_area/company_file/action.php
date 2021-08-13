<?php

	session_start();
    include ('../../../dbconnect.php');

    // Скрипт для мобильного телефона
    if (isset($_POST["btn_submit_number"])) {
        $inputNumber = $_POST["inputNumber"];
        $inputNumber = preg_replace("/(?:\+|\d)[\d\-\(\) ]{9,}\d/g", "", $inputNumber,);

        var_dump($inputNumber);
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
        $sqlCity = "INSERT INTO company (site, id_user) VALUES('$site', '{$_SESSION['id']}')"; // заменим переменные на специальные маркеры
        $mysqli->query($sqlCity);
        header("Location: contact_company.php");
    }


    // Скрипт кнопки смены имени компании
    if (isset($_POST["btn_save_name"])) {
        $sname = $_POST["saveName"];

        $sqlsName = "UPDATE users SET company='$sname' WHERE company='{$_SESSION['company']}'";
        $mysqli->query($sqlsName);
        var_dump($saveName);
        var_dump($sname);
        var_dump($sqlsName);
        header("Location: main_info.php");
    }
