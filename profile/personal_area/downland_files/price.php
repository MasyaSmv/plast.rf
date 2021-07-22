<!DOCTYPE html>
<html>
    <head>
        <title>Загрузка прайса</title>
        <?php
            include ('../../../header.php');
            include ('left_menu.html');
            include ('paginator_table.php');
            // include ('../../../dbconnect.php');
            ?>

<?php

$limit = 100;

if (isset($_POST['page_no'])) {
    $page_no = $_POST['page_no'];
}else{
    $page_no = 1;
}


$offset = ($page_no-1) * $limit;

$sql = "SELECT *
        FROM `price`
        WHERE id_user = {$_SESSION['id']}
        /* GROUP BY title,size,color,sity
        HAVING quant > 0 */
        /* AND unit = 'км'       Баг с группировкой разных величин (надо пофиксить) */
        LIMIT $offset, $limit";

$result = $mysqli->query($sql);

$output = "";

?>
    </head>
    <body>
    <div class="upload_file" style="text-align: center;">
<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="up_price.php" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="210000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Загружай файл пидрила: <input name="userfile" type="file" /> <br> <br>
    <input type="submit" value="Отправить файл" />
</form>

        <div class="btOP43 table-responsive-xxl" style="text-align: -webkit-center;">
            <table class="display table table-dark" id="table_id" style="width: 50%; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">номенклатура</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Ед. измерения</th>
                        <th scope="col">Гоаст/ТУ</th>
                    </tr>
                </thead>
                <?
                    $i = 1;
                    while ($pow = mysqli_fetch_array($result)) {?>
                <tbody>
                    <tr>
                        <th scope="row"><?echo $i++ ;?></th>
                        <td><?echo $pow['title'] ;?></td>
                        <td><?echo $pow['nomenclature'] ;?></td>
                        <td><?echo $pow['price'] ;?></td>
                        <td><?echo $pow['unit'] ;?></td>
                        <td><?echo $pow['gost/tu'] ;?></td>
                    </tr>
                    <?}
                        echo '<pre>';
                        print_r($_SESSION);
                        ?>
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: center;">
            <form action="delet_table.php" method="POST" name="btn_dlt_tbl">
                <div class="form-group"><br />
                    <input class="btn btn-primary btn-block" type="submit" name="btn_delet_table" value="Delet table">
                </div>
            </form>
        </div>

    </body>
</html>
