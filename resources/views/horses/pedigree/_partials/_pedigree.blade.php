<div class="ibox collapsed">
    <div class="ibox-title">
        <h5>
            {{ $family->name() }}
        </h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
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
                <a href="{{ route('pedigree.index', $family->slug()) }}" class="btn btn-info">
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
