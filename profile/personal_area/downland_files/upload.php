<?php
include ('../../../header.php');
include ('F:/XAMPP/htdocs/dbconnect.php');

$uploaddir = 'uploaded_files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

$file = fopen('test.csv', 'r');

echo '<table cellspacing = "0" border = "1" width = "500"></table>';
while (!feof($file)) {
  $mass = fgetcsv($file, 1024, ';');
  $j = count ($mass);
  if ($j > 1) {
    echo '<tr align = "center">';
      echo '<td width = "25%">';
      echo $mass[0];
      echo '</td>';
      echo '<td width = "25%">';
      echo $mass[1];
      echo '</td>';
      echo '<td width = "25%">';
      echo $mass[2];
      echo '</td>';
    echo '</tr>';
      $mysqli -> query ("INSERT INTO `sklad_tovar` (`name`, `quantity`, `unit`) VALUES ('{$mass[0]}','{$mass[1]}','{$mass[2]}')");
  }
}

echo '</table>';
fclose($file);
$mysqli -> close();


// $loadfile = $_POST['userfile']; // получаем имя загруженного файла
// require_once $_SERVER['DOCUMENT_ROOT']."/Classes/PHPExcel/IOFactory.php"; // подключаем класс для доступа к файлу
// $objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/uploads_file/".$uploadfile);
// foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) // цикл обходит страницы файла
// {
//   $highestRow = $worksheet->getHighestRow(); // получаем количество строк
//   $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок

//   for ($row = 1; $row <= $highestRow; ++ $row) // обходим все строки
//   {
//     $cell1 = $worksheet->getCellByColumnAndRow(0, $row); //Name
//     $cell2 = $worksheet->getCellByColumnAndRow(1, $row); //quantity
//     $cell3 = $worksheet->getCellByColumnAndRow(2, $row); //unit

//     $mysqli -> query ("INSERT INTO `sklad_tovar` (`name`, `quantity`, `unit`) VALUES ('{$cell1}','{$cell2}','{$cell3}')");
//     $query = mysqli_query($link,$sql) or die('Ошибка чтения записи: '.mysqli_error($mysql));
//   }
// }

// $mysqli->close();
// $sql = "INSERT INTO `sklad_tovar` (`name`, `quantity`, `unit`) VALUES ('$cell','$cell2','$cell3')";
// if (!mysqli_query($link, $con)) {
//   die('Error: ' . mysqli_error($mysql));
// }

echo 'Некоторая отладочная информация:';
print_r($_FILES);

print "</pre>";






// $message = '';
// if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
// {
//   if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
//   {
//     // получение подробной инфы о файле
//     $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
//     $fileName = $_FILES['uploadedFile']['name'];
//     $fileSize = $_FILES['uploadedFile']['size'];
//     $fileType = $_FILES['uploadedFile']['type'];
//     $fileNameCmps = explode(".", $fileName);
//     $fileExtension = strtolower(end($fileNameCmps));
//     // $id = $mysqli->query("SELECT id FROM `users` WHERE id = '".session_id()."'");

//     // очистка имени файла
//     $newFileName = date("Y.m.d").'_'.md5(time() . $fileName) . '.' . $fileExtension;

//     // проверка расширений файла
//     $allowedfileExtensions = array('jpg', 'gif', 'png', 'csv', 'zip', 'txt', 'xls', 'xlsx', 'doc');

//     if (in_array($fileExtension, $allowedfileExtensions))
//     {
//       // каталог загрузки файла
//       $uploadFileDir = './uploaded_files/';
//       $dest_path = $uploadFileDir . $newFileName;

//       if(move_uploaded_file($fileTmpPath, $dest_path))
//       {
//         $message ='File is successfully uploaded.';
//       }
//       else
//       {
//         $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
//       }
//     }
//     else
//     {
//       $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
//     }
//   }
//   else
//   {
//     $message = 'There is some error in the file upload. Please check the following error.<br>';
//     $message .= 'Error:' . $_FILES['uploadedFile']['error'];
//   }
// }
// $_SESSION['message'] = $message;







// header("Location: up_file.php");
