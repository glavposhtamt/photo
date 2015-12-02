<!DOCTYPE html>
<html>
<head>
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <meta charset="UTF-8">
        
    <?php  addCssAndJs($jsCSSLibs, ['default-template']);  ?>
        
    <title><?php if(!isset($title)) $title = 'Главная страница - StartUP'; echo $title;?></title>
     
      <!--<noindex><script async src="data:text/javascript;charset=utf-8;base64,ZnVuY3Rpb24gbG9hZHNjcmlwdChlLHQpe3ZhciBuPWRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoInNjcmlwdCIpO24uc3JjPSIvL2xwdHJhY2tlci5ydS9hcGkvIitlO24ub25yZWFkeXN0YXRlY2hhbmdlPXQ7bi5vbmxvYWQ9dDtkb2N1bWVudC5oZWFkLmFwcGVuZENoaWxkKG4pO3JldHVybiAxfXZhciBpbml0X2xzdGF0cz1mdW5jdGlvbigpe2xzdGF0cy5zaXRlX2lkPTEyNTE7bHN0YXRzLnJlZmVyZXIoKX07dmFyIGpxdWVyeV9sc3RhdHM9ZnVuY3Rpb24oKXtqUXN0YXQubm9Db25mbGljdCgpO2xvYWRzY3JpcHQoInN0YXRzX2F1dG8uanMiLGluaXRfbHN0YXRzKX07bG9hZHNjcmlwdCgianF1ZXJ5LTEuMTAuMi5taW4uanMiLGpxdWVyeV9sc3RhdHMp"></script></noindex>-->
</head>
    <body>
       <?php require 'navbar.php'; ?>
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
                                        <a href="/info">Информация</a>
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
                                    <li class="item-142"><a href="/student/info">Инфо</a>
                                    </li><li class="item-143">
                                        <a href="/student/price">Цены</a>
                                    </li><li class="item-144">
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
                <div id="bodym"> 						 
                    <div class="container ">
                        <ul class="menu" id="bodym">
                            <li class="item-106">
                                <a href="/portfolio/">Наши работы</a>
                            </li>																</li>
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
            <?php require 'footer.php' ?>
    </body>
</html>