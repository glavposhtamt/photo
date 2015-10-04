jQuery(document).ready(function(){

    var coords = {}, jcrop_api;      
    if($('#target').length > 0) {
        $('#target').Jcrop({ onChange: showCoords,onSelect: showCoords, minSize: [ 200, 140 ], aspectRatio: 1.428 }, function(){
            jcrop_api = this; 
        });
    }
    // Снять выделение	
    $('#release').click(function(e) {	
            release();
    });   
   // Изменение координат
    function showCoords(c){
        coords = c;
        if(c.w > 0 && c.h > 0){
            $('#crop').show();
        }else{
            $('#crop').hide();
        }	
    }	
    function release(){
        jcrop_api.release();
        $('#crop').hide();
    }
    // Обрезка изображение и вывод результата
    jQuery(document).ready(function(){
        jQuery(function($){
            $('#crop').click(function() {
                var img = $('#target').attr('src');
                img = img.substring(1);
                var pageId = document.location.pathname.split("/").slice(-1)[0];
                var type = document.location.pathname.split("/").slice(3, -1)[0];
                var url = '/admin/thumbnail/' + pageId;
                $.post(url, {'x1': coords.x, 'x2': coords.x2, 'y1': coords.y, 'y2': coords.y2, 'img': img, 'type': type },
                       function(data) {
                            release();
                            var img = document.getElementById('imgCrop');
                            if(img !== null) img.remove();
                            var newImg = new Image();
                            newImg.src = 'http://' + document.location.host + '/' + data;
                            newImg.alt = 'Миниатюра';
                            newImg.id = 'imgCrop';
                            $("#canvasbox").append(newImg);
                });

            });
        });
    });
});

