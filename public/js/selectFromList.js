Vue.component('list-item-select', {
	props: {
		displayResult: { type: Function },
		showLoading: { type: Function },
		hideLoading: { type: Function }
	},
	data() {
		return {
			cellNames: [ 'title', 'action_buttons' ],
			listItems: []
		}
	},
	methods: {
		clearItems: function () {
			// Clear the array of items.
			this.listItems = [];
		},
		selectRandomItem: function () {
			var count = this.listItems.length;
			var items = this.listItems;
			const showInfoBox = this.displayResult;
			const stopLoading = this.hideLoading;

			// There should be at least two items to choose between.
			if(count < 2) {
				// Display a warning.
				showInfoBox('Please have at least two items to select from.', true);
				return false;
			}

			this.showLoading();

			// Use an API (https://www.random.org/clients/http/) to get a more random number than Math.random can produce.
			var url = 'https://www.random.org/integers/?num=1&min=0&max=' + (count - 1) + '&col=1&base=10&format=plain&rnd=new';
			$.get(url, function(result) {
				// Get the selected item.
				var item = items[parseInt(result)];
				// Display the result.
				showInfoBox('Result: ' + item.title);
				stopLoading();
			});
		}
	},
	template: `
		<div>
			<b-card bg-variant="primary" text-variant="white" class="square-bottom">
				<span style="font-size: 1.5rem;">Selection List</span>
				<b-button v-b-modal.add_edit_modal variant="light" class="float-right">Add</b-button>
			</b-card>
			<b-table striped hover :items="listItems" :fields="cellNames" outlined thead-class="hidden_header">
			<template #cell(action_buttons)="row">
				<div class="text-right">
					<b-link variant="primary" v-b-tooltip.hover title="Remove item from the list">
						<b-icon icon="trash-fill" @click="listItems.splice(row.index, 1)"></b-icon>
					</b-link>
				</div>
			</template>
			</b-table>
			<b-button variant="primary" class="mt-3" @click="selectRandomItem">Submit</b-button>
			<b-button variant="secondary" class="mt-3" @click="clearItems">Clear</b-button>
			<add-edit-item :items="listItems" />
		</div>
	`
});