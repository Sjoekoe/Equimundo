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
					<p class="text-muted text-sm">
						[[ status.created_at ]]
					</p>
				</div>
			</div>
			<p>[[ status.body ]]</p>
			<div class="pad-ver">
				<span class="tag tag-sm">
					<i class="fa fa-heart text-danger"></i> [[ status.like_count ]]
				</span>
				@if (auth()->check())
					<div class="btn-group">
						<form class="like-button" method="POST" v-on:submit= "onSubmitLike($event, status)">

							<!-- Vue template -->

							<!-- Check if the the status likes array contains the user_id -->
							<template v-if="user.data.id === 1">
								<button class="btn btn-sm btn-default btn-hover-success active" type="submit"><i class="fa fa-thumbs-up"></i> You Like it</button>
							</template>
							<template v-else>
								<button class="btn btn-sm btn-default btn-hover-success" v-model="newlike.like[status.id]" type="submit"><i class="fa fa-thumbs-up"></i></button>
							</template>

						</form>
					</div>
					<a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
				@endif
			</div>
			<hr>
			<div v-for="comment in status.comments.data">
				<div class="media-block pad-all bg-gray-light">
                    <div class="media-body">
                        <div class="mar-btm">


						<!-- TODO a href with comment poster? -->


	                        <div class="pull-right">
								<div class="btn-group">
									<i class="dropdown-toggle-icon fa fa-chevron-down" data-toggle="dropdown" aria-expanded="false"></i>
									<ul class="dropdown-menu dropdown-menu-right">
										<li>
											<a href="javascript:void(0)" v-on:click="deleteComment(comment, status)">
												{{ trans('copy.a.delete') }}
											</a>
										</li>
									</ul>
								</div>
							</div>
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

