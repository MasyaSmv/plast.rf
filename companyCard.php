<?php

ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'E_ALL');
ini_set('display_startup_errors', 'E_ALL');

$company_id = $_GET['company_id'];

//ЕСЛИ В company_ID НЕ ЧИСЛА, ОСТАНОВИМ СКРИПТ
if (!is_numeric($company_id)) exit();

require_once 'app/header.php';

//ПОЛУЧАЕМ МАССИВ ПОСТА
$company = get_company_by_id($company_id);
?>

<div class="main">
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h1><?=$company['title']?></h1>
            </div>
            <hr>
            <div class="company-content">
                <img src="<?=$company['logo']?>" align="left" style="padding: 0 10px 10px 0;">
                <?=$company['full_text']?>
            </div>
        </div>
    </div>
</div>
</div>
