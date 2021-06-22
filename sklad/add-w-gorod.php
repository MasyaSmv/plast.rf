<?
ini_set('display_errors','on');
$where_am_i="sklad";
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
$site_nav[]=array("name"=>"Склад - Добавление</a>","url"=>"/$document_admin/sklad/add.php");
$statuses=array(0=>"не проверен",1=>"проверен и размещён", 2=>"проверен и отклонён", 3=>"устарел и будет удалён");
db_connect();
$unit=array();
$r=sql("select id,ed from sklad_unit order by id");
foreach($r as $rr){
	list($unid,$ed)=$rr;
	$unit[$unid]=$ed;
}
$unitf=array_flip($unit);
$msg="";
if($_SERVER['REQUEST_METHOD']=="POST"){
	if($_POST['step2']==1){
		$data=unserialize(gzuncompress(base64_decode($_POST['data'])));
		$c_id=$_POST['c_id2'];
		$city=$_POST['city'];
		//mysql_query("delete from sklad_tovar where comp_id=$c_id");
		foreach($data as $k=>$v){
			$title=$v['title'];
			$kol=str_replace(".",",",$v['quant']);
			$ed=$v['unit_id'];
			$comments=$v['comments'];
			$q="insert into `sklad_tovar` set `comp_id`=$c_id, `title`='$title',`quant`='$kol', `unit_id`=$ed, `date_cr`=CURDATE(), `visible`=1, `comments`='$comments', city='$city'";
			mysql_query($q);
		}	
		mysql_query("insert into sklad_userfiles_stat set uid=$c_id, date_cr=CURDATE()");
			if(isset($_POST['uved']) && $_POST['uved']=="on"){
				if($_SESSION['skladsent']==$c_id){
					$msg.="<p style='color:red;font-size:110%;'>Уведомление не отправлено: этому клиенту сегодня уже отправлялось уведомление</p>";
				}else{
					$cname=ssql("select `name` from users where id=$c_id limit 0,1");
					$cemail=ssql("select `email` from users where id=$c_id limit 0,1");
					include_once('Mail.php');
					include_once('Mail/mime.php');	
					$nextdate=date("d.m.Y",strtotime("now + 14 days"));	
					$subj="SKLAD.RusCable.Ru Ваши позиции размещены.";				
$text="Здравствуйте, $cname.

Сегодня Ваши складские остатки размещены на сервисе SKLAD.RusCable.Ru
Следующая дата предоставления информации не позднее $nextdate.
За три дня до окончания срока Вам будет выслано напоминание.

В случае, если у Вас появятся вопросы  и пожелания, обратитесь к нашим менеджерам по телефону (495) 229-33-36 
или по e-mail: sklad@ruscable.ru

Спасибо за использование сервиса.

Команда RusCable.Ru.
";				
				
					$crlf = "\n";
					$newmail = new Mail_mime($crlf);
					$newmail->_build_params = array(
					 'text_encoding' => 'quoted-printable',
					 'html_encoding' => 'quoted-printable', 
					 '7bit_wrap'     => 998,
					 'html_charset'  => 'windows-1251',
					 'text_charset'  => 'windows-1251',
					 'head_charset'  => 'windows-1251'
					);
					$headers=array(
					'Subject'	=>	"=?windows-1251?b?".base64_encode($subj)."?=",
					'From'		=>	"<sklad@ruscable.ru>"
					);
					$newmail->setTXTBody($text);
					$body = $newmail->get();
					$hdrs = $newmail->headers($headers);
					//$to='abcd@ruscable.ru';
					$to=$cemail;
					$mail =& Mail::factory('mail');
					if(!$mail->send($to, $hdrs, $body)){
					}else{
						$_SESSION['skladsent']=$c_id;
						$msg.="<p style='color:red;font-size:110%;'>Уведомление клиенту отправлено</p>";
					}
				}	
			}
			include("$DOCUMENT_ROOT/$document_admin/top.php");
			print "<h1>Позиции успешно добавлены</h1>Добавлено позиций: ".sizeof($data)."<br>$msg<br><br><a href='".$_SERVER['PHP_SELF']."'>Добавить ещё</a>
			<script>
			setTimeout('document.location.href=document.location.href', 3000);
			</script>
			";
			
			include("$DOCUMENT_ROOT/$document_admin/bottom.php"); 
			exit;
	}
	if(isset($_POST['stat_sel']) && isset($_POST['id'])){
		//print_r($_POST);exit;
		mysql_query("update sklad_userfiles set status=".intval($_POST['stat_sel']).", comment='".mysql_real_escape_string($_POST['comment'])."' where id=".$_POST['id']." limit 1");
		header("Location: /admin2/sklad/add.php");
		exit;
	}
	if(isset($_POST['c_id'])){
			// пропарсить файл+, проверить компанию+, показать предпросмотр+
		$error=0;
		$c_id=intval($_POST['c_id']);
		
		if($c_id==0 || $c_id==""){
			$error++;
			$msg="<p style='color:red;font-size:110%;'>Не был выбран пользователь</p>";
		}else{
			$iscomp=ssql("select count(id) from users where id=$c_id");
			if($iscomp==0){
				$error++;
				$msg="<p style='color:red;font-size:110%;'>Пользователя нет или он неактивен</p>";
			}else{
				$cname=ssql("select name from users where id=$c_id");
				$cname.=", ".ssql("select comp from users where id=$c_id");
			}
		}
		if(!is_uploaded_file($_FILES['ufile']['tmp_name'])){
			$error++;
			$msg="<p style='color:red;font-size:110%;'>Файл не закачан на сервер</p>";
		}
		if(!preg_match("/xls$/i",$_FILES['ufile']['name']) && !preg_match("/csv$/i",$_FILES['ufile']['name'])){
			$error++;
			$msg="<p style='color:red;font-size:110%;'>Файл неземного формата</p>";
		}
		if($error==0){
			
			
			if(preg_match("/xls$/i",$_FILES['ufile']['name'])){
				setlocale(LC_ALL, 'ru_RU.CP1251');
				$tmpfname = tempnam("/var/tmp", "FOOO");
				$com="/usr/local/bin/xls2csv -scp1251 -dcp1251 '".$_FILES['ufile']['tmp_name']."' > $tmpfname 2> /home/ruscableru/ruscableru/www/admin2/sklad/222.err";
				$a=`$com`;
				//if($_SERVER['REMOTE_ADDR']=="91.206.62.23"){
				//	echo $com, "  $tmpfname<br>";
				//}
				if(($a=file_get_contents("/home/ruscableru/ruscableru/www/admin2/sklad/222.err"))!=""){
					unlink("/home/ruscableru/ruscableru/www/admin2/sklad/222.err");
				}
				
			}elseif(preg_match("/csv$/i",$_FILES['ufile']['name'])){
				$tmpfname=$_FILES['ufile']['tmp_name'];
			}
			//echo $tmpfname;exit;
			$k=1;
			$lim=10000;
			$h=fopen($tmpfname,"r");
			$stopwords=array();
			$q=ssql("select word from sklad_stop_words order by word");
			$r=sql($q);
			foreach($r as $rr){
				list($w)=$rr;
				$stopwords[]=$w;
			}
			$dar=array();
			$data=array();
			while(($ar = fgetcsv($h,1000,",")) !== FALSE && $k <= $lim){
				if(sizeof($ar)==1){continue;}
				//echo $c."<br>";
				//if($k == 0){$k++;continue;}else{$k++;}
				
				$title=trim($ar[0]);
				$title=str_replace(" * ","х",$title);
				$title=str_replace("*","х",$title);
				$title=preg_replace("/\s+/"," ",$title);
				$kol=trim($ar[1]);
				$ed=trim($ar[2]);
				$ed=str_replace(".","",$ed);
				$comm=trim($ar[3]);
				//if(mb_detect_encoding($ed,"UTF-8, CP1251, ASCII")=="UTF-8"){
				//	$ed2=iconv("UTF-8","CP1251",$ed);
				//	$ed=$ed2;
				//}
				
				//print "$title ".strtolower($ed)."<br>";
				$edid=$unitf[strtolower($ed)];
				if(!$edid){
					$ed=3;
				}else{
					$ed=$edid;
				}
					
				$quant=str_replace(",",".",$kol);
				if(!is_float($quant)){
					settype($quant,"float");
				}
				$quant=round($quant,4);
				$kol=$quant;
				//$kol=str_replace(".",",",$quant);
				// метры в километры
				if($ed==2){
					$kol/=1000;
					$kol=round($kol,4);
					$ed=3;
				}
				// килограммы в тонны
				if($ed==8){
					$kol/=1000;
					$kol=round($kol,4);
					$ed=1;
				}
				
				if($title!==""){
					$lcheck=0;
					foreach($stopwords as $stopword){
						if(preg_match("/$stopword/",$title)){$lcheck++;}
					}
					if($lcheck==0){	
						$data[$k]['title']=mysql_escape_string(trim($title));
						$data[$k]['quant']=$kol;
						$data[$k]['unit_id']=$ed;
						$data[$k]['comments']=$comm;
						$k++;
					}
				}
			}
			//print_r($data);
			//преобразование однородных позиций
			$un=array();$kol=array();$edd=array();$comments=array();
			foreach($data as $k=>$v){
				if(in_array($v['title'],$un)){

					//такое название уже есть
					$k2=array_search($v['title'],$un);
					//echo "<hr>".$v['title']." $k -".$k2."<hr>";
					if($comments[$k2]==""){
						$comments[$k2]=$kol[$k2]."; ".$v['quant']."; ";
					}else{
						$comments[$k2].=$v['quant']."; ";
					}
					if(!is_float($v['quant'])){
						settype($v['quant'],"float");
					}					
					$v['quant']=round($v['quant'],4);
					if(!is_float($kol[$k2])){
						settype($kol[$k2],"float");
					}	
					$kol[$k2]=round($kol[$k2],4);
					//$tmp=bcadd($kol[$k2], $v['quant'], 4); 
					//$kol[$k2]=$tmp;
					$kol[$k2]+=$v['quant'];
				}else{
					$un[$k]=$v['title'];
					//print $v['title']." ".$k."<br>";
					$kol[$k]=$v['quant'];
					$edd[$k]=$v['unit_id'];
					$comments[$k]=$v['comments'];
				}			
			}
			
			//print_r($comments);
			foreach($un as $k=>$v){
				$data2[$k]['title']=$v;
				$data2[$k]['quant']=$kol[$k];
				$data2[$k]['unit_id']=$edd[$k];
				$data2[$k]['comments']=$comments[$k];
			}
			
			include("$DOCUMENT_ROOT/$document_admin/top.php");
			print "<h1>Предпросмотр</h1>
			<h2>$cname</h2>
			<form method=POST>
			<table border=0 width=50% cellpadding=3 cellspacing=1 class=color1>";
			print "<tr class=color4><td>№</td><td valign=top>Наименование</td><td>Количество</td><td>Единица</td><td>Дополн.</td></tr>";
			if(sizeof($data2)==0){
				print "<tr class=color4><td colspan=10><font color=red>Не удалось прочитать данные. Ошибка $a</a></td></tr>";
			}else{
				foreach($data2 as $k=>$v){
					
					print "<tr class=color4><td>$k</td><td valign=top>".$v['title']."</td><td>".$v['quant']."</td><td>".$unit[$v['unit_id']]."</td><td>".$v['comments']."</td></tr>";
	
				
				}
			}
			print "</table>
			<input type=hidden name=data value='".base64_encode(gzcompress(serialize($data2)))."'>
			<input type=hidden name=step2 value='1'>
			<input type=hidden name=c_id2 value='$c_id'>";
			if($_POST['uved']=="on"){
				print "<input type=hidden name=uved value='on'>";
			}else{
				print "<input type=hidden name=uved value=''>";			
			}
			print "<input type=hidden name=city value='".$_POST['city']."'>";
			print "<input type=submit value='Добавить данные'> <a href='".$_SERVER['PHP_SELF']."'>Не добавлять</a>
			</form>";
			include("$DOCUMENT_ROOT/$document_admin/bottom.php"); 
			unlink($tmpfname);
			exit;
			
		}
	}
}


if(isset($_SESSION['sklad_view_status']) && !isset($_POST['view_stat'])){
	$view_stat=$_SESSION['sklad_view_status'];
}elseif(isset($_POST['view_stat'])){
	$_SESSION['sklad_view_status'] =	$_POST['view_stat'];	
	$view_stat=$_POST['view_stat'];
}else{
	$view_stat=0;
}

if(isset($_GET['delufile'])){
	$did=intval($_GET['delufile']);
	mysql_query("delete from sklad_userfiles where id=$did limit 1");
	header("Location: /admin2/sklad/add.php");
	exit;
}

include("$DOCUMENT_ROOT/$document_admin/top.php");
?>
<script language=Javascript>
function ch(){
ans = confirm("Удалить запись ?");
if(ans){return true;}else{return false;}   
}
</script>

<style>
table tr td {font-size:12px;}
.form, .form td{
	border-collapse: collapse;
	border: 1px solid #7E89B1;
	padding:5px;
	font-size: 12px;
}
.red{
	color:red;
}
.none_bord{
	border:none;
}
.none_bord td{
	border:none;
}
.form a{
	font-size: 12px;
}
</style>
<?
if($msg!=""){
	echo "<hr><font color=red style='font-size:110%'>$msg</font><hr>";
}	
if(isset($_GET['c_id'])){
	$c_id=intval(trim($_GET['c_id']));
	
	$title=ssql("select name from users where id=$c_id limit 0,1");
	$title2=ssql("select comp from users where id=$c_id limit 0,1");
	$title="$title, $title2";
	$link="<a target=_new href='/admin2/users/users.html?id=$c_id&page=1'>$title</a>";
	$c_idv=$c_id;
	$title=str_replace("'",'"',$title);
	$dpfield= "<input type='hidden' name='company' value='$title'>";
}else{
	$link=<<<LINK
	
<input id="company1" type="text" name="company" style="width:200px;"/> 
<div id="compdiv"></div>
<script>
$(document).ready(function(){  
	$('#company1').keyup(function(){  
		$.ajax({ 
			type: "GET",  
			url: "s.php",
			data: "comp="+$("#company1").val(),
			success: function(html){
				$("#compdiv").html(html);
			}	
		});
	});
});
</script>
LINK;
	$c_idv="";
	$dpfield="";
}


?>
<form method="POST" enctype="multipart/form-data">
<table border=0 width=50% cellpadding=3 cellspacing=1 class=color1>
<tr class=color4>
<td>1)</td><td width=150>Пользователь, логин</td><td><?=$link?></td>
</tr>
<tr class=color4>
<td>2)</td><td width=150>ID пользователя<br>(опционально)</td><td><input type=text size=6 id="company2" name=c_id value='<?=$c_idv?>'></td>
</tr>
<tr class=color4><td>3)</td><td>Xls файл</td><td><input type=file name="ufile"></td></tr>
<tr class=color4><td>4)</td><td>Город (опционально)</td><td><input type=text name="city" style="width:200px;"></td></tr>
<tr class=color4><td>5)</td><td>Уведомление польз. на email</td><td><input type=checkbox name="uved" checked></td></tr>
<tr class=color4><td colspan=3><input type=submit value="Добавить"></td></tr>
</table>

<?=$dpfield?>
</form>
<a href='javascript:void(0);' id=lhelph>Справка</a>
<p id=lhelp>
Структура файла данных:<br>
<b>Название, Количество, Единица измерения, Остатки по барабанам</b>(необязательное поле)<br>
Единица измерения может быть следующей: <? foreach($unit as $v){print "$v, ";}?> при этом "м" будет автоматически разделено на 1000 и преобразовано в "км", то же самое произойдет с "кг" - преобразуется в тонны.<br>
Нажав кнопку "Добавить" вы попадете в окно предпросмотра, где данные будут показаны именно в таком виде, в котором они лягут в базу. Если что-то не устраивает - пройдёте там по ссылке "не добавлять".
</p>

<script>
jQuery(function(){
$('#lhelph').toggle(
function(){
	$('#lhelp').hide('slow');
},
function(){
	$('#lhelp').show('slow');
});
});
</script>

<hr>
<h1>Файлы, добавленные пользователями через личный кабинет</h1>
<form method=post>Статус:

<?




$cursel1="<select name=view_stat size=1 onchange='this.form.submit();'>";
foreach($statuses as $n=>$status){
	$cursel1.="<option value='$n' "; if($n==$view_stat){$cursel1.="selected";}
	$cursel1.=">$status</option>";
}
$cursel1.="</select>";
print $cursel1."</form>";


$q="select id,uid,DATE_FORMAT( `date_cr` , '%d.%m.%Yг.<br>%H:%i' ),comment from sklad_userfiles where status=$view_stat order by id, uid, date_cr";
//echo $q;
$r=sql($q);
if(sizeof($r)==0){
	print "файлов нет";
}else{
	print "<table border=0 width=50% cellpadding=3 cellspacing=1 class=color1>
	<tr class=color2><td>Пользователь</td><td>Дата добавления</td><td>Скачать</td><td>Изменить статус</td><td>Комментарий</td><td>Удалить</td></tr>
	";
	foreach($r as $rr){
		list($id,$cid,$date,$comment)=$rr;
		$cursel="<select name=stat_sel size=1 onchange='this.form.submit();'>";
		foreach($statuses as $n=>$status){
			$cursel.="<option value='$n' "; if($n==$view_stat){$cursel.="selected";}
			$cursel.=">$status</option>";
		}
		$cursel.="</select>";
		
		$cname=ssql("select name from users where id=$cid");
		$cname2=ssql("select comp from users where id=$cid");
		$cname="<a href='/admin2/sklad/add.php?c_id=$cid'>$cname</a>, $cname2";
		print "<tr class=color4><td>$cname</td><td>$date</td><form target=_new action='get.php' method=post><td><input type=hidden name=id value=$id><input type=submit value='скачать'></td></form><form method=post><td><input type=hidden name=id value=$id>$cursel</td><td><textarea rows=2 cols=10 name=comment>$comment</textarea></td></form><td><a href=add.php?delufile=$id onclick='return ch();'>Удалить</a></td></tr>";
	}
	print "</table>";
}


include("$DOCUMENT_ROOT/$document_admin/bottom.php"); 
?>


