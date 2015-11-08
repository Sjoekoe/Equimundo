@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    @if (auth()->user()->isInHorseTeam($horse))
        <div class="row">
            <a href="{{ route('pedigree.create', $horse->slug()) }}" class="btn">{{ trans('copy.a.add_family') }}</a>
        </div>
    @endif
    <div class="row pedigree">
        <div class="col s12">
            @if ($horse->hasFather())
                <div class="col s3 grandparent male">
                    @if ($family = $horse->fathersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=5']) }}" class="black-text">{{ trans('copy.a.add_father_father') }}</a>
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->fathersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=6']) }}" class="black-text">{{ trans('copy.a.add_father_mother') }}</a>
                    @endif
                </div>
            @endif

            @if ($horse->hasMother())
                <div class="col s3 grandparent male">
                    @if ($family = $horse->mothersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=7']) }}" class="black-text">{{ trans('copy.a.add_mother_father') }}</a>
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->mothersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        <a href="{{ route('pedigree.create', [$horse->slug, 'type=8']) }}" class="black-text">{{ trans('copy.a.add_mother_mother') }}</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s6 parent male">
                @if ($family = $horse->father())
                    @include('horses.pedigree._partials._pedigree')
                @else
                    <a href="{{ route('pedigree.create', [$horse->slug, 'type=1']) }}" class="black-text">{{ trans('copy.a.add_father') }}</a>
                @endif
            </div>
            <div class="col s6 parent female">
                @if ($family = $horse->mother())
                    @include('horses.pedigree._partials._pedigree')
                @else
                    <a href="{{ route('pedigree.create', [$horse->slug, 'type=2']) }}" class="black-text">{{ trans('copy.a.add_mother') }}</a>
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
                <p>{{ trans('copy.p.born') . ' ' . date('Y', strtotime($horse->date_of_birth)) }}</p>
                <p>{{ trans('copy.p.life_number') . ' ' . $horse->life_number ? : '-' }}</p>
            </div>
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s6 offspring male">
                {{ trans('copy.titles.sons') }}
                <hr/>
                @foreach ($horse->sons() as $son)
                    {{ $son->originalHorse->name }}
                @endforeach
            </div>
            <div class="col s6 offspring female">
                {{ trans('copy.titles.daughters') }}
                <hr/>
                @foreach ($horse->daughters() as $daughter)
                    {{ $daughter->originalHorse->name }}
                @endforeach
            </div>
        </div>
    </div>
@stop
