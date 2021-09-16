<?php
	require __DIR__ . '/../vendor/autoload.php';
	$f3 = \Base::instance();
	$f3->set('AUTOLOAD', __DIR__ . '/../src/');
	$f3->set('UI', __DIR__ . '/../views/');
	$f3->set('TEMP', __DIR__ . '/tmp/');
	// Define the routes used by the web service.
	$f3->route('GET /', 'Controllers\Selector->getMainPage');
	$f3->run();
?>