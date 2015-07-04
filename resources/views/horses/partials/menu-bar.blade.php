<div class="row">
    <div class="col s12 teal lighten-5">
        <ul class="tabs teal lighten-5">
            <li class="tab col s2">
                <a href="{{ route('horses.show', $horse->slug) }}" class="teal-text {{ Active::route('horses.show') }}">
                    {{ trans('copy.a.statuses') }}
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('horse.info', $horse->slug) }}" class="teal-text {{ Active::route('horse.info') }}">
                    {{ trans('copy.a.info') }}
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('follows.index', $horse->slug) }}" class="teal-text {{ Active::route('follows.index') }}">
                    {{ trans('copy.a.followers') }}
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('horses.pictures.index', $horse->slug) }}" class="teal-text {{ Active::route('horses.pictures.index') }}">
                    {{ trans('copy.a.pictures') }}
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('pedigree.index', $horse->slug) }}" class="teal-text {{ Active::route('pedigree.index') }}">
                    {{ trans('copy.a.pedigree') }}
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('palmares.index', $horse->slug) }}" class="teal-text {{ Active::route('palmares.index') }}">
                    {{ trans('copy.a.palmares') }}
                </a>
            </li>
        </ul>
    </div>
</div>
