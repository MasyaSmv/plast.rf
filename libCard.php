<?php

ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'E_ALL');
ini_set('display_startup_errors', 'E_ALL');

$lib_id = $_GET['lib_id'];

//ЕСЛИ В company_ID НЕ ЧИСЛА, ОСТАНОВИМ СКРИПТ
if (!is_numeric($library_id)) exit();

require_once 'app/header.php';

//ПОЛУЧАЕМ МАССИВ ПОСТА
$lib = get_library_by_id($lib_id);
?>

<div class="main">
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h1><?=$lib['title']?></h1>
            </div>
            <hr>
            <div class="company-content">
                <img src="<?=$lib['image']?>" align="left" style="padding: 0 10px 10px 0;">
                <?=$lib['text']?>
            </div>
        </div>
    </div>
</div>
</div>
