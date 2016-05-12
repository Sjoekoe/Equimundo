<div class="media-body" v-bind:class="{'text-right' : message.made_by_user}">
    <small v-bind:class="{'pull-left' : message.made_by_user, 'pull-right' : ! message.made_by_user}">
        @{{ message.created_at | diffForHumans }}
    </small>
    <strong>
        <a href="/user/@{{ message.userRelation.data.slug }}">
            @{{ message.userRelation.data.first_name + ' ' + message.userRelation.data.last_name }}
        </a>
    </strong>
    <p class="m-b-xs">
        @{{ message.body }}
    </p>
</div>
