<!DOCTYPE html>
<html>
<head>
  <title>Загрузка файла</title>
<?php
include ('../../../header.php');
include ('../../../dbconnect.php');
include ('../left_menu.html');

//запрос в бд с суммой столбца длины и групировкой одинаковых позций
$sql = "SELECT title,size,quant,unit,color,sity, SUM(quant)
        FROM `sklad_tovar`
        WHERE id_user = {$_SESSION['id']}
        GROUP BY title,size,color,sity";

$result = $mysqli->query($sql);
?>
</head>
<body>

<div class="btOP43 table-responsive-xxl" style="text-align: -webkit-center;">
<table class="table table-dark" style="width: 50%; text-align: center;">
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
<?}?>
  </tbody>
</table>

</div>
</body>
</html>
