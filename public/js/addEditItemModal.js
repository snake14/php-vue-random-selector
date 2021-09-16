Vue.component('add-edit-item', {
	data() {
		return {
			itemTitle: ''
		}
	},
	methods: {
		focusOnItemTitle: function () {
			$('#item_name').focus();
		},
		saveItem: function (event) {
			event.preventDefault();

			var value = this.itemTitle;

			// Add the list item to the list.
			$('#item_list').append('<li class="list-group-item" data-val="' + value + '">' + value + '</li>');

			// Hide the modal.
			this.$bvModal.hide('add_edit_modal');

			this.itemTitle = '';
		}
	},
	template: `
		<b-modal id="add_edit_modal" title="Add/Edit List Item" ok-title="Submit" @ok="saveItem" @shown="focusOnItemTitle">
			<b-form id="add_edit_item_form" @submit="saveItem">
				<div>
					<input type="text" name="item_name" id="item_name" class="form-control" v-model="itemTitle" required>
				</div>
			</b-form>
		</b-modal>
	`
});