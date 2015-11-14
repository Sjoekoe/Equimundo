<div class="row">
    <div class="col s12">
        <div class="card status">
            <div class="card-header">
                <div class="card-title">
                    <a href="{{ route('horses.show', $status->horse()->slug) }}">
                        {{ $status->horse()->name }}
                    </a>
                    <span class="badge">{{ $status->createdAt()->diffForHumans() }}</span>
                </div>
            </div>
            <div class="card-content">
                {{ nl2br($status->body()) }}
                @if ($status->hasPicture())
                    <br/>
                    <img src="{{ route('file.picture', [$status->getPicture()->id()]) }}" alt=""/>
                @endif
                <span class="right"><a href="{{ route('statuses.edit', $status->id()) }}">{{ trans('copy.a.edit') }}</a></span>
                <span class="right"><a href="{{ route('statuses.delete', $status->id()) }}">{{ trans('copy.a.delete') }}</a></span>
            </div>
            <div class="card-divider">
                {{ Form::open(['route' => ['status.like', $status->id()], 'class' => 'like-button pull-left', 'data-remote']) }}
                    {{ Form::hidden('status_id', $status->id()) }}
                    <button type="submit" class="btn-naked">
                        <i class="fa {{ in_array($status->id(), $likes) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                    </button>
                {{ Form::close() }}
                <p class="muted like-counter">
                    {{ count($status->likes()) }}
                </p>
                @unless ($status->comments()->isEmpty())
                    <div class="comments">
                        @foreach($status->comments() as $comment)
                            @include('statuses.partials.comment')
                        @endforeach
                    </div>
                @endif
            </div>
            @if (Auth::check())
                <div class="row comment">
                    {{ Form::open(['route' => ['comment.store', $status->id()], 'class' => 'comments__create-form col s12']) }}
                        <div class="row">
                            <div class="input-field col s12">
                                {{ Form::textarea('body', null, ['class' => 'materialize-textarea', 'rows' => 1, 'placeholder' => trans('forms.placeholders.write_a_comment')]) }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            @endif
        </div>
    </div>
</div>
