<?php include_once 'admin-header-default.php'; ?>
<?php include 'admin.php' ?>
<div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>
                    Новости
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true" id="rv"></span>
                    Создать новость
                </h1>
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Page Content -->
                        <form method="POST" action="/admin/news/add" id="add-news" role="form">
                            <input type="text" name="title" class="form-control  title" placeholder="Заголовок" required>
                            <textarea name="anotation" class="anotation form-control" placeholder="Анотация"></textarea>
                            <textarea name="editor2" id="editor2" rows="10" cols="80"></textarea>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'editor2' );
                            </script>
                            <input type="text" name="keywords" class="form-control input-row" placeholder="Ключевые слова">
                            <input type="submit" class="btn btn-success" value="Создать новость" >
                            <a href="/admin/news" class="btn btn-danger">Отмена</a>
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
                            <br>
                            <br>
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
    <script src="/js/uploadWidget.js"></script>
</body>

</html>