<!DOCTYPE html>
<html>

<head>
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <meta charset="UTF-8">

    <?php  addCssAndJs($jsCSSLibs, ['default-template']);  ?>

        <title>
            <?php if(!isset($title)) $title = 'Главная страница - StartUP'; echo $title;?>
        </title>

</head>

<body>
    <div class="wrap">
        <?php require 'header.php' ?>

            <div id="b1">
                <div id="b1">
                    <div id="login">
                        <a href="#" title="Войти в личный кабинет">Личный кабинет</a>
                    </div>
                    <div id="rkontakt">
                        <a class="logo" title="StartUP" alt="StartUP" href="/"> </a>
                        <span class="rkp">+7(495) 776-61-33<br>+7(926) 269-09-64</span>
                        <span class="rke">
                            <a href="mailto:info@startupfoto.ru">info@startupfoto.ru</a><br>
                            <a href="mailto:info@startupfoto.ru">zel@startupfoto.ru</a><br>
                            <a href="mailto:info@startupfoto.ru">nn@startupfoto.ru</a><br>
                            <a href="mailto:info@startupfoto.ru">penza@startupfoto.ru</a>
		                </span>
                    </div>
                    
                    <?php require 'topmenu.php'; ?>
                    
                    <div id="system-message-container"></div>
                    
                    <?php require 'menu.php'; ?>

                    <div class="item-pagebook1">
                        <div class="text page">
                            <?php require 'tabs.php'; ?>

                            <?php if(isset($post)) { echo $post; } ?>
                        </div>
                    </div>
                    <?php require 'footer.php' ?>
                </div>
</body>