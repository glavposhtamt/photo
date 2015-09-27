<?php include_once 'admin-header-default.php'; ?>
<?php include_once 'admin.php'; ?>
<div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>
                    Наши работы
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true" id="rv"></span>
                     Добавить учебное заведение
                </h1>
                <div class="row">
                    <div class="col-lg-6">
                        <?php if(isset($message)) : ?>
                            <span class="label label-success">Учебное заведение успешно добавлено!</span>
                        <?php endif; ?>
                            
                        <form method="POST" action="/admin/institution/">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" name="title" placeholder="Название учебного заведения" required>
                            </div>
                            <div class="form-group">
                                <label>Тип учебного заведения:</label>
                                <select class="form-control input-lg" name="type">
                                    <option value="1">Детский сад</option>
                                    <option value="2" selected>Школа</option>
                                    <option value="3">ВУЗ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Город:</label>
                                <select class="form-control input-lg" name="sity" id="sity-target">
                                    <?php if(!empty($sity)) : foreach ($sity as $value): ?>
                                        <option value="<?=$value->sity?>"><?=$value->sity?></option>
                                    <?php endforeach; endif; ?>
                                        <option>Другой вариант</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="other-sity" class="form-control input-lg" id="other-sity" placeholder="Введите город" required>
                            </div>
                            <input type="submit" class="btn btn-success btn-lg" value="Сохранить">
                        </form>
                    </div>
                    <div class="col-lg-5 col-lg-offset-1">
                        
                        <table class="table table-striped table table-condensed">
                            <thead>
                                <tr class="info">
                                    <th>№</th>
                                    <th>Тип</th>
                                    <th>Название</th>
                                    <th>Город</th>
                                </tr>                                
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($inst as $value): ?>
                                    <tr class="">
                                        <td><?=$i++?></td>
                                        <td><?=$value->type?></td>
                                        <td><?=$value->title?></td>
                                        <td><?=$value->sity?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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