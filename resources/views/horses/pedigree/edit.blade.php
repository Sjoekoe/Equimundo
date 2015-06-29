@extends('layout.app')

@section('content')
    <div class="row no-bottom-margin">
        <div class="col s12 heading" style="background-image: url(https://scontent-ams.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/10553388_10203915881569093_2920146316036226222_n.jpg?oh=6e110c44b513925b9e16c0d59d68b92e&oe=55DD955F)">
            <div class="heading-name left">
                <h1 class="teal-text">{{ $horse->name }}</h1>
            </div>

            <div class="heading-button right">
                @if (Auth::user()->isHorseOwner($horse))
                    <a href="{{ route('pedigree.create', $horse->slug) }}" class="btn">Add Family</a>
                @else
                    @include('horses.partials.follow-form')
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        @include('horses.partials.menu-bar')
    </div>
    <div class="row">
        {{ Form::open(['route' => ['pedigree.update', $pedigree->id], 'method' => 'PUT']) }}
        <div class="row">
            <div class="col s6 input-field">
                {{ Form::select('type', trans('pedigree.types'), $pedigree->type, ['class' => 'type-select']) }}
                {{ Form::label('type', 'Relation') }}
            </div>
            <div class="col s6 input-field">
                {{ Form::text('name', $pedigree->family_name) }}
                {{ Form::label('name', 'Name') }}
            </div>
        </div>
        <div class="row">
            <div class="col s6 input-field">
                {{ Form::select('color', trans('horses.colors'), $pedigree->color, ['class' => 'color-select']) }}
                {{ Form::label('color') }}
            </div>
            <div class="col s6 input-field">
                {{ Form::select('breed', trans('horses.breeds'), $pedigree->breed, ['class' => 'breed-select']) }}
                {{ Form::label('breed') }}
            </div>
        </div>
        <div class="row">
            <div class="col s6 input-field">
                {{ Form::label('height') }}
                {{ Form::text('height', $pedigree->height) }}
            </div>
            <div class="col s6 input-field">
                {{ Form::label('life_number', 'Life Number') }}
                {{ Form::text('life_number', $pedigree->family_life_number) }}
            </div>
        </div>
        <div class="row">
            <div class="col s6 input-field">
                {{ Form::label('date_of_birth', 'Date of Birth') }}
                {{ Form::text('date_of_birth',
                $pedigree->date_of_birth ? date('Y', strtotime($pedigree->date_of_birth)) : null, ['placeholder' => 'yyyy']) }}
            </div>
            <div class="col s6 input-field">
                {{ Form::label('date_of_death', 'Passed away:') }}
                {{ Form::text('date_of_death',
                $pedigree->date_of_death ? date('Y', strtotime($pedigree->date_of_death)) : null, ['placeholder' => 'yyyy']) }}
            </div>
        </div>
        <div class="row">
            {{ Form::submit('Save', ['class' => 'btn']) }}
        </div>
        {{ Form::close() }}
    </div>
@stop

@section('footer')
    <script>
        $(document).ready(function() {
            $('.type-select').material_select();
            $('.breed-select').material_select();
            $('.color-select').material_select();
        });
    </script>
@stop
