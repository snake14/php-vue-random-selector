Vue.component('list-item-select', {
	props: { displayResult: { type: Function } },
	methods: {
		clearItems: function () {
			// Remove all but the first, since that's the header.
			$('#item_list li').not(':first').remove();
		},
		selectRandomItem: function () {
			var count = $('#item_list li').length;
			const showInfoBox = this.displayResult;

			// The header item plus at least 2 more.
			if(count < 3) {
				// Display a warning.
				showInfoBox('Please have at least two items to select from.', true);
				return false;
			}

			// Use an API (https://www.random.org/clients/http/) to get a more random number than Math.random can produce.
			var url = 'https://www.random.org/integers/?num=1&min=0&max=' + (count - 2) + '&col=1&base=10&format=plain&rnd=new';
			$.get(url, function(result) {
				var item = $('#item_list li').get(parseInt(result) + 1);
				// Display the result.
				showInfoBox('Result: ' + $(item).data('val'));
			});
		}
	},
	template: `
		<div>
			<ul class="list-group" id="item_list">
				<li class="list-group-item active">
					<span style="font-size: 1.5rem;">Selection List</span>
					<b-button v-b-modal.add_edit_modal variant="light" class="float-right">Add</b-button>
				</li>
			</ul>
			<b-button variant="primary" class="mt-3" @click="selectRandomItem">Submit</b-button>
			<b-button variant="secondary" class="mt-3" @click="clearItems">Clear</b-button>
			<add-edit-item/>
		</div>
	`
});