<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head>
<?if(!$title_tag){$title_tag="RusCable.Ru :: Склад";}?>
<title><?=$title_tag?></title> 
 <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
<meta name="ROBOTS" content="ALL" /> 
<meta name="COPYRIGHT" content="Copyright © <?=date("Y")?> RusCable.Ru" /> 
<meta name="description" content="Сервис, созданный для эффективного и быстрого поиска кабельно-проводниковой продукции из наличия. Размещение складских остатков для поставщиков - абсолютно бесплатно." /> 
<meta name="keywords" content="провод кабель наличие ввг ввгнг кввг аабл асб аашв 3х240" /> 
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<!--[if IE]><link type="text/css" rel="stylesheet" media="all" href="/css/ie.css" /><![endif]-->

<script type="text/javascript" src="/misc/common.js"></script>
<script type="text/javascript" src="/misc/jquery.min.js"></script>
<script type="text/javascript" src="/misc/jquery.qtip-1.0.0.min.js"></script>
<script type="text/javascript" src="/misc/jquery.lwtCountdown-1.0.js"></script>
<script>
jQuery(function(){
$('#whatis').qtip({ style: { 
		border: {
         width: 3,
         radius: 8,
         color: '#0079c2'
      },
 tip: true } })
});
jQuery(function(){
$('#city').qtip(
	{ style: { 
		border: {
        	width: 3,
        	radius: 8,
        	color: '#0079c2'
      	}, 
      	width: 200,
      	tip: true 
      },
      position: {
      	corner: {
         target: 'bottomLeft',
         tooltip: 'topRight'
      	}
   	  },
      hide: 'unfocus',
      show: 'click',
      content: {
      	title: 'Кабель есть в наличии в городах:'
      }
    });
});
jQuery(function(){
$('.comments').qtip({ style: { 
		border: {
         width: 2,
         radius: 4,
         color: '#0079c2'
      },
 tip: true } })
});
<?
if($action11_enabled=="YES"){
?>
function action_start(){
   id=setInterval('time()',1000);
}
function time(){
	var dat = new Date();
   	var actionutchour=<?=$actionUTCh?>;
   	var currenthour=dat.getUTCHours();
   	var min=dat.getMinutes();
   	var sec=dat.getSeconds();
   	if(currenthour == actionutchour && min==<?=$action11mbegin?> && sec==0){
   		/* начало акции */
		document.location.href =	document.location.href;
   	}
   	if(currenthour == actionutchour && min==<?=$action11mend?> && sec<2){
   		/* конец акции */
		document.location.href =	document.location.href;
   	}
}
<?}?>
</script>
</head> 
 
<body <?
if($action11_enabled=="YES"){
?>
onload='action_start()' <?}?>> 
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" style="margin: 0;	padding: 0; border: 0;
	outline: 0;"> 
<tr valign=top> 
	<td class="all_1" height="120" id="content"> 
	<div id="topline_b"  style="width:100%"><center>
</center>
</div>
		<table border="0" width="100%" height="120" cellpadding="0" cellspacing="0"> 
		<td width="237" valign="top"> 
			<div class="head_logo"><a href="http://www.ruscable.ru/"><img src="http://www.ruscable.ru/i/logo.gif" width="187" height="32" border="0" alt="RusCable.Ru"></a>
			<br>
			<b style="padding-left:23%"><a href=http://sklad.ruscable.ru style="color:#fe5a24">СКЛАД</a>
			</b>
			</div> 
			<div class="head_4 date"><?show_head_date()?></div> 
		</td> 
		<td valign=top width="30%"> 
			<!-- Логин --> 
						<div class="login"> 
							
<?
if($action11_enabled=="YES" && $action11==1){
$curd=date("d");
$curm=date("m");
$cury=date("Y");
	if($sklad_uid > 0){
		print "<h2 style='margin-bottom:0px;'><a href='http://www.ruscable.ru/users/'>Войти в личный кабинет</a></h2>";
		print "<span style='line-height: 1,5;'>".$_SESSION['s_name']."";
		print ", ".$_SESSION['c_name']."<br>";
	}else{
		print "Здравствуйте, гость.<br>";
	}
	print <<< EOFA
	<font color=red><b>Акция - «11 с половиной минут!»</b></font><br> 
	
			Поисков по базе: неограниченное количество<br>

			Окончание акции через: 
	<div id="countdown_dashboard">
		<div class="dash minutes_dash">
			<span class="dash_title">&nbsp;мин.&nbsp;</span>
			<div class="digit">0</div>
			<div class="digit">0</div>
			
		</div>
		<div class="dash seconds_dash">
			<span class="dash_title">&nbsp;сек.&nbsp;</span>
			<div class="digit">0</div>
			<div class="digit">0</div>
			
		</div>
	</div>
	</span>
<script language="javascript" type="text/javascript">
var d = new Date();
var action11h = d.getHours();
jQuery(function(){
	$('#countdown_dashboard').countDown({
		targetDate: {
			'day': 		$curd,
			'month': 	$curm,
			'year': 	$cury,
			'hour': 	action11h,
			'min': 		$action11mend,
			'sec': 		0
		}
	});
});
		</script>			
EOFA;


}else{
if($authorized > 0){
	print "<h2 style='margin-bottom:0px;'><a href='http://www.ruscable.ru/users/'>Войти в личный кабинет</a></h2>";
	$str_end_date=date("d.m.Y г.",strtotime($end_date));
	if($authorized===1){
		if($sklad_cid){
			print "<span style='line-height: 1,5;'>".$_SESSION['s_name']."";
			print ", ".$_SESSION['c_name']."<br>";
			print "Тариф: Базовый, оканчивается $str_end_date<br> 
			Поисков по базе: $free_searches
			</span>
			";
		}else{
			print "Для просмотра позиций по базовому тарифу добавьте данные вашей компании в личном кабинете. После проверки данных базовый тариф будет включен Вам автоматически.<br>";
		}
	}elseif($authorized===2){
		print "<span style='line-height: 1,5;'>".$_SESSION['s_name']."";
		print ", ".$_SESSION['c_name']."<br>";
		print "Тариф: Безлимитный, оканчивается $str_end_date<br> 
		Поисков по базе: неограниченное количество
		</span>
		";
	}
	print "<br><a href='http://www.ruscable.ru/users/logout.html'>выйти</a>";

}elseif($sklad_uid > 0 && ($sklad_cid=="" || $sklad_cid==0)){
		print "<span style='line-height: 1,5;'>".$_SESSION['s_name']."<br>";
		print "Для получения доступа по Базовому тарифу, пожалуйста,<br>
		<a href='http://www.ruscable.ru/users/company.html'>добавьте данные о компании<br>в профиле пользователя</a>
		</span>
		";
}else{
?>
							<h2>Личный кабинет</h2>
							<form  method="post" action="http://www.ruscable.ru/users/logon.html">
							<input type="text"  name="login"  value="логин" class="in" id="login1" onfocus="javascript:getElementById('login1').value='';"/> 
							<input type="password" name="pass"  value="пароль" class="in" id="pass1" onfocus="javascript:getElementById('pass1').value='';"/>
							<input type="image" src="/img/button.gif" value="войти"/>
							<br><br>
							<a  href="http://www.ruscable.ru/users/registr.html" title="" rel="nofollow">регистрация</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<a href="http://www.ruscable.ru/users/pass.html" title="" rel="nofollow">забыли пароль?</a>
							</form> 
<? } } ?>							
							</div> 
					<!-- //Логин --> 

					

			
			
			
		</td> 
		<td valign=top>
			<div class="hhead"> 
			<h2>География поиска:</h2>
			<?	if($curcity!=""){
					print "Выбранный город: $curcity<br><a href='/setcityall'>поиск по всем городам</a>";
				}else{
					print "Поиск по всем городам";
				}
			?>	
			</div>
		</td>

		
		
		<td  width="10%" valign=top align=right>
		<div class="hhead"> 
				<h2>Статистика</h2>
				<?
				$all_kol_tovar=ssql("select count(id) from sklad_tovar where visible=1");
				print '<span style="color:#888888;"><a href=/catalog/>Всего товаров: '.$all_kol_tovar.'</a></span>';
				$all_kol_comp=ssql("select count(distinct comp_id) from sklad_tovar");
				print '<br/><span style="color:#888888;">Всего складов: '.$all_kol_comp.'</span>';
				?>
				<h2>Популярные запросы</h2>
				<?
				// 3 популярных запроса за последнюю неделю (7 дней)

				$qstat_t     = 7;
				$cur_time    = time(); // фиксируем время на данную секунду
				$today_time  = date("s", $cur_time) + date("i", $cur_time)*60 + date("H", $cur_time)*60*60; // прошло секунд за сегодня
				$time_start  = date("Y-m-d H:i:s", ( $cur_time - $today_time - (($qstat_t-1)*24*3600) ) );  // с какого времени производим выборку

				$qstat_where = " `time` >= '".$time_start."' ";
				$qstat_query = "SELECT `query`, count(*) as cou FROM sklad_query_stat WHERE ".$qstat_where." GROUP BY `query` ORDER BY count(*) DESC LIMIT 3";

				$qstat       = sql($qstat_query);
				print '<span style="color:#888888;">';
				for($ii=0; $ii<sizeof($qstat); $ii++)
				{
					print '"'.$qstat[$ii][0].' - '.$qstat[$ii][1].'"<br>';
				}
				print '</span>';
				?>
			</div>
		
		</td> 
		</table> 
	</td> 
</tr> 

<?/*

<tr> 
	<td class="all_1" height="60"> 
		<table border="0" width="100%" height="60" cellpadding="0" cellspacing="0"> 
		<tr> 
			<td class="head_2"> 
 
			<table border="0" width="100%" cellpadding="0" cellspacing="0"> 
			<tr> 
				<td align="center" width="20%" ><a href="/" class="menu<?if($navpage=="main"){ print " active";}?>">Найти кабель</a></td> 
				<td align="center" width="20%"><a href="/spisok/" class="menu<?if($navpage=="comp"){ print " active";}?>">Список складов</a></td> 
				<td align="center" width="20%"><a href="/add/" class="menu<?if($navpage=="add"){ print " active";}?>">Как добавить склад</a></td> 
				<td align="center" width="20%"><a href="/tarifs/" class="menu<?if($navpage=="tarifs"){ print " active";}?>">Тарифы</a></td> 
				<td align="center" width="20%"><a href="/info/" class="menu<?if($navpage=="info"){ print " active";}?>">Справка</a></td> 
			</tr> 
			</table> 
 
			</td> 
		</tr> 
		</table> 
	</td> 
</tr> 
*/?>

<tr> 
	<td class="all_1" height="60"> 
		<table border="0" width="100%" height="60" cellpadding="0" cellspacing="0"> 
		<tr> 
			<td class="head_2"> 
 
			<table border="0" width="100%" cellpadding="0" cellspacing="0"> 
			<tr> 
				<td align="center" width="20%"><a href="/" class="menu<?if($navpage=="info"){ print " active";}?>">О сервисе</a></td> 
<? /*				<td align="center" width="20%" ><a href="/" class="menu<?if($navpage=="main"){ print " active";}?>">Найти кабель</a></td> 				
*/ ?>
				<td align="center" width="20%"><a href="/tarifs/" class="menu<?if($navpage=="tarifs"){ print " active";}?>">Покупателям</a></td> 
				<td align="center" width="20%"><a href="/add/" class="menu<?if($navpage=="add"){ print " active";}?>">Продавцам</a></td> 
				
				<td align="center" width="20%">&nbsp;</td> 
			</tr> 
			</table> 
 
			</td> 
		</tr> 
		</table> 
	</td> 
</tr> 



<tr> 
	<td class="all_1" height="3"><img src="/img/point-red.gif" width="100%" height="3" border="0"></td> 
</tr> 
<tr> 
	<td class="all_1" height="5"><img src="/img/e.gif" width="1" height="5" border="0"></td> 
</tr> 
<tr> 
	<td class="all_1" valign="top"> 
		<table border="0" width="100%" height="120" cellpadding="0" cellspacing="0"><tr>
		<td valign="top"> 
<div class="content">
<script>
$(document).ready(function(){
$('#stext').keyup( function() {
		if($('#stext').val()==""){
			$('#suggest').css('padding','0');  
			$('#suggest').css('display','none');  
		}else{
			if($("input:checked").length >0){
				$('#suggest').css('display','block');
				$f="data=" + unescape($('#stext').val());
			
				$.ajax({
				type: "GET",
				url: "/suggest.php",
				data: $f,
				contentType: "application/x-www-form-urlencoded",
				success: function(data){
				$('#suggest').html(data);
				$('#suggest').css('display','block');    
				$('#suggest').css('border','1px solid #0079c2');    
				$('#suggest').css('z-index','1000');    
				$('#suggest').css('background','#ffffff');
				$('#suggest').css('padding','10px'); 
				$('#suggest').css('position','relative'); 
				$('#suggest').css('top','15px'); 
				}
				});
			}	
		}
		
});
});
</script>
<?
$ppageout="";
$ppage=array(30,50,100,500);
foreach($ppage as $ppage1){
	if($perpage==$ppage1){
		$ppageout.=" $ppage1 ";
	}else{
		$ppageout.=" <a href='/setrecordsperpage$ppage1'>$ppage1</a> ";
	}			
}
$ppageout="&nbsp;&nbsp;&nbsp;Позиций на странице: $ppageout";
$examples=array(
'3х150',
'ААБл',
'АВВГ',
'АВВГнг-LS 5х120',
'АПвБбШп',
'АПвБбШп 4х120',
'АСБ',
'ВВГнг 4х16',
'ВВГнг-FRLS',
'КПСВВ',
'КУПЭВ 2х2',
'СИП',
'КПСВВнг-LS');
$e1=$e2=$e3=$e4=$e5=0;
while($e1==$e2 || $e1==$e3 || $e1==$e4 || $e1==$e5 || $e2==$e3 || $e2==$e4 || $e2==$e5 || $e3==$e4 || $e3==$e5 || $e4==$e5){
	$e1= rand ( 0, sizeof($examples)-1 );
	$e2= rand ( 0, sizeof($examples)-1 );
	$e3= rand ( 0, sizeof($examples)-1 );
	$e4= rand ( 0, sizeof($examples)-1 );
	$e5= rand ( 0, sizeof($examples)-1 );
}
$exstr=<<<EXSTR
<a href="/$examples[$e1]">$examples[$e1]</a>, 
<a href="/$examples[$e2]">$examples[$e2]</a>, 
<a href="/$examples[$e3]">$examples[$e3]</a>, 
<a href="/$examples[$e4]">$examples[$e4]</a>, 
<a href="/$examples[$e5]">$examples[$e5]</a>
EXSTR;
?>
<form action="/poisk/" name="poisk">
<table width=100% bgcolor="#0079c2" style="padding-top: 5px;">
<tr>
	<td valign="middle" width=90%>
		<div class="search"> 				
			<span style="font-size: 16px; font-family: Arial;"><strong>Поиск кабеля из наличия:</strong></span>
			<input type="text" id="stext" name="stext" value="<?=$ruri?>" class="in"/>
			<div id="suggest"></div>
			<span >Например: <?=$exstr?></span>	<span><input type=checkbox name=smart> &larr;умный поиск (<a href='javascript:void(0);' id="whatis" title="<p><b>Умный поиск</b><br>
Начните вводить марку кабеля и умный поиск подскажет Вам какие похожие марки есть на СКЛАДе. А потом просто кликните по наиболее подходящему результату. Точность запроса экономит Ваше время!<br><b>Снимите галочку, если хотите пользоваться обычным поиском.</b></p>">что это?</a>)
		</span><span><?=$ppageout?></span>	
	</td>
	<td valign="middle">							
		<input type="submit" class=bottom value="Найти кабель"/>
	</td>
</tr>
</table>
</form> 	