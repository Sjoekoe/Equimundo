@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col s12">
            <h1>{{ trans('copy.titles.horses_of') }} {{ $user->fullName() }}</h1>
        </div>
    </div>

    <div class="row">
        @foreach ($user->horses as $horse)
            <div class="col s6 horse-overview">
                <div class="card">
                    @if ($horse->getProfilePicture())
                        <div class="card-image" style="background-image: url({{ route('file.picture', [$horse->id, $horse->getProfilePicture()->path]) }})">
                    @else
                        <div class="card-image" style="background-image: url(https://scontent-ams.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/10553388_10203915881569093_2920146316036226222_n.jpg?oh=6e110c44b513925b9e16c0d59d68b92e&oe=55DD955F)">
                    @endif
                    </div>
                    <div class="card-action teal lighten-5">
                        <a href="{{ route('horses.show', $horse->slug) }}" class="teal-text">
                            <h5>{{ $horse->name }}</h5>
                        </a>
                    </div>
                    <div class="card-content">
                        <h4>Look at This Swag Card</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi iusto reprehenderit voluptatem odio deleniti provident aliquam qui magnam aspernatur necessitatibus.</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
