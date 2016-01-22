    <div class="panel mar-no">
        <div class="panel-bg-cover">
            <img src="{{ asset('images/header.jpg') }}" alt="{{ $horse->name() }}" class="img-responsive">
        </div>
        <div class="panel-media">
            @if ($horse->getProfilePicture())
                <img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="panel-media-img img-circle img-border-light">
            @else
                <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="panel-media-img img-circle img-border-light">
            @endif
            <div class="row">
                <div class="col-lg-7">
                    <h3 class="panel-media-heading text-mint">{{ $horse->name() }}</h3>
                    <p>{{ trans('horses.breeds.' . $horse->breed()) }}</p>
                </div>
                <div class="col-lg-5 text-lg-right">
                    <div class="heading-button pull-right">
                        @if (auth()->user()->isInHorseTeam($horse))
                            <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn btn-sm btn-mint">{{ trans('copy.a.edit_horse', ['horse' => $horse->name()]) }}</a>
                        @else
                            @include('horses.partials.follow-form')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    @include('horses.partials.menu-bar')
</div>
