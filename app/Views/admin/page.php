<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'bootstrap', 'admin', 'ckeditor']);  ?>
</head>
<body>
<?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Редактирование страницы</h1>
                        <?php if(isset($message)) : ?>
                        <span class="label label-success"><?=$message?></span>
                        <?php endif; ?>
                        <form method="POST" role="form" id="edit-pages">
                            <input name="title" type="text" class="form-control title" placeholder="Название страницы"
                                   value="<?=$post->title?>" required>
                                   
                            <textarea name="editor1" id="editor1" rows="10" cols="80">
                                <?=$post->post ?>
                            </textarea>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'editor1' );
                            </script>
                             <div class="button-panel">
                                <a href="/<?=$post->route ?>" class="btn btn-default btn-lg" target="_blank">Перейти</a>
                                <input type="submit" class="btn btn-success btn-lg" value="Сохранить">
                                <a href="/admin/page" class="btn btn-danger btn-lg">Отмена/Назад</a>
                            </div>
                        </form>
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