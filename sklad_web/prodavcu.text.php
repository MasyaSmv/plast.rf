<div id="main" class="row">
    <div class="container">
        <div class="col-md-12 top">
            <div class="logo" style="display: block;">
                <a href="/" class="sklad"></a>
                <a href="http://www.ruscable.ru" class="baseSite"></a>
            </div>
            <div class="subtitle">Сервис для поиска кабельно-проводниковой продукции</div>
            <form class="top-form" id="search">
                <input type="text" placeholder="Введите маркоразмер">
                <input type="submit" value="Найти">
                <div class="result">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row gray-back" style="height: 460px;">
    <div class="profile-block">
        <?php if($authorized > 0){ ?>
            <?php $str_end_date=date("d.m.Y г.",strtotime($end_date)); ?>
            <div class="avatar" style="background:url(./img/new/avatar.png);"></div>
            <a href="http://www.ruscable.ru/users/" style="color: white;text-decoration: none;" class="username"><?php echo $_SESSION['s_name']; ?></a>
            <p>
                Тариф «Безлимитный» (неограниченный поиск)
            </p>
        <?php } else { ?>
            <p style="text-align: center;">
                <a href="http://www.ruscable.ru/users/" style="color:white;">Войдите</a> или <a href="http://www.ruscable.ru/users/registr.html"  style="color:white;">зарегистрируйтесь</a>
            </p>
        <?php } ?>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="row" style="margin-top:0px;">
                <div class="col-md-12">
                    <div class="header">СЕРВИС СКЛАД продавцу КПП</div>
                    <p class="big" style="text-align: left;">
                        Сервис <b>СКЛАД.RusCable.Ru</b> является незаменимым помощником в реализации продукции из наличия на складе Вашей организации.
                        <br><br>
                        Разместив в системе свою складскую справку абсолютно бесплатно, Вы получите максимальное внимание
                        со стороны многотысячной аудитории портала <b>RusCable.Ru</b>. Теперь не Вы будете искать покупателей, а они Вас!
                        Размещая информацию у нас — Вы даете доступ Вашим потенциальным клиентам к той информации, в которой
                        они нуждаются. Быстро, просто и без посредников.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row white preimushestva">
    <div class="container">
        <div class="head">
            Как разместить складские остатки?
        </div>
        <div class="col-md-12 instrum">
            <div class="row" style="margin-top:40px;">
                <div class="col-md-4">
                    <div class="orange-icon" style="background:url(./img/new/onestap.png);"></div>
                    <div class="caption">
                        <a href="http://www.ruscable.ru/users/registr.html">Зарегистрируйтесь</a><br>
                        на RusCable.Ru
                    </div>
                    <p>
                        Укажите именно те контактные данные, которые будут видны вашим потенциальным клиентам.<br><br>
                        Заполните информацию о вашей компании.
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="orange-icon" style="background:url(./img/new/toostap.png);"></div>
                    <div class="caption">Подготовьте файл</div>
                    <p>
                        <b>Формат Excel (.xls, .xlsx)</b>
                        с заполненными 4-мя колонками:
                    </p>
                    <ul style="padding-left: 10px;margin-bottom:20px;">
                        <li>Наименование</li>
                        <li>Количество</li>
                        <li>Единица измерения</li>
                        <li>Разбивка по кускам</li>
                    </ul>
                    <p>
                        <a href="./img/example.png"  data-lightbox="leters">Образец</a>
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="orange-icon" style="background:url(./img/new/threestap.png);"></div>
                    <div class="caption">Оправьте файл нам</div>
                    <p>
                        Либо через <a href="http://www.ruscable.ru/users/sklad_ost.html">личный кабинет</a> («Склад» > «Размещение остатков») или на <a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a>.<br><br>
                        Ваш файл будет размещен в течение 1 рабочего дня.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <hr style="margin-top: 70px;">
</div>
<div class="row whiteblock instrum">
    <div class="container">
        <div class="head" style="margin-top:0px;">
            ПРАВИЛА, КОТОРЫЕ ПОМОГУТ ВАШЕЙ ПРОДУКЦИИ<br>
            БЫТЬ ВЫШЕ КОНКУРЕНТОВ
        </div>
        <p>
            <b>1. Складская справка</b><br>
            Складская справка по наличию на различных филиалах (например, в разных городах) должна содержаться
            и предоставляться в отдельных файлах Excel.
        </p>
        <hr style="margin-top: 30px;margin-bottom: 30px;">
        <p>
            <b>2. Точное наименование</b><br>
            Наименование в базе Склад это – это сочетание их марки КПП, размера и номинального напряжения.
        </p>
        <p>
            <b>Поисковый механизм выдает сначала те позиции, которые написаны коротко –</b>
        </p>
        <div class="gray-prompt">
            ВВГ 3Х1,5
        </div>
        <p>
            <b>Затем те, у которых есть длинное окончание:</b>
        </p>
        <div class="gray-prompt">
            ВВГ 3х1,5 ГОСТ<br>
            ВВГ 3х1,5 ГОСТ черн<br>
            ВВГ 3х1,5 ГОСТ черн Кольчуга
        </div>
        <p>
            <b>Если Вы хотите, чтобы именно Ваша позиция шла выше остальных старайтесь придерживаться вот такого варианта отображения складской справки:</b>
        </p>
        <div class="gray-prompt">
            МАРКА_РАЗМЕР
        </div>
        <p>
            Примечания, номера ГОСТов и ТУ, длины, артикулы и прочее мы стараемся удалять, чтобы выдача в поиске была чище и пользователю было проще найти нужную марку и длину.
        </p>
        <hr style="margin-top: 30px;margin-bottom: 30px;">
        <p>
            <b style="text-transform:uppercase;">3. Маркообразование</b><br>
            Придерживайтесь общепринятых, наиболее распространенных (в конце концов по ГОСТ) обозначений марок КПП. Например: Не ВВГ нг-(А)-LS, а ВВГнг(А)-LS
        </p>
        <p>
            Чем больше файл будет отличаться от этих требовний, тем дольше мы будем его загружать.
        </p>
        <div class="orange-border">
            <div class="caption">Важно!</div>
            <p>
                Сервис СКЛАД предоставляет своим пользователям только актуальную информацию. Поэтому обновление информации в системе по каждому поставщику происходит каждые 2 недели.
            </p>
        </div>
        <p>
            Если складская справка вашей компании постоянно присутствует на вашем корпоративном сайте и соответствует  нашей форме, <a href="mailto:sklad@ruscable.ru">напишите нам</a> и специалисты сервиса СКЛАД организуют автоматическую загрузку информации
            без регулярного привлечения менеджера с вашей стороны.
        </p>
    </div>
    <hr style="margin-top: 40px;">
    <div class="container">
        <div class="head" style="margin-top:0px;font-size:25px;">
            Если вы еще не зарегистрированы на RusCable.Ru
        </div>
        <p>
            Подготовьте файл в формате Word (.doc,.docx) с реквизитами вашей компании и кратким описанием
            ее деятельности (производство, оптовая торговля, розничная торговля и т.д.), а также укажите контактное лицо
            по работе с системой (ФИО, раб. телефон, сот. телефон, ICQ, e-mail).
        </p>
        <p>
            Направьте оба файла (остатки в формате Excel и описание предприятия в формате Word) по адресу sklad@ruscable.ru. Мы занесем ваши данные и они станут доступны аудитории сервиса.
        </p>
    </div>
    <hr style="margin-top: 40px;">
    <div class="container">
        <div class="head" style="margin-top:0px;font-size:25px;">
            Механизм работы сервиса СКЛАД.RusCable.RU
        </div>
        <p>
            Поступающая в систему информация обновляется в течение одного рабочего дня. После размещения на указанный контактный e-mail поставщика поступает автоматическое подтверждение о размещении. Дальнейшие оповещения и уведомления от системы также приходят на указанный при регистрации поставщиком адрес.
            Вынуждены предупредить о возможных санкциях за предоставление недостоверной или устаревшей информации: первый раз – предупреждение, в случае повторения полное исключение из системы СКЛАД.RusCable.Ru.
        </p>
        <p style="color:#0080c0; font-size:25px;">
            ЦЕЛЬ СЕРВИСА — предоставить потребителям самую актуальную
            и достоверную информацию. Это в интересах каждой из сторон, присутствующих на СКЛАД.RusCable.Ru.
        </p>
    </div>
    <hr style="margin-top: 40px;">
    <div class="container">
        <div class="head" style="margin-top:0px;">
            Информер СКЛАД on-line
        </div>
        <p>
            Информация, которую вы размещаете  в системе СКЛАД может быть доступна не только
            на www.RusCable.Ru. Данный сервис снабжен бесплатным дополнением, уникальным по своему функционалу, которое позволяет поставщику получить преимущество среди конкурентов. Это информер «Склад on-line».
        </p>
        <p>
            Своеобразный виджет, который устанавливается на сайт вашей компании и отражает состояние складского наличия компании в режиме on-line. Причем дизайн виджета можно отрегулировать под корпоративный стиль сайта. Это удобно, просто, бесплатно.
        </p>
        <p>
            Кроме того, важным дополнением данной опции является знак «проверено RusCable.Ru», как гарант того,
            что компания заслуживает доверие и проверена администрацией первого электротехнического портала отрасли.
        </p>
        <p>
            С помощью информера „Склад on-line“ все пользователи Вашего корпоративного сайта смогут воспользоваться удобным механизмом поиска среди всей номенклатуры именно Вашего складского наличия.
        </p>
        <p>
            <b>
                Как установить Информер можно прочесть <a href="http://www.ruscable.ru/users/sklad_informer.html">ЗДЕСЬ</a> или обратиться к менеджеру сервиса тел: 8 (495) 229 33 36;
                e-mail: <a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a>.
            </b>
        </p>
        <div class="gray-block link-block">
            <div class="head">
                Полезные ссылки
            </div>
            <div class="row preimushestva">
                <div class="col-md-4">
                    <ul>
                        <li><a href="http://www.ruscable.ru/MobileApps/">Мобильная версия склада</a></li>
                        <li><a href="http://www.ruscable.ru/info/ves/">Расчет веса КПП</a></li>
                        <li><a href="http://www.ruscable.ru/info/tara/">Расчет схемы погрузки КПП</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li><a href="http://www.ruscable.ru/info/cable/">Справочник КПП</a></li>
                        <li><a href="http://www.ruscable.ru/company/">Поставщики КПП</a></li>
                        <li><a href="/pokupatelu">Мой список</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li><a href="http://www.ruscable.ru/info/osz_send.html">Отправить заявку на КПП</a></li>
                        <li><a href="http://www.ruscable.ru/promotion/osz.html">Получать заявки на КПП</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>