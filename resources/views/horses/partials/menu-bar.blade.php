<div class="row">
    <div class="col s12 teal lighten-5">
        <ul class="tabs teal lighten-5">
            <li class="tab col s2">
                <a href="{{ route('horses.show', $horse->slug) }}" class="teal-text {{ Active::route('horses.show') }}">
                    Statuses
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('horse.info', $horse->slug) }}" class="teal-text {{ Active::route('horse.info') }}">
                    Info
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('follows.index', $horse->slug) }}" class="teal-text {{ Active::route('follows.index') }}">
                    Followers
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('horses.pictures.index', $horse->slug) }}" class="teal-text {{ Active::route('horses.pictures.index') }}">
                    Pictures
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('pedigree.index', $horse->slug) }}" class="teal-text {{ Active::route('pedigree.index') }}">
                    Pedigree
                </a>
            </li>
            <li class="tab col s2">
                <a href="{{ route('palmares.index', $horse->slug) }}" class="teal-text {{ Active::route('palmares.index') }}">
                    Palmares
                </a>
            </li>
        </ul>
    </div>
</div>