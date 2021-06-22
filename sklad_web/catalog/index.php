<?
mb_internal_encoding("UTF-8");
setlocale(LC_ALL, 'ru_RU.UTF-8');
include_once("../inc/func.inc");
@db_connect();

if($_GET['frominf']==1){
	setcookie("informer", str_replace("/catalog/","",$_SERVER['REDIRECT_URL']), time()+3600, "/", "sklad.ruscable.ru", 0, 1);
	$userfrom = preg_replace("/[^0-9]/","",$_SERVER['REDIRECT_URL']);
	$referer = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
	$q = "insert into sklad_informer_sources set user_id = $userfrom, referer='$referer', dateandtime=NOW()";
	@mysql_query($q);
	header("Location: ".$_SERVER['REDIRECT_URL']."/");
	exit;
}

$navpage="catalog";
$company=array();
$cities=array();
$page_dir="";
$dopurl="";
$ruri="";
$out="";
$symbol="";
$firtLevelMenuId=100;
$ruri2=strip_tags($_GET['uri']);
if(mb_detect_encoding($ruri1,"UTF-8, CP1251, ASCII")!="UTF-8"){
	$ruri2=mb_convert_encoding($ruri2,"UTF-8");
}

if(preg_match("{page([0-9]+)/?$}",$ruri2,$pp)){
	$page=$pp[1];
	$ruri2=mb_ereg_replace("page([0-9]+)/?","",$ruri2);
}else{
	$page=1;
}

$company_id=$company_link="";
preg_match("/(.*)-(\d+)/",$ruri2,$mt);
if(sizeof($mt)>0){
	$name=$mt[1];
	$cid=$mt[2];
	$szr=ssql("select count(*) from users where id=$cid and activ=1 limit 0,1");
	if($szr > 0){
		$company_id=$cid;
		$company_link="$name-$cid";
		$company_link2="$name-$cid/";
	}
	$ruri2=preg_replace("/(.*)-(\d+)/","",$ruri2);
}


$ruri2=mb_ereg_replace("/","",$ruri2);

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
$symb=array();
if($company_id > 0){
	$addq=" comp_id=$company_id";
}elseif($_SESSION['informer_comp_id'] > 0){
	$addq=" comp_id=".$_SESSION['informer_comp_id'];
}else{
	$addq=" 1";
}
$r2=sql("SELECT DISTINCT SUBSTR( title, 1, 1 ) AS firstsymbol FROM `sklad_tovar` WHERE $addq");
foreach($r2 as $rr2){
	list($fsymb)=$rr2;
	if(mb_ereg("[a-zA-Z0-9а-яА-Я]",$fsymb)){
		$symb[]=mb_convert_case($fsymb,MB_CASE_UPPER);
	}
}
if($ruri2!=""){
	if(!in_array($ruri2,$symb) && $company_id==""){
		header("Location: /catalog/");
		exit;
	}
}



$title_tag="Кабель  и провод из наличия  - СКЛАД :: Каталог :: ";
if($ruri2 != ""){$title_tag.="Марки кабеля, начинающиеся на $ruri2 :: ";}
$title_tag.="Страница $page";
if($start_pos<0){$start_pos=0;}

if($ruri2!=""){
	$adq=" and s.`title` like '$ruri2%' ";
}else{
	$adq="";
}

if($company_id != ""){
	$adq .= " and s.comp_id = $company_id ";
}elseif($_SESSION['informer_comp_id']>0){
	$adq .= " and s.comp_id = ".$_SESSION['informer_comp_id'];
}



if($curcity==""){
	$q = "select count(id) from sklad_tovar s where visible=1 $adq";
	$qraspr  = "select count(id) from sklad_tovar s where visible=1 $adq and sale = 1";
}else{
	$q = "select count(s.id) from sklad_tovar s,users u where s.comp_id=u.id and u.city='$curcity' and s.visible=1 $adq";
	$qraspr  = "select count(s.id) from sklad_tovar s,users u where s.comp_id=u.id and u.city='$curcity' and s.visible=1 $adq and sale = 1";
}
$count = ssql($q);
$pages_count = ceil($count / $perpage);
if ($page > $pages_count) $page = $pages_count;
$start_pos = (($page - 1) * $perpage);

$israspr = ssql($qraspr);

if(($authorized==1 && $free_searches > 0) || $authorized==2 ){
    $qq="SELECT distinct city FROM sklad_tovar s WHERE visible =1 and city!='' $adq ORDER BY city";
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


if($authorized===1){
    if($page==1){
        if($action11==0){
            @mysql_query("insert into sklad_free_access set c_id=$sklad_cid, vremya=NOW()");
        }
    }
}

$bestid = array();
$q2 = "select id from company where substr(uslugi, 1, 5) > 0";
$r2 = sql($q2);
foreach($r2 as $rr2){
    list($bid) = $rr2;
    $bestid[] = $bid;
}

$q1="select distinct s.comp_id, u.name, u.comp, u.city, u.company_id from sklad_tovar s, users u where s.comp_id=u.id order by s.comp_id";
$r1=sql($q1);
foreach($r1 as $rr1){
    list($c_id,$cname,$ctitle,$ccity, $ucid)=$rr1;
    if($ctitle==""){$ctitle=$cname;}
    $cusl = intval(substr($cusl,0,6));
    $company[$c_id]['title']=$ctitle;
    $sef=rus2lat($ctitle);
    $sef=preg_replace("/\s+/","-",$sef);
    //$sef=str_replace(" ","-",$sef);
    $sef=preg_replace("/[^a-zA-Z0-9-]/","",$sef);
    $sef=strtolower($sef);
    $sef.="-".$c_id;
    $company[$c_id]['sef']=$sef;
    $company[$c_id]['ucid']=$ucid;
    $ccity!=""? $company[$c_id]['city']=$ccity : $company[$c_id]['city']="не указан";
}


if($company_id > 0){
    $iscomp_name=ssql("select company_id from users where id=$company_id");
    if($iscomp_name > 0){
        $comp_name=ssql("select concat(forma_sob, ' ', title) from company where id=$iscomp_name");
    }else{
        $comp_name=ssql("select comp from users where id=$company_id");
        if($comp_name==""){
            $comp_name=ssql("select name from users where id=$company_id");
        }
    }
}



if($curcity==""){
	$q="select id, comp_id, title, quant, unit_id, comments,city from sklad_tovar s where visible=1 $adq order by title LIMIT $start_pos, $perpage";
}else{
	$q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, city from sklad_tovar s where city='$curcity' and s.visible=1 $adq order by s.title LIMIT $start_pos, $perpage";
}

$r=sql($q);
$szr=sizeof($r);

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

$containerClass = 'search';
include_once("../inc/header.inc");

?>
<style type="text/css">
    #topline_b {
        position: relative;
    }
</style>
<div id="main" class="row">
    <div class="container">
        <div class="col-md-12 top">
            <a href="/" class="logo" style="display: block;"></a>
            <div class="subtitle">Сервис для поиска кабельно-проводниковой продукции</div>
            <form class="top-form" id="search" action="/">
                <input name="" placeholder="Введите маркоразмер" type="text" value="<?php echo $ruri; ?>">
                <input type="submit" value="Найти">
            </form>
        </div>
    </div>
</div>
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
                       <?php if($comp_name!=""){ ?>
                           Вы смотрите позиции склада компании <a href='/spisok/<?php echo $company_link; ?>'><?php echo $comp_name; ?></a>
                       <?php }elseif($_SESSION['informer_comp_name']!=""){ ?>
                           Вы смотрите позиции склада компании <a href='/spisok/<?php echo $_COOKIE['informer']; ?>'><?php echo $_SESSION['informer_comp_name']; ?></a>
                       <?php } ?>
                        </div>
                       <?
							if($israspr > 0){
								echo "<b style='border: 2px solid #ff6600;margin-left: 5px;padding: 4px;background:#ff6600;color:#fff;'>Все позиции</b>&nbsp;&nbsp;&nbsp;";
								echo "<a href='/sale/$company_link' style='border: 2px solid #ff6600;margin-left: 5px;padding: 4px;'>Распродажа</a>";
							}
                       ?>

                        <div class="clear"></div>
                        <table>
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

                                $quant=str_replace(",",".",$quant);
                                if(!is_float($quant)){
                                    settype($quant,"float");
                                }

                                $quant=round($quant,4);
                                $quant=str_replace(".",",",$quant);

                                ?>

                                <tr>
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
                                <?php echo show_links($page,$perpage,$count,"/catalog/".$company[$comp_id]["sef"].$ruri."/",$dopurl); ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
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
                $(this).attr("used","yes").addClass("active");
                $.ajax({url: "/addtolist.php", data: "data-id=" + dataid, cache: false}).done(function(){
                    $(".my-list a").load('/addtolist.php', {'action':'get'});
                    $('#showlist .contentList').load('/addtolist.php', {'action':'getfullinfo'});
                });
            }
        });
        $(".my-list a").load('/addtolist.php', {'action':'get'});
        $('#showlist .contentList').load('/addtolist.php', {'action':'getfullinfo'});
        setTopMargin();
    });

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
        $(".md-modal").offset({ top: 100});
    }



</script>


<?php include_once("../inc/footer.inc"); ?>


<?php /*

mb_internal_encoding("UTF-8");
setlocale(LC_ALL, 'ru_RU.UTF-8');
include_once("../inc/func.inc");
@db_connect();

if($_GET['frominf']==1){
    setcookie("informer", str_replace("/catalog/","",$_SERVER['REDIRECT_URL']), time()+3600, "/", "sklad.ruscable.ru", 0, 1);
    $userfrom = preg_replace("/[^0-9]/","",$_SERVER['REDIRECT_URL']);
    $referer = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
    $q = "insert into sklad_informer_sources set user_id = $userfrom, referer='$referer', dateandtime=NOW()";
    @mysql_query($q);
    header("Location: ".$_SERVER['REDIRECT_URL']."/");
    exit;
}

$navpage="catalog";
$company=array();
$cities=array();
$page_dir="";
$dopurl="";
$ruri="";
$out="";
$symbol="";
$firtLevelMenuId=100;
$ruri2=strip_tags($_GET['uri']);
if(mb_detect_encoding($ruri1,"UTF-8, CP1251, ASCII")!="UTF-8"){
    $ruri2=mb_convert_encoding($ruri2,"UTF-8");
}

if(preg_match("{page([0-9]+)/?$}",$ruri2,$pp)){
    $page=$pp[1];
    $ruri2=mb_ereg_replace("page([0-9]+)/?","",$ruri2);
}else{
    $page=1;
}

$company_id=$company_link="";
preg_match("/(.*)-(\d+)/",$ruri2,$mt);
if(sizeof($mt)>0){
    $name=$mt[1];
    $cid=$mt[2];
    $szr=ssql("select count(*) from users where id=$cid and activ=1 limit 0,1");
    if($szr > 0){
        $company_id=$cid;
        $company_link="$name-$cid";
        $company_link2="$name-$cid/";
    }
    $ruri2=preg_replace("/(.*)-(\d+)/","",$ruri2);
}


$ruri2=mb_ereg_replace("/","",$ruri2);

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
$symb=array();
if($company_id > 0){
    $addq=" comp_id=$company_id";
}elseif($_SESSION['informer_comp_id'] > 0){
    $addq=" comp_id=".$_SESSION['informer_comp_id'];
}else{
    $addq=" 1";
}
$r2=sql("SELECT DISTINCT SUBSTR( title, 1, 1 ) AS firstsymbol FROM `sklad_tovar` WHERE $addq");
foreach($r2 as $rr2){
    list($fsymb)=$rr2;
    if(mb_ereg("[a-zA-Z0-9а-яА-Я]",$fsymb)){
        $symb[]=mb_convert_case($fsymb,MB_CASE_UPPER);
    }
}
if($ruri2!=""){
    if(!in_array($ruri2,$symb) && $company_id==""){
        header("Location: /catalog/");
        exit;
    }
}



$title_tag="Кабель  и провод из наличия  - СКЛАД :: Каталог :: ";
if($ruri2 != ""){$title_tag.="Марки кабеля, начинающиеся на $ruri2 :: ";}
$title_tag.="Страница $page";
if($start_pos<0){$start_pos=0;}

if($ruri2!=""){
    $adq=" and s.`title` like '$ruri2%' ";
}else{
    $adq="";
}

if($company_id != ""){
    $adq .= " and s.comp_id = $company_id ";
}elseif($_SESSION['informer_comp_id']>0){
    $adq .= " and s.comp_id = ".$_SESSION['informer_comp_id'];
}

if($curcity==""){
    $q="select count(id) from sklad_tovar s where visible=1 $adq";
}else{
    $q="select count(s.id) from sklad_tovar s,users u where s.comp_id=u.id and u.city='$curcity' and s.visible=1 $adq";

}
$count = ssql($q);
$pages_count = ceil($count / $perpage);
if ($page > $pages_count) $page = $pages_count;
$start_pos = (($page - 1) * $perpage);

if($curcity==""){
    $q="select id, comp_id, title, quant, unit_id, comments,city from sklad_tovar s where visible=1 $adq order by title LIMIT $start_pos, $perpage";
}else{
    $q="select s.id, s.comp_id, s.title, s.quant, s.unit_id, s.comments, city from sklad_tovar s where city='$curcity' and s.visible=1 $adq order by s.title LIMIT $start_pos, $perpage";
}

$r=sql($q);
$szr=sizeof($r);

if($szr==0){
    $out="Склад пуст. Всё закончилось. Приходите завтра.";
}else{
    $out="<table width=100% ><tr><td width=40%>Найдено: $count ".okonch($count,"товар")." на $pages_count ".  okonch($pages_count,"страница");
    if($adq!=""){
        $out.=" <a href=/catalog/$company_link2>сбросить</a>";
    }

    $out.="</td><td style='text-align:left;width:30%;'>Фильтрация по первой букве <a href=/catalog/$company_link2>сбросить</a></td></tr></table>";
    $out.="</td>";

    $out .= "</tr></table>";
    $out.="<table width=100%><tr><td width=40%>";
    if ($pages_count >1){
        $out.= '<p><div class="pagination">';
        if($ruri2!="" || $company_link !=""){$link="/catalog/$company_link/$ruri2/";}else{$link="/catalog/";}
        $out.=show_links($page,$perpage,$count,$link,$dopurl);
        $out.='</div></p>';
    }else{
        $out.="&nbsp;";
    }
    $out.="</td><td width=60%>";
    $out2='<p><div class="paginationsm">';
    foreach($symb as $sym){
        if($ruri2==$sym){
            $out2.="<span class='current'>$sym</span>";
        }else{
            $out2.='<a href="/catalog/'.$company_link2.$sym.'/';
            if($page>1){$out2.="page$page/"; }
            $out2.='" class="page" title="Найти марки кабеля, начинающиеся на '.$sym.'">'.$sym.'</a>';
        }
    }
    $out2.='</div></p>';
    $out.=$out2;
    $out.="</td></tr></table>";

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

        $bestid = array();
        $q2 = "select id from company where substr(uslugi, 1, 5) > 0";
        $r2 = sql($q2);
        foreach($r2 as $rr2){
            list($bid) = $rr2;
            $bestid[] = $bid;
        }

        $q1="select distinct s.comp_id, u.name, u.comp, u.city, u.company_id from sklad_tovar s, users u where s.comp_id=u.id order by s.comp_id";


        $r1=sql($q1);
        foreach($r1 as $rr1){
            list($c_id,$cname,$ctitle,$ccity, $ucid)=$rr1;
            if($ctitle==""){$ctitle=$cname;}
            $cusl = intval(substr($cusl,0,6));
            $company[$c_id]['title']=$ctitle;
            $sef=rus2lat($ctitle);
            $sef=preg_replace("/\s+/","-",$sef);
            //$sef=str_replace(" ","-",$sef);
            $sef=preg_replace("/[^a-zA-Z0-9-]/","",$sef);
            $sef=strtolower($sef);
            $sef.="-".$c_id;
            $company[$c_id]['sef']=$sef;
            $company[$c_id]['ucid']=$ucid;
            $ccity!=""? $company[$c_id]['city']=$ccity : $company[$c_id]['city']="не указан";
        }
    }
    $comp_name="";
    if($company_id > 0){
        $iscomp_name=ssql("select company_id from users where id=$company_id");
        if($iscomp_name > 0){
            $comp_name=ssql("select concat(forma_sob, ' ', title) from company where id=$iscomp_name");
        }else{
            $comp_name=ssql("select comp from users where id=$company_id");
            if($comp_name==""){
                $comp_name=ssql("select name from users where id=$company_id");
            }
        }
    }
    $adtitle="";
    if($comp_name!=""){
        $adtitle="<h1>Вы смотрите позиции склада компании <a href='/spisok/$company_link'>$comp_name</a></h1>";
    }elseif($_SESSION['informer_comp_name']!=""){
        $adtitle="<h1>Вы смотрите позиции склада компании <a href='/spisok/".$_COOKIE['informer']."'>".$_SESSION['informer_comp_name']."</a></h1>";
    }
    $out.=
        $adtitle. '
		<div class="item"><table width="100%" ><tr><td width="40%" style="border-bottom: 1px solid #929292;">';
    if($authorized > 0){
        $out.= "<div id='note' style='float:right;margin: 2px 10px 0px 0px'></div>";
    }

}


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

*/ ?>