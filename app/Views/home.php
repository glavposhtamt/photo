<!DOCTYPE html>
<html>

<head>
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <meta charset="UTF-8">

    <?php  addCssAndJs($jsCSSLibs, ['default-template']);  ?>

    <title>
        <?php if(!isset($title)) $title = 'Главная страница - StartUP'; echo $title;?>
    </title>

        <!--<noindex><script async src="data:text/javascript;charset=utf-8;base64,ZnVuY3Rpb24gbG9hZHNjcmlwdChlLHQpe3ZhciBuPWRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoInNjcmlwdCIpO24uc3JjPSIvL2xwdHJhY2tlci5ydS9hcGkvIitlO24ub25yZWFkeXN0YXRlY2hhbmdlPXQ7bi5vbmxvYWQ9dDtkb2N1bWVudC5oZWFkLmFwcGVuZENoaWxkKG4pO3JldHVybiAxfXZhciBpbml0X2xzdGF0cz1mdW5jdGlvbigpe2xzdGF0cy5zaXRlX2lkPTEyNTE7bHN0YXRzLnJlZmVyZXIoKX07dmFyIGpxdWVyeV9sc3RhdHM9ZnVuY3Rpb24oKXtqUXN0YXQubm9Db25mbGljdCgpO2xvYWRzY3JpcHQoInN0YXRzX2F1dG8uanMiLGluaXRfbHN0YXRzKX07bG9hZHNjcmlwdCgianF1ZXJ5LTEuMTAuMi5taW4uanMiLGpxdWVyeV9sc3RhdHMp"></script></noindex>-->
</head>

<body>
    <div class="wrap">
        <?php require 'header.php'; ?>
                <div id="b2">
                                       
                    <?php require 'topmenu.php'; ?>
                    
                    <div id="bodym">
                        <div class="container ">
                            <ul class="menu" id="bodym">
                                <li class="item-106">
                                    <a href="/portfolio/">Наши работы</a>
                                </li>
                                </li>
                                <li class="item-109">
                                    <a href="/about/">О нас</a>
                                </li>
                                <li class="item-111">
                                    <a href="/prom/">Организация выпускного</a>
                                </li>
                                <li class="item-107">
                                    <a href="/video/">Видео</a>
                                </li>
                                <li class="item-110">
                                    <a href="/news/">Новости</a>
                                </li>
                                <li class="item-108">
                                    <a href="/contacts/">Контакты</a>
                                    <ul style="margin-top:-69px;">
                                        <li>
                                            <a href="/contacts/vacancies/">Вакансии</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="system-message-container"></div>

                    <div class="blog-featured"> </div>

                    <div class="content">

                        <div>

                            <div class="" id="obj_1361">
                                <div class="preview">
                                    <div class="preview_title"><a href="http://www.startupfoto.ru/news/">Последние новости</a></div>
                                    <div class="elements">
                                        <div class="preview_object tr0">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class="td_pic">
                                                            <div class="image">
                                                                <a href="http://www.startupfoto.ru/news/5/">
                                                                    <img src="/images/preview_oblozhka.jpg" alt="Как оформить фотоальбом? Полезные советы фото" title="Как оформить фотоальбом? Полезные советы фото">

                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="title"><a href="http://www.startupfoto.ru/news/5/">Как оформить фотоальбом? Полезные советы</a></div>
                                                            <div class="text">Цифровые технологии побуждают многих людей хранить фотографии в папках на компьютере. Но вряд ли стоит считать бумажные фотоальбомы «вчерашним днем». Красиво оформленный альбом с отборными фото смотреть куда приятнее, чем...</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>




                    <?php require 'footer.php' ?>
            </div>
</body>

</html>