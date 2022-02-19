Vue.component('add-edit-list', {
	props: {
		items: Array,
		listId: Number,
		setListId: { type: Function },
		setCanAddList: { type: Function },
		setIsListDirty: { type: Function },
		updateListData: { type: Function }
	},
	data() {
		return {
			listTitle: ''
		}
	},
	methods: {
		focusOnListTitle: function () {
			$('#list_name').focus();
		},
		clearTitle: function () {
			this.listTitle = '';
		},
		hideModal: function () {
			this.$bvModal.hide('add_edit_list_modal');
		},
		submitForm: function (event) {
			event.preventDefault();
			
			var value = this.listTitle;
			var listItems = this.items;
			const clearTitle = this.clearTitle;
			const setListId = this.setListId;
			const hideModal = this.hideModal;
			const setCanAddList = this.setCanAddList;
			const setIsListDirty = this.setIsListDirty;
			const updateListData = this.updateListData;

			$.post( "/lists/", { name: value, listItems: listItems }, function(response) {
				var responseJson = $.parseJSON(response);

				setListId(responseJson.listId);

				setCanAddList(false);
				setIsListDirty(false);

				// Hide the modal.
				hideModal();

				clearTitle();

				// Refresh the collection of available lists.
				updateListData(responseJson.listData);
			});
		}
	},
	template: `
		<b-modal id="add_edit_list_modal" title="Add/Edit List" hide-footer @shown="focusOnListTitle">
			<b-form id="add_edit_list_form" @submit="submitForm">
				<b-form-group>
					<b-form-input type="text" name="list_name" id="list_name" class="form-control" v-model="listTitle" required></b-form-input>
				</b-form-group>
				<b-form-group class="mb-0 text-right">
					<b-button variant="secondary" @click="listTitle = ''; $bvModal.hide('add_edit_list_modal');">Cancel</b-button>
					<b-button type="submit" variant="primary">Submit</b-button>
				</b-form-group>
			</b-form>
		</b-modal>
	`
});