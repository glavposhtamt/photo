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
                    
            <?php require 'topmenu.php'; ?>
                                
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