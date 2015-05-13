<div class="row">
    <div class="col s12 teal lighten-5">
        <ul class="tabs teal lighten-5">
            <li class="tab col s2"><a href="{{ route('horse.info', $horse->slug) }}" class="teal-text">Info</a></li>
            <li class="tab col s2"><a href="{{ route('horses.show', $horse->slug) }}" class="teal-text">Statuses</a></li>
            <li class="tab col s2"><a href="{{ route('follows.index', $horse->slug) }}" class="teal-text">Followers</a></li>
            <li class="tab col s2"><a href="{{ route('horses.pictures.index', $horse->slug) }}" class="teal-text">Pictures</a></li>
            <li class="tab col s2"><a href="{{ route('pedigree.index', $horse->slug) }}" class="teal-text">Pedigree</a></li>
            <li class="tab col s2"><a href="{{ route('palmares.index', $horse->slug) }}" class="teal-text">Palmares</a></li>
        </ul>
    </div>
</div>