<?php

include ('../../../header.php');
include ('../../../dbconnect.php');
include ('../left_menu.html');

$sql = "SELECT * FROM `sklad_tovar` ";
$result = $mysqli -> query($sql);

while ($pow = $result -> fetch_assoc()) {
    echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

        echo '<tr><td>' . 'Первый: '.$pow['title'] . '</td></tr>';
        echo "\n";
        echo '<tr><td>' . 'Второй: '.$pow['size'] . '</td></tr>';
        echo '<tr><td>' . 'Третий: '.$pow['quant'] . '</td></tr>';
        echo '<tr><td>' . 'Четвертый: '.$pow['unit'] . '</td></tr>';
        echo '<tr><td>' . 'Пятый: '.$pow['color'] . '</td></tr>';
        echo '<tr><td>' . 'Шестой: '.$pow['sity'] . '</td></tr>';

    echo '</table>';
}
//     echo 'Первый: '.$pow['title'];
//     echo 'Второй: '.$pow['size'];
//     echo 'Третий: '.$pow['quant'];
//     echo 'Четвертый: '.$pow['unit'];
//     echo 'Пятый: '.$pow['color'];
//     echo 'Шестой: '.$pow['sity'];
// }

?>
