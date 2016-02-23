new Vue({

	el: '#status-overview',

	ready: function(){
		this.fetchStatusses();
	},

	methods: {

		// Get the statusses from the backend
		fetchStatusses: function(){

			this.$set('statuses', statuses);
			this.$set('horse', horse);

			console.log(statuses);

			// $.ajax({
	  //       	url: 'http://equimundo.app/horses/tophorse',
	  //       	complete: function(data) {
	  //       		console.log(data);
	  //       	}
	  //       });

        	// $.each loop with data

		}
	}

});
