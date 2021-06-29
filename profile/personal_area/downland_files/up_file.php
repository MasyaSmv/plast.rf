
<!DOCTYPE html>
<html>
<head>
  <title>Загрузка файла</title>
  <?php include ('../../../header.php');
  ?>
</head>
<body>
  <div class="upload_file">
<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="210000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" /> <br> <br>
    Описание: <input name="text" type="text" />
    <input type="submit" value="Отправить файл" />
</form>
  </div>
</body>
</html>
