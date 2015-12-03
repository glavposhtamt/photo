<?php

$app->get('/admin/gallery/test', function() use($app, $js_css) {
	$app->render('tests/test-gallery.php', array('jsCSSLibs' => $js_css));
});