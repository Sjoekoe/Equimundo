@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                General info
                            </h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>
                                    {{ trans('forms.labels.name') }}
                                </dt>
                                <dd>
                                    {{ $horse->name() }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.breed') }}
                                </dt>
                                <dd>
                                    {{ trans('horses.breeds.' . $horse->breed()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.gender') }}
                                </dt>
                                <dd>
                                    {{ trans('horses.genders.' . $horse->gender()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.date_of_birth') }}
                                </dt>
                                <dd>
                                    {{ eqm_date($horse->dateOfBirth()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.height') }}
                                </dt>
                                <dd>
                                    {{ $horse->height() }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.color') }}
                                </dt>
                                <dd>
                                    {{ trans('horses.colors.' . $horse->color()) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Users
                            </h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                @foreach ($horse->userTeams as $team)
                                    <?php $user = $team->user()->first() ?>
                                    <dt>
                                        {{ trans('horse_teams.type.' . $team->type()) }}
                                    </dt>
                                    <dd>
                                        <a href="{{ route('users.profiles.show', $user->id()) }}" class="text-mint">
                                            {{ $user->fullName() }}
                                        </a>
                                        @if ($user->id() !== auth()->user()->id())
                                            <a href="{{ route('conversation.create', ['contact' => $user->id]) }}" class="btn btn-sm btn-mint btn-icon">
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        @endif
                                    </dd>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.disciplines') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            @foreach($horse->disciplines() as $discipline)
                                <div class="col-sm-3">
                                    {{ trans('disciplines.' . $discipline->discipline()) }}
                                </div>
                            @endforeach
                        </div>
                        @if (auth()->user()->isInHorseTeam($horse))
                            <div class="panel-footer text-right">
                                <a href="{{ route('disciplines.index', $horse->slug()) }}" class="btn btn-info">Add Disciplines</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
