
<dd class="pos-right clearfix">
    <div class="circ"></div>
    <div class="time">
        {{ eqm_translated_date($status->createdAt())->diffForHumans() }} <br>
        <div class="pull-right">
            <a href="{{ route('statuses.show', $status->id()) }}">
                <i class="fa fa-search fa-lg"></i>
            </a>
            <i class="fa fa-share-alt fa-lg"></i>
            <i class="fa fa-comments-o fa-lg"></i>
            {{--<p class="muted like-counter pull-right">
                {{ count($status->likes()) }}
            </p>--}}
            {{ Form::open(['route' => ['status.like', $status->id()], 'class' => 'like-button pull-right', 'data-remote']) }}
                {{ Form::hidden('status_id', $status->id()) }}
                <button type="submit" class="btn-naked">
                    <i class="fa {{ in_array($status->id(), $likes) ? 'fa-heart fa-lg' : 'fa-heart-o fa-lg' }}"></i>
                </button>
            {{ Form::close() }}
        </div>
    </div>
    <div class="events">
        <div class="pull-left">
            @if ($status->horse()->getProfilePicture())
                <img class="events-object img-rounded"
                    src="{{ route('file.picture', $status->horse()->getProfilePicture()->id()) }}">
            @else
                <img class="events-object img-rounded"
                     src="{{ asset('images/eqm.png')  }}">
            @endif
        </div>
        <div class="events-body">
            <h4 class="events-heading">
                <a href="{{ route('horses.show', $status->horse()->slug()) }}">{{ $status->horse()->name() }}</a>
                <i class="fa fa-info-circle fa"></i>
                @if ($status->prefix())
                    - {{ trans('statuses.prefixes.' . $status->prefix()) }}
                @endif
            </h4>
            <p>{{ $status->body() }}</p>
            @if ($status->hasPicture())
                <br/>
                <div class="thumbnail">
                    <img class="img-rounded" src="{{ route('file.picture', [$status->getPicture()->id()]) }}" alt=""/>
                </div>
            @endif
        </div>
    </div>
</dd>

{{--<div class="row">
    <div class="col s12">
        <div class="card status">
            <div class="card-header">
                <div class="card-title">
                    <a href="{{ route('horses.show', $status->horse()->slug) }}">
                        {{ $status->horse()->name }}
                    </a>
                    <span class="badge">{{ eqm_translated_date($status->createdAt())->diffForHumans() }}</span>
                </div>
            </div>
            <div class="card-content">
                {{ nl2br($status->body()) }}
                @if ($status->hasPicture())
                    <br/>
                    <img src="{{ route('file.picture', [$status->getPicture()->id()]) }}" alt=""/>
                @endif

                @can('edit-status', $status)
                    <span class="right"><a href="{{ route('statuses.edit', $status->id()) }}">{{ trans('copy.a.edit') }}</a></span>
                @endcan

                @can('delete-status', $status)
                    <span class="right"><a href="{{ route('statuses.delete', $status->id()) }}">{{ trans('copy.a.delete') }}</a></span>
                @endcan
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
</div>--}}
