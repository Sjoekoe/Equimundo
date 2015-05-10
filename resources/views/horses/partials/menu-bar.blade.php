<ul class="grid-block medium-12 primary menu-bar">
    <li><a href="{{ route('follows.index', $horse->slug) }}">Followers <span class="badge secondary pull-right">{{ count($horse->followers) }}</span></a></li>
    <li><a href="{{ route('horse.info', $horse->slug) }}">Info</a></li>
    <li><a href="#">Pictures</a></li>
    <li><a href="{{ route('pedigree.index', $horse->slug) }}">Pedigree</a></li>
    <li><a href="{{ route('palmares.index', $horse->slug) }}">Palmares</a></li>
    <li><a href="#">Contact the owner</a></li>
</ul>