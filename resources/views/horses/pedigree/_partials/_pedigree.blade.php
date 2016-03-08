<div class="panel-heading">
    <div class="panel-control">
        <button class="btn btn-default collapsed" data-target="#{{ $family->id() }}" data-toggle="collapse" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
    </div>
    <h3 class="panel-title">{{ $family->name() }}</h3>
</div>
<div class="collapse" id="{{ $family->id() }}" aria-expanded="false" style="height: 0px;">
    <div class="panel-body text-center">
    <p class="text-muted"><strong>{{ trans('forms.labels.breed') }}</strong> {{ trans('horses.breeds.' . $family->breed()) }}</p>
    <p class="text-muted"><strong>{{ trans('copy.p.born') }}</strong> {{ eqm_date($family->dateOfBirth(), 'Y') }}</p>
    <p class="text-muted"><strong>{{ trans('copy.p.life_number') }}</strong> {{ $family->lifeNumber() ? : '-' }}</p>
    <ul class="list-unstyled text-center pad-top mar-no clearfix">
        <li class="col-sm-4">
            <span class="text-lg">{{ count($family->statuses()) }}</span>
            <p class="text-muted text-uppercase">
                <small>{{ trans('copy.a.statuses') }}</small>
            </p>
        </li>
        <li class="col-sm-4">
            <a href="{{ route('pedigree.index', $family->slug()) }}" class="btn btn-mint">
                <i class="fa fa-eye"></i>
            </a>
        </li>
        <li class="col-sm-4">
            <span class="text-lg">{{ count($family->followers()) }}</span>
            <p class="text-muted text-uppercase">
                <small>{{ trans('copy.a.followers') }}</small>
            </p>
        </li>
    </ul>
</div>
</div>
