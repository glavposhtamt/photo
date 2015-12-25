<!DOCTYPE html>
<html>

<head>
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <meta charset="UTF-8">

    <?php  addCssAndJs($jsCSSLibs, ['default-template', 'jQuery', 'ymaps']);  ?>

        <title>
            <?php if(!isset($title)) $title = 'Главная страница - StartUP'; echo $title;?>
        </title>

</head>

<body>
    <div class="wrap">
        <?php include 'header.php'; ?>
            <div id="b1">

                <?php require 'topmenu.php'; ?>
                
                <div id="bodym2">
                    <div class="container ">
                        <ul class="menu" id="bodym2">
                            <li class="item-106">
                                <a href="/portfolio/" id="geo-item">География альбомов</a>
                            </li>
                            <li class="item-109">
                                <a href="/ourworks/">Наши работы</a>
                            </li>
                            <li class="item-111">
                                <a href="/video/">Видео</a>
                            </li>
                            <li class="item-107">
                                <a href="/news/">Новости</a>
                            </li>
                            <li class="item-110">
                                <a href="/contacts/vacancies/">Вакансии</a>
                            </li>
                            <li class="item-108">
                                <a href="/contacts/">Контакты</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="item-pagebook1">
                    
                    <div id="map" style="width:840px; height:600px"></div>
                </div>
                <?php include 'footer.php'; ?>
            </div>