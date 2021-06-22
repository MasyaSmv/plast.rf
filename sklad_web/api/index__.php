<?
$perpage = 20;
$units=array(1=>"тн",2=>"м",3=>"км",4=>"бухта",5=>"шт",6=>"упак.",7=>"комплект",8=>"кг",9=>"т шт");
//$trueips=array("178.159.249.210","95.163.108.100","193.124.134.8","94.25.196.239");
$actions=array("get_goods_data","get_company_data", "get_city_list", "check_user_rights","get_text");
//$pass=base64_encode(sha1("tip#Top^3%2!1@".date("d.m.Y"), true));

if(
    $_SERVER['REQUEST_METHOD']!="POST"
  )
{
	header('HTTP/1.0 403 Forbidden');print "<h1>Forbidden</h1>";exit;
}

foreach($_POST as $a=>$b){
	$$a=trim($b);
	$str.="$a: $b\n";
}
$logfile = date("Y-m-d").".log";
$h=fopen("./logs/$logfile","a+");
fwrite($h,"Query:\n".$str."\n=====\n");
fclose($h);

//if($access_key != $pass){
//		header('HTTP/1.1 403 Forbidden'); print "<h1>Forbidden 403</h1>";exit;
//}


if(!function_exists('sql')){function sql($q){$res=array();$r=@mysql_query($q);if(@mysql_num_rows($r)>0){while($row=@mysql_fetch_row($r)){$res[]=$row;}}return $res;}}if(!function_exists('ssql')){function ssql($q){return mysql_result(mysql_query($q),0,0);}}
$str="";

if(!in_array($action,$actions)){
	$data=array("action" => "unknown", "code"=>10, "techMessage" => "unknown action");
	sendData($data);
	exit;
}

$conn=mysql_connect("192.168.0.2", "ruscableru", "7o4hcdv3ef");
mysql_select_db("ruscableru");
mysql_query("set names utf8");

$authorized = 0;
$end_date = "";
if($sklad_user && $sklad_hash){
	$sklad_user = mysql_real_escape_string(trim($sklad_user));
	if($sklad_user == "Гость"){
		// проверка по Apple ID
		$appleId = mysql_real_escape_string(trim($appleId));
		if($appleId != ""){
			$is_new = ssql("select count(*) from sklad_apple_ids where apple_id	= '$appleId'");
			if($is_new == 0){
				mysql_query("insert into sklad_apple_ids set apple_id = '$appleId', `date`=CURDATE()");
				$authorized = 100;
			}else{
				$is_dost = ssql("select count(*) from sklad_apple_ids where apple_id = '$appleId' and `date` >= date_add(curdate() , INTERVAL -14 DAY )");
				if($is_dost > 0){
					$authorized = 100;
				}
			}
		}
	}else{
		$passuser = ssql("select pass from users where login = '$sklad_user'");
		if($passuser){
			$check_hash = md5($passuser.$appleId);
			if($sklad_hash == $check_hash){
				// правильные логин и пароль, ничего не знаем про компанию
				$comp_id = ssql("select company_id from users where login = '$sklad_user'");
				if(!$comp_id){
					// юзер реальный, ему надо использовать режим гостя
				}else{
					$isplatn = ssql("select count(*) from company_usl_list where company_id=$comp_id and tarif_id=18 and date_begin <= CURDATE() and date_end >= CURDATE()");
					if($isplatn > 0){
						$authorized = 100;
						$end_date = ssql("select DATE_FORMAT(date_end, '%d.%m.%Y') from company_usl_list where company_id=$comp_id and tarif_id=18 and date_begin <= CURDATE() and date_end >= CURDATE()");
					}
				}
			}
		}
	}
}

if($action == "check_user_rights"){
	$data=array(
	"action" => "check_user_rights",
	"code" => 0
	);
	sendData($data);
	exit;
}
if($action == "get_goods_data"){
	$searchTerm = mysql_real_escape_string(trim($searchTerm));
	if($resultsFrom){
		$resultsFrom = intval($resultsFrom);
		$resultsFrom2 = $resultsFrom * 20;
	}else{
		$resultsFrom2 = $resultsFrom = 0;
	}
	if(!$sort || $sort < 0 || $sort > 3){
		$sort = 0;
	}
	if($cityFilter && $cityFilter != ""){
		$cityFilter = mysql_real_escape_string(trim($cityFilter));
	}

	if($sort == 0){
		$ordby=" s.title";
	}elseif($sort == 1){
		$ordby=" s.title desc";
	}elseif($sort == 2){
		//$ordby="cast(s.quant as DECIMAL) asc, s.title";
		$ordby="s.q2 asc, s.title";
	}elseif($sort == 3){
		//$ordby="cast(s.quant as DECIMAL) desc, s.title";
		$ordby="s.q2 desc, s.title";
	}

	$ruri = clearurl($searchTerm);
	$adq2=array();
	$mruris=explode(" ",$ruri);
	foreach($mruris as $mrur){
		if($mrur=="кабель" || $mrur=="Кабель" || $mrur=="Провод" || $mrur=="провод"){
			continue;
		}
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
			$res="title like '$mrur%' or title like '% $mrur%'";
			if($mrur2!=""){
				$res.=" or title like '%$mrur2%'";
			}
			if(mb_ereg("-",$mrur) && !mb_ereg("(A)",$mrur) && !mb_ereg("(А)",$mrur)){
				$mrur20=str_replace("-","(A)-",$mrur);
				$mrur21=str_replace("-","(А)-",$mrur);
				$res.=" or title like '%$mrur20%' or title like '%$mrur21%'";
			}
			//13.12.2019
			
			if(mb_ereg("(A)",$mrur)){ // лат А
				$mrur20=str_replace("(A)","",$mrur);
				$mrur21=str_replace("(A)","(А)",$mrur);
				$res.=" or title like '%$mrur20%' or title like '%$mrur21%' ";
			}
			if(mb_ereg("(А)",$mrur)){ // рус А
				$mrur20=str_replace("(А)","",$mrur);
				$mrur21=str_replace("(А)","(A)",$mrur);
				$res.=" or title like '%$mrur20%' or title like '%$mrur21%'";
			}
			$adq2[]="($res)";
		}
	}
	$adq=implode(" and ",$adq2);

	if($cityFilter == ""){
		$q = "select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from
		sklad_tovar s where visible=1 and $adq order by $ordby LIMIT $resultsFrom2, $perpage";
		$q2 = "select count(id) from sklad_tovar s where visible=1 and $adq";
	}else{
		$q = "select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from
		sklad_tovar s where city='$cityFilter' and s.visible=1 and $adq order by $ordby LIMIT $resultsFrom2, $perpage";
		$q2 = "select count(s.id) from sklad_tovar s where city='$cityFilter' and s.visible=1 and $adq";
	}

	$totalCount = ssql($q2);
	$r=sql($q);
	$szr=sizeof($r);
	if($szr==0){
		$data=array(
		"action" => "get_goods_data",
		"searchTerm" => $searchTerm,
		"resultsFrom" => $resultsFrom,
		"code"=>0,
		"resultsCount"=>$totalCount,
		"data"=>array()
		);
		sendData($data);
		exit;
	}

	$q1 = "select distinct s.comp_id, u.name, u.comp, u.city, u.company_id from sklad_tovar s, users u
where s.comp_id=u.id order by s.comp_id";

	$r1=sql($q1);
	foreach($r1 as $rr1){
		list($c_id, $cname, $ctitle, $ccity, $ucid)=$rr1;
		if($ctitle==""){$ctitle=$cname;}
		$company[$c_id]['title']=$ctitle;
		$company[$c_id]['ucid']=$c_id;
		$ccity!=""? $company[$c_id]['city']=$ccity : $company[$c_id]['city']="не указан";
	}
	$resdata = array();
	foreach($r as $rr){
		list($id, $comp_id, $title, $quant, $unit_id, $comments,$city)=$rr;
		$quant=str_replace(",",".",$quant);
		if(!is_float($quant)){
			settype($quant,"float");
		}
		$quant=round($quant,4);
		$quant=str_replace(".",",",$quant);

		if($authorized == 100){
			$datan = array(
			"name" => $title,
			"amount" => $quant,
			"amount_parts" => $comments,
			"unit" => $units[$unit_id],
			"city" => $city,
			"company_id" => $company[$comp_id]['ucid'],
			"company_name" => $company[$comp_id]["title"]
			);
		}else{
			$datan = array(
			"name" => $title,
			"amount" => $quant,
			"amount_parts" => $comments,
			"unit" => $units[$unit_id],
			"city" => $city,
			"company_id" => "",
			"company_name" => ""
			);
		}
		$resdata[]=$datan;

	}
	if($resultsFrom*20 + 20 > $totalCount){
		$last_page = 1;
	}else{
		$last_page = 0;
	}
	$data = array(
		"action" => "get_goods_data",
		"searchTerm" => $searchTerm,
		"resultsFrom" => $resultsFrom,
		"sort" => $sort,
		"cityFilter" => $cityFilter,
		"code" => 0,
		"resultsCount" => $totalCount,
		"lastPage" => $last_page,
		"data" => $resdata
		);
		sendData($data);
		exit;
}


if($action == "get_company_data"){
	$company_id=intval($company_id);
	// проверка, есть ли валидные пользователи у этой компании
	if($authorized != 100){
		$data=array(
		"action" => "get_company_data",
		"company_id" => $company_id,
		"code" => 30,
		"techMessage" => "Как гость, вы не можете просматривать названия и контактные данные поставщиков"
		);
		sendData($data);
		exit;
	}
	$q5="select `name`, `comp`, `email`, `tel`, `fax`, company_id, city from users where id=$company_id and activ=1 limit 0,1";

	$r=sql($q5);
	$szr=sizeof($r);

	if($szr == 0){
		$data=array(
		"action" => "get_company_data",
		"company_id" => $company_id,
		"code" => 20,
		"techMessage"=>"Не удалось получить данные о компании"
		);
		sendData($data);
		exit;
	}else{
		// проверка, есть ли товары
		foreach($r as $rr){
			list($name, $comp, $email, $tel, $fax, $comp_id, $city)=$rr;
		}
		$allpos=ssql("select count(*) from sklad_tovar where comp_id=$company_id");
		if($allpos == 0){
			$data=array(
			"action" => "get_company_data",
			"company_id" => $company_id,
			"code" => 20,
			"techMessage"=>"У компании нет позиций на Склад.RusCable.Ru"
			);
		sendData($data);
		exit;
		}

		$cities=array();
		$cities[]=$city;
		$q="select distinct city from sklad_tovar where comp_id=$id and city!='' order by city";
		$r1=sql($q);
		foreach($r1 as $rr1){
			list($tmp)=$rr1;
			$cities[]=$tmp;
		}
		$cities2=array_unique($cities);
		$citi=implode(", ",$cities2);
		$email=trim($email);
		if($comp_id > 0){
			$url=@ssql("select `url` from company where id=$comp_id limit 0,1");
			if($comp == ""){
				$comp=ssql("select concat(forma_sob, ' ', title) from company where id=$comp_id");
			}
			$p_addr = @ssql("select `p_addr` from company where id=$comp_id limit 0,1");
		}else{
			$p_addr = "";
		}

		$datan = array(
		 "company_id" => $company_id,
		"title" => $comp,
		"city" => $citi);

		if($p_addr != ""){
			$datan["address"] = $p_addr;
		}
		if($tel != ""){
			$datan["phone"] = $tel;
		}
		if($email != ""){
			$datan["email"] = $email;
		}

		if($url != "" && $url != "http://"){
			if(!preg_match("{^http://}",$url)){$url="http://".$url;}
			$datan["url"] = $url;
		}

		if($name != ""){
			$datan["contact"] = $name;
		}

		$datan["goods_count"] = $allpos;

		$lastobn=ssql("select DATE_FORMAT(max(date_cr), '%d.%m.%Y' ) from sklad_tovar where comp_id=$company_id limit 0,1");
		if($lastobn == "NULL"){
			$datan["last_update"] = "";
		}else{
			$datan["last_update"] = $lastobn;
		}
		//if($comp!=""){
			$data=array(
			"action" => "get_company_data",
			"code" => 0,
			"data" => $datan
			);
			sendData($data);
			exit;
		//}else{
		//	$data=array(
		//	"action" => "get_company_data",
		//	"company_id" => $company_id,
		//	"code" => 20,
		//	"techMessage"=>"can't get company data"
		//	);
		//	sendData($data);
		//	exit;
		//}
	}
}

if($action == "get_city_list"){
	$q = "select distinct city from sklad_tovar where city != '' order by city";
	$r = sql($q);
	$city = array();
	foreach($r as $rr){
		list($ci) = $rr;
		$city[] = $ci;
	}
	//$city = array("Ангарск","Архангельск","Астана","Волгоград","Воскресенск");
	if(sizeof($city) > 0){
		$data=array(
		"action" => "get_city_list",
		"code" => 0,
		"data" => $city
		);
	}else{
		$data=array(
		"action" => "get_city_list",
		"code" => 20,
		"techMessage"=>"can't get city list"
		);
	}
	sendData($data);
	exit;
}

if($action == "get_text"){
	$html = ssql("select html from mobile_advertising where visible=1 order by id desc limit 0,1");
	$url = ssql("select url from mobile_advertising where visible=1 order by id desc limit 0,1");
	$data=array(
	"action" => "get_text",
	"code" => 0,
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#e26009;'><center><img src='http://ruscable.su/www/images/29c9f5b18843ed6c873af0712d5517bf.gif' style='padding:0px;margin:0px;height:70px;border:0px;'></center></div>"
	//"data" => "ООО Инженерно-промышленная группа Смол. Производство станков для перемотки кабельно-проводниковой продукции. Телефон: +7(812)648-13-99 E-mail: peremotka@inbox.ru"
	//"data" => "<script>document.location.href='http://ya.ru'</script>"
	//"data" => "<script>document.write('some text')</script>"
	//"data" => "<a target='_blank' href='http://ya.ru'>link</a>"
	//"data" => "<html><head></head><body><p style='font-family: 'Lucida Grande';font-weight: 400;'><i style='color:rgb(212,80,64)'>03.12.КОНФЕРЕНЦИЯ:Импортозамещение в кабельной промышленности. Подробнее: +7 495 2293336</i></p></body></html>"
	//"data" => ""
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://www.ruscable.ru/i/15years.jpg' style='width:100%;padding:0px;margin:0px;border:0px;'></center></div>"
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://www.ruscable.ru/i/15years-2.jpg' style='padding:0px;margin:0px;height:70px;border:0px;'></center></div>"
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://ruscable.su/www/images/c7ca852a2bb00820c1335f0eceb91de4.jpg' style='padding:0px;margin:0px;border:0px;'></center></div>"
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://www.ruscable.ru/i/kabelsnab_bnr12_600x70_1.5.jpg' style='width:100%;padding:0px;margin:0px;border:0px;'></center></div>"
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://www.ruscable.ru/i/ostec_bnr12_600x70_1.1.1.jpg' style='width:100%;padding:0px;margin:0px;border:0px;'></center></div>"
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://ruscable.su/www/images/c0b593d80ce91a2ed10dfa61973ee7d5.jpg' style='width:100%;padding:0px;margin:0px;border:0px;'></center></div>"
	//"data" => "<div style='padding:0px;margin:-8px;background-color:#ffffff;'><center><img src='http://ruscable.ru/banners/uncomtech_bnr3_600x70_1.1.jpg' style='width:100%;padding:0px;margin:0px;border:0px;'></center></div>"
	"data" => $html,
	"data_url" => $url
	);
	sendData($data);
	exit;
}

function sendData($data){
	global $q, $q2, $authorized, $end_date, $logfile;
	$data["performedDatetime"] = gmdate("Y-m-d\TH:i:s\Z");
	if($authorized == 100){
		$data["authStatus"] = "0";
		$data["accessDateEnd"] = $end_date;
	}else{
		$data["authStatus"] = "10";
	}
	//$data["qqq"] = $q;
	$res=json_encode($data);
	//header('HTTP/1.0 200 OK');
	header('Content-type: text/json');
	print "{\n\"responce\":".$res."\n}";

	$h=fopen("./logs/$logfile","a+");
	fwrite($h,"Response:\n".$res."\n=====\n");
	fwrite($h,"\n$q\nq2: $q2\n auth: $authorized \n=====\n");
	fclose($h);
}


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
