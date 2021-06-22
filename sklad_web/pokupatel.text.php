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
                Тариф «Безлимитный» (неограниченный поиск)<br>
                <?//Срок действия: до <?php echo  $str_end_date;
                ?>
            </p>
        <?php } else { ?>
            <p style="text-align: center;">
                <a href="http://www.ruscable.ru/users/" style="color:white;">Войдите</a> или <a href="http://www.ruscable.ru/users/registr.html"  style="color:white;">зарегистрируйтесь</a>
            </p>
        <?php } ?>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="row" style="margin-top:30px;">
                <div class="col-md-12">
                    <div class="header">Сервис склад ПОКУПАТЕЛЮ КПП</div>
                    <p class="big">
                        Для осуществления поисков в системе СКЛАД.Ruscable.Ru достаточно <a href="http://www.ruscable.ru/users/registr.html">пройти бесплатную регистрацию</a> (это займет не больше минуты)
                        или войти в систему, используя свой логин и пароль.
                        <!--Использование системы СКЛАД означает безоговорочное согласие и принятие <a href="/tarifs/oferta.php">публичной оферты</a>. -->
                        <br>С 31 августа 2018 года при поддержке компаний "Москабельмет", "КабельСтар" и "Подольсккабель" доступ к поиску для всех пользователей сервиса осуществляется бесплатно.


                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row white preimushestva">
    <div class="container">
        <div class="head">
            Воспользовавшись нашим сервисом,<br>
            вы сможете:
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top:40px;">
                <div class="col-md-6">
                    <ul style="padding-left: 10px;">
                        <li>Максимально оперативно найти требуемый кабель или провод</li>
                        <li>Узнать у кого из поставщиков он есть в наличии на складе, в каком количестве</li>
                        <li>Получить контакты тех организаций, которые Вас заинтересуют</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="padding-left: 10px;">
                        <li>Собрать необходимые позиции в on-line заявку и направить ее поставщику, либо сохранить или распечатать</li>
                        <li><a href="http://www.ruscable.ru/info/ves/" target="_blank">Рассчитать вес</a> как одного куска КПП, так и всей заявки</li>
                        <li><a href="http://www.ruscable.ru/info/tara/" target="_blank">Рассчитать схему погрузки</a> кабеля</li>
                    </ul>
                </div>
                <!--div class="col-md-12">
                    <p style="font-size: 18px; ">
                        3  поиска* в месяц - такое количество запросов осуществит зарегистрированный пользователь бесплатно,
                        при условии указания данных об организации.
                    </p>
                    <hr class="small">
                    <p style="font-size: 16px; font-style:italic; font-weight:lighter;">
                        *Поиск - любой запрос, в т.ч. пустой, в строке поиска и нажатие кнопки «Найти кабель» или клавиши «Enter».<br>
                        Запрос, не давший результатов, поиском не считается.
                    </p>
                </div-->
            </div>
        </div>
    </div>
    <hr>
<? /*
    <div class="container" id="tarif">
        <div class="cel">Тариф</div>
        <div class="col-md-12">
            <p>
                Все зарегистрированные на RusCable.Ru пользователи одной организации при подключении тарифа «Безлимитный»
                получают неограниченный доступ к системе на оплаченный период.
            </p>
            <p>
                <b>Тариф «Безлимитный»</b>
            </p>
            <table>
                <thead>
                <tr>
                    <th>Период обслуживания</th>
                    <th>Цена, руб.</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1 месяц</td>
                    <td class="price">1 798</td>
                </tr>
                <tr>
                    <td>3 месяца</td>
                    <td class="price">5 394</td>
                </tr>
                <tr>
                    <td>6 месяцев</td>
                    <td class="price">10 240</td>
                </tr>
                <tr>
                    <td>12 месяцев</td>
                    <td class="price">19 400</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr style="margin-top: 70px;">
</div>
<div class="row whiteblock instrum">
    <div class="container">
        <div class="head" style="margin-top:0px;">
            Оплата
        </div>
        <p style="margin-top:30px; margin-bottom:10px;">
            Оплата тарифа «Безлимитный» может быть осуществленна при помощи:
        </p>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6" style="width:20%">
                    <div class="orange-icon" style="background:url(./img/new/debetcardicon.png);"></div>
                    <div class="caption">Банковской карты</div>
                </div>
                <div class="col-md-6" style="width:20%">
                    <div class="orange-icon" style="background:url(./img/new/webmoneyicon.png);"></div>
                    <div class="caption">Webmoney</div>
                </div>
                <div class="col-md-6" style="width:20%">
                    <div class="orange-icon" style="background:url(./img/new/yandexmoneyicon.png);"></div>
                    <div class="caption">Яндекс.Денег</div>
                </div>
                <div class="col-md-6" style="width:20%">
                    <div class="orange-icon" style="background:url(./img/new/sberbankicon.png);"></div>
                    <div class="caption">Квитанции для Сбербанка</div>
                </div>
                <div class="col-md-6" style="width:20%">
                    <div class="orange-icon" style="background:url(./img/new/invoiceicon.png);"></div>
                    <div class="caption">Через счет на оплату услуг</div>
                </div>
            </div>
        </div>
        <p style="margin-top:30px;">
            Для проведения оплаты перейдите в ваш <a href="http://www.ruscable.ru/users/sklad_dost.html">личный кабинет</a> RusCable.Ru, который доступен сразу после <a href="http://www.ruscable.ru/users/registr.html">регистрации</a> 
            и добавления данных о компании.
        </p>
        <p style="margin-top:30px;margin-bottom:50px;">
            По вопросам оплаты и подключения доступа к поисковой системе СКЛАД.RusCable.Ru вы можете обратиться
            по тел 8 (495) 229-33-36 или по e-mail: <b><a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a></b>, <b><a href="mailto:mail@ruscable.ru">mail@ruscable.ru</a></b>.
        </p>
    </div>
    <hr>
</div>
<div class="row whiteblock instrum">
    <div class="container" style="margin-bottom: 70px;">
        <div class="head" style="margin-top:0px;">
            Акции
        </div>
        <p style="margin-top:30px; margin-bottom:10px;">
			<strong>11 с половиной минут свободного поиска ежедневно</strong>
        </p>
        <p style="margin-top:30px; margin-bottom:10px;">
			Ежедневно, с 11:00 до 11:12, включая выходные и праздники, любой пользователь имеет возможность осуществить неограниченное количество поисков. В этот период все пользователи, даже незарегистрированные, смогут осуществлять поиск среди сотен складов и десятков тысяч складских позиций.
        </p>
    </div>
</div>
*/
?>
<div class="row mylist-block blue-back">
    <div class="container">
        <div class="head">
            <div class="orange-icon" style="background:url(./img/new/icon1.png);"></div> Функция «мой список»
        </div>
        <p>
            Для всех пользователей поиска доступна новая функция – Мой Список.
        </p>
        <p>
            Нужные  позиции теперь легко можно добавить в интерактивный список, который затем вывести на печать
            или сразу отправить по e-mail поставщику в формате excel.
        </p>
        <p>
            Автоматически в единой таблице Моего Списка по каждой выбранной позиции отображаются: количество, город, название компании-поставщика, все данные контактного лица. Попробуйте создать свой список прямо сейчас — это очень просто!
        </p>
    </div>
</div>
<div class="row whiteblock instrum">
    <div class="container">
        <div class="link-block">
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