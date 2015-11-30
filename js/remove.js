var contextObject = {};

contextObject.remove = {
    
    name: "Удалить",
    
    callback: function(key, opt){

        var span = opt.$trigger[0].getElementsByClassName('name')[0],
            name = span.textContent,
            path = scanDir.hashParse(),
            type = opt.$trigger[0].className.split(' ')[0];


        jQuery(opt.$trigger[0]).hide(500);

        console.log("Имя %s Путь %s ", name, path);
        $.post("/admin/dropfile", { path: path, name: name, type: type });
                      
    }
};

$(".filemanager ul").contextMenu({

    selector: ".folders",
    
    items: { delete: contextObject.remove }
    
});

$(".filemanager ul").contextMenu({

    selector: ".files",
    
    items: {
        delete: contextObject.remove,
        
        setAlt: { 
            name: "Альтернативный текст",
            callback: function(key, opt){
                console.log(key);
                console.log(opt);
            }
        }
        
    }
});


