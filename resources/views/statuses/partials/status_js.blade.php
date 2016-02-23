<div class="panel">
	<div class="panel-body">
		<div class="media-block status">
			<a href="{{ route('horses.show', $horse->slug) }}" class="media-left">
				@if ($horse->getProfilePicture())
					<img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="img-circle img-sm">
				@else
					<img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="img-circle img-sm">
				@endif
			</a>
			<div class="media-body">
				<div class="mar-btm">
					<a href="{{ route('horses.show', $horse->slug()) }}" class="btn-link text-semibold media-heading box-inline text-mint">
						{{ $horse->name() }}
					</a>
				</div>
			</div>
			<p>[[ status.body ]]</p>
			<div v-for="comment in status.comments.data">
				<div class="media-block pad-all bg-gray-light">
                    <div class="media-body">
                        <div class="mar-btm">
						</div>
						<p>[[ comment.body ]]</p>
					</div>
					<hr>
				</div>
			</div>
			<div class="media-footer">
				@if (Auth::check())
					<div class="media-block pad-ver">
						<form id="form_[[ status.id ]]" method="POST" v-on:submit= "onSubmitComment($event, status)">
						<div class="row">
							<div class="col-sm-12 col-md-11 col-md-offset-1">
								<textarea id="status_[[ status.id ]]" type="text" class="form-control" name="comment" v-model="newComment.comment[status.id]"></textarea>
								<button type="submit" class="btn btn-default">Post comment</button>
							</div>
						</div>
						</form>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

