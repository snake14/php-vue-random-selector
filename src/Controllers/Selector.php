<?php
namespace Controllers;

class Selector {
	/**
	 * Load the main page and render it.
	 * 
	 * @param \Base $f3
	 * @param array $params
	 * @return void
	 * @author JacobR
	 */
	public function getMainPage($f3, $params) {
		$result = (new \Services\Selector($f3))->getListsForSelect();
		$f3->set('listData', json_encode($result['lists'] ?? []));

		echo \Template::instance()->render('main.htm');
	}

	/**
	 * Get the items for a specific list and return them in JSON format.
	 * 
	 * @param \Base $f3
	 * @param array $params
	 * @return void
	 * @author JacobR
	 */
	public function getListItems($f3, $params) {
		$listId = $params['id'] ?? 0;

		if(empty($listId)) {
			echo json_encode([ 'success' => false, 'error' => 'No list ID provided.' ]);
			exit;
		}

		$result = (new \Services\Selector($f3))->loadListItems($listId);
		echo json_encode($result);
	}

	/**
	 * Take a name and list of items to use in the creation of a new list.
	 * 
	 * @param \Base $f3
	 * @param array $params
	 * @return void
	 * @author JacobR
	 */
	public function saveNewList($f3, $params) {
		if(empty($_POST['name'])) {
			echo json_encode([ 'success' => false, 'error' => 'No list name provided.' ]);
			exit;
		}

		if(empty($_POST['listItems'])) {
			echo json_encode([ 'success' => false, 'error' => 'No list items provided.' ]);
			exit;
		}

		$result = (new \Services\Selector($f3))->createNewList($_POST);
		echo json_encode($result);
	}

	/**
	 * Take a list of items to use in updating a list.
	 * 
	 * @param \Base $f3
	 * @param array $params
	 * @return void
	 * @author JacobR
	 */
	public function updateListItems($f3, $params) {
		$listId = $params['id'] ?? 0;

		if(empty($listId)) {
			echo json_encode([ 'success' => false, 'error' => 'No list ID provided.' ]);
			exit;
		}

		if(empty($_REQUEST['listItems'])) {
			echo json_encode([ 'success' => false, 'error' => 'No list items provided.' ]);
			exit;
		}

		$result = (new \Services\Selector($f3))->updateListItems([ 'listId' => $listId, 'listItems' => $_REQUEST['listItems'] ]);
		echo json_encode($result);
	}

	/**
	 * Take a list ID and delete the associated list.
	 * 
	 * @param \Base $f3
	 * @param array $params
	 * @return void
	 * @author JacobR
	 */
	public function deleteList($f3, $params) {
		$listId = $params['id'] ?? 0;

		if(empty($listId)) {
			echo json_encode([ 'success' => false, 'error' => 'No list ID provided.' ]);
			exit;
		}

		$result = (new \Services\Selector($f3))->deleteList($listId);
		echo json_encode($result);
	}
}