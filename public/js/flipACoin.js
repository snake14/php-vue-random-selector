Vue.component('coin-flip', {
	data() {
		return {
			imageLink: 'images/coin_flip.png',
			defaultImageLink: 'images/coin_flip.png',
			coinImageUrls: [
				'http://lincolnpennies.net/wp-content/uploads/2009/08/lincoln_penny_obverse1.jpg',
				'http://lincolnpennies.net/wp-content/uploads/2009/08/lincoln-memorial-penny.jpg'
			]
		}
	},
	methods: {
		flipCoin: function () {
			var index = Math.floor(Math.random() * 2);
			$('#coin_image').hide();
			$('#flip_spinner').show();
			this.imageLink = this.coinImageUrls[index];

			setTimeout(function() {
				$('#coin_image').show();
				$('#flip_spinner').hide();
			}, 500);
		},
		resetCoin: function () {
			this.imageLink = this.defaultImageLink;
		}
	},
	template: `
		<div>
			<form id="coin_flip_form">
				<div class="form-row">
					<div class="form-group col">
						<b-button variant="primary" @click="flipCoin">Flip</b-button>
						<b-button variant="secondary" @click="resetCoin">Reset</b-button>
					</div>
				</div>
			</form>
			<img :src="imageLink" id="coin_image" style="max-width: 200px;" class="mt-3" />
		</div>
	`
});