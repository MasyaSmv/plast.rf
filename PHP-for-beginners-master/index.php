<?php

ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'E_ALL');
ini_set('display_startup_errors', 'E_ALL');

require_once 'app/header.php';

$IntlDateFormatter = datefmt_create(
    'ru_RU',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Moscow',
    IntlDateFormatter::GREGORIAN,
    'd MMMM yyyy, EEEE H:mm'
);

?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h1>Все записи:</h1>
                <select name="page-select" id="page-select" class="form-control pull-right">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <hr/>
            <?php
                $page = isset($_GET['page']) ? $_GET['page']: 1;
                $limit = 5;
                $offset = $limit * ($page - 1);

                $posts = get_posts($limit, $offset);
            ?>
            <?php foreach($posts as $post): ?>
            <div class="row">
                <div class="col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?=$post['image']?>" alt="">
                    </a>
                </div>
                <div class="col-md-9">
                    <h4><a href="/post.php?post_id=<?=$post['id']?>"><?=$post['title']?></a></h4>
                    <p>
                      <?=mb_substr($post['content'], 0, 128, 'UTF-8').'...'?>
                    </p>
                    <p><a class="btn btn-info btn-sm" href="/post.php?post_id=<?=$post['id']?>">Читать полностью...</a></p>
                    <br/>
                    <ul class="list-inline">
                        <li><i class="glyphicon glyphicon-list"></i> <a href="#">Категория</a> | </li>
                        <li><i class="glyphicon glyphicon-calendar"></i> <?=datefmt_format($IntlDateFormatter, $post['created_at'])?>
                        <!--<?=date('d/m/Y H:i', $post['created_at'])?>-->
                    </ul>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
        </div>
        <div class="col-md-3">
            <?php include_once 'app/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php

include_once 'app/footer.php';

?>
