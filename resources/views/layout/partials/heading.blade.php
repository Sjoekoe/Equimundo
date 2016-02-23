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
<div class="panel mar-no">
    <div class="panel-bg-cover" style="height: 40em; background-image: url({{ $horse->getHeaderImage() ? route('file.picture', $horse->getHeaderImage()->id()) : asset('images/header.jpg') }})">
        @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
            <div class="pull-right">
                {{ Form::open(['route' => ['horses.pictures.header', $horse->id()], 'files' => 'true']) }}
                    <div class="image-upload pull-right">
                        <label for="header_picture">
                            <i class="btn btn-trans btn-icon fa fa-camera fa-2x add-tooltip"></i>
                        </label>
                        {{ Form::file('header_picture', ['id' => 'header_picture']) }}
                    </div>
                    <div class="confirmation-buttons pull-right" style="display: none;">
                        <button type="submit" class="btn btn-trans fa fa-check fa-2x" id="heading-confirm-button"></button>
                        <i class="btn btn-trans fa fa-remove fa-2x" id="heading-cancel-button"></i>
                    </div>
                {{ Form::close() }}
            </div>
        @endif
    </div>
    <div class="panel-media mar-btm pad-no" style="padding-bottom: 0px;">
        @if ($horse->getProfilePicture())
            <img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="panel-media-img img-circle img-border-light">
        @else
            <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="panel-media-img img-circle img-border-light">
        @endif
        <div class="row mar-btm">
            <div class="col-lg-7">
                <h1 class="panel-media-heading text-mint">{{ $horse->name() }}</h1>
                <p>{{ trans('horses.breeds.' . $horse->breed()) }}</p>
                <p>{{ $horse->father() ? $horse->father()->name() : '' }} {{ $horse->father() && $horse->mothersFather() ? '<span class="text-bold">X</span> ' . $horse->mothersFather()->name() : '' }}</p>
                <div class="fb-share-button"
                     data-href="{{ route('horses.show', $horse->slug()) }}"
                     data-layout="icon" >
                </div>
            </div>
            @if (auth()->check())
                <div class="col-lg-5 text-lg-right">
                    <div class="heading-button pull-right">
                        @if (auth()->user()->isInHorseTeam($horse))
                            <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn btn-sm btn-mint">{{ trans('copy.a.edit_horse', ['horse' => $horse->name()]) }}</a>
                        @else
                            @include('horses.partials.follow-form')
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-5 col-lg-offset-3">
                <ul class="list-unstyled text-center pad-top mar-no clearfix">
                    <li class="col-xs-2 col-lg-2 {{ Active::route('horses.show', 'border-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('horses.show', $horse->slug()) }}">
                                <i class="fa fa-list fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-xs-2 col-lg-2 {{ Active::route('horse.info', 'border-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('horse.info', $horse->slug()) }}">
                                <i class="fa fa-info-circle fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-xs-2 col-lg-2 {{ Active::route('follows.index', 'border-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('follows.index', $horse->slug()) }}">
                                <i class="fa fa-users fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-xs-2 col-lg-2 {{ Active::route(['horses.pictures.index', 'album.show', 'album.create', 'album.edit'], 'border-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('horses.pictures.index', $horse->slug()) }}">
                                <i class="fa fa-camera fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-xs-2 col-lg-2 {{ Active::route(['pedigree.index', 'pedigree.create'], 'border-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('pedigree.index', $horse->slug()) }}">
                                <i class="fa fa-share-alt fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-xs-2 col-lg-2 {{ Active::route(['palmares.index', 'palmares.create', 'palmares.edit'], 'border-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('palmares.index', $horse->slug()) }}">
                                <fa class="fa fa-trophy fa-2x"></fa>
                            </a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
