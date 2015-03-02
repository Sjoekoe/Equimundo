<div class="row status-media">
    <div class="col-md-3 status-left">
        <h4 class="media-heading">
            {{ $status->horse->name }}
        </h4>
        {{ $status->created_at->diffForHumans() }}
    </div>
    <div class="col-md-8 status-body">
        {{ $status->body }}
    </div>
    <div class="col-md-1 status-right">
        <div class="text-center">
            <i class="fa fa-heart-o"></i>
        </div>
    </div>
</div>