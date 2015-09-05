<article class="comments__comment media status-media row">
    <div class="media-body clearfix">
        <h5 class="media-heading pull-left">{{ $comment->poster()->fullName() }}</h5>
        <p>{{ $comment->body() }}</p>
    </div>
</article>
