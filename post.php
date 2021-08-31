<?
$post_id = $_GET['post_id'];
if (!is_numeric($post_id)) exit();
require_once 'app/header.php';
$post = get_post_by_id($post_id);
?>
