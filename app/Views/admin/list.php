<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'bootstrap', 'admin']);  ?>
    <title>Страницы сайта</title>
</head>
<body>
<?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="list-group">
                            <h1>Страницы</h1>
                            <?php foreach ($arr as $value): ?>
                            
                                <a href="/admin/page/<?=$value->id ?>" class="list-group-item">
                                    <h4 class="list-group-item-heading"><?=$value->title ?></h4>
                                    <p list-group-item-text>
                                        <?php echo $func($value->route) !== '' ? '(' . $func($value->route) . ") $value->date"  : $value->date; ?>
                                    </p>
                                </a>
                                <a href="/<?=$value->route ?>" class="link-on-page" target="_blank">
                                    <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
                                </a>
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
