<div id="main" class="row">
    <div class="container">
        <div class="col-md-12 top">
            <div class="logo" style="display: block;">
                <a href="/" class="sklad"></a>
                <a href="//www.ruscable.ru" class="baseSite"></a>
            </div>
            <div style="clear: both;"></div>
            <div class="subtitle"><p>Сервис для поиска кабельно-проводниковой продукции</p></div>
            <form class="top-form" id="search" class="search">
                <input type="text" placeholder="Введите маркоразмер">
                <input type="submit" value="Найти">
                <div class="result">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row gray-back">
    <div class="profile-block">
        <?php if($authorized > 0)
        {

            $str_end_date=date("d.m.Y г.",strtotime($end_date));
            if($authorized===1){
                if($action11)
                {
                ?>
                    <p>
                        <strong>Акция &laquo;11 с половиной минут свободного поиска&raquo;</strong><br />
                        С 11:00 до 11:12, Вы имеете возможность осуществить неограниченное количество поисков.
                    </p>
                <?php
                }
                elseif($sklad_cid)
                { ?>
                    <div class="avatar" style="background:url(./img/new/avatar.png);"></div>
                    <a href="//www.ruscable.ru/users/" style="color: white;text-decoration: none;" class="username"><?php echo $_SESSION['s_name']; ?></a>
                    <p>
                        Тариф: Базовый ( поисков <?php echo $free_searches; ?>)<br>
                        Срок действия: до <?php echo  $str_end_date; ?>
                    </p>

                <?php
                }
                else
                {
                ?>
                    <p>
                        Для просмотра позиций по базовому тарифу добавьте данные вашей компании в личном кабинете. После проверки данных базовый тариф будет включен Вам автоматически.
                    </p>

                <?php
                }
            }
            elseif($authorized===2)
            { ?>


                <div class="avatar" style="background:url(./img/new/avatar.png);"></div>
                <a href="//www.ruscable.ru/users/" style="color: white;text-decoration: none;" class="username"><?php echo $_SESSION['s_name']; ?></a>

                <p>
                    Тариф «Безлимитный» (неограниченный поиск)<br>
                    <?//Срок действия: до <?php echo  $str_end_date;
                    ?>
                </p>


            <?php
            }
        }
        elseif($sklad_uid > 0 && ($sklad_cid=="" || $sklad_cid==0))
        {
        ?>
            <p>
                Для получения доступа по Базовому тарифу, пожалуйста,<br>
                <div class="specHref"><a href='//www.ruscable.ru/users/company.html'> добавьте данные о компании<br>в профиле пользователя</a></div>
            </p>
        <?php
        }
        else
        { ?>
            <p style="text-align: center;">
               Для начала работы, пожалуйста, <a href="//www.ruscable.ru/users/" class="loginLink"  data-toggle="modal" data-target="#authModal" style="color:white;">войдите</a> или <a href="//www.ruscable.ru/users/registr.html"  style="color:white;">зарегистрируйтесь</a>
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
            </div>
        <?php } ?>
    </div>
        <div style="position: relative; top: -50px; height: 0px; width:500px; margin: 0px auto; text-align: center;">
            <a href="https://itunes.apple.com/ru/app/rc-sklad/id898735516" target="_blank" style="width: 150px; background:url(//www.ruscable.ru/MobileApps/images/appStore.png); display: inline-block; height: 50px; margin-right: 7px;"></a>
            <!--<a href="https://play.google.com/store/apps/details?id=ru.ruscable.RC_sklad" target="_blank" style="width: 150px; background:url(//www.ruscable.ru/MobileApps/images/google-play.png);display: inline-block; height: 50px; margin-top: 20px;"></a>-->
        </div>
    <div class="container">
        <div class="col-md-12">
            <div class="row" style="margin-top:30px;">
                <div class="col-md-6">
                    <a href="/pokupatelu" style="display: block;" class="caption">ДЛЯ ПОКУПАТЕЛЯ КПП</a>
                    <a href="/pokupatelu" class="krug-image" style="display:none;background:url(./img/new/krug1.png);"></a>
                    <p>

                        Если вы хотите найти кабель и/или провод в наличии на складе сначала
                         пройдите <a href="//www.ruscable.ru/users/registr.html">регистрацию</a>.
                          Затем <a href="//www.ruscable.ru/users/">войдите</a> на сервис Склад под своим логином.
                          С 31 августа 2018 года при поддержке компаний "Москабельмет", "КабельСтар" и "Подольсккабель"
                          доступ к поиску для всех пользователей сервиса осуществляется бесплатно.

                          <? //Бесплатно вы можете сделать 3 поиска. Для продолжения  -  <a href="//sklad.ruscable.ru/pokupatelu#tarif">выберите тариф</a> на неограниченное количество поисков не только для вас, но и для всех сотрудников вашей компании
                          ?>

                    </p>
                </div>
                <div class="col-md-6">
                    <a href="/prodavcu" style="display: block;" class="caption">ДЛЯ ПРОДАВЦА КПП</a>
                    <a href="/prodavcu" class="krug-image" style="display:none;background:url(./img/new/krug2.png);"></a>
                    <p>
                        У вашей компании есть в наличии кабель и провод, который вы хотите реализовать?
                        Бесплатно разместим вашу складскую справку, если вы пришлете ее на <a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a> или оставите в <a href="//www.ruscable.ru/users/">вашем личном кабинете</a>. Обратите внимание на <a href="//sklad.ruscable.ru/prodavcu">советы</a> при формировании справки
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="//api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
    <script type="text/javascript">
        var myMap;


        ymaps.ready(function(){
            myMap = new ymaps.Map("map", {
                center: [61.57105915, 99.77110667],
                behaviors: ['default'],
                zoom: 3
            });


            myMap.controls
                .add('zoomControl', { left: 5, top: 5 })
                .add('typeSelector')
                .add('mapTools', { left: 35, top: 5 })
                .add('searchControl');

            myMap.behaviors.disable('scrollZoom');

            var iconOptions = {
                iconImageHref: "/img/map_icon.png",
                iconImageSize: [30, 34],
                iconImageOffset: [0, 0]
            };

            myPlacemark1 = new ymaps.Placemark([64.56839038, 40.55718800], {}, iconOptions);
            myPlacemark2 = new ymaps.Placemark([51.15181486, 71.48300800], {}, iconOptions);
            myPlacemark3 = new ymaps.Placemark([48.65054724, 44.47330800], {}, iconOptions);
            myPlacemark4 = new ymaps.Placemark([59.22556174, 39.88022200], {}, iconOptions);
            myPlacemark5 = new ymaps.Placemark([51.69427264, 39.33576650], {}, iconOptions);
            myPlacemark6 = new ymaps.Placemark([55.29840941, 38.71147800], {}, iconOptions);
            myPlacemark7 = new ymaps.Placemark([58.58292083, 49.57085650], {}, iconOptions);
            myPlacemark8 = new ymaps.Placemark([56.78875630, 60.60339450], {}, iconOptions);
            myPlacemark9 = new ymaps.Placemark([57.00861008, 40.99670700], {}, iconOptions);
            myPlacemark10 = new ymaps.Placemark([56.85577004, 53.20128550], {}, iconOptions);
            myPlacemark11 = new ymaps.Placemark([55.77014476, 49.10252450], {}, iconOptions);
            myPlacemark12 = new ymaps.Placemark([54.70453943, 20.47379150], {}, iconOptions);
            myPlacemark13 = new ymaps.Placemark([54.53378530, 36.23689800], {}, iconOptions);
            myPlacemark14 = new ymaps.Placemark([58.58292083, 49.57085650], {}, iconOptions);
            myPlacemark15 = new ymaps.Placemark([56.30129406, 39.36727900], {}, iconOptions);
            myPlacemark16 = new ymaps.Placemark([45.05936976, 38.99970700], {}, iconOptions);
            myPlacemark17 = new ymaps.Placemark([56.02278829, 92.89742450], {}, iconOptions);
            myPlacemark18 = new ymaps.Placemark([51.71761064, 36.18174150], {}, iconOptions);
            myPlacemark19 = new ymaps.Placemark([58.10723235, 57.80040800], {}, iconOptions);
            myPlacemark20 = new ymaps.Placemark([55.67955220, 37.90909850], {}, iconOptions);
            myPlacemark21 = new ymaps.Placemark([53.85317629, 34.44536500], {}, iconOptions);
            myPlacemark22 = new ymaps.Placemark([55.72479891, 37.64696100], {}, iconOptions);
            myPlacemark23 = new ymaps.Placemark([55.93755582, 37.36759400], {}, iconOptions);
            myPlacemark24 = new ymaps.Placemark([55.84632751, 37.17210250], {}, iconOptions);
            myPlacemark25 = new ymaps.Placemark([56.28765400, 43.85762950], {}, iconOptions);
            myPlacemark26 = new ymaps.Placemark([48.63743015, 35.22550700], {}, iconOptions);
            myPlacemark27 = new ymaps.Placemark([55.00081759, 82.95627700], {}, iconOptions);
            myPlacemark28 = new ymaps.Placemark([55.86248397, 38.44345200], {}, iconOptions);
            myPlacemark29 = new ymaps.Placemark([55.10013891, 36.59999650], {}, iconOptions);
            myPlacemark30 = new ymaps.Placemark([50.35547559, 37.70163250], {}, iconOptions);
            myPlacemark31 = new ymaps.Placemark([52.29768440, 76.97028100], {}, iconOptions);
            myPlacemark32 = new ymaps.Placemark([58.02265172, 56.22860350], {}, iconOptions);
            myPlacemark33 = new ymaps.Placemark([55.43755409, 37.53963450], {}, iconOptions);
            myPlacemark34 = new ymaps.Placemark([55.76361722, 37.86589800], {}, iconOptions);
            myPlacemark35 = new ymaps.Placemark([47.25221300, 39.69359700], {}, iconOptions);
            myPlacemark36 = new ymaps.Placemark([53.24442141, 50.19907950], {}, iconOptions);
            myPlacemark37 = new ymaps.Placemark([59.91815364, 30.30557800], {}, iconOptions);
            myPlacemark38 = new ymaps.Placemark([54.15786812, 45.17444300], {}, iconOptions);
            myPlacemark39 = new ymaps.Placemark([43.70903108, 39.74489050], {}, iconOptions);
            myPlacemark40 = new ymaps.Placemark([56.50697995, 84.97990300], {}, iconOptions);
            myPlacemark41 = new ymaps.Placemark([54.72865424, 56.03041250], {}, iconOptions);
            myPlacemark42 = new ymaps.Placemark([48.46897578, 135.11297400], {}, iconOptions);
            myPlacemark43 = new ymaps.Placemark([56.10124032, 47.27209450], {}, iconOptions);
            myPlacemark44 = new ymaps.Placemark([55.16418663, 61.39170200], {}, iconOptions);

            myMap.geoObjects.add(myPlacemark1);
            myMap.geoObjects.add(myPlacemark2);
            myMap.geoObjects.add(myPlacemark3);
            myMap.geoObjects.add(myPlacemark4);
            myMap.geoObjects.add(myPlacemark5);
            myMap.geoObjects.add(myPlacemark6);
            myMap.geoObjects.add(myPlacemark7);
            myMap.geoObjects.add(myPlacemark8);
            myMap.geoObjects.add(myPlacemark9);
            myMap.geoObjects.add(myPlacemark10);
            myMap.geoObjects.add(myPlacemark11);
            myMap.geoObjects.add(myPlacemark12);
            myMap.geoObjects.add(myPlacemark13);
            myMap.geoObjects.add(myPlacemark14);
            myMap.geoObjects.add(myPlacemark15);
            myMap.geoObjects.add(myPlacemark16);
            myMap.geoObjects.add(myPlacemark17);
            myMap.geoObjects.add(myPlacemark18);
            myMap.geoObjects.add(myPlacemark19);
            myMap.geoObjects.add(myPlacemark20);
            myMap.geoObjects.add(myPlacemark21);
            myMap.geoObjects.add(myPlacemark22);
            myMap.geoObjects.add(myPlacemark23);
            myMap.geoObjects.add(myPlacemark24);
            myMap.geoObjects.add(myPlacemark25);
            myMap.geoObjects.add(myPlacemark26);
            myMap.geoObjects.add(myPlacemark27);
            myMap.geoObjects.add(myPlacemark28);
            myMap.geoObjects.add(myPlacemark29);
            myMap.geoObjects.add(myPlacemark30);
            myMap.geoObjects.add(myPlacemark31);
            myMap.geoObjects.add(myPlacemark32);
            myMap.geoObjects.add(myPlacemark33);
            myMap.geoObjects.add(myPlacemark34);
            myMap.geoObjects.add(myPlacemark35);
            myMap.geoObjects.add(myPlacemark36);
            myMap.geoObjects.add(myPlacemark37);
            myMap.geoObjects.add(myPlacemark38);
            myMap.geoObjects.add(myPlacemark39);
            myMap.geoObjects.add(myPlacemark40);
            myMap.geoObjects.add(myPlacemark41);
            myMap.geoObjects.add(myPlacemark42);
            myMap.geoObjects.add(myPlacemark43);
            myMap.geoObjects.add(myPlacemark44);
        });


    </script>
    <div class="container pt-3">
        <div class="col-md-12">
            <div class="row">
                <h3 class="text-center">ГЕОГРАФИЯ РАЗМЕЩЕНИЯ СКЛАДОВ</h3>
                <div id="map" style="height:400px; margin-bottom:40px; border:1px gray solid;">
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .slider-wraper ul li img {
        width:140px;
    }

    .slider-wraper ul li .leter-item {
        line-height: 115px;
    }
</style>
<div class="row white slider">
    <div class="container">
      <div class="head">В настоящий момент в базе сервиса <b><?php echo $statSklad; ?></b> <?php echo pluralForm($n, "товар", "товара", "товаров"); ?> и <b><?php echo $statProvider; ?></b> <?php echo pluralForm($n, "склад", "склада", "складов"); ?></div>
       <!--  <div class="col-md-12">
            <div class="leters">
                <div class="slider-wraper" id="leters-carousel">
                    <ul >
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/1.jpg" data-lightbox="leters">
                                    <img src="./img/companies/1.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/3.jpg" data-lightbox="leters">
                                    <img src="./img/companies/3.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/4.jpg" data-lightbox="leters">
                                    <img src="./img/companies/4.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/5.gif" data-lightbox="leters">
                                    <img src="./img/companies/5.gif">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/7.jpg" data-lightbox="leters">
                                    <img src="./img/companies/7.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/8.gif" data-lightbox="leters">
                                    <img src="./img/companies/8.gif">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/10.PNG" data-lightbox="leters">
                                    <img src="./img/companies/10.PNG">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/11.jpg" data-lightbox="leters">
                                    <img src="./img/companies/11.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/12.png" data-lightbox="leters">
                                    <img src="./img/companies/12.png">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/14.jpg" data-lightbox="leters">
                                    <img src="./img/companies/14.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/15.jpg" data-lightbox="leters">
                                    <img src="./img/companies/15.jpg">
                                </a>
                            </div>
                        </li>

                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/17.png" data-lightbox="leters">
                                    <img src="./img/companies/17.png">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/18.jpg" data-lightbox="leters">
                                    <img src="./img/companies/18.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/19.png" data-lightbox="leters">
                                    <img src="./img/companies/19.png">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/20.jpg" data-lightbox="leters">
                                    <img src="./img/companies/20.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/21.jpg" data-lightbox="leters">
                                    <img src="./img/companies/21.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/22.jpg" data-lightbox="leters">
                                    <img src="./img/companies/22.jpg">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/23.gif" data-lightbox="leters">
                                    <img src="./img/companies/23.gif">
                                </a>
                            </div>
                        </li>
                        <li class="slide-wrap">
                            <div class="leter-item">
                                <a href="./img/companies/24.gif" data-lightbox="leters">
                                    <img src="./img/companies/24.gif">
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="form3" class="leters-controls">
                    <a class="leters-prev" href="#"></a>
                    <a class="leters-next" href="#"></a>
                </div>
            </div>
        </div> -->
    </div>
    <hr>
    <div class="container">
        <div class="cel" style="font-weight: bold;">ЦЕЛЬ СЕРВИСА</div>
        <div class="col-md-12">
            <p class="cel-text" style="font-size: 17px;">
                Цель сервиса — предоставить потребителям самую актуальную
                и достоверную информацию. Это в интересах каждой из сторон, присутствующих на СКЛАД.RusCable.Ru
            </p>
        </div>
    </div>
</div>
<div class="row blue-back">
    <div class="head">МЕХАНИЗМ РАБОТЫ</div>
    <div class="container">
        <div class="col-md-12">
            <div class="row" style="margin-top:35px;">
                <div class="col-md-6">
                    <p class="square">
                        Любой поставщик КПП, зарегистрированный
                        на портале  RC, может бесплатно разместить складскую справку (через личный кабинет или направив на <a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a> и попасть в общую базу данных сервиса
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="square">
                        Любой покупатель КПП, зарегистрированный
                        на портале  RC, может искать кабель и провод по всей базе сервиса, формировать заявку и отправлять поставщику, осуществлять расчет веса и схему размещения продукции в авто
                        и ж/д транспорте
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p style="padding-left:30px;">
                        Поступающая в систему информация от поставщиков КПП обновляется в течение одного рабочего дня.
                        После размещения на указанный контактный e-mail поставщика поступает автоматическое подтверждение
                        о размещении. Дальнейшие оповещения и уведомления от системы также приходят на указанный
                        при регистрации поставщиком адрес.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row whiteblock instrum">
    <div class="container">
        <div class="head">
            ДОПОЛНИТЕЛЬНЫЕ ИНСТРУМЕНТЫ<br>
            СЕРВИСА СКЛАД.RUSCABLE.RU
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:40px;">
                <div class="col-md-6">
                    <div class="orange-icon" style="background:url(./img/new/icon1.png);"></div>
                    <div class="caption">МОЙ СПИСОК</div>
                    <div class="desc">
                        Начните использовать эту простую и удобную функцию для оформления заявки поставщику прямо сейчас! Отметьте несколько нужных позиций, нажмите «Мой список» и готовый заказ можно отправить, распечатать или сохранить.
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="orange-icon" style="background:url(./img/new/icon2.png);"></div>
                    <div class="caption">ИНФОРМЕР</div>
                    <div class="desc">
                        «Склад on-line» — это виджет для Вашего корпоративного сайта. Это краткая справка о состоянии вашего складского наличия в реальном времени. Установка информера – бесплатна. Код для установки находится в одноименном разделе <a href="//www.ruscable.ru/users/sklad_informer.html">Вашего Личного кабинета</a>.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="//www.ruscable.ru/info/ves/" class="orange-icon" style="display:block;background:url(./img/new/icon3.png);"></a>
                    <a href="//www.ruscable.ru/info/ves/" style="display: block;" class="caption">ВЕС КАБЕЛЯ</a>
                    <div class="desc">
                        Рассчитать вес всей заявки или отдельной марки зная количество&nbsp;— легко! Перейдите на сервис <a href="//www.ruscable.ru/info/ves/">ВЕС КАБЕЛЯ</a> и произведите расчет за секунды. Кроме того, если искомая продукция есть на складах поставщиков СКЛАД.RusCable.Ru, сервис даст вам знать.
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="//www.ruscable.ru/info/tara/" class="orange-icon" style="display:block;background:url(./img/new/icon4.png);"></a>
                    <a href="//www.ruscable.ru/info/tara/" style="display: block;" class="caption">СХЕМА ПОГРУЗКИ</a>
                    <div class="desc">
                        Узнать какой транспорт подойдет для перевозки вашей продукции можно прямо сейчас. Выберите количество кабеля и тип тары и программа поможет в выборе оптимальной схемы размещения в кузове автомобиля или контейнере. <a href="//www.ruscable.ru/info/tara/">Схему</a> можно сохранить, переслать, распечатать.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="//www.ruscable.ru/MobileApps/" class="orange-icon" style="display:block;background:url(./img/new/icon5.png);"></a>
                    <a href="//www.ruscable.ru/MobileApps/" style="display: block;" class="caption">МОБИЛЬНЫЕ ПРИЛОЖЕНИЯ</a>
                    <div class="desc">
                        «<a href="https://itunes.apple.com/ru/app/rc-sklad/id898735516">RC Склад</a>» — третье мобильное приложение от RusСable.Ru доступно в AppStore. Удобный формат и простой функционал сервиса СКЛАД в Вашем гаджете. Какие еще приложения разработаны можно посмотреть <a href="//www.ruscable.ru/MobileApps/">здесь</a>.
                    </div>
                </div>
                    <div class="col-md-6">
                    <a href="//www.ruscable.ru/info/sign" class="orange-icon" style="display:block;background:url(./img/new/icon7.png);"></a>
                    <a href="//www.ruscable.ru/info/sign" style="display: block;" class="caption">РАСШИФРОВКА КАБЕЛЯ</a>
                    <div class="desc">
                        Уточнить что значит марка кабеля теперь просто! Для этого просто перейдите <a href="//www.ruscable.ru/info/sign">на страницу сервиса</a> и наберите нужную марку.
                    </div>
                </div>
            </div>
            <div class="row">
                            <div class="col-md-6">
                    <div class="orange-icon" style="background:url(./img/new/icon6.png);"></div>
                    <div class="caption">НОВОСТИ СЕРВИСА</div>
                    <div class="desc">
                        Новый формат сервиса СКЛАД. Что нового подробнее в <a href="//www.ruscable.ru/news/2014/10/12/Servis_SKLAD_Sleduya_trebovaniyam_vremeni/">релизе</a> на RusCable.
                    </div>
                </div>
                    <div class="col-md-6">
                    <a href="//tenders.ruscable.ru/" class="orange-icon" style="display:block;background:url(./img/new/icon8.png);"></a>
                    <a href="//tenders.ruscable.ru/" style="display: block;" class="caption">ТЕНДЕРЫ</a>
                    <div class="desc">
                        <a href="//tenders.ruscable.ru/">Сервис «Тендеры»</a> предоставляет площадку для размещения заявок о покупке кабельно-проводниковой продукции и механизма моментального ответа на предложение со стороны продавцов.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gray2-back preimushestva">
    <div class="container">
        <div class="head">
            ПРЕИМУЩЕСТВА СЕРВИСА СКЛАД.RUSCABLE.RU
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:40px;">
                <div class="col-md-6">
                    <ul>
                        <li>Самая широкая аудитория по кабельному профилю</li>
                        <li>Вся информация по наличию поступает исключительно напрямую от поставщиков</li>
                        <li>Размещение складских остатков в системе&nbsp;&ndash; бесплатно</li>
                        <li>Доступ к сервису с мобильного устройства через <a href="//www.ruscable.ru/MobileApps/" target="_blank">мобильное приложение</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li>Простота и удобство использования</li>
                        <li>Возможность установки информера «<a href="//www.ruscable.ru/users/sklad_informer.html" target="_blank"><span style="white-space: nowrap;">Склад on-line</span></a>» для корпоративных сайтов</li>
                        <li>Неограниченный доступ к поиску
                        <? //всего за <a href="//sklad.ruscable.ru/pokupatelu">1 798&nbsp;рублей в&nbsp;месяц</a>
                        ?>
                        </li>
                        <li>Взаимосвязь с другими сервисами портала RusCable.Ru: <a href="//www.ruscable.ru/info/cable/" target="_blank">Справочник</a>, <a href="//tenders.ruscable.ru/" target="_blank">Тендеры</a>, <a href="//market.ruscable.ru/" target="_blank">Маркет</a>, <a href="//www.ruscable.ru/board/" target="_blank">Объявления</a>, <a href="//www.ruscable.ru/interactive/forum/" target="_blank">Форум</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row whiteblock">
    <div class="container">
        <div class="head" style="margin-top: 40px;">
            ДАННЫЕ О РАБОТЕ СЕРВИСА
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:30px;">
                <div class="col-md-2">
                    <div class="orange"><b>2011</b> год</div>
                    <p>
                        Начало работы
                    </p>
                </div>
                <div class="col-md-2">
                    <div class="orange"><b><?php echo $statUsers; ?></b></div>
                    <p>
                        пользователей
                    </p>
                </div>
                <div class="col-md-2">
                    <div class="orange"><b><?php echo $statProvider; ?></b></div>
                    <p>
                        Поставщиков<br>
                        складов
                    </p>
                </div>
                <?php if(count($markStat) > 0) { $dubleMarkStat = $markStat; $markStatOne = array_shift($dubleMarkStat); }?>
                <div class="col-md-2">
                    <div class="orange"><b><?php echo isset($markStatOne) ? $markStatOne["mark"] : "СИП"; ?></b></div>
                    <p>
                        Лидер в поиске
                    </p>
                </div>
                <div class="col-md-2">
                    <div class="orange"><b>5 000</b></div>
                    <p>
                        Запросов в день <br>
                        в среднем
                    </p>
                </div>
                <div class="col-md-2">
                    <div class="orange"><b>6 000</b></div>
                    <p>
                        Посещений сервиса<br>
                        в день
                    </p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="head" style="margin-top: 40px;">
            ЧАЩЕ ВСЕГО ИЩУТ
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:30px;">
                <div class="col-md-2" style="width:20%;">
                        <p>
                            <a href="//www.ruscable.ru/info/wire/mark/petv/" target="_blank">ПЭТВ</a>
                        </p>
                    </div>
                                    <div class="col-md-2" style="width:20%;">
                        <p>
                            <a href="//www.ruscable.ru/info/wire/mark/vvg/" target="_blank">ВВГ</a>
                        </p>
                    </div>
                                    <div class="col-md-2" style="width:20%;">
                        <p>
                            <a href="//www.ruscable.ru/info/wire/mark/vvgng/" target="_blank">ВВГнг</a>
                        </p>
                    </div>
                                    <div class="col-md-2" style="width:20%;">
                        <p>
                            <a href="//www.ruscable.ru/info/wire/mark/kvvg/" target="_blank">КВВГ</a>
                        </p>
                    </div>
                                    <div class="col-md-2" style="width:20%;">
                        <p>
                            <a href="//www.ruscable.ru/info/wire/mark/kvvge/" target="_blank">КВВГЭ</a>
                        </p>
                    </div>
                <?/*php foreach($markStat as $markVal) { ?>
                    <div class="col-md-2" style="width:20%;">
                        <p>
                            <a href="//www.ruscable.ru/info/wire/mark/<?php echo $markVal["url_title"]; ?>/" target="_blank"><?php echo $markVal["mark"]; ?></a>
                        </p>
                    </div>
                <?php } */?>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="head" style="margin-top: 40px;">
            ПОСЛЕДНИЕ 5 ЗАПРОСОВ
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:30px;">
                <?php foreach($lastQueries as $lastQuery) { ?>
                    <div class="col-md-2" style="width:20%;">
                        <p>
                            <?php if($authorized > 0 && $authorized===2) { ?>
                                <a href="//sklad.ruscable.ru/<?php echo $lastQuery; ?>"><?php echo $lastQuery; ?></a>
                            <?php } else { ?>
                                <?php echo $lastQuery; ?>
                            <?php } ?>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row blue-back" style="height: 400px;">
        <div class="head" style="margin-top: 40px;color:#fff">
                Партнеры сервиса
            </div>
        <div class="container" style="">
            <div class="col-md-12">
                <div class="row" style="margin-top:30px;margin-left:10px;">
                     <div class="col-md-3">
                        <div class="">
                            <a href="https://www.mkm.ru/" target="_blank" class="title">
                                <img style="border-radius: 50%;" width="200" src="/img/sklad_part1.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <a href="http://www.podolskkabel.ru/" target="_blank" class="title">
                                <img style="border-radius: 50%;" width="200" src="/img/sklad_part2.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <a href="http://cablestar.ru/" target="_blank" class="title">
                                <img style="border-radius: 50%;" width="200" src="/img/sklad_part3.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <a href="http://rusensys.ru/" target="_blank" class="title">
                                <img style="border-radius: 50%;" width="200" src="/img/sklad_part4.jpg">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="head" style="margin-top: 40px;">
            Новости
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:30px;">
                <?php foreach($news as $value) { ?>
                <div class="col-md-4">
                    <div class="news">
                        <div class="img" style="background-image:url('//ruscable.ru/news/convert/240/<?php echo $value["newsid"]; ?>-1.jpg');"></div>
                        <a href="//www.ruscable.ru/news/<?php echo date("Y",strtotime($value["date"]));?>/<?php echo date("m",strtotime($value["date"]));?>/<?php echo date("d",strtotime($value["date"]));?>/<?php echo $value["seo_title"];?>/" class="title"><?php echo $value["title"];?></a>
                        <div class="date"><?php echo date("d.m.Y",strtotime($value["date"]));?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="./misc/new/waypoints.min.js"></script>
<script>
    $(document).ready(function() {

        $('#leters-carousel').jcarousel({
            animation: 'slow',
            wrap : "both"
        });
        $('#leters-carousel').jcarouselAutoscroll({
            interval: 3000,
            target: '+=1'
        });

        $('.leters-prev').jcarouselControl({
            target: '-=1'
        });

        $('.leters-next').jcarouselControl({
            target: '+=1'
        });

    });

</script>
