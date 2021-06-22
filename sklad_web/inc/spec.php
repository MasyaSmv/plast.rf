<?php
$dbr = mysql_query("SELECT ms.*, c.title as c_title, c.id as c_id FROM market_spec ms LEFT JOIN company c ON c.id = ms.c_id WHERE ms.active = 1 ORDER BY RAND() LIMIT 2");
if ($dbr && mysql_num_rows($dbr)) {
	while ($item = mysql_fetch_assoc($dbr)) {
?>
		<div class="specblock"><img src="/img/specblock_top.gif" width="239" height="6" /><div class="header">Спецпредложение от:<br /><a href="/company-<?=$item['c_id']?>.html"><?=$item['c_title']?></a></div>
			<div class="content">
				<table><tr><td>
				<h2><?=$item['title']?></h2>
				<?php if (strlen($item['content']) < 150) { ?>
				<p style="width:200px;overflow:hidden"><?=nl2br(htmlspecialchars($item['content']))?></p>
				<?php } else { ?>
				<p style="width:200px;overflow:hidden"><?=nl2br(htmlspecialchars(substr($item['content'], 0, 150)))?>...</p>
				<a href="/spec/?id=<?=$item['id']?>">» <span>Подробнее</span></a>
				<?php } ?>
				</td></tr></table>
			</div><img src="/img/specblock_bottom.gif" width="239" height="6" /></div>
		<br/>
	
<?
	}
}	

if(isset($cat)){
	if(is_array($cat)){
		$cat2=$cat['p_id'];
	}else{$cat2=$cat;}
}
if($cat2 != ""){
	
	$ottitle=ssql("select title from market_cat where id=$cat2");	
	$ottitle2=str_replace(" ","%",$ottitle);
	$ottitle2=preg_replace("/(%.%)/","%",$ottitle2);
	$q="SELECT id, city, name, comments  FROM predl WHERE comments LIKE '%$ottitle2%' and `date` >= date_add( curdate() , INTERVAL -7 DAY )  ORDER BY RAND()  LIMIT 0,1";	
	$r=sql($q);
	if(sizeof($r)==0){
		$ottitle2=preg_replace("/%\w+?$/","",$ottitle2);
		$q="SELECT id, city, name, comments  FROM predl WHERE comments LIKE '%$ottitle2%' and `date` >= date_add( curdate() , INTERVAL -7 DAY )  ORDER BY RAND()  LIMIT 0,1";
		$r=sql($q);
	}
	if(sizeof($r)==0){
		$ottitle2=preg_replace("/%\w+?$/","",$ottitle2);
		$q="SELECT id, city, name, comments  FROM predl WHERE comments LIKE '%$ottitle2%' and `date` >= date_add( curdate() , INTERVAL -7 DAY )  ORDER BY RAND()  LIMIT 0,1";
		$r=sql($q);
	}
	foreach($r as $rr){
		list($id,$city,$name,$comments)=$rr;
		$comments=substr($comments,0,150);
		$comments=preg_replace("/ \w+?$/","",$comments)."...";
		//$ottitle=substr($comments,0,20);
		//$ottitle=preg_replace("/ \w+?$/","",$ottitle);
?>		
		<div class="specblock"><img src="/img/specblock_top.gif" width="239" height="6" /><div class="header">Предложение с доски объявлений от:<br /><i><?=$name?></i> по теме:</div>
			<div class="content">
			<table><tr><td>
				<h2><?=$ottitle?></h2>
				<?
				$ttt=str_replace("&amp;quot;",'',nl2br(htmlspecialchars(preg_replace("/(\r\n?)+/","\n",$comments)))); 
				$ttt=str_replace("&quot;",'',$ttt);
				?>
				<p style="width:200px;overflow:hidden"><?=$ttt?></p>
				
				<a href="http://www.ruscable.ru/board/msg-<?=$id?>.html">» <span>Подробнее</span></a>
				<br><br>
				<a href="http://www.ruscable.ru/board/search.html?what_string=comments&query=<?=$otitle?>&search_parts2=3"><span style='color: rgb(0, 121, 194);'>» Найти еще объявления по теме "<?=$ottitle?>"</span></a>
			</td></tr></table>	
			</div><img src="/img/specblock_bottom.gif" width="239" height="6" /></div>
		<br/>
<?		
	}

}




if($cat2 != ""){
	
	$ottitle=ssql("select title from market_cat where id=$cat2");	
	$ottitle2=str_replace(" ","%",$ottitle);
	$ottitle2=preg_replace("/(%.%)/","%",$ottitle2);
	$q="SELECT id, city, author, text  FROM obv_obv WHERE text LIKE '%$ottitle2%' and `data` >= date_add( curdate() , INTERVAL -7 DAY )  ORDER BY RAND()  LIMIT 0,1";	
	$r=sql($q);
	if(sizeof($r)==0){
		$ottitle2=preg_replace("/%\w+?$/","",$ottitle2);
		$q="SELECT id, city, author, text  FROM obv_obv WHERE text LIKE '%$ottitle2%' and `data` >= date_add( curdate() , INTERVAL -7 DAY )  ORDER BY RAND()  LIMIT 0,1";
		$r=sql($q);
	}
	if(sizeof($r)==0){
		$ottitle2=preg_replace("/%\w+?$/","",$ottitle2);
		$q="SELECT id, city, author, text  FROM obv_obv WHERE text LIKE '%$ottitle2%' and `data` >= date_add( curdate() , INTERVAL -7 DAY )  ORDER BY RAND()  LIMIT 0,1";
		$r=sql($q);
	}
	foreach($r as $rr){
		list($id,$city,$name,$comments)=$rr;
		$comments=substr($comments,0,150);
		$comments=preg_replace("/ \w+?$/","",$comments)."...";
		//$ottitle=substr($comments,0,20);
		//$ottitle=preg_replace("/ \w+?$/","",$ottitle);
?>		
		<div class="specblock"><img src="/img/specblock_top.gif" width="239" height="6" /><div class="header">Предложение с электротехнической доски объявлений от:<br /><i><?=$name?></i> по теме:</div>
			<div class="content">
			<table ><tr><td>
				<h2><?=$ottitle?></h2>
				
				<? 
					$ttt=str_replace("&amp;quot;",'',nl2br(htmlspecialchars(preg_replace("/(\r\n?)+/","\n",$comments)))); 
					$ttt=str_replace("&quot;",'',$ttt);
				?>
				<p style="width:200px;overflow:hidden"><?=$ttt?></p>
				
				<a href="http://www.ruscable.ru/board_el/msg-<?=$id?>.html">» <span>Подробнее</span></a>
				<br><br>
				<a href="http://www.ruscable.ru/board_el/search.html?what_string=text&query=<?=$otitle?>&search_parts2=3"><span style='color: rgb(0, 121, 194);'>» Найти еще объявления по теме "<?=$ottitle?>"</span></a>
			</td></tr></table>	
			</div><img src="/img/specblock_bottom.gif" width="239" height="6" /></div>
		<br/>
<?		
	}

}


/*

<noindex>
<script language='JavaScript' type='text/javascript'> 

<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://www.ruscable.ru/_ban_sys/ads/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:74");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//--></script><noscript><a href='http://www.ruscable.ru/_ban_sys/ads/adclick.php?n=a6b41b7c' target='_blank'><img src='http://www.ruscable.ru/_ban_sys/ads/adview.php?what=zone:74&amp;n=a6b41b7c' border='0' alt=''></a></noscript>

</noindex>

*/

?>


<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://ruscable.su/www/delivery/ajs.php':'http://ruscable.su/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=42");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://ruscable.su/www/delivery/ck.php?n=a0e8d290&amp;cb=534534' target='_blank'><img src='http://ruscable.su/www/delivery/avw.php?zoneid=42&amp;cb=534534&amp;n=a0e8d290' border='0' alt='' /></a></noscript>
