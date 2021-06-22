<?php
session_start();
if(isset($_SESSION['captcha_privatekey']) && $_SESSION['captcha_privatekey'] === $_POST['captchainput']){

	$picture = ""; 
	$valid_formats = array("doc", "docx", "txt", "xls", "xlsx");
	if (!empty($_FILES['atach']['tmp_name'])) 
	{ 
		$filename = stripslashes($_FILES['atach']['name']);
	
		$ext = getExtension($filename);
		$ext = strtolower($ext);

		if(in_array($ext,$valid_formats)){
			$path = $_FILES['atach']['name']; 
			if (copy($_FILES['atach']['tmp_name'], $path)) $picture = $path; 
		}
		else{
			echo 'fileExterror';
			exit;
		}
	}

	

	if (!empty($_POST['mail']) && !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		echo 'emailerror2'; exit; 
	}

    if (empty($_POST['mail']) && empty($_POST['phone']) && empty($_POST['contactName'])){
        echo 'emptyerror'; exit;
    }

	$_POST['mail'] = htmlspecialchars(stripslashes($_POST['mail'])); 
	$_POST['text'] = htmlspecialchars(stripslashes($_POST['text']));
	$_POST['coment'] = htmlspecialchars(stripslashes($_POST['coment']));
	$_POST['phone'] = htmlspecialchars(stripslashes($_POST['phone']));
	$_POST['organ'] = htmlspecialchars(stripslashes($_POST['organ']));	
	$_POST['city'] = htmlspecialchars(stripslashes($_POST['city']));	
	$_POST['contactName'] = htmlspecialchars(stripslashes($_POST['contactName']));	
	$_POST['actual'] = htmlspecialchars(stripslashes($_POST['actual']));			

	
	
	$thm = "Заявка от компании ".$_POST['organ'];
	
	$msg = "Организация: ".$_POST['organ']."<br/>
E-mail: ".$_POST['mail']."<br/>
Телефон: ".$_POST['phone']."<br/>
Актуальность: ".$_POST['actual']."<br/>
Город: ".$_POST['city']."<br/>
Контактное лицо: ".$_POST['contactName']."<br/>
Текст по заявке: ".$_POST['text']."<br/>
Комментарий: ".$_POST['coment'];
	
	$mail_to = 'zakaz@kab.ru';
	
	if(empty($picture))
    {
        send_mail_noatach('zakaz@kab.ru', $thm, $msg);
        send_mail_noatach('romka@totalbiz.ru', $thm, $msg);
        send_mail_noatach('m.gerasimova@corp.ruscable.ru', $thm, $msg);


    }
	else
    {
        send_mail('zakaz@kab.ru', $thm, $msg, $picture);
        send_mail('romka@totalbiz.ru', $thm, $msg, $picture);
        send_mail('m.gerasimova@corp.ruscable.ru', $thm, $msg, $picture);
    }

    $text_client_message = "Спасибо за обращение в Отраслевую Службу Заказов (ОСЗ) от RusCable.Ru, в ближайшее время Ваша заявка будет направлена до абонентской базы поставщиков нашего портала!<br />Желаем успехов!<br /><i>Для того, чтобы стать абонентом службы, обращайтесь по тел: 8 (495) 229 33 36 или электронному адресу: reklama@corp.ruscable.ru.</i>";

    if(!empty($_POST["mail"]))
        send_mail_noatach($_POST["mail"], "Заявка с RusCable.Ru", $text_client_message);



    unset($_SESSION['captcha_privatekey']);
}else{
echo "error2";
}

	function send_mail_noatach($to, $thm, $html) 
	{ 
	
		$boundary = "--".md5(uniqid(time())); 
	
		$headers .= "MIME-Version: 1.0\n"; 
	
		$headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 
	
		$multipart .= "--$boundary\n"; 
	
		$multipart .= "Content-Type: text/html; charset=UTF-8\n"; 
	
		$multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n"; 
	
		$multipart .= "$html\n\n"; 
	
	
	
		$message_part = "--$boundary\n"; 
	
	
	
		if(!mail($to, $thm, $multipart, $headers)) { 
	
		echo "error"; 
	
		exit(); 
	
		} 
	
	}

	function send_mail($to, $thm, $html, $path) 
	{ 
	
		$fp = fopen($path,"r"); 
	
		if (!$fp) 
	
		{ 
	
		print "Файл $path не может быть прочитан"; 
	
		exit(); 
	
		} 
	
		$file = fread($fp, filesize($path)); 
	
		fclose($fp); 
	
		
	
		$boundary = "--".md5(uniqid(time())); 
	
		$headers .= "MIME-Version: 1.0\n"; 
	
		$headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 
	
		$multipart .= "--$boundary\n"; 
	
		$multipart .= "Content-Type: text/html; charset=UTF-8\n"; 
	
		$multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n"; 
	
		$multipart .= "$html\n\n"; 
	
	
	
		$message_part = "--$boundary\n"; 
	
		$message_part .= "Content-Type: application/octet-stream\n"; 
	
		$message_part .= "Content-Transfer-Encoding: base64\n"; 
	
		$message_part .= "Content-Disposition: attachment; filename = \"".$path."\"\n\n"; 
	
		$message_part .= chunk_split(base64_encode($file))."\n"; 
	
		$multipart .= $message_part."--$boundary--\n"; 
	
	
	
		if(!mail($to, $thm, $multipart, $headers)) { 
	
		echo "error"; 
	
		exit(); 
	
		} 
	
	}
	
	function getExtension($str)
	{
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}
?>