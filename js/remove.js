
$.contextMenu({

    //selector: "footer",
    selector: ".filemanager ul li",

    items: {
        delete: { name: "Удалить", callback: function(key, opt){
            
            var span = opt.$trigger[0].getElementsByClassName('name')[0],
                name = span.textContent,
                path = scanDir.hashParse(),
                type = opt.$trigger[0].className.split(' ')[0];
            
            
            jQuery(opt.$trigger[0]).hide(500);
            
            console.log("Имя %s Путь %s ", name, path);
            
            $.post("/admin/dropfile", { path: path, name: name, type: type });
                      
        }},
    }
});