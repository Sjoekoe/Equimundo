<div class="col-sm-12 col-md-4">
    <div class="panel panel-bordered-dark">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ $album->name() }}
            </h3>
        </div>
        <div class="panel-body">
            <div class="media-block">
                <a href="{{ route('album.show', $album->id()) }}" class="text-center">
                    @if (count($album->pictures()))
                        <img src="{{ route('file.picture', [$album->pictures()->first()->id()]) }}" alt="" class="img-responsive thumbnail" style="height: 240px">
                    @else
                        <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="img-responsive thumbnail">
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>
