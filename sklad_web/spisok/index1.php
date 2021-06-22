<?
//setlocale(LC_ALL, 'ru_RU.CP1251');
include_once("../inc/func.inc");
$title_tag="Sklad.RusCable.Ru :: Список складов";
$perpage=25;
$navpage="comp";
$text1="";
$txt="";
$company=array();
$page_dir="";
$dopurl="";
$gor=array();
$out="";
$ruri="";

if($authorized==0){header("Location: /");exit;}

$rurit=strip_tags(urldecode($_SERVER['REQUEST_URI']));
	if(mb_detect_encoding($rurit,"UTF-8, CP1251, ASCII")!="UTF-8"){
	$rurit=iconv("CP1251","UTF-8",$rurit);
}
$rurit=trim(str_replace("/spisok/","",$rurit));

if($rurit==="/" || $rurit===""){
header("Location: /");
exit;
/*	
	//список всех городов
	$q="select id,`name` from geo_gor order by id";
	$r=sql($q);
	foreach($r as $rr){
		list($gid,$gname)=$rr;
		$gor[$gid]=$gname;
	}
	//главная страница, выводим список компаний.
	$out.=<<<OUT0
<div class="item"><table><tr><td colspan=2 width="100%" style="border-bottom: 1px solid #929292;"><div class="sorting_bar"><h1>Список складов в системе</h1></div></td></tr><tr><td height='20' colspan=2></td></tr>
OUT0;

	$q1="select distinct s.comp_id, c.forma_sob, c.title, c.seo_title, c.city_id from sklad_tovar s, company c where s.comp_id=c.id order by c.title";
			$r1=sql($q1);
			$ccc=1;
			foreach($r1 as $rr1){
				list($c_id,$fs,$ctitle,$sef,$cityid)=$rr1;
				if($fs!=""){$ctitle="$fs $ctitle";}
				if($cityid!=0 && array_key_exists($cityid,$gor)){
					$city=", ".$gor[$cityid];
				}else{
					$city="";
				}
				//$company[$c_id]['title']=$ctitle;
				//$company[$c_id]['sef']=$sef;


				$out.="
				<tr><td>$ccc &nbsp;</td><td><a href='/spisok/$sef'>$ctitle$city</a></td></tr>
				<tr><td height='20' colspan=2></td></tr>";
				$ccc++;
			}
		$out.="</table></div>";	
	//$out="Здесь находится описание, плюсы продукта, краткая справка по работе";
*/	
}else{
	//поиск и показ одного пользователя
	$mruri=mysql_real_escape_string($rurit);
	preg_match("/(.*)-(\d+)/",$mruri,$mt);
	$name=$mt[1];
	$id=$mt[2];
	$q="select `name`, `comp`, `email`, `tel`, `fax`, company_id, city from users where id=$id and activ=1 limit 0,1";

	//$q="select id, forma_sob, title, eng_title, seo_title, p_addr, phone, fax, email, url, map_id, icq,dop_contacts
 //from company where visible=1 and seo_title = '$mruri'  order by id limit 0,1";
	//echo $q;
	$r=sql($q);
	$szr=sizeof($r); 

	if($szr==0){
		$out="Склада с таким названием в списке нет.<br><a href=/>Перейти на главную страницу</a>";
	}else{
		foreach($r as $rr){
			list($name, $comp, $email, $tel, $fax, $company_id, $city)=$rr;
			if($company_id!=""){
				$url=@ssql("select `url` from company where id=$company_id limit 0,1");				
			}
			if($_SESSION['sk_last_success_query']!=""){
				$out.= "<h1 class=lss>Вы искали: <a href='/".$_SESSION['sk_last_success_query']."'>".$_SESSION['sk_last_success_query']."</a></h1>";
			}
			$out.="<table class='tblbord' width=500>";
			if($comp!=""){
				$out.="<tr class=tblth><td colspan=2 valign=middle style='text-align:center;'><b>$comp</b></td></tr>";
			}
			if($city!=""){
				$out.="<tr><td width=50%><b>Город:</b></td><td>$city</td></tr>";
			}
			if($name!=""){
				$out.="<tr><td width=50%><b>Контактное лицо:</b></td><td>$name</td></tr>";
			}
			if($tel!=""){			
				$out.="<tr><td><b>Телефон:</b></td><td>".$tel."</td></tr>";
			}
			if($fax!=""){		
					$out.="<tr><td><b>Факс:</b></td><td>".$fax."</td></tr>";
			}
			if($email!=""){
				$out.="<tr><td><b>E-mail:</b></td><td>";
				if(isset($_SESSION['panel_user_id'])){
					$out.= '<a href="mailto:'.$email.'">'.$email.'</a>';
				}else{
					$out.= '<img src="/image-e.php?id='.$id.'" border=0>';
				}	
				$out.= "</td></tr>";
			}	
			if($url!="" && $url!="http://"){
				if(!preg_match("{^http://}",$url)){$url="http://".$url;}
				$out.="<tr><td><b>Сайт:</b></td><td><noindex><a target=_new href='$url'>".$url."</a></noindex></td></tr>";
			}
			$lastobn=ssql("select DATE_FORMAT(max(date_cr), '%d.%m.%Y' ) from sklad_tovar where comp_id=$id limit 0,1");
			$out.="<tr><td><b>Склад обновлялся:</b></td><td>$lastobn г.</td></tr>";
			$out.="</table>";
			
			
			
			$out.="<table class='tblbord' width=500><tr><td><p>Уважаемый коллега, при контакте с потенциальным поставщиком просим Вас указывать, что <b>информация о наличии кабеля найдена Вами на сайте РусКабель.Ру</b></p><p>

В случае, если информация о наличии КПП не подтвердится, то Вы можете воспользоваться специальной формой «<a href='/abuse/'>Жалоба на поставщика</a>». Мы стремимся к тому, чтобы сервис SKLAD.RusCable.Ru. был актуальным и полезным для всех участников кабельного рынка. Спасибо за участие!</p></td></tr></table>";
			
			
			
			
			
		}
	}
}

include_once("../inc/header.inc");


?>



<table width="100%">
<tr>
	<td width="75%" valign=top>
	
		<?=$out?>
		

	</td>
	
</tr>
</table>
<?
include_once("../inc/footer.inc");
?>
