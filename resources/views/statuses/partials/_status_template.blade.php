<div class="panel" v-for="status in statuses">
    <div class="panel-body">
        <div class="media-block">
            <a href="/horses/@{{ status.horse.data.slug }}" class="media-left">
                <img v-bind:src="status.horse.data.profile_picture" alt="" class="img-circle img-sm">
            </a>
            <div class="media-body">
                <div class="mar-btm">
                    <div class="pull-right">
                        <div class="btn-group">
                            <i class="dropdown-toggle-icon fa fa-chevron-down" data-toggle="dropdown" aria-expanded="false" v-if="status.can_delete_status"></i>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="javascript:void(0)" @click="deleteStatus(status)">
                                    {{ trans('copy.a.delete') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="/horses/@{{ status.horse.data.slug }}" class="btn-link text-semibold media-heading box-inline text-mint">
                        @{{ status.horse.data.name }}
                    </a>
                    <span class="text-semibold text-muted" v-if="status.prefix"> - @{{ status.prefix }}</span>
                    <p class="text-muted text-sm">
                        @{{ status.formatted_date }}
                    </p>
                </div>
                <p v-html="status.body"></p>
                <a v-if="status.picture" v-bind:href="status.picture" data-lightbox="@{{ status.id }}">
                    <img v-bind:src="status.picture" alt="" class="img-responsive thumbnail">
                </a>
                <div class="pad-ver">
                                    <span class="tag tag-sm">
                                        <i class="fa fa-heart text-danger"></i> @{{ status.like_count }}
                                    </span>

                    @if (auth()->check())
                        <div class="btn-group">
                            <template v-if="status.liked_by_user">
                                <button class="btn btn-sm btn-default btn-hover-success active" type="submit" @click="likeStatus(status)"><i class="fa fa-thumbs-up"></i> You Like it</button>
                            </template>
                            <template v-else>
                                <button class="btn btn-sm btn-default btn-hover-success" type="submit" @click="likeStatus(status)"><i class="fa fa-thumbs-up"></i></button>
                            </template>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="media-block pad-all bg-gray-light" v-for="comment in status.comments.data">
                    <div class="media-body">
                        <div class="mar-btm">
                            <a href="/user/@{{ comment.user.data.slug }}" class="btn-link text-mint text-semibold media-heading box-inline">
                                @{{ comment.user.data.first_name + ' ' + comment.user.data.last_name }}
                            </a>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <i class="dropdown-toggle-icon fa fa-chevron-down" data-toggle="dropdown" aria-expanded="false" v-if="comment.can_delete_comment"></i>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a href="javascript:void(0)" @click="deleteComment(status, comment)">
                                            {{ trans('copy.a.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted text-sm">
                                @{{ comment.formatted_date }}
                            </p>
                        </div>
                        <p v-html="comment.body"></p>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="media-footer">
                @if (auth()->check())
                    <div class="media-block pad-ver">
                        <form method="POST" v-on:submit="postComment($event, status)">
                            <div class="row">
                                <div class="col-sm-12 col-md-11 col-md-offset-1">
                                    <input type="textarea" name="body", class="form-control" rows="1", placeholder="{{ trans('forms.placeholders.write_a_comment') }}" v-model="newComment.comment[status.id]">
                                    <small class="help-block text-danger text-left">@{{ errors[status.id].body[0] }}</small>
                                </div>
                            </div>
                            <div class="mar-ver text-right">
                                <template v-if="commenting">
                                    <button class="btn btn-info" disabled><i class="fa fa-spinner fa-spin"></i></button>
                                </template>
                                <template v-else>
                                    <button class="btn btn-info">Comment</button>
                                </template>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="panel" v-if="loading">
    <div class="panel-body text-center">
        <i class="fa fa-refresh fa-spin fa-2x text-mint"></i>
        <br> <br>
        <p>Loading...</p>
    </div>
</div>
