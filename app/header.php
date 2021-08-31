<?
    require_once 'include/functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
	<link href="public/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="wrapper">
		<div class="header">
			<div class="headerContent">
				<div class="left">
					<h1 class="head-h1"><a href="#">Пластикат.РФ</a></h1>
					<p>Все о кабельны хполимерах</p>
				</div>
				<div class="right">
					<form class="search">
						<input type="text" placeholder="Search...">
						<input type="image" src="public/images/search.png" title="Search">
					</form>
				</div>
			</div>
		</div>
		<div class="slider">
			<div class="itemSlider">
				<div class="bgSlide"><img src="public/images/bg-slide.jpg" class="bg-slide">
					<div class="bgSlide shadow">
					</div>
				</div>
				<div class="descSlide">
					<h1 class="head-h1">Пластикаты.РФ</h1>
					<p>или все о кабельных полимерах</p>
					<span>Здесь вы узнаете...</span>
					<p>Любые новости связанные с пластикатами, всю необходимую литературу, каталог компаний по выпуску
						пластикатов, справочник пластикатов и тп.</p>
				</div>
			</div>
		</div>
		<div class="nav">
			<ul class="menu">
				<li><a href="/news/index.php">Новости</a></li>
				<li><a href="#">Каталог компаний</a></li>
				<li><a href="guide.php">Справочник</a></li>
				<li><a href="#">Стандарты/ГОСТы</a></li>
				<li><a href="#">Литература</a></li>
				<li><a href="../index.php">О проекте</a></li>
			</ul>
		</div>
