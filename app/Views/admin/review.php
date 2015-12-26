<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">

    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'fontawesome', 'bootstrap', 'admin']);  
    ?>
    <title>Отзывы/Вопросы</title>
</head>
<body>
<?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <h3>Отзывы:</h1>
                                <div class="list-group">
                                   <?php foreach($re as $val) : ?>
                                    <a href="review/<?=$val->id?>" class="list-group-item <?=!$val->status ? 'active' : '' ?>">
                                        <h4 class="list-group-item-heading"><?=$val->author?></h4>
                                        <p class="list-group-item-text">(<?=$val->type?>) <?=$val->title?></p>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <h3>Вопросы:</h1>
                                <div class="list-group">
                                   <?php foreach($qu as $val) : ?>
                                    <a href="review/<?=$val->id?>" class="list-group-item <?=!$val->status ? 'active' : '' ?>">
                                        <h4 class="list-group-item-heading"><?=$val->author?></h4>
                                        <p class="list-group-item-text">(<?=$val->type?>) <?=$val->title?></p>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        
        <!-- #riht-frame -->
        <div id="right-frame"></div>
        <!-- /#riht-frame -->
        <div class="clear"></div>
    </div>
    <!-- /#wrapper -->
</body>