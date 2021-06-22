<?
include_once("inc/func.inc");
@db_connect2();

if(mb_detect_encoding($_GET['data'],"UTF-8, CP1251, ASCII, Windows-1251")!="UTF-8"){
	//$stext=mb_convert_encoding($_GET['data'],"UTF-8");
	$stext=iconv("CP1251","UTF-8",trim($_GET['data']));
}else{
	$stext=trim($_GET['data']);
}

$w=mysql_real_escape_string($stext);
if($w==""){
	exit;
}
if(strlen($w)<5){
	print "Слишком короткий запрос";
	exit;
}

$adq="";
if($_SESSION['informer_comp_id']>0){
	$adq.=" and comp_id = ".$_SESSION['informer_comp_id'];
}

if($curcity==""){
	//$q="select distinct title from sklad_tovar where title like '%$w%' $adq order by title LIMIT 0,50";
	$q="select distinct title from sklad_tovar where title like '$w%' $adq order by title LIMIT 0,50";
}else{
	$q="select distinct s.title from sklad_tovar s,users u where s.comp_id=u.id and u.city='$curcity'  and s.title like '$w%' $adq order by title LIMIT 0,50";
}
$r=sql($q);
if(sizeof($r)==0){
	print "Нажимай поиск! Найдется все!";
}else{
	foreach($r as $rr){
		list($title)=$rr;
		$out.="<li><a href='/$title'>$title</a></li>";
	}
	print "<ol>$out</ol>";

}

?>