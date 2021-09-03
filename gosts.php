<?
    $title = "Литература";
    require_once "app/header.php";
    require_once "simplehtmldom_1_9_1/simple_html_dom.php";
    ini_set('max_execution_time', 900);
    ini_set("memory_limit", "400M");
?>
 <div class="main">
    <div class="rightCol">
<?
$html = file_get_html('https://gost.ruscable.ru/list.htm');

foreach($html->find('tr') as $row) {

    $item['gost'] = $row->find('td',0)->plaintext;
    $item['text'] = $row->find('td',1)->plaintext;
    $item['date'] = $row->find('td',2)->plaintext;

    $gost = $item['gost'];
    $text = $item['text'];
    $date = $item['date'];

    $fck = array_slice($table, 0, 5); //! эта куета не раобтает

    $table[] = $item;

        // $link -> query("INSERT INTO gost SET `title` = '$text', `gost` = '$gost', `date` = '$date'");
        // echo '<pre>';
        // print_r($text);
        // echo '<pre>';
        // print_r($date);
        // echo($table);
        echo '<pre>';
        print_r(array_slice($item, 1, true)); //! эта куета не раобтает


}


        ?>
</div>
</div>
