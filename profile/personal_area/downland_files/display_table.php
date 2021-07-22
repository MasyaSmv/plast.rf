<!DOCTYPE html>
<html>
    <head>
        <title>Загрузка файла</title>
        <?php
            include ('../../../header.php');
            include ('../../../dbconnect.php');
            include ('left_menu.html');

            $limit = 100;

            if (isset($_POST['page_no'])) {
                $page_no = $_POST['page_no'];
            }else{
                $page_no = 1;
            }


            $offset = ($page_no-1) * $limit;

            $sql = "SELECT title,size,quant,unit,color,sity, SUM(quant)
                    FROM `sklad_tovar`
                    WHERE id_user = {$_SESSION['id']}
                    GROUP BY title,size,color,sity
                    HAVING quant > 0
                    /* AND unit = 'км'       Баг с группировкой разных величин (надо пофиксить) */
                    LIMIT $offset, $limit";

            $result = $mysqli->query($sql);

            $output = "";

            ?>
    </head>
    <body>
        <div class="btOP43 table-responsive-xxl" style="text-align: -webkit-center;">
            <table class="display table table-dark" id="table_id" style="width: 50%; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Сечение</th>
                        <th scope="col">Длина</th>
                        <th scope="col">Ед. измерения</th>
                        <th scope="col">Цвет</th>
                        <th scope="col">Город</th>
                    </tr>
                </thead>
                <?
                    $i = 1;
                    while ($pow = mysqli_fetch_array($result)) {?>
                <tbody>
                    <tr>
                        <th scope="row"><?echo $i++ ;?></th>
                        <td><?echo $pow['title'] ;?></td>
                        <td><?echo $pow['size'] ;?></td>
                        <td><?echo $pow['SUM(quant)'] ;?></td>
                        <td><?echo $pow['unit'] ;?></td>
                        <td><?echo $pow['color'] ;?></td>
                        <td><?echo  $pow['sity'] ;?></td>
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
