<?
    $title = "Новости";
    require_once "app/header.php";
?>
<div class="main">
    <div class="rightCol">
    <?php
                $page = isset($_GET['page']) ? $_GET['page']: 1;
                $news = get_news();
                $i = 1;
            ?>
<?php
foreach($news as $new):
    echo "<table><tr>";
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    ?>
<td><a href="/newsCard.php?new_id=<?=$new['newsid']?>"><?=$new['title']?></a></td>
<?echo "</tr>";?>
<?php endforeach;
echo "</table>";
?>


<!-- ------------------------------------------- -->
<!-- <?
            if ($result = $mysqli->query($rc_kpp_groups)) {
                $rowsCount = $result->num_rows; // количество полученных строк
                $i = 1;
                echo "<p>Получено объектов: $rowsCount</p>";
                echo "<table><tr><th>Id</th><th>Имя</th></tr>";
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $i++ . "</td>";
                    echo "<td><a>" . $row["mark"] . "</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                $result->free();
            } else {
                echo "Ошибка: " . $mysqli->error;
            }
            $mysqli->close();
            ?> -->
    </div>
