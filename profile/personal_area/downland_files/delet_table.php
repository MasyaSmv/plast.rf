<?php
session_start();
include ('../../../dbconnect.php');

if (isset($_POST["btn_delet_table"])) {

    $sql = $mysqli -> query("DELETE FROM sklad_tovar WHERE id_user = {$_SESSION['id']}");

    if (!$sql) {
        $pussy = "<p class='pussy_error'><strong>Ошибка!</strong> При удалении товаров произошла ошибка </p><p>Описание ошибки: $mysqli->error <br /> Код ошибки: $mysqli->errno </p>";

    } else {
        $pussy = "<p class='success_pussy'> Данные успешно удалены <br /> Теперь Вы можете загрузить их заново </p>";

    }


} else {

    exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. ");
}

header("Location: display_table.php");
