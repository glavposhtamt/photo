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

    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'fontawesome', 'folders', 'jquery.cookie', 'bootstrap', 'ckeditor', 'admin', 
                                    'fileupload', 'minimalUploadWidget', 'jquery.cookie', 'render-function-fm']);  
    ?>
</head>
<body>
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
                       
                        <!-- Insert from Gallery -->
                       <button class="btn btn-info fileinput-button" data-toggle="modal" data-target="#myModal">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Выбрать изображения</span>
                        </button>
                        <br>
                        <br>
                        <!-- The fileinput-button span is used to style the file input field as button -->
                       <span class="btn btn-success fileinput-button upload-img">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Загрузить изображения</span>
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
        <?php require 'modal.php'; ?>
    </div>
    <!-- /#wrapper -->

</body>

</html>