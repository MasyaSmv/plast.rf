<?
    $title = "ГОСТы";
    require_once "app/header.php";
    require_once "simplehtmldom_1_9_1/simple_html_dom.php";
?>
 <div class="main">
    <div class="rightCol">
       <?
    $page = isset($_GET['page']) ? $_GET['page']: 1;
                $gosts = get_gosts();
                $i = 1;
            ?>
<?php
foreach($gosts as $gost):
    echo "<table><tr>";
    echo "<tr>";
    ?>
<td><h3><?=$gost['gost']?></h3>
<p><?=$gost['title']?></p></td>
<?echo "</tr>";
// echo '<pre>';
// var_dump($lib['image']);
?>
<?php endforeach;
echo "</table>";
?>
</div>
</div>
