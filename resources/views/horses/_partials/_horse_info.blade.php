<div class="ibox-content text-center">
    <h2>{{ $horse->name() }}</h2>
    <div class="m-b-sm">
        @if ($horse->getProfilePicture())
            <img class="img-circle widget-img" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
        @else
            <img class="img-circle widget-img" src="{{ asset('images/eqm.png') }}">
        @endif
    </div>
    <p>{{ trans('horses.breeds.' . $horse->breed()) }}</p>

    <div class="text-center">
        <a class="btn btn-xs btn-primary" href="{{ route('horses.show', $horse->slug()) }}"><i class="fa fa-eye"></i> </a>
    </div>
</div>
