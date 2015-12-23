<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'fontawesome', 'bootstrap', 'admin']);  ?>
    <title>Новости</title>
</head>
<body>
<?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Новости</h1>
                        <a class="add-new" href="/admin/news/add">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>
                            <span class="anchor">Создать новость</span>
                        </a>
                        <a href="#menu-toggle" id="news-position" class="add-new">
                            <span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true" ></span>
                            <span class="anchor">Показать/Скрыть</span>
                        </a>
                        <!-- Список новостей -->
                        <div class="list-group">
                            <?php foreach ($list as $value) : ?>
                                <a href="/admin/news/<?=$value->id?>" class="list-group-item" id="item<?=$value->id?>">
                                    <h4 class="list-group-item-heading"><?=$value->title?></h4>
                                    <p list-group-item-text><?=$value->date?></p>
                                </a>
                                <span class="remove-link" data-id="<?=$value->id?>" data-type="news">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </span>
                            <?php endforeach; ?>
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

</html>
