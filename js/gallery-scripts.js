/*-------------------------
	Parse Hash
-------------------------*/

folders.render = function(data) {

    var scannedFolders = [],
	    scannedFiles = [],
        that = this;

    if(Array.isArray(data)) {

	   data.forEach(function (d) {
           if (d.type === 'folder') {
               scannedFolders.push(d);
           } else if (d.type === 'file') {
               scannedFiles.push(d);
           }

       });

    } else if(typeof data === 'object') {

        scannedFolders = data.folders;
		scannedFiles = data.files;
    }

// Empty the old result and make the new one

	that.fileList.empty().hide();

	if(!scannedFolders.length && !scannedFiles.length) {
        that.filemanager.find('.nothingfound').show();
    } else {
	   that.filemanager.find('.nothingfound').hide();
    }

	if(scannedFolders.length) {

	   scannedFolders.forEach(function(f) {

		  var itemsLength = f.items.length,
              name = that.escapeHTML(f.name),
              icon = '<span class="icon folder"></span>';

           if(itemsLength) {
               icon = '<span class="icon folder full"></span>';
           }

           if(itemsLength == 1) {
               itemsLength += ' item';
           } else if(itemsLength > 1) {
               itemsLength += ' items';
           } else {
               itemsLength = 'Empty';
           }

           var folder = $('<li class="folders"><a href="'+ f.path +'" title="'+ f.path +'" class="folders">'+icon+'<span class="name">' + name + '</span> <span class="details">' + itemsLength + '</span></a></li>');
					folder.appendTo(that.fileList);
       });

    }

	if(scannedFiles.length) {

	   scannedFiles.forEach(function(f) {

           var fileSize = that.bytesToSize(f.size),
               name = that.escapeHTML(f.name),
               fileType = name.split('.'),
               icon = '<span class="icon file"></span>',
               id = f.id,
               url = 'http://' + location.hostname + '/' + decodeURI(f.url);

               fileType = fileType[fileType.length-1];

                    var href = 'http://' + location.hostname +'/files/.thumbail/' + name;
                    icon = '<img class="icon thumbnail" src="'+ decodeURI(href) + '" >';
					var file = $('<li id="li'+ id +'" data-id="' + id + '" class="files">' + 
                                    '<a href="'+ url + '" class="files">' + 
                                        icon + 
                                        '<span class="name">' + name + '</span>' + 
                                        '<span class="details">'+fileSize+'</span>' + 
                                    '</a>' + 
                                 '</li>');
					file.appendTo(that.fileList);
				});

    }


	// Generate the breadcrumbs

    var url = '';

	if(that.filemanager.hasClass('searching')){
        
        url = '<span>Search results: </span>';
		that.fileList.removeClass('animated');

    } else {

	   that.fileList.addClass('animated');
       that.breadcrumbsUrls.forEach(function (u, i) {

           var name = u.split('/');

           if (i !== that.breadcrumbsUrls.length - 1) {
               url += '<a href="'+u+'"><span class="folderName">' + name[name.length-1] + 
                      '</span></a> <span class="arrow">→</span> ';
               
           } else {
               url += '<span class="folderName">' + name[name.length-1] + '</span>';
           }

       });

    }

	that.breadcrumbs.text('').append(url);


	// Show the generated elements

	that.fileList.animate({'display':'inline-block'});
     //that.fileList.show();
            
     that.replaceFile();
     that.setUploadPath();

};


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

