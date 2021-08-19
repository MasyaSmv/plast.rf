<?php
include ('../dbconnect.php')
if(isset($_FILES['file'])) {

  if ($_FILES['file']['name'] !== '' && $_FILES['file']['error'] == 0) {
    try {
      // MIME-типы нужно проверять ещё в JS коде и выводить ошибки пользователю
      // Сейчас они вываливаются во вкладке "Network" браузера
      $fileTmpName = $_FILES['file']['tmp_name'];
      $fi = finfo_open(FILEINFO_MIME_TYPE);
      $mime = (string) finfo_file($fi, $fileTmpName);
      if (strpos($mime, 'image') === false) die('Можно загружать только изображения с расширениями  .jpg, .jpeg, .png!');
      $image = getimagesize($fileTmpName);
      $extension = image_type_to_extension($image[2]);
      $name = randomFileName($extension);
      $file = $name.str_replace('jpeg', 'jpg', $extension);
      if (!move_uploaded_file($fileTmpName, __DIR__ . '/upload/'.$file)) {
          throw new Exception('При загрузке изображения произошла ошибка на сервере!');
      }
      // Записать имя файла в БД
    //   $db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'password');
      $user_id = $_SESSION['id'];
      $query = "UPDATE `users` SET `avatar` = :avatar WHERE `id` = :user_id";
      $params = [':avatar' => $file, ':user_id' => $user_id];
      $stmt = $db->prepare($query);
      if (!$stmt->execute($params)) {
          throw new Exception('Произошла ошибка при записи в БД!');
      }
      // Записать в $data имя файла
      $data = ['file' => $file];
      echo json_encode($data);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
}


// Генерируем уникальное имя для файла
function randomFileName($extension = false)
{
  $extension = $extension ? '.' . $extension : '';
  do {
    $name = md5(microtime() . rand(0, 9999));
    $file = $name . $extension;
  } while (file_exists($file));

  return $file;
}
