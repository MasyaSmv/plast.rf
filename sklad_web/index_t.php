
<?php

include_once("inc/func.inc");
require_once("../www/admin2/info/CableManualClass.php");

$ruri=strip_tags($_GET['uri']);
if(mb_detect_encoding($ruri,"UTF-8, CP1251, ASCII")!="UTF-8"){
    $ruri=mb_convert_encoding($ruri,"UTF-8");
}

if(preg_match("{/page([0-9]+)/?$}",$ruri,$pp)){
    $page=$pp[1];
    $ruri=preg_replace("{/page([0-9]+)/?$}","",$ruri);
}else{
    $page=1;
}

//echo $ruri;exit();

?>
<?php if($ruri==="/" || $ruri===""){ ?>

    <?php $news = getSkladNews(); ?>
    <?php //$markStat = getMarkStat();  ?>
    <?php $lastQueries = getLastQueries(); ?>
<?
//$end_time = microtime();$end_array = explode(" ",$end_time);$end_time = $end_array[1] + $end_array[0];$time = $end_time - $start_time;
//if($_SESSION['login']=="vladimir"){printf("<center>Страница сгенерирована за %f секунд</center>",$time);}
?>
    <?php $statUsers = 0; ?>
    <?php $statProvider = 0; ?>
    <?php $statSklad = 0; ?>

    <?php $statUsers = ssql("SELECT COUNT(*) FROM `sklad_user_search_stat`"); ?>
    <?php $statProvider = ssql("SELECT COUNT(DISTINCT comp_id) FROM `sklad_tovar`");?>
    <?php $statSklad = ssql("SELECT COUNT(*) FROM `sklad_tovar`"); $statProvider = $statProvider + 90; ?>


    <?php include_once("./inc/header_t.inc");?>
    <?php include_once("./index.text_t.php");?>

<?php } elseif($ruri==="pokupatelu") { ?>

    <?php $containerClass = 'pokupatel';?>
    <?php include_once("./inc/header.inc");?>
    <?php include_once("./pokupatel.text.php");?>

<?php } elseif($ruri=="prodavcu") { ?>

    <?php $containerClass = 'prodavcu';?>
    <?php include_once("./inc/header.inc");?>
    <?php include_once("./prodavcu.text.php");?>

<?php } else { ?>
    <?php $containerClass = 'search';?>
    <?php include_once("./inc/header.inc");?>
    <?php

    $ruri=clearurl($ruri);
    $title_tag="Кабель  и провод из наличия  - СКЛАД :: $ruri";
    if($page > 1){
        $title_tag.=" :: Страница $page";
    }
    $mruri=mysql_real_escape_string($ruri);
    $adq2=array();
    /*$mruri = str_replace("("," ", $mruri);
    $mruri = str_replace(")"," ", $mruri);
    $mruri = str_replace("-1","", $mruri);
    $mruri = str_replace("-"," ", $mruri);
    $mruri = preg_replace("/нг/"," нг ", $mruri);
    $mruri = preg_replace("/\s+/"," ", $mruri);
    */
    $mruris=explode(" ",$mruri);
    $manualLink = false;
	/*
    foreach($mruris as $mrur){
        if($mrur=="кабель" || $mrur=="Кабель" || $mrur=="Провод" || $mrur=="провод"){
            continue;
        }
		//$mrur = trim($mrur);
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
            $res="title like '$mrur%' or title like '%$mrur%'";
            if($mrur2!=""){
                $res.=" or title like '%$mrur2%'";
            }
            if(mb_ereg("-",$mrur) && !mb_ereg("(A)",$mrur) && !mb_ereg("(А)",$mrur)){
                $mrur20=str_replace("-","(A)-",$mrur);
                $mrur21=str_replace("-","(А)-",$mrur);
                $res.=" or title like '%$mrur20%' or title like '%$mrur21%'";
            }
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
    */
    foreach($mruris as $mrur){
    	/*
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
		*/
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
	$adq = implode(" and ",$adq2);

    if(!$manualLink)
        {
            $searchManualCable = CableManualClass::model()->searchCable($mrur);

            if($searchManualCable)
            {
                $manualLink = '<a href="//www.ruscable.ru/info/wire/mark/'.$searchManualCable["url_title"].'/" target="_blank">'.$searchManualCable["mark"].'</a>';
            }
        }

    if($_SESSION['informer_comp_id']>0){
        $adq.=" and comp_id = ".$_SESSION['informer_comp_id'];
    }

    if($curcity==""){
        $q="select count(id) from sklad_tovar s where visible=1 and $adq";
    }else{
        $q="select count(s.id) from sklad_tovar s where city='$curcity' and s.visible=1 and $adq";
    }
    $count = ssql($q);
    $pages_count = ceil($count / $perpage);
    if ($page > $pages_count) $page = $pages_count;
    $start_pos = (($page - 1) * $perpage);
    if($start_pos<0){$start_pos=0;}

    if($mruri!=""){
        $qq="insert into sklad_query_stat set `query`='$mruri',`time`=NOW(),results=$count";
        mysql_query($qq);
        if($_SESSION['sklad_uid'] > 0){
            $is = ssql("select count(*) from sklad_user_search_stat where user_id = ".$_SESSION['sklad_uid']);
            if($is > 0){
                mysql_query("update sklad_user_search_stat set `stat`=`stat` + 1 where user_id = ".$_SESSION['sklad_uid']);
            }else{
                mysql_query("insert into sklad_user_search_stat set user_id = ".$_SESSION['sklad_uid'].", stat = 1");
            }
            @mysql_query("insert into sklad_user_search_stat_ip set user_id = ".$_SESSION['sklad_uid'].", ip = '".$_SERVER['REMOTE_ADDR']."'");
        }
    }

    if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
        $sklad_uid = $_SESSION['sklad_uid'];
        $spisok = array();
        $issel = ssql("select count(*) from sklad_note where user_id = $sklad_uid");
        if($issel > 0){
            $q = "select t_id from sklad_note where user_id = $sklad_uid order by t_id";
            $r = sql($q);
            foreach($r as $rr){
                list($sp) = $rr;
                $spisok[] = $sp;
            }
        }
    }
    if(!$_SESSION['setsort'] || $_SESSION['setsort']=="default"){
        $ordby=" s.title";
    }elseif($_SESSION['setsort']=="kolasc"){
        $ordby="q2 desc, s.title";
    }elseif($_SESSION['setsort']=="koldesc"){
        $ordby="s.q2 ";
    }
    if($curcity==""){
        $q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_tovar s where visible=1 and $adq order by $ordby LIMIT $start_pos, $perpage";

    }else{
        $q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, s.city from sklad_tovar s where city='$curcity' and s.visible=1 and $adq order by $ordby LIMIT $start_pos, $perpage";
    }

	//if($_SESSION['login'] == "vladimir"){
	//	echo $q;
	//}

    if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
        $qq="SELECT distinct city FROM sklad_tovar WHERE visible =1 and city!='' and $adq ORDER BY city";
        $r=sql($qq);
        foreach($r as $rr){
            list($cit)=$rr;
            if($cit!=""){
                $cities[]=$cit;
            }
        }
        $cities2 = array_unique($cities);
    }else{
        $citytext = "Город";
    }


    $r=sql($q);
    $szr=sizeof($r);


    if($authorized==0 || ($authorized===1 && $free_searches ===0) ){

    }else{
        if($authorized===1){
            if($page==1){
                if($action11==0){
                    @mysql_query("insert into sklad_free_access set c_id=$sklad_cid, vremya=NOW()");
                }
            }
        }

        // выбрать тут сразу компании - c тарифом профессионал
        $bestid = array();
        $q2 = "select id from company where tpro=1 AND date(tpro_date) > CURDATE()";
        $r2 = sql($q2);
        foreach($r2 as $rr2){
            list($bid) = $rr2;
            $bestid[] = $bid;
        }


        //выбрать тут сразу названия и урл компаний, чтобы не лазить за ними в базу на каждую строчку
        $q1 = "select distinct s.comp_id, u.name, u.comp, u.city, u.company_id from sklad_tovar s, users u where s.comp_id=u.id order by s.comp_id";

        $r1=sql($q1);
        foreach($r1 as $rr1){
            list($c_id, $cname, $ctitle, $ccity, $ucid)=$rr1;
            if($ctitle==""){$ctitle=$cname;}
            $company[$c_id]['title']=$ctitle;
            $sef=rus2lat($ctitle);
            $sef=preg_replace("/\s+/","-",$sef);
            $sef=preg_replace("/[^a-zA-Z0-9-]/","",$sef);
            $sef=strtolower($sef);
            $sef.="-".$c_id;
            $company[$c_id]['sef']=$sef;
            $company[$c_id]['ucid']=$ucid;
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

    ?>

    <style type="text/css">
        #topline_b {
            position: relative;
        }
    </style>


    <?php
    if($authorized == 0 || ($authorized===1 && $free_searches === 0) ){
$outout = '
	<div class="row" style="margin-top:80px; height:40px;">
    <div class="profile-block" style=" margin-top: -89px; background-color: #FF6600">
     <p style="text-align: center; font-size: 15px; ">
               Для начала работы, пожалуйста, <a href="//www.ruscable.ru/users/" class="loginLink"  data-toggle="modal" data-target="#authModal" style="color:white;text-decoration: underline;">войдите</a> или <a href="//www.ruscable.ru/users/registr.html"  style="color:white;text-decoration: underline;">зарегистрируйтесь</a>
            </p>

            <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top:30px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="//www.ruscable.ru/users/logon.html" class="form-horizontal" role="form"  method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" style="color: black;" id="myModalLabel">Вход на сайт</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="login" style="color: black;" class="col-sm-2 control-label">Логин</label>
                                    <div class="col-sm-10">
                                        <input type="text"  class="form-control" name="login" id="login"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pass"  style="color: black;" class="col-sm-2 control-label">Пароль</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="pass" class="form-control" id="pass"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <a href="//www.ruscable.ru/users/pass.html" class="forgot">Напомнить пароль</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="submit" value="Войти" class="btn btn-default"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div></div>
            </div>';

   } ?>

    <div id="main" class="row">
        <div class="container">
            <div class="col-md-12 top">
                <div class="logo" style="display: block;">
                    <a href="/" class="sklad"></a>
                    <a href="//www.ruscable.ru" class="baseSite"></a>
                </div>
                <div style="clear: both;"></div>
                <div class="subtitle"><p>Сервис для поиска кабельно-проводниковой продукции</p></div>
                <form class="top-form" id="search" action="/">
                    <input name="" placeholder="Введите маркоразмер" type="text" value="<?php echo $ruri; ?>">
                    <input type="submit" value="Найти">
                    <div class="result">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?=$outout?>

    <?if($authorized == 0 || ($authorized===1 && $free_searches === 0) ){ ?>

    <div class="row white">
        <div class="container search">
            <div class="col-md-12">
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <?php if($szr==0) { ?>
                        <div class="header">
                            По вашему запросу ничего не найдено, проверьте правильность указания марки. Примеры запросов: «ВВГнг 4х95 - 1кВ», «КВБбШв 7х2,5», «3х50», «ААШв» и т.п.
                        </div>
                        <?php } else { ?>


                            <div class="header">
                               <img src="https://sklad.ruscable.ru/img/sklad_2_0/cat.png" width="50"> По запросу <b>«<?php echo $ruri; ?>»</b> найдено <?php echo $count; ?> <?php echo okonch($count,"товар"); ?> на <?php echo $pages_count; ?> <?php echo okonch($pages_count,"страница"); ?>
                                
                            </div>

                            <div class="not_auch_mess">
                                Сервис <a href="https://sklad.ruscable.ru/">Sklad.RusCable.Ru</a> является абсолютно бесплатным. Для пользования сервисом, пожалуйста, <a href="//www.ruscable.ru/users/" class="loginLink"  data-toggle="modal" data-target="#authModal" target="_blank">войдите</a> или <a href="https://www.ruscable.ru/users/registr.html" target="_blank">зарегистрируйтесь</a>. 
                            </div>

                            <?php if(isset($manualLink) && $manualLink) { ?>
                                <div class="subheader" style="margin-bottom: 20px;">Информация по марке <?php echo $manualLink; ?> в справочнике RusCable.Ru</div>
                            <?php } ?>
                        <div class="clear"></div>


                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>

    </div>




    <?}else{?>
    

    <div class="row white">
        <div class="container search">
            <div class="col-md-12">
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <?php if($szr==0) { ?>
                        <div class="header">
                            По вашему запросу ничего не найдено, проверьте правильность указания марки. Примеры запросов: «ВВГнг 4х95 - 1кВ», «КВБбШв 7х2,5», «3х50», «ААШв» и т.п.
                        </div>
                        <?php } else { ?>
                            <div class='my-list'>
                                <i class='doc-icon'></i>В моем списке <a data-modal="showlist" class='md-trigger' onclick="setTopMargin();"></a>
                            </div>

                            <div class="header">
                               <img src="https://sklad.ruscable.ru/img/sklad_2_0/cat.png" width="50"> По запросу <b>«<?php echo $ruri; ?>»</b> найдено <?php echo $count; ?> <?php echo okonch($count,"товар"); ?> на <?php echo $pages_count; ?> <?php echo okonch($pages_count,"страница"); ?>
                            </div>

                            <?php if(isset($manualLink) && $manualLink) { ?>
                                <div class="subheader">Информация по марке <?php echo $manualLink; ?> в справочнике RusCable.Ru</div>
                            <?php } ?>
                        <div class="clear"></div>
                        <table class="search-result">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Наименование</th>
                                <th>К-во</th>
                                <th>Ед. изм.</th>
                                <th>
                                    <?php if(($authorized==1 && $free_searches > 0) || $authorized==2 ){ ?>
                                    <div class="city-select">
                                        <select>
                                            <option>Выбрать город</option>
                                            <option value="/setcityall">Все города</option>
                                            <?php foreach($cities2 as $city) { ?>
                                                <option value="/setcity<?php echo $city; ?>"><?php echo $city; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php } ?>
                                </th>
                                <th>Поставщик</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $z=0;
                            foreach($r as $rr){
                                list($id, $comp_id, $title, $quant, $unit_id, $comments,$city)=$rr;
								if(preg_match("/ГОСТ.*\d+.*$/", $title)){
									//$title = str_replace("ГОСТ","<span style='color:green'>ГОСТ", $title);
									//$title .= "</span>";
									$title = preg_replace("/(ГОСТ\s+?[0-9.-]+)/", "<span style='color:green'>$1</span>", $title);
								}
								if(preg_match("/ ТУ.*\d+.*$/", $title)){
									//$title = str_replace("ТУ","<span style='color:blue'>ТУ", $title);
									//$title .= "</span>";
									$title = preg_replace("/(ТУ\s+?[0-9.-]+)/", "<span style='color:blue'>$1</span>", $title);
								}
                                $quant=str_replace(",",".",$quant);
                                if(!is_float($quant)){
                                    settype($quant,"float");
                                }

                                $quant=round($quant,4);
                                $quant=str_replace(".",",",$quant);
								if($comments!=""){
									$quant="<a class='comments' title='$comments'>$quant</a>";
								}

								// если нет ссылки на компанию, нет и пользователя, видимо удалили, стало быть и позицию пропускаем
								if ( !$company[$comp_id]["sef"] ) continue;
                                ?>

                                <tr class="<?php echo in_array($company[$comp_id]['ucid'], $bestid) ? "best" : ""; ?>">
                                    <td>
                                        <?php if((($authorized==1 && $free_searches > 0) || $authorized==2) && sizeof($spisok) > 0 && in_array($id, $spisok)) { ?>
                                            <i class="doc-icon active addtolist" used="yes" data-id="<?php echo $id; ?>"></i>
                                        <?php } elseif(($authorized==1 && $free_searches > 0) || $authorized==2) { ?>
                                            <i class="doc-icon addtolist"  data-id="<?php echo $id; ?>"></i>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $quant; ?></td>
                                    <td><?php echo $units[$unit_id]; ?></td>
                                    <td><?php echo $city; ?></td>
                                    <td><a href="/spisok/<?php echo $company[$comp_id]["sef"]; ?>"><?php echo $company[$comp_id]["title"]; ?></a></td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <div align="center">
                            <?php
                            if ($pages_count >1) { ?>
                                <?php echo show_links($page,$perpage,$count,"/".$ruri."/",$dopurl); ?>
                            <?php } ?>
                        </div>
                        <?php } ?>


					</div>
                </div>
            </div>
        </div>

    </div>
    
    <?}?>


    <script type="text/javascript">
        $(document).ready(function(){
            $(".addtolist").click(function(){
                var dataid = $(this).attr("data-id");

                if( $(this).attr("used") == "yes"){
                    $(this).attr("used","");
                    $(this).removeClass("active");
                    $.ajax({url: "/addtolist.php", data: "data-del=" + dataid, cache: false}).done(function(){
                        $(".my-list a").load('/addtolist.php', {'action':'get'});
                        $('#showlist .contentList').load('/addtolist.php', {'action':'getfullinfo'});
                    });
                }else{
                    var block = $(this);

                    $(this).attr("used","yes").addClass("active");
                    $.ajax({url: "/addtolist.php", data: "data-id=" + dataid, cache: false}).done(function(){
                        $(".my-list a").load('/addtolist.php', {'action':'get'});

                        block
                            .clone()
                            .css({'position' : 'absolute', 'z-index' : '11100', top: block.offset().top, left:block.offset().left})
                            .appendTo("body")
                            .animate({opacity: 0.05,
                                left: $(".my-list").offset()['left'],
                                top: $(".my-list").offset()['top'],
                                width: 20}, 1000, function() {
                                $(this).remove();
                            });

                        $('#showlist .contentList').load('/addtolist.php', {'action':'getfullinfo'});
                    });
                }




            });
            $(".my-list a").load('/addtolist.php', {'action':'get'});
            $('#showlist .contentList').load('/addtolist.php', {'action':'getfullinfo'});
            setTopMargin();
        });

        <?php if($authorized==0 || ($authorized===1 && $free_searches ===0)){ ?>
        $(document).on("click",".search-result",function(){
            $("#warningModalLink").click();
        });
        <?php } ?>

        $(document).on("click",".contact-trigger",function(){
            if($(this).hasClass('opened')){
                $(this).removeClass('opened');
                $(this).next().animate({height: "hide"},200);
            }else{
                $(this).addClass('opened');
                $(this).next().animate({height: "show"},200);
            }
        });

        function setTopMargin()
        {
            $(".md-modal").offset({ top: $(window).scrollTop()+100});

        }



    </script>

<?php } ?>

<?php include_once("./inc/footer.inc");?>


<?php

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

function getSkladNews()
{
    $out = array();
    $query = "select newsid,title,seo_title,text,date,img from news where visible=1 AND img=1 AND date < NOW() ORDER BY date DESC LIMIT 3";

    $result = mysql_query($query);

    while($value = mysql_fetch_array($result))
    {
        $out[] = $value;
    }

    return $out;
}

function getMarkStat()
{

    $out = array();
    $queries = array();
    $query = "select * from sklad_query_stat where  query!='' and query IS NOT NULL AND time > DATE_ADD(now(), INTERVAL -31 DAY) and LENGTH(query) > 2 group by query ORDER BY results DESC LIMIT 100";

    $result = mysql_query($query);

    while($value = mysql_fetch_array($result))
    {
        $queries[] = $value["query"];
    }

    foreach($queries as $queryVal)
    {
        $searchManualCable = CableManualClass::model()->searchCable($queryVal);

        if($searchManualCable)
        {
            $out[$searchManualCable["url_title"]] = $searchManualCable;
        }

        if(count($out)==5)
            break;
    }

    return $out;
}



function getLastQueries()
{
    $queries = array();
    //$query = "select * from sklad_query_stat where  query!='' and query IS NOT NULL AND time > DATE_ADD(now(), INTERVAL -31 DAY) and LENGTH(query) > 2 group by query ORDER BY results DESC LIMIT 10";
    $query = "SELECT * from sklad_query_stat LIMIT 100";

    $result = mysql_query($query);

    while($value = mysql_fetch_array($result))
    {
        if ( strlen($value["query"]) < 2 ) continue;
        $queries[trim($value["query"])] = trim($value["query"]);

        if(count($queries)==5)
            break;
    }

    return $queries;
}


?>