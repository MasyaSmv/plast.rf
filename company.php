<?
    $title = "Компании";
    require_once "app/header.php";
?>
<div class="main">
    <div class="rightCol">
    <?php
                $page = isset($_GET['page']) ? $_GET['page']: 1;
                $companys = get_company();
                $i = 1;
            ?>
<?php
foreach($companys as $company):
    echo "<table><tr>";
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    ?>
<td><a href="/companyCard.php?company_id=<?=$company['id']?>"><?=$company['title']?></a></td>
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
