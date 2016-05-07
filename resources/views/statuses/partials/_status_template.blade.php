<div class="panel" v-if="! loading && ! statuses.length && ! hideNoStatusesText">
    <div class="panel-body">
        <p class="text-center">{{ trans('copy.p.no_statuses') }}</p>
    </div>
</div>

<div class="social-feed-box" v-else v-for="status in statuses">
    <div class="pull-right social-action dropdown">
        <button data-toggle="dropdown" class="dropdown-toggle btn-white" v-if="status.can_delete_status">
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu m-t-xs">
            <li>
                <a href="javascript:void(0)" @click="deleteStatus(status)">
                    {{ trans('copy.a.delete') }}
                </a>
            </li>
        </ul>
    </div>
    <div class="social-avatar">
        <template v-if="status.is_horse_status">
            <a href="/horses/@{{ status.poster.data.slug }}" class="pull-left">
                <img alt="image" v-bind:src="status.poster.data.profile_picture">
            </a>
        </template>
        <template v-else>
            <a href="/companies/@{{ status.poster.data.slug }}" class="pull-left">
                <img alt="image" src="{{ asset('images/eqm.png') }}">
            </a>
        </template>
        <span class="text-muted pull-right" v-if="status.prefix" v-html="status.prefix"></span>
        <div class="media-body">
            <template v-if="status.is_horse_status">
                <a href="/horses/@{{ status.poster.data.slug }}" class="text-info">
                    @{{ status.poster.data.name }}
                </a>
            </template>
            <template v-else>
                <a href="/companies/@{{ status.poster.data.slug }}" class="text-info">
                    @{{ status.poster.data.name }}
                </a>
            </template>
            <small class="text-muted">@{{ status.created_at | diffForHumans }}</small>
        </div>
        <div class="social-body">
            <p v-html="status.body"></p>
            <a v-if="status.picture" v-bind:href="status.picture">
                <img v-bind:src="status.picture" class="img-responsive" style="width: 100%; height: auto;">
            </a>
            <div class="btn-group">
                <button class="btn btn-white btn-xs">
                    <i class="fa fa-heart text-danger"></i> @{{ status.like_count }}
                </button>
                @if (auth()->check())
                    <template v-if="status.liked_by_user">
                        <button class="btn btn-info btn-xs" @click="likeStatus(status)"><i class="fa fa-thumbs-up"></i> {{ trans('copy.a.you_like_it') }}</button>
                    </template>
                    <template v-else>
                        <button class="btn btn-white btn-xs" @click="likeStatus(status)"><i class="fa fa-thumbs-up"></i></button>
                    </template>
                    </div>
                @endif
            </div>
        </div>
        <div class="social-footer">
            <div class="social-comment" v-for="comment in status.comments.data">
                <div class="pull-right social-action dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle btn-link" v-if="comment.can_delete_comment">
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu m-t-xs">
                        <li>
                            <a href="javascript:void(0)" @click="deleteComment(status, comment)">
                            {{ trans('copy.a.delete') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="media-body">
                    <a href="/user/@{{ comment.user.data.slug }}" class="text-info">
                        @{{ comment.user.data.first_name + ' ' + comment.user.data.last_name }}
                    </a>
                    <small class="text-muted">
                        @{{ comment.created_at | diffForHumans }}
                    </small>
                    <p v-html="comment.body"></p>
                    <div class="btn-group">
                        <button class="btn btn-white btn-xs">
                            <i class="fa fa-heart text-danger"></i> @{{ comment.like_count }}
                        </button>
                        @if (auth()->check())
                            <template v-if="comment.liked_by_user">
                                <button class="btn btn-info btn-xs" @click="likeComment(comment)"><i class="fa fa-thumbs-up"></i></button>
                            </template>
                            <template v-else>
                                <button class="btn btn-white btn-xs" @click="likeComment(comment)"><i class="fa fa-thumbs-up"></i></button>
                            </template>
                        @endif
                    </div>
                </div>
            </div>
            @if (auth()->check())
                <div class="social-comment">
                    <div class="media-body">
                        <form method="POST" v-on:submit="postComment($event, status)">
                            <input type="textarea" name="body", class="form-control" rows="1", placeholder="{{ trans('forms.placeholders.write_a_comment') }}" v-model="newComment.comment[status.id]">
                            <br>
                            <div class="mar-ver text-right">
                                <template v-if="commenting">
                                    <button class="btn btn-info btn-xs" disabled><i class="fa fa-spinner fa-spin"></i></button>
                                </template>
                                <template v-else>
                                    <button class="btn btn-info btn-xs">{{ trans('copy.a.place_comment') }}</button>
                                </template>
                            </div>
                        </form>
                    </div>

                </div>
            @endif
        </div>
    </div>
</div>
<div class="panel" v-if="loading">
    <div class="panel-body text-center">
        <i class="fa fa-refresh fa-spin fa-2x text-info"></i>
        <br> <br>
        <p>Loading...</p>
    </div>
</div>
