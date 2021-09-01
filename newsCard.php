<?php

ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'E_ALL');
ini_set('display_startup_errors', 'E_ALL');

$new_id = $_GET['new_id'];

//ЕСЛИ В company_ID НЕ ЧИСЛА, ОСТАНОВИМ СКРИПТ
if (!is_numeric($new_id)) exit();

require_once 'app/header.php';

//ПОЛУЧАЕМ МАССИВ ПОСТА
$new = get_news_by_id($new_id);
?>

<div class="main">
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h1><?=$new['title']?></h1>
            </div>
            <hr>
            <div class="company-content">
                <img src="<?=$new['img']?>" align="left" style="padding: 0 10px 10px 0;">
                <?=$new['text']?>
            </div>
        </div>
    </div>
</div>
</div>
