<div class="row mar-btm">
    <div class="col-md-12">
        <ul class="nav nav-pills nav-justified bord-all bg-primary">
            <li class="{{ Active::route('horses.show') }}">
                <a href="{{ route('horses.show', $horse->slug()) }}">
                    {{ trans('copy.a.statuses') }}
                </a>
            </li>
            <li class="{{ Active::route('horse.info') }}">
                <a href="{{ route('horse.info', $horse->slug()) }}">
                    {{ trans('copy.a.info') }}
                </a>
            </li>
            <li class="{{ Active::route('follows.index') }}">
                <a href="{{ route('follows.index', $horse->slug()) }}">
                    {{ trans('copy.a.followers') . ' ' }} <span class="badge badge-info">{{ count($horse->followers()) }}</span>
                </a>
            </li>
            <li class="{{ Active::route('horses.pictures.index') }}">
                <a href="{{ route('horses.pictures.index', $horse->slug()) }}">
                    {{ trans('copy.a.pictures') }}
                </a>
            </li>
            <li class="{{ Active::route('pedigree.index') }}">
                <a href="{{ route('pedigree.index', $horse->slug()) }}">
                    {{ trans('copy.a.pedigree') }}
                </a>
            </li>
            <li class="{{ Active::route('palmares.index') }}">
                <a href="{{ route('palmares.index', $horse->slug()) }}">
                    {{ trans('copy.a.palmares') }}
                </a>
            </li>
        </ul>
    </div>
</div>
