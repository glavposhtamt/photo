  <?php
    header("Cache-Control: no-store"); 
    header("Expires: " .  date("r"));
  ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'jquery.cookie', 'bootstrap', 'ckeditor', 'admin']);  ?>

    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="/bower_components/blueimp-load-image/js/load-image.all.min.js" ></script>
    <!-- The basic File Upload plugin -->
    <script src="/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="/js/jquery.fileupload-validate.js"></script>

    <script src="/js/uploadWidget.js"></script>
</head>
<body>
    <?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>
                    Наши работы
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true" id="rv"></span>
                    Создать работу
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
                                        <input type="number" class="form-control input-lg" placeholder="Год выпуска" 
                                               name="work-year" required>
                                               
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control input-lg" cols="30" rows="5" name="work-desc"
                                                  placeholder="Описание" required></textarea>
                                                  
                                    </div>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Ключевые слова"
                                               name="work-keywords">
                                               
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
                    <div class="col-lg-4">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button upload-img">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Выбрать изображения</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload" type="file" name="files[]" multiple>
                        </span>
                        <br><br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <div id="files" class="files"></div>
                        <br>                        
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
