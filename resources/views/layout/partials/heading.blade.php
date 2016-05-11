<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="row white-bg">
    <div class="col-lg-12 heading m-b-md img-border panel-bg-cover" style="height: 22em; background-position: center; background-size: cover; background-image: url({{ $horse->getHeaderImage() ? route('file.picture', $horse->getHeaderImage()->id()) : asset('images/header.jpg') }})">
        @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
            <div class="pull-right">
                {{ Form::open(['route' => ['horses.pictures.header', $horse->id()], 'files' => 'true']) }}
                    <div class="image-upload pull-right">
                        <label for="header_picture">
                            <i class="btn btn-link btn-icon fa fa-camera fa-2x add-tooltip"></i>
                        </label>
                        {{ Form::file('header_picture', ['id' => 'header_picture']) }}
                    </div>
                    <div class="confirmation-buttons pull-right" style="display: none;">
                        <button type="submit" class="btn btn-link fa fa-check fa-2x" id="heading-confirm-button"></button>
                        <i class="btn btn-link fa fa-remove fa-2x" id="heading-cancel-button"></i>
                    </div>
                {{ Form::close() }}
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <div class="profile-image">
            @if ($horse->getProfilePicture())
                <a href="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" data-gallery="#blueimp-gallery-profile">
                    <img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="img-circle circle-border m-b-md">
                </a>
            @else
                <a href="{{ asset('images/eqm.png') }}" data-lightbox="profilePicture">
                    <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="img-circle circle-border m-b-md">
                </a>
            @endif
        </div>
        <div class="profile-info">
            <div>
                <div>
                    <h2 class="no-margins">{{ $horse->name() }}</h2>
                    <h4>{{ $horse->father() ? $horse->father()->name() : '' }} {{ $horse->father() && $horse->mothersFather() ? '<span class="text-bold">X</span> ' . $horse->mothersFather()->name() : '' }}</h4>
                    <small>
                        {{ trans('horses.breeds.' . $horse->breed()) }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <table class="table small m-b-xs">
            <tbody>
            <tr>
                <td>
                    <strong>{{ count($horse->statuses()) }}</strong> {{ trans('copy.a.statuses') }}
                </td>
                <td>
                    <strong>{{ count($horse->followers()) }}</strong> {{ trans('copy.titles.followers') }}
                </td>
            </tr>
            <tr>
                <td>
                    <div class="fb-share-button" data-href="{{ route('horses.show', $horse->slug()) }}" data-layout="icon"></div>
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    @if (auth()->check())
        <div class="col-md-3">
            <div class="pull-right">
                @if (auth()->user()->isInHorseTeam($horse))
                    <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn btn-sm btn-info">{{ trans('copy.a.edit_horse', ['horse' => $horse->name()]) }}</a>
                @else
                    @include('horses.partials.follow-form')
                @endif
            </div>
        </div>
    @endif
</div>

<div class="row m-b-md white-bg">
    <div class="col-lg-12 text-center">
        <div class="col-xs-2 {{ Active::route('horses.show', 'active-nav') }}">
            <a href="{{ route('horses.show', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-list fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2 {{ Active::route('horse.info', 'active-nav') }}">
            <a href="{{ route('horse.info', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-info-circle fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2 {{ Active::route('follows.index', 'active-nav') }}">
            <a href="{{ route('follows.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-users fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2 {{ Active::route(['horses.pictures.index', 'album.show', 'album.create', 'album.edit'], 'active-nav') }}">
            <a href="{{ route('horses.pictures.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-camera fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2 {{ Active::route(['pedigree.index', 'pedigree.create'], 'active-nav') }}">
            <a href="{{ route('pedigree.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-share-alt fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2 {{ Active::route(['palmares.index', 'palmares.create', 'palmares.edit'], 'active-nav') }}">
            <a href="{{ route('palmares.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-trophy fa-2x"></i>
            </a>
        </div>
    </div>
</div>
