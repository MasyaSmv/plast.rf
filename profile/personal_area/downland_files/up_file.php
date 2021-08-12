<!DOCTYPE html>
<html>
    <head>
        <title>Загрузка файла</title>
        <?php
            include ('../../../header.php');
            include ('../left_menu.html');
            include ('paginator_table.php');
            ?>
    </head>
    <body>
        <!-- Контейнер страницы  -->
        <div class="s7iwrf gMPiLc  Kdcijb" >
            <!-- Контейнер центра страницы -->
            <div class="ETkYLd">
                <!-- Контейнер с контентом -->
                <div class="D8JwHb">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="pHFe3 btn btn-link-free btn-block text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" name="button">
                                    Загрузка файла
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="ahh38c">
                                        <!-- Верхняя часть блока с текстами и картинкой -->
                                        <div class="ugt2L aK2X8b iDdZmf">
                                            <!-- Ссылка для перехода -->
                                            <div class="VZLjze Wvetm N5YmOc kJXJmd bvW4md I6g62c">
                                                <!-- Блок с текстами и картинкой -->
                                                <header class="mSUZQd">
                                                    <!-- Блок с текстами -->
                                                    <div class="jbRlDc">
                                                        <!-- Заголовок -->
                                                        <h2 class="fnfC4c">Загрузка файла обязательно формата .xlsx</h2>
                                                        <!-- Описание -->
                                                        <div class="ISnqu input-group">
                                                            <div class="custom-file">
                                                                <form enctype="multipart/form-data" action="upload.php" method="POST">
                                                                    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
                                                                    <input type="hidden" name="MAX_FILE_SIZE" value="210000" />
                                                                    <!-- Название элемента input определяет имя в массиве $_FILES -->
                                                                    <input name="userfile" type="file" class="custom-file-input" id="myInput" aria-describedby="myInput" />
                                                                    <label class="custom-file-label" for="myInput">Загрузи файл сучечка</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                        <div class="col-7">
                                                        <input type="text" class="form-control" name="city" autocomplete="off" placeholder="City">
                                                        </div>
                                                        <div class="col">
                                                        <input type="text" class="form-control" name="country" autocomplete="off" placeholder="Country"> <!-- Еще не добавлена в БД -->
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <!-- Контейнер с картинкой -->
                                                    <div class="CljqTd oiLvD3">
                                                    <!-- Блок с картинкой -->
                                                    <div class="fxHFgc" style="width: 96px; height: 96px;">
                                                    <!-- Картинка -->
                                                    <figure class="HJOYV HJOYVi13">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z"/>
                                                    </svg>
                                                    </figure>
                                                    </div>
                                                    </div>
                                                </header>
                                            </div>
                                        </div>
                                        <!-- Контейнер с нижней частью блока -->
                                        <div class="ugt2L ul8zCc aK2X8b t97Ap">
                                        <!-- Полоса разделения верхней и нижней части блока -->
                                        <div class="cv2gi">
                                        <div class="Q5jTGb">
                                        </div>
                                        </div>
                                        <!-- Нижняя часть блока -->
                                        <div class="VfPpkd-ksKsZd-XxIAqe CmhoVd">
                                        <!-- Ссылка для перехода -->
                                        <div class="VZLjze Wvetm I6g62c Of8KN kJXJmd">
                                        <div class="ng43Og mtfBU input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04" value="Отправить файл">Загрузить</button>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                        <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                        <button class="pHFe3 btn btn-link-free btn-block text-center collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Таблица с загруженными остатками
                        </button>
                        </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                        <?
                            //запрос в бд с суммой столбца длины и групировкой одинаковых позций
                            $sql = "SELECT title,size,quant,unit,color,city, SUM(quant)
                              FROM `sklad_tovar`
                              WHERE id_user = {$_SESSION['id']}
                              GROUP BY title,size,color,city
                              LIMIT $offset, $size_page";

                            $result = $mysqli->query($sql);


                            ?>
                        </head>
                        <body>
                        <div class="btOP43 table-responsive-xxl" style="text-align: -webkit-center;">
                        <table class="table fk4FG3">
                        <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Сечение</th>
                        <th scope="col">Длина</th>
                        <th scope="col">Ед. измерения</th>
                        <th scope="col">Цвет</th>
                        <th scope="col">Город</th>
                        </tr>
                        </thead>
                        <?
                            $i = 1;
                            while ($pow = mysqli_fetch_array($result)) {?>
                        <tbody>
                        <tr>
                        <th scope="row"><?echo $i++ ;?></th>
                        <td><?echo $pow['title'] ;?></td>
                        <td><?echo $pow['size'] ;?></td>
                        <td><?echo $pow['SUM(quant)'] ;?></td>
                        <td><?echo $pow['unit'] ;?></td>
                        <td><?echo $pow['color'] ;?></td>
                        <td><?echo  $pow['city'] ;?></td>
                        </tr>
                        <?}?>
                        </tbody>
                        </table>
                        </div>
                        <ul class="pagination">
                        <li><a href="?pageno=1">Начальная </a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Предыдущая </a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Следующая </a>
                        </li>
                        </ul>
                        <!-- Кнопка удаления таблицы (не работает) -->
                        <!-- <div style="display: flex; justify-content: center;">
                            <form action="delet_table.php" method="POST" name="btn_dlt_tbl">
                              <div class="form-group"><br />
                            	<input class="btn btn-primary btn-block" type="submit" name="btn_delet_table" value="Delet table">
                            </div>
                            </form>
                            </div> -->
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        </div>
        <?
            echo "\n Некоторая отладочная информация:";
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
              ?>
        <script>
            document.querySelector('.custom-file-input').addEventListener('change',function(e){
              var fileName = document.getElementById("myInput").files[0].name;
              var nextSibling = e.target.nextElementSibling
              nextSibling.innerText = fileName
            })
        </script>
    </body>
</html>
