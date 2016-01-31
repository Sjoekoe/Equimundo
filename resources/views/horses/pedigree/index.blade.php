@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel widget panel-bordered-mint">
                        <div class="widget-header bg-purple">
                            <img class="widget-bg img-responsive" src="{{ asset('/images/header.jpg') }}" alt="Image">
                        </div>
                        <div class="widget-body text-center">
                            @if ($horse->getProfilePicture())
                                <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
                            @else
                                <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ asset('images/eqm.png') }}">
                            @endif
                            <h4 class="mar-btm">{{ $horse->name() }}</h4>
                            <p class="text-muted"><strong>{{ trans('forms.labels.breed') }}</strong> {{ trans('horses.breeds.' . $horse->breed()) }}</p>
                            <p class="text-muted"><strong>{{ trans('copy.p.born') }}</strong> {{ eqm_date($horse->dateOfBirth(), 'Y') }}</p>
                            <p class="text-muted"><strong>{{ trans('copy.p.life_number') }}</strong> {{ $horse->lifeNumber() ? : '-' }}</p>
                            <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                <li class="col-sm-4">
                                    <span class="text-lg">{{ count($horse->statuses()) }}</span>
                                    <p class="text-muted text-uppercase">
                                        <small>{{ trans('copy.a.statuses') }}</small>
                                    </p>
                                </li>
                                <li class="col-sm-4">
                                    @if (! auth()->user()->isInHorseTeam($horse))
                                        @if (Auth::user()->isFollowing($horse))
                                            {{ Form::open(['route' => ['follows.destroy', $horse->id()], 'method' => 'DELETE']) }}
                                            <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') . $horse->name() }}</button>
                                            {{ Form::close() }}
                                        @else
                                            {{ Form::open(['route' => ['follows.store', $horse->id()]]) }}
                                            <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') . $horse->name() }}</button>
                                            {{ Form::close() }}
                                        @endif
                                    @endif
                                </li>
                                <li class="col-sm-4">
                                    <span class="text-lg">{{ count($horse->followers()) }}</span>
                                    <p class="text-muted text-uppercase">
                                        <small>{{ trans('copy.a.followers') }}</small>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-bordered-info">
                        <?php $family = $horse->father() ?>
                        @include('horses.pedigree._partials._pedigree')
                    </div>
                    <div class="panel widget panel-bordered-pink">
                        <?php $family = $horse->mother() ?>
                        @include('horses.pedigree._partials._pedigree')
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-bordered-info">
                        <?php $family = $horse->fathersFather() ?>
                        <div class="panel-body">
                            @if ($family)
                                {{ $family->name() }}
                            @else
                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-bordered-pink">
                        <?php $family = $horse->fathersMother() ?>
                        <div class="panel-body">
                            @if ($family)
                                {{ $family->name() }}
                            @else
                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-bordered-info">
                        <?php $family = $horse->mothersFather() ?>
                        <div class="panel-body">
                            @if ($family)
                                {{ $family->name() }}
                            @else
                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-bordered-pink">
                        <?php $family = $horse->mothersMother() ?>
                        <div class="panel-body">
                            @if ($family)
                                {{ $family->name() }}
                            @else
                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-bordered-info">
                        <div class="panel-header">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.sons') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            @foreach ($horse->sons() as $son)
                                {{ $son->originalHorse->name() }}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-bordered-pink">
                        <div class="panel-header">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.daughters') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            @foreach ($horse->daughters() as $daughter)
                                {{ $daughter->originalHorse->name() }}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--@if (auth()->user()->isInHorseTeam($horse))
        <div class="row">
            <a href="{{ route('pedigree.create', $horse->slug()) }}" class="btn">{{ trans('copy.a.add_family') }}</a>
        </div>
    @endif--}}
    {{--<div class="row pedigree">
        <div class="col s12">
            @if ($horse->hasFather())
                <div class="col s3 grandparent male">
                    @if ($family = $horse->fathersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug, 'type=5']) }}" class="black-text">{{ trans('copy.a.add_father_father') }}</a>
                        @endcan
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->fathersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug, 'type=6']) }}" class="black-text">{{ trans('copy.a.add_father_mother') }}</a>
                        @endcan
                    @endif
                </div>
            @endif

            @if ($horse->hasMother())
                <div class="col s3 grandparent male">
                    @if ($family = $horse->mothersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can ('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type=7']) }}" class="black-text">{{ trans('copy.a.add_mother_father') }}</a>
                        @endcan
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->mothersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type=8']) }}" class="black-text">{{ trans('copy.a.add_mother_mother') }}</a>
                        @endcan
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
                    @can('create-pedigree', $horse)
                        <a href="{{ route('pedigree.create', [$horse->slug(), 'type=1']) }}" class="black-text">{{ trans('copy.a.add_father') }}</a>
                    @endcan
                @endif
            </div>
            <div class="col s6 parent female">
                @if ($family = $horse->mother())
                    @include('horses.pedigree._partials._pedigree')
                @else
                    @can('create-pedigree', $horse)
                        <a href="{{ route('pedigree.create', [$horse->slug(), 'type=2']) }}" class="black-text">{{ trans('copy.a.add_mother') }}</a>
                    @endcan
                @endif
            </div>
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s12 self">
                <a href="{{ route('horses.show', $horse->slug()) }}">
                    <h4>{{ $horse->name() }}</h4>
                </a>
                <p>{{ trans('copy.p.born') . ' ' . eqm_date($horse->dateOfBirth(), 'Y') }}</p>
                <p>{{ trans('copy.p.life_number') . ' ' . $horse->lifeNumber() ? : '-' }}</p>
            </div>
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s6 offspring male">
                {{ trans('copy.titles.sons') }}
                <hr/>
                @foreach ($horse->sons() as $son)
                    {{ $son->originalHorse->name() }}
                @endforeach
            </div>
            <div class="col s6 offspring female">
                {{ trans('copy.titles.daughters') }}
                <hr/>
                @foreach ($horse->daughters() as $daughter)
                    {{ $daughter->originalHorse->name() }}
                @endforeach
            </div>
        </div>
    </div>--}}
@stop
