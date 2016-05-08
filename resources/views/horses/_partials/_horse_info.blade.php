<div class="ibox-content text-center">
    <h1>{{ $horse->name() }}</h1>
    <div class="m-b-sm">
        @if ($popularHorse->getProfilePicture())
            <img class="img-circle widget-img" src="{{ route('file.picture', $popularHorse->getProfilePicture()->id()) }}">
        @else
            <img class="img-circle widget-img" src="{{ asset('images/eqm.png') }}">
        @endif
    </div>
    <p class="font-bold">{{ trans('horses.breeds.' . $horse->breed()) }}</p>

    <div class="text-center">
        <a class="btn btn-xs btn-primary" href="{{ route('horses.show', $horse->slug()) }}"><i class="fa fa-eye"></i> </a>
    </div>
</div>
