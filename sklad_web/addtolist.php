<?
include_once("inc/func.inc");
db_connect();

$sklad_uid=$sklad_cid=$free_searches=0;
if(isset($_SESSION['login']) && $_SESSION['login']!=""){$sklad_uid=$_SESSION['panel_user_id'];}
if(isset($_SESSION['company_id']) && $_SESSION['company_id']!=""){$sklad_cid=$_SESSION['company_id'];}

$authorized=0;
$action11_enabled="YES";
$action11=0;
$action11h=11;
//$action11h=15;
$action11mbegin=0;
$action11mend=12;
//$action11mend=59;
$actionUTCh=$action11h-4;
/*
if($action11_enabled=="YES" && date("H") == $action11h && date("i")<$action11mend && date("i")>=$action11mbegin){
	$action11=1;
	$authorized=1;
	$free_searches=100000;
}else{
	//проверка на куку из информера
	if((isset($_COOKIE['informer']) && preg_match("/(.*)-\d+/",$_COOKIE['informer']) && strstr($_SERVER['REQUEST_URI'],$_COOKIE['informer']))||$_SESSION['informer_comp_id']>0){
		$authorized=2;
	}

	if($sklad_uid > 0 && $sklad_cid > 0){
		//базовые данные есть, можно приступить к проверке.
		// есть ли платная актуальная услуга?
		$isplatn=ssql("select count(*) from company_usl_list where company_id=$sklad_cid and tarif_id=18 and date_begin <= CURDATE() and date_end >= CURDATE()");
		if($isplatn > 0){
			$authorized=2;
			$end_date=ssql("select date_end from company_usl_list where company_id=$sklad_cid and tarif_id=18 and date_begin <= CURDATE() and date_end >= CURDATE()");
			unset($_COOKIE['informer']);
			unset($_SESSION['informer_comp_id']);
			unset($_SESSION['informer_comp_name']);
		}else{
			// платной услуги нет, проверяем на бесплатную
			$isfree=ssql("select count(*) from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
			if($isfree > 0){
				//проверяем, сколько поисков уже сделано
				$start_date=ssql("select date_begin from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
				$end_date=ssql("select date_end from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
				$hassearch=ssql("select count(*) from sklad_free_access where c_id=$sklad_cid and vremya >='$start_date'");
				if($hassearch < $max_free_searches){
					$authorized=1;
					$free_searches=$max_free_searches-$hassearch;
				}else{
					$authorized=1;
					$free_searches=0;
				}
			}else{
				$authorized=1;
				$free_searches=$max_free_searches;
				$end_date=ssql("select date_end from company_usl_list where company_id=$sklad_cid and tarif_id=19 and date_begin <= CURDATE() and date_end >= CURDATE()");
			}

		}

	}
}
*/
if($sklad_uid > 0){
	$authorized=2;
}
if(!isset($_SESSION['sklad_uid']) || $authorized < 1){
	exit;
}



$uid = $_SESSION['sklad_uid'];

if(isset($_GET['data-id'])){
	$id = intval($_GET['data-id']);
	$ist = ssql("select count(*) from sklad_tovar where id = $id");
	$isus = ssql("select count(*) from sklad_note where user_id = $uid and t_id = $id");
	if($ist == 1 && $isus == 0){
		mysql_query("insert into sklad_note set user_id = $uid, t_id = $id");
		mysql_query("insert into sklad_note_history set user_id = $uid, t_id = $id");
	}
}
if(isset($_GET['data-del'])){
	if($_GET['data-del'] == "all"){
		mysql_query("delete from sklad_note where user_id = $uid");
	}else{
		$id = intval($_GET['data-del']);
		$ist = ssql("select count(*) from sklad_tovar where id = $id");
		$isus = ssql("select count(*) from sklad_note where user_id = $uid and t_id = $id");
		if($ist == 1 && $isus == 1){
			mysql_query("delete from sklad_note where user_id = $uid and t_id = $id");
		}
	}
}

if($_POST['action'] == "get"){
		//$iss = ssql("select count(*) from sklad_note where user_id = $uid");
		$iss = ssql("select count(n.t_id) from sklad_note n, sklad_tovar s where n.user_id = $uid and n.t_id=s.id");
		if($iss > 0) { ?>
            <?php echo $iss; ?> <?php echo okonch($iss,"позиция"); ?>
    	<?php }
}

if($_POST['action'] == "getfullinfo" || $_GET['action'] == "getfullinfo"){

	if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>
                <div class="actions">
                    <div class="pull-right">
                        <a href="#" id="clearlist" class="red-link">Очистить список</a>
                    </div>
                    <a href="javascript:void(0);" onclick="f3();">Выгрузить в Excel</a>
                    <a href="javascript:void(0);" onclick="f2();">Отправить на печать</a>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>К-во</th>
                        <th>Ед. изм.</th>
                        <th>Город</th>
                        <th>Поставщик</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $q = "select n.t_id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_note n, sklad_tovar s where n.user_id = $uid and n.t_id=s.id  order by s.title";
                    $r = sql($q);
                    $i = 1;
                    $manualCableExist = array();
                    foreach($r as $rr){
                        list($tid, $c_id, $title, $quant, $unit_id, $comments, $city)=$rr;
                        $q="select `name`, `comp`, `email`, `tel`, `fax`, company_id, city from users where id=$c_id and activ=1 limit 0,1";
                        $r1 = sql($q);
                        foreach($r1 as $rr1){
                            list($name, $comp, $email, $tel, $fax, $company_id, $city1)=$rr1;
                        }
                        if($comp != ""){
                            $post = $comp;
                        }else{
                            $iscomp_name = ssql("select company_id from users where id=$c_id");
                            if($iscomp_name > 0){
                                $comp_name=ssql("select concat(forma_sob, ' ', title) from company where id=$iscomp_name");
                                $post = $comp_name;
                            }
                        }
                        if($city == ""){
                            $city = $city1;
                        }
                        if($company_id!=""){
                            $url=@ssql("select `url` from company where id=$company_id limit 0,1");
                        }
                        $kont ="";
                        if($name!=""){
                            $kont.="Контактное лицо: $name<br>";
                        }
                        if($tel!=""){
                            $kont.="Телефон: $tel<br>";
                        }
                        if($fax!=""){
                            $kont.="Факс: $fax<br>";
                        }
                        if($email!=""){
                            $kont.="E-mail: <a href='mailto:$email'>$email</a><br>";
                        }
                        if($url!="" && $url!="http://"){
                            if(!preg_match("{^http://}",$url)){$url="http://".$url;}
                            $kont.="Сайт: <a target=_blank href='$url'>$url</a><br>";
                        }

                        $tempManualArray = array();
                        $tempManualArray = findAllCableManual($title);

                        if(count($tempManualArray) > 0)
                        {
                            foreach($tempManualArray as $tempManualKey=>$tempManualValue)
                            {
                                $manualCableExist[$tempManualKey]=$tempManualValue;
                            }
                        }

                        ?>
                        <tr>
                            <td>
                                <?php echo $title; ?>
                                <div>
                                    <div class="contact-trigger">Контакты</div>
                                    <div class="contact-spoler">
                                        <?php echo $kont; ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $quant; ?></td>
                            <td><?php echo $units[$unit_id]; ?></td>
                            <td><?php echo $city; ?></td>
                            <td><a href="#"><?php echo $post; ?></a></td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>

                <?php if(count($manualCableExist) > 0) { ?>
                    <br />
                    Справочная информация по выбранным маркам:
                    <?php foreach($manualCableExist as $manualCableValue) { ?>
                        <a href="<?php echo $manualCableValue["manual_link"]; ?>" target="_blank"><?php echo $manualCableValue["title"]; ?></a>&nbsp;
                    <?php } ?>
                <?php } ?>


        <form method=post action='/addtolist.php' name='toexcel'><input type=hidden name='action' value='toexcel'></form>

    <script type="text/javascript">
        function f1(a){
            $.ajax({url: '/addtolist.php', data: 'data-del=' + a, cache: false}).done(function(){
                $('#showlist').load('/addtolist.php', {'action':'getfullinfo'});
            });
        }
        function f2(){
            window.open('/addtolist.php?action=getfullinfo');
        }
        function f3(){
            document.toexcel.submit();
        }

        $(document).ready(function(){
                $('#clearlist').click(function(){
                ans = confirm('Действительно очистить весь список?');
                if(ans){
                    $.ajax({url: '/addtolist.php', data: 'data-del=all', cache: false}).done(function(){
                        $(".my-list a").load('/addtolist.php', {'action':'get'});
                        $('#showlist .contentList').load('/addtolist.php', {'action':'getfullinfo'});
                        setTopMargin();
                    });
                }else{
                    return false;
                }
            });
        });

    </script>
    <?php
	}
    elseif($_SERVER['REQUEST_METHOD'] == "GET")
    { ?>

        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>Кабель и провод из наличия :: Склад.RusCable.Ru</title>
            <meta http-equiv="content-type" content="text/html; charset=utf-8">
            <style>
                @media print{
                    body {
                        font-family: Times, "Times New Roman", serif;
                        font-size: 12px;
                    }
                    h1, h2, p {
                        color: #000;
                    }
                }
                table{
                    border-collapse: collapse;
                }
                td{
                    border: 1px solid black;
                    border-collapse: collapse;
                }
            </style>
        </head>
        <body><center><h1 style='font-size:24px;'>Склад.RusCable.Ru &rarr; Мой список</h1></center><br>
        <table id='sorttable' class='tblbord tablesorter'>
            <thead>
            <tr class='tblth'><th width=4%><b style='font-size:10px;'>№</b></th><th width=28%><b>Название</b></th><th width=8%><b style='font-size:10px;'>Количество</b></th><th width=10%><b>Город</b></th><th width=10%><b>Поставщик</b></th><th width=40%><b>Контакты</b></th></tr>
            </thead>
            <tbody>
        <?php
        $q = "select n.t_id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_note n, sklad_tovar s where n.user_id = $uid and n.t_id=s.id  order by s.title";
        $r = sql($q);
        $i = 1;
        foreach($r as $rr){
            list($tid, $c_id, $title, $quant, $unit_id, $comments, $city)=$rr;
            $q="select `name`, `comp`, `email`, `tel`, `fax`, company_id, city from users where id=$c_id and activ=1 limit 0,1";
            $r1 = sql($q);
            foreach($r1 as $rr1){
                list($name, $comp, $email, $tel, $fax, $company_id, $city1)=$rr1;
            }
            if($comp != ""){
                $post = $comp;
            }else{
                $iscomp_name = ssql("select company_id from users where id=$c_id");
                if($iscomp_name > 0){
                    $comp_name=ssql("select concat(forma_sob, ' ', title) from company where id=$iscomp_name");
                    $post = $comp_name;
                }
            }
            if($city == ""){
                $city = $city1;
            }
            if($company_id!=""){
                $url=@ssql("select `url` from company where id=$company_id limit 0,1");
            }
            $kont ="";
            if($name!=""){
                $kont.="Контактное лицо: $name<br>";
            }
            if($tel!=""){
                $kont.="Телефон: $tel<br>";
            }
            if($fax!=""){
                $kont.="Факс: $fax<br>";
            }
            if($email!=""){
                $kont.="E-mail: <a href='mailto:$email'>$email</a><br>";
            }
            if($url!="" && $url!="http://"){
                if(!preg_match("{^http://}",$url)){$url="http://".$url;}
                $kont.="Сайт: <a target=_blank href='$url'>$url</a><br>";
            }
            ?>
            <tr>
                <td class='tbltd'><?php echo $i; ?></td>
                <td class='sortedtitle'><?php echo $title; ?></td>
                <td style='text-align: right;'><?php echo $quant; ?> <?php echo $units[$unit_id]; ?></td>
                <td style='text-align: center;'><?php echo $city; ?></td>
                <td><?php echo $post; ?></td>
                <td><?php echo $kont; ?></td>
            </tr>
         <?php } ?>
            </tbody>
            <table>
       <script>window.print();</script>
        </body>
        </html>

    <?php
    }
}


if($_POST['action'] == "toexcel" || $_GET['action'] == "toexcel"){
	mysql_query("set names cp1251");
	$q = "select n.t_id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_note n, sklad_tovar s where n.user_id = $uid and n.t_id=s.id  order by s.title";
	$r = sql($q);
	$i = 0;
	foreach($r as $rr){
		list($tid, $c_id, $title, $quant, $unit_id, $comments, $city)=$rr;
		$q="select `name`, `comp`, `email`, `tel`, `fax`, company_id, city from users where id=$c_id and activ=1 limit 0,1";
		$r1 = sql($q);
		foreach($r1 as $rr1){
			list($name, $comp, $email, $tel, $fax, $company_id, $city1)=$rr1;
		}
		if($comp != ""){
			$post = $comp;
		}else{
			$iscomp_name = ssql("select company_id from users where id=$c_id");
			if($iscomp_name > 0){
				$comp_name=ssql("select concat(forma_sob, ' ', title) from company where id=$iscomp_name");
				$post = $comp_name;
			}
		}
		if($city == ""){
			$city = $city1;
		}
		if($company_id!=""){
			$url=@ssql("select `url` from company where id=$company_id limit 0,1");
		}
		if($name!=""){
			$kontakt[$i] = $name;
		}else{
			$kontakt[$i] = '';
		}
		if($tel!=""){
			$phones[$i] = $tel;
		}else{
			$phones[$i] = '';
		}
		if($fax!=""){
			$faxes[$i] = $fax;
		}else{
			$faxes[$i] = '';
		}
		if($email!=""){
			$emails[$i] = $email;
		}else{
			$emails[$i] = '';
		}
		if($url!="" && $url!="http://"){
			if(!preg_match("{^http://}",$url)){$url="http://".$url;}
			$urls[$i] = $url;
		}else{
			$urls[$i] = '';
		}

		$names[$i] = $title;
		$kol[$i] = $quant . " " . iconv("UTF-8","CP1251",$units[$unit_id]);
		$cities[$i] = $city;
		$postav[$i] = $post;
		$items[] = $i;
		$i++;
	}

	require_once "Spreadsheet/Excel/Writer.php";
	$xls =& new Spreadsheet_Excel_Writer();
	$xls->setVersion(8);
	$xls->send("Sklad.RusCable.Ru_".date('d.m.Y').".xls");
	$sheet =& $xls->addWorksheet('Worksheet 1');
	$sheet->setInputEncoding('CP1251');
	$titleText = iconv("UTF-8","CP1251",'Подборка кабеля на Склад.RusCable.Ru, ' . date('d.m.Y'));
	// Создание объекта форматирования
	$titleFormat =& $xls->addFormat();
	$titleFormat->setFontFamily('Helvetica');
	$titleFormat->setBold();
	$titleFormat->setSize('13');
	$titleFormat->setAlign('merge');
	$titleFormat->setAlign('vcenter');
	$sheet->write(1,1,$titleText,$titleFormat);
	$sheet->writeRow(1,2,array('','','','',''),$titleFormat);

	// Высота строки
	$sheet->setRow(1,30);
	$sheet->setRow(3,20);
	$sheet->setRow(4,20);
	// Определение ширины колонки для первых 4 колонок
	$sheet->setColumn(0,0,5);
	$sheet->setColumn(1,1,5);
	$sheet->setColumn(2,2,35);
	$sheet->setColumn(3,3,15);
	$sheet->setColumn(4,4,20);
	$sheet->setColumn(5,10,30);


	$bodyFormat =& $xls->addFormat();
	$bodyFormat->setFontFamily('Arial');
	$bodyFormat->setSize('11');
	$bodyFormat->setBottom(1);
	$bodyFormat->setTop(1);
	$bodyFormat->setLeft(1);
	$bodyFormat->setRight(1);
	$bodyFormat->setAlign('center');

	$bodyFormatMarc =& $xls->addFormat();
	$bodyFormatMarc->setFontFamily('Arial');
	$bodyFormatMarc->setSize('11');
	$bodyFormatMarc->setBottom(1);
	$bodyFormatMarc->setTop(1);
	$bodyFormatMarc->setLeft(1);
	$bodyFormatMarc->setRight(1);
	$bodyFormatMarc->setAlign('right');

	$bodyFormatSize =& $xls->addFormat();
	$bodyFormatSize->setFontFamily('Arial');
	$bodyFormatSize->setSize('11');
	$bodyFormatSize->setBottom(1);
	$bodyFormatSize->setTop(1);
	$bodyFormatSize->setLeft(1);
	$bodyFormatSize->setRight(1);
	$bodyFormatSize->setAlign('left');

	$colHeadingFormat =& $xls->addFormat();
	$colHeadingFormat->setBold();
	$colHeadingFormat->setFontFamily('Arial');
	$colHeadingFormat->setBold();
	$colHeadingFormat->setSize('10');
	$colHeadingFormat->setAlign('center');
	$colHeadingFormat->setAlign('top');
	$colHeadingFormat->setBottom(1);
	$colHeadingFormat->setTop(1);
	$colHeadingFormat->setLeft(1);
	$colHeadingFormat->setRight(1);

	$commentFormat =& $xls->addFormat();
	$commentFormat->setFontFamily('Arial');
	$commentFormat->setSize('11');
	$commentFormat->setAlign('merge');

	$bf =& $xls->addFormat();
	$bf->setFontFamily('Arial');
	$bf->setSize('11');
	$bf->setAlign('left');

	$colNames=array(iconv("UTF-8","CP1251","№"), iconv("UTF-8","CP1251","Название"), iconv("UTF-8","CP1251","Количество"), iconv("UTF-8","CP1251","Город"),iconv("UTF-8","CP1251","Поставщик"), iconv("UTF-8","CP1251","Контактное лицо"), iconv("UTF-8","CP1251","Телефон"), iconv("UTF-8","CP1251","Факс"), iconv("UTF-8","CP1251","Email"), iconv("UTF-8","CP1251","Сайт"));
	$sheet->writeRow(3,1,$colNames,$colHeadingFormat);

	for ($i = 0; $i < sizeof($items); $i++ ) {
		$wi = $i + 4;
		$sheet->setRow($wi,20);
		$sheet->write($wi, 1, $items[$i]+1, $bodyFormat);
		$sheet->write($wi, 2, $names[$i], $bodyFormatSize);
		$sheet->write($wi, 3, $kol[$i], $bodyFormatMarc);
		$sheet->write($wi, 4, $cities[$i], $bodyFormat);
		$sheet->write($wi, 5, $postav[$i], $bodyFormatSize);
		$sheet->write($wi, 6, $kontakt[$i], $bodyFormatSize);
		$sheet->write($wi, 7, $phones[$i], $bodyFormatSize);
		$sheet->write($wi, 8, $faxes[$i], $bodyFormatSize);
		$sheet->write($wi, 9, $emails[$i], $bodyFormatSize);
		$sheet->write($wi, 10, $urls[$i], $bodyFormatSize);

	}

	$i+=3;
	$sheet->write($i + 4, 1, iconv("UTF-8","CP1251","Склад.RusCable.Ru - это лучший ежедневно обновляемый рабочий инструмент для снабженцев и трейдеров."), $commentFormat);
	$sheet->writeRow($i + 4, 2, array('','','',''),$commentFormat);
	$str = iconv("UTF-8","CP1251","Следить за новостями http://sklad.ruscable.ru/");
	$sheet->writeUrl($i + 6, 2, "http://sklad.ruscable.ru/", $str, $bf);
	//$sheet->writeFormula($i + 7, 2, "=HYPERLINK('http://sklad.ruscable.ru/';'$str')");
	//$sheet->writeRow($i + 6, 4, array('',''),$bodyFormatSize);

	$xls->close();
	exit;

}



function findAllCableManual($str)
{
    require_once("../www/admin2/info/CableManualClass.php");
    $strArray = explode(" ",$str);
    $out = array();


    foreach($strArray as $strValue)
    {
        $result = CableManualClass::model()->searchCable($strValue);

        if($result)
        {
            $out[$result["id"]]["manual_link"] = "http://www.ruscable.ru/info/wire/mark/".$result["url_title"]."/";
            $out[$result["id"]]["title"] = $result["mark"];

            break;
        }
    }

    return $out;
}


?>