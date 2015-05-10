<ul class="grid-block medium-12 primary menu-bar">
    <li class="medium-3"><a href="{{ route('follows.index', $horse->slug) }}">Followers <span class="badge secondary pull-right">{{ count($horse->followers) }}</span></a></li>
    <li class="medium-3"><a href="{{ route('horse.info', $horse->slug) }}">Info</a></li>
    <li class="medium-3"><a href="#">Pictures</a></li>
    <li class="medium-3"><a href="{{ route('pedigree.index', $horse->slug) }}">Pedigree</a></li>
    <li class="medium-3"><a href="{{ route('palmares.index', $horse->slug) }}">Palmares</a></li>
    <li class="medium-3"><a href="#">Contact the owner</a></li>
</ul>