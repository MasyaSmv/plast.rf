<?
@session_start();

/*
if(preg_match("/android|midp|j2me|symbian|series\ 60|symbos|windows\ mobile|windows\ ce|ppc|smartphone|blackberry|mtk|windows\ phone|iPod|iPad|iPhone|Opera\ Mini|SonyEricsson/i",$_SERVER['HTTP_USER_AGENT'])){
	$Mobile = true;
}else{
	$Mobile = false;
}
*/

$maxCP=50;
if(@$_SESSION['company_id']==4467){$maxCP=150;}
$maxEL=100;
// бесплатных поисков по складу в месяц:
$max_free_searches=3;

$path = dirname(__FILE__);
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// url сайта
$site_url="www.ruscable.ru";
$users_dir='users';
// разделитель в заголовках окон
$separator="»";

// разделитель в альтернативной навигации
$alt_separator="»";

// индексный файл
$indexfile=array("index.html","main.php");

// имя файла с заголовком каталога
$title_filename=".title";

// имя файла с мета-тегами description
$metafile_description=".metadescription";

// имя файла с мета-тегами keywords
$metafile_keywords=".metakeywords";

// имя файла с мета-тегами classification
$metafile_classification=".metaclassification";

$db_server="localhost";
$db_server2="localhost";
//$db_server="192.168.0.1";
//$db_server2="192.168.0.1";
//$read_db_server = "192.168.0.1";
$read_db_server = "localhost";
$db_user="ruscableru";
$db_password="7o4hcdv3ef";
$db_database="ruscableru";
if(!function_exists('db_connect')){
function db_connect()
{
        global $db_server, $db_user, $db_password, $db_database;
        static $connected = FALSE;
        //if( $connected ) return; // уже подключены

        $connected = mysql_connect($db_server, $db_user, $db_password) && mysql_select_db($db_database);
        //$connected = mysql_connect("localhost:/tmp/mysql.sock", $db_user, $db_password) && mysql_select_db($db_database);
        if( !$connected ) { die("В данный момент на сервере ведутся технические работы, пожалуйста, попробуйте обновить страницу или зайти попозже.<br>Приносим извинения за временные неудобства."); }else {mysql_query("set names cp1251");}
}
}
if(!function_exists('db_connect2')){
function db_connect2()
{
        global $db_server2, $db_user, $db_password, $db_database;
	static $connected2 = FALSE;
	if($connected){@mysql_close();}
	if($connected2){ return; }
        $connected2 = mysql_connect($db_server2, $db_user, $db_password) && mysql_select_db($db_database);
        //$connected2 = mysql_connect("localhost:/tmp/mysql.sock", $db_user, $db_password) && mysql_select_db($db_database);
        if( !$connected2 ) { die("Невозможно подключиться к базе данных"); }else {mysql_query("set names cp1251");}
}
}
if(!function_exists('read_db_connect')){
function read_db_connect()
{
        global $read_db_server, $db_user, $db_password, $db_database;
        static $read_connected = FALSE;
        if( $connected ) return; // уже подключены

        $read_connected = mysql_connect($read_db_server, $db_user, $db_password) && mysql_select_db($db_database);
        if( !$read_connected ) {
        	db_connect();
        }else {mysql_query("set names cp1251");}
}
}
if(!function_exists('sql')){
	function sql($q,$mode = 'row'){
	$res=array();
	$r=@mysql_query($q);
	if(@mysql_num_rows($r)>0)
	   {
			if ( $mode == 'row' ) while($row=@mysql_fetch_row($r)){$res[]=$row;}
			if ( $mode == 'assoc' ) while($row=@mysql_fetch_assoc($r)){$res[]=$row;}
	   }
	return $res;
	}
}
if(!function_exists('ssql')){
        function ssql($q){
                return @mysql_result(@mysql_query($q),0,0);
        }
}
$months=array("","января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");

if(!function_exists('cuttext')){
function cuttext($text,$len)
{
	$length  = strlen($text);
	if ($len>=$length)
	{
		$txt=$text;
	}
	else
	{
		$txt     = strip_tags($text, "<sub><sup>");
	if($length>$len) $txt = substr($txt, 0, $len);
	$txt_arr = explode(" ", $txt);
	$txt_arr[(count($txt_arr)-1)] = "";
	$txt     = implode(" ", $txt_arr);
	if($txt=="") $txt = substr($text, 0, $len);
	$txt     = trim($txt);
	if(substr($txt, -1, 1)==',' || substr($txt, -1, 1)==';' || substr($txt, -1, 1)=='.') $txt = substr($txt, 0, (strlen($txt)-1));
	}

	return $txt;
}
}
function alt_nav()
{
	global $SCRIPT_NAME;
	global $alt_separator;
	global $title_filename;
	global $indexfile;
	global $site_url;

	//echo $SCRIPT_NAME."<br>";
	//echo dirname($SCRIPT_NAME)."<br><br>";

	$path_no_arr=str_replace("\\","/",dirname($SCRIPT_NAME)); // замена слешей для совместимости виндов и юникса
	if($path_no_arr=="/")
		$path=array("");
	else
		$path=explode("/",$path_no_arr);

	//for($i=0;$i<count($path);$i++) echo "|$path[$i]|<br>";

	$str="";

	// перебираем все надкаталоги в поисках заголовков
	for($i=0;$i<count($path);$i++)
	{
		//echo $i;
		if($i!==0) chdir("../");
		if(file_exists($title_filename))
		{
			$f=file($title_filename);
			if(trim($f[0]) != '')
			{
				// делаем ссылку на текущий каталог
				$link="";
				for($j=0;$j<(count($path)-$i);$j++)
				{
					$link.=$path[$j]."/";
					//echo "j=$j link=$link <br>";
				}
				if($i!==0)
				{
					if($str != '')
						$str="<li><a  href='http://".$site_url.$link."'>".$f[0]."</a> ".$alt_separator." ".$str.'</li>';
					else
						$str="<li><a  href='http://".$site_url.$link."'>".$f[0]."</a></li> ";
				}
				elseif(!in_array(basename($SCRIPT_NAME),$indexfile))
					$str="<li><a   href='http://".$site_url.$link."'>".$f[0]."</a> ".$str."</li>";
				else
					$str=$f[0]."<span>".$str."</span>";
			}
		}
	}
	// возвращаемся в каталог с запрошенным файлом
	for($i=0;$i<count($path);$i++)
	{
		if($path[$i]!=="") chdir($path[$i]);
	}

	return $str;
}

if(!function_exists('GetDB')){
function GetDB($query){
	$result=mysql_query($query);
	if(mysql_errno()!=0)
	{
		//echo "<p><font color=\"#ff0000\">Ошибка : ".mysql_error()." : ".mysql_errno()."</font>";
	}
	else
	{
		for ($i=0; $row=mysql_fetch_array($result); $i++)
		{
			$rez[$i]=$row;
		}
	}
	return @$rez;
}
}
function fnc_strtoupper($word)
{
	$word=strtr($word, "ёйцукенгшщзхъфывапролджэячсмитьбю", "ЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ");

	return $word;
}
function fnc_strtolower($word)
{
	$word=strtr($word,"ЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ", "ёйцукенгшщзхъфывапролджэячсмитьбю");

	return $word;
}
if(!function_exists('title')){
function title($str="")
{
	global $separator;
	global $title_filename;
	global $SCRIPT_NAME;

	//echo $SCRIPT_NAME."<br>";

	$path_no_arr=str_replace("\\","/",dirname($SCRIPT_NAME)); // caiaia neaoae aey niaianoeiinoe aeiaia e ?ieena
	if($path_no_arr=="/")
		$path=array("");
	else
		$path=explode("/",$path_no_arr);
	//if(count($path)==1) $path=array("");

	//echo "eie-ai eaoaeiaia = ".count($path)."<br>";

	$str="$str";

	// ia?aae?aai ana iaaeaoaeiae a iieneao caaieiaeia
	for($i=0;$i<count($path);$i++)
	{
		if($i!==0) chdir("../");
		if(file_exists($title_filename))
		{
			$f=file($title_filename);
			if(trim($f[0]) != '' && $str != '')
				$str=$f[0].' '.$separator.' '.$str;
			elseif(trim($f[0]) != '' && $str == '')
				$str=$f[0];
		}
	}

	// aica?auaainy a eaoaeia n cai?ioaiiui oaeeii
	for($i=0;$i<count($path);$i++)
	{
		if($path[$i]!=="") chdir($path[$i]);
	}
	return $str;
}
}
function meta($meta_name)
{
	global $metafile_description;
	global $metafile_keywords;
	global $metafile_classification;
	global $SCRIPT_NAME;

	$meta_var="metafile_".$meta_name;   // ociaai eiy aeiaaeuiie ia?aiaiiie n iacaaieai iaoa-oaeea

	$path_no_arr=str_replace("\\","/",dirname($SCRIPT_NAME)); // caiaia neaoae aey niaianoeiinoe aeiaia e ?ieena
	if($path_no_arr=="/")
		$path=array("");
	else
		$path=explode("/",$path_no_arr);

	$str="";

	// ia?aae?aai ana iaaeaoaeiae a iieneao caaieiaeia
	for($i=0;$i<count($path);$i++)
	{
		if($i!==0) chdir("../");
		if(file_exists($$meta_var) && $str=="")
		{
			$f=file($$meta_var);
			$str=$f[0];
		}
	}

	// aica?auaainy a eaoaeia n cai?ioaiiui oaeeii
	for($i=0;$i<count($path);$i++)
	{
		if($path[$i]!=="") chdir($path[$i]);
	}
	return $str;
}
function lastweek($data) {
$data = explode("-",$data);
$year = $data[0];
$month = intval($data[1]);
$day = intval($data[2]);
$lastweek = date("Y-m-d", mktime(0, 0, 0, $month, $day-7, $year));
return $lastweek;
}


function show_head_date(){
global $months;

if(date("Y-m-d")=="2012-04-01") print "<div style=\"position:relative; bottom:-2px; left: 0px;\">32 марта " . date("Y") . "г.</div>";
else print "<div style=\"position:relative; bottom:-2px; left: 0px;\">" . date("j") . " " . $months[date("n")] . " " . date("Y") . "г.</div>";

}
function chk_int($val, $positive=false)
{
	if(is_numeric($val) && strpos($val, '.')==false)
		if(!$positive)
			return true;
		elseif($positive && $val>=0)
			return true;
		else
			return false;
	else
		return false;
}
if(!function_exists('true_addslashes')){function true_addslashes($a_string='',$is_like=FALSE)
{
	if($is_like){
		$a_string=str_replace('\\','\\\\\\\\',$a_string);
	}
	else{
		$a_string=str_replace('\\','\\\\',$a_string);
	}
	$a_string=str_replace('\'','\\\'',$a_string);

	return $a_string;
}
}
function cpt1(){
	print '<img id="cptimage" src="/captcha/show.php?'.session_name()."=".session_id().'">';
	print "<img style='cursor: pointer;' src=/i/rf.gif alt=\"Обновить символы\" title=\"Обновить символы\" border=0 width=20 height=20 onclick=\"document.getElementById('cptimage').src='/captcha/show.php?".session_name()."='+Math.random();\">";


}

function cpt2(){
	print '<input type="text" name="keystring" size="10" maxlength=6>';
}

function acpt1(){
	$out= '<img id="cptimage" src="/captcha/show.php?'.session_name()."=".session_id().'">';
	$out.= "<a     onclick=\"document.getElementById('cptimage').src='/captcha/show.php?".session_name()."='+Math.random()\"><img src=/i/rf.gif alt=\"Обновить символы\" title=\"Обновить символы\" border=0 width=20 height=20></a>";
	return $out;
}

function acpt2(){
	$out= '<input type="text" name="keystring" size="10" maxlength=6>';
	return $out;
}


function ch3(){
//var_dump($_SESSION);exit;
	if( $_SESSION['captcha_keystring'] !=  $_POST['keystring'] || $_SESSION['captcha_keystring'] == ""){
		return false;
	}
	unset($_SESSION['captcha_keystring']);
	return true;
}

function cpt1a(){
	$html  = '<img id="cptimage" src="/captcha/show.php?'.session_name()."=".session_id().'">';
	//$html .= "<a onclick=\"document.getElementById('cptimage').src='/captcha/show.php?".session_name()."='+Math.random()\"><img src=/i/rf.gif alt=\"Обновить символы\" title=\"Обновить символы\" border=0 width=20 height=20></a>";
	$html .= "<img style='cursor: pointer;' src=/i/rf.gif alt=\"Обновить символы\" title=\"Обновить символы\" border=0 width=20 height=20 onclick=\"document.getElementById('cptimage').src='/captcha/show.php?".session_name()."='+Math.random();\">";
	return $html;
}

function cpt2a(){
	$html  = '<input type="text" name="keystring" size="10" maxlength=6>';
	return $html;
}

function cpt1f(){
	$html  = '<img id="cptimage-f" src="/captcha/show.php?'.session_name()."=".session_id().'"> ';
	//$html .= "<a onclick=\"document.getElementById('cptimage').src='/captcha/show.php?".session_name()."='+Math.random()\"><img src=/i/rf.gif alt=\"Обновить символы\" title=\"Обновить символы\" border=0 width=20 height=20></a>";
	$html .= "<img style='cursor: pointer;' src=/i/rf.gif alt=\"Обновить символы\" title=\"Обновить символы\" border=0 width=20 height=20 onclick=\"document.getElementById('cptimage-f').src='/captcha/show.php?".session_name()."='+Math.random();\">";
	return $html;
}

function cpt2f(){
	$html  = '<input type="text" name="keystring" size="10" maxlength=6 style="width: 120px;">';
	return $html;
}

// Показываем форму
function doform_show($form_id)
{
	if(!chk_int($form_id, true)) return '';

	// получаем параметры формы
	$cur_date = date('Y-m-d');
//echo 	"SELECT template_id, capcha FROM doform_forms WHERE id='$form_id' and date_start <= '$cur_date' and date_stop >= '$cur_date'";
	$form     = GetDB("SELECT template_id, capcha FROM doform_forms WHERE id='$form_id' and date_start <= '$cur_date' and date_stop >= '$cur_date'");
	if(sizeof($form) != 1) return '';

	// получаем шаблон формы
	$tmpl = GetDB("SELECT code FROM doform_templates WHERE id='".$form[0]['template_id']."'");
	// рисуем форму
	$html  = '<form method="POST" action="/doform_2_recap3.php">'."\n\n";
	if( $form[0]['capcha'] == 1) $html .= '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">';
	$html .= $tmpl[0]['code']."\n";
	$html .= '<input type="hidden" name="form" value="'.$form_id.'">'."\n";
	$html .= '<input class="done" name="submit" type="submit" value="Отправить">';
	$html .= "\n".'</form>'."\n";

	// выводим капчу
	// if($form[0]['capcha'])
	// {
	// 	$html = str_replace("<!-- capcha_begin -->", "", $html);
	// 	$html = str_replace("<!-- capcha_end -->", "", $html);
	// 	if($form_id == 50){
	// 		$html = str_replace("<!-- capcha_code -->", "<div id='RecaptchaField3'></div>", $html);
	// 	}else{
	// 		$html = str_replace("<!-- capcha_code -->", cpt1f()."<br>".cpt2f(), $html);
	// 	}
	// }
	// //  не выводим капчу
	// else
	// {
	// 	$html = preg_replace('/<!-- capcha_begin -->.*<!-- capcha_end -->/Uis', '', $html);
	// }

	return $html;
}


/**
* Check single-line inputs:
* Returns false if text contains newline character
*/
function has_no_newlines($text)
{
 return preg_match("/(%0A|%0D|\\n+|\\r+)/i", $text) == 0;
}

/**
* Check multi-line inputs:
* Returns false if text contains newline followed by
* email-header specific string
*/
function has_no_emailheaders($text)
{
 return preg_match("/(%0A|%0D|\\n+|\\r+)(content-type:|to:|cc:|bcc:)/i", $text) == 0;
}

function hist($message){
	$user=$_SERVER['PHP_AUTH_USER'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$q="insert into history set user='$user',action='$message',date_act=NOW(),ip='$ip'";
	mysql_query($q);
}

function show_pagenumeration($prefix,$num_files,$leadzero="no",$nachalo="Страница:",$sep="|",$ext="html")
// $prefix    - префикс в названиях страниц
// $num_files - количество страниц
// $leadzero  - ведущий ноль в номерах страниц (yes или no)
// $nachalo   - выводится перед списком номеров страниц
// $sep       - разделитель номеров страниц
// $ext       - расширение страниц
{
	global $SCRIPT_NAME;

	// узнаем номер текущей страницы
	$filename=basename($SCRIPT_NAME);
	$filename=substr($filename,0,strlen($filename)-(strlen($ext)+1));
	$filename=explode("-",$filename);
	$page_num=@$filename[1];

	// формируем строку с сылками на страницы
	$str=$nachalo." ";

	for($i=1;$i<=$num_files;$i++)
	{
		// добавляем ведущие нули, если надо
		if($leadzero=="yes")
		{
			if($i<10) $ii="0$i";
			if($i>=10) $ii=$i;
		}
		else
		{
			$ii=$i;
		}

		if($i==$page_num)
		{
			$str.=" $i ";
		}
		else
		{
			$str.=" <a href=\"$prefix-$ii.$ext\">$i</a> ";
		}
		if($i!==$num_files) $str.=$sep;
	}

	return $str;
}

function show_articles_tree($parent_id, $level,$ontop,$max_level,$dir,$erase,$from_id,$ooo)
{
	if(($ontop==1 && $level<$max_level) || $ooo==1)
	{
		// скрываем разделы, перенесенные в статьи
		//$hide_cats = " AND id != '298' AND id != '299' AND id != '881' AND id != '948' AND id != '300' ";

		//$result=mysql_query("SELECT * FROM articles_cat WHERE parent_id='".$parent_id."' AND visible='1' ".$hide_cats." ORDER BY sort, id");
		$result=mysql_query("SELECT * FROM articles_cat WHERE parent_id='".$parent_id."' AND visible='1' ORDER BY sort, id");
		while($catalog=mysql_fetch_assoc($result))
		{

			if($level==0 && $catalog['zag']==1)
			{
				$nach='<h2>';
				$kon='</h2>';
				$class_level="level0";
				//$style_a=' style="text-decoration:none;" ';
				$style_a='';
			}
			else if($level==1 && $catalog['zag']==1)
			{
				$nach='<h3>';
				$kon='</h3>';
				$class_level="level1";
				//$style_a=' style="text-decoration:none;" ';
				$style_a='';
			}
			else
			{
				$nach='';
				$kon='';
				$class_level="";
				$style_a='';
			}
			$catalog['link']=str_replace($erase,"",$catalog['link']);

			if($catalog['type']=="folder") print '<li class="'.$class_level.'">'.$nach.'<a href="'.$dir.$catalog['link'].'" '.$style_a.' title="'.$catalog['title'].'">'.$catalog['title'].'</a>'.$kon;
			elseif($catalog['type']=="article") print '<li><a href="'.$dir.$catalog['link'].'"   title="'.$catalog['title'].'">'.$catalog['title'].'</a>';
			elseif($catalog['type']=="link") print '<li class="'.$class_level.'">'.$nach.'<a href="'.$catalog['text'].'" '.$style_a.' title="'.$catalog['title'].'">'.$catalog['title'].'</a>'.$kon;
			elseif($catalog['type']=="text")
			{
				$catalog['text'] = str_replace("<p>&nbsp;</p>", "", $catalog['text']); // для отчетности предприятий
				print '<li style="list-style:none;">'.$catalog['text'];
			}

			print '<ul>';
			show_articles_tree($catalog['id'],$level+1,$catalog['ontop'],$max_level,$dir,$erase,$from_id,$ooo);
			print '</ul></li>';
		}

	}
}

function show_articles_tree2($parent_id, $level,$ontop,$max_level,$dir,$erase,$from_id,$ooo)
{
	global $doplink2;
	if(($ontop==1 && $level<$max_level) || $ooo==1)
	{
	$result=mysql_query("SELECT * FROM articles_cat WHERE parent_id='".$parent_id."' AND visible='1' ORDER BY sort, id");
	while($catalog=mysql_fetch_assoc($result))
	{

		if($level==0 && $catalog['zag']==1)
		{
			$nach='<h2 class=bigH2>';
			$kon='</h2>';
			$class_level="level0";
			$style_a=' style="text-decoration:none;" ';
		}
		else if($level==1 && $catalog['zag']==1)
		{
			$nach='<h3 style="color:#797979;">';
			$kon='</h3>';
			$class_level="level1";
			$style_a=' style="text-decoration:none;" ';
		}
		else
		{
			$nach='';
			$kon='';
			$class_level="";
			$style_a='';
		}
		$catalog['link']=str_replace($erase,"",$catalog['link']);
		//echo $dir."<br>";
		//echo $catalog['link']."<hr>";
		if($catalog['type']=="folder") print '<li class="'.$class_level.'"><a href="'.$doplink2.$catalog['link'].'" '.$style_a.' title="'.$catalog['title'].'">'.$nach.$catalog['title'].$kon.'</a>';
		else if($catalog['type']=="article") print '<li><a href="'.$doplink2.$catalog['link'].'"   title="'.$catalog['title'].'">'.$catalog['title'].'</a>';
		else if($catalog['type']=="link") print '<li class="'.$class_level.'"><a href="'.$catalog['text'].'" '.$style_a.' title="'.$catalog['title'].'">'.$nach.$catalog['title'].$kon.'</a>';
		else if($catalog['type']=="text") print '<li style="list-style:none; padding:5px;margin-left:-5px;"><div class="article_text">'.$catalog['text'].'</div>';

	 		print '<ul style="padding-left:10px;">';
			show_articles_tree($catalog['id'],$level+1,$catalog['ontop'],$max_level,$dir,$erase,$from_id,$ooo);
			print '</ul></li>';

		}

	}
}

function show_articles_tree3($parent_id, $level,$ontop,$max_level,$dir,$erase,$from_id,$ooo)
{
	if(($ontop==1 && $level<$max_level) || $ooo==1)
	{
		// скрываем разделы, перенесенные в статьи
		//$hide_cats = " AND id != '298' AND id != '299' AND id != '881' AND id != '948' AND id != '300' ";

		//$result=mysql_query("SELECT * FROM articles_cat WHERE parent_id='".$parent_id."' AND visible='1' ".$hide_cats." ORDER BY sort, id");
		$result=mysql_query("SELECT * FROM articles_cat WHERE parent_id='".$parent_id."' AND visible='1' ORDER BY sort, id");
		while($catalog=mysql_fetch_assoc($result))
		{

			if($level==0 && $catalog['zag']==1)
			{
				$nach='<h2>';
				$kon='</h2>';
				$class_level="level0";
				//$style_a=' style="text-decoration:none;" ';
				$style_a='';
			}
			else if($level==1 && $catalog['zag']==1)
			{
				$nach='<h3>';
				$kon='</h3>';
				$class_level="level1";
				//$style_a=' style="text-decoration:none;" ';
				$style_a='';
			}
			else
			{
				$nach='';
				$kon='';
				$class_level="";
				$style_a='';
			}
			$catalog['link']=str_replace($erase,"",$catalog['link']);

			if($catalog['type']=="folder") print '<li class="'.$class_level.'">'.$nach.'<a href="'.$catalog['link'].'" '.$style_a.' title="'.$catalog['title'].'">'.$catalog['title'].'</a>'.$kon;
			elseif($catalog['type']=="article") print '<li><a href="'.$catalog['link'].'"   title="'.$catalog['title'].'">'.$catalog['title'].'</a>';
			elseif($catalog['type']=="link") print '<li class="'.$class_level.'">'.$nach.'<a href="'.$catalog['text'].'" '.$style_a.' title="'.$catalog['title'].'">'.$catalog['title'].'</a>'.$kon;
			elseif($catalog['type']=="text")
			{
				$catalog['text'] = str_replace("<p>&nbsp;</p>", "", $catalog['text']); // для отчетности предприятий
				print '<li style="list-style:none;">'.$catalog['text'];
			}

			print '<ul>';
			show_articles_tree3($catalog['id'],$level+1,$catalog['ontop'],$max_level,$dir,$erase,$from_id,$ooo);
			print '</ul></li>';
		}

	}
}

function get_articles_tree($parent_id, $level,$ontop,$max_level,$dir,$erase,$from_id,$ooo)
{
	$out="";
	if(($ontop==1 && $level<$max_level) || $ooo==1)
	{
	$result=mysql_query("SELECT * FROM articles_cat WHERE parent_id='".$parent_id."' AND visible='1' ORDER BY sort, id");
	while($catalog=mysql_fetch_assoc($result))
	{

		if($level==0 && $catalog['zag']==1)
		{
			$nach='<h2>';
			$kon='</h2>';
			$class_level="level0";
			$style_a=' style="text-decoration:none;" ';
		}
		else if($level==1 && $catalog['zag']==1)
		{
			$nach='<h3 style="color:#797979;">';
			$kon='</h3>';
			$class_level="level1";
			$style_a=' style="text-decoration:none;" ';
		}
		else
		{
			$nach='';
			$kon='';
			$class_level="";
			$style_a='';
		}
		$catalog['link']=str_replace($erase,"",$catalog['link']);

		if($catalog['type']=="folder") $out.= '<li class="'.$class_level.'"><a href="'.$dir.$catalog['link'].'" '.$style_a.' title="'.$catalog['title'].'">'.$nach.$catalog['title'].$kon.'</a>';
		else if($catalog['type']=="article") $out.= '<li><a href="'.$dir.$catalog['link'].'"   title="'.$catalog['title'].'">'.$catalog['title'].'</a>';
		else if($catalog['type']=="link") $out.= '<li class="'.$class_level.'"><a href="'.$catalog['text'].'" '.$style_a.' title="'.$catalog['title'].'">'.$nach.$catalog['title'].$kon.'</a>';
		else if($catalog['type']=="text") $out.= '<li style="list-style:none; padding-top:0px; margin-top:-5px;">'.$catalog['text'];

	 		$out.= '<ul style="padding-left:10px;">';
			$out.= get_articles_tree($catalog['id'],$level+1,$catalog['ontop'],$max_level,$dir,$erase,$from_id,$ooo);
			$out.= '</ul></li>';
		}

	}
	return $out;
}

function grate_articles_nav($from_id,$dir)
{
	global $articles_navigation, $articles_title_tag;

	$result=mysql_query("SELECT link, title FROM articles_cat WHERE id='".$from_id."'");
	$nach=mysql_fetch_assoc($result);
	if(trim($_GET['link'])!="")
	{

		$title_tag=$nach['title']." > ";
		$nav='<a href="'.$dir.'" title="'.$nach['title'].'">'.$nach['title'].'</a> » ';
	}
	else
	{
		$title_tag=$nach['title'];
		$nav="";
	}

	$g_arr=explode("/",$_GET['link']);
	//print_r($g_arr);
	unset($g_arr[0]);

	$nav_url='';

	for($i=1; $i<=count($g_arr);$i++)
	{
		$result=mysql_query("SELECT title, link  from articles_cat WHERE eng_title='".$g_arr[$i]."'");
		if(mysql_num_rows($result)>0)
		{
			$g_title=mysql_fetch_assoc($result);
			$g_title['link']=str_replace($nach['link'],"",$g_title['link']);
			if($i==count($g_arr))
			{
				//$nav.=''.$g_title['title'].'';
				$nav.='';
				//$title_tag.=$g_title['title'];
                $title_tag=$g_title['title'];
			}
			else
			{
				$nav.='<a href="'.$dir.$g_title['link'].'" title="'.$g_title['title'].'">'.$g_title['title'].'</a>';
				if($i<(count($g_arr)-1)) $nav.=' » ';
				//$title_tag.=$g_title['title'].' » ';
                $title_tag=$g_title['title'];
			}
		}

	}

	$articles_navigation=$nav;
	$articles_title_tag=$title_tag;

}


function show_articles_from_id($from_id,$articles_navigation,$dir)
{
	$txt  = '<ul id="articles_cat">';

	$result = mysql_query("SELECT link, type, parent_id, sort FROM articles_cat WHERE id='".$from_id."'");
	$arr    = $erase;
	if($_GET['link']!="") {
		$arr_names  = explode("/",$_GET['link']);
		$name       = $arr_names[(count($arr_names)-1)];

		$result     = mysql_query("SELECT id, title, text, ontop, show_level, onpage, parent_id, type, sort ,DATE_FORMAT(date_add,'%d.%m.%Y') AS data2 FROM articles_cat WHERE eng_title='".$name."'");
		$nach_id    = mysql_fetch_assoc($result);
		$id         = $nach_id['id'];
		$ontop      = $nach_id['ontop'];
		$title      = $nach_id['title'];
		$show_level = $nach_id['show_level'];
		$onpage     = $nach_id['onpage'];

		if($onpage==1) $ooo = 1;
		else           $ooo=0;
	}
	else {
		$id         = $from_id;

		$result     = mysql_query("SELECT title, text, ontop, show_level, onpage, parent_id, type, sort, DATE_FORMAT(date_add,'%d.%m.%Y') AS data2 FROM articles_cat WHERE id='".$from_id."'");
		$nach_id    = mysql_fetch_assoc($result);
		$ontop      = $nach_id['ontop'];
		$show_level = $nach_id['show_level'];
		$onpage     = $nach_id['onpage'];
		$title      = $nach_id['title'];
		$ooo        = 0;
	}

	if ($nach_id['type']=="article" && $nach_id['data2']!="00.00.0000") $txt .= '<p>'.$nach_id['data2'].'</p>';
	$txt .= $nach_id['text'];

	if ($nach_id['type']=="article")
	{
		$txt .= '<div id="nextPrevNav">';

		$result3 = mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort<'".$nach_id['sort']."' ORDER BY sort DESC LIMIT 1");

		if(mysql_num_rows($result3)>0)
		{
			$next = mysql_fetch_assoc($result3);
			$txt .= '<a href="'.$next['eng_title'].'" class="orangeButton prev"><span><img src="/rc2012/img/prev-arrow.png">Предыдущая статья</span></a>';
		}

		$result3 = mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort>'".$nach_id['sort']."' ORDER BY sort LIMIT 1");

		if(mysql_num_rows($result3)>0)
		{
			$next = mysql_fetch_assoc($result3);
			$txt .= '<a href="'.$next['eng_title'].'" class="orangeButton next"><span>Следующая статья<img src="/rc2012/img/next-arrow.png"></span></a>';
		}

		$txt .= '</div>';
	}

	if($onpage==1)
	{
		// выводим в буфер
		ob_start();

		show_articles_tree($id,0,$ontop,$show_level,$dir,$erase['link'],$from_id,$ooo);

		$txt .= ob_get_contents();
		ob_end_clean();
	}

	$txt .= '</ul>';

	echo '<div id="breadcrumbs">'.$articles_navigation.'</div>';
	echo '<h1>'.$title.'</h1>';
	//echo '<div id="articles_nav">'.$articles_navigation.'</div>';
	echo $txt;
}

function show_articles_from_id2($from_id,$articles_navigation,$dir)
{
	?>
	<div id="articles_nav">
	<?=$articles_navigation?>
</div>
<ul id="articles_cat">
<?
$result=mysql_query("SELECT link, type, parent_id, sort FROM articles_cat WHERE id='".$from_id."'");
$arr=$erase;
if($_GET['link']!="") {
	$arr_names=explode("/",$_GET['link']);
	$name=$arr_names[(count($arr_names)-1)];

	$result=mysql_query("SELECT id, title, text, ontop, show_level, onpage, parent_id, type, sort ,DATE_FORMAT(date_add,'%d.%m.%Y') AS data2, dis_ins_links FROM articles_cat WHERE eng_title='".$name."'");
	$nach_id=mysql_fetch_assoc($result);
	$id=$nach_id['id'];
	$ontop=$nach_id['ontop'];
	print '<h1>'.$nach_id['title'].'</h1>';
	$show_level=$nach_id['show_level'];
	$onpage=$nach_id['onpage'];
    if($onpage==1) $ooo=1;
    else $ooo=0;
}
else {
	$id=$from_id;

	$result=mysql_query("SELECT title, text, ontop, show_level, onpage, parent_id, type, sort, DATE_FORMAT(date_add,'%d.%m.%Y') AS data2, dis_ins_links FROM articles_cat WHERE id='".$from_id."'");
	$nach_id=mysql_fetch_assoc($result);
	$ontop=$nach_id['ontop'];
	$show_level=$nach_id['show_level'];
	$onpage=$nach_id['onpage'];
	print '<h1>'.$nach_id['title'].'</h1>';
    $ooo=0;
}

if ($nach_id['type']=="article" && $nach_id['data2']!="00.00.0000" && $nach_id['dis_ins_links']=='0') print '<p style="color:gray;">'.$nach_id['data2'].'</p>';
print '<div class="article_text">'.$nach_id['text'].'</div>';
if ($nach_id['type']=="article" && $nach_id['dis_ins_links']=='0')
{

    print '<br><br><br><p>';

    $result3=mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort>'".$nach_id['sort']."' ORDER BY sort LIMIT 1");
  if(mysql_num_rows($result3)>0)
  {
     $next=mysql_fetch_assoc($result3);
     print '<a href="'.$next['eng_title'].'" style="float:right;">Следующая статья >><a/>';
  }
    $result3=mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort<'".$nach_id['sort']."' ORDER BY sort DESC LIMIT 1");
  if(mysql_num_rows($result3)>0)
  {
     $next=mysql_fetch_assoc($result3);
     print '<a href="'.$next['eng_title'].'"><< Предыдущая статья<a/>';
  }
  print '</p>';
}
if($onpage==1)
{
	show_articles_tree2($id,0,$ontop,$show_level,$dir,$erase['link'],$from_id,$ooo);
}
?>
</ul>
	<?
}


function show_articles_from_id3($from_id,$articles_navigation,$dir)
{
	$txt  = '<ul id="articles_cat">';

	$result = mysql_query("SELECT link, type, parent_id, sort FROM articles_cat WHERE id='".$from_id."'");
	$arr    = $erase;
	if($_GET['link']!="") {
		$arr_names  = explode("/",$_GET['link']);
		$name       = $arr_names[(count($arr_names)-1)];

		$result     = mysql_query("SELECT id, title, text, ontop, show_level, onpage, parent_id, type, sort ,DATE_FORMAT(date_add,'%d.%m.%Y') AS data2 FROM articles_cat WHERE eng_title='".$name."'");
		$nach_id    = mysql_fetch_assoc($result);
		$id         = $nach_id['id'];
		$ontop      = $nach_id['ontop'];
		$title      = $nach_id['title'];
		$show_level = $nach_id['show_level'];
		$onpage     = $nach_id['onpage'];

		if($onpage==1) $ooo = 1;
		else           $ooo=0;
	}
	else {
		$id         = $from_id;

		$result     = mysql_query("SELECT title, text, ontop, show_level, onpage, parent_id, type, sort, DATE_FORMAT(date_add,'%d.%m.%Y') AS data2 FROM articles_cat WHERE id='".$from_id."'");
		$nach_id    = mysql_fetch_assoc($result);
		$ontop      = $nach_id['ontop'];
		$show_level = $nach_id['show_level'];
		$onpage     = $nach_id['onpage'];
		$title      = $nach_id['title'];
		$ooo        = 0;
	}

	if ($nach_id['type']=="article" && $nach_id['data2']!="00.00.0000") $txt .= '<p>'.$nach_id['data2'].'</p>';
	$txt .= $nach_id['text'];

	if ($nach_id['type']=="article")
	{
		$txt .= '<div id="nextPrevNav">';

		$result3 = mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort<'".$nach_id['sort']."' ORDER BY sort DESC LIMIT 1");

		if(mysql_num_rows($result3)>0)
		{
			$next = mysql_fetch_assoc($result3);
			$txt .= '<a href="'.$next['eng_title'].'" class="orangeButton prev"><span><img src="/rc2012/img/prev-arrow.png">Предыдущая статья</span></a>';
		}

		$result3 = mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort>'".$nach_id['sort']."' ORDER BY sort LIMIT 1");

		if(mysql_num_rows($result3)>0)
		{
			$next = mysql_fetch_assoc($result3);
			$txt .= '<a href="'.$next['eng_title'].'" class="orangeButton next"><span>Следующая статья<img src="/rc2012/img/next-arrow.png"></span></a>';
		}

		$txt .= '</div>';
	}

	if($onpage==1)
	{
		// выводим в буфер
		ob_start();

		show_articles_tree3($id,0,$ontop,$show_level,$dir,$erase['link'],$from_id,$ooo);

		$txt .= ob_get_contents();
		ob_end_clean();
	}

	$txt .= '</ul>';

	echo '<div id="breadcrumbs">'.$articles_navigation.'</div>';
	echo '<h1>'.$title.'</h1>';
	//echo '<div id="articles_nav">'.$articles_navigation.'</div>';
	echo $txt;
}


function get_articles_from_id($from_id,$articles_navigation,$dir)
{
$out='<div id="articles_nav">';
$out.=$articles_navigation;
$out.='</div><ul id="articles_cat">';
$result=mysql_query("SELECT link, type, parent_id, sort FROM articles_cat WHERE id='".$from_id."'");

$arr=$erase;
if($_GET['link']!="") {
	$arr_names=explode("/",$_GET['link']);
	$name=$arr_names[(count($arr_names)-1)];

	$result=mysql_query("SELECT id, title, text, ontop, show_level, onpage, parent_id, type, sort ,DATE_FORMAT(date_add,'%d.%m.%Y') AS data2 FROM articles_cat WHERE eng_title='".$name."'");
	$nach_id=mysql_fetch_assoc($result);
	$id=$nach_id['id'];
	$ontop=$nach_id['ontop'];
	$out.= '<center><h1 style="font-size:24px;">'.$nach_id['title'].'</h1></center><br>';
	$show_level=$nach_id['show_level'];
	$onpage=$nach_id['onpage'];
    if($onpage==1) $ooo=1;
    else $ooo=0;
}
else {
	$id=$from_id;

	$result=mysql_query("SELECT title, text, ontop, show_level, onpage, parent_id, type, sort, DATE_FORMAT(date_add,'%d.%m.%Y') AS data2 FROM articles_cat WHERE id='".$from_id."'");
	$nach_id=mysql_fetch_assoc($result);
	$ontop=$nach_id['ontop'];
	$show_level=$nach_id['show_level'];
	$onpage=$nach_id['onpage'];
	$out.= '<center><h1 style="font-size:24px;">'.$nach_id['title'].'</h1></center><br>';
    $ooo=0;
}

if ($nach_id['type']=="article" && $nach_id['data2']!="00.00.0000") $out.= '<p style="color:gray;">'.$nach_id['data2'].'</p>';
$out.= $nach_id['text'];



if ($nach_id['type']=="article")
{

    $out.= '<br><br><br><p>';

    $result3=mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort>'".$nach_id['sort']."' ORDER BY sort LIMIT 1");
  if(mysql_num_rows($result3)>0)
  {
     $next=mysql_fetch_assoc($result3);
     $out.= '<a href="'.$next['eng_title'].'" style="float:right;">Следующая статья >><a/>';
  }
    $result3=mysql_query("SELECT eng_title FROM articles_cat WHERE parent_id='".$nach_id['parent_id']."'AND type='".$nach_id['type']."' AND visible='1' AND sort<'".$nach_id['sort']."' ORDER BY sort DESC LIMIT 1");
  if(mysql_num_rows($result3)>0)
  {
     $next=mysql_fetch_assoc($result3);
     $out.= '<a href="'.$next['eng_title'].'"><< Предыдущая статья<a/>';
  }
  $out.= '</p>';
}
if($onpage==1)
{
	$out.=get_articles_tree($id,0,$ontop,$show_level,$dir,$erase['link'],$from_id,$ooo);
}

$out.='</ul>';
return $out;
}

function add_user_history($uid, $title, $text,$ip)
{
     mysql_query("INSERT INTO user_logs SET uid='".$uid."', date='".date("Y-m-d H:i:s")."', title='".$title."', text='".$text."',ip='".$ip."'");
}


function admin_frm_mess($f_uid, $message) //Отправка уведомления от администрации в личку
{
	mysql_query("INSERT INTO forum_adm_msg SET text='".mysql_real_escape_string($message)."', date=NOW()");
	$adm_mess_id=mysql_insert_id();
	mysql_query("INSERT INTO `forum_adm_to_usr` SET f_uid='".$f_uid."', mess_id='".$adm_mess_id."', `read`='0'");
	$res=mysql_query("SELECT subscribe_email FROM forum_users  WHERE uid='".$f_uid."'");
	$user=mysql_fetch_assoc($res);
	$zsubject=convert_cyr_string("Новое уведомление от администрации форума RusCable.Ru.","w","w");
	$zheaders=convert_cyr_string("From: RusCable.Ru <admin@ruscable.ru>\nContent-type: text/plain; charset=windows-1251","w","w");
        $zmessage=convert_cyr_string("Вы получили уведомление от администрации форума RusCable.Ru:

                    ".strip_tags($message)."

                    Посмотреть уведомление Вы можете по ссылке: http://www.ruscable.ru/interactive/forum/users/adm_mess.html","w","w");



		@Mail($user['subscribe_email'],$zsubject,$zmessage,$zheaders);
		//@Mail("nik21@list.ru",$zsubject,$zmessage,$zheaders);
}

function numMonthToStr($num)
{
     $month=array(
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'апреля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря'
    );
    return($month[$num]);
}

function RCdateStr($date)
{
   $year = substr($date,0,4);
   $month=substr($date,5,2);
   $day=substr($date,8,2);

   $time=substr($date,11,5);

   return intval($day).' '.numMonthToStr($month).' '. $year.', '.$time;
}
function RCdateDayStr($date)
{
   $year = substr($date,0,4);
   $month=substr($date,5,2);
   $day=substr($date,8,2);



   return intval($day).' '.numMonthToStr($month).' '. $year;
}

function RCShortDateDayStr($date)
{
   $year = substr($date,0,4);
   $month=substr($date,5,2);
   $day=substr($date,8,2);



   return intval($day).'.'.$month.'.'. $year;
}
if(!function_exists('cut_paragraph')){
	function cut_paragraph($string,$width=400)
	{
		$your_desired_width = intval($width);
		$string = substr($string, 0, $your_desired_width+1);

		if (strlen($string) > $your_desired_width)
		{
			$string = wordwrap($string, $your_desired_width);
			$i = strpos($string, "\n");
			if ($i) {
				$string = substr($string, 0, $i);
			}
		}
		return $string;
	}
}

function rcCheckStopIP($action)
{
	$ip     = $_SERVER['REMOTE_ADDR'];
	$date   = date("Y-m-d");
	$result = GetDB("SELECT * FROM stop_ip WHERE ip = '$ip' and (action = '$action' or action = 'all') and active = '1' and date_add <= '$date' and date_stop >= '$date'");

	if(sizeof($result) > 0) return false;

	return true;
}

if(!function_exists('toja')){function toja($what){
	$what=str_replace("/[^a-zA-Z0-9а-яА-ЯёЁъЪ ,.:-]/","",$what);
	$what=date("d.m.Y H:i:s").", логин ".$_SERVER['PHP_AUTH_USER'].", IP ".$_SERVER['REMOTE_ADDR'].": ".$what;
	$msg=addslashes($what);
	$msg=iconv("CP1251", "UTF-8", $msg);
	$com="echo '$msg' | /usr/local/bin/sendxmpp -f /home/ruscableru/.sendxmpprc hermano@im.ruscable.ru";
	$res = `$com`;
}}

// для использования в мета-теге keywords
function getKeywords($text)
{
	$nonword  = array("&nbsp;");
	$text     = str_replace($nonword, " ", $text);
	$text     = strip_tags($text);

	$text     = preg_replace("~[^а-яА-Яa-zA-Z0-9-]+~", " ", $text);
	$text     = preg_replace("~\s+~", " ", $text);

	$words    = explode(" ", $text);
	$wordstat = array_count_values($words);
	arsort($wordstat);

	$keywords = '';
	foreach($wordstat as $w => $col)
	{
		if(strlen($w) > 3) $keywords .= $w.' ';
		if(strlen($keywords) > 250) break;
	}

	return trim($keywords);
}

if(!function_exists('rus2lat')){function rus2lat($str){
	$iso = array(
		"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
		"Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
		"З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
		"М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
		"С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
		"Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
		"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
		"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
		"е"=>"e","ё"=>"yo","ж"=>"zh",
		"з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
		"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
		"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
		"ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
		"ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
	);

	$string = ucfirst(strtr($str, $iso));
	return $string;
}}

function send_404(){
		header("HTTP/1.0 404 Not Found");
		include $_SERVER["DOCUMENT_ROOT"]."/error.html";
		exit;
}

if(!function_exists('sendMail')){
	function sendMail($theme,$email,$mes,$template='default.html')
	{
		//echo $mes;exit();
		$body = file_get_contents($_SERVER['DOCUMENT_ROOT']."/mail_template/".$template);
		$body = str_replace("##TITLE##", $theme, $body);
		$body = str_replace("##TEXT##", $mes, $body);

		require('Mail.php');
		require('Mail/mime.php');
		$crlf = "\n";
		$newmail = new Mail_mime($crlf);
		$newmail->_build_params = array(
			'text_encoding' => '8bit',
			'html_encoding' => 'quoted-printable',
			'7bit_wrap'     => 998,
			'html_charset'  => 'windows-1251',
			'text_charset'  => 'windows-1251',
			'head_charset'  => 'windows-1251'
		);
		$headers=array(
			'Subject'=>	$theme,
			'From' => "RusCable<no_reply@ruscable.ru>",
			'Reply-To'=> "RusCable<no_reply@ruscable.ru>",
			'Precedence' => 'bulk;'
		);

		$newmail->setHTMLBody($body);
		$out = $newmail->get();
		$hdrs = $newmail->headers($headers);
		$mail =& Mail::factory('mail');
		$mail->send($email, $hdrs, $out);
	}
}

if(!function_exists('getInformerRTL')){
	function getInformerRTL($company_id,$company_name='')
	{
		$RTLqry = "SELECT sum FROM trust_level WHERE cid = $company_id"; // Получаем значение RTL
		$company_RTL = ssql($RTLqry);

		echo '<div style="width:245px;height:90px;background-image:url(\'/i/rtl/'.$rtl_img.'.jpg\');text-align:right;color:#fff;border:0px solid red;overflow:hidden;margin:80px 0 0 -80px;">
			<div style="width:30px;height:30px;margin:37px 0 0 180px;font-size:40px;font-weight:bold;">'.$company_RTL.'</div>
		</div>';
	}
}

if(!function_exists('getHashStr')){
	function getHashStr($str)
	{
		return md5(str_replace(array(' ',',','.','-',':',';','/','\r\n', '\r', '\n',chr(13),chr(10)), '', strip_tags(strtolower(trim($str)))));
	}
}

if(!function_exists('createTicket')){
	function createTicket($title, $description) {

	   $responsible = 1000040;
	    $auditors = array(1000000);
	    $executors = array(1000055);


	    $title = mysql_real_escape_string($title);
		//$description = iconv("CP1251", "UTF-8", $description);

	    $login = "romka@totalbiz.ru";
	    $password = md5("ee66bd7843");
	    require_once($_SERVER['DOCUMENT_ROOT']."/inc/megaplan_api_php/Request.php");

	    if( $curl = curl_init() ) {
	        $ua="Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
	        $hd=array("Accept: text/html,application/xhtml+xml,application/xml;q=0.9",
	        "Accept-Language: en-us,en;q=0.5",
	        "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7");

	        #curl_setopt($curl, CURLOPT_USERAGENT, $ua);
	        #curl_setopt($curl, CURLOPT_HTTPHEADER, $hd);
	        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	        #curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	        curl_setopt($curl, CURLOPT_URL, 'https://ruscable.megaplan.ru/BumsCommonApiV01/User/authorize.api');
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
	        curl_setopt($curl, CURLOPT_POST, true);
	        curl_setopt($curl, CURLOPT_POSTFIELDS, "Login=$login&Password=$password");
	        $out = curl_exec($curl);
	        curl_close($curl);

	        $out = json_decode($out);

	        //echo '<pre>';print_r($out);echo '</pre>';

	        if($out->status->code=="ok")
	        {
	            $access_key = $out->data->AccessId;
	            $secret_key = $out->data->SecretKey;
	            $params = array(
	                "Model[Name]"=>$title,
	                "Model[Responsible]"=>$responsible,
	                "Model[Auditors]"=>$auditors,
	                "Model[Statement]"=>nl2br($description),
	                "Model[Executors]"=>$executors,
	                "Model[SuperTask]"=>"p1000048"
	            );

	            $request = new SdfApi_Request($access_key, $secret_key, "ruscable.megaplan.ru");

	            $request->get("/BumsTaskApiV01/Task/create.api", $params);

	            $result = $request->getResult();

	            $result = json_decode($result);

	            //echo '<pre>';print_r($result);echo '</pre>';

	            return $result->status->code;

	        }
	        else
	            return false;

	    }
	    else
	    {
	        return false;
	    }

	}
}

if(!function_exists('win2utf')){
	function win2utf($str)
	{
	    $utf = "";
	    for($i = 0; $i < strlen($str); $i++)
	    {
	        $donotrecode = false;
	        $c = ord(substr($str, $i, 1));
	        if ($c == 0xA8) $res = 0xD081;
	        elseif ($c == 0xB8) $res = 0xD191;
	        elseif ($c < 0xC0) $donotrecode = true;
	        elseif ($c < 0xF0) $res = $c + 0xCFD0;
	        else $res = $c + 0xD090;
	        $utf .= ($donotrecode) ? chr($c) : (chr($res >> 8) . chr($res & 0xff));
	    }
	    return $utf;
	}
}
// Дебаг элементов
function d($elem, $var_dump = 0, $die = 0){
	echo '<pre>';

	if((int)$var_dump)
		var_dump($elem);
	else
		print_r($elem);

	echo '</pre>';

	if((int)$die)
		die;
}

//Получаем последнее фото переданного пользователя, по всем привязанным соц.сетям
function socAvatar($uid){
	if((int)$uid == 0)
		return false;

	$soc_akk = sql("SELECT * FROM users_auth_social WHERE uid = '$uid' LIMIT 1", "assoc");
	if(empty($soc_akk))
		return false;
	$soc_akk = $soc_akk[0];
	unset($soc_akk['id'], $soc_akk['uid']);

	foreach ($soc_akk as $soc => $user) {
		//Пустые поля отбрасываем
		if( empty($user) )
			continue;

		$soc_user = sql("SELECT * FROM users_auth_social_$soc WHERE {$soc}_uid = '$user' LIMIT 1", "assoc");
		//создаем массив с фото и датой соц.сетей
		foreach ($soc_user as $profile) {
			$all_photo["{$soc}_date"] = strtotime($profile['date_connect']);
			$all_photo["{$soc}_photo"] = $profile['photo'];
		}

	}
	//Если нет фото
	if(count($all_photo) < 2)
		return false;

	//выбираем все даты
	foreach ($all_photo as $k => $v) {
		if(stristr($k, 'date') !== false)
			$all_date[$k] = $v;
	}
	//Получаем ключ массива с наибольшей датой
	$soc_date = array_search( max($all_date), $all_date);
	//берем ключ фото
	$soc_photo = str_replace('date', 'photo', $soc_date);
	//по ключу вытягиваем последнее фото
	return $all_photo[$soc_photo];
}



//Кешируем запрос
// $name - ключевое имя, по которому будем вытаскивать кеш
// $sql - SQL-запрос
// $memcache - объект Memcache, если вызывался ранее на странице - передаем, иначе создастся новый
// $time - время, на которое кешируем, по умолчанию 24 часа
// $assoc - получаемая выборка
// $replace - перезаписать Кеш
function getCacheSql($name, $sql, $memcache = '', $time = 86400, $assoc = 'assoc', $replace = false){

	if(empty($memcache)){
		$memcache = new Memcache;
		$memcache->connect('192.168.0.2', 11211);
	}
	$q = $memcache->get($name);

	if(!$q || $replace){
		$q = sql($sql, $assoc);
		$memcache->set($name, $q, false, $time);
	}

	return $q;
}

//Возвращаем чистый URL
function getClearUrl($url){
	$url = str_replace(array('www.', 'http://', 'https://'),'',$url);
	$url = parse_url($url);
	$zurl = $url['host']?:$url['path'];
	return rtrim($zurl, '/');
}



/*
// Функция, для получения созданных тем за определенный день, $day - в формате '2017-10-18'
if (!function_exists('getForumThemesForTheDay')) {
	function getForumThemesForTheDay() {
			$query = "SELECT forum_tree.postid, forum_tree.title, forum_sections.
sectid, forum_sections.title AS section,  forum_tree.date FROM  `forum_tree` INNER JOIN forum_sections ON forum_tree.area = forum_sections.sectid WHERE  `parent` =0 AND  `date` >  NOW() - INTERVAL 1 DAY AND  `date` <  NOW()";
			return sql($query, 'assoc'); // Возвращает двумерный ассоциативный массив
		}
}
*/


// КОСТЫЛЬ: вызываем отсюда, чтобы гарантированно запустить переадресацию на мобильный РК с любой страницы
//require_once ($_SERVER['DOCUMENT_ROOT']."/go_to_mobile.php");
require_once ("/home/ruscableru/ruscableru/www/go_to_mobile.php");

// 21 12 2017
//include($_SERVER['DOCUMENT_ROOT']."/inc/timer.class.php");
include("/home/ruscableru/ruscableru/www/inc/timer.class.php");

?>
