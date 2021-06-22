<?
$where_am_i="sklad";
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
$site_nav[]=array("name"=>"<a href=/admin2/sklad/>Склад - Просмотр складов</a>","url"=>"/$document_admin/sklad/");


db_connect();

include("$DOCUMENT_ROOT/$document_admin/top.php");


if(!isset($_GET['c'])){$c=0;}
?>
<style>
table tr td {font-size:12px;}
.form, .form td
{
	border-collapse: collapse;
	border: 1px solid #7E89B1;
	padding:5px;
	font-size: 12px;
}
.red
{
	color:red;
}
.none_bord
{
	border:none;
}
.none_bord td
{
	border:none;
}
.form a
{
	font-size: 12px;
}
	
</style>
<script language=Javascript>
function ch(){
ans = confirm("Удалить ?");
if(ans){return true;}else{return false;}   
}
</script>

<? 
 //---------------------------------------------------------------------		

//-----------------------------------------------------------------------------
if(!isset($_GET['a']))
{
$perpage = 30;//кол-во элементов на странице
function link_bar($page, $pages_count) 
{ 
for ($j = 1; $j <= $pages_count; $j++) 
{ 
// Вывод ссылки 
if ($j == $page) { 
echo ' <a ><b>'.$j.'</b></a> '; 
} else { 
echo ' <a  href="?page='.$j.'&c='.$_GET['c'].'&s='.$_GET['s'].'"" style="color:#616161;text-decoration: none;">'.$j.'</a> ';
} 
// Выводим разделитель после ссылки, кроме последней 
// например, вставить "|" между ссылками 
if ($j != $pages_count) echo ' '; 
} 
return true; 
} // Конец функции 
	
	
	
	
$where="1 ";



if (!isset($_GET['page']) || ($_GET['page'] <= 0)) 
	{ 
		$page = 1; 
	} 
	else 
	{ 
		$page =  $_GET['page']; // Считывание текущей страницы 
	} 

	$count = ssql("SELECT count(distinct comp_id) from sklad_tovar order by id");
	$pages_count = ceil($count / $perpage);
	if ($page > $pages_count) $page = $pages_count; 
	$start_pos = ($page - 1) * $perpage;


	//$q="select  id,title from company where order by id desc LIMIT ".$start_pos.", ".$perpage;
//	$q="select distinct comp_id as cid, count(*) as kol, date_cr from sklad_tovar group by comp_id order by date_cr  LIMIT ".$start_pos.", ".$perpage;
	if($_GET['search']!=""){
		$stext=mysql_real_escape_string(trim($_GET['search']));
		$adq="and (u.email like '%$stext%' or u.comp like '%$stext%' or u.`name` like '%$stext%' or u.login like '%$stext%') ";
	}else{
		$adq="";
	}
	$q="select distinct s.comp_id as cid, count(`s`.`id`) as kol, s.date_cr, u.name, u.comp as title, u.city from sklad_tovar s,users u where s.comp_id=u.id $adq group by s.comp_id order by s.date_cr  LIMIT ".$start_pos.", ".$perpage;
	$r=sql($q);


$cc=$start_pos;

print "
<script language=Javascript>
function ch(){
ans = confirm('Удалить позиции?');
if(ans){return true;}else{return false;}   
}
</script>
<form>
Поиск по имени и email: <input type=text name=search value='$stext'> <input type=submit value='найти'>
</form>
<table border=0 width=100% cellpadding=3 cellspacing=1 class=color1><tr class=color2><td width=5%>№</td>
<td width=25%>Пользователь</td><td width=25%>Организация</td><td>Город</td><td>Файлов</td><td width=20%>Товаров</td><td width=20%>Дата добавления</td><td>Удалить позиции</td>
</tr>";

foreach($r as $rr){
	$cc++;
    $prodl="";
	list($cid,$kol_tov,$date,$name,$comp,$city)=$rr;
	if((time()-strtotime($date)) > 1209600){
		$date="<font color=red>$date</font>";
        $prodl='<a href="/admin2/sklad/prodl.php?uid='.$cid.'">продлить</a> ';
	}
	$files=ssql("select count(*) from sklad_userfiles_stat where uid=$cid");	
	print '
<tr class=color4><td>'.$cc.'</td>
<td><a href="/admin2/users/users.html?id='.$cid.'&page=1">'.$name.'</a></td>
<td><a href="/admin2/users/users.html?id='.$cid.'&page=1">'.$comp.'</a></td>
<td>'.$city.'</td>
<td>'.$files.' </td><td>'.$kol_tov.' </td><td>'.$date.'</td>
<td>'.$prodl.'<a href="/admin2/sklad/del.php?uid='.$cid.'" onclick="return ch();">удалить</a></td>
</tr>';

}

print "</table>";

if ($pages_count >1) link_bar($page, $pages_count); 
}

include("$DOCUMENT_ROOT/$document_admin/bottom.php"); 



?>


