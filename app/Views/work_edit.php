<?php include_once 'admin-header-default.php'; ?>
<?php include_once 'admin.php'; ?>
<div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>
                    Наши работы
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true" id="rv"></span>
                    Редактировать работу
                </h1>
                <div class="row">
                    <div class="col-lg-8">
                        <form method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control input-lg" id="work-type">
                                            <option value="1">Детский сад</option>
                                            <option value="2" selected>Школа</option>
                                            <option value="3">ВУЗ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                     <div class="form-group">
                                        <select class="form-control input-lg" id="work-class" name="work-class">
                                            <option>Класс</option>
                                            <?php for($i = 1; $i <= 11; ++$i) : ?>
                                                <option><?=$i?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <select class="form-control input-lg" id="work-city">
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
                                        <select class="form-control input-lg" id="work-institution" name="institution" disabled>
                                            <option>Учебное заведение</option>
                                            <?php for($i = 1; $i <= 2; ++$i) : ?>
                                                <option><?='ВУЗ ' . $i?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="number" class="form-control input-lg" placeholder="Год выпуска" name="work-year" required>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control input-lg" cols="30" rows="5" name="work-desc" placeholder="Описание" required></textarea>
                                    </div>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Ключевые слова" name="work-keywords">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success btn-lg" value="Создать работу">
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
                            <a href="/admin/thumbnail/work/<?=$work->id?>" target="_blank" class="btn btn-info btn-lg" >Установить миниатюру</a>
                        </div>
                        <div class="container_">
                            <h4>Установить водяные знаки:</h4>
                            <button class="btn btn-info btn-lg" id="news-watermark" data-news-id="<?=$work->id?>">Подписать картинки</button>
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