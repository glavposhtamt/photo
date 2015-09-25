jQuery(document).ready(function(){

    var x1, y1, x2, y2, crop = 'files/crop/', jcrop_api;      
    if($('#target').length > 0) {
        $('#target').Jcrop({ onChange: showCoords,onSelect: showCoords, minSize: [ 200, 140 ], maxSize: [ 200, 140 ]  }, function(){
            jcrop_api = this; 
        });
    }
    // Снять выделение	
    $('#release').click(function(e) {	
            release();
    });   
   // Изменение координат
    function showCoords(c){
        x1 = c.x;		
        y1 = c.y;		
        x2 = c.x2;		
        y2 = c.y2;
        var canvasImg = document.getElementById('target');
        var elem=document.getElementById('canvas');
        elem.width = 200;
        elem.height = 140;
        var canvas=elem.getContext('2d');
        canvas.drawImage(canvasImg, x1, y1, 200, 140, 0, 0, 200, 140);
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
                $.post('/admin/thumbnail/' + pageId, {'x1': x1, 'x2': x2, 'y1': y1, 'y2': y2, 'img': img, 'crop': crop}, function() {
                    release();
                    alert("Миниатюра выбрана!");
                });

            });
        });
    });
});

