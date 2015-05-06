<div class="palmares grid-block medium-12">
    <div class="grid-content left-side medium-5">
        <p>Event: {{ $palmares->event->name }}</p>
        <p>Date: {{ date('d F Y', strtotime($palmares->date)) }}</p>
    </div>
    <div class="grid-content center-side medium-5">
        <p>Discipline: {{ array_flatten(trans('disciplines.list'))[$palmares->discipline - 1] }}</p>
        <p>Category: {{ $palmares->level }}</p>
    </div>
    <div class="grid-content right-side medium-2">
        <h3 class="subheader">{{ $palmares->ranking }} Place</h3>
        <p><a href="#">Show Story</a></p>
    </div>
</div>