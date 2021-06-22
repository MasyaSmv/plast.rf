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
db_connect();



if(isset($_GET['stext'])){
	$stext=trim($_GET['stext']);	
	if(mb_detect_encoding($stext,"UTF-8, CP1251, ASCII")!="UTF-8"){
		//$stext2=iconv("CP1251","UTF-8",$stext);
		$stext2=mb_convert_encoding($stext2,"UTF-8");
		$stext=$stext2;
	}
	$stext=clearurl($stext);
	$stext=urlencode($stext);
	$to="http://".$_SERVER['HTTP_HOST']."/$stext";
	header("Content-type: text/html; charset=utf-8", TRUE);	
	header("Vary: Accept-Encoding,Cookie");	
	header("Location: $to",TRUE,301);
	exit;
}


$ruri=strip_tags($_GET['uri']);
if(mb_detect_encoding($ruri,"UTF-8, CP1251, ASCII")!="UTF-8"){
	//$ruri=iconv("CP1251","UTF-8",$ruri);
	$ruri=mb_convert_encoding($ruri,"UTF-8");
}

if(preg_match("{/page([0-9]+)/?$}",$ruri,$pp)){
	$page=$pp[1];
	$ruri=preg_replace("{/page([0-9]+)/?$}","",$ruri);	
}else{
	$page=1;
}

if($ruri==="/" || $ruri===""){
	//главная страница
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
		if(mb_ereg("\.",$mrur)){
			$mruri2=mb_ereg_replace("\.",",",$mrur);
			$adq2[]="(title like '%$mrur%' or title like '%$mruri2%')";
		}elseif(mb_ereg(",",$mrur)){
			$mruri2=mb_ereg_replace(",",".",$mrur);
			$adq2[]="(title like '%$mrur%' or title like '%$mruri2%')";
		}else{
			$adq2[]="(title like '%$mrur%')";
		}
	}
	$adq=implode(" and ",$adq2);
	
	
	
	if($curcity==""){
		$q="select count(id) from sklad_tovar where visible=1 and $adq";
	}else{
		$q="select count(s.id) from sklad_tovar s,users u where s.comp_id=u.id and u.city='$curcity' and s.visible=1 and $adq";	
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
	if($curcity==""){
		$q="select id, comp_id, title, quant, unit_id, comments from sklad_tovar where visible=1 and $adq order by date_cr desc,title LIMIT $start_pos, $perpage";
	}else{
		$q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments from sklad_tovar s,users u where s.comp_id=u.id and u.city='$curcity' and s.visible=1 and $adq order by s.date_cr desc,s.title LIMIT $start_pos, $perpage";
	}	
	//echo "<!-- $q -->";
	$r=sql($q);
	$szr=sizeof($r);

	if($szr==0){
		$out="По вашему запросу ничего не найдено, проверьте правильность указания марки. Примеры запросов: «ВВГнг 4х95 - 1кВ», «КВБбШв 7х2,5», «3х50», «ААШв» и т.п.";
		if($curcity!=""){
			$out.="<p><b>Вы ищете кабель только в городе $curcity.<br>Попробуйте поискать его <a href=/setcityall>по всем городам</a></b></p>";
		}

	}else{
		
		$out="<table width=100%><tr><td>Найдено: $count ".okonch($count,"товар")." на $pages_count ".  okonch($pages_count,"страница")."</td></tr></table>";
		//$out="<table width=100%><tr><td>Найдено: $count</td></tr></table>";

		if($authorized==0 || ($authorized===1 && $free_searches ===0) ){
			$out.="<table class='wrap3'><tr><td valign=top width=60%>";

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
		$out.=<<< OUT1
		<div class="item"><table width="100%" ><tr><td width="40%" style="border-bottom: 1px solid #929292;"><div class="sorting_bar"><span>Наименование</span></div></td><td style="border-bottom: 1px solid #929292;"><div class="sorting_bar">Количество</div></td>
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
			list($id, $comp_id, $title, $quant, $unit_id, $comments)=$rr;
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
				
				$out.=$company[$comp_id]["city"]."</td><td $ad1><a href='/spisok/".$company[$comp_id]["sef"]."'>".$company[$comp_id]["title"]."</td>";
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
		if($authorized==0 || ($authorized===1 && $free_searches ===0)){
			$out.=<<<OUT3
			
			</td><td valign=top width=40%><div class=nologin>




<div id="rounded-box-3">
    <b class="r3"></b><b class="r1"></b><b class="r1"></b>
    <div class="inner-box">       
        <p>Просмотр данных о поставщиках доступен только зарегистрированным пользователям.</p>
        <p>Пожалуйста пройдите <a href='http://www.ruscable.ru/users/registr.html'>бесплатную регистрацию</a> (это займет не больше минуты) или войдите в систему, используя свои логин и пароль.</p>
        <p>Базовый тариф, доступный любому зарегистрированному пользователю, <b>УКАЗАВШЕМУ ДАННЫЕ О КОМПАНИИ В ЛИЧНОМ КАБИНЕТЕ</b>,  даёт возможность использовать $max_free_searches поисков в месяц бесплатно. Хотите искать больше – неограниченный доступ всего за 899р. в месяц без НДС.</p>
    </div>
    <b class="r1"></b><b class="r1"></b><b class="r3"></b>
</div>
			
		</div></td></tr></table>
OUT3;

		}
		
	}
	if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
		$qq="SELECT u.city FROM sklad_tovar s, users u WHERE s.comp_id = u.id AND s.visible =1 and $adq GROUP BY u.city ORDER BY u.city";
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

include_once("inc/header.qstat.inc");


?>



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
