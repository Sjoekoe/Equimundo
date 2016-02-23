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
		</div>
	</div>
</div>

