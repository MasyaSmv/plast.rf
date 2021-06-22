<?
header("Content-type: text/html; charset=windows-1251");

ini_set('display_errors','on');
$ar1=array();
$ar2=array();

include("../../func.inc");
db_connect();
$q="select distinct comp_id from sklad_tovar order by comp_id";
$r=sql($q);
foreach($r as $rr){
	list($id)=$rr;
	$ar1[]=$id;
}
$q="select distinct s.comp_id as cid, count(`s`.`id`) as kol, s.date_cr, u.name, u.comp as title from sklad_tovar s,users u where s.comp_id=u.id group by s.comp_id order by s.comp_id";
$r=sql($q);
foreach($r as $rr){
	list($id)=$rr;
	$ar2[]=$id;
}
?>
<table border=1><tr><td valign=top>
<?
print sizeof($ar1)."<hr>";
foreach($ar1 as $v){
	print "$v<br>";
}
?>
</td><td valign=top>
<?
print sizeof($ar2)."<hr>";
foreach($ar2 as $v1){
	if(in_array($v1,$ar1)){
		print "$v1<br>";
	}else{
		print "-----<br>";
	}
}
?>
</td></tr></table>