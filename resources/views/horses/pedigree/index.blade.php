@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12 clearfix heading">
            <div class="pull-left">
                <h1>{{ $horse->name }}</h1>
            </div>

            <div class="pull-right">
                @if ($horse->owner()->first()->id !== Auth::user()->id)
                    @include('horses.partials.follow-form')
                @else
                    <a href="{{ route('pedigree.create', $horse->slug) }}" class="button">Add Family</a>
                @endif
            </div>
        </div>

        @include('horses.partials.menu-bar')

        <div class="pedigree">
            <div class="pedigree grid-block medium-12">
                <div class="grid-content medium-3 grandparent male">
                    @if ($family = $horse->fathersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        Fathers Father
                    @endif
                </div>
                <div class="grid-content medium-3 grandparent female">
                    @if ($family = $horse->fathersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        Fathers Mother
                    @endif
                </div>
                <div class="grid-content medium-3 grandparent male">
                    @if ($family = $horse->mothersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        Mothers Father
                    @endif
                </div>
                <div class="grid-content medium-3 grandparent female">
                    @if ($family = $horse->mothersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        Mothers Mother
                    @endif
                </div>
            </div>
            <div class="grid-block medium-12">
                <div class="grid-content medium-6 parent male">
                    @if ($family = $horse->father())
                        @include('horses.pedigree._partials._pedigree')
                    @endif
                </div>
                <div class="grid-content medium-6 parent female">
                    @if ($family = $horse->mother())
                        @include('horses.pedigree._partials._pedigree')
                    @endif
                </div>
            </div>
            <div class="grid-block medium-12">
                <div class="grid-content medium-12 self">
                    <a href="{{ route('horses.show', $horse->slug) }}">{{ $horse->name }}</a>
                </div>
            </div>
            <div class="grid-block medium-12">
                <div class="grid-content medium-6 offspring male">
                    Sons
                </div>
                <div class="grid-content medium-6 offspring female">
                    Daughters
                </div>
            </div>
        </div>
    </div>
@stop