<?php
// include_once("$DOCUMENT_ROOT/func.inc");// подключаем функции работы с базой

$file_name = "letters.txt"; //Бекап плейлиста, сохраняется последний удачный запрос
$file = "$DOCUMENT_ROOT/test/podcast/parser/$file_name";

// d($file,1,1);
$memcache = new Memcache;
$memcache->connect('192.168.0.2', 11211);

$mkey = 'podcast_playlist';
$vkey = $memcache->get($mkey);
// d($vkey,1,1);

if($vkey){
  $playlist = $vkey;
}else{

  $url = 'http://kabel.fm';
  $html = file_get_contents($url);
  $html = str_replace("\n", "", $html);

  // Извлекаем плейлист
  preg_match_all('/<div class="playlist">(.+)<div class="album-player"/', $html, $out);
  mb_convert_variables( "windows-1251", 'ASCII,UTF-8,SJIS-win', $out);

  //Разбиваем плейлист на элементы
  preg_match_all('/<li(.+)\<span/U', implode($out[0]), $matches, PREG_OFFSET_CAPTURE);
  $playlist = array();
  if(count($matches[0])){  //Если блок нашелся то бберем его

    foreach ($matches[0] as $k => $v) {
      $track = array();
      $v[0] = trim($v[0], "<li..><span"); //чистим справа, слева
      $track[] = explode("data-",$v[0]);

      foreach ($track as $k2 => $v2) {
        $tr = array();

        foreach ($v2 as $k3 => $v3) {
          preg_match_all('/(.*)="(.*)"/', $v3, $track_v); //разбиваем строку на КЛЮЧ - ЗНАЧЕНИЕ
          if(!empty($track_v[1][0]))
            $tr[$track_v[1][0]] = $track_v[2][0]; //Ассоциативный массив делаем
        }
        $playlist[] = $tr;
      }
    }
    // $memcache->set($mkey,$playlist, false, 3600*24*7);
    $memcache->set($mkey,$playlist, false, 60);

    // Дополнительный вариант, берем из файла
    // ( на случай, если домен во время запроса будет недоступен или блок с плейлистом не найдет, поменяется верстка )
    $data = serialize($playlist);
    $f = fopen($file, "w");
    fwrite($f, $data);
    fclose($f);

  }else{ // в противном случае грузим из файла

    if(file_exists($file)){
      $data = file_get_contents($file);
      $playlist = unserialize($data);
    }

  }


}
// d($playlist);
