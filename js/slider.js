/*Рамка*/
jQuery(document).ready(function(){
    $(".carousel img").click(function(){
        var img = $(".carousel img");
        for(var i = 0; i < img.length; ++i) {
            img[i].style.border = "";
        }
        var that = this;
        $("#big-img")[0].src = that.src;
        $("#box-big-img a")[0].href = that.src;
        that.style.border = "3px solid #ffaa00";
    });
});

/*Увеличение размера*/
jQuery(document).ready(function(){
    $("#box-big-img").hover(function(){
        $( "#fullscreen-img" ).fadeIn( 500 );
    },
    function(){
        $( "#fullscreen-img" ).fadeOut( 300 ).finish();

    });
});