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
		},
		newLike: '',
		user: '',
		horse: '',
		statuses: '',
	},

	ready: function(){
		//this.fetchStatusses();
		this.fetchHorse();
		this.fetchUser();
	},

	methods: {

		fetchHorse: function(){
			this.$http.get('/api/horses/' + horse_id + '', function(horse){

				// Create a comments object for each status
				$.each(horse.data.statuses.data, function(ndx, value){
					if(!value.comments){
						value.comments = {
							"data" : []
						};
					}
				});

				// Set the variables for the two way binding
				this.$set('horse', horse);
				this.$set('statuses', horse.data.statuses.data);

			});
		},

		fetchUser: function(){

			this.$http.get('/api/users/' + user_id + '', function(user){
				this.$set('user', user);
			});
		},

		onSubmitComment: function(e, status){

			//console.log(this.newComment.comment);
			var comment_body;

			// Prevent default submit behaviour
			e.preventDefault();

			$.each(this.newComment.comment, function(ndx, value){
				comment_body = value;
			});

			// Add new comment to statuses.comments.data
			// status.comments.data.push(this.newComment.comment);
			if(status.comments){
				status.comments.data.push({
					"body" : comment_body,
					"user" : this.user,
				});
			}

			// Reset input field
			this.newComment = { comment:'' };

			// TODO Send POST ajax request
		},

		onSubmitLike: function($e, $status){

			$status.like_count++;

			// Prevent default submit behaviour
			$e.preventDefault();

			// TODO Send POST ajax request

		},

		deleteComment: function($comment, $status){

			//Vue.delete($status.comments , $comment);

			$.each($status.comments.data, function(ndx, comment){
				if(comment.id === $comment.id){
					console.log(this);
				}
			});

			$status.comments.data.splice( $.inArray($comment, $status.comments.data), 1 );
		}
	}

});