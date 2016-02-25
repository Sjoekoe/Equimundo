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
		allHorses: '',
	},

	ready: function(){

		// Get the data for a horse detail page
		if(horse_id){

			this.fetchHorse();

		// Get the data for a horse overview page
		}else{
			this.fetchAllHorses();
		}

		// Get the auth user
		this.fetchUser();
	},

	methods: {

		fetchHorse: function(){

			this.$http.get('/api/horses/' + horse_id + '/?include=statuses', function(horse){

				// Create a comments object for each status
				$.each(horse.data.statuses.data, function(ndx, value){
					if(!value.comments){
						value.comments = {
							"data" : []
						};
					}
					if(!value.likes){
						value.likes = {
							"data" : []
						}
					}
				});

				// Set the variables for the two way binding
				this.$set('horse', horse);
				this.$set('statuses', horse.data.statuses.data);

			});
		},

		fetchAllHorses: function(){
			this.$http.get('/api/users/' + user_id + '/feed', function(statuses){

				// Create a comments object for each status
				$.each(statuses.data, function(ndx, value){
					if(!value.comments){
						value.comments = {
							"data" : []
						};
					}
					if(!value.likes){
						value.likes = {
							"data" : []
						}
					}
					// Store the profile picture in an extra field to read it in the view
					if(value.horse.data.pictures){
						console.log("there is one");

						$.each(value.horse.data.pictures.data, function(index, picture){
							if(picture.is_profile_picture){
								value.horse.data.profile_picture_path = picture.id;
							}
						});
					}

					// TODO this is to set the links, has to come out of backend
					value.horse.data.slug = value.horse.data.name.replace(/\s/g,"-");
				});

				this.$set('statuses', statuses.data);
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
			var comment;

			// Prevent default submit behaviour
			e.preventDefault();

			$.each(this.newComment.comment, function(ndx, value){
				comment_body = value;
			});

			if(comment_body.replace(/[^a-zA-Z 0-9]+/g, '').trim().length === 0){
				return;
			}else{

				comment = {
					"body" : comment_body,
					"user" : this.user
				}
				// Add new comment to statuses.comments.data
				// status.comments.data.push(this.newComment.comment);
				if(status.comments){
					status.comments.data.push(comment);
				}
			}

			// Reset input field
			this.newComment = { comment:'' };

			// TODO Send POST ajax request
			this.$http.post('/api/statuses/' + status.id + '/comments', comment);
		},

		deleteComment: function($comment, $status){

			$status.comments.data.splice( $.inArray($comment, $status.comments.data), 1 );

			if($comment.id){
				this.$http.delete('/api/statuses/' + $status.id + '/comments/' + $comment.id + '');
			}
		},

		onSubmitLike: function($e, $status){

			// Prevent default submit behaviour
			$e.preventDefault();

			if($status.liked_by_user){

				$status.like_count--;
				$status.liked_by_user = false;
				this.$http.post('/api/statuses/' + $status.id + '/like');

			}else{

				$status.like_count++;

				$status.likes.data.push(
						this.user.data
					);

				$status.liked_by_user = true;
				this.$http.post('/api/statuses/' + $status.id + '/like');
			}

		},
	}

});
