<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">

    <?php  addCssAndJs($jsCSSLibs, ['default-template']);  ?>

        <title>
            <?=$title?>
        </title>
</head>

<body>
    <div class="wrap">
        <?php require 'header.php'; ?>
            <div id="b1">
               
                <?php require 'topmenu.php'; ?>
                
                <?php require 'menu.php'; ?>
                
                <div class="item-pagebook1">                    
                    <div class="news-list">
                        <?php foreach ($news as $value) : ?>
                            <div class="news-wrapper">
                                <div class="mini-img">
                                    <?php if($value->mini) :?>
                                        <img src="/files/.crop/<?=$value->mini?>" alt="mini">
                                        <?php endif; ?>
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

                <?php require 'footer.php' ?>
            </div>
</body>

</html>