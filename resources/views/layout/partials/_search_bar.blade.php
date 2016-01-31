<div id="search-bar" class="row pad-ver mar-btm bg-trans-dark" style="display: none">
    {{ Form::open(['route' => 'search', 'class' => 'col-xs-12 col-sm-10 col-sm-offset-1 pad-hor']) }}
        {{ Form::text('search', null, ['placeholder' => trans('forms.placeholders.search') . '...', 'class' => 'form-control input-lg']) }}
    {{ Form::close() }}
</div>
