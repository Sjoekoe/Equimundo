@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        <div class="row pedigree">
            <div class="col s12">
                <div class="col s3 grandparent male">
                    @if ($family = $horse->fathersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=3']) }}" class="black-text">Add Fathers Father</a>
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->fathersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=4']) }}" class="black-text">Add Fathers Mother</a>
                    @endif
                </div>
                <div class="col s3 grandparent male">
                    @if ($family = $horse->mothersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=5']) }}" class="black-text">Add Mothers Father</a>
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->mothersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=6']) }}" class="black-text">Add Mothers Mother</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row pedigree">
            <div class="col s12">
                <div class="col s6 parent male">
                    @if ($family = $horse->father())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=1']) }}" class="black-text">Add Father</a>
                    @endif
                </div>
                <div class="col s6 parent female">
                    @if ($family = $horse->mother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=2']) }}" class="black-text">Add Mother</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row pedigree">
            <div class="col s12">
                <div class="col s12 self">
                    <a href="{{ route('horses.show', $horse->slug) }}">
                        <h4>{{ $horse->name }}</h4>
                    </a>
                    <p>Born: {{ date('Y', strtotime($horse->date_of_birth)) }}</p>
                    <p>Passed Away: {{ $horse->date_of_death ? date('Y', strtotime($family->date_of_death)) : '-' }}</p>
                    <p>Life number: {{ $horse->family_life_number ? : '-' }}</p>
                </div>
            </div>
        </div>
        <div class="row pedigree">
            <div class="col s12">
                <div class="col s6 offspring male">
                    Sons
                </div>
                <div class="col s6 offspring female">
                    Daughters
                </div>
            </div>
        </div>
    </div>
@stop