Vue.http.headers.common['X-CSRF-TOKEN'] = $('#token').attr('val');

new Vue({

	el: '#status-overview',

	data: {
		newComment: {
			comment: {
			},
			// comment: [{
			// 	'id' : ''
			// }]
		}
	},

	ready: function(){
		//this.fetchStatusses();
		this.fetchHorse();
	},

	methods: {

		fetchHorse: function(){
			this.$http.get('/api/horses/1', function(horse){
				this.$set('horse', horse);
				this.$set('statuses', horse.data.statuses.data);
			});
		},

		onSubmitComment: function(e, status){
			console.log(this.newComment.comment);
			var comment_body;

			$.each(this.newComment.comment, function(ndx, value){
				comment_body = value;
			});

			// Prevent default submit behaviour
			e.preventDefault();

			// Add new comment to statuses.comments.data
			// status.comments.data.push(this.newComment.comment);
			if(status.comments){
				status.comments.data.push({
					"body" : comment_body
				});
			}else{
				console.log("tja hier gaat de fallback moeten komen");
			}

			// Reset input field
			this.newComment = { comment:'' };

			// Send POST ajax request
		}
	}

});
