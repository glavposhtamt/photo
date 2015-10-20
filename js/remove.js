
$.contextMenu({

    //selector: "footer",
    selector: "ul li",

    items: {
        delete: { name: "Удалить", callback: function(key, opt){ 
            var span = opt.$trigger[0].getElementsByClassName('name')[0],
                name = span.textContent,
                path = scanDir.hashParse();
            
            
            jQuery(opt.$trigger[0]).hide(500);
            
            console.log(path);
            
            $.post("/admin/dropfile", { path: path, name: name }, function(){
                
            });
                      
        }},
    }
});