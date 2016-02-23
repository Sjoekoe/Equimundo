<div class="panel">
	<div class="panel-body">
		<div class="media-block status">
			<a href="{{ route('horses.show', $status->horse()->slug()) }}" class="media-left">
				@if ($status->horse()->getProfilePicture())
					<img src="{{ route('file.picture', $status->horse()->getProfilePicture()->id()) }}" alt="{{ $status->horse()->name() }}" class="img-circle img-sm">
				@else
					<img src="{{ asset('images/eqm.png') }}" alt="{{ $status->horse()->name() }}" class="img-circle img-sm">
				@endif
			</a>
			<div class="media-body">
				<div class="mar-btm">
					<a href="{{ route('horses.show', $status->horse()->slug()) }}" class="btn-link text-semibold media-heading box-inline text-mint">
						{{ $status->horse()->name() }}
					</a>
					@if ($status->prefix())
						 - <span class="text-semibold -text-muted">{{ trans('statuses.prefixes.' . $status->prefix()) }}</span>
					@endif
					<p class="text-muted text-sm">
						{{ eqm_translated_date($status->createdAt())->diffForHumans() }}
					</p>
				</div>
				<p>{{ $status->body() }}</p>
				@if ($status->hasPicture())
					@if ($status->getPicture()->isImage())
						<img src="{{ route('file.picture', [$status->getPicture()->id()]) }}" alt="" class="img-responsive thumbnail">
					@elseif ($status->getPicture()->isMovie())
						<video width="600" controls>
							<source src="{{ route('file.movie', $status->getPicture()->id()) }}">
						</video>
					@endif
				@endif
				<div class="pad-ver">
					<span class="tag tag-sm">
						<i class="fa fa-heart text-danger"></i> {{ count($status->likes()) }}
					</span>
					<div class="btn-group">
						{{ Form::open(['route' => ['status.like', $status->id()], 'class' => 'like-button', 'data-remote']) }}
						{{ Form::hidden('status_id', $status->id()) }}
						@if (in_array($status->id(), $likes))
							<button class="btn btn-sm btn-default btn-hover-success active" type="submit"><i class="fa fa-thumbs-up"></i> You Like it</button>
						@else
							<button class="btn btn-sm btn-default btn-hover-success" type="submit"><i class="fa fa-thumbs-up"></i></button>
						@endif
						{{ Form::close() }}
					</div>
					<a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
				</div>
				<hr>
				@foreach($status->comments() as $comment)
					<div class="media-block pad-all bg-gray-light">
						<div class="media-body">
							<div class="mar-btm">
								<a href="{{ route('users.profiles.show', $comment->poster()->id()) }}" class="btn-link text-mint text-semibold media-heading box-inline">
									{{ $comment->poster()->fullName() }}
								</a>
								<div class="pull-right">
									@can('delete-comment', $comment)
										<a href="{{ route('comment.delete', $comment->id()) }}">Delete</a>
									@endcan
								</div>
								<p class="text-muted text-sm">
									{{ eqm_translated_date($comment->created_at)->diffForHumans() }}
								</p>

							</div>
							<p>{{ $comment->body() }}</p>
							<div class="pad-ver">
													<span class="tag tag-sm">
														<i class="fa fa-heart text-danger"></i> {{ count($comment->likes()) }}
													</span>
								<div class="btn-group">
									@if (auth()->check())
										{{ Form::open(['route' => ['comment.like', $comment->id()], 'class' => 'like-button', 'data-remote']) }}
										{{ Form::hidden('comment_id', $comment->id()) }}
										@if ($comment->isLikedByUser(auth()->user()))
											<a class="btn btn-sm btn-default btn-hover-success active" href="#"><i class="fa fa-thumbs-up"></i> You Like it</a>
										@else
											<a class="btn btn-sm btn-default btn-hover-success" href="#"><i class="fa fa-thumbs-up"></i></a>
										@endif
										{{ Form::close() }}
									@endif
								</div>
							</div>
						</div>
						<hr>
					</div>
				@endforeach
			</div>
			<div class="media-footer">
				@if (Auth::check())
					<div class="media-block pad-ver">
						{{ Form::open(['route' => ['comment.store', $status->id()], 'class' => 'comments__create-form col s12']) }}
						<div class="row">
							<div class="col-sm-12 col-md-11 col-md-offset-1">
								{{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => trans('forms.placeholders.write_a_comment')]) }}
							</div>
						</div>
						{{ Form::close() }}
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

