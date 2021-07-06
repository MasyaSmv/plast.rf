
<!DOCTYPE html>
<html>
<head>
  <title>Загрузка файла</title>
  <?php
  include ('../../../header.php');
  include ('../left_menu.html');
  ?>
</head>
<body>
  <!-- Блок загрузки файла -->
  <div class="upload_file" style="text-align: center;">
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="210000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Загружай файл пидрила: <input name="userfile" type="file" /> <br> <br>
    Город: <input name="sity" type="text" />
    <input type="submit" value="Отправить файл" />
    <?
echo "\n Некоторая отладочная информация:";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
  ?>
</form>
  </div>

</body>
</html>
