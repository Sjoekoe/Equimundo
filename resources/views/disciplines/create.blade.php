@extends('layout.app', ['title' => trans('copy.titles.disciplines'), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-xs-4 pull-right">
                <div class="form-group text-right pull-right">
                    <a href="{{ route('horse.info', $horse->slug()) }}" class="btn btn-info">{{ trans('copy.a.back_to') }} {{ $horse->name() }}</a>
                </div>
            </div>
        </div>
        {{ Form::open(['route' => ['disciplines.store', $horse->slug()], 'class' => 'form-inline']) }}
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Various
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.various') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Racing
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.racing') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Classic
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.classic') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info {{ $horse->performsDiscipline($discipline) ? 'active' : '' }}">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Western
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.western_sports') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Harness
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.harness') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Team Sports
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.team') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Ancient
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (config('disciplines.ancient') as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox checkbox-info">
                                {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 pull-right">
                    <div class="form-group text-right pull-right">
                        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-info']) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@stop
