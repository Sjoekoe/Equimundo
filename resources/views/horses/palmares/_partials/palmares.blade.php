<div class="panel panel-mint panel-colorful text-center">
    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <i class="fa fa-map-marker fa-3x"></i>
            </div>
            <div class="media-body">
                <h4 class="mar-no text-left">{{ $palmares->event()->name() }}</h4>
                <p class="text-left">{{ eqm_translated_date($palmares->date())->format('d F Y') }}</p>
            </div>
            <div class="media-body">
                <p class="text-right">
                    <a href="{{ route('statuses.show', $palmares->status()->id()) }}" class="text-light">{{ trans('copy.a.show_story') }}</a>
                </p>
            </div>
            <hr>
            <div class="row-pad-top">
                <div class="col-xs-4">
                    <p>
                        {{ trans('copy.p.discipline') }}
                    </p>
                    <p class="text-3x">
                        {{ trans('disciplines.' . $palmares->discipline()) }}
                    </p>
                </div>
                <div class="col-xs-4">
                    <p>
                        {{ trans('copy.p.ranked') }}
                    </p>
                    <p class="text-3x">
                        {{ $palmares->ranking() }}
                    </p>
                </div>
                <div class="col-xs-4">
                    <p>
                        {{ trans('copy.p.category') }}
                    </p>
                    <p class="text-3x">
                        {{ $palmares->level() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
