<?php include_once 'admin-header-default.php'; ?>
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
                                        <select class="form-control input-lg" id="work-type" name="work-type">
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
                                        <select class="form-control input-lg" id="work-city" name="work-city">
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
                                        <select class="form-control input-lg" name="institution" id="work-institution" disabled>
                                            <option>Учебное заведение</option>
                                            <?php for($i = 1; $i <= 2; ++$i) : ?>
                                                <option><?='ВУЗ ' . $i?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Год выпуска">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control input-lg" name="" id="" cols="30" rows="5" placeholder="Описание"></textarea>
                                    </div>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Ключевые слова">
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
    <!-- /#wrapper -->
    <!--Scripts -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="/bower_components/blueimp-load-image/js/load-image.all.min.js" ></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="/bower_components/blueimp-canvas-to-blob/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="/js/jquery.fileupload-validate.js"></script>
    <!-- jQuery Cookie -->
    <script src="/bower_components/jquery.cookie/jquery.cookie.js"></script>
    <!--Скрипт для виджета загрузки файлов-->
    <script src="/js/uploadWidget.js"></script>
</body>

</html>
