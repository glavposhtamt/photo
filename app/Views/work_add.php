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
                    <div class="col-lg-9">
                        <form method="POST">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control input-lg" name="type">
                                            <option value="1">Детский сад</option>
                                            <option value="2" selected>Школа</option>
                                            <option value="3">ВУЗ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <select class="form-control input-lg" name="type">
                                            <?php for($i = 1; $i <= 2; ++$i) : ?>
                                                <option><?='ВУЗ ' . $i?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control input-lg" name="type">
                                            <?php for($i = 1; $i <= 11; ++$i) : ?>
                                                <option><?=$i?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2"><h4>г. Джанкой</h4></div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Улица, номер дома">
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
                    <div class="col-lg-3">
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
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
var response$;
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'http://' + location.host +'/admin/images',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Отмена')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });

            });
            
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').addClass("wrapper").appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
            var input1 = '<input type="text" class="alt-img form-control" placeholder="Альтернативный текст"/>';
            var input2 = '<input type="text" class="info-img form-control" placeholder="Описание картинки"/>';
            var form = $('<form/>').addClass("desc-img-form").appendTo(data.context);
            $(form).append( input1 + input2 );
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Загрузить')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        response$ = data;
        setDescAndTitle(data.result.files[0].id, data.context[0].lastChild);
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
</body>

</html>
