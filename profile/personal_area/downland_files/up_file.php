
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
  <div class="upload_file" style="text-align: center;">
<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="210000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Загружай файл пидрила: <input name="userfile" type="file" /> <br> <br>
    Город: <input name="sity" type="text" />
    <input type="submit" value="Отправить файл" />
</form>
  </div>
  <?

  ?>
</body>
</html>
