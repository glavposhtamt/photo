<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">

    <?php  addCssAndJs($jsCSSLibs, ['default-template', 'jQuery', 'fontawesome', 'blueimp-gallery', 'jcarousellite',
                                    'slider', 'vk-share', 'vk-api']);  ?>

        <title>
            <?=$title?>
        </title>
</head>

<body>
    <div class="wrap">
        <?php require 'header.php' ?>
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
                
                <?php require 'menu.php' ?>
                
                <div class="item-pagebook1">
                    <div class="news-block text page">
                        <h1 class="news-h1"><?=$news->title?></h1>
                        <script type="text/javascript">
                            document.write(VK.Share.button());
                            document.getElementById('vk_share_button').innerHTML = VK.Share.button(location.href, {
                                type: 'link'
                            });
                        </script>
                        <p>
                            <?=$news->anotation?>
                        </p>
                        <!-- Управление галереей -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                            <div class="slides"></div>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                        </div>
                        <?php if(!empty($img)) :?>
                            <div class="custom-container basic2" id="links">
                                <div id="box-big-img">
                                    <a href="/files/<?=$img[0]?>"><img src="/files/<?=$img[0]?>" alt="big" id="big-img"></a>
                                    <i class="fa fa-search-plus fa-3" id="fullscreen-img"></i>
                                </div>
                                <div class="left-moove">
                                    <i class="fa fa-chevron-left prev"></i>
                                </div>
                                <div class="carousel">
                                    <ul>
                                        <?php $count = count($img); for ($c = 0; $c < $count; $c++) : ?>
                                            <li>
                                                <a href="/files/<?=$img[$c]?>" title="<?=$altDesc[$c]->description ? $altDesc[$c]->description : " " ?>">
                                       
                                       <img src="/files/<?=$img[$c]?>" 
                                            alt="<?=$altDesc[$c]->title ? $altDesc[$c]->title : "" ?>" width="129" height="97" >
                                            
                                    </a>
                                            </li>
                                            <?php endfor; ?>
                                    </ul>
                                </div>
                                <div class="right-moove">
                                    <i class="fa fa-chevron-right next"></i>
                                </div>
                                <div class="clear"></div>
                                <script>
                                    $(".basic2 .carousel").jCarouselLite({
                                        btnNext: ".basic2 .next",
                                        btnPrev: ".basic2 .prev"
                                    });
                                </script>
                            </div>
                            <?php endif; ?>
                                <p>
                                    <?=(isset($news->news)) ? $news->news : ''?>
                                </p>
                                <!-- Gallery -->
                                <script>
                                    document.getElementById('links').onclick = function(event) {
                                        event = event || window.event;
                                        var target = event.target || event.srcElement,
                                            link = target.src ? target.parentNode : target,
                                            options = {
                                                index: link,
                                                event: event
                                            },
                                            links = this.getElementsByTagName('a');
                                        blueimp.Gallery(links, options);
                                    };
                                </script>
                                <div class="vk-block" id="vk_comments_<?=$type?>_<?=$id?>"></div>
                                <script type="text/javascript">
                                    window.onload = function() {
                                        VK.init({
                                            apiId: 5059948,
                                            onlyWidgets: true
                                        });
                                        VK.Widgets.Comments('vk_comments_<?=$type?>_<?=$id?>', {
                                            width: 680,
                                            limit: 15,
                                            attach: "*"
                                        });
                                    }
                                </script>
                    </div>
                </div>
                <?php require 'footer.php' ?>
            </div>
</body>

</html>