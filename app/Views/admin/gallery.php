<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
<?php 
    addCssAndJs($jsCSSLibs, ['jQuery','admin', 'bootstrap','folders', 'fontawesome', 'contextMenu', 'blueimp-gallery',
                             'jquery.cookie', 'gallery-scripts']);
?>

</head>
<body>
<?php include_once 'admin.php'; ?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Управление галереей -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                            <div class="slides"></div>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                        </div>
                        <div class="filemanager">
                            <div class="new-folder">
                                <i class="fa fa-folder-open-o fa-4x new-f"></i>
                                <a href="/admin/upload"><i class="fa fa-upload fa-4x"></i></a>
                            </div>
                            <div class="search">
                                <input type="search" placeholder="Find a file.." />
                            </div>


                             <div class="breadcrumbs"></div>

                                 <ul class="data" id="links"></ul>

                              <div class="nothingfound">
                                   <div class="nofiles"></div>
                                   <span>No files here.</span>
                              </div>

                        </div>
                        <button style="display:none" data-toggle="modal" data-target="#myModal"></button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                             <!-- Modal content-->
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                                         <h4 class="modal-title">Атрибуты изображения:</h4>
                                     </div>
                                 <div class="modal-body" id="modal-img-info">
                                   
                                    <form action="/admin/alt" method="post" id="alt-desc-img">
                                        <input type="text" name="alt" class="form-control" placeholder="Альтернативный текст">
                                        <input type="text" name="desc" class="form-control" placeholder="Описание картинки">
                                        <input type="hidden" name="url-path">
                                        <input type="hidden" name="img-path">
                                        <button class="form-control btn btn-success">Сохранить</button>
                                    </form>
                                    
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- End Modal -->
                        <script>
                            document.getElementById('links').onclick = function (event) {
                                event = event || window.event;
                                var target = event.target || event.srcElement,
                                    link = target.src ? target.parentNode : target,
                                    options = {index: link, event: event},
                                    links = this.querySelectorAll('a.files'),
                                    node = target.nodeName === 'a' ? target : target.parentNode; 
                                
                                node.className === 'files' ? blueimp.Gallery(links, options) : null;
                            };
                        </script>
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