@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12">
            <div class="grid-content">
                <h1>Horses of {{ $user->username }}</h1>
            </div>
        </div>

        <div class="grid-block medium-12">
        @foreach ($user->horses as $horse)
            <div class="grid-content medium-6">
                <div class="card">
                    <img src="https://scontent-ams.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/10553388_10203915881569093_2920146316036226222_n.jpg?oh=6e110c44b513925b9e16c0d59d68b92e&oe=55DD955F" style="width: 100%">
                    <div class="card-divider">
                        <a href="{{ route('horses.show', $horse->slug) }}">
                            <h3>{{ $horse->name }}</h3>
                        </a>
                    </div>
                    <div class="card-section">
                        <h4>Look at This Swag Card</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi iusto reprehenderit voluptatem odio deleniti provident aliquam qui magnam aspernatur necessitatibus.</p>
                    </div>
                </div>
            </div>
        @endforeach
            </div>
    </div>
@stop