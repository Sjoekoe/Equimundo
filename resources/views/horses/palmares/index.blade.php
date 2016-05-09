@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        <div class="col-lg-12">
            @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                <div class="row">
                    <div class="col-sx-3 pull-right">
                        <a href="{{ route('palmares.create', $horse->slug()) }}" class="btn btn-info">{{ trans('copy.a.add_achievement') }}</a>
                    </div>
                </div>
                <br>
            @endif
            @if (! count($horse->palmares()))
                <div class="panel">
                    <div class="panel-body">
                        <p class="text-center">{{ $horse->name() }} {{ trans('copy.p.no_palmares') }}</p>
                    </div>
                </div>
            @else
                <div class="panel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trans('copy.p.event') }}</th>
                                        <th>{{ trans('copy.p.date') }}</th>
                                        <th>{{ trans('copy.p.discipline') }}</th>
                                        <th>{{ trans('copy.p.category') }}</th>
                                        <th>{{ trans('copy.p.ranked') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($palmaresResults as $palmares)
                                        <tr>
                                            <td>
                                                {{ $palmares->event()->name() }}
                                            </td>
                                            <td>
                                                {{ eqm_translated_date($palmares->date())->format('d F Y') }}
                                            </td>
                                            <td>
                                                {{ trans('disciplines.' . $palmares->discipline()) }}
                                            </td>
                                            <td>
                                                {{ $palmares->level() }}
                                            </td>
                                            <td>
                                                {{ $palmares->ranking() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('statuses.show', $palmares->status()->id()) }}" class="text-light">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                                    <a href="{{ route('palmares.delete', $palmares->id()) }}">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
