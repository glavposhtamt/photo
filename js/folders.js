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
        that.breadcrumbsUrls = [];

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



folders.render = function(data){
    // Render the HTML for the file manager
};