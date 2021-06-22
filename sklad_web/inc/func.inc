<?
$start_time = microtime();
$start_array = explode(" ",$start_time);
$start_time = $start_array[1] + $start_array[0];
// бесплатных поисков по складу в месяц:
$max_free_searches=3;

session_start();
if(!function_exists('sql')){function sql($q){$res=array();$r=@mysql_query($q);if(@mysql_num_rows($r)>0){while($row=@mysql_fetch_row($r)){$res[]=$row;}}return $res;}}

if(!function_exists('ssql')){function ssql($q){return mysql_result(mysql_query($q),0,0);}}
//$db_server="192.168.0.1";
//$db_server2="localhost";
$db_server="localhost";
$db_server2="192.168.0.2";
//$db_server2="192.168.0.1";
$db_user="ruscableru";
$db_password="7o4hcdv3ef";
$db_database="ruscableru";
if(!function_exists('db_connect')){
function db_connect()
{
	global $db_server2, $db_user, $db_password, $db_database;
	static $connected = FALSE;
	if( $connected ) return; // уже подключены

	$connected = mysql_connect($db_server2, $db_user, $db_password) && mysql_select_db($db_database);
	if( !$connected ) { die("Невозможно подключиться к базе данных"); }else {mysql_query("set names utf8");}
}
}

db_connect();
if(!function_exists('db_connect2')){
function db_connect2()
{
        global $db_server2, $db_user, $db_password, $db_database;
	if($connected){@mysql_close();}
        $connected = mysql_connect($db_server2, $db_user, $db_password) && mysql_select_db($db_database);
        if( !$connected ) { die("Невозможно подключиться к базе данных"); }else {mysql_query("set names utf8");}
}
}



$sklad_uid=$sklad_cid=$free_searches=0;
if(isset($_SESSION['login']) && $_SESSION['login']!=""){$sklad_uid=$_SESSION['panel_user_id'];}
if(isset($_SESSION['company_id']) && $_SESSION['company_id']!=""){$sklad_cid=$_SESSION['company_id'];}

$authorized=0;
$action11_enabled="NO";
$action11=0;
$action11h=11;
//$action11h=18;
$action11mbegin=0;
$action11mend=12;
//$action11mend=59;
$actionUTCh=$action11h-4;
if($action11_enabled=="YES" && date("H")==$action11h && date("i")<$action11mend && date("i")>=$action11mbegin){
	$action11=1;
	$authorized=1;
	$free_searches=100000;
}else{
	//проверка на куку из информера
	if((isset($_COOKIE['informer']) && preg_match("/(.*)-\d+/",$_COOKIE['informer']) && strstr($_SERVER['REQUEST_URI'],$_COOKIE['informer']))||$_SESSION['informer_comp_id']>0){
		$authorized=2;
	}
	if($sklad_uid > 0){
	//if($sklad_uid > 0 && $sklad_cid > 0){
		//базовые данные есть, можно приступить к проверке.
		// есть ли платная актуальная услуга?
	//	$isplatn=ssql("select count(*) from company_usl_list where company_id=$sklad_cid and tarif_id=18 and date_begin <= CURDATE() and date_end >= CURDATE()");
	//	if($isplatn > 0){
			$authorized=2;
	//		$end_date=ssql("select date_end from company_usl_list where company_id=$sklad_cid and tarif_id=18 and date_begin <= CURDATE() and date_end >= CURDATE()");
			unset($_COOKIE['informer']);
			unset($_SESSION['informer_comp_id']);
			unset($_SESSION['informer_comp_name']);
	//	}else{
			// платной услуги нет, проверяем на бесплатную
	//		$isfree=ssql("select count(*) from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
	//		if($isfree > 0){
				//проверяем, сколько поисков уже сделано
	//			$start_date=ssql("select date_begin from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
	//			$end_date=ssql("select date_end from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
	//			$hassearch=ssql("select count(*) from sklad_free_access where c_id=$sklad_cid and vremya >='$start_date'");
	//			if($hassearch < $max_free_searches){
	//				$authorized=1;
	//				$free_searches=$max_free_searches-$hassearch;
	//			}else{
	//				$authorized=1;
	//				$free_searches=0;
	//			}
	//			unset($_COOKIE['informer']);
	//			unset($_SESSION['informer_comp_id']);
	//			unset($_SESSION['informer_comp_name']);

	//		}else{
	//			mysql_query("insert into company_usl_list set company_id=$sklad_cid, tarif_id=19, date_begin=CURDATE(), date_end=date_add(CURDATE(),INTERVAL +1 MONTH)");
	//			$authorized=1;
	//			$free_searches=$max_free_searches;
	//			$end_date=ssql("select date_end from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
	//			unset($_COOKIE['informer']);
	//			unset($_SESSION['informer_comp_id']);
	//			unset($_SESSION['informer_comp_name']);

	//		}

	//	}

	}
}

$perpage=30;
if(preg_match("/setrecordsperpage(\d+)/",$_GET['uri'],$match)){
	if( in_array($match[1],array(30,50,100,500)) ){
		$_SESSION['perpage']=$match[1];
	}else{
		$_SESSION['perpage']=30;
	}
	if($_SERVER['HTTP_REFERER']!=""){
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}else{
		header("Location: /");
	}
	exit;
}
if(isset($_SESSION['perpage']) && in_array($_SESSION['perpage'], array(30,50,100,500)))	{
	$perpage=$_SESSION['perpage'];
}


if(preg_match("/setcity(.*)$/",$_GET['uri'],$match)){
		$skladcity=mysql_real_escape_string(trim($match[1]));
		$_SESSION['sklad_city']=$skladcity;
		if($_SERVER['HTTP_REFERER']!=""){
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}else{
			header("Location: /");
		}
		exit;
}
if(isset($_SESSION['sklad_city'])){
	if($_SESSION['sklad_city']!="all"){
		$curcity=$_SESSION['sklad_city'];
	}else{
		$curcity="";
	}
}else{
	$curcity="";
}
if(preg_match("/setsort(.*)$/",$_GET['uri'],$match)){
		$setsort=mysql_real_escape_string(trim($match[1]));
		if($setsort == "default" || $setsort == "kolasc" || $setsort == "koldesc"){
			$_SESSION['setsort']=$setsort;
			if($_SERVER['HTTP_REFERER']!=""){
				header("Location: ".$_SERVER['HTTP_REFERER']);
			}else{
				header("Location: /");
			}
			exit;
		}
}
if($PANEL==1 && !$_SESSION['login']){
	header("Location: /"); exit;
}


$months=array("","января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
function show_head_date(){
	global $months;
	print "Сегодня " . date("j") . " " . $months[date("n")] . " " . date("Y") . " г.";
}



function img_resize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100)
{
  if (!file_exists($src)) return false;

  $size = getimagesize($src);

  if ($size === false) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($new_width, $new_height);

  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, 0, 0, 0, 0,
    $new_width, $new_height, $size[0], $size[1]);

  imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return true;

}


function show_links($page, $rows_onpage, $rows_num, $page_dir, $dopurl="")
{

$res="";

$sets=ceil($rows_num/$rows_onpage);


$pagenavi_options = array(
		'pages_text' => 'страница 222 из 1000',
		'current_text' => '222',
		'page_text' => '222',
		'first_text' => '&laquo;',
		'last_text' => '&raquo;',
		'next_text' => '&raquo;',
		'prev_text' =>'&laquo;',
		'dotright_text' =>'...',
		'dotleft_text' => '...',
		'style' => 1,
		'num_pages' => 10,
		'always_show' => 0,
		'num_larger_page_numbers' => 5,
		'larger_page_numbers_multiple' => 10,
		'use_pagenavi_css' => 0,
	);


	$pname="page";



	//$request = $wp_query->request;
	//$posts_per_page = intval(get_query_var('posts_per_page'));
	//$paged = intval(get_query_var('paged'));
	//$numposts = $wp_query->found_posts;
	//$max_page = intval($wp_query->max_num_pages);
	$posts_per_page=$rows_onpage;
	$paged=$page;
	//$numposts =23;
	$max_page=$sets;

	if (empty($paged) || $paged == 0)
		$paged = 1;

	$pages_to_show = intval($pagenavi_options['num_pages']);
	$larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
	$larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	$larger_page_nachalo=$paged-$larger_page_multiple*($larger_page_to_show+1);


	if ($start_page <= 0)
		$start_page = 1;

	$end_page = $paged + $half_page_end;
	if (($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}

	if ($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}

	if ($start_page <= 0)
		$start_page = 1;

	$larger_pages_array = array();
	if ( $larger_page_multiple )
		for ( $i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple )
			$larger_pages_array[] = $i;


	if ($max_page > 1 || intval($pagenavi_options['always_show'])) {

		$res.= '<div class="wp-pagenavi">'."\n";

				if (!empty($pages_text)) {
					$res.= '<div class="pages">'.$pages_text.'</div>';
				}
				if ($start_page >= 2 && $pages_to_show < $max_page) {
					$first_page_text = $pagenavi_options['first_text'];
					$res.= '<a href="'.$page_dir.$dopurl.'" class="first" title="'.$first_page_text.'">'.$first_page_text.'</a>';
					if (!empty($pagenavi_options['dotleft_text'])) {
						$res.= '<span class="extend">'.$pagenavi_options['dotleft_text'].'</span>';
					}
				}
				$larger_page_start = 0;
				foreach($larger_pages_array as $larger_page) {
					if ($larger_page >= $larger_page_nachalo &&  $larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
						$page_text = $pagenavi_options['page_text'];
						$res.= '<a href="'.$page_dir.$pname.$larger_page.'/'.$dopurl.'" class="page" title="'.$larger_page.'">'.$larger_page.'</a>';
						$larger_page_start++;
					}
				}
				//previous_posts_link($pagenavi_options['prev_text']);
				for($i = $start_page; $i  <= $end_page; $i++) {
					if ($i == $paged) {
						$current_page_text = $pagenavi_options['current_text'];
						$res.= '<span class="current">'.$i.'</span>';
					} else {
						$page_text = $pagenavi_options['page_text'];
						$res.= '<a href="'.$page_dir.$pname.$i.'/'.$dopurl.'" class="page" title="'.$i.'">'.$i.'</a>';
					}
				}
				//next_posts_link($pagenavi_options['next_text'], $max_page);
				$larger_page_end = 0;
				foreach($larger_pages_array as $larger_page) {
					if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
						$page_text =  $pagenavi_options['page_text'];
						$res.= '<a href="'.$page_dir.$pname.$larger_page.'/'.$dopurl.'" class="page" title="'.$larger_page.'">'.$larger_page.'</a>';
						$larger_page_end++;
					}
				}
				if ($end_page < $max_page) {
					if (!empty($pagenavi_options['dotright_text'])) {
						$res.= '<span class="extend">'.$pagenavi_options['dotright_text'].'</span>';
					}
					$last_page_text =  $pagenavi_options['last_text'];
					$res.= '<a href="'.$page_dir.$pname.$max_page.'/'.$dopurl.'" class="last" title="'.$last_page_text.'">'.$last_page_text.'</a>';
				}

		}
		$res.= '</div>'."\n";
		return $res;
	}


$units=array(1=>"тн",2=>"м",3=>"км",4=>"бухта",5=>"шт",6=>"упак.",7=>"комплект",8=>"кг",9=>"т шт");

function ch3(){
//var_dump($_SESSION);exit;
	if( $_SESSION['captcha_keystring'] !=  $_POST['keystring'] || $_SESSION['captcha_keystring'] == ""){
		return false;
	}
	unset($_SESSION['captcha_keystring']);
	return true;
}

function cpt1a(){
	$html  = '<img id="cpt1image" src="http://www.ruscable.ru/captcha/show.php?'.session_name()."=".session_id().'">';
	$html .= "<a onclick=\"refresh()\"><font style='font-size:11px;cursor: pointer; cursor: hand;'>Обновить символы</font></a>
	<script>
	function refresh(){
		document.getElementById('cpt1image').src='http://www.ruscable.ru/captcha/show.php?".session_name()."='+Math.random();
		return false;
	}
	</script>
	";
	return $html;
}

function cpt2a(){
	$html  = '<input type="text" name="keystring" size="10" maxlength=6>';
	return $html;
}

function has_no_newlines($text)
{
 return preg_match("/(%0A|%0D|\\n+|\\r+)/i", $text) == 0;
}

function has_no_emailheaders($text)
{
 return preg_match("/(%0A|%0D|\\n+|\\r+)(content-type:|to:|cc:|bcc:)/i", $text) == 0;
}
if(!function_exists('rus2lat')){
	function rus2lat($str){
		$iso0=array(
"ий"=>"ij",
"ой "=>"oj",
"ее"=>"eje",
"ое"=>"oje",
"ая"=>"aja",
"яя"=>"jaja",
"ия"=>"ija",
"ие"=>"ije",
"ые"=>"ye");

		$iso = array(
			"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
			"Е"=>"E","Ё"=>"Yo","Ж"=>"Zh",
			"З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
			"М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
			"С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"H",
			"Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Shch","Ъ"=>"",
			"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"Ju","Я"=>"Ja",
			"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
			"е"=>"e","ё"=>"yo","ж"=>"zh",
			"з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
			"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
			"ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shch","ъ"=>"",
			"ы"=>"y","ь"=>"","э"=>"e","ю"=>"ju","я"=>"ja"
		);
		$str=preg_replace("/^е/","je",$str);
		$str=preg_replace("/^Е/","je",$str);

		$str2 = strtr($str, $iso0);
		$string = strtr($str2, $iso);
		return $string;
	}
}

function okonch($number,$word){
	$w1=array("товар","товара","товаров");
	$w2=array("странице","страницах");
	$w3=array("позиция","позиции","позиций");
	if($word=="страница"){
		if($number==11){
			$res=$w2[1];
		}elseif($number < 10){
			if($number==1){
				$res=$w2[0];
			}else{
				$res=$w2[1];
			}
		}else{
			if(substr($number,-1)=="1"){
				$res=$w2[0];
			}else{
				$res=$w2[1];
			}
		}
	}elseif($word=="товар"){
		if($number<10){$subn=$number;}else{$subn=substr($number,-1);}
		if($number < 10 || $number > 20){
			if($subn==1){
				$res=$w1[0];
			}elseif($subn>1 && $subn < 5){
				$res=$w1[1];
			}else{
				$res=$w1[2];
			}
		}else{
				$res=$w1[2];
		}
	}elseif($word=="позиция"){
		if($number<10){$subn=$number;}else{$subn=substr($number,-1);}
		if($number < 10 || $number > 20){
			if($subn==1){
				$res=$w3[0];
			}elseif($subn>1 && $subn < 5){
				$res=$w3[1];
			}else{
				$res=$w3[2];
			}
		}else{
				$res=$w3[2];
		}
	}
	return $res;
}

// В русском языке существительные с числительными могут быть в единственном, двойственном и множественном числе: один арбуз, два арбуза, пять арбузов
// (двойственное число — это почти исчезнувшая в русском языке грамматическая конструкция, встречающаяся только в этом случае).
function pluralForm($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}

?>
