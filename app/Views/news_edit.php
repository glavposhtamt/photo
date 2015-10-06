<?php include_once 'admin-header-default.php'; ?>
<?php include_once 'admin.php'; ?>
<div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <h1>Редактирование новости</h1>
                        <?php if(isset($message)) : ?>
                        <span class="label label-success"><?=$message?></span>
                        <?php endif; ?>
                        <form method="POST" role="form" id="edit-pages">
                            <input name="title" type="text" class="form-control title" value="<?=$news->title?>"
                                     placeholder="Заголовок" required>
                                     
                            <textarea name="anotation" class="anotation form-control" placeholder="Анотация">
                                <?=$news->anotation?>
                            </textarea>
                            <textarea name="editor1" id="editor1" rows="10" cols="80">
                                <?=$news->news ?>
                            </textarea>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'editor1' );
                            </script>
                            <div class="row input-row">
                                <div class="col-lg-2">
                                    <input type="number" class="form-control" name="news-id" value="<?=$news->id?>" disabled="disabled">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="keywords" class="form-control" value="<?=$news->keywords?>" placeholder="Ключевые слова">
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker2'>
                                            <input type="text" name="date" value="<?=date_format($news->date, 'Y.m.d H:i')?>" class="form-control" >
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="button-panel">
                                <input type="submit" class="btn btn-success btn-lg" value="Сохранить">
                                <a href="/admin/news" class="btn btn-danger btn-lg">Отмена/Назад</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-1">
                            <h4>Порядок:</h4>
                            <div id="container-img">
                                <?php foreach ($images as $value) : ?>
                                    <div class="drag">
                                        <img src="/files/thumbail/<?=$value->file_name?>" data-id="<?=$value->file_id?>" />
                                        <span class="glyphicon glyphicon-trash" data-img="<?=$value->file_id?>"></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="btn btn-info btn-sm" id="savePosition">Сохранить</button>
                    </div>
                    <div class="col-lg-3" id="right-button-block">
                        <div class="container_">
                          <h4>Загрузка изображений:</h4>
                          <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Выбрать из галереи</button>

                          <!-- Modal -->
                          <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Выберите изображение</h4>
                                </div>
                                <div class="modal-body" id="modal-img-list">
                                    <?php foreach ($gallery as $value) : ?>
                                    <img src="/files/thumbail/<?=$value->name?>" alt="Выберите изображение" data-id="<?=$value->id?>">
                                    <?php endforeach; ?>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>

                            </div>
                          </div>

                        </div>
                        <div class="container_">                        
                            <h4>Настройка миниатюры:</h4>
                            <a href="/admin/thumbnail/news/<?=$news->id?>" target="_blank" class="btn btn-info btn-lg" >Установить миниатюру</a>
                        </div>
                        <div class="container_">
                            <h4>Установить водяные знаки:</h4>
                            <button class="btn btn-info btn-lg" id="news-watermark" data-news-id="<?=$news->id?>">Подписать картинки</button>
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
