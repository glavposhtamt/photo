<?php include_once 'admin-header-default.php'; ?>
<?php include_once 'admin-header-file.php'; ?>
</head>
<?php include_once 'admin.php'; ?>
<div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Управление галереей -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                            <div class="slides"></div>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                        </div>
                        <div class="filemanager">
                            <div class="new-folder">
                                <i class="fa fa-folder-open-o fa-4x new-f"></i>
                                <a href="/admin/upload"><i class="fa fa-upload fa-4x"></i></a>
                            </div>
                            <div class="search">
                                <input type="search" placeholder="Find a file.." />
                            </div>


                             <div class="breadcrumbs"></div>

                                 <ul class="data" id="links"></ul>

                              <div class="nothingfound">
                                   <div class="nofiles"></div>
                                   <span>No files here.</span>
                              </div>

                        </div>

                                    <!-- Include our script files -->

                         <script src="/js/folders.js"></script>
                         <script src="/js/remove.js"></script>
                         <script>
                            document.getElementById('links').onclick = function (event) {
                                event = event || window.event;
                                var target = event.target || event.srcElement,
                                    link = target.src ? target.parentNode : target,
                                    options = {index: link, event: event},
                                    links = this.querySelectorAll('a.files'),
                                    node = target.nodeName === 'a' ? target : target.parentNode; 
                                
                                node.className === 'files' ? blueimp.Gallery(links, options) : null;
                            };
                        </script>
                        <script src="/js/jquery.blueimp-gallery.min.js"></script>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        
        <!-- #riht-frame -->
        <div id="right-frame"></div>
        <!-- /#riht-frame -->
        <div class="clear"></div>
    </div>
    <!-- /#wrapper -->
</body>

</html>