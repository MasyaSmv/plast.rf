<?
if(!function_exists('word_ending')){function word_ending($number, $one, $two, $many) {
	if (strlen($number) > 2){
		$number = substr($number, -2);
	}
	if ($number > 9 && $number < 20) {
		return $many;
		break;
	}
	$number = (strlen($number) > 1) ? substr($number, -1) : $number;

	if($number == 1){
		return $one;
		break;
	}elseif($number >= 2 && $number <= 4) {
		return $two;
		break;
	}else{
		return $many;
		break;
	}
}
}

//print_r($_GET);exit;

if(!function_exists('sql')){function sql($q){$res=array();$r=@mysql_query($q);if(@mysql_num_rows($r)>0){while($row=@mysql_fetch_row($r)){$res[]=$row;}}return $res;}}

if(!function_exists('ssql')){function ssql($q){return mysql_result(mysql_query($q),0,0);}}
$db_server="192.168.0.1";
$db_user="ruscableru";
$db_password="7o4hcdv3ef";
$db_database="ruscableru";
if(!function_exists('db_connect')){
	function db_connect()
	{
		global $db_server, $db_user, $db_password, $db_database;
		$connected = mysql_connect($db_server, $db_user, $db_password) && mysql_select_db($db_database);
		if( !$connected ) { die(""); }else {mysql_query("set names utf8");}
	}
}
db_connect();

$wd=intval($_GET['wd']);
if($wd < 150 || $wd > 400){
	$wd=200;
}
$cr=intval($_GET['cr']);
if($cr < 1 || $cr > 2){
	$cr=1;
}
$bg=trim($_GET['bg']);
if(preg_match("/[^#0-9a-fA-F]/",$bg)){
	$bg="#bde2fe";
}else{
	$bg="#".$bg.";";
}
$t=trim($_GET['t']);
if(preg_match("/[^#0-9a-fA-F]/",$t)){
	$t="#333333";
}else{
	$t="#".$t.";";
}
$cn=trim($_GET['cn']);
if(mb_detect_encoding($cn,"UTF-8, CP1251, ASCII")!="UTF-8"){
	$cn2=mb_convert_encoding($cn,"UTF-8");
}else{
	$cn2=$cn;
}
$cn2=stripslashes($cn2);
$cn2=str_replace("'","",$cn2);
$uid=intval($_GET['uid']);

$isuid=ssql("select count(*) from users where id=$uid and activ=1");
$colpos=ssql("select count(*) from sklad_tovar where comp_id=$uid");


if($isuid==0 || $colpos==0){
	$tmpl2=<<<TMPL2
<style>
#informbody{
	width: 200px;
	border: 1px solid #057fc5;
	border-radius: 5px;
	background-color: #bce3fc;
	text-align: center;
}
#companyname {
	padding: 15px 5px;
	margin: 5px 5px auto;
	background-color: white;
	border-radius: 2px;
}
#companyname a{
	font-size: 16px;
	font-weight: bold;
	color: #fc6600;
	text-decoration: none;
}

#positions{
	font-size: 12px;
	font-weight: bold;
	font-family: Verdana;
	color: #333333;
	margin: 5px 0px auto;
	padding: 5px 1px;
}
#positions a{
	text-decoration: none;
	color: #333333;
	border-bottom: 1px solid #333333;
}
#verification{
	padding: 5px;
	font-family: Tahoma;
	background-color: white;
	font-size: 12px;
	margin: 5px;
	line-height: 18px;
	border-radius: 2px;
}
#ruscable-informer-logo{
	width: 100px;
}
</style>
<div id=informbody>
<div id=companyname>
		<a target=_new href="http://sklad.ruscable.ru/">SKLAD.RusCable.Ru</a>
</div>
<div id=positions>
	Сотни организаций и десятки тысяч позиций<br>КПП <a target=_new href="http://sklad.ruscable.ru/">из наличия</a>!
</div>
<div id=verification>
	Проверено:<br>
	<a target=_blank href="http://www.ruscable.ru/"  title="RusCable.Ru"><img id="ruscable-informer-logo" src="http://www.ruscable.ru/i/logo.gif" border=0></a>
</div>
</div>
TMPL2;

	header("Content-type: text/javascript; charset=utf-8");
	$res2=explode("\n",$tmpl2);
	foreach($res2 as $res3){
		print "document.write('".trim($res3)."');\n";
	}
	exit;
}

$tmpl=<<<TMPL
<style>
#ruscable-informer-informbody{
	:::WIDTH:::
	border: 1px solid #057fc5;
	:::BG:::
	text-align: center;
	:::BR1:::
}
#ruscable-informer-companyname{
	font-family: Arial, Tahoma;
	font-size: 16px;
	font-weight: bold;
	color: #fc6600;
	padding: 5px;
	margin: 5px 5px auto;
	background-color: white;
	:::BR2:::
}
#ruscable-informer-positions{
	font-size: 12px;
	font-weight: bold;
	font-family: Verdana;
	:::T:::
	margin: 5px 0px auto;
	padding: 5px 1px;
}
#ruscable-informer-positions a{
	text-decoration: none;
	color: #333333;
	border-bottom: 1px solid #333333;
}
#ruscable-informer-verification{
	padding: 5px;
	font-family: Tahoma;
	background-color: white;
	font-size: 12px;
	margin: 5px;
	line-height: 18px;
	:::BR2:::
}
#informer-rc-logo{
	width: :::LOGOWD:::;
}
</style>
<div id="ruscable-informer-informbody">
<div id="ruscable-informer-companyname">
:::CN:::
</div>
<div id="ruscable-informer-positions">
	Наше наличие на складе<br>
	Всего: <a target=_new href="http://sklad.ruscable.ru/catalog/:::SEF:::?frominf=1">:::COLPOS::: :::NAIMEN:::</a>
</div>
<div id="ruscable-informer-verification">
	Проверено:<br>
	<a target=_blank href="http://www.ruscable.ru/" title="RusCable.Ru"><img id="informer-rc-logo" src="http://www.ruscable.ru/i/logo.gif" border=0></a>
</div>
</div>
TMPL;

$res=str_replace(":::WIDTH:::","width:".$wd."px;", $tmpl);
$logowd=intval($wd/2)."px";
$res=str_replace(":::LOGOWD:::",$logowd, $res);

if($cr==1){
	$res=str_replace(":::BR1:::","border-radius: 5px;", $res);
	$res=str_replace(":::BR2:::","border-radius: 2px;", $res);
}else{
	$res=str_replace(":::BR1:::","",$res);
	$res=str_replace(":::BR1:::","",$res);
}
$res=str_replace(":::BG:::","background-color:".$bg, $res);
$res=str_replace(":::T:::","color:".$t, $res);
$res=str_replace(":::CN:::",$cn2, $res);


$sef=rus2lat($cn2);
$sef=preg_replace("/\s+/","-",$sef);
$sef=preg_replace("/[^a-zA-Z0-9-]/","",$sef);
$sef=strtolower($sef);
$sef.="-".$uid;
$res=str_replace(":::SEF:::",$sef, $res);

$res=str_replace(":::COLPOS:::",$colpos, $res);
$res=str_replace(":::NAIMEN:::",word_ending($colpos,"наименование","наименования","наименований"), $res);

header("Content-type: text/javascript; charset=utf-8");
$res2=explode("\n",$res);
foreach($res2 as $res3){
	print "document.write('".trim($res3)."');\n";
}

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
	"ые"=>"ye"
);

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


?>