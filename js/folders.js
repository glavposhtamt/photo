var folders = {
    breadcrumbsUrls: [],
    folders: [],
    files: [],
    filemanager: null,
    breadcrumbs: null,
    fileList: null,
    currentPath: '',

    // This function escapes special html characters in names
	escapeHTML:	function (text) {
		return text.replace(/\&/g,'&amp;').replace(/\</g,'&lt;').replace(/\>/g,'&gt;');
	},
    
    // Convert file sizes from bytes to human readable units
    bytesToSize: function (bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Bytes';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    },
    
    // Splits a file path and turns it into clickable breadcrumbs
	generateBreadcrumbs: function (nextDir){
        var path = nextDir.split('/').slice(0);
		for(var i=1;i<path.length;i++){
		  path[i] = path[i-1]+ '/' +path[i];
		}
		return path;
    },
    
    // Locates a file by path
	searchByPath: function (dir, response) {
		var path = dir.split('/'),
		demo = response,
		flag = 0;

		for(var i=0;i<path.length;i++){
		  for(var j=0;j<demo.length;j++){
			if(demo[j].name === path[i]){
				flag = 1;
				demo = demo[j].items;
				break;
            }
          }
		}

		demo = flag ? demo : [];
		return demo;
    },
    
	// Recursively search through the file tree
    searchData: function(data, searchTerms) {
        
        var that = this;

        data.forEach(function(d){
            if(d.type === 'folder') {

			    that.searchData(d.items,searchTerms);

				if(d.name.toLowerCase().match(searchTerms)) {
				    that.folders.push(d);
				}
            } else if(d.type === 'file') {
                if(d.name.toLowerCase().match(searchTerms)) {
				    that.files.push(d);
				}
              }
			});
        return {folders: that.folders, files: that.files};
    },
    
    
    // Init filemanager, breadcrumbs, fileList
    initProperty: function(){
        this.filemanager = $('.filemanager');
        this.breadcrumbs = $('.breadcrumbs');
        this.fileList = $('.filemanager').find('.data');
    }
};

    // Navigates to the given hash (path)

folders.goto = function(hash, response, data) {
    var that = this;
    hash = decodeURIComponent(hash).slice(1).split('=');

	if (hash.length) {
	   var rendered = '';
        
	// if hash has search in it

        if (hash[0] === 'search') {

		  that.filemanager.addClass('searching');
		  rendered = that.searchData(response, hash[1].toLowerCase());

		  if (rendered.length) {
		      that.currentPath = hash[0];
			  that.render(rendered);
          }	else {
						that.render(rendered);
          }

		}
    // if hash is some path

        else if (hash[0].trim().length) {

            rendered = that.searchByPath(hash[0], response);

			if (rendered.length) {

				that.currentPath = hash[0];
				that.breadcrumbsUrls = that.generateBreadcrumbs(hash[0]);
				that.render(rendered);

			} else {
				that.currentPath = hash[0];
				that.breadcrumbsUrls = that.generateBreadcrumbs(hash[0]);
				that.render(rendered);
			}

        }

    // if there is no hash

	   else {
           that.currentPath = data.path;
           that.breadcrumbsUrls.push(data.path);
           that.render(that.searchByPath(data.path, response));
       }
    }
};

folders.scanDir = function(){
    var that = this;
    
    this.initProperty();

	// Start by fetching the file data from scan.php with an AJAX request

	$.get('/admin/scan', function(data) {
        data = jQuery.parseJSON(data);

		var response = [data];

		var folders = [],
			files = [];

		// This event listener monitors changes on the URL. We use it to
		// capture back/forward navigation in the browser.

		$(window).on('hashchange', function(){

			that.goto(window.location.hash, response, data);

			// We are triggering the event. This will execute 
			// this function on page load, so that we show the correct folder:

		}).trigger('hashchange');


		// Hiding and showing the search box

		that.filemanager.find('.search').click(function(){

			var search = $(this);

			search.find('span').hide();
			search.find('input[type=search]').show().focus();

		});


		// Listening for keyboard input on the search field.
		// We are using the "input" event which detects cut and paste
		// in addition to keyboard input.

		that.filemanager.find('input').on('input', function(e){

			folders = [];
			files = [];

			var value = this.value.trim();

			if(value.length) {

				that.filemanager.addClass('searching');

				// Update the hash on every key stroke
				window.location.hash = 'search=' + value.trim();

			}

			else {

				that.filemanager.removeClass('searching');
				window.location.hash = encodeURIComponent(that.currentPath);

			}

		}).on('keyup', function(e){

			// Clicking 'ESC' button triggers focusout and cancels the search

			var search = $(this);

			if(e.keyCode == 27) {

				search.trigger('focusout');

			}

		}).focusout(function(e){

			// Cancel the search

			var search = $(this);

			if(!search.val().trim().length) {

				window.location.hash = encodeURIComponent(that.currentPath);
				search.hide();
				search.parent().find('span').show();

			}

		});


		// Clicking on folders

		that.fileList.on('click', 'li.folders', function(e){
			e.preventDefault();

			var nextDir = $(this).find('a.folders').attr('href');

			if(that.filemanager.hasClass('searching')) {

				// Building the breadcrumbs

				that.breadcrumbsUrls = that.generateBreadcrumbs(nextDir);

				that.filemanager.removeClass('searching');
				that.filemanager.find('input[type=search]').val('').hide();
				that.filemanager.find('span').show();
			}
			else {
				that.breadcrumbsUrls.push(nextDir);
			}

			window.location.hash = encodeURIComponent(nextDir);
			that.currentPath = nextDir;
		});


		// Clicking on breadcrumbs

		that.breadcrumbs.on('click', 'a', function(e){
			e.preventDefault();

			var index = that.breadcrumbs.find('a').index($(this)),
				nextDir = that.breadcrumbsUrls[index];

			that.breadcrumbsUrls.length = Number(index);

			window.location.hash = encodeURIComponent(nextDir);

		});

        
	});
};

// Render the HTML for the file manager

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
