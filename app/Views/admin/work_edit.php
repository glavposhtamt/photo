<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php 
        addCssAndJs($jsCSSLibs, ['jQuery', 'folders', 'bootstrap', 'fontawesome', 'admin', 'ckeditor', 
                                 'sortable', 'render-function-fm']);
    ?>
</head>
<body>
<?php include_once 'admin.php'; ?>
<div id="page-content-wrapper">
            <div class="container-fluid">
                <h1 data-id="<?=(isset($id)) ? $id : ''?>">
                    Наши работы
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true" id="rv"></span>
                    Редактировать работу
                </h1>
                <div class="row">
                    <div class="col-lg-8">
                        <?php if(isset($message)) : ?>
                            <span class="label label-success"><?=$message?></span>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control input-lg" id="work-type">
                                            <?php for($i = 0, $c = 1; $i < count($types); ++$i) : ?>
                                               <option value="<?=$c?>" <?=($work->type === $types[$i] ? 'selected' : '') ?> >
                                                   <?=$types[$i]?>
                                               </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                     <div class="form-group">
                                        <select class="form-control input-lg" id="work-class" 
                                            style="<?=($work->school_class === 0) ? 'display: none;' : '' ?>" name="work-class">
                                            <option>Класс</option>
                                            <?php for($i = 1; $i <= 11; ++$i) : ?>
                                                <option <?=($work->school_class == $i) ? 'selected' : '' ?> ><?=$i?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <select class="form-control input-lg" id="work-city">
                                            <option><?=$work->city ?></option>
                                            <option>Город</option>
                                            <?php foreach($school as $value) : ?>
                                                <option><?=$value->city?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control input-lg" id="work-institution" name="institution">
                                            <option value="<?=$work->institution?>"><?=$work->title?></option>
                                            <option>Учебное заведение</option>
                                            <?php foreach($inst as $value) : ?>
                                                <option value="<?=$value->id?>"><?=$value->title?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="number" class="form-control input-lg" placeholder="Год выпуска"
                                                    name="work-year" value="<?=$work->year?>" required>
                                                    
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control input-lg" cols="30" rows="5" name="work-desc"
                                                    placeholder="Описание" required ><?=$work->anotation?></textarea>
                                                    
                                    </div>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Ключевые слова"
                                                 name="work-keywords" value="<?=$work->keywords?>">
                                    </div>
                                    
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success btn-lg" value="Обновить">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <a href="/admin/work" class="btn btn-danger btn-lg">Отмена/Назад</a>
                                </div>   
                            </div>                            
                        </form>
                    </div>
                    <div class="col-lg-1">
                            <h4>Порядок:</h4>
                            <div id="container-img">
                                <?php foreach ($images as $value) : ?>
                                    <div class="drag">
                                        <img src="/files/.thumbail/<?=$value->file_name?>" data-id="<?=$value->file_id?>" />
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
                          <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                              Выбрать из галереи
                          </button>

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
                                    <!-- File Manager -->
                                    <div class="filemanager">
                                        
                                         <div class="breadcrumbs"></div>
                                         <ul class="data" id="links"></ul>

                                          <div class="nothingfound">
                                               <div class="nofiles"></div>
                                               <span>No files here.</span>
                                          </div>

                                    </div>
                                    <!-- End File Manager -->
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
                            <a href="/admin/thumbnail/work/<?=$work->id?>" target="_blank" class="btn btn-info btn-lg" >
                                Установить миниатюру
                            </a>
                        </div>
                        <div class="container_">
                            <h4>Установить водяные знаки:</h4>
                            <button class="btn btn-info btn-lg" id="news-watermark" data-news-id="<?=$work->id?>">
                                Подписать картинки
                            </button>
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