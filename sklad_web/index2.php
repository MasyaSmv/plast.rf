<?php

include_once("inc/func.inc");

$bnbn=intval(file_get_contents("/home/ruscableru/ruscableru/www/admin2/banners/show.txt"));
if($bnbn==0){
    $showbanners = false;
}else{
    $showbanners = true;
}

if(!$title_tag){
    $title_tag="RusCable.Ru :: Склад";
}


?>
<!DOCTYPE html>
<html xmlns="//www.w3.org/1999/xhtml">
<head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P8SZK7X');</script>
    <!-- End Google Tag Manager -->


	<title><?=$title_tag?></title>
	<meta name="description" content=" <?=$metadescription?> ">
    <meta charset="utf-8">
	<meta name="ROBOTS" content="ALL" />
	<meta name="COPYRIGHT" content="Copyright © <?=date("Y")?> RusCable.Ru" />
	<meta name="description" content="Сервис, созданный для эффективного и быстрого поиска кабельно-проводниковой продукции из наличия. Размещение складских остатков для поставщиков - абсолютно бесплатно." />
	<meta name="keywords" content="провод кабель наличие ввг ввгнг кввг аабл асб аашв 3х240" />
	<meta property='og:title' content='<?=$title_tag?>'/>
	<meta property='og:image' content='//sklad.ruscable.ru/img/sklad_social.png'/>
    <link rel="stylesheet" href="/css/new/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/new/lightbox.css" type="text/css" media="only screen" />
    <link rel="stylesheet" href="/css/new/style.css" type="text/css" media="only screen" />
    <link rel="stylesheet" href="/css/new/jquery.formstyler.css" type="text/css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>



	<link href="//www.ruscable.ru/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,700,300&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/new/bootstrap.min.css">

    <!-- Optional theme -->


    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	</head>
    <body onload="init();">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P8SZK7X"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <div id="topline_b" class="banner_oth">
        <?
        if($showbanners){
            $zid=120;
            ?>


<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://ruscable.su/www/delivery/ajs.php':'http://ruscable.su/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=120");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='//ruscable.su/www/delivery/ck.php?n=a8005d36&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='//ruscable.su/www/delivery/avw.php?zoneid=120&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a8005d36' border='0' alt='' /></a></noscript>





        <? } ?>
    </div>









