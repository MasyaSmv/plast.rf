<?php

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
    <link rel="stylesheet" href="/css/new_2_0/style.css?ver=0.0.1" type="text/css" media="only screen" />
    <link rel="stylesheet" href="/css/new/jquery.formstyler.css" type="text/css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/jquery.qtip.min.js"></script>
	<link rel="stylesheet" href="/js/jquery.qtip.min.css" type="text/css"/>

    <meta name="yandex-verification" content="9588331920659398" />

	<link href="//www.ruscable.ru/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,700,300&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/new/bootstrap.min.css?ver=0.0.1">

    <!-- Optional theme -->


    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script>
	$(document).ready(function () {
    $('.comments').qtip();

	});
	</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(35032, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/35032" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


    
	</head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P8SZK7X"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <div id="topline_b" class="banner_oth">
        <?
        if($showbanners){
            $zid=120;
            ?>

  <iframe id='a8005d36' name='a8005d36' src='//ruscable.su/www/delivery/afr.php?zoneid=120&amp;cb=6546854683456' frameborder='0' scrolling='no' width='100%' height='70'></iframe>





        <? } ?>
    </div>

	<?php
	include_once("./inc/banner_screenglide.inc");
	?>

    <div class="container-fluid <?php echo $containerClass; ?>">



