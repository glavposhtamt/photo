/*-------------------------
	Render function
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
              icon = '<i class="fa fa-folder fa-4x new-f"></i>';

           if(itemsLength) {
               icon = '<i class="fa fa-folder fa-4x new-f"></i>';
           }

           if(itemsLength == 1) {
               itemsLength += ' item';
           } else if(itemsLength > 1) {
               itemsLength += ' items';
           } else {
               itemsLength = 'Empty';
           }

           var folder = $('<li class="folders"><a href="'+ f.path +'" title="'+ f.path +'" class="folders">'+icon+'<span class="name">' + name + '</span></a></li>');
					folder.appendTo(that.fileList);
       });

    }

	if(scannedFiles.length) {

	   scannedFiles.forEach(function(f) {

           var fileSize = that.bytesToSize(f.size),
               name = that.escapeHTML(f.name),
               fileType = name.split('.'),
               icon = '',
               id = f.id,
               url = 'http://' + location.hostname + '/' + decodeURI(f.url);

               fileType = fileType[fileType.length-1];

                    var href = 'http://' + location.hostname +'/files/.thumbail/' + name;
                    icon = '<img src="'+ decodeURI(href) + '" >';
					var file = $('<li id="li'+ id +'" data-id="' + id + '" class="files">' + 
                                    '<a href="'+ url + '" class="files">' + icon + '</a>' + 
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

    that.fileList.show();
            

};


/*-------------------------
	Run This Script
-------------------------*/

window.addEventListener('load', function(){
    folders.scanDir();
}, false);