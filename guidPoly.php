<?
ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'E_ALL');
ini_set('display_startup_errors', 'E_ALL');

$post_id = $_GET['post_id'];
if (!is_numeric($post_id)) exit();
require_once 'app/header.php';
$post = get_post_by_id($post_id);
?>
<div class="main">
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h1><?=$post['subtitle']?></h1>
            </div>
            <hr>
            <div class="post-content">
                <img src="<?=$post['image']?>" align="left" style="padding: 0 10px 10px 0;">
                <?=$post['text']?>
            </div>
        </div>
    </div>
</div>
</div>
