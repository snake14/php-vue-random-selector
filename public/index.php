<?php
	require __DIR__ . '/../vendor/autoload.php';
	$f3 = \Base::instance();
	$f3->set('AUTOLOAD', __DIR__ . '/../src/');
	$f3->set('UI', __DIR__ . '/../views/');
	$f3->set('TEMP', __DIR__ . '/tmp/');

	require __DIR__ . '/../src/config/config.php';
	$Db = new Utils\Database\Selector($config);
	$Db->connect();

	$f3->set('db', $Db);

	// Define the routes used by the web service.
	$f3->route('GET /', 'Controllers\Selector->getMainPage');
	$f3->route('GET /lists/@id', 'Controllers\Selector->getListItems');
	$f3->route('POST /lists/', 'Controllers\Selector->saveNewList');
	$f3->route('POST /lists/@id/items', 'Controllers\Selector->updateListItems');
	$f3->route('DELETE /lists/@id', 'Controllers\Selector->deleteList');
	$f3->run();
?>