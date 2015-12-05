/*-------------------------
	Parse Hash
-------------------------*/

folders.hashParse = function() {
        
        var hash = decodeURIComponent(location.hash).split('/'),
            path = '';
        for(var i = 0; i < hash.length; ++i){
            if(hash[i] === 'files'){
                ++i;
                for(; i < hash.length; i++){
                    path += ( hash[i] + '/' );
                }
            }
        }
        
       return path; 
    };

/*-------------------------
	Replace File
-------------------------*/

folders.replaceFile = function(){
        var that = this;
        $('li.files').on('dragstart', function (event) {
            var id = $(event.originalEvent.target.parentNode).data('id');
            event.originalEvent.dataTransfer.setData('id', id);
        });
        
        $('li.folders').on('drop', function(event){
            
            event.originalEvent.preventDefault();
            
            var some = event.originalEvent.target.parentNode,
                folderName = that.hashParse() + some.getElementsByClassName('name')[0].textContent,                      
                id = event.originalEvent.dataTransfer.getData('id'),
                selector = '#li' + id,
                $li = $(selector);
            
            if($li.length > 0) {
                var elem = $li[0].getElementsByClassName('name')[0],
                    imgName = elem.textContent,
                    imgPath = that.hashParse() + imgName;
                $.post('/admin/rename', { id: id, path: imgPath, newPath: folderName + '/' + imgName, name: imgName }, 
                function(data){
                    that.scanDir();
                });
                $li.remove();
            }
            else return;
            
        });
        
        $('li.folders').on('dragover', function(event){
            event.originalEvent.preventDefault();
        });
        
        $('li.folders').on('dragenter', function(event){
            event.originalEvent.preventDefault();
        });
};


/*-------------------------
	New Folder
-------------------------*/

jQuery(document).ready(function(){
    
    $('.new-folder i.new-f').click(function(){
        var folderName = prompt('Введите название папки');
        if(folderName){
            folderName = folderName.replace(/ /g, "-");
            $.post('/admin/newfolder', { name: '/' + folders.hashParse() + folderName}, function(){
                folders.scanDir();
            });
        }

    });
});

/*-------------------------
	Upload Files
-------------------------*/

folders.setUploadPath = function(){
    $.cookie('path', folders.hashParse(), {'path': '/admin/images'});
};

/*-------------------------
	Context Menu
-------------------------*/

/* Меню удаления */

folders.remove = {
    
    name: "Удалить",
    
    callback: function(key, opt){            
        var span = opt.$trigger[0].getElementsByClassName('name')[0],
            name = span.textContent,
            path = folders.hashParse(),
            type = opt.$trigger[0].className.split(' ')[0];

        var hideElement = opt.$trigger.parent();
        
        jQuery(hideElement).hide(500);

        $.post("/admin/dropfile", { path: path, name: name, type: type });                      
    }
};


/* Инициализация контекстного меню после загрузки страницы */

window.addEventListener('load', function() {
    $(".filemanager ul").contextMenu({

        selector: ".folders",

        items: { delete: folders.remove }

    });

    $(".filemanager ul").contextMenu({

        selector: ".files",

        items: {
            delete: folders.remove,

            alt: { 
                name: "Атрибуты",
                callback: function(key, opt){
                   var btn = jQuery('[data-toggle="modal"]')[0];        
                   jQuery.event.trigger('click', null, btn);
                    
                   var span = opt.$trigger[0].getElementsByClassName('name')[0],
                       name = span.textContent,
                       path = folders.hashParse();
                    
                    jQuery('[name="url-path"]').val(document.location.href);
                    jQuery('[name="img-path"]').val(path + name);                   

                }
            }

        }
    });
}, false);

/*-------------------------
	Function render()
-------------------------*/

/*-------------------------
	Run This Script
-------------------------*/

window.addEventListener('load', function(){
    folders.scanDir();
}, false);

