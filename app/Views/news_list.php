<!DOCTYPE html>
<html class="bx-no-touch bx-no-retina bx-firefox bx-boxshadow bx-borderradius bx-flexwrap bx-boxdirection bx-transition bx-transform"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="index, follow">
    <link href="/css/kernel_main.css" type="text/css" rel="stylesheet">
    <link href="/css/template.css" type="text/css" data-template-style="true" rel="stylesheet">
	
  <title><?=$title?></title>
  <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">

    <style>
        #b2 {
            background-image: none;
    /*
            background: url(/bitrix/templates/sf_services/images/bg400000.jpg) repeat-y 50% 0;
    */
        }
    </style>
	</head>
    <body>
    <div class="hdr">
        <div class="hdr2">
            <div class="sp-logo"><a href="/"></a></div>
            <div class="sp-tel"><a href="tel:+74957766133">8(495) 776-61-33</a><br><a href="tel:+78007753438">8(800) 775-34-38</a></div>
            <div class="sp-mail">
                <a href="mailto:info@startupfoto.ru">info@startupfoto.ru</a><br>
            </div>
            <div class="sp-lk"><a href="http://lk.startupfoto.ru/users/login/" title="Войти в личный кабинет">Личный кабинет</a></div>
        </div>
    </div>
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
                    <div class="news-list">
                        <?php foreach ($news as $value) : ?>
                        <div class="news-wrapper">
                            <div class="mini-img">
                                <img src="/files/.crop/<?=$value->mini?>" alt="mini">
                            </div>
                            <div class="anotation">
                                <h1><a href="<?=$value->id?>"><?=$value->title?></a></h1>
                                <div class="anotation-desc">
                                    <?=$value->anotation?>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="white-line">
                                <div class="border-dotted"></div>
                                <div class="border-none"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div id="footer">
                    <div id="footer2">
                        <div class="cop">
                            <div class="container ">
                                <ul class="menu" id="footermenu">
                                    <li class="item-106 deeper">
                                        <a href="/portfolio/">Наши работы</a>
                                    </li>
                                    <li class="item-109 deeper">
                                        <a href="/about/">О нас</a>
                                    </li>
                                    <li class="item-111 deeper">
                                        <a href="/prom/">Организация выпускного</a>
                                    </li>
                                    <li class="item-107 deeper">
                                        <a href="/video/">Видео</a>
                                     </li>
                                    <li class="item-110 deeper">
                                        <a href="/news/">Новости</a>
                                    </li>
                                    <li class="item-108 deeper">
                                        <a href="/contacts/">Контакты</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="soc">
                            <a title="Мы в Facebook" href="https://www.facebook.com/groups/169948596435926/"></a>
                            <a title="Мы в Одноклассниках" href="#"> </a>
                            <a title="Мы в Twitter" href="#"> </a>
                            <a title="Мы Вконтакте" href="http://vk.com/startupfoto"> </a>
                            <div class="copy">
                                2011-2014 © StartUP Foto
                                <a href="/">www.startupfoto.ru</a>
                            </div>
                            <div class="razr">
                                <address>г.Москва, ул. Новая Басманная, д. 35, офис 321</address>
                                <a href="tel:+74957766133">+7(495) 776-61-33</a>
                                <a href="tel:+79262690964">+7(926) 26-909-64</a><br>
                                <a href="mailto:info@startupfoto.ru">info@startupfoto.ru</a><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="afisha">
                 <div class="container mafisha"><div id="k2ModuleBox115" class="k2ItemsBlock mafisha"></div>
            </div>
        </body>
</html>
