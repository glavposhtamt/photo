<!DOCTYPE html>
<html>

<head>
    <link href="http://startupfoto.ru/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <meta charset="UTF-8">

    <?php  addCssAndJs($jsCSSLibs, ['default-template']);  ?>

        <title>
            <?php if(!isset($title)) $title = 'Главная страница - StartUP'; echo $title;?>
        </title>

</head>

<body>
    <div class="wrap">
        <?php require 'header.php' ?>

            <div id="b1">

                <?php require 'topmenu.php'; ?>

                <?php require 'menu.php'; ?>

               <div class="item-pagebook1">
                   <div class="text page">
                       <div class="comment_sub_menu">
                           <table class="menu_items">
                               <tbody>
                                   <tr>
                                       <td class="menu_item">
                                           <a href="/review" class="link <?=$type == 'r' ? 'active' : '' ?>">Оставить отзыв</a>
                                       </td>
                                       <td class="menu_item">
                                           <a href="/question" class="link <?=$type == 'q' ? 'active' : '' ?>">Спросить совет</a>
                                       </td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                       <div class="comments">
                           <div class="red_popup review_add">
                               <form id="" class="form" method="post">
                                   <input name="type" value="<?=$type; ?>" type="hidden">
                                   <div class="field">
                                       <div class="name">Имя *: </div>
                                       <div class="val">
                                           <input name="author" placeholder="Имя" required type="text">
                                       </div>
                                   </div>
                                   <div class="field">
                                       <div class="name">E-mail *: </div>
                                       <div class="val">
                                           <input name="email" placeholder="e-mail@domain.com" required type="email">
                                       </div>
                                   </div>
                                   <div class="field">
                                       <div class="name">Телефон: </div>
                                       <div class="val">
                                           <input name="phone" placeholder="+7(978)866-73-78" type="phone">
                                       </div>
                                   </div>
                                   <div class="field">
                                       <div class="name">
                                           Учебное заведение *: 
                                        </div>
                                       <div class="val">
                                            <select name="institution">
                                                <option>Учебное заведение</option>
                                                <?php foreach($inst as $value) : ?>
                                                    <option value="<?=$value->id?>"><?=$value->title?></option>
                                                <?php endforeach; ?>
                                            </select>
                                       </div>
                                   </div>
                                   <div class="field">
                                       <div class="name">
                                           <?=$type == 'r' ? 'Отзыв *' : 'Вопрос *'; ?>: 
                                        </div>
                                       <div class="val">
                                           <textarea name="text" required></textarea>
                                       </div>
                                   </div>
                                   <div class="submit" style="text-align:center;">
                                       <input class="send" value="Добавить" type="submit">
                                   </div>
                               </form>
                           </div>
                       </div>
                       
                       <div id="reviews">
                           <?php foreach($re as $val) : ?>
                               <div class="block">
                                    <div class="rblock">
                                        <div class="name">
                                            <h3><?=$val->author?> <?=$val->title ? '(' . $val->title . ')' : ''?></h3>
                                        </div>
                                        
                                        <div class="rbody"><?=$val->message ?></div>
                                    </div>
                                    
                                    <?php $a = $answ($val->id); foreach($a as $val2) : ?>
                                        <div class="ablock">
                                            <div class="name">
                                                <h3>Администратор сайта</h3>
                                            </div>
                                            
                                            <div class="rbody"><?=$val2->answer?></div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                               </div>
                           <?php endforeach; ?>
                       </div>
                       
                   </div>
               </div>
               
               <?php require 'footer.php' ?>

            </div>
        </div>
</body>