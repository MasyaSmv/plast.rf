<?
mb_internal_encoding("UTF-8");
//setlocale(LC_ALL, 'ru_RU.CP1251');
include_once("inc/func.inc");

$navpage="info";
$text1="";
$txt="";
$company=array();
$cities=array();
$page_dir="";
$dopurl="";

$out2="";
$uri=$_SERVER['REQUEST_URI'];
$uri=str_replace("/company/","",$uri);
$uris=explode("/",$uri);
$comp=$uris[0];
preg_match("/-(\d+)$/",$comp,$tmp);
$comp_id=intval($tmp[1]);
if(sizeof($uris)>1){
	$text=$uris[1];
}else{
	$text="";
}


$ruri=strip_tags($_GET['uri']);
if(mb_detect_encoding($ruri,"UTF-8, CP1251, ASCII")!="UTF-8"){
	//$ruri=iconv("CP1251","UTF-8",$ruri);
	$ruri=mb_convert_encoding($ruri,"UTF-8");
}

if( sizeof($uris)==2 && preg_match("{/page([0-9]+)/?$}",$uris[2],$pp)){
	$page=$pp[1];
}else{
	$page=1;
}

if($text==""){
	//весь склад компании
	$title_tag="Кабель  и провод из наличия  - СКЛАД :: О сервисе";
	include("./index.text.php");
}else{
	
	//поиск по ruri
	$ruri=clearurl($ruri);
	$title_tag="Кабель  и провод из наличия  - СКЛАД :: $ruri";
	if($page > 1){
		$title_tag.=" :: Страница $page";
	}
	$mruri=mysql_real_escape_string($ruri);
	$adq2=array();
	$mruris=explode(" ",$mruri);
	foreach($mruris as $mrur){	
		if(mb_ereg("х",$mrur)){
			$mrur2=mb_ereg_replace("х","x",$mrur);
		}else{
			$mrur2="";
		}
		if(mb_ereg("\.",$mrur)){
			$mruri2=mb_ereg_replace("\.",",",$mrur);
			if($mrur2!=""){
				$mruri3=mb_ereg_replace("х","x",$mrur);
			}else{
				$mruri3="";
			}
			$res="title like '%$mrur%' or title like '%$mruri2%'";
			if($mrur2!=""){
				$res.=" or title like '%$mrur2%'";
			}
			if($mruri3!=""){
				$res.=" or title like '%$mruri3%'";
			}
			$adq2[]="($res)";
		}elseif(mb_ereg(",",$mrur)){
			$mruri2=mb_ereg_replace(",",".",$mrur);
			if($mrur2!=""){
				$mruri3=mb_ereg_replace("х","x",$mrur);
			}else{
				$mruri3="";
			}
				
			$res="title like '%$mrur%' or title like '%$mruri2%'";
			if($mrur2!=""){
				$res.=" or title like '%$mrur2%'";
			}
			if($mruri3!=""){
				$res.=" or title like '%$mruri3%'";
			}
			$adq2[]="($res)";
		}else{
			$res="title like '%$mrur%'";
			if($mrur2!=""){
				$res.=" or title like '%$mrur2%'";
			}	
			$adq2[]="($res)";
		}
	}
	$adq=implode(" and ",$adq2);
	
	
	
	if($curcity==""){
		$q="select count(id) from sklad_tovar where visible=1 and $adq";
	}else{
		$q="select count(s.id) from sklad_tovar s where city='$curcity' and s.visible=1 and $adq";	
	}	
	$count = ssql($q);
	//$count = ssql("select count(id) from sklad_tovar where visible=1 and title like '%$mruri%'");
	$pages_count = ceil($count / $perpage);
	if ($page > $pages_count) $page = $pages_count; 
	$start_pos = (($page - 1) * $perpage);
	if($start_pos<0){$start_pos=0;}	
	
	if($mruri!=""){
			$qq="insert into sklad_query_stat set `query`='$mruri',`time`=NOW(),results=$count";
			mysql_query($qq);
	}
	if(!$_SESSION['setsort'] || $_SESSION['setsort']=="default"){
		$ordby=" s.title";
	}elseif($_SESSION['setsort']=="kolasc"){
		$ordby="quant desc, s.title";	
	}elseif($_SESSION['setsort']=="koldesc"){
		$ordby="s.quant";	
	}
	if($curcity==""){
		$q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_tovar s where visible=1 and $adq order by $ordby LIMIT $start_pos, $perpage";
		
	}else{
		$q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_tovar s where city='$curcity' and s.visible=1 and $adq order by $ordby LIMIT $start_pos, $perpage";
	}	
	//if($_SERVER['REMOTE_ADDR']=="94.25.229.3"){
	//	echo "$q";
	//}
	$r=sql($q);
	$szr=sizeof($r);

	if($szr==0){
		$out="По вашему запросу ничего не найдено, проверьте правильность указания марки. Примеры запросов: «ВВГнг 4х95 - 1кВ», «КВБбШв 7х2,5», «3х50», «ААШв» и т.п.";
		if($curcity!=""){
			$out.="<p><b>Вы ищете кабель только в городе $curcity.<br>Попробуйте поискать его <a href=/setcityall>по всем городам</a></b></p>";
		}

		// добавляем рекламу ОСЗ
		$out.='<div style="margin: 30px 0; color: #fe5a24; padding: 5px 0; font-size: 16px;"><strong>Не нашел кабель?</strong> <a href="http://www.ruscable.ru/board/add.html" target="_blank">Размести объявление.</a></div>';

	}else{

		// AV: 2012-11-19: Добавляем баннер-растяжку
		$out2 = <<<BANNER_RAST
		<div id='rast1' style='border: 0px solid black; margin: 16px 0; text-align: center;'>
		<script type='text/javascript'><!--//<![CDATA[
		   var m3_u = (location.protocol=='https:'?'https://ruscable.su/www/delivery/ajs.php':'http://ruscable.su/www/delivery/ajs.php');
		   var m3_r = Math.floor(Math.random()*99999999999);
		   if (!document.MAX_used) document.MAX_used = ',';
		   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
		   document.write ("?zoneid=115");
		   document.write ('&amp;cb=' + m3_r);
		   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
		   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
		   document.write ("&amp;loc=" + escape(window.location));
		   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
		   if (document.context) document.write ("&context=" + escape(document.context));
		   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
		   document.write ("'><\/scr"+"ipt>");
		//]]>--></script><noscript><a href='http://ruscable.su/www/delivery/ck.php?n=a3d4f226&amp;cb=643543549687468465' target='_blank'><img src='http://ruscable.su/www/delivery/avw.php?zoneid=115&amp;cb=643543549687468465&amp;n=a3d4f226' border='0' alt='' /></a></noscript>
		</div>
BANNER_RAST;

		$out ="<table width=100%><tr><td>Найдено: $count ".okonch($count,"товар")." на $pages_count ".  okonch($pages_count,"страница")."</td></tr></table>";
		//$out="<table width=100%><tr><td>Найдено: $count</td></tr></table>";

		if($authorized==0 || ($authorized===1 && $free_searches ===0) ){
			$out.="<table class='wrap3' width='100%'><tr><td valign=top >";

		}else{
			if($authorized===1){
				if($page==1){
					if($action11==0){
						@mysql_query("insert into sklad_free_access set c_id=$sklad_cid, vremya=NOW()");
					}
				}
			}
			//$out="";
			//выбрать тут сразу названия и урл компаний, чтобы не лазить за ними в базу на каждую строчку
			$q1="select distinct s.comp_id, u.name, u.comp, u.city from sklad_tovar s, users u where s.comp_id=u.id order by s.comp_id";
			$r1=sql($q1);
			foreach($r1 as $rr1){
				list($c_id,$cname,$ctitle,$ccity)=$rr1;
				if($ctitle==""){$ctitle=$cname;}
				$company[$c_id]['title']=$ctitle;
				$sef=rus2lat($ctitle);
				$sef=preg_replace("/\s+/","-",$sef);
				//$sef=str_replace(" ","-",$sef);
				$sef=preg_replace("/[^a-zA-Z0-9-]/","",$sef);
				$sef=strtolower($sef);
				$sef.="-".$c_id;
				$company[$c_id]['sef']=$sef;
				$ccity!=""? $company[$c_id]['city']=$ccity : $company[$c_id]['city']="не указан";
			}
		}
		if(!$_SESSION['setsort'] || $_SESSION['setsort']=="default"){
			$akol="<a href=/setsortkolasc>Количество</a>";
			$anam="Наименование";
		}elseif($_SESSION['setsort']=="kolasc"){
			$akol="<a href=/setsortkoldesc>Количество</a>";
			$anam="<a href=/setsortdefault>Наименование</a>";
		}elseif($_SESSION['setsort']=="koldesc"){
			$akol="<a href=/setsortkolasc>Количество</a>";
			$anam="<a href=/setsortdefault>Наименование</a>";
		}
		$out.=<<< OUT1
		<div class="item"><table width="100%" ><tr><td width="40%" style="border-bottom: 1px solid #929292;"><div class="sorting_bar"><span >$anam</span></div></td><td style="border-bottom: 1px solid #929292;"><div class="sorting_bar"><span style='display:inline;'>$akol</span></div></td>
			<td style="border-bottom: 1px solid #929292;"><div class="sorting_bar">Ед. изм.</div></td>
			<td style="border-bottom: 1px solid #929292;"><div class="sorting_bar">###CITYTEXT###</div></td>
OUT1;
		if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
			$_SESSION['sk_last_success_query']=$ruri;
			$out.=<<<OUT2
			<td style="border-bottom: 1px solid #929292;"><div class="sorting_bar" >Поставщик</div></td>
OUT2;
			$cols=5;
		}else{
			$cols=4;
		}
		$out.="</tr><tr><td colspan='$cols' height='20'></td></tr>";
		$z=0;
		foreach($r as $rr){
			list($id, $comp_id, $title, $quant, $unit_id, $comments,$city)=$rr;
		
			$quant=str_replace(",",".",$quant);
			if(!is_float($quant)){
				settype($quant,"float");
			}
				
			$quant=round($quant,4);
			$quant=str_replace(".",",",$quant);
			if($comments!=""){
				$quant="<a class=comments href='javascript:void(0);' title='<p>$comments</p>'>$quant</a>";
			}
			if($z==0){
				//$ad1='style="border-bottom: 1px solid #929292;"';
				$ad1='style="background: #eeeeee;"';
				//$ad1="";
				$z=1;
			}else{
				$ad1="";
				$z=0;
			}
			$out.="<tr class=tbltr><td $ad1>$title</td><td $ad1>$quant</td><td $ad1>".$units[$unit_id]."</td><td $ad1>";
			if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
				
				$out.=$city."</td><td $ad1><a href='/spisok/".$company[$comp_id]["sef"]."'>".$company[$comp_id]["title"]."</td>";
			}else{
				$out.="недоступно</td>";
			}
			$out.="</tr>";
			
			
		}		
		$out.="</table>";
		if ($pages_count >1){
			$out.= '<br><br><div class="pagination">';
			$out.=show_links($page,$perpage,$count,"/".$ruri."/",$dopurl);
			
			$out.='</div>'; 
		}

		// добавляем рекламу ОСЗ
		$out.='<div style="border-top: #fe5a24 2px solid; margin: 30px 0; color: #fe5a24; background-color: #eaf6fe; padding: 5px 2px; font-size: 12px;"><strong>Не нашел кабель?</strong> <a href="http://www.ruscable.ru/board/add.html" target="_blank">Размести объявление.</a></div>';

		if($authorized==0 || ($authorized===1 && $free_searches ===0)){
			$out.=<<<OUT3
			
			</td><td valign=top width="480px"><div class=nologin>




<div id="rounded-box-3">
    <b class="r3"></b><b class="r1"></b><b class="r1"></b>
    <div class="inner-box">       
        <p>Просмотр данных о поставщиках доступен только зарегистрированным пользователям.</p>
        <p>Пожалуйста пройдите <a href='http://www.ruscable.ru/users/registr.html'>бесплатную регистрацию</a> (это займет не больше минуты) или войдите в систему, используя свои логин и пароль.</p>
        <p>Базовый тариф, доступный любому зарегистрированному пользователю, <b>УКАЗАВШЕМУ ДАННЫЕ О КОМПАНИИ В ЛИЧНОМ КАБИНЕТЕ</b>,  даёт возможность использовать $max_free_searches поисков в месяц бесплатно. Хотите искать больше – неограниченный доступ всего за 899р. в месяц без НДС.</p>
    </div>
    <b class="r1"></b><b class="r1"></b><b class="r3"></b>
</div>
<p>	
 <script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://ruscable.su/www/delivery/ajs.php':'http://ruscable.su/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=105");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://ruscable.su/www/delivery/ck.php?n=a1eee711&amp;cb=123' target='_blank'><img src='http://ruscable.su/www/delivery/avw.php?zoneid=105&amp;cb=123&amp;n=a1eee711' border='0' alt='' /></a></noscript>
		
</p>		</div></td></tr></table>
OUT3;

		}

	}
	if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
		//$qq="SELECT u.city FROM sklad_tovar s, users u WHERE s.comp_id = u.id AND s.visible =1 and $adq GROUP BY u.city ORDER BY u.city";
		$qq="SELECT distinct city FROM sklad_tovar WHERE visible =1 and city!='' and $adq ORDER BY city";
		$r=sql($qq);
		foreach($r as $rr){
			list($cit)=$rr;
			if($cit!=""){
				$cities[]=$cit;
			}
		}
		$cities2=array_unique($cities);
		$ct="<a href='/setcityall'>Все&nbsp;города</a><br><br>";
		foreach($cities2 as $city){
			if($city!="не указан"){
				$ct.="<a href='/setcity$city'>$city</a><br>";
			}	
		}
		$citytext='Город <b id="city" title="<p>'.$ct.'</p>">выбрать</b>';	
	}else{
		$citytext="Город";
	}
	$out=str_replace("###CITYTEXT###",$citytext,$out);
	
	
	if($authorized===1){
		$hassearch=ssql("select count(*) from sklad_free_access where c_id=$sklad_cid and vremya >='$start_date'");
		if($hassearch < $max_free_searches){
			$authorized=1;
			$free_searches=$max_free_searches-$hassearch;
		}else{
			$authorized=1;
			$free_searches=0;
		}	
	}
}

include_once("inc/header.inc");
?>

<?=$out2?>

<table width="100%">
<tr>
	<td width="75%" valign=top>

		<?=$out?>

	</td>
</tr>
</table>
<?
include_once("inc/footer.inc");


function clearurl($a){
	mb_regex_encoding("UTF-8");
	$title=preg_replace("{/$}","",$a);
	$title=mb_ereg_replace(" \* ","х",$title);
	$title=mb_ereg_replace("\*","х",$title);
	$title=mb_ereg_replace(" x ","х",$title);
	$title=mb_ereg_replace("x","х",$title);
	$title=mb_ereg_replace(" X ","х",$title);
	$title=mb_ereg_replace("X","х",$title);
	$title=mb_ereg_replace(" Х ","х",$title);
	$title=mb_ereg_replace("Х","х",$title);
//	$title=mb_ereg_replace("\.",",",$title);
	$title=mb_ereg_replace("\s+"," ",$title);
//	echo "-- $title --";
	return $title;
}
?>
