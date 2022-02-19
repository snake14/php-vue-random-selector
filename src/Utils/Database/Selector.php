<?php
	namespace Utils\Database;

	class Selector extends Base {
		/**
		 * Create a new list in the database and and items associated with the list.
		 * 
		 * @param array $params Should contain the name of the list and the list items.
		 * @return array Indicate whether to creation was successful or not.
		 * @author JacobR
		 */
		public function createList(array $params): array {
			$stmt = $this->conn->prepare("INSERT INTO lists (name) VALUES (?)");
			if(!$stmt) {
				return [ 'success' => false, 'error' => $this->conn->error ];
			}
			$stmt->bind_param("s", $params['name']);
			$result = $stmt->execute();
			$stmt->close();
			if(!$result) {
				return [ 'success' => false, 'error' => $this->conn->error ];
			}
			$new_list_id = $this->conn->insert_id;

			foreach($params['listItems'] as $item) {
				$stmt = $this->conn->prepare("INSERT INTO list_items (list_id, name) VALUES (?,?)");
				if(!$stmt) {
					return [ 'success' => false, 'error' => $this->conn->error ];
				}
				$stmt->bind_param("is", $new_list_id, $item['name']);
				$result = $stmt->execute();
				$stmt->close();
			}

			return [ 'success' => $result, 'listId' => $new_list_id, 'error' => $this->conn->error ];
		}

		/**
		 * Get a collection of all of the stored lists.
		 * 
		 * @return array Indicates success and contains the collection of all of the lists from the database.
		 * @author JacobR
		 */
		public function getAllLists(): array {
			$stmt = $this->conn->prepare("SELECT * FROM lists;");
			$success = $stmt->execute();
			if($success) {
				$result = $stmt->get_result();
				$rows = [];
				while($row = $result->fetch_assoc()) {
					$rows[] = $row;
				}
			}
			$stmt->close();

			return [ 'success' => $success, 'lists' => $rows ];
		}

		/**
		 * Get all of the items associated with a specific list.
		 * 
		 * @param integer $list_id Id that uniquely identifies the list.
		 * @return array Indicates success and contains the collection of list items.
		 * @author JacobR
		 */
		public function getItemsByListId(int $list_id): array {
			$stmt = $this->conn->prepare("SELECT id, name FROM list_items WHERE list_id = ?;");
			if(!$stmt) {
				return [ 'success' => false, 'error' => $this->conn->error ];
			}
			$stmt->bind_param('i', $list_id);
			$success = $stmt->execute();
			if($success) {
				$result = $stmt->get_result();
				$rows = [];
				while($row = $result->fetch_assoc()) {
					$rows[] = $row;
				}
			}
			$stmt->close();

			return [ 'success' => $success, 'items' => $rows ];
		}

		/**
		 * Rename an existing list.
		 * 
		 * @param array $params Should contain the name and ID of the list to be updated.
		 * @return array Indicates whether or not the update was successful.
		 * @author JacobR
		 */
		public function renameList(array $params): array {
			$stmt = $this->conn->prepare("UPDATE lists
				SET name = ?
				WHERE id = ?;");
			if(!$stmt) {
				return [ 'success' => false, 'error' => $this->conn->error ];
			}
			$stmt->bind_param("si", $params['listName'], $params['listId']);
			$result = $stmt->execute();
			$stmt->close();
			return [ 'success' => $result, 'error' => $this->conn->error ];
		}

		/**
		 * Update the list of items associated with a specific list. This is done by deleting the previously persisted
		 * items and then saving the new list.
		 * 
		 * @param array $params Should include the list ID and the collection of new list items.
		 * @return array Indicates whether or not the update was successful.
		 * @author JacobR
		 */
		public function updateListItems(array $params): array {
			// Delete all of the existing items for the list
			$stmt = $this->conn->prepare("DELETE FROM list_items WHERE list_id = ?;");
			if(!$stmt) {
				return [ 'success' => false, 'error' => $this->conn->error ];
			}
			$stmt->bind_param("i", $params['listId']);
			$result = $stmt->execute();
			$stmt->close();
			if(!$result) {
				return [ 'success' => false, 'error' => $this->conn->error ];
			}

			// Insert the new/updated items for the list
			foreach($params['listItems'] as $item) {
				$stmt = $this->conn->prepare("INSERT INTO list_items (list_id, name) VALUES (?,?)");
				if(!$stmt) {
					return [ 'success' => false, 'error' => $this->conn->error ];
				}
				$stmt->bind_param("is", $params['listId'], $item['name']);
				$result = $stmt->execute();
				$stmt->close();
			}

			return [ 'success' => $result, 'error' => $this->conn->error ];
		}

		/**
		 * Deletes a specific list.
		 * 
		 * @param integer $list_id ID that uniquely identifies the list to be deleted.
		 * @return array Indicates whether or not the deletion was successful.
		 * @author JacobR
		 */
		public function deleteList(int $list_id): array {
			$stmt = $this->conn->prepare("DELETE FROM list_items WHERE list_id = ?;");
			$stmt->bind_param('i', $list_id);
			$result = $stmt->execute();
			$stmt->close();
			$stmt = $this->conn->prepare("DELETE FROM lists WHERE id = ?;");
			$stmt->bind_param('i', $list_id);
			$result = $stmt->execute();
			$stmt->close();

			return [ 'success' => $result, 'error' => $this->conn->error ];
		}
	}