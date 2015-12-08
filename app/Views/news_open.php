<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  
   <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
   
    <?php  addCssAndJs($jsCSSLibs, ['default-template', 'jQuery', 'fontawesome', 'blueimp-gallery', 'jcarousellite',
                                    'slider', 'vk-share', 'vk-api']);  ?>
    
   <title><?=$title?></title>
</head>
<body>
    <?php require 'navbar.php' ?>
        <div id="b1">
            <div id="b2">
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
                <div id="topm">
                    <div class="container ">
                        <ul class="menu" id="topmenu">
                            <li class="item-102 deeper parent">
                                <a href="/kids/">Детский альбом</a>
                                <ul>
                                    <li class="item-139">
                                        <a href="/kids/info">Информация</a>
                                    </li>
                                    <li class="item-140">
                                        <a href="/kids/price">Цены</a>
                                    </li>
                                    <li class="item-141">
                                        <a href="/kids/faq">Вопросы</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="item-103 deeper parent">
                                <a href="/school/">Школьный альбом</a>
                                <ul>
                                    <li class="item-136">
                                        <a href="/school/info">Инфо</a>
                                    </li>
                                    <li class="item-137">
                                        <a href="/school/price">Цены</a>
                                    </li>
                                    <li class="item-138">
                                        <a href="/school/faq">Вопросы</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="item-104 deeper parent">
                                <a href="/student/">Студенческий альбом</a>
                                <ul>
                                    <li class="item-142">
                                        <a href="/student/info">Инфо</a>
                                    </li>
                                    <li class="item-143">
                                        <a href="/student/price">Цены</a>
                                    </li>
                                    <li class="item-144">
                                        <a href="/student/faq">Вопросы</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="item-105 deeper parent">
                                <a href="/minibook/">Mini Book</a>
                                <ul>
                                    <li class="item-145">
                                        <a href="/minibook/info">Инфо</a>
                                    </li>
                                    <li class="item-146">
                                        <a href="/minibook/price">Цены</a>
                                    </li>
                                    <li class="item-147">
                                        <a href="/minibook/faq">Вопросы</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="bodym2">
                    <div class="container ">
                        <ul class="menu" id="bodym2">
                            <li class="item-106">
                                <a href="/portfolio/">Наши работы</a>
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
                                  <ul>
                                      <li>
                                          <a href="/contacts/vacancies/">Вакансии</a>
                                      </li>
                                 </ul>
                             </li>
                        </ul>
                    </div>

                </div>
                <div class="item-pagebook1">  
                    <div class="news-block">
                    <h1 class="news-h1"><?=$news->title?></h1>
<script type="text/javascript">
    document.write(VK.Share.button());
    document.getElementById('vk_share_button').innerHTML = VK.Share.button(location.href, {type: 'link'}); 
</script>
                    <p><?=$news->anotation?></p>
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
                                    <a href="/files/<?=$img[$c]?>" 
                                       title="<?=$altDesc[$c]->description ? $altDesc[$c]->description : "" ?>">
                                       
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
                    <p><?=(isset($news->news)) ? $news->news : ''?></p>
 <!-- Gallery -->                   
<script>
    document.getElementById('links').onclick = function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event},
            links = this.getElementsByTagName('a');
        blueimp.Gallery(links, options);
    };
</script>
<div class="vk-block" id="vk_comments_<?=$type?>_<?=$id?>"></div>
<script type="text/javascript">
    window.onload = function () {
        VK.init({apiId: 5059948 , onlyWidgets: true });
        VK.Widgets.Comments('vk_comments_<?=$type?>_<?=$id?>', {width: 680, limit: 15, attach: "*"});
    }
</script>
                    </div>
                </div>
                
    <?php require 'footer.php' ?>
        </body>
</html>
