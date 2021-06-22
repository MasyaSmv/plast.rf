<?
//====================================================
// Административный модуль раздела 'Склад - статистика запросов'
// Last update: 15.12.2011 - Васильев Андрей
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

$cur_time   = time(); // фиксируем время на данную секунду
$today_time = date("s", $cur_time) + date("i", $cur_time)*60 + date("H", $cur_time)*60*60; // прошло секунд за сегодня
$time_start = date("Y-m-d H:i:s", ( $cur_time - $today_time - (($t-1)*24*3600) ) );        // с какого времени производим выборку
$time_stop  = date("Y-m-d H:i:s", $cur_time);                                              // по какое время производим выборку

$t_where    = " `time` >= '".$time_start."' ";

// небольшое исключение для "вчера"
if($t == 2)
{
	$time_stop  = date("Y-m-d H:i:s", ($cur_time - $today_time - 1));                      // по какое время производим выборку
	$t_where    = " `time` >= '".$time_start."' and `time` <= '".$time_stop."' ";
}

$search_period = "<span style='color: #888888;'>(с ".$time_start." по ".$time_stop.")</span>";



include("$DOCUMENT_ROOT/$document_admin/top.php");


db_connect();

//print date("H", $cur_time)."<br><br>";
//print date("i", $cur_time)."<br><br>";
//print date("s", $cur_time)."<br><br>";
//print $t_where."<br><br>";

print '<a href="?t=1" '; if($t=="1") print 'style="color:red; font-weight:bold;"'; print '>сегодня</a> &nbsp;&nbsp;';
print '<a href="?t=2" '; if($t=="2") print 'style="color:red; font-weight:bold;"'; print '>вчера</a> &nbsp;&nbsp;';
print '<a href="?t=7" '; if($t=="7") print 'style="color:red; font-weight:bold;"'; print '>неделя</a> &nbsp;&nbsp;';
print '<a href="?t=14" '; if($t=="14") print 'style="color:red; font-weight:bold;"'; print '>2 недели</a> &nbsp;&nbsp;';
print '<a href="?t=30" '; if($t=="30") print 'style="color:red; font-weight:bold;"'; print '>месяц</a> &nbsp;&nbsp;';



//$query = "SELECT forum_users.uid, forum_users.username, forum_users.status, forum_tree.uid, forum_tree.count(uid) FROM forum_tree, forum_users WHERE forum_users.uid = forum_tree.uid ORDER BY forum_users.uid GROUP BY forum_tree.uid";

//$query = "SELECT forum_users.username, forum_users.status, forum_tree.uid, count(forum_tree.uid) FROM forum_tree, forum_users WHERE forum_users.uid = forum_tree.uid GROUP BY forum_tree.uid ORDER BY count(forum_tree.uid)";

//$query = "SELECT forum_users.username, forum_users.status, forum_tree.uid, count(*) FROM forum_tree, forum_users WHERE forum_users.uid = forum_tree.uid ".$t_where."   GROUP BY forum_tree.uid ORDER BY `count(*)` DESC";

$query = "SELECT `query`, count(*) as cou FROM sklad_query_stat WHERE ".$t_where." GROUP BY `query` ORDER BY count(*) DESC ";
//echo "<p>$query</p>";

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

$out = "<p><b>Уникальных запросов: <font color=ff0000>$num</font></b>, всего запросов: <font color=ff0000>$obschkol</font>.<br>$search_period $out";

echo $out;

include("$DOCUMENT_ROOT/$document_admin/bottom.php");
?>
