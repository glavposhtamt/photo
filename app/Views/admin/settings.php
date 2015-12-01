<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php  addCssAndJs($jsCSSLibs, ['jQuery', 'bootstrap', 'admin']);  ?>
</head>
<body>
<?php include_once 'admin.php'; ?>
    <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 id="settings-h1">Настройки</h1>
                        <div class="row">
                            <div class="col-lg-6">
                                <h3>Смена пароля:</h3>
                                <form role="form" class="settings">
                                    <input type="password" name="old-pass" class="form-control" placeholder="Старый пароль">
                                    <input type="password" name="new-pass" class="form-control" placeholder="Новый пароль">
                                    <input type="password" name="confirm-pass" class="form-control"
                                            placeholder="Повотрите новый пароль">
                                            
                                    <input type="submit" class="btn btn-info btn-lg" value="Изменить пароль">
                                </form>
                            </div>
                            <div class="col-lg-4 col-lg-offset-1">
                                    <h3>Выбор водяного знака:</h3>
                                    <!-- Trigger the modal with a button -->
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" 
                                            data-target="#myModal">Выбрать из галереи</button>
                                            
                                    <div id="water-zone">
                                        <?php if($file_name): ?>
                                            <img id="water-img" alt="watermark" src="/files/<?=$file_name?>">
                                        <?php endif; ?>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Выберите изображение</h4>
                                            </div>
                                            <div class="modal-body" id="modal-water-list">
                                                <?php foreach ($gallery as $value) : ?>
                                                <img src="/files/.thumbail/<?=$value->name?>" alt="Выберите изображение" 
                                                    data-id="<?=$value->id?>">
                                                    
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                        
                                            </div>
                                        </div>

                                      </div>
                                    </div>                           
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

</html>
