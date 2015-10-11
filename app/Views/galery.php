<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Cute file browser</title>
    <link rel="stylesheet" href="/css/folders.css">

	<!-- Include our stylesheet -->

    <link rel="stylesheet" href="/bower_components/fontawesome/css/font-awesome.min.css">
    <script src="/js/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" href="/bower_components/jQuery-contextMenu/dist/jquery.contextMenu.min.css">
    <script src="/bower_components/jQuery-contextMenu/src/jquery.contextMenu.js"></script>
    <!-- Include our stylesheet -->

</head>
<body>

	<div class="filemanager">
        <div class="new-folder">
            <i class="fa fa-folder-open-o fa-4x"></i>
        </div>
		<div class="search">
			<input type="search" placeholder="Find a file.." />
		</div>


		<div class="breadcrumbs"></div>

		<ul class="data"></ul>

		<div class="nothingfound">
			<div class="nofiles"></div>
			<span>No files here.</span>
		</div>

	</div>
	<script>
        $.contextMenu({
    // define which elements trigger this menu
    selector: "footer",
    // define the elements of the menu
    items: {
        foo: {name: "Foo", callback: function(key, opt){ alert("Foo!"); console.log(key); console.log(opt.$trigger); }},
        bar: {name: "Bar", callback: function(key, opt){ alert("Bar!") }}
    }
    // there's more, have a look at the demos and docs...
});
    </script>

	<!-- Include our script files -->
	
	<script src="/js/folders.js"></script>

</body>
</html>