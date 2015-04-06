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
            {{ Form::open(['route' => ['status.like', $status->id], 'class' => 'like-button', 'data-remote']) }}
                {{ Form::hidden('status_id', $status->id) }}
                <button type="submit" class="btn-naked">
                    <i class="fa {{ in_array($status->id, $likes) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                </button>
            {{ Form::close() }}
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