<!DOCTYPE html>
<html>

<head>
    <title>METANIT.COM</title>
    <meta charset="utf-8" />
    <?php
include '../../header.php';
// include ('../left_menu.php');
?>
</head>

<body>
    <!-- Контейнер страницы  -->
    <div class="s7iwrf gMPiLc  Kdcijb">
        <!-- Контейнер центра страницы -->
        <div class="ETkYLd">
            <!-- Контейнер с контентом -->
            <div class="D8JwHb">
                <h2>Загрузка файла</h2>
                <?php
                    if (isset($_SESSION['message']) && $_SESSION['message']) {
                        printf('<b>%s</b>', $_SESSION['message']);
                        unset($_SESSION['message']);
                    }
                ?>
                <form method="POST" action="upload_photo.php" enctype="multipart/form-data">
                    <div>
                        <span>Upload a File:</span>
                        <input type="file" name="uploadedFile" />
                    </div>
                    <input type="submit" name="uploadBtn" value="Upload" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>
