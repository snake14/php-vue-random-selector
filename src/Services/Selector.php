<?php
namespace Services;

class Selector {
	protected $container;

	public function __construct(\Base $f3) {
		$this->container = $f3;
	}

	/**
	 * Load the collection of lists from the database.
	 * 
	 * @return array Indicates success and contains the collection of lists.
	 * @author JacobR
	 */
	public function loadLists(): array {
		// Load the list from the database...
		$db = $this->container->get('db');
		$result = $db->getAllLists();

		return [ 'success' => $result['success'] ?? false, 'lists' => $result['lists'] ?? [] ];
	}

	/**
	 * Format the collection of list data from that database to be used by a select element.
	 * 
	 * @return array Indicates success and contains the collection of formatted list data.
	 * @author JacobR
	 */
	public function getListsForSelect(): array {
		$result = $this->loadLists();
		if(empty($result['success']) || empty($result['lists'])) {
			return [ 'success' => false, 'error' => 'No lists found.' ];
		}

		$lists = [];
		foreach ($result['lists'] as $list) {
			$lists[] = [ 'value' => $list['id'], 'text' => $list['name'] ];
		}

		return [ 'success' => true, 'lists' => $lists ];
	}

	/**
	 * Load all of the items for a specific list.
	 * 
	 * @param integer $listId The ID that uniquely identifies a list.
	 * @return array Indicates success and contains the collection of items for a list.
	 * @author JacobR
	 */
	public function loadListItems(int $listId): array {
		// Load the list from the database...
		$db = $this->container->get('db');
		$result = $db->getItemsByListId($listId);

		return [ 'success' => $result['success'] ?? false, 'listItems' => $result['items'] ?? [] ];
	}

	/**
	 * Creates a new list with the specified name and list items.
	 * 
	 * @param array $params Should contain the name and list items for the new list.
	 * @return array Indicates success, contains the ID of the newly created list, and contains the updated collection of lists.
	 * @author JacobR
	 */
	public function createNewList(array $params): array {
		if(empty($params['name']) || empty($params['listItems'])) {
			return [ 'success' => false, 'error' => 'Missing required values.' ];
		}

		// Save the list to the database...
		$db = $this->container->get('db');
		$result = $db->createList($params);

		if(empty($result['success'])) {
			return $result;
		}

		$listDataResult = $this->getListsForSelect();

		return [ 'success' => $result['success'] ?? false, 'listId' => $result['listId'] ?? '', 'listData' => $listDataResult['lists'] ?? [] ];
	}

	/**
	 * Update the items associated with a specific list.
	 * 
	 * @param array $params Should contain the list ID and the items assocaited with the list.
	 * @return array Indicates success.
	 * @author JacobR
	 */
	public function updateListItems(array $params): array {
		if(empty($params['listId'])) {
			return [ 'success' => false, 'error' => 'Missing required values.' ];
		}

		if(empty($params['listItems'])) {
			return [ 'success' => false, 'error' => 'Missing required values.' ];
		}

		// Save the list changes to the database...
		$db = $this->container->get('db');
		$result = $db->updateListItems($params);

		return [ 'success' => $result['success'] ?? false ];
	}

	/**
	 * Update the name associated with a specific list.
	 * 
	 * @param array $params Should contain the list ID and the name assocaited with the list.
	 * @return array Indicates success.
	 * @author JacobR
	 */
	public function updateListName(array $params): array {
		if(empty($params['listId'])) {
			return [ 'success' => false, 'error' => 'Missing required values.' ];
		}

		if(empty($params['listName'])) {
			return [ 'success' => false, 'error' => 'Missing required values.' ];
		}

		// Save the list changes to the database...
		$db = $this->container->get('db');
		$result = $db->renameList($params);

		$listDataResult = $this->getListsForSelect();

		return [ 'success' => $result['success'] ?? false, 'listData' => $listDataResult['lists'] ?? [] ];
	}

	/**
	 * Delete a specific list and return the updated collection of lists and IDs.
	 * 
	 * @param integer $listId The ID that uniquely identifies a list.
	 * @return array Indicates success and contains the updated collection of lists.
	 * @author JacobR
	 */
	public function deleteList(int $listId): array {
		// Delete the list and associated list items from the database...
		$db = $this->container->get('db');
		$result = $db->deleteList($listId);

		if(empty($result['success'])) {
			return $result;
		}

		$listDataResult = $this->getListsForSelect();

		return [ 'success' => $result['success'] ?? false, 'listData' => $listDataResult['lists'] ?? [] ];
	}
}