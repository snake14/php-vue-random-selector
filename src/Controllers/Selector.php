<?php
    namespace Controllers;

	use \Classes\DisplayableError;

    class Selector {
        public function getMainPage($f3, $params) {
			include(__DIR__ . '/../../views/main.htm');
        }
	}