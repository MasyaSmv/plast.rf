<?
    $title = "Литература";
    require_once "app/header.php";
    require_once "simplehtmldom_1_9_1/simple_html_dom.php";
?>
 <div class="main">
    <div class="rightCol">
       <?
    $page = isset($_GET['page']) ? $_GET['page']: 1;
                $library = get_library();
                $i = 1;
            ?>
<?php
foreach($library as $lib):
    echo "<table><tr>";
    echo "<tr>";
    ?>
<td><img src="https://plastinfo.ru<?=$lib['image']?>"></img></td>
<td><h1><?=$lib['title']?></h1>
<p><?=$lib['text']?></p></td>
<?echo "</tr>";
// echo '<pre>';
// var_dump($lib['image']);
?>
<?php endforeach;
echo "</table>";
?>













<!-- =================НИЖЕ ПАРСЕР КНИГ С ПОЛИМЕРОВ================== -->
<!-- <?
$html = file_get_html('https://plastinfo.ru/information/literature/page7/');

foreach($html->find('tr[valign="top"]') as $row) {
    $item['h1'] = $row->find('strong',0)->plaintext;
    $item['text'] = $row->find('p',0)->plaintext;
    $item['image'] = $row->find('img',0)->src;

$h1 = $item['h1'];
$text = $item['text'];
$image = $item['image'];

    $table[] = $item;
    $link -> query("INSERT INTO library SET `title` = '$h1', `text` = '$text', `image` = '$image'");
    echo '<pre>';
    print_r($h1);
    echo '<pre>';
    print_r($text);
    echo '<pre>';
    print_r($image);

}


        ?> -->
</div>
</div>
