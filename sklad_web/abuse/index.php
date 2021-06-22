<?
include_once("../inc/func.inc");
$title_tag="Кабель  и провод из наличия  - СКЛАД :: Жалоба на поставщика";
$navpage="info";
$text1="";
$txt="";
$company=array();
$page_dir="";
$dopurl="";
$gor=array();
$out="";
$ruri="";

if(isset($_SESSION['login']))
{
    $result=mysql_query("SELECT * FROM users WHERE login='".$_SESSION['login']."' LIMIT 1");
    $userinfo = mysql_fetch_assoc($result);
}


$form='
	<h1>Жалоба на поставщика</h1>
<p>Уважаемые господа, если Вы столкнулись с фактом предоставления в систему недостоверной информации, то просим Вас сообщить нам об этом. Наша цель – поддерживать систему только актуальной информацией.</p>
<p>
Если Ваши сведения подтвердятся, то на компанию будут наложены санкции, вплоть до полного исключения из системы SKLAD.RusCable.Ru
</p>
<p>Ниже приводится форма, где звёздочками помечены обязательные к заполнению пункты. Полные идентификационные данные о себе обязательны, с целью исключения недобросовестной конкуренции и анонимных сообщений. Администрация оставляет за собой право переслать Вашу жалобу обсуждаемой организации с целью полного выяснения причин на несоотвествие информации.</p>
<p>Просим указывать как можно больше детальной информации, с целью ускорения разрешения вопроса.</p>

<div class="tform">
<form method="POST" enctype="multipart/form-data">
<table  cellpadding="3" cellspacing="1" border="0" align=left class="tblbord" width=50%>

<tr><td width=30%><font color=red>*</font>ФИО:</td><td><input type=text name=fio value="'.@$userinfo['name'].'" style="width:250px;"></td></tr>
<tr><td width=30%><font color=red>*</font>Ваша организация:</td><td><input type=text name=org  value="'.@$userinfo['comp'].'" style="width:250px;"></td></tr>
<tr><td width=30%><font color=red>*</font>e-mail:</td><td><input type=text name=email  value="'.@$userinfo['email'].'" style="width:250px;"></td></tr>
<tr><td width=30%><font color=red>*</font>Телефон:</td><td><input type=text name=phone  value="'.@$userinfo['tel'].'" style="width:250px;"></td></tr>
<tr><td width=30%><font color=red>*</font>Недобросовестная организация:</td><td><input type=text name=badorg style="width:250px;"></td></tr>
<tr><td width=30%><font color=red>*</font>Жалоба в произвольной форме с деталями (позиция, с кем общались и т.п.)</td>
<td><textarea rows=8 name=abusetext style="width:250px;"></textarea></td>
</tr>
<tr><td width=30%>Прикрепить счёт (если был) (формат jpg, gif, pdf):</td><td><input type=file name=ufile style="width:250px;"</td></tr>
<tr><td width=30%><font color=red>*</font>
';
$form.=cpt1a()."</td><td>".cpt2a()."</td></tr>
<tr class=tblth><td colspan=2 align=center><input type=submit value='отправить'></td></tr>
</table>
</form>
</div>";

if($_SERVER['REQUEST_METHOD']=="POST"){
	$error=0;
	$fio=trim($_POST['fio']);
	$org=trim($_POST['org']);
	$email=trim($_POST['email']);
	$phone=trim($_POST['phone']);
	$badorg=trim($_POST['badorg']);
	$abusetext=trim($_POST['abusetext']);
	if($_SESSION['sent']==1){
		$error++;
		$out="Вы уже отправляли письмо.";		
	}
	if(!ch3()){
		$error++;
		$out="Не совпадают контрольные символы";
	}
	if(has_no_newlines($fio) && has_no_newlines($org) && has_no_newlines($email) && has_no_newlines($phone)  && has_no_newlines($badorg)  && has_no_emailheaders($abusetext)){
		$error=0;
	}else{
		$error++;
		$out="Ошибка в данных";
	}
	if(is_uploaded_file($_FILES["ufile"]['tmp_name'])){
		if(!preg_match("/\.(?:jp(?:e?g|e|2)|gif|pdf)$/i",$_FILES["ufile"]['name'])){
			$error++;
			$out="Недопустимое расширение файла";		
		}
	}
	if($fio=="" || $org=="" || $email=="" || $phone=="" || $badorg==""||$abusetext==""){
			$error++;
			$out="Необходимо указать все данные";		
		
	}
	
	if($error==0){
		$mails=array("m.borzunov@corp.ruscable.ru","ruscable@gmail.com");
		include('Mail.php');
	    include('Mail/mime.php');
	    $text1="ФИО: $fio
Организация: $org
email $email
телефон $phone
======
Жалоба на: $badorg
Текст: $abusetext
======
";
		$text=iconv("UTF-8","CP1251",$text1);
		//отправка
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
		$subj1="Жалоба на недостоверную информацию на SKLAD.RusCable.Ru";
		$subj=iconv("UTF-8","CP1251",$subj1);
		$headers=array(
		'Subject'	=>	"=?windows-1251?b?".base64_encode($subj)."?=",
		'From'		=>	"<no_reply@ruscable.ru>"
		);
    $bcc=implode(", ",$mails);
    $newmail->addBcc($bcc);
    $newmail->setTXTBody($text);
    
    if(is_uploaded_file($_FILES["ufile"]['tmp_name'])){
    
   		$fname=$_FILES["ufile"]['tmp_name'];
    	$newmail->addAttachment($fname, 'octet/stream', rus2lat($_FILES["ufile"]['name']));
    }
    $body = $newmail->get();
    $hdrs = $newmail->headers($headers);
    $to='sklad@ruscable.ru';
    $mail =& Mail::factory('mail');

    if(!$mail->send($to, $hdrs, $body)){
        $out="Уважаемый $fio!<br>
Спасибо за обращение.<br>
К сожалению, отправить письмо не удалось.<br>
Попробуйте отправить эту же информацию на email <a href='mailto:sklad@ruscable.ru'>sklad@ruscable.ru</a>, указав в теме письма слово 'Жалоба'.

";
    }else{
        
       $out="Уважаемый $fio!<br>
Спасибо за обращение.<br>
Ваша жалоба на организацию $badorg будет рассмотрена в ближайшее время.<br>
Сделаем работу на SKLAD.RusCable.Ru  прозрачной и честной вместе!
";
        $_SESSION['sent']=1;
    }
		
		
		
		
		
		
		
	
	}else{
		$out="<font color=red>$out</font><hr>".$form;
	}

}else{
	$out=$form;
}



include_once("../inc/header.inc");

//if($_SERVER['REMOTE_ADDR']=="91.206.62.23") print_r($_SESSION);

?>


<div id="main" class="row">
    <div class="container">
        <div class="col-md-12 top">
            <a href="/" class="logo"></a>
            <div class="subtitle">Сервис для поиска кабельно-проводниковой продукции</div>
            <form class="top-form" id="search">
                <input type="text" placeholder="Введите маркоразмер">
                <input type="submit" value="Найти">
            </form>
        </div>
    </div>
</div>
<table width="100%">
<tr>
	<td valign=top>
	
	
<?=$out;?>



	</td>
	
</tr>
</table>
<?
include_once("../inc/footer.inc");
?>
