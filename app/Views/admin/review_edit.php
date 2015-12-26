<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">

    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'fontawesome', 'bootstrap', 'ckeditor', 'admin']); ?>

        <title>Отзывы/Вопросы</title>
</head>

<body>
    <?php include_once 'admin.php'; ?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-7 col-md-5">
                                <h3><?=$re->type === 'r' ? 'Отзыв' : 'Вопрос'?> (<?=$re->status ? 'Одобрено' : 'Ожидает проверки'?>)</h3>
                                
                                <?php if($suck) : ?>
                                    <span class="label label-success"><?=$suck?></span>
                                <?php endif; ?>
                                
                                <form method="POST" role="form" id="edit-pages">
                                    <input name="author" type="text" class="form-control title" value="<?=$re->author?>" placeholder="Имя" required>
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input name="email" type="email" class="form-control title" value="<?=$re->email?>" placeholder="E-mail" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input name="phone" type="phone" class="form-control title" value="<?=$re->phone?>" 
                                                   placeholder="Телефон" required>
                                        </div>
                                    </div>  
                                    
                                     <select class="form-control title" id="work-institution" name="institution">
                                         <option value="0">Учебное заведение</option>
                                         <?php foreach($inst as $val) : ?>
                                             <option value="<?=$val->id?>" <?=$re->title === $val->title ? 'selected' : '' ?> >
                                                 <?=$val->title ?>
                                             </option>
                                         <?php endforeach; ?>
                                     </select>                                
                                    
                                    <textarea name="editor1" id="editor1" rows="10" cols="80">
                                        <?=$re->message ?>
                                    </textarea>
                                    
                                    <script>
                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        CKEDITOR.replace('editor1');
                                    </script>
                                    
                                    <div class="button-panel">
                                        <input name="public" type="submit" class="btn btn-success btn-lg" value="Опубликовать">
                                        <input name="save" type="submit" class="btn btn-info btn-lg" value="Сохранить">
                                        <input name="disable" type="submit" class="btn btn-danger btn-lg" value="Отклонить">
                                        <a href="/admin/review" class="btn btn-warning btn-lg">Отмена/Назад</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <h3>Ответы:</h3>
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