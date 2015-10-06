
/*Делает меню активным*/

window.onload = function() {
    var nodes = document.querySelectorAll(".sidebar-nav a");
    for(var i = 0; i < nodes.length; ++i){
        nodes[i].className = '';
        if(nodes[i].href === window.location.href) {
            nodes[i].className = "active-menu";
        }
                    
    }
};

/*Ajax удаление новости*/

jQuery( document ).ready(function() {
   $(".remove-link").click(function() {
        var bool = confirm("Подтвердите действие");
        if(!bool) return;
        var that = this;
        var id = $(that).data("id");
        var type = $(that).data("type");
        $.post('/admin/delete/', { type: type, id: id }, function(){
            $(that).remove();
            $('#item' + id).remove();            
        });        
   });   
});

/* Menu Toggle Script */

jQuery(document).ready(function(){
    $("#news-position").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
});

/* Datetimepicker */
jQuery(document).ready(function(){
    $(function () {
        if($('#datetimepicker2').length > 0){
            $('#datetimepicker2').datetimepicker({
               locale: 'ru'
            });
        }
    });
});


/* Позиции картинок */

function position(message){
    var obj = $(".drag img"), names = {};
    for(var i = 0; i < obj.length; ++i) {
        names[$(obj[i]).data("id")] = i;
    }
    var dataH1 = document.querySelector("h1[data-id]");
    names.id = $(dataH1).data('id');
    console.log("Тип: %s", names.id);
    var type = document.location.pathname.split("/").slice(2, -1)[0];
    console.log("Тип %s ", type);
    var strImgName = JSON.stringify(names);
        
    $.post("/admin/position", { position: strImgName, type: type }, function(){ message ? alert("Изменено!") : ''; });
}

function removeImg(that) {
    $(that).parent().remove();
    $.post("/admin/removeimg", { file_id: $(that).data("img") }, function(data){
        alert("Удалено!");
        position(false);
    });
}


jQuery(document).ready(function(){
    $("#savePosition").click(function(){
        position(true);
    });

});

/* Выбрать картинку */


window.addEventListener('load', function(){
    var list = document.querySelectorAll("#modal-img-list img");
    
    for (var i = 0, len = list.length; i < len; i++) {
        list[i].addEventListener('click', function(){
            var that = this;
            var clone = that.cloneNode(true);
            that.remove();
            var dataH1 = document.querySelector("h1[data-id]");
            var pageId = $(dataH1).data('id');
            var fileName = clone.src.split("/").slice(-1)[0];
            var div = document.createElement("div");
            var span = document.createElement("span");
            div.className += "drag";
            span.className += "glyphicon glyphicon-trash";
            span.dataset.img = $(clone).data("id");
            $(span).bind("click", function(){ var that = this; removeImg(that); });
            var container = document.getElementById("container-img");
            var type = document.location.pathname.split("/").slice(2, -1)[0];
            container.appendChild(div);
            div.appendChild(clone);
            div.appendChild(span);
            $('.drag').draggable();
            $.post("/admin/bind", { file_id: $(clone).data("id"), file_name: decodeURI(fileName), id: pageId, type: type }, 
                function(data){
                    console.log(data);
                    position(false);
                });
        }, false);
    }

}, false);

/* Удаление картинки */

jQuery(document).ready(function(){
    $(".drag span.glyphicon").click(function(){
        var that = this;
        removeImg(that);
        
    });
});

/* Добавляем альтернативный текст */

var setDescAndTitle = function(id, form){
    var alt = form.children[0].value;
    var desc = form.children[1].value;
    $.post("/admin/attache", { id: id, title: alt, description: desc  });
};

/*Водяной знак (настройки)*/

(function(){                                      

        var PROPERTIES = {                             
          position: "absolute",
          visibility: "hidden",
          display: "block"
        };

        window.getDimensions = function(element) {     

          var previous = {};                            
          for (var key in PROPERTIES) {
            previous[key] = element.style[key];
            element.style[key] = PROPERTIES[key];
          }

          var result = { 
            width: element.offsetWidth,
            height: element.offsetHeight
          };

          for (key in PROPERTIES) {
            element.style[key] = previous[key];
          }
          return result;
        };

      })();

jQuery(document).ready(function(){
    $("#modal-water-list img").click(function(){
        var that = this;
        var clone = that.cloneNode(true);
        var imgName = decodeURI(clone.src.split("/").slice(-1)[0]);
        var parts, ext = ( parts = imgName.split("/").pop().split(".") ).length > 1 ? parts.pop() : "";
        if(ext !== 'png'){
            alert('Необходимо загрузить картинку формата png');
            return;
        }
        var img = new Image();
        img.src = 'http://' + window.location.host + '/files/' + imgName;
        img.id = "water-img";
        img.display = 'none';
        $("#water-zone").append(img);
        var dimensions = getDimensions(img);
        if( dimensions.width > 200 && dimensions.height > 200 ){
            $(img).remove();
            alert('Максимальный размер картинки 200 × 200');
            return;
        }
        if($("#water-zone").children().length === 2 &&
                $("#water-zone").children()[0].display !== 'none'){
            $("#water-zone").children()[0].remove();
        }
        img.display = 'block';
        $.post("/admin/setwatermark/", { file_id: $(clone).data('id'), file_name: imgName  });

    });

});

/*Водяной знак (подпись)*/

jQuery(document).ready(function(){
    jQuery('#news-watermark').click(function(){
        var that = this;
        var type = document.location.pathname.split("/").slice(2, -1)[0];
        $.post('/admin/watermark/' + $(that).data('news-id'),{ type: type } , function(data){ alert(data); });
    });
});

/* Добавление поля в форму учебных заведений */

jQuery(document).ready(function(){
    var input = document.getElementById('other-city');
    if($("#сity-target option").length === 1){
        input.type = 'text';
    }
    $( "#city-target" ).change(function() {
        var str = "";
        $( "#city-target option:selected" ).each(function() {
            str += $( this ).text();
            if(str === 'Другой вариант' ){
                input.type = 'text';
            }else if(str !== 'Другой вариант' && input.value === '' && input.type === 'hidden') return;
            else {
                input.type = 'hidden';
                input.value = '';
            }
        });
    });
});

/* Умная динамичная форма */

jQuery(document).ready(function(){
    var type, city, createOption = function(val, text, parent){
        var option = document.createElement('option');
        option.value = val;
        option.text = text;
        parent.appendChild(option);
    };
    $("#work-type").change(function(){
        $("#work-type option:selected").each(function() {
            type = $(this).text().trim();
            $("#work-city")[0].disabled = true;
            $("#work-institution")[0].disabled = true;
            if(type !== 'Школа') $("#work-class").hide(500);
            else $("#work-class").show(500);
            $.post("/admin/smartform/", { query: 'city', type: type }, function(data){
                var arr = jQuery.parseJSON(data);
                if(arr.length > 0){
                    $("#work-city").children().remove();
                    createOption('Город', 'Город', $("#work-city")[0]);
                    for(var i = 0; i < arr.length; ++i){
                        createOption(arr[i], arr[i], $("#work-city")[0]);
                    }
                    $("#work-city")[0].disabled = false;
                }else $("#work-city")[0].disabled = true;
            });
        });
    });
    
    $("#work-city").change(function(){
        $("#work-city option:selected").each(function() {
            city = $(this).text();
            type = type === undefined ? 'Школа' : type;
            if(city !== 'Город'){
                $.post("/admin/smartform/", { query: 'institution', type: type, city: city }, function(data){
                    var arr = jQuery.parseJSON(data);
                    $("#work-institution").children().remove();
                    createOption('Учебное заведение', 'Учебное заведение', $("#work-institution")[0]);
                    
                    for(var prop in arr){ 
                        createOption(prop, arr[prop], $("#work-institution")[0]); 
                    }
                    $("#work-institution")[0].disabled = false;
                });
            }else return;
            
        });
    });
});

/* Удаление учебных заведений */

jQuery(document).ready(function(){
    jQuery('td .glyphicon-trash').click(function(){
        var that = this;
        $.post('/admin/remove/institution', { id: $(that).data('id') }, function(){
            $(that).parent().parent().remove();
        });
    });
});