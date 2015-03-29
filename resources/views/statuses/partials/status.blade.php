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

@if (Auth::check())
    {{ Form::open(['route' => ['comment.store', $status->id], 'class' => 'comments__create-form row']) }}
        {{ Form::hidden('status_id', $status->id) }}

        <!-- Body Form input -->
        <div class="form-group">
            {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 1]) }}
        </div>
    {{ Form::close() }}
@endif

@unless ($status->comments->isEmpty())
    <div class="comments">
        @foreach($status->comments as $comment)
            @include('statuses.partials.comment')
        @endforeach
    </div>
@endif