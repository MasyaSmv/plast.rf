<?
header("Content-type: text/html; charset=windows-1251");

ini_set('display_errors','on');
if(!isset($_GET['comp']) || strlen($_GET['comp'])<3){exit;}

include("../../func.inc");
db_connect();
//mysql_query("set names utf8");

$comp=trim($_GET['comp']);
if(mb_detect_encoding($comp,"UTF-8, CP1251, ASCII")=="UTF-8"){
		$comp=iconv("UTF-8","CP1251",$comp);
}

$q="select id,`name`,comp from users where activ=1 and (name like '%$comp%' or comp like '%$comp%') order by name limit 0,20";
$r=sql($q);
if(sizeof($r)>0){
//	header("Content-type: text/html; charset=windows-1251");
}
foreach($r as $rr){
	list($id,$name, $comp)=$rr;
	$title="$name, $comp";
	$title=str_replace("'",'"',$title);
	//$title2=iconv("UTF-8","CP1251",$title);
	print "<a href='javascript:return false;' class='select_comp' comp_id='$id' comp_name='$title'>$title</a><br>";
}
print "
<script>
$(document).ready(function(){  
	$('.select_comp').click(function(){
		$('#company1').val($(this).attr('comp_name'));
		$('#company2').val($(this).attr('comp_id'));
	});
});
</script>
";
?>