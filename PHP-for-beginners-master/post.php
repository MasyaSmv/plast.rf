<?php

ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'E_ALL');
ini_set('display_startup_errors', 'E_ALL');

$post_id = $_GET['post_id'];

//ЕСЛИ В POST_ID НЕ ЧИСЛА, ОСТАНОВИМ СКРИПТ
if (!is_numeric($post_id)) exit();

require_once 'app/header.php';

//ПОЛУЧАЕМ МАССИВ ПОСТА
$post = get_post_by_id($post_id);
?>


<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h1><?=$post['subtitle']?></h1>
            </div>
            <ul class="list-inline">
                <li><i class="glyphicon glyphicon-list"></i> <a href="#">Название категории</a> | </li>
                <li><i class="glyphicon glyphicon-calendar"></i> 14 июля 2016 21:00
            </ul>
            <hr>
            <div class="post-content">
                <img src="<?=$post['image']?>" align="left" style="padding: 0 10px 10px 0;">
                <?=$post['content']?>
            </div>
        </div>
        <div class="col-md-3">
            sidebar
        </div>
    </div>
</div>


<?php
    include_once 'app/footer.php';
?>
