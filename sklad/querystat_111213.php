<?

//====================================================

// Административный модуль раздела 'Склад - статистика запросов'

// Last update: 28.09.2011

//====================================================

include("../droot.php");

// подключаем конфиг

include_once("$DOCUMENT_ROOT/$document_admin/config.php");

// подключаем функции работы с базой

include_once("$DOCUMENT_ROOT/func.inc");

// добавляем новый элемент в массив навигации

$site_nav[]=array("name"=>"Склад - статистика запросов","url"=>"/$document_admin/sklad/querystat.php");

if(isset($_GET['t'])) $t=intval($_GET['t']);
else $t=1;
if($t==0){$t=1;}

$t_where=" `time` >= '".date("Y-m-d H:i:s",(time()-($t*24*3600)))."' ";



include("$DOCUMENT_ROOT/$document_admin/top.php");



db_connect();


print '<a href="?t=1" '; if($t=="1") print 'style="color:red; font-weight:bold;"'; print '>24 часа</a> &nbsp;&nbsp;';
print '<a href="?t=7" '; if($t=="7") print 'style="color:red; font-weight:bold;"'; print '>неделя</a> &nbsp;&nbsp;';
print '<a href="?t=14" '; if($t=="14") print 'style="color:red; font-weight:bold;"'; print '>2 недели</a> &nbsp;&nbsp;';
print '<a href="?t=30" '; if($t=="30") print 'style="color:red; font-weight:bold;"'; print '>месяц</a> &nbsp;&nbsp;';



//$query = "SELECT forum_users.uid, forum_users.username, forum_users.status, forum_tree.uid, forum_tree.count(uid) FROM forum_tree, forum_users WHERE forum_users.uid = forum_tree.uid ORDER BY forum_users.uid GROUP BY forum_tree.uid";

//$query = "SELECT forum_users.username, forum_users.status, forum_tree.uid, count(forum_tree.uid) FROM forum_tree, forum_users WHERE forum_users.uid = forum_tree.uid GROUP BY forum_tree.uid ORDER BY count(forum_tree.uid)";

//$query = "SELECT forum_users.username, forum_users.status, forum_tree.uid, count(*) FROM forum_tree, forum_users WHERE forum_users.uid = forum_tree.uid ".$t_where."   GROUP BY forum_tree.uid ORDER BY `count(*)` DESC";

$query = "SELECT `query`, count(*) as cou FROM sklad_query_stat WHERE ".$t_where." GROUP BY `query` ORDER BY count(*) DESC ";
//echo $query;

$rows = GetDB($query);
$num  = count($rows);


$out="";




$out.= "\n<p>\n<table border=0 width=600 cellpadding=3 cellspacing=1 class=\"color1\">\n";

$out.= "<tr class=\"color2\">\n";

$out.= "\t<td align=center width=30><div class=\"fnt2\"><b>Запрос</b></div></td>\n";

$out.= "\t<td align=center width=120><div class=\"fnt2\"><b>Количество</b></div></td>\n";

$out.= "</tr>\n";

$obschkol=0;
for ($i=0;$i<$num;$i++)
{
	$out.= "<tr class=\"color4\">\n";
	$out.= "\t<td><div class=\"fnt2\">".$rows[$i]['query']."</a></div></td>\n";
	$out.="\t<td align=center><div class=\"fnt2\">".$rows[$i]['cou']."</div></td>\n";
	$out.="</tr>\n";
	$obschkol+=intval($rows[$i]['cou']);
}

$out.= "</table>\n";


$out= "<p><b>Уникальных запросов: <font color=ff0000>$num</font></b>, всего запросов: <font color=ff0000>$obschkol</font>.$out";

echo $out;


include("$DOCUMENT_ROOT/$document_admin/bottom.php");

?>

