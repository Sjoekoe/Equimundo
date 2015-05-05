<div class="grid-block medium-12">
    <div class="card grid-content medium-12">
        <div class="card-header clearfix">
            <div class="name pull-left">
                <h5>
                    <a href="{{ route('horses.show', $status->horse->slug) }}">
                        {{ $status->horse->name }}
                    </a>
                </h5>
            </div>
            <div class="time pull-right">
                {{ $status->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="card-section">
            {{ nl2br($status->body) }}
        </div>
        <div class="card-divider">
            {{ Form::open(['route' => ['status.like', $status->id], 'class' => 'like-button pull-left', 'data-remote']) }}
                {{ Form::hidden('status_id', $status->id) }}
                <button type="submit" class="btn-naked">
                    <i class="fa {{ in_array($status->id, $likes) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                </button>
            {{ Form::close() }}
            <p class="muted like-counter">
                {{ count($status->likes) }}
            </p>
            @unless ($status->comments->isEmpty())
                <div class="comments">
                    @foreach($status->comments as $comment)
                        @include('statuses.partials.comment')
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if (Auth::check())
        {{ Form::open(['route' => ['comment.store', $status->id], 'class' => 'comments__create-form medium-12']) }}
            {{ Form::hidden('status_id', $status->id) }}
            {{ Form::hidden('username', Auth::user()->username) }}
            <!-- Body Form input -->
            <div class="form-group">
                {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => 'write a comment ...']) }}
            </div>
        {{ Form::close() }}
    @endif
</div>
