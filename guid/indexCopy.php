<?
include("../header.php");
include("../dbconnect.php");
$rc_kpp_groups = "SELECT * FROM `rc_kpp_groups`";
?>
<div class="main">
    <div class="rightCol">
        <a>
            <?
            if ($result = $mysqli->query($rc_kpp_groups)) {
                $rowsCount = $result->num_rows; // количество полученных строк
                echo "<p>Получено объектов: $rowsCount</p>";
                echo "<table><tr><th>Id</th><th>Имя</th></tr>";
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                $result->free();
            } else {
                echo "Ошибка: " . $mysqli->error;
            }
            $mysqli->close();
            ?>
        </a>
    </div>
