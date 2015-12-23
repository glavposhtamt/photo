<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'bootstrap', 'admin', 'crop']);  ?>
    <title>Задать миниатюру</title>
</head>
<body>
<?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Выбор миниатюры:</h1>
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <?php if(!is_null($news) && !is_null($news->thumbnail)): ?>
                                    <img src="/files/.mini/<?=$news->thumbnail?>" alt="[Jcrop Example]" id="target" > 
                                <?php else: ?>
                                    <span class="label label-danger">В этой новости нет картинок!</span>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <section id="canvasbox">
                                    <?php if(!is_null($news) && !is_null($news->mini)) : ?>
                                        <img src="/files/.crop/<?=$news->mini?>" id="imgCrop" alt="Миниатюра">
                                    <?php endif; ?>
                                </section>
                                <div id="thumbnail-panel">
                                    <button id="release" class="btn btn-danger btn-sm">Убрать выделение</button> 
                                    <button id="crop" class="btn btn-info btn-sm">Обрезать</button> 
                                    <a href="/admin<?=$return?>" class="btn btn-warning">Назад</a>
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

</html>
