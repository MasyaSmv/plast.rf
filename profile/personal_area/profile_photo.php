<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Личный кабинет</title>
    <link rel="stylesheet" type="text/css" href="/css/profile_photo.css?v=1.0.0.0">
</head>

<body>
    <div class="ee-Ji-eb ee-Df-eb">
        <div class="ee-Ji-If ee-Hi-Zb-If">
            <div class="ee-Ji-hc ee-Hi-Zb-ie" style="height: 50px;">
                <div class="ee-Hi-Zb-Ii-Yb-mh" id=":3">
                    <div class="a-Ii-Yb a-Ii-Yb-Zb a-Ii-Yb-hc" role="tablist" tabindex="0" style="user-select: none;">
                        <div class="a-Ii a-Ii-w" role="tab" aria-selected="true" style="user-select: none;" id=":5">
                            <div class="ee-Hi-Zb-Tj" style="user-select: none;">Загрузка фотографий</div>
                        </div>
                        <div class="a-b-c a-kb-u" role="tab" aria-hidden="true"
                            style="user-select: none; display: none;" aria-expanded="false" aria-haspopup="true"
                            id=":7">
                            <div class="a-b-c a-kb-u-pb-qb" style="user-select: none;">
                                <div class="a-b-c a-kb-u-rb-qb" style="user-select: none;">
                                    <div class="a-b-c a-kb-u-mb" style="user-select: none;">
                                        <div style="user-select: none;">Ещё
                                            <div class="ee-wj-n-Vj-Wj-me" style="user-select: none;"></div>
                                        </div>
                                    </div>
                                    <div class="a-b-c a-kb-u-nb" style="user-select: none;">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ee-Ji-eb ee-Hi-Zb-eb" style="top: 51px;">
                <div>
                    <div class="ee-Ji-If ee-Ki-If">
                        <div class="ee-Ji-eb ee-Ki-eb" style="bottom: 70px;">
                            <div class="ee-eb ee-eg ee-ko">
                                <div class="ee-ko-hj">
                                    <div class="d-Lb d-Lb-Nb" aria-live="assertive" aria-atomic="true"></div>
                                </div>
                                <div class="ee-No ee-ah-Qd-Oo" aria-hidden="false"
                                    style="left: 0px; width: auto; height: auto;">
                                    <div class="ee-No-Rd ee-No-jp">
                                        <div class="ee-No-hp">
                                            <div class="ee-No-ip ee-No-mp" style="opacity: 1;">
                                                <div class="ee-wj-Fl-eg-Hk"></div>
                                                <div class="ee-No-tc">Перетащите фотографию сюда</div>
                                                <div class="ee-No-kp">
                                                    <div>
                                                        <div class="ee-No-lp">— или —</div>
                                                        <div id=":e.select-files-button"></div>
                                                    </div>
                                                </div>
                                                <div id=":e.select-files-button">
                                                    <div class="custom-file">
                                                        <form method="post" enctype="multipart/form-data"
                                                            id="form-file-ajax" action="upload_photo.php">
                                                            <input type="file" id="file" name="file" required>
                                                            <br />
                                                            <button type="submit"
                                                                id="btn-file-upload">Загрузить</button>
                                                            <!-- preloader.gif - картинка имитирующая процесс загрузки -->
                                                            <div id="process"><img src="preloader.gif" alt="Loading">
                                                            </div>
                                                            <div id="photo-content">
                                                                <!-- Эта картинка выводится из базы по умолчанию -->
                                                                <img src="http://site.com/upload/<?= $image ?>"
                                                                    alt="Image" width="400">
                                                            </div>
                                                        </form>
                                                        <script src="https://code.jquery.com/jquery-3.3.1.min.js">
                                                        </script>
                                                        <!-- Этот файл будет содержать код отправки данных PHP скрипту -->
                                                        <script src="ajax.js"></script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ee-Fc-eg-td-u">
                                        <button style="display: none;">
                                        </button>
                                        <input type="file" style="height: 0px; visibility: hidden; position: absolute;">
                                    </div>
                                </div>
                                <div class="ee-ko-Xb-mh" style="display: none;">
                                    <div class="ee-ko-Xb-tc">Загрузка</div>
                                    <div class="ee-ko-Xb">
                                        <div class="Xb-Yb-Zb ee-Xb-Yb" aria-valuemin="0" aria-valuemax="100"
                                            aria-atomic="true" aria-live="polite" aria-label="Начато" role="status">
                                            <div class="Xb-Yb-O" style="width: 0%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
