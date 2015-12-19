<!DOCTYPE html>
<html>
<head>
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <meta charset="UTF-8">
        
    <?php  addCssAndJs($jsCSSLibs, ['default-template']);  ?>
        
    <title><?php if(!isset($title)) $title = 'Главная страница - StartUP'; echo $title;?></title>
    
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
        <div id="system-message-container"></div>
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
            <?php if(isset($post)) { echo $post; } ?>
        </div>
        <?php require 'footer.php' ?>
</body>