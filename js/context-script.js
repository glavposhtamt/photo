var contextObject = {};

contextObject.remove = {
    
    name: "Удалить",
    
    callback: function(key, opt){            
        var span = opt.$trigger[0].getElementsByClassName('name')[0],
            name = span.textContent,
            path = scanDir.hashParse(),
            type = opt.$trigger[0].className.split(' ')[0];

        var hideElement = opt.$trigger.parent();
        
        jQuery(hideElement).hide(500);

        $.post("/admin/dropfile", { path: path, name: name, type: type });                      
    }
};


window.addEventListener('load', function() {
    $(".filemanager ul").contextMenu({

        selector: ".folders",

        items: { delete: contextObject.remove }

    });

    $(".filemanager ul").contextMenu({

        selector: ".files",

        items: {
            delete: contextObject.remove,

            alt: { 
                name: "Атрибуты",
                callback: function(key, opt){
                    var btn = jQuery('[data-toggle="modal"]')[0];        
                    jQuery.event.trigger('click', null, btn);
                    
                   var span = opt.$trigger[0].getElementsByClassName('name')[0],
                       name = span.textContent,
                       path = scanDir.hashParse();
                    
                    jQuery('[name="url-path"]').val(document.location.href);
                    jQuery('[name="img-path"]').val(path + name);                   

                }
            }

        }
    });
}, false);



