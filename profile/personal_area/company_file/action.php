<?php

	session_start();

    include ('../../../dbconnect.php');
	if(isset($_POST["btn_submit_register"])){
        // Сделать регулярку для удаления https
        $site = trim($_POST["site"]);
        $id_user = $_SESSION['id'];
        $sql = "INSERT INTO company (site, id_user) VALUES(?,?)"; // заменим переменные на специальные маркеры
        $site = $mysqli->real_escape_string($site); //Экранирование
        $site = preg_replace('^(https?:\/\/)?', '', $site);
        $stmt = $mysqli->prepare($sql); // подготовим запрос к выполнению.
        $stmt->bind_param("ss", $site, $id_user); // привяжем к нему переменные
        $stmt->execute(); // и выполним его
        header("Location: contact_company.php");
    } else {
        exit ("ashipka");
    }
