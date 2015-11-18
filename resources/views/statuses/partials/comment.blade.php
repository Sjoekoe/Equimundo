<article class="comments__comment media status-media row">
    <div class="media-body clearfix">
        <h5 class="media-heading pull-left">{{ $comment->poster()->fullName() }}</h5>
        <p>{{ $comment->body() }}</p>

        @can('edit-comment', $comment)
            <a href="{{ route('comment.edit', $comment->id()) }}" class="pull-right">Edit</a>
        @endcan

        @can('delete-comment', $comment)
            <a href="{{ route('comment.delete', $comment->id()) }}" class="pul-right">Delete</a>
        @endcan
    </div>
</article>
