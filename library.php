<?
    $title = "Литература";
    require_once "app/header.php";
    require_once "simplehtmldom_1_9_1/simple_html_dom.php";
?>
<div class="main">
    <div class="rightCol">
        <?
$table = array();

$html = file_get_html('https://plastinfo.ru/information/literature/page1/');
foreach($html->find('tr[valign="top"]') as $row) {
    $image = $row->find('img',0)->plaintext;
    $text = $row->find('td',1)->plaintext;
    // $title = $row->find('td',2)->plaintext;

    $table[$image][$text] = true;
}
foreach($html->find('img') as $element)
       echo $element->src . '<br>';

// echo '<pre>';
// echo $image -> src. '<br>';
// echo '</pre>';
        ?>
</div>
</div>
