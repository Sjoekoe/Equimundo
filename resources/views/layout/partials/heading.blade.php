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
    <div class="col-lg-12 heading m-b-md img-border" style="height: 20em; background-position: center; background-size: cover; background-image: url({{ $horse->getHeaderImage() ? route('file.picture', $horse->getHeaderImage()->id()) : asset('images/header.jpg') }})">
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
                    <strong>{{ count($horse->statuses()) }}</strong> Statuses
                </td>
                <td>
                    <strong>{{ count($horse->followers()) }}</strong> Followers
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <div class="pull-right">
            @if (auth()->user()->isInHorseTeam($horse))
                <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn btn-sm btn-info">{{ trans('copy.a.edit_horse', ['horse' => $horse->name()]) }}</a>
            @else
                @include('horses.partials.follow-form')
            @endif
        </div>
    </div>
</div>

<div class="row m-b-md white-bg">
    <div class="col-lg-12 text-center">
        <div class="col-xs-2 active-nav">
            <a href="{{ route('horses.show', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-list fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('horse.info', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-info-circle fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('follows.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-users fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('horses.pictures.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-camera fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('pedigree.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-share-alt fa-2x"></i>
            </a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('palmares.index', $horse->slug()) }}" class="text-muted">
                <i class="fa fa-trophy fa-2x"></i>
            </a>
        </div>
    </div>
</div>
