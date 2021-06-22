<?
ini_set("session.cookie_domain", ".ruscable.ru");
session_start();
if(!function_exists('ssql')){function ssql($q){return mysql_result(mysql_query($q),0,0);}}
if( isset($_SESSION['session_ip']) && $_SESSION['session_ip']!= "" && $_SESSION['session_ip'] != $_SERVER['REMOTE_ADDR']){
	@session_destroy();
	header("Location: /");
	exit;
}
if(isset($_COOKIE['rusc_id'])){
	$preauth=explode("$",$_COOKIE['rusc_id']);
	if(ctype_digit($preauth[0]) && ctype_alnum($preauth[1])){
		if(mysql_connect("192.168.0.1","ruscableru","7o4hcdv3ef") && mysql_select_db("ruscableru") && mysql_query("set names utf8")){
//		if(mysql_connect("localhost","ruscableru","7o4hcdv3ef") && mysql_select_db("ruscableru") && mysql_query("set names utf8")){

			$isu=ssql("select count(*) from users where id=".$preauth[0]." limit 0,1");
			if($isu==1){
				$p=ssql("select pass from users where id=".$preauth[0]." limit 0,1");
				if($preauth[1]===md5($p.$preauth[0])){
					$result=@mysql_query("SELECT * FROM users WHERE id=".$preauth[0]." limit 0,1");
					$user=@mysql_fetch_assoc($result);
					$_SESSION['login']=$user['login'];
					$_SESSION['s_name']=$user['name'];
					$_SESSION['panel_user_id']=$user['id'];
					$_SESSION['sklad_uid']=$user['id'];
					if($user['company_id'] > 0){
						$_SESSION['c_name']=ssql("select title from company where id=".$user['company_id']." limit 0,1");
						$_SESSION['company_id']=$user['company_id'];
						$_SESSION['market_cid']=$_SESSION['company_id'];
					}
					mysql_close();
				}
			}
		}
	}
}else{
	if(isset($_SESSION['s_name'])){
		if(mb_detect_encoding($_SESSION['s_name'],"UTF-8, CP1251, ASCII")!="UTF-8"){
			$_SESSION['s_name']=iconv("CP1251","UTF-8", $_SESSION['s_name']);
		}
	}
}

if($_SERVER['HTTP_HOST']=="sklad.ruscable.ru"){
	//if(preg_match("/sklad\-m\.ruscable\.ru/",$_SERVER['HTTP_REFERER'])){
	if($_GET['src'] == "mobile"){
//		@setcookie("skladnomobile","1",time()+1209600,"/",".ruscable.ru");
		@setcookie("skladnomobile","1",time()+3600,"/",".ruscable.ru");
		header("Location: https://sklad.ruscable.ru");
		exit;
	}elseif(preg_match("/android|midp|j2me|symbian|series\ 60|symbos|windows\ mobile|windows\ ce|ppc|smartphone|blackberry|mtk|windows\ phone|iPod|iPad|iPhone|Opera\ Mini|SonyEricsson/i",$_SERVER['HTTP_USER_AGENT']) && $_COOKIE['skladnomobile']!="1" && $_GET['frominf']!="1" && !isset($_COOKIE['informer']) && !strstr($_SERVER['REQUEST_URI'],"informer")){
		header("Location: http://sklad-m.ruscable.ru".$_SERVER['REQUEST_URI']);
		exit;
	}
}

//unset($_SESSION['informer_comp_name']);
//unset($_SESSION['informer_comp_id']);
// && !isset($_SESSION['informer_comp_name']) && !isset($_SESSION['informer_comp_id'])){
if(isset($_COOKIE['informer'])){
	mysql_connect("192.168.0.1","ruscableru","7o4hcdv3ef");
	//mysql_connect("localhost","ruscableru","7o4hcdv3ef");
	mysql_select_db("ruscableru");
	mysql_query("set names utf8");
	preg_match("/(.*)-(\d+)/",$_COOKIE['informer'],$mt);
	$id=$_SESSION['informer_comp_id']=intval($mt[2]);
	$comp_id=ssql("select company_id from users where id=$id");
	if($comp_id > 0){
		$comp_name=ssql("select concat(forma_sob, ' ', title) from company where id=$comp_id");
	}else{
		$comp_name=ssql("select comp from users where id=$id");
		if($comp_name==""){
			$comp_name=ssql("select name from users where id=$id");
		}
	}
	$_SESSION['informer_comp_name']=$comp_name;
}

$ABSPATH=str_replace("/inc","",dirname(__FILE__));
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT",true);
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT",true);
?>
