@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
            <div class="row">
                <div class="table-responsive">
                    <table class="text-center pedigree col-lg-12">
                        <tbody>
                        <tr>
                            <td>
                                <div class="panel panel-bordered-mint mar-rgt">
                                    <div class="panel-heading">
                                        <div class="panel-control">
                                            <button class="btn btn-default collapsed" data-target="#{{ $horse->id() }}" data-toggle="collapse" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                        </div>
                                        <h3 class="panel-title">{{ $horse->name() }}</h3>
                                    </div>
                                    <div class="collapse" id="{{ $horse->id() }}" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body text-center">
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
                                                    @if (auth()->check() && ! auth()->user()->isInHorseTeam($horse))
                                                        @if (Auth::user()->isFollowing($horse))
                                                            {{ Form::open(['route' => ['follows.destroy', $horse->id()], 'method' => 'DELETE']) }}
                                                            <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') }}</button>
                                                            {{ Form::close() }}
                                                        @else
                                                            {{ Form::open(['route' => ['follows.store', $horse->id()]]) }}
                                                            <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') }}</button>
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
                            </td>
                            <td>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="panel panel-bordered-info mar-hor">
                                                @if ($horse->father())
                                                    @include('horses.pedigree._partials._pedigree', ['family' => $horse->father()])
                                                @else
                                                    <div class="panel-body">
                                                        @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type' => \EQM\Models\Pedigrees\Pedigree::FATHER]) }}" class="btn btn-mint">{{ trans('copy.a.add_father') }}</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <div class="panel panel-bordered-info mar-hor">
                                                        @if ($horse->father() && $horse->fathersFather())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->fathersFather()])
                                                        @else
                                                            <div class="panel-body">
                                                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                                    <a href="{{ route('pedigree.create', [$horse->slug(), 'type=5']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_father') }}</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="panel panel-bordered-pink mar-hor">
                                                        @if ($horse->father() && $horse->fathersMother())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->fathersMother()])
                                                        @else
                                                            <div class="panel-body">
                                                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                                    <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="panel panel-bordered-pink mar-hor">
                                                @if ($horse->mother())
                                                    @include('horses.pedigree._partials._pedigree', ['family' => $horse->mother()])
                                                @else
                                                    <div class="panel-body">
                                                        @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type' => \EQM\Models\Pedigrees\Pedigree::MOTHER]) }}" class="btn btn-mint">{{ trans('copy.a.add_mother') }}</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <div class="panel panel-bordered-info mar-hor">
                                                        @if ($horse->mother() && $horse->mothersFather())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->mothersFather()])
                                                        @else
                                                            <div class="panel-body">
                                                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                                    <a href="{{ route('pedigree.create', [$horse->slug(), 'type=7']) }}" class="btn btn-mint">{{ trans('copy.a.add_mother_father') }}</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="panel panel-bordered-pink mar-hor">
                                                        @if ($horse->mother() && $horse->mothersMother())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->mothersMother()])
                                                        @else
                                                            <div class="panel-body">
                                                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                                    <a href="{{ route('pedigree.create', [$horse->slug(), 'type=8']) }}" class="btn btn-mint">{{ trans('copy.a.add_mother_mother') }}</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-bordered-info">
                            <div class="panel-heading">
                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                    <div class="panel-control">
                                        <div class="btn-group">
                                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type' => \EQM\Models\Pedigrees\Pedigree::SON]) }}" class="btn btn-mint">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <h3 class="panel-title">
                                    {{ trans('copy.titles.sons') }}
                                </h3>
                            </div>
                            <div class="panel-body">
                                @foreach ($horse->sons() as $son)
                                    <a href="{{ route('pedigree.index', $son->originalHorse->slug()) }}">
                                        {{ $son->originalHorse->name() }} <br>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-bordered-pink">
                            <div class="panel-heading">
                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                    <div class="panel-control">
                                        <div class="btn-group">
                                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type' => \EQM\Models\Pedigrees\Pedigree::DAUGHTER]) }}" class="btn btn-mint">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <h3 class="panel-title">
                                    {{ trans('copy.titles.daughters') }}
                                </h3>
                            </div>
                            <div class="panel-body">
                                @foreach ($horse->daughters() as $daughter)
                                    <a href="{{ route('pedigree.index', $daughter->originalHorse->slug()) }}">
                                        {{ $daughter->originalHorse->name() }} <br>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
