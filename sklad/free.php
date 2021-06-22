<?
$where_am_i="sklad";
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
$site_nav[]=array("name"=>"Склад - Бесплатные клиенты (тариф Базовый)</a>","url"=>"/$document_admin/sklad/free.php");


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

	$count = ssql("SELECT count(*) from company_usl_list where tarif_id=19 order by id");
	$pages_count = ceil($count / $perpage);
	if ($page > $pages_count) $page = $pages_count; 
	$start_pos = ($page - 1) * $perpage;

	if($_GET['search']!=""){
		$stext=mysql_real_escape_string(trim($_GET['search']));
		$adq="and c.title like '%$stext%'";
	}else{
		$adq="";
	}

	$q="select  id,title from company where order by id desc LIMIT ".$start_pos.", ".$perpage;
//	$q="select distinct comp_id as cid, count(*) as kol, date_cr from sklad_tovar group by comp_id order by date_cr  LIMIT ".$start_pos.", ".$perpage;
	
	$q="SELECT cul.company_id as cid, DATE_FORMAT( cul.date_begin , '%d.%m.%Y' ),DATE_FORMAT( cul.date_end , '%d.%m.%Y' ), c.title FROM company_usl_list cul,company c WHERE  cul.tarif_id=19 and c.id=cul.company_id $adq ORDER BY cul.date_end desc  LIMIT ".$start_pos.", ".$perpage;
	$r=sql($q);


$cc=$start_pos;

print "<form>Поиск по названию компании: <input type=text name=search value='$stext'> <input type=submit value='найти'></form>";

print "<table border=0 width=100% cellpadding=3 cellspacing=1 class=color1><tr class=color2><td>№</td>
<td>Организация</td><td>Дата начала</td><td>Дата окончания</td><td>Сделано поисков</td><td>Обнулить счетчик поисков</td>

</tr>";

foreach($r as $rr){
	$cc++;
	list($cid,$date_b,$date_e,$title)=$rr;
	if(strtotime($date_e)<time()){
		$date_e="<font color=red>$date_e</font>";
	}
	$kol=ssql("select count(*) from sklad_free_access where c_id=$cid and vremya >='".date("Y-m-d", strtotime($date_b))."' and 
	vremya <='".date("Y-m-d", strtotime($date_e))."'
	");
	print '
<tr class=color4><td>'.$cc.'</td>
<td><a href=/admin2/or/?a=edit&id='.$cid.'&page='.$_GET['page'].'&c='.$cid.'>'.$title.'</a></td><td>'.$date_b.' </td><td>'.$date_e.'</td><td>'.$kol.'</td><td><a href=null.php?clear='.$cid.'>обнулить</a></td></tr>';

}
print "</table>";
if ($pages_count >1 && !$_GET['search']){ link_bar($page, $pages_count); } 
}
include("$DOCUMENT_ROOT/$document_admin/bottom.php"); 



?>


